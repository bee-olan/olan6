<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Sezons\Godas;

use App\Annotation\Guid;
use App\Model\Paseka\Entity\Sezons\Godas\GodaRepository;
use App\Model\Paseka\Entity\Sezons\Godas\UchasGoda;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie;
use App\Model\Paseka\UseCase\Sezons\Godas\UchasGoda\Add;
use App\Model\Paseka\UseCase\Sezons\Godas\UchasGoda\Edit ;
use App\Controller\ErrorHandler;
use App\Model\Paseka\Entity\Sezons\Godas\Goda;
use App\Model\User\Entity\User\User;
use App\ReadModel\Paseka\Sezons\Godas\GodaFetcher;
use App\ReadModel\Paseka\Sezons\Godas\UchasGodaFetcher;
use App\ReadModel\Paseka\Uchasties\PersonaFetcher;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sezons/godas/{id}/uchasgoda", name="sezons.godas.uchasgoda")
 */
class UchasGodaController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }
    /**
     * @Route("", name="")
     * @param Request $request
     * @param Goda $goda
     * @param UchasGodaFetcher $uchasgodas
     * @return Response
     */
    public function index( Goda $goda,  UchasGodaFetcher $uchasgodas, Request $request): Response
    {


//       dd($uchasgodas->allOfGoda($goda->getId()->getValue()));
        // $this->denyAccessUnlessGranted(ProjectAccess::MANAGE_MEMBERS, $plemmatka);
// выводит из проекта uchastniks - учстников
        return $this->render('sezons/godas/uchasgoda/index.html.twig', [
            'goda' => $goda,
            'uchasgodas' => $uchasgodas->allOfGoda($goda->getId()->getValue()),
        ]);
    }

    /**
     * @Route("/assign", name=".assign")
     * @param Goda $goda
     * @param PersonaFetcher $personas
     * @param UchasGodaFetcher $uchasgodas
     * @param Request $request
     * @param Add\Handler $handler
     * @return Response
     */
    public function assign(UchasGodaFetcher $uchasgodas, PersonaFetcher $personas, Goda $goda, Request $request, Add\Handler $handler): Response
    {
//dd($uchasgodas->getUchas());
        if ($uchasgodas->exists($this->getUser()->getId(),$goda->getId()->getValue())) {
            $this->addFlash('error', 'Вы уже в этом сезоне ');
            return $this->redirectToRoute('sezons.godas.uchasgoda', ['id' => $goda->getId()->getValue()]);
        }

        if (!$personas->exists($this->getUser()->getId())) {
            $this->addFlash('error', 'Начните с выбора ПерсонНомера ');
            return $this->redirectToRoute('paseka.uchasties.personas.diapazon');
        }
        $grupp = $personas->find($this->getUser()->getId());
        $gruppa = (string)$grupp->getNomer();


        $command = new Add\Command($goda->getId()->getValue(),
                                    $this->getUser()->getId(),
                                    $gruppa);

        $form = $this->createForm(Add\Form::class, $command  );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('sezons.godas.uchasgoda', ['id' => $goda->getId()->getValue()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('sezons/godas/uchasgoda/assign.html.twig', [
            'goda' => $goda,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("edit", name=".edit")
     * @param UchasGoda $uchasgoda
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(UchasGoda $uchasgoda, Request $request, Edit\Handler $handler): Response
    {
        $command = Edit\Command::fromUchasGoda($uchasgoda);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('sezons.godas.uchasgoda', ['id' => $goda->getId()->getValue()]);
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('sezons/godas/uchasgoda/edit.html.twig', [
            'uchastie' => $uchastie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{uchasgoda_id}", name=".show", requirements={"uchasgoda_id"=Guid::PATTERN})
     * @param Goda $goda
     * @return Response
     */
    public function show(Goda $goda): Response
    {
        return $this->redirectToRoute('paseka.godas.uchasgoda',
            ['id' => $goda->getId()]);
    }
}