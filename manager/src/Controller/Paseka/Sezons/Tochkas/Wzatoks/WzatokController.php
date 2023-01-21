<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Sezons\Tochkas\Wzatoks;

use App\Controller\ErrorHandler;

use App\Annotation\Guid;
use App\Model\Paseka\Entity\Sezons\Tochkas\Wzatoks\Id;

use App\ReadModel\Paseka\Sezons\Tochkas\Wzatoks\WzatokFetcher;
use App\Model\Paseka\Entity\Sezons\Tochkas\Tochka;
use App\Model\Paseka\UseCase\Sezons\Tochkas\Wzatoks\Create;
use App\Model\Paseka\UseCase\Sezons\Tochkas\Wzatoks\Edit;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("/sezons/tochkas/{tochka_id}/wzatoks", name="sezons.tochkas.wzatoks")
     * @ParamConverter("tochka", options={"id" = "tochka_id"})
     */
class WzatokController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }
    /**
     * @Route("", name="")
     * @param Request $request
     * @param Tochka $tochka
     * @param WzatokFetcher $fetchers
     * @return Response
     */
    public function index(Request $request, Tochka $tochka,
                           WzatokFetcher $fetchers  ): Response
    {
//      dd($fetchers->allOfTochka($tochka->getId()->getValue()));
        return $this->render('sezons/tochkas/wzatoks/index.html.twig', [
            'tochka'=> $tochka,
            'wzatoks' => $fetchers->allOfTochka($tochka->getId()->getValue()),
        ]);
    }

    /**
     * @Route("/create", name=".create")
     * @param Request $request
     * @param Tochka $tochka
     * @param WzatokFetcher $fetchers
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(Request $request, WzatokFetcher $fetchers,Tochka $tochka,  Create\Handler $handler): Response
    {
        $gruppa = $tochka->getGruppa()  ;
        $nomerwz = $fetchers->getMaxWzatok($tochka->getId()->getValue()) +1;
        $gruppa = $gruppa.".".$nomerwz;

        $command = new Create\Command($tochka->getId()->getValue(),
                                    $gruppa, $nomerwz);

        $form = $this->createForm(Create\Form::class, $command  );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('sezons.tochkas.wzatoks', ['tochka_id' => $tochka->getId()->getValue()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('sezons/tochkas/wzatoks/create.html.twig', [
            'nomerwz' => $nomerwz,
            'tochka' => $tochka,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param Tochka $tochka
     * @param string $id
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Request $request, Tochka $tochka, string $id,  Edit\Handler $handler): Response
    {
//dd($tochka);
        $wzatok = $tochka->getWzatok(new Id($id));

        $command = Edit\Command::fromWzatok($tochka,  $wzatok );

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('sezons.tochkas.wzatoks', ['tochka_id' => $tochka->getId(),
                                                        'id' => $id]);
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('sezons/tochkas/wzatoks/edit.html.twig', [
            'wzatok' => $wzatok,
            'tochka'  => $tochka,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name=".show", requirements={"id"=Guid::PATTERN})
     * @param Tochka $tochka
     * @return Response
     */
    public function show(Tochka $tochka): Response
    {
        return $this->redirectToRoute('sezons.tochkas.wzatoks',
            ['tochka_id' => $tochka->getId()]);
    }
}