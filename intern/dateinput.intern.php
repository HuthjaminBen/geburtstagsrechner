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
    // erstellen weiterer Variablen
    $input_datetime = $input_date.$input_time;
    $tablename = "tb_".$input_userid."_userdates_".$input_username;

    // abfangen, falls es keine Zeiteingabe gab -> 8:30 ist statistisch in Deutschland die geburtenreichste Stunde / https://www.aerzteblatt.de/nachrichten/49618/Deutsche-Babys-kommen-meist-morgens-zur-Welt
    if ($input_time == ''){
        $input_time = '08:30';
    }

    // Diverse Checks BEVOR es an die Datenbank geht *********
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
    // erstellen einer Tabelle, so diese noch nicht existiert und einfügen der eingegebenen Werte
    else {
        $sql_tablework ="CREATE TABLE IF NOT EXISTS ".$tablename." (
                        pk_userdates_id int AUTO_INCREMENT NOT NULL PRIMARY KEY;
                        fk_userdates_user int FOREIGN KEY REFERENCES tb_users(pk_users_id);
                        userdates_name varchar(255);
                        userdates_datetime datetime;
                        )
                        INSERT INTO ".$tablename." (fk_users_user, userdates_name, userdates_datetime)
                        VALUES (?, ?, ?);";
        $prepared_statement = mysqli_stmt_init($db_connection);
        if(!mysqli_stmt_prepare($prepared_statement, $sql_tablework)) {
            header("Location: ../index.php?error=sql-error");
            exit();
        }
        // Eingabe der Nutzereingegebenen Daten in SQL
        else{
            mysqli_stmt_bind_param($prepared_statement,"sss", $input_userid, $input_name, $input_datetime); 
            // die "s" sorgen dafür, dass die Eingaben als String gewertet werden - Schutz gegen SQL-injectons 
            mysqli_stmt_execute($prepared_statement);
            header("Location: ../index.php?datainsert=successful");
        }
        // Schließen der aufgemachten Verbindungen (das sollte mit mysqlI sowieso funktionieren - sicher ist sicher)
        mysqli_stmt_close($prepared_statement);
        mysqli_close($db_connection);
    }
}
// das else vom allerersten if
else {
    header("Location: ../index.php?");
    exit();
}

