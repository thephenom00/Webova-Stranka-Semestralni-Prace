<?php
// ARRAY WITH ALL TASKS
$tasks = array("Jet", "Přijet", "Odjet", "Nastavit", "Postavit", "Žehlit", "Vyžehlit", "Běhat", "Posilovat", "Nakrmit", "Vyhodit", "Utřít", "Vařit", "Péct", "Hrát", "Ostříhat", "Osekat", "Připravit", "Shrabat", "Zamést", "Dezinfikovat", "Roztřídit", "Rozbít", "Malotvat", "Aktivovat", "Absorbovat", "Bavit", "Brát", "Čekat", "Couvat", "Cvičit", "Cestovat", "Dělat","Doplnit", "Dívat", "Dřít", "Existovat", "Eliminovat", "Experimentovat", "Flákat", "Fotografovat", "Flirtovat", "Generovat", "Googlit", "Hladovět", "Hladit", "Holit", "Informovat", "Investovat", "Implementovat", "Jednat", "Ječet", "Koupat", "Kojit", "Krmit", "Léčit", "Lepit", "Létat", "Masírovat", "Milovat", "Naplnit", "Opravit", "Ošetřit", "Rozhodnout", "Spravit", "Sázet", "Sedět", "Telefonovat", "Tisknout", "Transportovat", "Udělat", "Uvařit", "Uklidit","Ustlat", "Umýt", "Vyvenčit", "Vyprat", "Zabavit", "Zapojit", "Zničit");

// INPUT FROM USER
$input = $_REQUEST["q"];

$task_from_database = "";

if ($input !== "") {
  $len = strlen($input);
  foreach($tasks as $task) {
    if (stristr($input, substr($task, 0, $len))) {
      if ($task_from_database === "") {
        $task_from_database = $task;
      }else {
        $task_from_database .= ", $task";
      }
    }
  }
}

// SHOWS TASKS MATCHING WITH INPUT
echo $task_from_database === "" ? "" : "Máte na mysli ".$task_from_database."?";
?>