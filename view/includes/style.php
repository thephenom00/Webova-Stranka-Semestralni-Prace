<?php

// IF THE THEME IS CHOSEN, MAKE A SESSION
  if(isset($_POST['theme-mode'])){
    $_SESSION['css'] = $_POST['theme-mode'];
  }


// IF THERE IS A USER AND HAS A SESSION FOR THEME
if(isset($user) && !($user == null) && isset($_SESSION['css'])){
  if($_SESSION['css'] == "dark"){
    $json = file_get_contents("../../core/users.json");
      $data = json_decode($json, true);
  
      // SET THE THEME IN DATABASE FOR DARK
      foreach($data as $key => $userArray){
          if($userArray["id"] == $user['id']){
              $data[$key]["theme"] = "dark";
              break;
          }
      }
      
      // RETURN TO DB
      $json = json_encode($data);
      file_put_contents("../../core/users.json", $json);
    }
    else {
      // SET THE THEME IN DATABASE FOR LIGHT
      $json = file_get_contents("../../core/users.json");
      $data = json_decode($json, true);
  
      foreach($data as $key => $userArray){
          if($userArray["id"] == $user['id']){
              $data[$key]["theme"] = "light";
              break;
          }
      }

      // RETURN TO DB
      $json = json_encode($data);
      file_put_contents("../../core/users.json", $json);
    }
}
?>
  
<link rel="stylesheet" media="screen" href="../../static/css/style<?php if(isset($_SESSION['css']) && $_SESSION['css'] == "dark"){echo "DarkMode";}if(isset($_SESSION['css']) && $_SESSION['css'] == "light"){echo "";}else{echo "";}?>.css">


