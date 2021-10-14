<?php

  require_once('jpgraph/src/jpgraph.php');
  require_once('jpgraph/src/jpgraph_pie.php');

  $conexion =  mysqli_connect("...", "...", "...", "...");

  if (!$conexion){
    echo 'Error al conectar  a la base de datos';
  }
  else{

    // Variables de control
    $i=0;
    $contadorTipo=0;
    $contadorTipo3=0;

    // Variables de fecha
    $fechaActual = date('m-d-Y');
    $fechaActual = explode("-",$fechaActual);
    $mesActual = $fechaActual[0];
    $annioActual = $fechaActual[2];

    $sql = "select * FROM oculususuarios";
    $res = mysqli_query($conexion,$sql);

    $sentencias = array('INSERT', 'DELETE', 'UPDATE');

    $fechaP = $annioActual.'-'.$mesActual.'-01 00:00:01';
    $fechaU = $annioActual.'-'.$mesActual.'-31 23:59:59';

    for ($l3=0; $l3<3; $l3++){

      $fac='oculus'.$rol[0];

		  $sql3 = "select action from ... where action='".$sentencias[$l3]."' AND table_name='".$fac."' AND updated > '".$fechaP."' AND updated < '".$fechaU."'";

        $res3 = mysqli_query($conexion,$sql3);
          
        while($mostrar3=mysqli_fetch_array($res3)){
          $contadorTipo3++;
          /* Aqui estamos sumando los INSERT, DELETE y UPDATE en cada uno de sus indices,
			ya que es un array que maneja la variable sentencias */
          $biblioteca3[$l3] = $contadorTipo3;
      }

      $biblioteca3[$l3] = $contadorTipo3;
      $contadorTipo3=0;
    }

    $fechaPA = $annioActual.'-01-01 00:00:01';
    $fechaUA = $annioActual.'-12-31 23:59:59';

    for ($i=0; $i<3; $i++){

        $fac='oculus'.$rol[0];
        $sql2 = "select action from ... where action='".$sentencias[$i]."' AND table_name='".$fac."' AND updated > '".$fechaPA."' AND updated < '".$fechaUA."'";
        $res = mysqli_query($conexion,$sql2);
          
        while($mostrar=mysqli_fetch_array($res)){
          $contadorTipo++;  

          $biblioteca[$i] = $contadorTipo;
      }

      $biblioteca[$i] = $contadorTipo;
      $contadorTipo=0;
    }

    echo "<p>Se han publicado ".$biblioteca3[0]." noticias este mes.</p>";
    echo "<p>Se han publicado ".$biblioteca[0]." noticias este año.</p>";
  }

?>