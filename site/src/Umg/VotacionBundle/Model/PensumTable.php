<?php

namespace Umg\VotacionBundle\Model;

use Brown298\DataTablesBundle\MetaData as DataTable;
use Brown298\DataTablesBundle\Model\DataTable\QueryBuilderDataTableInterface;
use Brown298\DataTablesBundle\Test\DataTable\QueryBuilderDataTable;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Templating\EngineInterface;


/**
 * Class PensumTable
 *
 * @package Umg\VotacionBundle\Model
 *
 * @DataTable\Table(id="pensumTable", displayLength=10)
 */
class PensumTable extends QueryBuilderDataTable implements QueryBuilderDataTableInterface
{
    /**
     * @var string
     * @DataTable\Column(source="q.id", name="Año")
     * @DataTable\Format(dataFields={"id":"q.id","anio":"q.Anio"}, template="UmgVotacionBundle:Pensum:nombre.html.twig")
     * @DataTable\DefaultSort()
     */
    public $id;
      
    /**
     * @var int
     * @DataTable\Column(source="q.Anio", name="Acciones")
     * @DataTable\Format(dataFields={"id":"q.id"}, template="UmgVotacionBundle:Pensum:accionesindex.html.twig")
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
        $userRepository = $this->container->get('doctrine.orm.entity_manager')
            ->getRepository('UmgVotacionBundle:Pensum');
        $qb = $userRepository->createQueryBuilder('q')
            ;

        return $qb;
    }
     
}
