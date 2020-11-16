<?php
session_start();
//nur wer von der index.php kommt bekommt Zugang zu den Funktionen dieser Seite (else steht ganz unten) 
if(isset($_POST['dateinput-submit'])) {
    //Datenbank einbinden
    require 'database.intern.php';
    // Daten aus dem Eingabefeld und SESSION werden übernommem
    $input_name = $_POST['subject_name'];
    $input_date = $_POST['subject_date'];
    $input_time = $_POST['subject_time'];
    $input_username = $_SESSION['session_username'];
    $input_userid = $_SESSION['session_userid'];
   
    // abfangen, falls es keine Zeiteingabe gab -> 8:30 ist statistisch in Deutschland die geburtenreichste Stunde / https://www.aerzteblatt.de/nachrichten/49618/Deutsche-Babys-kommen-meist-morgens-zur-Welt
    if ($input_time == ''){
        $input_time = '08:30';
    }

    // erstellen weiterer Variablen
    $input_datetime = $input_date." ".$input_time;

    // Checks BEVOR es an die Datenbank geht *********
    // Sind alle Felder ausgefüllt
    if (empty($input_name) || empty($input_date)) {
        header("Location: ../index.php?error=emptyfield&name=".$input_name."&datum=".$input_date);
        exit();
    }
    // semantisch gültiger Name
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $input_name)){
        header("Location: ../index.php?error=invalidname&name=".$input_name);
        exit();
    }
    
    // nun zur Datenbank **************************
    // einfügen der eingegebenen Werte in die tb_userdata
    else {
            $sql_insert ="INSERT INTO tb_userdates (fk_userdates_user_id, userdates_name, userdates_datetime) VALUES (?, ?, ?)"; 
            $preparedstatement = mysqli_stmt_init($db_connection);
            if(!mysqli_stmt_prepare($preparedstatement, $sql_insert)) {
                header("Location: ../index.php?error=sql-input-error");
                exit();
            }
            else {
            // hier endlich der insert
                mysqli_stmt_bind_param($preparedstatement,"sss", $input_userid, $input_name, $input_datetime);
                mysqli_stmt_execute($preparedstatement);
                header("Location: ../index.php?input=successful");
               //echo "datum: ".$input_date;
               //echo "zeit: ".$input_time;
               //echo "datezeit: ".$input_datetime;
            }
        }
    
    // Schließen der aufgemachten Verbindungen (das sollte mit mysqlI sowieso funktionieren - sicher ist sicher)
    mysqli_stmt_close($preparedstatement); 
    mysqli_stmt_close($prepared_statement);
    mysqli_close($db_connection);

}
// das else vom allerersten if
else {
    header("Location: ../index.php?");
    exit();
}

