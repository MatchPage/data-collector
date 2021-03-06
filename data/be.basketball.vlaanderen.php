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
  array_multisort($matchesSort["jsDTCode"], SORT_ASC, $data);

  // Return the matches
  $returnArr = array();
  foreach ($data as $match) {
    $returnArr[] = array(
      "homeTeamId" => $match["tTGUID"],
      "awayTeamId" => $match["tUGUID"],
      "homeTeamName" => $match["tTNaam"],
      "awayTeamName" => $match["tUNaam"],
      "homeTeamLogo" => "https://vbl.wisseq.eu/vbldataOrganisation/" . substr($match["tTGUID"], 0, 8) . "_Small.jpg",
      "awayTeamLogo" => "https://vbl.wisseq.eu/vbldataOrganisation/" . substr($match["tUGUID"], 0, 8) . "_Small.jpg",
      "datetime" => substr($match["datumString"], 6, 4) . "-" . substr($match["datumString"], 3, 2) . "-" . substr($match["datumString"], 0, 2) . " " . substr($match["beginTijd"], 0, 2) . ":" . substr($match["beginTijd"], 2, 2),
      "date" => substr($match["datumString"], 6, 4) . "-" . substr($match["datumString"], 3, 2) . "-" . substr($match["datumString"], 0, 2),
      "time" => substr($match["beginTijd"], 0, 2) . ":" . substr($match["beginTijd"], 3, 2),
      "accomodation" => $match["accNaam"],
      "competition" => $match["pouleNaam"],
      "score" => $match["uitslag"],
    );
  }

  return $returnArr;
}

// Get only the matches that are not finished
function getNotFinished($club_id)
{
  // Get Unix timestamp of today
  $today = strtotime(date("Y-m-d H:i:s"));
  // Get the matches which are not finished
  $returnArr = array();
  foreach (allMatches($club_id) as $match) {
    // Turn date and time into a Unix timestamp
    $date = strtotime($match["datetime"]);
    $date = date("Y-m-d H:i", $date);
    $date = strtotime($date);
    // If the match is not finished yet, add it to the return array
    if ($date < $today) {
      $returnArr[] = $match;
    }
  }

  return $returnArr;
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
    $date = strtotime($match["datetime"]);
    $date = date("Y-m-d H:i", $date);
    $date = strtotime($date);
    // If the match is not finished yet, add it to the return array
    if ($date > $today) {
      $returnArr[] = $match;
    }
  }

  return $returnArr;
}

// Get a list of all the teams
function getTeams($issguid)
{
  // VBL api url to get teams
  $api_url = "https://vblcb.wisseq.eu/VBLCB_WebService/data/OrgDetailByGuid?issguid=" . $issguid;
  // Get the data
  $data = file_get_contents($api_url);
  // Decode the data
  $data = json_decode($data, true);

  // Return the teams
  $returnArr = array();
  foreach ($data[0]["teams"] as $team) {
    $competitions = array();
    foreach ($team["poules"] as $competition) {
      $competitions[] = array(
        "name" => $competition["naam"],
        "id" => $competition["guid"],
      );
    }
    $returnArr[] = array(
      "id" => $team["guid"],
      "name" => $team["naam"],
      "competitions" => $competitions,
    );
  }

  return $returnArr;
}
