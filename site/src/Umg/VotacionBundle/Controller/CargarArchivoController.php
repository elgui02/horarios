<?php
namespace Umg\VotacionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Ddeboer\DataImport\Reader\ExcelReader;
use Symfony\Component\HttpFoundation\Response;
use Umg\VotacionBundle\Entity\Carrera;
use Umg\VotacionBundle\Entity\Curso;
use Umg\VotacionBundle\Entity\Catedratico;
use Umg\VotacionBundle\Entity\PensumAnio;
use PHPExcel;
use PHPExcel_IOFactory;

class CargarArchivoController extends Controller
{
    public function indexAction()
    {
        return $this->render('UmgVotacionBundle:CargarArchivo:index.html.twig');
    }


/*    public function cursoAction()
    {
        return $this->render('UmgVotacionBundle:CargarArchivo:asignarcurso.html.twig');
        $cursopensum = new PensumAnio();
        $cursopensum->setPensumAnio('')
    }*/
    public function showAction(Request $request)
    {
      if($request->getMethod() == 'POST')
      {
          $archivo =$request->files->get('archivo');
          #$this->showAction($archivo);
      }

      $inputFileName=$archivo;
      //  Read your Excel workbook
              try {
                      $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                      $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                      $objPHPExcel = $objReader->load($inputFileName);
                  }
              catch (Exception $e)
                  {
                      die('Error al Cargar el Archivo "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                  }
      //  Get worksheet dimensions
                  $sheet = $objPHPExcel->getSheet(0);
                  $highestRow = $sheet->getHighestRow();
                  $highestColumn = $sheet->getHighestColumn();
      //  Loop through each row of the worksheet in turn
                  $file= array();
                  for ($row = 1; $row <= $highestRow; $row++)
                  {
      //  Read a row of data into an array
                 /*     echo "<table border=5><tr>";"*/
                      $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL, TRUE, FALSE);

                      foreach($rowData[0] as $k=>$v)
                    //echo "<td> fila".$row."- Col: ".($k+1)." = ".$v."<td/>";
                     // echo "<td>".$v."<td/>";
                    //  $matriz[$row][$k]=$v;
                      //echo ""<tr/> <table/>";

//Obtencion del Codigo de la Carrea
                      $data =$rowData[0];
                      if($row == 1)
                      {
                        $carrera[]=$data;
                        foreach($carrera[0] as $j=>$v)
                        if($j == 2)
                        {
                          $codigocarrera=$v;
                        }
                          $codecarrera=explode(' ',$codigocarrera);
                      }
//Obtencio del Codigo del Curso
                      if($row == 2)
                      {
                        $curso[]=$data;
                        foreach($curso[0] as $k=>$v)
                        if($k == 2)
                        {
                        $codigocurso=$v;
                        }
                          $codecurso=explode( ' ',$codigocurso );
                      }
//Obtencion del Codigo de Catedratico
                      if($row == 3)
                      {
                        $catedratico[]=$data;
                        foreach($catedratico[0] as $m=>$v)
                        if($m == 2)
                        {
                          $codigocatedratico=$v;
                        }
                        $codecatedratico=explode(' ',$codigocatedratico );
                      }
//Obtencion del Codigo de Alumnos
                      if($row > 5)
                      {
                        $file[]= $data;
                      }
                  }

                    $lista= $highestRow - 6;
                    for ($contalum = 0; $contalum <= $lista; $contalum++)
                    {
                      foreach($file[$contalum] as $m=>$v)
                      if($m == 1)
                      {
                        $codigoestudiante[]=$v;
                      }
                    }

                    for ($contalum = 0; $contalum <= $lista; $contalum++)
                    {
                      foreach($file[$contalum] as $m=>$v)
                      if($m == 2)
                      {
                        $nomestudiante[]=$v;
                      }
                    }
                      //var_dump($nomestudiante);
/*
Consulta de Carrera
*/
      //  $Carrera=1;
        $snc = $codecarrera[0];
        $em = $this->getDoctrine()->getManager();
        $carrera = $em->getRepository('UmgVotacionBundle:CampusCarrera')->findOneBy(array('Codigo'=>$snc));
/*
Consulta de Curso
*/
        $codcur = $codecurso[0];
        $curs = $em->getRepository('UmgVotacionBundle:PensumAnio')->findOneBy(array('Codigo'=> $codcur));
        $ResultCurso = 'Existente Valida';

/*
Consulta de Catedratico
*/
        $cc = explode(' - ',$catedratico[0][2]);
        $codcat = $codecatedratico[0];
//        var_dump($cc);
        $cat = $em->getRepository('UmgVotacionBundle:Catedratico')->findOneBy(array('Codigo'=>$codcat));
        $ResultCatedratico = 'Existente Valida';

        $catcur = $em->getRepository('UmgVotacionBundle:CatedraticoCurso')->findOneBy(array(
          'catedratico'=>$cat,
          'carreraCurso'=>$curs,
        ));
/*
Consultar de Codigos de alumnos que no estan creados
*/

for ($x = 0; $x<= $lista; $x++)
{
  $coda = $codigoestudiante[$x];
  $alum = $em->getRepository('UmgVotacionBundle:Alumno')->findOneBy(array('Carne'=> $coda));
  $varalum[]=$alum;
  $ResultAlumno = 'Existente Valida';
  if(!$alum)
  {
    $noalumno[]=$coda;
    //echo "estoy aca";
  }
}
    $contandoalumnos=count($noalumno);
    $cantalum=$contandoalumnos-1;
    //var_dump($cantalum);
/*
Consulta de Nombres de alumnos que no estan creados
*/

for ($x = 0; $x<= $lista; $x++)
{
  $nom = $nomestudiante[$x];
  $nomalum = $em->getRepository('UmgVotacionBundle:Alumno')->findOneBy(array('Nombre'=> $nom));
  $varalum[]=$alum;
  $ResultAlumno = 'Existente Valida';
  if(!$nomalum)
  {
    $nomnoalumno[]=$nom;
    //echo "estoy aca";
  }
}
//var_dump($nomnoalumno);
/*
Consulta de alumnos que si estan creados
*/
/*
        $codalum = $codigoestudiante;
        $consultab = 'select a from UmgVotacionBundle:Alumno a where a.Carne IN(:verifica)';
        $queryb = $em->createQuery($consultab);
        $queryb->setParameter('verifica', array_values($codalum));
        $alumnosumgno = $queryb->getResult();*/

        $codalum = $codigoestudiante;
      //  $consulta = 'select c.Nombre, c.Carne from UmgVotacionBundle:AlumnoCurso a JOIN a.alumno c JOIN a.carreraCurso car JOIN car.pensumAnio pen WHERE pen.Codigo!=:codigocurso AND c.Carne IN(:carne)';
        $consulta = 'SELECT a FROM UmgVotacionBundle:Alumno a INNER JOIN a.alumnoCursos c
                    INNER JOIN c.carreraCurso car
                    INNER JOIN car.pensumAnio pen
                    WHERE pen.Codigo!=:codigocurso
                    AND a.Carne IN(:carne)';
        $query = $em->createQuery($consulta);
        $query->setParameter('carne', array_values($codalum));
        $query->setParameter('codigocurso', $codcur);
        $alumnosumg = $query->getResult();

/*
consulta los que estan asginados al curso
*/
          $consulasignatura= 'SELECT c.Nombre, c.Carne FROM UmgVotacionBundle:AlumnoCurso a JOIN a.alumno c JOIN a.carreraCurso car JOIN car.pensumAnio pen WHERE c.Carne IN(:carne) AND pen.Codigo=:codigocurso ';
          $queryasignatura=$em->createQuery($consulasignatura);
          $queryasignatura->setParameter('carne',array_values($codalum));
          $queryasignatura->setParameter('codigocurso', $codcur);
          $noasigalumno =$queryasignatura->getResult();
        //var_dump($alumnosumg);

      return $this->render('UmgVotacionBundle:CargarArchivo:show.html.twig',array(
        'tabla'   => $file,
        'snc'     => $snc,
        'carrera' => $carrera,
        'curso'   => $curso[0],
        'docente' => $catedratico[0],
        'alumno' =>$file[0],
        'catedratico' => $cat,
        'curs' => $curs,
        'catcur' => $catcur,
        'alum' => $alum,
        'estudiante' => $codigoestudiante,
        'ResultCurso'=> $ResultCurso,
        'ResultCatedratico' => $ResultCatedratico,
        'ResultAlumno' => $ResultAlumno,
        'veralumno' => $alumnosumg,
        'noasigalumno' => $noasigalumno,
        'noalumno' => $noalumno,
        'nomnoalumno' => $nomnoalumno,
        'cantalum' => $cantalum,
      ));
    }
}
