<?php require "../includes/header.php" ?>
  <form method="post">
    <select class='mode' name="theme-mode">
      <option value="light" <?php if (isset($_SESSION['css']) && $_SESSION['css'] == 'light') echo 'selected'; ?>>Light mode</option>
      <option value="dark" <?php if (isset($_SESSION['css']) && $_SESSION['css'] == 'dark') echo 'selected'; ?>>Dark mode</option>
    </select>
    <button class='modeButton' type="submit">Aplikovat</button>
  </form>
  <?php require "../../view/includes/footer.php"; ?>
</body>


</html>




