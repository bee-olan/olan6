<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Matkas;

use App\Model\Paseka\Entity\Matkas\Kategoria\Permission;
use App\Model\Paseka\Entity\Matkas\Kategoria\Kategoria;
use App\Model\Paseka\UseCase\Matkas\Kategoria\Copy;
use App\Model\Paseka\UseCase\Matkas\Kategoria\Create;
use App\Model\Paseka\UseCase\Matkas\Kategoria\Edit;
use App\Model\Paseka\UseCase\Matkas\Kategoria\Remove;
use App\ReadModel\Paseka\Matkas\KategoriaFetcher;
use App\Controller\ErrorHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// * @IsGranted("ROLE_WORK_MANAGE_PROJECTS")
/**
 * @Route("/paseka/matkas/kategorias", name="paseka.matkas.kategorias")
 */
class KategoriasController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param KategoriaFetcher $fetcher
     * @return Response
     */
    public function index(KategoriaFetcher $fetcher): Response
    {
        $kategorias = $fetcher->all();
        $permissions = Permission::names();

        return $this->render('app/paseka/matkas/kategorias/index.html.twig', compact('kategorias', 'permissions'));
    }

    /**
     * @Route("/create", name=".create")
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(Request $request, Create\Handler $handler): Response
    {
        $command = new Create\Command();

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.matkas.kategorias');
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/matkas/kategorias/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param Kategoria $kategoria
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Kategoria $kategoria, Request $request, Edit\Handler $handler): Response
    {
        $command = Edit\Command::fromKategoria($kategoria);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.matkas.kategorias.show', ['id' => $kategoria->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/matkas/kategorias/edit.html.twig', [
            'kategoria' => $kategoria,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/copy", name=".copy")
     * @param Kategoria $kategoria
     * @param Request $request
     * @param Copy\Handler $handler
     * @return Response
     */
    public function copy(Kategoria $kategoria, Request $request, Copy\Handler $handler): Response
    {
        $command = new Copy\Command($kategoria->getId()->getValue());

        $form = $this->createForm(Copy\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.matkas.kategorias');
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/matkas/kategorias/copy.html.twig', [
            'kategoria' => $kategoria,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"POST"})
     * @param Kategoria $kategoria
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Kategoria $kategoria, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('paseka.matkas.kategorias.show', ['id' => $kategoria->getId()]);
        }

        $command = new Remove\Command($kategoria->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('paseka.matkas.kategorias');
    }

    /**
     * @Route("/{id}", name=".show")
     * @param Kategoria $kategoria
     * @return Response
     */
    public function show(Kategoria $kategoria): Response
    {
        return $this->render('app/paseka/matkas/kategorias/show.html.twig', compact('kategoria'));
    }
}
