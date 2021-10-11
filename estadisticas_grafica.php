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

    if( isset($_GET["selector-annio"]) && isset($_GET["selector-mes"]) ){
      $annioP = $_GET["selector-annio"];
      $mesP = $_GET["selector-mes"];

      $fechaP = $annioP.'-'.$mesP.'-01 00:00:01';
      $fechaU = $annioP.'-'.$mesP.'-31 23:59:59';

      for ($l3=0; $l3<3; $l3++){
        for($j3=0; $j3<count($nombreRol); $j3++){
          $nameBib3 = 'oculus'.$nombreRol[$j3];

          $sql3 = "select action from ... where action='".$sentencias[$l3]."' AND table_name='".$nameBib3."' AND updated > '".$fechaP."' AND updated < '".$fechaU."'";
          $res3 = mysqli_query($conexion,$sql3);
          $tipo[$j3]=0;
          
          while($mostrar3=mysqli_fetch_array($res3)){
            $contadorTipo3++;  
            $tipo[$j3]=$contadorTipo3;
            $biblioteca3[$l3][$j3] = $contadorTipo3;
          }

          $biblioteca3[$l3][$j3] = $contadorTipo3;
          $contadorTipo3=0;
        }
      }

      // Esto lo vamos a necesitar
      if(array_sum($biblioteca3[0]) == 0 && array_sum($biblioteca3[1]) && array_sum($biblioteca3[2])){
        echo "VACIO";
      }

    }
    else{
      
      if( isset($_GET["selector-annio"]) ){
        // Existe año, ponemos el mes actual

        $annioP = $_GET["selector-annio"];
        $mesP = $mesActual;

        $fechaP = $annioP.'-'.$mesP.'-01 00:00:01';
        $fechaU = $annioP.'-'.$mesP.'-31 23:59:59';

        for ($l3=0; $l3<3; $l3++){
          for($j3=0; $j3<count($nombreRol); $j3++){
            $nameBib3 = 'oculus'.$nombreRol[$j3];

            $sql3 = "select action from ... where action='".$sentencias[$l3]."' AND table_name='".$nameBib3."' AND updated > '".$fechaP."' AND updated < '".$fechaU."'";
            $res3 = mysqli_query($conexion,$sql3);
            $tipo[$j3]=0;
            
            while($mostrar3=mysqli_fetch_array($res3)){
              $contadorTipo3++;  
              $tipo[$j3]=$contadorTipo3;
              $biblioteca3[$l3][$j3] = $contadorTipo3;
            }

            $biblioteca3[$l3][$j3] = $contadorTipo3;
            $contadorTipo3=0;
          }
        }

      }
      elseif ( isset($_GET["selector-mes"]) ){
        // Existe mes, ponemos el año actual

        $annioP = $annioActual;
        $mesP = $_GET["selector-mes"];

        $fechaP = $annioP.'-'.$mesP.'-01 00:00:01';
        $fechaU = $annioP.'-'.$mesP.'-31 23:59:59';
        
        echo $fechaP."<br>";
        echo $fechaU."<br>";

        for ($l3=0; $l3<3; $l3++){
          for($j3=0; $j3<count($nombreRol); $j3++){
            $nameBib3 = 'oculus'.$nombreRol[$j3];

            $sql3 = "select action from ... where action='".$sentencias[$l3]."' AND table_name='".$nameBib3."' AND updated > '".$fechaP."' AND updated < '".$fechaU."'";
            $res3 = mysqli_query($conexion,$sql3);
            $tipo[$j3]=0;
            
            while($mostrar3=mysqli_fetch_array($res3)){
              $contadorTipo3++;  
              $tipo[$j3]=$contadorTipo3;
              $biblioteca3[$l3][$j3] = $contadorTipo3;
            }

            $biblioteca3[$l3][$j3] = $contadorTipo3;
            $contadorTipo3=0;
          }
        }

      }
      else{
        // No existe ninguna peticion GET, mostramos año y mes actual

        $annioP = $annioActual;
        $mesP = $mesActual;

        $fechaP = $annioP.'-'.$mesP.'-01 00:00:01';
        $fechaU = $annioP.'-'.$mesP.'-31 23:59:59';

        for ($l3=0; $l3<3; $l3++){
          for($j3=0; $j3<count($nombreRol); $j3++){
            $nameBib3 = 'oculus'.$nombreRol[$j3];

            $sql3 = "select action from ... where action='".$sentencias[$l3]."' AND table_name='".$nameBib3."' AND updated > '".$fechaP."' AND updated < '".$fechaU."'";
            $res3 = mysqli_query($conexion,$sql3);
            $tipo[$j3]=0;
            
            while($mostrar3=mysqli_fetch_array($res3)){
              $contadorTipo3++;  
              $tipo[$j3]=$contadorTipo3;
              $biblioteca3[$l3][$j3] = $contadorTipo3;
            }

            $biblioteca3[$l3][$j3] = $contadorTipo3;
            $contadorTipo3=0;
          }
        }

      }

    }
  }

  creaGrafico($biblioteca3, $nombreRol);
  
  function creaGrafico($biblioteca3, $nombreRol){

    $insertBibliotecas = array();

    // Esto lo vamos a necesitar
    if( array_sum($biblioteca3[0]) != 0 || array_sum($biblioteca3[1]) != 0 || array_sum($biblioteca3[2]) != 0 ){
        for($jj=0; $jj<count($nombreRol); $jj++){
            array_push($insertBibliotecas, $biblioteca3[0][$jj]);
          }

          $graph = new PieGraph(450,350);
          $graph->SetShadow();
          
          $size=0.4;
          $p1 = new PiePlot($insertBibliotecas);
          $graph->Add($p1);
          $p1->SetSize($size);
          $p1->SetCenter(0.4,0.5);
          $p1->SetLegends($nombreRol);
          $graph->legend->SetPos(0.0005,0.0001,'right','top');
          $graph->legend->SetColumns(1);
          $graph->legend->SetFont(FF_FONT1,FS_NORMAL);
          //$p1->SetSliceColors(array('#696D38','#D2D57C','#606E11','#2F350E','#324495','#6776B9','#98A7EA','#DC983C','#A46713','#543407','#540C07','#BF2F26','#C83372','#B42FC6','#8B5792','#634786','#AFF5D7','#8FDC83','#5EEBAF','#8A8A8A','#CECCCF'));
          $p1->SetTheme("earth");
          $graph->img->SetTransparent("white");
          $graph->Stroke();
    }
    else{
      echo "No hay datos para mostrar";
    }

  }

?>