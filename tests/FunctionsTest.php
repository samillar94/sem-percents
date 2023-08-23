<?php
use PHPUnit\Framework\TestCase;

$extractDataSuites = array(
    /// Some translated from js to PHP by GPT-3.5
    "valid" => array(
        array(
            array(
                'item_1' => "Lecture sessions",
                'item_2' => "Lab sessions",
                'item_3' => "Support sessions",
                'item_4' => "Canvas activities",
                'attendance_1' => 0,
                'attendance_2' => 1,
                'attendance_3' => 10,
                'attendance_4' => 55,
                'availability_1' => 33,
                'availability_2' => 22,
                'availability_3' => 44,
                'availability_4' => 55,
            ),
            array(
                "items" => array("Lecture sessions","Lab sessions","Support sessions","Canvas activities"),
                "attendances" => array(0,1,10,55),
                "availabilities" => array(33,22,44,55)   
            )
        ),
        array(
            array(
                'foo' => "bar",
                'item_1' => "Lectures",
                'item_2' => "Labs",
                'item_3' => "Support",
                'item_4' => "Canvas",                
                'attendance_1' => 4,
                'attendance_2' => 22.5,
                'attendance_3' => 0,
                'attendance_4' => 50,
                'availability_1' => 60,
                'availability_2' => 60,
                'availability_3' => 60,
                'availability_4' => 60,
            ),
            array(
                "items" => array("Lectures","Labs","Support","Canvas"),
                'attendances' => array(4, 22.5, 0, 50),
                'availabilities' => array(60, 60, 60, 60),
            )
        ),
        array(
            array(
                'item_1' => "Lectures",
                'item_2' => "Labs",
                'attendance_1' => 4,
                'attendance_2' => 22,
                'availability_1' => 60,
                'availability_2' => 60,
            ),
            array(
                "items" => array("Lectures","Labs"),
                'attendances' => array(4, 22),
                'availabilities' => array(60, 60),
            )
        )

    ),
    'diffCounts' => array(
        array(
            array(
                'item_1' => "Lectures",
                'item_2' => "Labs",
                'item_3' => "Support",
                'item_4' => "Canvas",                
                'attendance_1' => 0,
                'attendance_2' => 1,
                'availability_1' => 33,
                'availability_2' => 22,
                'availability_3' => 44,
                'availability_4' => 9
            )
        ),
        array(
            array(
                'item_1' => "Lectures",
                'item_2' => "Labs",
                'item_3' => "Support",
                'item_4' => "Canvas",                
                'attendance_1' => 0,
                'attendance_2' => 1,
                'attendance_3' => 10,
                'attendance_4' => 55,
                'availability_1' => 33,
                'availability_2' => 22,
                'availability_3' => 44
            )
        ),
        array(
            array(
                'item_1' => "Lectures",            
                'attendance_1' => 0,
                'attendance_2' => 1,
                'attendance_3' => 10,
                'attendance_4' => 55,
                'availability_1' => 33,
                'availability_2' => 22,
                'availability_3' => 44,
                'availability_4' => 55
            )
        ),
        array(
            array(
                'item_1' => "Lectures",
                'item_2' => "Labs",
                'item_3' => "Support",
                'item_4' => "Canvas",                
                'attendance_1' => 0,
                'attendance_2' => 1,
                'attendance_3' => 10,
                'attendance_4' => 55
            )
        )
    )      

)

class FunctionsTest extends TestCase {
    public function testExtractData() {

        $functions = new Functions();

        foreach ($extractDataSuites['valid'] as $case) {
            $actual = $functions->extractData($case['input']),
            $this->assertEqualSets($case['expected'], $actual);
        }

        foreach ($extractDataSuites['diffCounts'] as $case) {
            $this->expectException(Exception::class);
            $actual = $functions->extractData($case['input']),
        }

    }
};

?>