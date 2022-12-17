<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\PlemMatka;

use App\Annotation\Guid;

use App\Model\Mesto\Entity\InfaMesto\MestoNomerRepository;
use App\Model\Mesto\Entity\InfaMesto\Id as MestoNomerId;

use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Model\Paseka\Entity\Rasas\Linias\Nomers\Id;
use App\Model\Paseka\Entity\Rasas\Linias\Nomers\NomerRepository;

use App\Model\Paseka\Entity\Uchasties\Personas\PersonaRepository;
use App\Model\Paseka\Entity\Uchasties\Personas\Id as PersonaId;

use App\Model\Paseka\UseCase\Matkas\PlemMatka\Create;
use App\Model\Paseka\UseCase\Matkas\PlemMatka\Remove;
use App\ReadModel\Paseka\Matkas\PlemMatka\Filter;

use App\ReadModel\Paseka\Matkas\PlemMatka\PlemMatkaFetcher;
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
    private const PER_PAGE = 50;

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    // /**
    //  * @Route("", name="")
    //  * @param Request $request
    //  * @param PlemMatkaFetcher $fetcher
    //  * @return Response
    //  */
    // public function index(Request $request, PlemMatkaFetcher $fetcher): Response
    // {
    //     $filter = new Filter\Filter();

    //     $form = $this->createForm(Filter\Form::class, $filter);
    //     $form->handleRequest($request);

    //     $pagination = $fetcher->all(
    //         $filter,
    //         $request->query->getInt('page', 1),
    //         self::PER_PAGE,
    //         $request->query->get('sort', 'name', 'persona'),
    //         $request->query->get('direction', 'asc')
    //     );

    //     return $this->render('proekt/pasekas/matkas/index.html.twig', [
    //         'pagination' => $pagination,
    //         'form' => $form->createView(),
    //     ]);
    // }

    /**
     * @Route("/create/{id}", name=".create" , requirements={"id"=Guid::PATTERN})
     * @param Request $request
     * @param NomerRepository $nomers
     * @param PersonaRepository $personas
     * @param MestoNomerRepository $mestonomers
     * @param string $id
     * @param PlemMatka $plemmatka
     * @param PlemMatkaFetcher $plemmatkas
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(string $id, Request $request,
                           PlemMatkaFetcher $plemmatkas,
                           PersonaRepository $personas,
                           MestoNomerRepository $mestonomers,
                           NomerRepository $nomers,
                           PlemMatka $plemmatka,
                           Create\Handler $handler): Response
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

        $nomer = $nomers->get(new Id($id));

        $uchastieId =  $this->getUser()->getId();
        $persona = $personas->get(new PersonaId($uchastieId));
        $mestonomer = $mestonomers->get(new MestoNomerId($uchastieId));

        $command = new Create\Command();

        $command->rasaNomId = $id;

        $command->uchastieId = $uchastieId;

        $command->persona = $persona->getNomer();

        $command->sort = $plemmatkas->getMaxSortPerson($command->persona) + 1;

        $command->mesto = $mestonomer->getNomer();

        $command->name = $nomer->getTitle()." : ".$command->mesto."_пН-". $command->persona."_№-".$command->sort;

        // dd($command);

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

        return $this->render('proekt/pasekas/matkas/create.html.twig', [
            'form' => $form->createView(),
            'command' => $command,
        ]);
    }

}