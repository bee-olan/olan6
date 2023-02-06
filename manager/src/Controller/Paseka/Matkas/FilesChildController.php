<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Matkas;

//use App\Model\Work\Entity\PlemMatkas\PlemMatka\PlemMatka;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Files;

use App\Model\Paseka\UseCase\Matkas\ChildMatka\Executor;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Move;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Plan;


use App\Controller\ErrorHandler;
use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatka;

use App\Security\Voter\Proekt\Matkas\ChildMatkaAccess;
use App\Service\Uploader\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("paseka/matkas/childmatkas", name="paseka.matkas.childmatkas")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class FilesChildController extends AbstractController
{
    private const PER_PAGE = 50;

    private $errors;

    public function __construct( ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("/{id}/files", name=".files")
     * @param ChildMatka $childmatka
     * @param Request $request
     * @param Files\Add\Handler $handler
     * @param FileUploader $uploader
     * @return Response
     */
    public function files( Request $request, Files\Add\Handler $handler, ChildMatka $childmatka, FileUploader $uploader): Response
    {
//        $this->denyAccessUnlessGranted(ChildMatkaAccess::MANAGE, $childmatka);

        $command = new Files\Add\Command($this->getUser()->getId(), $childmatka->getId()->getValue());

        $form = $this->createForm(Files\Add\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $files = [];
            foreach ($form->get('files')->getData() as $file) {
                $uploaded = $uploader->upload($file);
                $files[] = new Files\Add\File(
                    $uploaded->getPath(),
                    $uploaded->getName(),
                    $uploaded->getSize()
                );

            }
            $command->files = $files;

            try {
                $handler->handle($command);
                return $this->redirectToRoute('/paseka/matkas/childmatkas/show', ['id' => $childmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/matkas/childmatkas/files.html.twig', [
            'plemmatka' => $childmatka->getPlemMatka(),
            'childmatka' => $childmatka,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/files/{file_id}/delete", name=".files.delete", methods={"POST"})
     * @ParamConverter("uchastie", options={"id" = "uchastie_id"})
     * @param ChildMatka $childmatka
     * @param string $file_id
     * @param Request $request
     * @param Files\Remove\Handler $handler
     * @return Response
     */
    public function fileDelete(ChildMatka $childmatka, string $file_id, Request $request, Files\Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('revoke', $request->request->get('token'))) {
            return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
        }

        $this->denyAccessUnlessGranted(ChildMatkaAccess::MANAGE, $childmatka);

        $command = new Files\Remove\Command($this->getUser()->getId(), $childmatka->getId()->getValue(), $file_id);

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
    }



}


