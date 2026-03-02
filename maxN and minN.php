<?php
//Verwenden Sie array_filter() und max(), um den Maximalwert in einem Array zu finden.
function maxN($numbers)
{
  $maxValue = max($numbers);
  $maxValueArray = array_filter($numbers, function ($value) use ($maxValue) {
    return $maxValue === $value;
  });

  return count($maxValueArray);
}

maxN([1, 2, 3, 4, 5, 5]); // 2
maxN([1, 2, 3, 4, 5]); // 1


//Verwenden Sie array_filter() und min(), um den Minimalwert in einem Array zu finden.

function minN($numbers)
{
  $minValue = min($numbers);
  $minValueArray = array_filter($numbers, function ($value) use ($minValue) {
    return $minValue === $value;
  });

  return count($minValueArray);
}

minN([1, 1, 2, 3, 4, 5, 5]); // 2
minN([1, 2, 3, 4, 5]); // 1