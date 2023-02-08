<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Matkas;

//use App\Model\Work\Entity\PlemMatkas\PlemMatka\PlemMatka;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Files;

use App\Model\Paseka\UseCase\Matkas\ChildMatka\Executor;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Move;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Plan;


use App\Controller\ErrorHandler;
use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatka;

use App\Security\Voter\Proekt\Matkas\ChildMatkaAccess;
use App\Service\Uploader\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("paseka/matkas/childmatkas", name="paseka.matkas.childmatkas")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class FilesChildController extends AbstractController
{
    private const PER_PAGE = 50;

    private $errors;

    public function __construct( ErrorHandler $errors)
    {
        $this->errors = $errors;
    }






}


