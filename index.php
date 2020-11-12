<?php
// einbinden der header.php in den Code (incl. sessionstart)
require "header.php";
?>

<main>
    <article>
        <section id="welcome">
            <h1>Willkommen auf dem Geburtstagsrechner</h1>
            <p> Der Geburtstagsrechner ermöglicht (in seiner letzten Ausbaustufe) <b>jeden Tag Geburtstag zu feiern</b>. <br />
                Nach kostenloser Anmeldung können in einer Webmaske Geburtsdaten (das eigene oder auch die von FreundInnen, KollegInnen, MitbewohnerInnen... oder auch
                Jahrestage) eingegeben werden. Ein Klick auf "Geburtstage berechnen" gibt dann verschiedene Feiergründe aus, die ihr zusammen, oder alleine erreicht habt.
            </p>
        </section>
        <section id="login">
            <?php
            // gibt es eine aktive session? - dann diesen Code (HTML per php)
            if (isset($_SESSION['session_userid'])) {
                echo '  <p> Hallo'.$_SESSION['session_username'].' !<br />
                             Du bist eingeloggt.</p> 
                        <div>
                            <form action="intern/dateinput.intern.php" method="post">
                                <p><input type="text" name="subject_name">Name (nur Buchstaben und Ziffern)</p>
                                <p><input type="date" name="subject_date">Datum</p>
                                <p><input type="time" name="subject_time">Uhrzeit <sup>- Dieses Feld darf leer bleiben.</sup></p>
                                <p><button type="submit" name="dateinput-submit">Datum eintragen</button>
                            </form>
                        </div>
                        <div>
                            <form action="calculate.php" method="post">
                                <p>><button type="submit" name="calculate-submit">Geburtstage berechnen</button></p>
                            </form>
                        </div>
                        <div>
                            <form action="show.php" method="post">
                                <p><button type="submit" name="showall-submit">Alle eingetragenen Daten anzeigen</button></p>
                            </form>
                        </div>
                        <div>
                            <form action="intern/logout.intern.php" method="post">
                                <button type="submit" name="logout-submit">Logout</button>
                            </form>
                        </div>';
                }
            // Keine aktive Session
            else {
                echo '  <p> Du bist nicht eingeloggt</p>
                        <div>
                            <form action="intern/login.intern.php" method="post">
                                <input type="text" name="name_user" placeholder="Benutzername">
                                <input type="password" name="password_user" placeholder="P@§$wrd ;)">
                                <button type="submit" name="login-submit">Login</button>
                            </form>
                            <a href="signup.php">Anmelden</a>
                        </div>';
                }
            ?>
        </section>
    <div> 
    </div>
    </article>
</main>
<?php 
//einbinden des footers
require "footer.php";
?>