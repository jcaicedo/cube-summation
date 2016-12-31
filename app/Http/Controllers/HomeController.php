<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HomeController extends Controller
{

  public function postCube(Request $request){

    $results=[];
    if ($request->hasFile('file-input')) {
      $file = $request->file('file-input')->getPathName();

      $fh = fopen($file,'r');
      $test_cases = trim(fgets($fh)) ;
      $n=0;
      while($n<$test_cases){
        echo "test: ".$n."<br>";
        $line = $this->clearLine(fgets($fh));
        $size_matriz = $line[0];
        $number_operations=$line[1];
        $matriz = $this->createMatriz($size_matriz);

        echo "size_matriz: ".$size_matriz." number_operations: ".$number_operations."<br>";
        for ($i = 0; $i < $number_operations ; $i++) {
          $line = $this->clearLine(fgets($fh));
          switch ($line[0]) {
            case 'UPDATE':
            $matriz[$line[1]][$line[2]][$line[3]]=(int)$line[4];
            echo "update: ".$matriz[$line[1]][$line[2]][$line[3]]."<br>";
            break;
            case 'QUERY':
            $results[]=$this->cubeSummation($line,$matriz);
            break;

            default:
            # code...
            break;
          }
        }

        $n++;
      }

      fclose($fh);
      dd($results);
      // dd($request->file('file-input')->getPathName());
    }else{
      dd('no');
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
