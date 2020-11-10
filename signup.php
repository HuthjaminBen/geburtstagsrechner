<?php
require "header.php";
?>

<main>
<h1>Neuen Account anlegen</h1>
<?php
    if (isset($_GET['error'])) {
        if($GET['error'] == "emptyfield"){
            echo '<p class="errortext">Bitte alle Felder ausfüllen.</p>';
        }  
        else if($GET['error'] == "invalidusername"){
            echo '<p class="errortext">Der Benutzername entspricht nicht den Namenskriterien.</p>';
        }  
        else if($GET['error'] == "invalidusernameandpassword"){
            echo '<p class="errortext">Sowohl Benutzername als auch Email entsprechen nicht den Kriterien.</p>';
        }  
        else if($GET['error'] == "invalidmailadress"){
            echo '<p class="errortext">Die Mailadresse entspricht nicht den Kriterien.</p>';
        }  
        else if($GET['error'] == "missmatchpasswords"){
            echo '<p class="errortext">Der Benutzername entspricht nicht den Namenskriterien.</p>';
        }  
        else if($GET['error'] == "sql-error"){
            echo '<p class="errortext">Ein Fehler in der SQL-Datenbank ist aufgetreten.</p>';
        }  
        else if($GET['error'] == "usernametaken"){
            echo '<p class="errortext">Der Benutzername ist bereits vergeben.</p>';
        } 
    } 
    else if($GET['signup'] == "successful"){
        echo '<p class="successtext">Ein Nutzerkonto wurde erfolgreich erstellt.</p>';
    }  
?>

<form action="intern/signup.intern.php" method="post">
<input type="text" name="name_user" placeholder="Benutzername">
<input type="text" name="mail_user" placeholder="Email">
<input type="password" name="pwd_user" placeholder="P@§$w0rt ;)">
<input type="password" name="pwd_user_2" placeholder="Wiederhole P@§$w0rt">
<button type="submit" name="signup-submit">Account anlegen</button>

</form>

   <!-- <h1>Willkommen auf dem Geburtstagsrechner</h1>
    <p>
        Der Geburtstagsrechner ermöglicht (in seiner letzten Ausbaustufe) <b>jeden Tag Geburtstag zu feiern</b>. In unten stehender Webmaske können Geburtsdaten (nur das eigene, oder auch die von FreundInnen, KollegInnen, MitbewohnerInnen... oder auch
        Jahrestage) eingegeben werden. Ein Klick auf "Geburtstage berechnen" gibt dann verschiedene Feiergründe aus, die ihr zusammen, oder alleine erreicht habt.
    </p>
    <div>
        <form action="eingetragen.php" method="post">
            <p><input type="text" name="subj_name">Name</p>
            <p><input type="date" name="subj-datum">Datum</p>
            <p><button type="submit">Geburtstag berechnen</button>
        </form>
    </div>-->
</main>

<?php 
require "footer.php";
?>