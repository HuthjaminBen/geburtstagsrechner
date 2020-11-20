<?php

session_start();
?>
<head>
    <link href="../css/style.css" type="text/css" rel="stylesheet" />
    <link rel="icon" href="../favicon.ico" type="image/png" />
    <!--<script src="js/jquery.min.js" type="text/javascript"></script>
    <script src="js/javascript.js" type="text/javascript"></script>-->
    <title>Geburtstagsrechner - ein Ausbildungsprojekt</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="title" content="IT Benjamin Huth" />
    <meta name="author" content="Benjamin Huth" />
</head>
<?php
require "../header.php";
?>
<main>
    <article>
        <section>
            <h1>Ergebnisse der Geburtstagsberechnung</h1>
            <div class="flexcontainer">
<?php        
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
    $result = 0;
    $result_show = mysqli_query($db_connection, $sql_show);
   
// SQL- Variablen können innerhalb von Funktionen nur existieren, wenn sie explizit an diese übergeben werden. 
// Auch die errechneten Werte ind außerhalb der FKT nur zugänglich wenn sie ausgegeben wurden.

    // Funktion Berechnungen & Output
    function simple_calculate_output ($now,$name,$UNIX_start_date,$UNIX_age_sek,$calculated_UNIX_age){
        //einfache Berechnungen durch Division der UNIX-Timestamp-Sekunden
        $UNIX_age_min = floor($UNIX_age_sek/60);                // =Minuten
        $UNIX_sek_remainder = $UNIX_age_sek % 60;               // =restliche Sekunden
        $UNIX_age_hrs = floor($UNIX_age_sek/60/60);             // =Stunden
        $UNIX_min_remainder = floor(($UNIX_age_sek / 60) %60);  // =restliche Minuten
        $UNIX_age_day = floor($UNIX_age_sek/3600/24);           // =Tage
        $UNIX_hrs_remainder = floor(($UNIX_age_sek / 3600) %24);// =restliche Stunden
        $UNIX_age_week = floor($UNIX_age_sek/86400/7);          // =Wochen
        $UNIX_days_remainder = floor(($UNIX_age_sek / 86400) %7);//=restliche Tage
        $UNIX_age_month = floor($UNIX_age_sek/86400/30.4375);   // =Monate
        $UNIX_month_check = floor(($UNIX_age_sek/86400)%30.4375);//=restliche Tage
        $UNIX_week_remainder = floor($UNIX_month_check/7);      // =restliche Wochen
        $UNIX_age_year = floor($UNIX_age_sek/86400/365.25);     // =Jahre
        $UNIX_year_check = floor(($UNIX_age_sek/86400)%365.25); // =restliche Tage
        $UNIX_month_remainder = floor($UNIX_year_check/30.4375);// =restliche Monate
        
       

        // Addition der Alter
        $calculated_UNIX_age_for_output = $calculated_UNIX_age + $UNIX_age_sek;
        // die Ausgabe
        echo '<div class="flexitem">';
        echo "<h3>Name: ".$name."</h3><br>";
        echo '<b>Gesamtalter jeweils in</b><br>
            <ul>
                <li>Sekunden: '.$UNIX_age_sek.'</li>
                <li>Minuten: '.$UNIX_age_min.' (und '.$UNIX_sek_remainder.' Sekunden)</li>
                <li>Stunden: '.$UNIX_age_hrs.' (und '.$UNIX_min_remainder.' Minuten)</li>
                <li>Tagen: '.$UNIX_age_day.' (und '.$UNIX_hrs_remainder.' Stunden)</li>
                <li>Wochen: '.$UNIX_age_week.' (und '.$UNIX_days_remainder.' Tage)</li>';
       
            // genauere Überprüfung der Monats und Jahresalter und deren Ausgabe
            //date("z",$timestamp) gibt den Tag des Jahres aus
            //date("j",timestamp) gibt den Tag des Monats an      
            $daychecker_now_day_year = date('z',$now);
            $daychecker_now_day_month = date('j',$now);

            $daychecker_birth_day_year = date('z',$UNIX_start_date);
            $daychecker_birth_day_month = date('j',$UNIX_start_date);
            
            $days_cause_of_month = $daychecker_now_day_month - $daychecker_birth_day_month;
            $days_cause_of_month = $daychecker_now_day_year - $daychecker_birth_day_year;
            if($daychecker_now_day_month==$daychecker_birth_day_month){
                echo '
                <li>Monate: <b>heute genau</b> '.$UNIX_age_month.' Monate. - Glückwunsch!</li>';
            }  else if($daychecker_now_day_month > $daychecker_birth_day_month) {
                echo '<li>Monate: '.$UNIX_age_month.' Monate (und '.$days_cause_of_month.'Tage)</li>';
            }
            else {         
                echo '<li>Monate: '.$UNIX_age_month.' Monate (und '.$days_cause_of_month.'Tage)</li>';
            }

             //TODO: problem?: Jahreswechsel
            if(($UNIX_year_check >= 363) || ($UNIX_year_check <= 3)) {
                if($daychecker_now_day_year == $daychecker_birth_day_year) {
                        echo '</ul>
                        <p>Hat heute Geburtstag und wird '.date("H:i",$daychecker_birth).'Uhr '.$UNIX_age_year.'Jahre alt.</p> <br>
                        <h2>Herzlichen Glückwunsch!</h2>'; 
                }
                else if($daychecker_now_day_year > $daychecker_birth_day_year) {
                        echo '</ul>
                        <p>Hatte vor '.$daychecker_now_day_year-$daychecker_birth_day_year. 'Tagen Geburtstag und wurde'.$UNIX_age_year.'Jahre alt. </p><br>
                        <h2>Nachträglich alles Gute!</h2>'; 
                }
                else if($daychecker_now_day_year < $daychecker_birth_day_year) {
                    echo '</ul>
                    <p>Wird in '.$daychecker_birth_day_year-$daychecker_now_day_year.' Tagen '.$UNIX_age_year.'Jahre alt. </p><br>
                    <h2>Schnell noch ein Geschenk besorgen!</h2><br>
                    <p>- hier könnte Ihre Werbung stehen - <br>
                    Hahahahahahahahahahahahahah </p>';
                }
                else {
                    echo '<a href="mailto:fachinformatiker@benjamin-huth.de>REPORT BUG</a>';
                }
            }
            else

        echo "</ul>
            <b>also genau:</b><br>".$UNIX_age_year." Jahre, ".$UNIX_month_remainder." Monate, ".$UNIX_week_remainder." Wochen, ".$UNIX_days_remainder." Tage, ".$UNIX_hrs_remainder." Stunden, ".$UNIX_min_remainder." Minuten und ".$UNIX_sek_remainder." Sekunden. <br><br><br> ";
        
        echo "</div>";
        return $calculated_UNIX_age_for_output;
    }

    if (mysqli_num_rows($result_show) > 0) {
        // eine Schleife um alle Daten auszugeben
        while($row = mysqli_fetch_assoc($result_show)) {
            if($result == 0){
                $calculated_UNIX_age = 0;
            }
            else {
                $calculated_UNIX_age = $result;
            }
            // Aus der Datenbank wird ein Datetime-formatierter String abgerufen und umgewandelt.
            $UNIX_start_date=strtotime($row["userdates_datetime"]);
            $name=$row["userdates_name"];
            $UNIX_age_sek = $now-$UNIX_start_date; 
            $result=simple_calculate_output($now,$name,$UNIX_start_date,$UNIX_age_sek,$calculated_UNIX_age);
            //echo "<br>result= ".$result;
        }
        //echo "result außerhalb der while-schleife".$result;
        $UNIX_age_sek = $result;
        $name = "Alle Personen zusammen";
        $result=simple_calculate_output($now,$name,$UNIX_start_date,$UNIX_age_sek,$calculated_UNIX_age);   
        //$now, $now,$name,$UNIX_start_date,$UNIX_age_sek,$calculated_UNIX_age
    } else {
        echo "Noch sind keine Daten vorhanden - Wenn Du gerade welche eingetragen hast 'Alle eingetragenen Daten anzeigen' drücken.";
    }
    mysqli_close($db_connection);
?>
            <form>
                <button type=link href="<?php header("Location: ../index.php?")?>">Zurück</button> 
            </form>
        </section>
    </article>
</main>
<?php
}
else{
    header("Location: ../index.php?");
    exit();
}
?>