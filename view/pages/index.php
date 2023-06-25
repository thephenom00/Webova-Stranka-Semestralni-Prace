<?php
    require "../includes/header.php";

    // TOKEN FOR CSRF
    if (!isset($_SESSION['token'])) {
        // SET TOKEN EXPIRATION TIME (1HOUR)
        $_SESSION['token'] = bin2hex(random_bytes(32));
    }

    // SET TOKEN FOR 1 HOUR
    $_SESSION['token_expiration'] = time() + 60*60;

    // ADDS NOTE TO DATABASE + DATE VALIDATION
    if (isset($_POST['addNote'])) {

        // IF THE TOKENS ARE SAME
        if(($_POST['inputToken'] == $_SESSION['token']) && ($_SESSION['token_expiration'] >= time())){
            $title = htmlspecialchars($_POST['title']);
            $date = $_POST['date'];

            if(isset($_POST['isImportant'])){
                $importance = $_POST['isImportant'];
            }else{
                $importance = null;
            }

            $text = htmlspecialchars($_POST['text']);

                // IF THE DATE WAS IN THE PAST, SHOW ERROR
                if(strtotime($date) + 60*60*24 >= time()){
                    db_add_note($title, $date, $importance, $text);
                    unset($_SESSION['token']);
                    header("Location: list-notes.php");
                }else{
                    $pastError = "Je nám líto, ale nemůžete cestovat do minulosti";
                }
            // IF THE TOKENS ARE NOT SAME
            }else{
                die("Token is invalid");
            }
        }


?>
 
    <div class='boxIndex'>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

            <!-- CSRF TOKEN -->
            <input type="hidden" name="inputToken" value="<?= $_SESSION['token']; ?>">

            <div class='make'><h1>Napsat poznámku</h1></div>
            <div class='container'>
                <div class='name'>
                    <label for="title">Název</label>
                    <input spellcheck="false" value="<?php if(isset($_POST["addNote"])){echo $_POST["title"];}?>" name="title" type="text" class="search" placeholder="Název" required autofocus>
                    <p id='sugg'><span id="suggestion"></span></p>
                </div>

                <label for="date">Datum</label>
                <input name="date" type="date" required autofocus>
                <?php
                if (isset($pastError)){
                    echo "<span class='timeTravel'>".$pastError."</span>";
                }
                ?>

                <label for="isImportant">Je to důležité? <span class='check'>*Nepovinné</span></label>
                <input type="checkbox" id="noteImportance" name="isImportant"
                <?php
                    // SAVE CHECK VALUE
                    if (isset($_POST["addNote"])){
                        if (isset($_POST["isImportant"])){
                            echo "checked";
                        }
                    }   else{
                        echo "";
                    }

                ?>
                />

                <div class='description'>
                    <label for="text">Popis</label>
                    <textarea name="text" cols="30" rows="10" placeholder='Popis Vaší poznámky' required><?php if(isset($_POST["addNote"])){echo $_POST["text"];}?></textarea>
                </div>
            </div>
            <input type="submit" name="addNote" value="Přidat" class="btn">
        </form>
    </div>
<?php require "../../view/includes/footer.php"; ?>
<script src="../../lib/suggestions.js"></script>

</body>

</html>