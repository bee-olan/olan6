<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Sezons\Nachalos;

use App\Annotation\Guid;

use App\Model\Paseka\Entity\Sezons\Godas\Goda;
use App\ReadModel\Paseka\Sezons\Nachalos\NachaloFetcher;
use App\ReadModel\Paseka\Uchasties\PersonaFetcher;

use App\Model\Paseka\UseCase\Sezons\Nachalos\Create;

use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sezons/nachalos", name="sezons.nachalos")
 */
class NachaloController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    /**
     * @Route("", name="")
     * @param Request $request
     * @param NachaloFetcher $nachalos
     * @return Response
     */
    public function index( Request $request,  NachaloFetcher $nachalos): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);
//dd($nachalos->allOfGoda($goda->getId()->getValue()));
//        dd($nachalos->all());

        return $this->render('sezons/nachalos/index.html.twig', [
            'nachalos' => $nachalos->all(),
        ]);
    }

//    /**
//     * @Route("/plemmatka", name=".plemmatka")
//     * @param Goda $goda
//     * @param Request $request
//     * @param NachaloFetcher $nachalos
//     * @return Response
//     */
//    public function plemmatka( Goda $goda, Request $request,  NachaloFetcher $nachalos ): Response
//    {
//        return $this->render('app/sezons/godas/nachalos/plemmatka.html.twig', [
//            'goda' => $goda,
//            'nachalos' => $nachalos->allOfGoda($goda->getId()->getValue()),
//        ]);
//    }
//
    /**
     * @Route("/create", name=".create")
     * @param PersonaFetcher $personas
	 * @param NachaloFetcher $nachalos
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create( PersonaFetcher $personas, NachaloFetcher $nachalos, Request $request, Create\Handler $handler): Response
   {
       if (!$personas->exists($this->getUser()->getId())) {
           $this->addFlash('error', 'Начните с выбора ПерсонНомера ');
           return $this->redirectToRoute('paseka.uchasties.personas.diapazon');
       }
       $grupp = $personas->find($this->getUser()->getId());
       $gruppa = (string)$grupp->getNomer();

        $command = new Create\Command(
                        $gruppa
                        );
        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);
//dd($command);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('sezons.nachalos');
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }
        return $this->render('sezons/nachalos/create.html.twig', [
//            'goda' => $goda,
            'form' => $form->createView(),
//            'name' => $command->title,
        ]);
   }
//
//    /**
//     * @Route("/{nachalo_id}/edit", name=".edit")
//     * @param Goda $goda
//     * @param string $nachalo_id
//     * @param Request $request
//     * @param Edit\Handler $handler
//     * @return Response
//     */
//    public function edit(Goda $goda, string $nachalo_id, Request $request, Edit\Handler $handler): Response
//    {
//        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);
//
//        $nachalo = $goda->getNachalo(new Id($nachalo_id));
//
//        $command = Edit\Command::fromNachalo($goda, $nachalo);
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
//                return $this->redirectToRoute('sezons.godas.nachalos.show',
//									['id' => $goda->getId(), 'nachalo_id' => $nachalo_id]);
//            } catch (\DomainException $e) {
//                $this->logger->warning($e->getMessage(), ['exception' => $e]);
//                $this->addFlash('error', $e->getMessage());
//            }
//        }
//
//        return $this->render('app/sezons/godas/nachalos/edit.html.twig', [
//            'goda' => $goda,
//            'nachalo' => $nachalo,
//            'form' => $form->createView(),
//        ]);
//    }
//
//    /**
//     * @Route("/{nachalo_id}/delete", name=".delete", methods={"POST"})
//     * @param Goda $goda
//     * @param string $nachalo_id
//     * @param Request $request
//     * @param Remove\Handler $handler
//     * @return Response
//     */
//    public function delete(Goda $goda, string $nachalo_id, Request $request, Remove\Handler $handler): Response
//    {
//        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);
//
//        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
//            return $this->redirectToRoute('sezons.godas.nachalos', ['id' => $goda->getId()]);
//        }
//
//        $nachalo = $goda->getNachalo(new Id($nachalo_id));
//
//        $command = new Remove\Command($goda->getId()->getValue(), $nachalo->getId()->getValue());
//
//        try {
//            $handler->handle($command);
//        } catch (\DomainException $e) {
//            $this->logger->warning($e->getMessage(), ['exception' => $e]);
//            $this->addFlash('error', $e->getMessage());
//        }
//
//        return $this->redirectToRoute('sezons.godas.nachalos',
//					['id' => $goda->getId()]);
//    }
//
//    /**
//     * @Route("/{nachalo_id}", name=".show", requirements={"nachalo_id"=Guid::PATTERN})
//     * @param Goda $goda
//     * @return Response
//     */
//    public function show(Goda $goda): Response
//    {
//        return $this->redirectToRoute('sezons.godas.nachalos',
//				['id' => $goda->getId()]);
//    }
}
