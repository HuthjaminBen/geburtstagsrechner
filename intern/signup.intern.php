<?php
//nur wer von der signup.php kommt bekommt Zugang zu den Funktionen dieser Seite (else steht ganz unten) 
if(isset($_POST['signup-submit'])) {
    //Datenbank einbinden
    require 'database.intern.php';
    // Daten aus der signup php werden übernommem
    $username = $_POST['name_user'];
    $email = $_POST['mail_user'];
    $password = $_POST['pwd_user'];
    $password_2 = $_POST['pwd_user_2'];
    // Erzeugen weiterer Variablen
    $tablename = "tb_userdata_".$username;
    // Diverse Checks BEVOR es an die Datenbank geht *********
    // Sind alle Felder ausgefüllt
    if (empty($username) || empty($email) || empty($password) || empty($password_2)) {
        header("Location: ../signup.php?error=emptyfield&name_user=".$username."&mail_user=".$email);
        exit();
    }
    // semantisch gültige Emailadresse UND gültiger Name (als Letztes, aus Kombination der beiden Nachfolgenden erstellt)
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)&&!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header("Location: ../signup.php?error=invalidusernameandpassword");
    }
    // semantisch gültiger Benutzername
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        header("Location: ../signup.php?error=invalidusername&mail_user=".$email);
        exit();
    }
    // semantisch gültige Mailadresse
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header("Location: ../signup.php?error=invalidmailadress&name_user=".$username);
        exit();
    }
    // stimmen die beiden Passworte überein
    else if ($password_2 !== $password) {
        header("Location: ../signup.php?error=missmatchpasswords&name_user=".$username."&mail_user=".$email);
        exit();
    }
    // nun arbeit in der Datenbank *****************
    // Check ob der SELECT überhaupt in der Datenbank laufen wird
    else {
        $sql_select ="SELECT users_name FROM tb_users WHERE users_name=?";
        $prepared_statement = mysqli_stmt_init($db_connection);
        if(!mysqli_stmt_prepare($prepared_statement, $sql_select)) {
            header("Location: ../signup.php?error=sql-error");
            exit();
        }
        // Abgleich der Nutereingegebenen Daten in SQL
        else{
            mysqli_stmt_bind_param($prepared_statement,"s", $username); 
            // das "s" sorgt dafür, dass die Einabe als String gewertet wird - Schutz gegen SQL-injectons 
            mysqli_stmt_execute($prepared_statement);
            mysqli_stmt_store_result($prepared_statement);
            $check = mysqli_stmt_num_rows($prepared_statement);
            //gibt die Anzahl der abgefragten Zeilen aus
            if ($check > 0) {
                header("Location: ../signup.php?error=usernametaken&mail_user=".$email);
                exit();
            }
//Nutzer eintragen ****
            // nochmaliger SQL-check: läuft der Insert mit den Userdaten
            else {
                $sql_insert ="INSERT INTO tb_users (users_name, users_email, users_password) VALUES (?, ?, ?)"; 
                $preparedstatement = mysqli_stmt_init($db_connection);
                if(!mysqli_stmt_prepare($preparedstatement, $sql_insert)) {
                    header("Location: ../signup.php?error=sql-error");
                    exit();
                }
                else {
                // hier endlich der insert
                    mysqli_stmt_bind_param($preparedstatement,"sss", $username, $email, $password);
                    mysqli_stmt_execute($preparedstatement);
                    header("Location: ../index.php?signup=successful");
                }
            }
        }
        // Schließen der aufgemachten Verbindungen (das sollte mit mysqlI sowieso funktionieren - sicher ist sicher)
        mysqli_stmt_close($preparedstatement); 
        mysqli_stmt_close($prepared_statement);
        mysqli_close($db_connection);
        }
    }

// das else vom allerersten if
else {
    header("Location: ../signup.php?");
    exit();
}

