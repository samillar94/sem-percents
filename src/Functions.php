<?php
namespace App;
error_reporting(E_ALL);

class Functions {
  public function extractData($query)
  {

    $extractedData = array(
      "items" => array(),
      "attendances" => array(),
      "availabilities" => array()
    );

    $count = count((array)$query);

    $hasNext = true;

    if (!array_key_exists("item_1", $query) || !array_key_exists("attendance_1", $query) || !array_key_exists("availability_1", $query)) {
      throw new \Exception("Component attribute missing");
    };

    $i = $query['item_1'];
    $att = $query['attendance_1'];
    $av = $query['availability_1'];

    for ($nextID = 2; ($nextID <= $count/3 + 1 && $hasNext == true); $nextID++) {

      if (strlen($i) == 0) {
        throw new \Exception("Unlabelled item");
      };

      $attFloat = floatval($att);
      $avFloat = floatval($av);

      if ($attFloat === 0.0 && !($att === "0" || $att === "0.0")) {
        throw new \Exception("Non-numerical/blank attendance");
      };
      if ($avFloat === 0.0 && !($av === "0" || $av=== "0.0")) {
        throw new \Exception("Non-numerical/blank availability");
      };

      if ($attFloat < 0) {
          throw new \Exception("Negative attendance");
      };
      if ($avFloat <= 0) {
          throw new \Exception("Negative or zero availability");
      };

      if ($attFloat > $avFloat) {
          throw new \Exception("Attendance larger than available");
      };

      $extractedData['items'][] = $i;
      $extractedData['attendances'][] = $attFloat;
      $extractedData['availabilities'][] = $avFloat;

      if (!array_key_exists("item_{$nextID}", $query) && !array_key_exists("attendance_{$nextID}", $query) && !array_key_exists("availability_{$nextID}", $query)) {

        $hasNext = false;

      } elseif (!array_key_exists("item_{$nextID}", $query) || !array_key_exists("attendance_{$nextID}", $query) || !array_key_exists("availability_{$nextID}", $query)) {

        throw new \Exception("Inconsistent counts of component attributes");

      } else {

        $i = $query["item_{$nextID}"];
        $att = $query["attendance_{$nextID}"];
        $av = $query["availability_{$nextID}"];     

      };

    };

    return $extractedData;
  }

  public function buildResults($extractedData) {

    try {
      $results = array(
        "error" => false,
        "data" => array(
          "percents" => array(),
        ),
        "lines" => array()
      );

      for ($index = 0; $index < count($extractedData['items']); $index++) {
        
        $item = $extractedData['items'][$index];
        $attendance = $extractedData['attendances'][$index];
        $availability = $extractedData['availabilities'][$index];

        $percent = (100*$attendance/$availability);
        $results['data']['percents'][] = $percent;

        $line = $item.': '.round($percent).'% attendance';
        $results['lines'][] = $line;

      };
    } catch (Exception $e) {
      $results = array(
        "error" => true,
        "message" => $e
      );
    }

    return $results;
  }
};
?>