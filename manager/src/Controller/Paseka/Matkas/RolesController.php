<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Matkas;

use App\Model\Paseka\Entity\Matkas\Role\Permission;
use App\Model\Paseka\Entity\Matkas\Role\Role;
use App\Model\Paseka\UseCase\Matkas\Role\Copy;
use App\Model\Paseka\UseCase\Matkas\Role\Create;
use App\Model\Paseka\UseCase\Matkas\Role\Edit;
use App\Model\Paseka\UseCase\Matkas\Role\Remove;
use App\ReadModel\Paseka\Matkas\RoleFetcher;
use App\Controller\ErrorHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// * @IsGranted("ROLE_WORK_MANAGE_PROJECTS")
/**
 * @Route("/paseka/matkas/roles", name="paseka.matkas.roles")
 */
class RolesController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param RoleFetcher $fetcher
     * @return Response
     */
    public function index(RoleFetcher $fetcher): Response
    {
        $roles = $fetcher->all();
        $permissions = Permission::names();

        return $this->render('app/paseka/matkas/roles/index.html.twig', compact('roles', 'permissions'));
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
                return $this->redirectToRoute('paseka.matkas.roles');
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/matkas/roles/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param Role $role
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Role $role, Request $request, Edit\Handler $handler): Response
    {
        $command = Edit\Command::fromRole($role);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.matkas.roles.show', ['id' => $role->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/matkas/roles/edit.html.twig', [
            'role' => $role,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/copy", name=".copy")
     * @param Role $role
     * @param Request $request
     * @param Copy\Handler $handler
     * @return Response
     */
    public function copy(Role $role, Request $request, Copy\Handler $handler): Response
    {
        $command = new Copy\Command($role->getId()->getValue());

        $form = $this->createForm(Copy\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.matkas.roles');
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/matkas/roles/copy.html.twig', [
            'role' => $role,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"POST"})
     * @param Role $role
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Role $role, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('paseka.matkas.roles.show', ['id' => $role->getId()]);
        }

        $command = new Remove\Command($role->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('paseka.matkas.roles');
    }

    /**
     * @Route("/{id}", name=".show")
     * @param Role $role
     * @return Response
     */
    public function show(Role $role): Response
    {
        return $this->render('app/paseka/matkas/roles/show.html.twig', compact('role'));
    }
}
