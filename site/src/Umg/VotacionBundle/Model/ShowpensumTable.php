<?php

namespace Umg\VotacionBundle\Model;

use Brown298\DataTablesBundle\MetaData as DataTable;
use Brown298\DataTablesBundle\Model\DataTable\QueryBuilderDataTableInterface;
use Brown298\DataTablesBundle\Test\DataTable\QueryBuilderDataTable;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Templating\EngineInterface;


/**
 * Class ShowshowpensumTable
 *
 * @package Umg\VotacionBundle\Model
 *
 * @DataTable\Table(id="showpensumTable", displayLength=10)
 */
class ShowpensumTable extends QueryBuilderDataTable implements QueryBuilderDataTableInterface
{
    /**
     * @var string
     * @DataTable\Column(source="q.id", name="Código")
     * @DataTable\Format(dataFields={"id":"q.id","codigo":"q.Codigo"}, template="UmgVotacionBundle:Pensum:shownombre.html.twig")
     * @DataTable\DefaultSort()
     */
    public $id;

     /**
     * @var string
     * @DataTable\Column(source="q.curso.Curso", name="Curso")
     * @DataTable\DefaultSort()
     */
    public $curso;

     /**
     * @var string
     * @DataTable\Column(source="q.carrera.Carrera", name="Carrera")
     * @DataTable\DefaultSort()
     */
    public $carrera;
    /**
     * @var int
     * @DataTable\Column(source="q.Codigo", name="Acciones")
     * @DataTable\Format(dataFields={"id":"q.id"}, template="UmgVotacionBundle:Pensum:showaccionesindex.html.twig")
     */
    public $acciones;

    /**
     * @var bool hydrate results to doctrine objects
     */
    public $hydrateObjects = true;

    /**
     * getQueryBuilder
     *
     * @param Request $request
     *
     * @return null
     */
    public function getQueryBuilder(Request $request = null)
    {
        $id = $request->request->get('id');
        $userRepository = $this->container->get('doctrine.orm.entity_manager')
            ->getRepository('UmgVotacionBundle:PensumAnio');
        $qb = $userRepository->createQueryBuilder('q')
                ->andWhere('q.Pensum_id = :id')
                ->setParameter('id', $id)
            ;

        return $qb;
    }

}
