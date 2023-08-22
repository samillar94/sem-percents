<?php
/**
 * 
 */
function extractData($query)
{

  $extractedData = array(
    "items" => array(),
    "attendances" => array(),
    "availabilities" ==> array()
  );

  $count = count((array)$query);

  $hasNext = true;

  $i = $query['item_1'];
  $att = $query['attendance_1'];
  $av = $query['availability_1'];

  if (!isset($i) || !isset($att) || !isset($av)) {
    throw new Exception("Component attribute missing");
  }

  for ($nextID = 2; ($nextID <= $count/3 + 1 && $hasNext == true); $nextID++) {

    if (strlen($i) == 0) {
      throw new Exception("Unlabelled item");
    }

    $attFloat = floatval($att);
    $avFloat = floatval($av);

    if (is_nan($attFloat)) {
        throw new Exception("Non-numerical/blank attendance");
    }
    if (is_nan($avFloat)) {
        throw new Exception("Non-numerical/blank availability");
    }

    if ($attFloat < 0) {
        throw new Exception("Negative attendance");
    }
    if ($avFloat < 0) {
        throw new Exception("Negative availability");
    }

    if ($attFloat > $avFloat) {
        throw new Exception("Attendance larger than available");
    }

    $extractedData['items'][] = $i;
    $extractedData['attendances'][] = $attFloat;
    $extractedData['availabilities'][] = $avFloat;

    $i = $query["item_{$nextID}"];
    $att = $query["attendance_{$nextID}"];
    $av = $query["availability_{$nextID}"];

    if (!isset($i) && !isset($att) && !isset($av)) {
      $hasNext = false;
    } elseif (!isset($i) || !isset($att) || !isset($av)) {
      throw new Exception("Inconsistent counts of component attributes.");
    }

  } 

  return $extractedData;
}

function buildResponse($extractedData) {

  $resToFront = array(
		"error" => false,
		"percents" => array(),
		"lines" => array()
	);

  $sorted_attendance=getSortedAttendance($items, $attendances);

	$lines = array();

	for ($i = 0; $i < count($items); $i++) {
		$line = $items[$i].' - '.$attendances[$i];
		array_push($lines,$line);
	}

	$output['items']=$items;
	$output['attendance']=$attendances;
	$output['sorted_attendance']=$sorted_attendance;
	$output['lines']=$lines;

  return $resToFront
}