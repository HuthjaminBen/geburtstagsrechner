<?php

session_start();
//nur wer von der index.php kommt bekommt Zugang zu den Funktionen dieser Seite (else steht ganz unten) 
if(isset($_POST['addup-submit'])) {
    //Datenbank einbinden
    require 'database.intern.php';
    // Daten aus der SESSION werden übernommem
    $userid = $_SESSION['session_userid'];
    // Weitere Variablen
    $now = date_create();
    $now = date_timestamp_get($now); // das ist der UNIX-Timestamp(Sekunden sei 1.1.1970) vom Zeitpunkt der Abfrage
    $sql_show = "SELECT userdates_name, userdates_datetime FROM tb_userdates WHERE fk_userdates_user_id = '$userid';";
   
    $result_show = mysqli_query($db_connection, $sql_show);
    $calculated_UNIX_date_sek;
    $UNIX_start_date;
    $UNIX_age_sek;
    $UNIX_age_min;
    $UNIX_sek_remainder; 
    $UNIX_age_hrs;
    $UNIX_min_remainder;
    $UNIX_age_day;
    $UNIX_hrs_remainder;
    $UNIX_age_week;
    $UNIX_days_remainder;
    $UNIX_age_month;
    $UNIX_age_year;

// SQL- Variablen können innerhalb von Funktionen nur existieren, wenn sie explizit an diese übergeben werden. 
// Auch die errechneten Werte ind außerhalb der FKT nur zugänglich wenn sie ausgegeben wurden.
// Daher wird für den Datenaustausch der folgenden FKT das Array UNIX_age_results erzeugt.
// es enthält in dieser Reihenfolge folgende Werte:
// $UNIX_age_sek, $UNIX_age_min, $UNIX_sek_remainder, $UNIX_age_hrs, $UNIX_min_remainder, $UNIX_age_day, $UNIX_hrs_remainder,
// $UNIX_age_week, $UNIX_days_remainder, $UNIX_age_month, $UNIX_age_year;


    // Funktion Berechnungen 
    function simple_calculate ($now, $UNIX_start_date){

        $UNIX_age_sek = $now-$UNIX_start_date; 
        $UNIX_age_min = floor($UNIX_age_sek/60);
        $UNIX_sek_remainder = $UNIX_age_sek % 60; 
        $UNIX_age_hrs = floor($UNIX_age_sek/60/60);
        $UNIX_min_remainder = floor(($UNIX_age_sek / 60) %60);
        $UNIX_age_day = floor($UNIX_age_sek/3600/24);
        $UNIX_hrs_remainder = floor(($UNIX_age_sek / 3600) %24);
        $UNIX_age_week = floor($UNIX_age_sek/86400/7);
        $UNIX_days_remainder = floor(($UNIX_age_sek / 86400) %7);
        $UNIX_age_month = floor($UNIX_age_sek/86400/30.4375);
        $UNIX_age_year = floor($UNIX_age_sek/86400/365.25);
        $UNIX_age_results = array($UNIX_age_sek, $UNIX_age_min, $UNIX_sek_remainder, $UNIX_age_hrs, $UNIX_min_remainder, $UNIX_age_day, $UNIX_hrs_remainder, $UNIX_age_week, $UNIX_days_remainder, $UNIX_age_month, $UNIX_age_year);
        return $UNIX_age_results;
    }

    // Funktion Ausgaben
    function simple_output ($name, $UNIX_age_results) {
        $UNIX_age_sek = $UNIX_age_results[0]; 
        $UNIX_age_min = $UNIX_age_results[1]; 
        $UNIX_sek_remainder = $UNIX_age_results[2]; 
        $UNIX_age_hrs = $UNIX_age_results[3]; 
        $UNIX_min_remainder = $UNIX_age_results[4]; 
        $UNIX_age_day = $UNIX_age_results[5]; 
        $UNIX_hrs_remainder = $UNIX_age_results[6]; 
        $UNIX_age_week = $UNIX_age_results[7]; 
        $UNIX_days_remainder = $UNIX_age_results[8]; 
        $UNIX_age_month = $UNIX_age_results[9]; 
        $UNIX_age_year = $UNIX_age_results[10]; 

        echo "<b>Name: ".$name."</b><br>";
        echo "- <b>Gesamtalter jeweils in</b><br> 
            Sekunden: ".$UNIX_age_sek."<br>
            Minuten: ".$UNIX_age_min." (und ".$UNIX_sek_remainder." Sekunden)<br>
            Stunden: ".$UNIX_age_hrs." (und ".$UNIX_min_remainder." Minuten)<br>
            Tagen: ".$UNIX_age_day." (und ".$UNIX_hrs_remainder." Stunden)<br>
            Wochen: ".$UNIX_age_week." (und ".$UNIX_days_remainder." Tage)<br>
        <b>also genau:</b> ".floor($UNIX_age_week)." Wochen, ".$UNIX_days_remainder." Tage, ".$UNIX_hrs_remainder." Stunden, ".$UNIX_min_remainder." Minuten und ".$UNIX_sek_remainder." Sekunden. <br><br> ";
        // echo "zwischengrößen".$UNIX_age_month."  ".$UNIX_age_year;
    }

    if (mysqli_num_rows($result_show) > 0) {
        // eine Schleife um alle Daten auszugeben
        while($row = mysqli_fetch_assoc($result_show)) {
            // der UNIX-Timestamp wird für die nächsten Berechnungen als Grundlage benutzt.
            // Aus der Datenbank wird ein Datetime-formatierter String abgerufen und umgewandelt.
            $UNIX_start_date=strtotime($row["userdates_datetime"]);
            $name=$row["userdates_name"];
            $result=simple_calculate($now,$UNIX_start_date);
            simple_output ($name, $result);

            $calculated_UNIX_date_sek = $calculated_UNIX_date_sek + $UNIX_age_sek;
            
        }
    
        $UNIX_start_date = $calculated_UNIX_date_sek;
        $name = "zusammen";
        $result=simple_calculate($now,$UNIX_start_date);
        simple_output ($name, $result);

         
           








        
        
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