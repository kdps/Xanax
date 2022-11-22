<?php

namespace Xanax\Classes;

use RecursiveArrayIterator;

class ArrayObject {

  public function getKeys(array $array) {
    return array_keys($array);
  }

  public function getLastKey(array $array) {
    return array_key_last($array);
  }

  public function getFirstKey(array $array) {
    return array_key_first($array);
  }

  public function getAllValues(array $array) {
    return array_values($array);
  }

  public function Shuffle(array $array) {
    return shuffle($array);
  }

  public function SortByCaseInsensitiveNaturalOrderAlgorithm(array $array) {
    return natcasesort($array);
  }

  public function SortByNaturalOrderAlgorithm(array $array) {
    return natsort($array);
  }

  public function AssignValues(array $array) {
    return list($array);
  }

  public function SortByKeyInReverseOrder(array $array) {
    return krsort($array);
  }

  public function SortByKey(array $array) {
    return ksort($array);
  }

  public function FetchKey(array $array) {
    return key($array);
  }

  public function isKeyExists(array $array, $key) {
    return array_key_exists($array, $key);
  }

  public function getKeyByValue(array $array, string $key) {
    return array_search($key, $array);
  }

  public function getDepth(array $array) {
    $depth = 0;
    $arrayReclusive = new \RecursiveArrayIterator($array);
    $iteratorReclusive = new \RecursiveIteratorIterator($arrayReclusive);

    foreach ($iteratorReclusive as $iterator) {
        $currentDepth = $iterator->getDepth();

        $depth = $currentDepth > $depth ? $currentDepth : $depth;
    }

    return $depth;
  }

}
