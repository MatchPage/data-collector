<?php
// Required get api header
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Required get api variables
if (!isset($_GET["data"])) {
  echo json_encode(array(
    "status" => 400,
    "error" => "No data file specified",
  ));
  exit();
}


if (!isset($_GET["function"])) {
  echo json_encode(array(
    "status" => 400,
    "error" => "No function specified",
  ));
  exit();
}

if (!isset($_GET["club_id"])) {
  echo json_encode(array(
    "status" => 400,
    "error" => "No club_id specified",
  ));
  exit();
}

// Check if the data file exists by reading the json file
// read the json file
$data = json_decode(file_get_contents("datalist.json"), true);
foreach ($data["data"] as $file) {
  if ($file["id"] == $_GET["data"]) {
    require_once "data/" . $file["id"] . ".php";
    continue;
  }

  echo json_encode(array(
    "status" => 400,
    "error" => "Data file not found",
  ));
}

// Check if the function exists
if ($_GET["function"] == "getNotFinished") {
  echo json_encode(getNotFinished($_GET["club_id"]));
} else if ($_GET["function"] == "getFinished") {
  echo json_encode(getFinished($_GET["club_id"]));
} else if ($_GET["function"] == "getTeams") {
  echo json_encode(getTeams($_GET["club_id"]));
} else {
  echo json_encode(array(
    "status" => 400,
    "error" => "Function not found",
  ));
}
