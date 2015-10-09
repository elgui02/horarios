<?php

namespace Umg\VotacionBundle\Model;

use Brown298\DataTablesBundle\MetaData as DataTable;
use Brown298\DataTablesBundle\Model\DataTable\QueryBuilderDataTableInterface;
use Brown298\DataTablesBundle\Test\DataTable\QueryBuilderDataTable;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Templating\EngineInterface;


/**
 * Class CatedraticoTable
 *
 * @package Umg\VotacionBundle\Model
 *
 * @DataTable\Table(id="catedraticoTable", displayLength=10)
 */
class CatedraticoTable extends QueryBuilderDataTable implements QueryBuilderDataTableInterface
{
    /**
     * @var string
     * @DataTable\Column(source="q.id", name="Código")
     * @DataTable\Format(dataFields={"id":"q.id","codigo":"q.Codigo"}, template="UmgVotacionBundle:Catedratico:nombre.html.twig")
     * @DataTable\DefaultSort()
     */
    public $id;
     
    /**
     * @var string
     * @DataTable\Column(source="q.Nombre", name="Nombre")
     * @DataTable\DefaultSort()
     */
    public $nombre;
    
    /**
     * @var int
     * @DataTable\Column(source="q.Codigo", name="Acciones")
     * @DataTable\Format(dataFields={"id":"q.id"}, template="UmgVotacionBundle:Catedratico:accionesindex.html.twig")
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
            ->getRepository('UmgVotacionBundle:Catedratico');
        $qb = $userRepository->createQueryBuilder('q')
            ;

        return $qb;
    }
     
}
