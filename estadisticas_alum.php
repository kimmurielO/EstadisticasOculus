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

    $sql = "select * FROM ...";
    $res = mysqli_query($conexion,$sql);
        
    // Contamos cuántos roles hay.
    while($mostrar=mysqli_fetch_array($res)){
      $nombreRol[$i]=$mostrar['rol'];
      $i++;
    }

    // Recorrer nombre Rol
    for($m=0; $m<count($nombreRol); $m++){
      if($nombreRol[$m] == "admin" || $nombreRol[$m] == "TEST"){
        /* Eliminamos admin que no es una biblioteca y reorganizamos los indices del array. Volvemos a comenzar el bucle para no saltarnos ninguno ya que
        hemos cambiado la longitud del array.*/
        unset($nombreRol[$m]);
        $nombreRol = array_values($nombreRol);
        $m=-1;
      }
    }

    // Aqui vamos a quitar duplicados y luego reorganizamos los indices
    $nombreRol = array_unique($nombreRol);
    $nombreRol = array_values($nombreRol);

    $sentencias = array('INSERT', 'DELETE', 'UPDATE');

    $fechaP = $annioActual.'-'.$mesActual.'-01 00:00:01';
    $fechaU = $annioActual.'-'.$mesActual.'-31 23:59:59';

    for ($l3=0; $l3<3; $l3++){
      for($j3=0; $j3<count($nombreRol); $j3++){
        $nameBib3 = 'oculus'.$nombreRol[$j3];

        $sql3 = "select action from logs where action='".$sentencias[$l3]."' AND table_name='".$nameBib3."' AND updated > '".$fechaP."' AND updated < '".$fechaU."'";
        $res3 = mysqli_query($conexion,$sql3);
          
        while($mostrar3=mysqli_fetch_array($res3)){
          $contadorTipo3++;  

          $biblioteca3[$l3] = $contadorTipo3;
        }
      }

      $biblioteca3[$l3] = $contadorTipo3;
      $contadorTipo3=0;
    }

    $fechaPA = $annioActual.'-01-01 00:00:01';
    $fechaUA = $annioActual.'-12-31 23:59:59';

    for ($i=0; $i<3; $i++){
      for($j3=0; $j3<count($nombreRol); $j3++){
        $nameBib3 = 'oculus'.$nombreRol[$j3];

        $sql2 = "select action from logs where action='".$sentencias[$i]."' AND table_name='".$nameBib3."' AND updated > '".$fechaPA."' AND updated < '".$fechaUA."'";
        $res = mysqli_query($conexion,$sql2);
          
        while($mostrar=mysqli_fetch_array($res)){
          $contadorTipo++;  

          $biblioteca[$i] = $contadorTipo;
        }
      }

      $biblioteca[$i] = $contadorTipo;
      $contadorTipo=0;
    }

    echo "<p>Se han publicado ".$biblioteca3[0]." noticias este mes.</p>";
    echo "<p>Se han publicado ".$biblioteca[0]." noticias este año.</p>";
    
  }

?>