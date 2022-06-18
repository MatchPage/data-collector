<?php
// Get all the matches from the api
function allMatches($issguid)
{
  // VBL api url to get matches
  $api_url = "https://vblcb.wisseq.eu/VBLCB_WebService/data/OrgMatchesByGuid?issguid=" . $issguid;
  // Get the data
  $data = file_get_contents($api_url);
  // Decode the data
  $data = json_decode($data, true);
  // Sort array by jsDTCode (Unix timestamp)
  $matchesSort = array();
  foreach ($data as $match) {
    foreach ($match as $key => $value) {
      if (!isset($matchesSort[$key])) {
        $matchesSort[$key] = array();
      }
      $matchesSort[$key][] = $value;
    }
  }

  // Sort array by jsDTCode (Unix timestamp)
  array_multisort($matchesSort["jsDTCode"], SORT_ASC, $matches);

  // Return the matches
  $returnArr = array();
  foreach ($matches as $match) {
    $returnArr[] = array(
      "homeTeamId" => $match["tTGUID"],
      "awayTeamId" => $match["tAGUID"],
      "homeTeamName" => $match["tTNaam"],
      "awayTeamName" => $match["tANaam"],
      "datetime" => substr($match["datumString"], 6, 4) . "-" . substr($match["datumString"], 3, 2) . "-" . substr($match["datumString"], 0, 2) . " " . substr($match["tijdString"], 0, 2) . ":" . substr($match["tijdString"], 2, 2),
      "date" => substr($match["datumString"], 6, 4) . "-" . substr($match["datumString"], 3, 2) . "-" . substr($match["datumString"], 0, 2),
      "time" => substr($match["tijdString"], 0, 2) . ":" . substr($match["tijdString"], 2, 2),
      "accomodation" => $match["accNaam"],
      "pool" => $match["pouleNaam"],
      "score" => $match["uitslag"],
    );
  }

  return $returnArr;
}

// Get only the matches that are not finished
function getNotFinished($club_id)
{
  // Get Unix timestamp of today
  $today = strtotime(date("Y-m-d H:i"));
  // Get the matches which are not finished
  $returnArr = array();
  foreach (allMatches($club_id) as $match) {
    // Turn date and time into a Unix timestamp
    $datetime = strtotime($match["date"] . " " . $match["time"]);
    // If the match is not finished yet, add it to the return array
    if ($datetime > $today) {
      $returnArr[] = $match;
    }
  }
}

// Get the matches that are finished
function getFinished($club_id)
{
  // Get Unix timestamp of today
  $today = strtotime(date("Y-m-d H:i"));
  // Get the matches which are not finished
  $returnArr = array();
  foreach (allMatches($club_id) as $match) {
    // Turn date and time into a Unix timestamp
    $datetime = strtotime($match["date"] . " " . $match["time"]);
    // If the match is not finished yet, add it to the return array
    if ($datetime < $today) {
      $returnArr[] = $match;
    }
  }
}
