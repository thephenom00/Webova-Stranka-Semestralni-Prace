<?php
    // LOADS ALL THE FUNCTIONS
    require "../../lib/validate.php";
    require "../../core/db.php";

    $formIsSent = isset($_POST['reg']);
    
    if ($formIsSent) {
        // SAVE THE DATA FROM THE FORM
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['pass1']);
        $password2 = htmlspecialchars($_POST['pass2']);

        // VALIDATE THE DATA
        $validName = validateName($username);
        $validEmail = validateEmail($email);
        $validPasswords = validatePasswords($password,$password2);

        // IF ITS ALL VALID, ADD TO DATABASE
        if ($validName && $validPasswords && $validEmail) {
            $erroror = db_add_user($username, $email, $password);
        
        // SHOW ERROR
        } else {
            if(!$validName){
                $errorUsername = "Uživatelské jméno není validní";
            }
            if(!$validPasswords){
                $errorPassword1 = "Heslo není v pořádku";
            }
            if(!$validEmail){
                $errorEmail = "Email není validní";
            }

        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require "../includes/style.php"?>
    <link rel="stylesheet" href="../../static/css/stylePrint.css" media="print">
    <script src="../../lib/validate.js"></script>
    <title>Register</title>
</head>
<body>
<?php require "../includes/logo.php" ?>

<!-- RULES FOR THE FORM -->
    <div class="rules">
        <ul>
            <span><li>Uživaletské jméno</li></span>
            <li>musí mít alespoň 5 znaků</li>
            <li>nesmí obsahovat mezery</li>
            <li>smí obsahovat pouze písmena a čísla</li>
            <span class='rulesEmail'><li>Email</li></span>
            <li>musí být validní</li>
            <li>nesmí obsahovat speciální znaky</li>
        </ul>
    </div>


    <div id="boxRegister">
        <h1>Registrace</h1>
        
    <form action="" method="post" class="regForm">


        <div class="int" id="intUsername">
        <label for="user">Vytvořte uživatelské jméno</label>
        <input type="text" class="field" name="username" id="user" autocomplete="off" <?php if (isset($_POST['username'])){echo "value='$username'";} ?> pattern="[A-Za-z0-9]{5,}">
        
        <?php
            if (isset($errorUsername)) {
                echo "<span class='error'><p>$errorUsername</p></span>";
            }
        ?>
        </div>



        <div class="int" id="intEmail">
        <label for="email">Email</label>
        <input type="text" class="field" name="email" id="email" autocomplete="off" <?php if (isset($_POST['email'])){echo "value='$email'";}?> pattern="^(?=.{6,})(?=.*[A-Za-z0-9@.])(?=.*[@.])[A-Za-z0-9@.]+$">
        <?php
            if (isset($errorEmail)) {
                echo "<span class='error'><p>$errorEmail</p></span>"; 
            }
        ?>
        </div>





        <div class="int" id="intPassword1">
        <label for="pass">Heslo</label>
        <input type="password" class="field" name="pass1" id="pass" autocomplete="off" pattern=".{4,}">
        <?php
            if (isset($errorPassword1)) {
                echo "<span class='error'><p>$errorPassword1</p></span>";
            }
        ?>
        </div>


        
        <div class="int" id="intPassword2">
        <label for="confirmpass">Potvrďte heslo</label>
        <input type="password" class="field" name="pass2" id="confirmpass" autocomplete="off">
        <span id="sameUser"></span>
        </div>

        <input type="submit" id="buttonRegister" name="reg" value="Vytvořte účet">

        <?php
            if (isset($erroror)) {
                echo "<span class='error' id='errorUserEmail'><p>$erroror</p></span>";
            }
        ?>
        <span class="accountAlready">Již máte účet? <a href="login.php">Přihlašte se</a></span>

    </form>
    </div>
    
<script>
init();
</script>
</body>
</html>