<?php

class Array
{
  public function getDepth(array $array)
  {
    $depth = 0;
    $arrayReclusive = new RecursiveArrayIterator($array);
    $iteratorReclusive = new RecursiveIteratorIterator($arrayReclusive);

    foreach ($iteratorReclusive as $iterator) {
        $currentDepth = $reclusive->getDepth();
      
        $depth = $currentDepth > $depth ? $currentDepth : $depth;
    }

    return $depth;
  }
}
