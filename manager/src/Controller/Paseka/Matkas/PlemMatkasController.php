<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Matkas;

use App\Model\Paseka\Entity\Rasas\Linias\Nomers\Id;
use App\Model\Paseka\Entity\Rasas\Linias\Nomers\NomerRepository;

use App\Model\Paseka\UseCase\Matkas\PlemMatka\Create;
use App\ReadModel\Paseka\Matkas\PlemMatka\Filter;

use App\ReadModel\Paseka\Matkas\PlemMatka\PlemMatkaFetcher;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paseka/matkas", name="paseka.matkas")
 */
class PlemMatkasController extends AbstractController
{
    private const PER_PAGE = 50;

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("", name="")
     * @param Request $request
     * @param PlemMatkaFetcher $fetcher
     * @return Response
     */
    public function index(Request $request, PlemMatkaFetcher $fetcher): Response
    {
        $filter = new Filter\Filter();

        $form = $this->createForm(Filter\Form::class, $filter);
        $form->handleRequest($request);

        $pagination = $fetcher->all(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 'name'),
            $request->query->get('direction', 'asc')
        );

        return $this->render('app/paseka/matkas/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/create/{id}", name=".create")
     * @param Request $request
     * @param NomerRepository $nomers
     * @param string $id
     * @param PlemMatkaFetcher $plemmatkas
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(string $id, Request $request,
                           PlemMatkaFetcher $plemmatkas,
                           NomerRepository $nomers,
                           Create\Handler $handler): Response
    {
//        $this->denyAccessUnlessGranted('ROLE_WORK_MANAGE_PROJECTS');

        $nomer = $nomers->get(new Id($id));

        $command = new Create\Command();
        $command->sort = $plemmatkas->getMaxSort() + 1;
        $command->name = $nomer->getTitle()."_п-м-".$command->sort;
     //dd($command->name);
        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.matkas');
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/matkas/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}