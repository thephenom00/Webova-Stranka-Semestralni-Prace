 
    <nav>
    <div class="welcome">
    <label class="logo"><a href="../pages/index.php">📝</a></label>
    <label class='welcomee'>Vítej <?php if(isset($user) && !($user == null)){echo $user["username"];}?></label>
    </div>
    
    <ul>
        <!-- <li><a href="../pages/login.php">Login</a></li> -->
        <li><a href="../pages/index.php">Domů</a></li>
        <li><a href="../pages/list-notes.php">Poznámky</a></li>
        <li><a href="../pages/settings.php">Nastavení</a></li>
        <li><a href="../pages/logout.php">Odhlásit se</a></li>
    </ul>
    </nav>
