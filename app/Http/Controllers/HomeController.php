<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HomeController extends Controller
{

  public function postCube(Request $request){


    $error=[];
    $data =[];
    $results=[];
    $input = [];
    $n=0;

    if ($request->hasFile('file-input')) {
      $file = $request->file('file-input')->getPathName();

      $fh = fopen($file,'r');
      $line=fgets($fh);
      $input[]=$line;
      $test_cases = (int)trim($line) ; //numero de casos

      if ((1<=$test_cases)&&($test_cases<=50)) {
        while($n<$test_cases){
          $line=fgets($fh);
          $input[]=$line;
          $line = $this->clearLine($line);
          if (!feof($fh)) {
            $size_matriz = (int)$line[0]; //tamaño de la matriz
            $number_operations=(int)$line[1]; //numero de operaciones
            $matriz = $this->createMatriz($size_matriz);

            if ((1<=$size_matriz)&&($size_matriz<=100)) {
              if((1<=$number_operations)&&($number_operations<=1000)){

                for ($r=0; $r < $number_operations ; $r++) {
                  $line=fgets($fh);
                  $input[]=$line;
                  $line = $this->clearLine($line);  //clear line


                  switch ($line[0]) {

                    case 'UPDATE':
                    if ((1<=$line[1])&&(1<=$line[2])&&(1<=$line[3])&&($line[1]<=$size_matriz)&&($line[2]<=$size_matriz)&&($line[3]<=$size_matriz)&&(pow(-10, 9)<=$line[4])&&($line[4]<=pow(10, 9))) {
                      $matriz[$line[1]][$line[2]][$line[3]]=(int)$line[4];
                    }else{
                      $error[]="Error en UPDATE ".$r." de la iteración: ".($n+1).", donde 1 <= x,y,z <= N y -10^9 <= W <= 10^9 ";
                    }

                    break;

                    case 'QUERY':

                    if ((1>(int)$line[1]) || ((int)$line[1]>(int)$line[4]) || ((int)$line[4]>$size_matriz)) {
                      $error[] = "Los valores para x en la iteracion ".($n+1)." de la operación ".($r+1)." de  ".$line[0]." debe cumplie con 1<=x1<=x2<=N";

                    }else{
                      if ((1>(int)$line[2]) || ((int)$line[2]>(int)$line[5]) || ((int)$line[5]>$size_matriz)) {
                        $error[] = "Los valores para y en la iteracion ".($n+1)." de la operación ".($r+1)." de  ".$line[0]." debe cumplie con 1<=y1<=y2<=N";

                      }else{
                        if ((1>(int)$line[3]) || ((int)$line[3]>(int)$line[6]) || ((int)$line[6]>$size_matriz)) {
                          $error[] = "Los valores para z en la iteracion ".($n+1)." de la operación ".($r+1)." de ".$line[0]." debe cumplie con 1<=z1<=z2<=N";

                        }else{

                          $results[]=$this->cubeSummation($line,$matriz);
                        }
                      }
                    }


                    break;

                  }
                }

              }else{
                $error[]="El valor de M debe ser 1<=M<=1000 en la iteracion #".($n+1);
              }
            }else{
              $error[]="El valor de N debe ser 1<=N<=100 en la iteracion #".($n+1);
            }
            $n++;
          }else{
            $error[]="No concuerda el valor de T con la cantidad de casos";
            break;
          }

        }
      }else{
        $error[]="El valor de T debe ser 1<=T<=50";
      }

      fclose($fh);
      $data['errors']=$error;
      $data['inputs']=$input;
      $data['results']=$results;
      return $data;
    }else{
      $data['errors']= $error[]="no existe data o el formato de archivo no es correcto";
      $data['inputs']= $input;
      return $data;
    }
  }

  //Descomposicion de la linea de archivo
  public function clearLine($line){
    $line = explode(" ", $line);
    foreach ($line as $key => $value) {
      $line[$key]=trim($value);

    }
    return $line;
  }

  //creacion de nueva matriz
  public function createMatriz($size){
    $matriz = [];
    for ($x=1; $x < $size+1 ; $x++) {
      for ($y = 1; $y < $size+1 ; $y++) {
        for ($z = 1; $z < $size+1 ; $z++) {
          $matriz[$x][$y][$z]=0;
        }
      }
    }
    return $matriz;
  }

  //sumatoria de la matriz de matriz
  public function cubeSummation($line,$matriz=[]){
    $summation = 0;
    for ($x = $line[1]; $x < $line[4]+1; $x++) {
      for ($y = $line[2]; $y < $line[5]+1 ; $y++) {
        for ($z = $line[3]; $z < $line[6]+1; $z++) {
          $summation = $summation + $matriz[$x][$y][$z];
        }
      }
    }
    return $summation;
  }


}
