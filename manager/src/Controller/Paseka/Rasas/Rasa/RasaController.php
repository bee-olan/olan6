<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Rasas\Rasa;

use App\Annotation\Guid;
use App\Model\Paseka\Entity\Rasas\Rasa;
use App\Model\Paseka\UseCase\Rasas\Remove;

//use App\Security\Voter\Paseka\Materis\MateriAccess;
use App\ReadModel\Paseka\Rasas\Linias\LiniaFetcher;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paseka/{rasa_id}/rasas", name="paseka.rasas")
 */
class RasaController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    /**
      * @Route("", name=".show", requirements={"id"=Guid::PATTERN})
      * @param Rasa $rasa
      * @param LiniaFetcher $fetcher
      * @return Response
      */
      public function show(Rasa $rasa, LiniaFetcher $fetcher): Response
      {
          $linias = $fetcher->allOfRasa($rasa->getId()->getValue());

        return $this->render('app/paseka/rasas/linias/index.html.twig',
                                            compact('rasa', 'linias')); 
    
    }

    /**
     * @Route("/delete", name=".delete", methods={"POST"})
     * @param Rasa $rasa
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Rasa $rasa, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('paseka.rasas', ['id' => $rasa->getId()]);
        }

        //$this->denyAccessUnlessGranted(MateriAccess::EDIT, $rasas);

        $command = new Remove\Command($rasa->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->logger->warning($e->getMessage(), ['exception' => $e]);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('paseka.rasas');
    }	


}
