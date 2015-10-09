<?php

namespace Umg\VotacionBundle\Model;

use Brown298\DataTablesBundle\MetaData as DataTable;
use Brown298\DataTablesBundle\Model\DataTable\QueryBuilderDataTableInterface;
use Brown298\DataTablesBundle\Test\DataTable\QueryBuilderDataTable;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Templating\EngineInterface;


/**
 * Class AlumnoTable
 *
 * @package Umg\VotacionBundle\Model
 *
 * @DataTable\Table(id="alumnoTable", displayLength=10)
 */
class AlumnoTable extends QueryBuilderDataTable implements QueryBuilderDataTableInterface
{
    /**
     * @var string
     * @DataTable\Column(source="q.id", name="Carne")
     * @DataTable\Format(dataFields={"id":"q.id","codigo":"q.Carne"}, template="UmgVotacionBundle:Alumno:nombre.html.twig")
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
     * @var string
     * @DataTable\Column(source="q.Usuario", name="Usuario")
     * @DataTable\Format(dataFields={"id":"q.id","usuario":"q.Usuario"}, template="UmgVotacionBundle:Alumno:usuario.html.twig")
     * @DataTable\DefaultSort()
     */
    public $usuario;

    /**
     * @var int
     * @DataTable\Column(source="q.Codigo", name="Acciones")
     * @DataTable\Format(dataFields={"id":"q.id"}, template="UmgVotacionBundle:Alumno:accionesindex.html.twig")
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
            ->getRepository('UmgVotacionBundle:Alumno');
        $qb = $userRepository->createQueryBuilder('q')
            ;

        return $qb;
    }
     
}
