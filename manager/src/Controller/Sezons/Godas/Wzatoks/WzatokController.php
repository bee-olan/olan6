<?php

declare(strict_types=1);

namespace App\Controller\Sezons\Godas\Wzatoks;

use App\Annotation\Guid;
//use App\Model\Paseka\Entity\Godas\Wzatoks\Id;

use App\Model\Sezons\UseCase\Godas\Wzatoks\Create;
use App\Controller\ErrorHandler;
use App\Model\Sezons\Entity\Godas\Goda;
use App\ReadModel\Paseka\Uchasties\PersonaFetcher;
use App\ReadModel\Sezons\Godas\Wzatoks\WzatokFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sezons/godas/{id}/wzatoks", name="sezons.godas.wzatoks")
 */
class WzatokController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    /**
     * @Route("", name="")
     * @param Goda $goda
     * @param Request $request
     * @param WzatokFetcher $wzatoks
     * @return Response
     */
    public function index( Goda $goda, Request $request,  WzatokFetcher $wzatoks): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);
//dd($wzatoks->allOfGoda($goda->getId()->getValue()));
        //dd($goda);
        return $this->render('sezons/godas/wzatoks/index.html.twig', [
            'goda' => $goda,
            'wzatoks' => $wzatoks->allOfGoda($goda->getId()->getValue()),
        ]);
    }

//    /**
//     * @Route("/plemmatka", name=".plemmatka")
//     * @param Goda $goda
//     * @param Request $request
//     * @param WzatokFetcher $wzatoks
//     * @return Response
//     */
//    public function plemmatka( Goda $goda, Request $request,  WzatokFetcher $wzatoks ): Response
//    {
//        return $this->render('app/sezons/godas/wzatoks/plemmatka.html.twig', [
//            'goda' => $goda,
//            'wzatoks' => $wzatoks->allOfGoda($goda->getId()->getValue()),
//        ]);
//    }
//
    /**
     * @Route("/create", name=".create")
     * @param Goda $goda
     * @param PersonaFetcher $personas
	 * @param WzatokFetcher $wzatoks
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(Goda $goda, PersonaFetcher $personas, WzatokFetcher $wzatoks, Request $request, Create\Handler $handler): Response
   {
       if (!$personas->exists($this->getUser()->getId())) {
           $this->addFlash('error', 'Начните с выбора ПерсонНомера ');
           return $this->redirectToRoute('paseka.uchasties.personas.diapazon');
       }
       $grupp = $personas->find($this->getUser()->getId());
       $gruppa = (string)$grupp->getNomer();

        $command = new Create\Command(
                        $goda->getId()->getValue(),
                        $gruppa
                        );
        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);
//dd($command);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('sezons.godas.wzatoks', ['id' => $goda->getId()->getValue()]);
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }
        return $this->render('sezons/godas/wzatoks/create.html.twig', [
            'goda' => $goda,
            'form' => $form->createView(),
//            'name' => $command->title,
        ]);
   }
//
//    /**
//     * @Route("/{wzatok_id}/edit", name=".edit")
//     * @param Goda $goda
//     * @param string $wzatok_id
//     * @param Request $request
//     * @param Edit\Handler $handler
//     * @return Response
//     */
//    public function edit(Goda $goda, string $wzatok_id, Request $request, Edit\Handler $handler): Response
//    {
//        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);
//
//        $wzatok = $goda->getWzatok(new Id($wzatok_id));
//
//        $command = Edit\Command::fromWzatok($goda, $wzatok);
//
////$command->title = $godas->getName();
////$command->title = $command->title."_".$command->name;
////dd($command);
//        $form = $this->createForm(Edit\Form::class, $command);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            try {
//                $command->title = $goda->getName();
//                $command->title = $command->title."_".$command->name;
//                // dd($command->title);
//                $handler->handle($command);
//                return $this->redirectToRoute('sezons.godas.wzatoks.show',
//									['id' => $goda->getId(), 'wzatok_id' => $wzatok_id]);
//            } catch (\DomainException $e) {
//                $this->logger->warning($e->getMessage(), ['exception' => $e]);
//                $this->addFlash('error', $e->getMessage());
//            }
//        }
//
//        return $this->render('app/sezons/godas/wzatoks/edit.html.twig', [
//            'goda' => $goda,
//            'wzatok' => $wzatok,
//            'form' => $form->createView(),
//        ]);
//    }
//
//    /**
//     * @Route("/{wzatok_id}/delete", name=".delete", methods={"POST"})
//     * @param Goda $goda
//     * @param string $wzatok_id
//     * @param Request $request
//     * @param Remove\Handler $handler
//     * @return Response
//     */
//    public function delete(Goda $goda, string $wzatok_id, Request $request, Remove\Handler $handler): Response
//    {
//        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);
//
//        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
//            return $this->redirectToRoute('sezons.godas.wzatoks', ['id' => $goda->getId()]);
//        }
//
//        $wzatok = $goda->getWzatok(new Id($wzatok_id));
//
//        $command = new Remove\Command($goda->getId()->getValue(), $wzatok->getId()->getValue());
//
//        try {
//            $handler->handle($command);
//        } catch (\DomainException $e) {
//            $this->logger->warning($e->getMessage(), ['exception' => $e]);
//            $this->addFlash('error', $e->getMessage());
//        }
//
//        return $this->redirectToRoute('sezons.godas.wzatoks',
//					['id' => $goda->getId()]);
//    }
//
//    /**
//     * @Route("/{wzatok_id}", name=".show", requirements={"wzatok_id"=Guid::PATTERN})
//     * @param Goda $goda
//     * @return Response
//     */
//    public function show(Goda $goda): Response
//    {
//        return $this->redirectToRoute('sezons.godas.wzatoks',
//				['id' => $goda->getId()]);
//    }
}
