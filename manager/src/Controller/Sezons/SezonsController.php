<?php

declare(strict_types=1);

namespace App\Controller\Sezons;

use App\Annotation\Guid;
use App\Model\Sezons\UseCase\Sezon\Create;

use App\ReadModel\Sezons\SezonFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/sezons", name="sezons")
 */
class SezonsController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("", name="")
     * @param SezonFetcher $sezons
     * @return Response
     */
    public function index(SezonFetcher $sezons): Response
    {

        $sezons = $sezons->all();

        return $this->render('app/sezons/index.html.twig', compact('sezons'));
    }

    /**
     * @Route("/create", name=".create")
     * @param SezonFetcher $sezons
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(Request $request,  SezonFetcher $sezons, Create\Handler $handler): Response
    {
            $godMax = $sezons->getMaxGod() + 1;
       // dd( $godMax);

        $command = new Create\Command();

//        $form = $this->createForm(Create\Form::class, $command);
//        $form->handleRequest($request);
        $command->god = $godMax;

        $command->sezon = $godMax."-".($godMax + 1);

//        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('sezons');
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
//        }

        return $this->render('app/sezons/create.html.twig', [
           // 'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name=".show", requirements={"id"=Guid::PATTERN})
     * @return Response
     */
    public function show(): Response
    {
        return $this->redirectToRoute('sezons');
    }
}
