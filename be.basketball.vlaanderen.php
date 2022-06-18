<?php
// Get all the matches from the api
function matches($issguid)
{
  // VBL api url to get matches
  $api_url = "https://vblcb.wisseq.eu/VBLCB_WebService/data/OrgMatchesByGuid?issguid=" . $issguid;
  // Get the data
  $data = file_get_contents($api_url);
  // Decode the data
  $data = json_decode($data, true);
  // Return the data
  return $data;
}

// Sort the matches by date
function sortByDate($matches)
{
  // Sort array by jsDTCode (Unix timestamp)
  $matchesSort = array();
  foreach ($matches as $match) {
    foreach ($match as $key => $value) {
      if (!isset($matchesSort[$key])) {
        $matchesSort[$key] = array();
      }
      $matchesSort[$key][] = $value;
    }
  }

  // Sort array by jsDTCode (Unix timestamp)
  array_multisort($matchesSort["jsDTCode"], SORT_ASC, $matches);
}

// Get only the matches that are not finished
function getNotFinished($matches)
{
  $newMatches = array();
  foreach ($matches as $match) {
    if ($match["jsDTCode"] > time()) {
      $newMatches[] = $match;
    }
  }

  return $newMatches;
}
