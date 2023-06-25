<?php
    require '../../core/db.php';

    
    if (isset($_POST['login'])) {
        // SAVES THE VALUES INTO VARIABLES
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        if ($username && $password) {
            $user = getUserByUserName($username);
            if ($user) {
                if (password_verify($password.$user["salt"].$user["email"], $user['passwordHash'])) {
                    // START SESSION
                    session_start();

                    // SET THE USERS ID AND THEME (DEFAULT TO LIGHT)
                    $_SESSION['uid'] = $user['id'];
                    $_SESSION['css'] = $user['theme'];

                    header('Location: index.php');
                
                // SHOW ERRORS
                } else {
                  $error = 'Přihlašovací údaje nebyly zadány správně';  
                }
            } else {
                $error = 'Přihlašovací údaje nebyly zadány správně';
            }
        } else {
            $error = 'Přihlašovací údaje nebyly zadány správně';
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
    <title>Login</title>
</head>



<body>
    <?php require "../includes/logo.php" ?>
    <div id="boxLogin">
        <h1>Přihlásit se</h1>
        
    <form action="" method="post">
        
        <div class="username">
            <label for="user">Uživatelské jméno</label>
        </div>  
        <input type="text" name="username" id="user" class="field" autocomplete="off" placeholder="Uživatelské jméno" value="<?php if(isset($username)){echo $username;}?>">


        <div class="password">
            <label for="pass">Heslo</label>
        
        <input type="password" class="field" name="password" id="pass" placeholder="Heslo" value="<?php if(isset($password)){echo $password;}?>">
        </div>

            <input type="submit"  name="login" id="button" value="Přihlásit se">

        <div id="signup">
            Nemáte účet? <a href="register.php">Zaregistrujte se</a>
         </div>
        <?php
            if (isset($error)) {
                echo "<p class='loginError'>$error</p>";
            }
        ?>
    </form>
    </div>





</body>
</html>