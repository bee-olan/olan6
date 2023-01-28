<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\PlemMatka;

use App\Annotation\Guid;

use App\Model\Paseka\Entity\Matkas\Kategoria\Permission;
use App\ReadModel\Paseka\Matkas\KategoriaFetcher;

use App\Model\Mesto\Entity\InfaMesto\MestoNomerRepository;
use App\Model\Mesto\Entity\InfaMesto\Id as MestoNomerId;

use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Model\Paseka\Entity\Rasas\Linias\Nomers\Id;
use App\Model\Paseka\Entity\Rasas\Linias\Nomers\NomerRepository;

use App\Model\Paseka\Entity\Uchasties\Personas\PersonaRepository;
use App\Model\Paseka\Entity\Uchasties\Personas\Id as PersonaId;

use App\Model\Paseka\UseCase\Matkas\PlemMatka\Create;
use App\Model\Paseka\UseCase\Matkas\PlemMatka\Remove;

use App\ReadModel\Proekt\Pasekas\PlemMatka\Side\Filter;
use App\ReadModel\Proekt\Pasekas\PlemMatka\Side\PlemSideFetcher;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proekt/pasekas/matkas", name="proekt.pasekas.matkas")
 */
class PlemMatkaCreateController extends AbstractController
{
    private const PER_PAGE = 10;

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("", name="")
     * @param Request $request
     * @param PlemSideFetcher $fetcher
     * @return Response
     */
    public function index(Request $request, PlemSideFetcher $fetcher): Response
    {
        $filter = new Filter\Filter();

        $form = $this->createForm(Filter\Form::class, $filter);
        $form->handleRequest($request);

        $pagination = $fetcher->all(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 'name', 'persona'),
            $request->query->get('direction', 'asc')
        );

        return $this->render('proekt/pasekas/matkas/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/create/{id}", name=".create" , requirements={"id"=Guid::PATTERN})
     * @param Request $request
     * @param NomerRepository $nomers
     * @param PersonaRepository $personas
     * @param MestoNomerRepository $mestonomers
     * @param string $id
     * @param PlemSideFetcher $plemmatkas
     * @param Create\Handler $handler
     * @param KategoriaFetcher $kategoria
     * @return Response
     */
    public function create(string $id, Request $request,
                           PlemSideFetcher $plemmatkas,
                           PersonaRepository $personas,
                           MestoNomerRepository $mestonomers,
                           NomerRepository $nomers,
                           Create\Handler $handler,
                           KategoriaFetcher $kategoria
                           ): Response
    {
//        $this->denyAccessUnlessGranted('ROLE_WORK_MANAGE_PROJECTS');

        if (!$plemmatkas->existsPerson($this->getUser()->getId())) {
            $this->addFlash('error', 'Начните с выбора ПерсонНомера ');
            return $this->redirectToRoute('paseka.uchasties.personas.diapazon');
        }

        if (!$plemmatkas->existsMesto($this->getUser()->getId())) {
            $this->addFlash('error', 'Пожалуйста, определитесь с номером места расположения Вашей пасеки ');
            return $this->redirectToRoute('mesto.infamesto.okrugs');
        }
        $sort = $plemmatkas->getMaxSort() + 1;

        $command = new Create\Command($id, $sort, $this->getUser()->getId() );

        $nomer = $nomers->get(new Id($id));
//dd($nomer);
        $uchastieId =  $this->getUser()->getId();
//        $persona = $personas->get(new PersonaId($uchastieId));
//        $mestonomer = $mestonomers->get(new MestoNomerId($uchastieId));


//        $command->rasaNomId = $id;

//        $command->uchastieId = $uchastieId;

//        $command->persona = $persona->getNomer();

//        $command->
//        $command->sort = $plemmatkas->getMaxSort() + 1;

//        $command->mesto = $mestonomer->getNomer();


//        $command->name = $nomer->getTitle()." : "."пн-". $command->persona."_".$command->mesto;
//        dd( $command->name);

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('proekt.pasekas.matkas.plemmatkas.sdelano',
                [ 'id_nom' => $id ,'kategoria' => $command->nameKateg, 'plemmatka' => $command->name]);
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }
        $kategorias = $kategoria->all();
        $permissions = Permission::names();

        return $this->render('proekt/pasekas/matkas/create.html.twig', [
            'form' => $form->createView(),
            'command' => $command,
            'kategorias' => $kategorias, 
            'permissions' => $permissions,
        ]);
    }

}