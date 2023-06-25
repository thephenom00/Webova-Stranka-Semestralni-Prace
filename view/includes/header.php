<?php
require_once '../../config.php';
require_once '../../core/db.php';


session_start();

// IF USER HAS A UISER ID, GET THE USER
$uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : NULL;
if ($uid) {
    $user = getUserByUid($uid);
} else {
    header('Location: login.php');
}

// IF DB OF USERS IS EMPTY, REDIRECT TO LOGIN
if(filesize("../../core/users.json") == 0){
    header('Location: login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <?php require "../includes/style.php" ?>
    <link rel="stylesheet" href="../../static/css/stylePrint.css" media="print">
    <title>OneNote</title>
</head>

<body>
<?php require "nav.php"; ?>
