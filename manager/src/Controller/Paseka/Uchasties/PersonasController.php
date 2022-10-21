<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Uchasties;

use App\Annotation\Guid;
use App\Model\Paseka\Entity\Uchasties\Personas\Id;
use App\Model\Paseka\Entity\Uchasties\Personas\Persona;

use App\Model\Paseka\Entity\Uchasties\Personas\PersonaRepository;
use App\Model\User\Entity\User\User;
use App\ReadModel\User\UserFetcher;

use App\Model\Paseka\UseCase\Uchasties\Personas\Create;
//App\Model\Paseka\UseCase\Uchasties\Personas\Edit;
//App\Model\Paseka\UseCase\Uchasties\Personas\Remove;

use App\Model\Paseka\UseCase\Uchasties\Personas\Diapazon;

use App\ReadModel\Paseka\Uchasties\PersonaFetcher;

use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paseka/uchasties/personas", name="paseka.uchasties.personas")
 */
class PersonasController extends AbstractController

{
    private $logger;
    private $users;

    public function __construct(LoggerInterface $logger, UserFetcher $users)
    {
        $this->logger = $logger;
        $this->users = $users;
    }
    /**
     * @Route("/diapazon", name=".diapazon")
     * @param PersonaFetcher $fetcher
     * @param Diapazon\Handler $handler
     * @return Response
     */
    public function diapazon(PersonaFetcher $fetcher, Request $request, Diapazon\Handler $handler ): Response
    {
        $diapazon = 1;
        if ($fetcher->exists($this->getUser()->getId())) {
            $this->addFlash('error', 'Вы уже выбрали ПЕРСОНАЬНЫЙ номер .');
            return $this->redirectToRoute('paseka.uchasties.personas', ['itogo' => $diapazon]);
        }
        $personas = $fetcher->allPers();

        $command = new Diapazon\Command();

        $form = $this->createForm(Diapazon\Form::class, $command);

        $form->handleRequest($request);

        $diapazon = $command->diapazon;

        if ($form->isSubmitted() && $form->isValid()) {
            try {

                $handler->handle($command);

                return $this->redirectToRoute('paseka.uchasties.personas',  ['itogo' => $diapazon]);
            } catch (\DomainException $e) {
                $this->logger->error($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/uchasties/personas/diapazon.html.twig', [
            'form' => $form->createView(),
            'personas' => $personas,
        ]);
    }

    /**
     * @Route("/show", name=".show")
     * @param PersonaFetcher $fetchers
     * @param PersonaRepository $personas
     * @return Response
     */
    public function show(PersonaFetcher $fetchers, PersonaRepository $personas,
                         Request $request ): Response
    {
        $fetcher = $fetchers->allPers();

        $persona = $personas ->get(new Id($this->getUser()->getId()));


        return $this->render('app/paseka/uchasties/personas/show.html.twig',
            compact('fetcher', 'persona'));

    }

    /**
     * @Route("/{itogo}", name="")
     * @param PersonaFetcher $fetcher
     * @param int $itogo
     * @return Response
     */
    public function index(int $itogo, PersonaFetcher $fetcher): Response
    {

//
        //$personas = $fetcher->all();
		$personas = $fetcher->all();
		//dd($personas[]['nomer']);
        $i = 0;
        $kol_nomer = 50;
        $resul =[];
       // dd($personas);
		foreach($personas as $row) {
		$i++;
		$resul[$i]=$row['nomer'];
		}

        $kol_na4 =  $kol_nomer* ($itogo-1) + 1;
        $kol_kon =  $kol_nomer* $itogo + 1;
		$pe = [];
        for ( $i = $kol_na4; $i < $kol_kon; $i++ )
            { $pe[$i]=$i; }
       // dd($pe);
		$persons = array_diff($pe,$resul);
//dd($persons);

      //  'personas', 'persons',
        return $this->render('app/paseka/uchasties/personas/index.html.twig',
				compact(  'personas', 'persons','itogo'));
    }

    /**
     * @Route("/{person}/create", name=".create")
	 * @param User $user
     * @param PersonaFetcher $personas
     * @param int $person
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create( int $person, Request $request, PersonaFetcher $personas, Create\Handler $handler): Response
    {

        //dd($this->getUser()->getId());

        if ($personas->exists($this->getUser()->getId())) {
            $this->addFlash('error', 'ПЕРСОНАЬНЫЙ номер уже существует..');
            return $this->redirectToRoute('paseka.uchasties.personas', ['person' => $person]);
        }

          //dd($this->getUser()->getId());

		//$user = $this->users->findDetail($this->getUser()->getId());

        //$command = new Create\Command($user->id);

		$command = new Create\Command($this->getUser()->getId() );
        $command->nomer = $person;

        //dd( $person);
        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.uchasties.personas.show');
            } catch (\DomainException $e) {
                $this->logger->error($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/uchasties/personas/create.html.twig', [
            'form' => $form->createView(),
            'person' => $person,
        ]);
    }




//     /**
//     * @Route("/{id}/delete", name=".delete", methods={"POST"})
//     * @param Persona $persona
//     * @param Request $request
//     * @param Remove\Handler $handler
//     * @return Response
//     */
//    public function delete(Persona $persona, Request $request, Remove\Handler $handler): Response
    //{
    //     if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
    //         return $this->redirectToRoute('work.members.groups.show', ['id' => $persona->getId()]);
    //     }

    //     $command = new Remove\Command($persona->getId()->getValue());

    //     try {
    //         $handler->handle($command);
    //         return $this->redirectToRoute('work.members.groups');
    //     } catch (\DomainException $e) {
    //         $this->errors->handle($e);
    //         $this->addFlash('error', $e->getMessage());
    //     }

    //     return $this->redirectToRoute('work.members.groups.show', ['id' => $group->getId()]);
   // }
}
