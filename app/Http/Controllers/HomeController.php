<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HomeController extends Controller
{
  public function postCube(Request $request){
    if ($request->hasFile('file-input')) {
      $file = $request->file('file-input')->getPathName();

      $fh = fopen($file,'r');
       $test_cases = fgets($fh);
      $n=0;
      while($n<$test_cases){
        $line = explode(" ", fgets($fh));
        $size_matriz = trim($line[0]);

        $matriz = $this->createMatriz($size_matriz);
        $number_operations=trim($line[1]);

        $n++;
      }

      fclose($fh);
  dd("fin");
      // dd($request->file('file-input')->getPathName());
    }else{
      dd('no');
    }
  }





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
}
