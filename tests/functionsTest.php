<?php

include("functions.inc.php");

$items = array("Lecture sessions","Lab sessions","Support sessions","Canvas activities");

$attendance_arrays = array(
    array("1","2","4","3"),
    array("4","22","0","22")
);

$outputs_expected = array(
    array(
        array(
          "item"=> "Support sessions",
          "attendance"=> "4"
        ),
        array(
          "item"=> "Canvas activities",
          "attendance"=> "3"
        ),
        array(
          "item"=> "Lab sessions",
          "attendance"=> "2"
        ),
        array(
          "item"=> "Lecture sessions",
          "attendance"=> "1"
        )
    ),
    array(
        array(
            "item"=> "Lab sessions",
            "attendance"=> "22"
        ),
        array(
            "item"=> "Canvas activities",
            "attendance"=> "22"
        ),
        array(
            "item"=> "Lecture sessions",
            "attendance"=> "4"
        ),
        array(
            "item"=> "Support sessions",
            "attendance"=> "0"
        )
    )
);

echo "Testing sort functions";

$testcount = 0;
$passedcount = 0;
$failedcount = 0;

for($i=0; $i<sizeof($attendance_arrays); $i++)
{
    $output_expected = $outputs_expected[$i];
    $testcount++;
    $output = getSortedAttendance($items, $attendance_arrays[$i]);
    echo "Testing input: \n".$attendance_arrays[$i]."\n\nExpected output: \n".$output_expected."\n\nFound: \n".$output."\n\n";
    if ($output_expected == $output)
    {
        echo "PASSED\n";
        $passedcount++;
    }
    else
    {
        echo "FAILED\n";
        $failedcount++;
    }
}

echo "Performed ".$testcount." test with ".$passedcount." passed and ".$failedcount." failed.\n";

if ($failedcount>0)
    exit(1);
exit(0);