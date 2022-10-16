<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Rasas\Rasa\Linias;

use App\Annotation\Guid;
use App\Model\Paseka\Entity\Rasas\Linias\Id;
use App\Model\Paseka\Entity\Rasas\Rasa;
use App\Model\Paseka\UseCase\Rasas\Linias\Create;
use App\Model\Paseka\UseCase\Rasas\Linias\Edit;
use App\Model\Paseka\UseCase\Rasas\Linias\Remove;
use App\ReadModel\Paseka\Rasas\Linias\LiniaFetcher;
//use App\Security\Voter\Paseka\Rasas\MateriAccess;
use App\Controller\ErrorHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paseka/rasas/{id}/linias", name="paseka.rasas.linias")
 */
class LiniaController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param Rasa $rasa
     * @param Request $request
     * @param LiniaFetcher $linias
     * @return Response
     */
    public function index( Rasa $rasa, Request $request,  LiniaFetcher $linias): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);
//dd($linias->allOfRasa($rasa->getId()->getValue()));
        //dd($rasa);
        return $this->render('app/paseka/rasas/linias/index.html.twig', [
            'rasa' => $rasa,
            'linias' => $linias->allOfRasa($rasa->getId()->getValue()),
        ]);
    }

    /**
     * @Route("/create", name=".create")
     * @param Rasa $rasa
	 * @param LiniaFetcher $linias
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(Rasa $rasa, LiniaFetcher $linias, Request $request, Create\Handler $handler): Response
   {
       $maxSort = $linias->getMaxSortLinia($rasa->getId()->getValue()) + 1;

       $command = Create\Command::fromRasa($rasa, $maxSort);// заполнение  значениями из Rasa
//        $command = new Create\Command($rasa->getId()->getValue());
//        $command->title = $rasa->getName();
//		$command->sortLinia = $linias->getMaxSortLinia($rasa->getId()->getValue()) + 1;
        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);
//dd($command);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.rasas.linias', ['id' => $rasa->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }
        return $this->render('app/paseka/rasas/linias/create.html.twig', [
            'rasa' => $rasa,
            'form' => $form->createView(),
            'name' => $command->title,
        ]);
   }

    /**
     * @Route("/{linia_id}/edit", name=".edit")
     * @param Rasa $rasa
     * @param string $linia_id
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Rasa $rasa, string $linia_id, Request $request, Edit\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);

        $linia = $rasa->getLinia(new Id($linia_id));

        $command = Edit\Command::fromLinia($rasa, $linia);

//$command->title = $rasas->getName();
//$command->title = $command->title."_".$command->name;
//dd($command);
        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $command->title = $rasa->getName();
                $command->title = $command->title."_".$command->name;
                // dd($command->title);
                $handler->handle($command);
                return $this->redirectToRoute('paseka.rasas.linias.show',
									['id' => $rasa->getId(), 'linia_id' => $linia_id]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/rasas/linias/edit.html.twig', [
            'rasa' => $rasa,
            'linia' => $linia,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{linia_id}/delete", name=".delete", methods={"POST"})
     * @param Rasa $rasa
     * @param string $linia_id
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Rasa $rasa, string $linia_id, Request $request, Remove\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);

        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('paseka.rasas.linias', ['id' => $rasa->getId()]);
        }

        $linia = $rasa->getLinia(new Id($linia_id));

        $command = new Remove\Command($rasa->getId()->getValue(), $linia->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('paseka.rasas.linias',
					['id' => $rasa->getId()]);
    }

    /**
     * @Route("/{linia_id}", name=".show", requirements={"linia_id"=Guid::PATTERN}))
     * @param Rasa $rasa
     * @return Response
     */
    public function show(Rasa $rasa): Response
    {
        return $this->redirectToRoute('paseka.rasas.linias',
				['id' => $rasa->getId()]);
    }
}
