<?php
// zugang zum Code nur über den Login-Button 
if(isset($_POST['login-submit'])){
    //einbinden der Datenbankverbindung
    require 'database.intern.php';
    // Übername Formulardaten
    $username = $_POST['name_user'];
    $password = $_POST['password_user'];
    // Check, ob beide Felder ausgefüllt wurden
    if (empty($username) || empty($password)){
        header("location: ../index.php?error=emptyfield");
        exit();
    }
    // der Select ********
    else{
        $sql_select = "SELECT * FROM tb_users WHERE users_name=? OR users_email=?;";// Nutzer kann sowohl seinen Namen, als auch die Mailadresse angeben
        $statement = mysqli_stmt_init($db_connection);
        // SQL- Abfragencheck
        if (!mysqli_stmt_prepare($statement, $sql_select)){
            header("location: ../index.php?error=sql-error");
            exit();   
        }
        else {
            // "ss" - eingaben werden als Strings gewertet - NO SQL INJECTION
            mysqli_stmt_bind_param($statement, "ss", $username, $username); 
            mysqli_stmt_execute($statement);
            $result = mysqli_stmt_get_result($statement);
            if ($data_set = mysqli_fetch_assoc($result)){ // assoc macht die Einzeldaten der Zeile für PHP auslesbar
               // $password_check = password_verify($password, $row['users_password']);
                if ($data_set['users_password'] !== $password){ //derzeit noch ein PASSWORT IN KLARSCHRIFT in der Datenbank
                    header("location: ../index.php?error=wrongpassword");
                    exit();  
                }
                //erfolgreiche Verifizierung ->session wird gestartet 
                else {
                    session_start(); 
                    //übergabe einzelner Sessionparameter in sessioninterne Variablen
                    $_SESSION['session_userid'] = $data_set['pk_users_id'];
                    $_SESSION['session_username'] = $data_set['users_name'];
                    $_SESSION['session_useremail'] = $data_set['users_email'];
                    header("location: ../index.php?loginsucessfully");
                    exit();  
                }
           }//falls kein Nutzer gefunden wird
           else{
                header("location: ../index.php?error=nosuchuser");
                exit();   
           }
        }
    }
}
// Rauswurf beim Versuch des Direktzugriffs auf die Datei (siehe ganz oben)
else {
    header("location: ../index.php?pleaselogin");
    exit();
}