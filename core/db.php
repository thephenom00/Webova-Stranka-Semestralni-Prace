<?php
/////////////////////// ADD NOTE ///////////////////////

/**
 * ADD NOTE TO DATABASE
 * @param $title - TITLE OF NOTE
 * @param $date - DATE BY WHICH THE NOTE SHOULD BE COMPLETED
 * @param $importance - IMPORTANCE OF NOTE
 * @param $text - TEXT OF NOTE
 * @return void - RETURNS ERROR OR PUT FILES IN DATABASE
 */
function db_add_note($title, $date, $importance, $text) {   
    // GETS CONTENT OF JSON FILE
    $data = file_get_contents(DBFILE);
    $data = json_decode($data, JSON_OBJECT_AS_ARRAY);

    // IF ITS NULL RETURNS EMPTY ARRAY
    if (is_null($data)) {                                      
        $data = [];
    }

    // CREATES NEW NOTE
    $newNote = array(
        'id' => uniqid(),
        'title' => $title,
        'date' => $date,
        'importance' => $importance,
        'text' => $text,
        'currentDate' => date('d.m.Y'),
        'user' => $_SESSION['uid']  // EVERY USER HIS OWN NOTES
    );

    $data[] = $newNote;

    // SORTS DATA BY DATE
    usort($data, function($a, $b) {
        return strtotime($a['date']) - strtotime($b['date']);
    });

    // ENCODES DATA
    $encodedData = json_encode($data);

    // PUTS CONTENT INTO JSON
    file_put_contents(DBFILE, $encodedData); 

}


/**
 * GET ALL ITEMS
 * @return array|mixed - RETURNS ALL ITEMS IN DATABASE
 */
function db_get_all_items() {
    $data = file_get_contents(DBFILE);
    $data = json_decode($data, JSON_OBJECT_AS_ARRAY);

    if (is_null($data)) {
        return [];
      }else{
        return $data;
      }

    return $data;
}

/**
 * FILTERS DATA FROM ARRAY
 * @param $importance - IMPORTANCE OF THE NOTE
 * @return array - RETURN DATA WITH SPECIFIC IMPORTANCE
 */
function filterData($importance) {
    $data = file_get_contents(DBFILE);
    $data = json_decode($data, JSON_OBJECT_AS_ARRAY);

    if (is_null($data)) {
        return [];
    }

    $filteredData = [];

    // DULEZITE = "on" aka 1, NEDULEZITE = "null" aka 2, ALL IS 3
    if ($importance == 1){
        foreach ($data as $item) {                          
            if ($item['importance'] == "on" && $item['user'] == $_SESSION['uid']) {
              $filteredData[] = $item;
            }
          }
    }

    if ($importance == 2){
        foreach ($data as $item) {                          
            if ($item['importance'] == null && $item['user'] == $_SESSION['uid']) {
              $filteredData[] = $item;
            }
          }

    }
    
    if ($importance == 3){
        foreach ($data as $item) {                          
            if ($item['user'] == $_SESSION['uid']) {
              $filteredData[] = $item;
            }
          }
    }

    return $filteredData;
}


/**
 * GET NUMBER OF USERS NOTES
 * @return int - RETURNS A NUMBER
 */
function getNumberOfNotes(){
    $count = 0;
    $json = file_get_contents(DBFILE);
    $data = json_decode($json, true);

    foreach($data as $key => $noteArray){
        if($noteArray["user"] == $_SESSION['uid']){
            $count++;
        }
    }
    return $count;
}


/**
 * GET NOTES OF A SPECIFIC USER
 * @return array - USERS NOTES
 */
function getUsersNotes(){
    $json = file_get_contents(DBFILE);
    $data = json_decode($json, true);
    $notes = [];
    
    if (is_null($data)) {
        return [];
    }

    foreach($data as $key => $noteArray){
        if($noteArray["user"] == $_SESSION['uid']){
            $notes[] = $noteArray;
        }
    }
    return $notes;
}


/////////////////////// ADD USER ///////////////////////

/**
 * ADD USER TO DATABASE
 * @param $username - USERNAME
 * @param $email - EMAIL
 * @param $password - PASSWORD
 * @return string|void - RETURNS AN ERROR IF USER ALREADY IN DATABASE
 * @throws Exception
 */
function db_add_user($username, $email, $password) {

    // SALT FOR PASSWORD
    $salt = bin2hex(random_bytes(16));
    $users = array(
        'id' => uniqid(),
        'username' => $username,
        'email' => $email,
        'passwordHash' => password_hash($password.$salt.$email, PASSWORD_DEFAULT),
        'salt' => $salt,
        'theme' => "light"  // EVERY NEW USER HAS LIGHT THEME 
    );

    

    // IF ITS THE FIRST USER IN DATABASE
    if(filesize("../../core/users.json") == 0){          
        // $old_records is MEANT TO BE A NEW ARRAY
        $old_records = array($users);

    }else{
        // IF THERE ARE SOME USERS
        $old_records = json_decode(file_get_contents("../../core/users.json"), true);       
        $isInArray = false;
        $isEmailInArray = false;

        // IF USER OR EMAIL ALREADY IN DATABASE
        foreach($old_records as $old_array){
            if($username == $old_array["username"]){
                $isInArray = true;  
            }
            if($email == $old_array["email"]){
                $isEmailInArray = true;
            }
        }

        $erroror = '';
        if($isInArray == false && $isEmailInArray == false){
            array_push($old_records, $users);
        }else{
            
        // IF USER OR EMAIL IS IN DATABASE, MAKE AN ERROR
        if($isInArray == false && $isEmailInArray == true){
            $erroror = 'Email je již použit';
        }
        elseif($isInArray == true && $isEmailInArray == false){
            $erroror = 'Uživatelské jméno je již použito';
        }else{
            $erroror = 'Uživatelské jméno i email je již použit';
            }

            // ERROR AND END
            return $erroror;
        }
    }

    // ADDS NEW USER TO JSON FILE AND REDIRECT
    $data_to_save = $old_records;
    file_put_contents("../../core/users.json", json_encode($data_to_save, JSON_PRETTY_PRINT), LOCK_EX);
    header('Location: login.php');

}


/**
 * GET ALL USERS IN DATABASE
 * @return array|mixed - RETURNS ARRAY
 */
function getAllUsers(){
    $users = file_get_contents("../../core/users.json");
    $users = json_decode($users, JSON_OBJECT_AS_ARRAY);

    if (is_null($users)) {
        return [];
    } else {
        return $users;
    }
}

/**
 * GET AN USER FROM DATABASE
 * @param $username - USERNAME
 * @return array|mixed|null - RETURNS A SPECIFIC USER
 */
function getUserByUserName($username) {
    $users = file_get_contents("../../core/users.json");
    $users = json_decode($users, JSON_OBJECT_AS_ARRAY);

    if (is_null($users)) {
        return [];
    } else {

        // IF $USERNAME IS IN DATABASE
        foreach ($users as $user) {
            if($username == $user['username']) {
                return $user;
            }
        }
    
        return NULL;
    }

}

/**
 * GET A SPECIFIC USER BY ID
 * @param $uid - ID
 * @return array|mixed|null - RETURNS A SPECIFIC USER
 */
function getUserByUid($uid) {
    $users = file_get_contents("../../core/users.json");
    $users = json_decode($users, JSON_OBJECT_AS_ARRAY);

    if (is_null($users)) {
        return [];
    } else {
        // IF $UID IS IN DATABASE
        foreach ($users as $user) {
            if($uid == $user['id']) {
                return $user;
            }
        }
    
        return NULL;
    }


}

///////////////////////// MARK AS DONE + REMOVE /////////////////////////

/**
 * MARK A SPECIFIC NOTE AS DONE
 * @param $id - ID OF A NOTE
 * @return void
 */
function db_mark_as_done($id){
    $json = file_get_contents(DBFILE);
    $data = json_decode($json, true);

    // MARK THE ARRAY WITH SPECIFIC ID AS DONE
    foreach($data as $key => $noteArray){
        if($noteArray["id"] == $id){
            $data[$key]["done"] = true;
            break;
        }
    }

    $json = json_encode($data);
    file_put_contents(DBFILE, $json);
}

/**
 * REMOVE NOTE FROM DATABASE
 * @param $id - ID OF A NOTE
 * @return void
 */
function db_remove_note($id) {
    $json = file_get_contents(DBFILE);
    $data = json_decode($json, true);

    // REMOVE THE ARRAY WITH SPECIFIC ID
    foreach($data as $key => $noteArray){
        if($noteArray["id"] == $id){
            unset($data[$key]);
            break;
        }
    }

    $json = json_encode($data);
    file_put_contents(DBFILE, $json);
}



