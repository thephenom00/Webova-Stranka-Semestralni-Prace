<?php
// TAKES DATA FROM DB
$users = file_get_contents("../core/users.json");
$users = json_decode($users, JSON_OBJECT_AS_ARRAY);

// STORES THE VALUE OF THE INPUT AKA USERNAME
$input = $_REQUEST["q"]; 

$userInDatabase = "";

if ($input !== "") {
  // IF THE DB IS NOT EMPTY, CHECK IT BY FOREACH
  if($users !== null){ 
    foreach($users as $user) {
      // IF THERE IS A MATCH, SAVE THE USERNAME
      if ($input === $user["username"]) {
        $userInDatabase = $user["username"];
        break;
      }
    }
  }
  
}

echo $userInDatabase === "" ? "" :"Uživatel ".$userInDatabase." již existuje 😔";
?>