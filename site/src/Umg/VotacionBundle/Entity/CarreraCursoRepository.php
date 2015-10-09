<?php
// src/AppBundle/Entity/ProductRepository.php
namespace Umg\VotacionBundle\Entity;
use DateTime;

use Doctrine\ORM\EntityRepository;

class CarreraCursoRepository extends EntityRepository
{
    public function findCatedraticosCarrera($carrera)
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('c')
            ->from('UmgVotacionBundle:CatedraticoCurso', 'c')
            ->innerJoin('c.carreraCurso','cc')
            ->where('cc.campusCarrera = :carrera')
            ->groupBy('c.Catedratico_id')
            ->setParameter('carrera', $carrera)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findCursos($carrera,$catedratico)
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->select('c')
            ->from('UmgVotacionBundle:CatedraticoCurso', 'c')
            ->innerJoin('c.carreraCurso','cc')
            ->where('cc.campusCarrera = :carrera')
            ->andWhere('c.Catedratico_id = :catedratico')
            ->setParameter('carrera', $carrera)
            ->setParameter('catedratico', $catedratico->getId())
            ->getQuery()
            ->getResult()
            ;
    }

}
