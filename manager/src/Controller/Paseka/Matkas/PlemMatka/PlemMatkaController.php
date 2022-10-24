<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Matkas\PlemMatka;

use App\Annotation\Guid;

use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatka;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paseka/matkas/{id}", name="paseka.matkas.plemmatka")
 */
class PlemMatkaController extends AbstractController
{
    /**
     * @Route("", name=".show", requirements={"id"=Guid::PATTERN})
     * @param PlemMatka $plemmatka
     * @return Response
     */
    public function show(PlemMatka $plemmatka): Response
    {
        return $this->render('app/paseka/matkas/plemmatka/show.html.twig',
            compact('plemmatka'));
    }
}
