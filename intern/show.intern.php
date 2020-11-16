<?php

session_start();
//nur wer von der index.php kommt bekommt Zugang zu den Funktionen dieser Seite (else steht ganz unten) 
if(isset($_POST['showall-submit'])) {
    //Datenbank einbinden
    require 'database.intern.php';
    // Daten aus der SESSION werden übernommem
    $userid = $_SESSION['session_userid'];

    $sql_show = "SELECT userdates_name, userdates_datetime FROM tb_userdates WHERE fk_userdates_user_id = '$userid';";
   
    $result_show = mysqli_query($db_connection, $sql_show);
    //$row_show = mysqli_fetch_assoc($result_show);
    //$SESSION['all_userdates_in_db']= $row_show; 
    if (mysqli_num_rows($result_show) > 0) {
        // eine Schleife um alle Daten auszugeben
        while($row = mysqli_fetch_assoc($result_show)) {
            echo "Name: " . $row["userdates_name"]. " - Geburtszeitpunkt: " . $row["userdates_datetime"]."<br>";
        }
    } else {
        echo "Noch sind keine Daten vorhanden - Wenn Du gerade welche eingetragen hast 'Alle eingetragenen Daten anzeigen' drücken.";
    }
    mysqli_close($db_connection);
?>
<form>
    <button type=link href="javascript:history.back()">Zurück</button> 
</form>
<?php
}
else{
    header("Location: ../index.php?");
    exit();
}
?>