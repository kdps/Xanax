<?php

class RangeSort
{
    public function Sort(array $array)
    {
        $count = count($array);

        for ($i = 0; $i < $count; $i++) {
            for ($j = 0; $j < $count; $j++) {
                if ($array[$i] < $array[$j]) {
                    $tmp = $array[$j];
                    $array[$j] = $array[$i];
                    $array[$i] = $tmp;
                }

                if ($array[$i] > $array[$count - 1]) {
                    $tmp = $array[$count - 1];
                    $array[$count - 1] = $array[$i];
                    $array[$i] = $tmp;
                }
            }
        }

        return $array;
    }
}
