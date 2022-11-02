<?php


namespace App\Controller\Mesto\InfaMesto;

use App\Model\Mesto\Entity\Okrugs\Oblasts\Raions\Raion;

use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mesto/infamesto/{raion_id}", name="mesto.infamesto")
 * @ParamConverter("raion", options={"id" = "raion_id"})
 */
class MestoInfaController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("/mesto/{name_ok},{name_ob}", name=".mesto")
     * @param string $name_ok
     * @param string $name_ob
     * @param Raion $raion
     * @return Response
     */
    public function mesto(string $name_ok, string $name_ob,  Raion $raion): Response
    {
//        if ($user->getId()->getValue() === $this->getUser()->getId()) {
//            $this->addFlash('error', 'Не в состоянии изменить роль для себя.');
//            return $this->redirectToRoute('users.show', ['id' => $user->getId()]);
//        }

        return $this->render('app/mesto/infamesto/mesto.html.twig',
            compact('name_ok', 'name_ob' , 'raion'));
    }
}
