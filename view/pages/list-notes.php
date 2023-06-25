<?php
    require "../includes/header.php";
    
    // CHECK IF IMPORTANCE FILTER IS SET
    if (isset($_POST['importanceFilter'])) {
      // SET VARIABLE TO NULL
      $isImportant = null;
      $import = $_POST['importanceFilter'];

      // IF THE IMPORATNCE IS DULEZITE, VARIABLE IS SET TO 1
      if ($import == "Důležité"){
        $isImportant = 1;
      }

      // IF THE IMPORATNCE IS NEDULEZITE, VARIABLE IS SET TO 2
      if ($import == "Nedůležité"){
        $isImportant = 2;
      }
      
      // IF IT IS SET TO ALL, VARIABLE IS SET TO 3
      if ($import == "All") {
        $isImportant = 3;
      }
      
      $usersItems = filterData($isImportant);
    } else {
      // IF THE IMPORTANCE IS NOT SET, SHOW ALL USERS ITEMS
      $usersItems = getUsersNotes();
      
    }

    // IF USER HAS DATA SHOW PAGINATION
    if($usersItems != 0){
      $total_items = count($usersItems);
      
      if (isset($_POST['page_num'])){
        $page_num = $_POST['page_num'];
      }else{
        $page_num = 1;
      }
      
      $items_per_page = 8;
  
      $num_pages = ceil($total_items / $items_per_page);
  
      // HOW MANY HAS TO SKIP
      $offset = ($page_num - 1) * $items_per_page; 
  
      // GET ALL ITEMS ON A PAGE
      $page_items = array_slice($usersItems, $offset, $items_per_page);
    }
?>


  <div class="filterWrapper">
    <form method="post" action="" class="importanceForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="importanceFilter" class="importanceLabel">Filter pro důležitost:</label>
            <select name="importanceFilter" id="importanceFilter" onchange="this.form.submit()">
                <option value="All">Vše</option>
                <option value="Důležité" <?php if(isset($import)){if($import == "Důležité"){echo'selected="selected"';}}?>>Důležité
              </option>
                <option value="Nedůležité" <?php if(isset($import)){if($import == "Nedůležité"){echo'selected="selected"';}}?>>Nedůležité</option>
            </select>
    </form>
  </div>



<!-- IF USER HAS NO DATA SHOW IMG -->
<?php if ($total_items == 0) { ?>
  
<div class="noData">
<p>Bohužel zde nevidím žádné poznámky</p>
<img src="../../static/img/meme-crying.gif" alt="">
</div>

<?php } ?>


<!-- SHOWS ITEMS ON A PAGE -->
<ul class='wrapper'> 

<?php foreach($page_items as $item) : if($item['user'] == $_SESSION['uid']):?>
    <li class="note <?php if(in_array("done",$item)){echo "done";} ?>"> 
        <div class="details">
            <p><?= $item['title']."<span class='currentDate'>".$item['currentDate']."</span>"?></p>
            <p class ="importance">
              <?php 
                if ($item['importance'] != null) {
                  echo "Důležité\n";
                } else {
                  echo "Nedůležité\n";
                } 
              ?>
            </p>
            <div class="border"></div>
            <span><?= $item['text'] ?></span>
        </div>
        <div class="bottom-content">
            <span>Do: <?= date('d.m.Y', strtotime($item['date'])) ?></span>

            <form method="post">
            <button name="doneButton" value='<?= $item['id'] ?>' type="submit">✅</button>
            </form>
            <?php
                if(isset($_POST['doneButton'])){
                    db_mark_as_done($_POST['doneButton']);
                    header("Location: list-notes.php");
                }
            ?>


            <form method="post" >
            <button value="<?= $item['id'] ?>" name="deleteButton" type="submit">🗑️</button>
            </form>
            <?php
                if(isset($_POST['deleteButton'])){
                    db_remove_note($_POST['deleteButton']);
                    header("Location: list-notes.php");
                }
            ?>
            
        </div>

    </li>
<?php endif; endforeach; ?>
</ul>



<!-- IF USER HAS NO DATA WILL NOT SHOW PAGIATION -->
<?php if ($total_items != 0){  ?>
<form method="post" action="" class="pagiation">
  <input type="hidden" name="importanceFilter" value="<?php if(isset($_POST['importanceFilter'] )){ echo htmlspecialchars($_POST['importanceFilter']);} else {echo "All";} ?>" />

  <label for="page_num">Select page:</label>
  <select name="page_num" id="page_num" onchange="this.form.submit()">
    <?php for ($i = 1; $i <= $num_pages; $i++) : ?>
      <option value="<?php echo $i; ?>" <?php if ( $page_num == $i ) { echo 'selected'; } ?>><?php echo $i; ?></option>
    <?php endfor; ?>
  </select>
</form>
<?php
}
?>



</body>

</html>


