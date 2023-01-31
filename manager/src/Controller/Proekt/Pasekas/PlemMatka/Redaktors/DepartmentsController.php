<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\PlemMatka\Redaktors;

use App\Annotation\Guid;
use App\Model\Paseka\Entity\Matkas\PlemMatka\Department\Id;

use  App\Model\Paseka\UseCase\Matkas\PlemMatka\Department\Create;
use  App\Model\Paseka\UseCase\Matkas\PlemMatka\Department\Edit;
use  App\Model\Paseka\UseCase\Matkas\PlemMatka\Department\Remove;
use App\ReadModel\Paseka\Matkas\PlemMatka\DepartmentFetcher;
//use App\Security\Voter\Work\Projects\ProjectAccess;
use App\Controller\ErrorHandler;
use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Security\Voter\Proekt\Matkas\PlemMatkaAccess;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paseka/matkas/plemmatka/{plemmatka_id}/redaktors/departments", name="paseka.matkas.plemmatka.redaktors.departments")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class DepartmentsController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param PlemMatka $plemmatka
     * @param DepartmentFetcher $departments
     * @return Response
     */
    public function index(PlemMatka $plemmatka, DepartmentFetcher $departments): Response
    {
        $this->denyAccessUnlessGranted(PlemMatkaAccess::MANAGE_UCHASTIES, $plemmatka);


        return $this->render('app/paseka/matkas/plemmatka/redaktors/departments/index.html.twig', [
            'plemmatka' => $plemmatka,
            'departments' => $departments->allOfPlemMatka($plemmatka->getId()->getValue()),
        ]);
    }

    /**
     * @Route("/create", name=".create")
     * @param PlemMatka $plemmatka
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(PlemMatka $plemmatka, Request $request, Create\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted(PlemMatkaAccess::MANAGE_UCHASTIES, $plemmatka);

        $command = new Create\Command($plemmatka->getId()->getValue());

//        $form = $this->createForm(Create\Form::class, $command);
//        $form->handleRequest($request);

//        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.matkas.plemmatka.redaktors.departments', ['plemmatka_id' => $plemmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
//        }

        return $this->render('app/paseka/matkas/plemmatka/redaktors/departments/create.html.twig', [
            'plemmatka' => $plemmatka,
//            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param PlemMatka $plemmatka
     * @param string $id
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(PlemMatka $plemmatka, string $id, Request $request, Edit\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted(PlemMatkaAccess::MANAGE_UCHASTIES, $plemmatka);

        $department = $plemmatka->getDepartment(new Id($id));

        $command = Edit\Command::fromDepartment($plemmatka, $department);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.matkas.plemmatka.redaktors.departments.show', ['plemmatka_id' => $plemmatka->getId(), 'id' => $id]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/matkas/plemmatka/redaktors/departments/edit.html.twig', [
            'plemmatka' => $plemmatka,
            'department' => $department,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"POST"})
     * @param PlemMatka $plemmatka
     * @param string $id
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(PlemMatka $plemmatka, string $id, Request $request, Remove\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted(PlemMatkaAccess::MANAGE_UCHASTIES, $plemmatka);

        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('paseka.matkas.plemmatka.redaktors.departments', ['plemmatka_id' => $plemmatka->getId()]);
        }

        $department = $plemmatka->getDepartment(new Id($id));

        $command = new Remove\Command($plemmatka->getId()->getValue(), $department->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('paseka.matkas.plemmatka.redaktors.departments', ['plemmatka_id' => $plemmatka->getId()]);
    }

    /**
     * @Route("/{id}", name=".show", requirements={"id"=Guid::PATTERN}))
     * @param PlemMatka $plemmatka
     * @return Response
     */
    public function show(PlemMatka $plemmatka): Response
    {
        return $this->redirectToRoute('paseka.matkas.plemmatka.redaktors.departments', ['plemmatka_id' => $plemmatka->getId()]);
    }
}
