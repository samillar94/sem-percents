<?php
use App\Functions;
// use \Exception;
use PHPUnit\Framework\TestCase;
// include '../src/Functions.php';

class FunctionsTest extends TestCase {

    public function provideExtractDataValid() {
        return [
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
        ];
    }

    public function provideExtractDataDiffCounts() {
        return [
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
        ];
    }

    public function provideBuildResultsValid() {
        return [
            [
                array(
                    "items" => array("Lecture sessions","Lab sessions","Support sessions","Canvas activities"),
                    "attendances" => array(0,1,10,55),
                    "availabilities" => array(33,22,44,55)   
                ),
                array(
                    "error" => false,
                    "data" => array(
                        "percents" => [0,4.545454545454546,22.727272727272727,100], 
                    ),
                    "lines" => [
                        'Canvas activities: 100% attendance',
                        'Lab sessions: 5% attendance',
                        'Lecture sessions: 0% attendance',
                        'Support sessions: 23% attendance'
                    ]
                )
            ],
            [
                array(
                    "items" => array("Lectures","Labs","Support","Canvas"),
                    'attendances' => array(4, 22.5, 0, 50),
                    'availabilities' => array(60, 60, 60, 60),
                ),
                array(
                    "error" => false,
                    "data" => array(
                        "percents" => [6.666666666666667,37.5,0,83.33333333333333],
                    ),
                    "lines" => [
                        'Canvas: 83% attendance',
                        'Labs: 38% attendance',
                        'Lectures: 7% attendance',
                        'Support: 0% attendance'
                    ]
                )
            ],
            [
                array(
                    "items" => array("Lectures","Labs"),
                    'attendances' => array(4, 22),
                    'availabilities' => array(60, 60),
                ),
                array(
                    "error" => false,
                    "data" => array(
                        "percents" => [6.666666666666667,36.666666666666664],
                    ),
                    "lines" => [
                        'Labs: 37% attendance',
                        'Lectures: 7% attendance'
                    ]
                )
            ]
        ];
    }

    /**
     * @dataProvider provideExtractDataValid
     */
    public function testExtractDataValid($inputArray, $expectedArray) {

        $functions = new Functions();

        $actual = $functions->extractData($inputArray);
        $this->assertEqualsCanonicalizing($expectedArray, $actual);

    }

    /**
     * @dataProvider provideExtractDataDiffCounts
     */
    public function testExtractDataDiffCounts($inputArray) {

        $functions = new Functions();

        $this->expectException(\Exception::class);
        $actual = $functions->extractData($inputArray);

    }

    /**
     * @dataProvider provideBuildResultsValid
     */
    public function testBuildResultsValid($inputArray, $expectedArray) {

        $functions = new Functions();

        $actual = $functions->BuildResults($inputArray);
        echo print_r($actual, true);
        $this->assertEqualsCanonicalizing($expectedArray, $actual);

    }
};

?>