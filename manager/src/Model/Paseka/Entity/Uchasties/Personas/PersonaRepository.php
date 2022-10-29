<?php


namespace App\Model\Paseka\Entity\Uchasties\Personas;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class PersonaRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Persona::class);
        $this->em = $em;
    }

    public function get(Id $id): Persona
    {
        /** @var Persona $persona */
        if (!$persona = $this->repo->find($id->getValue())) {
          return $this->redirectToRoute('paseka.uchasties.personas.diapazon');
            //  return $this->render('app/paseka/uchasties/personas/diapazon.html.twig');
            //throw new EntityNotFoundException('Persona is not found.');
        }
        return $persona;
    }

    public function add(Persona $persona): void
    {
        $this->em->persist($persona);
    }

    public function remove(Persona $persona): void
    {
        $this->em->remove($persona);
    }
}
