<?php
//einbinden des Header (incl .Sessionstart)
require "header.php";
?>

<main>
    <article>
        <section>
            <h1>Neuen Account anlegen</h1>
            <?php
            // abfangen der Error-messages und anzeigen was der Fehler war wenn ein Versuch gescheitert ist
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

            <!-- DAs Feld zur Dateneingabe-->
            <p> um einen Account anzulegen wird ein Benutzername (Nur Buchstaben und Ziffern), sowie eine gültige Mailadresse und ein Password(2x eingeben) gebraucht.<br /> 
            In den beiden Feldern darunter kannst Du Deinen eigenen Geburtstag und die Geburtszeit eingeben, diese Daten können dann für die Berechnung der Feiergründe mit genutzt werden. Geburtstag und -zeit sind für einen Account nicht zwingend erforderlich</p>
            <form action="intern/signup.intern.php" method="post">
                <input type="text" name="name_user" placeholder="Benutzername">
                <input type="text" name="mail_user" placeholder="Email">
                <input type="password" name="pwd_user" placeholder="P@§$w0rt ;)">
                <input type="password" name="pwd_user_2" placeholder="Wiederhole P@§$w0rt">
                <input type="date" name="date_user">
                <input type="time" name="time_user">
                <button type="submit" name="signup-submit">Account anlegen</button>
            </form>
        </section>
    </article>
    </main>

<?php 
// einbinden des footers
require "footer.php";
?>