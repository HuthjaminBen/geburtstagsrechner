<?php
require "header.php";
?>

<main>
    <article>
        <section id="welcome">
            <h1>Willkommen auf dem Geburtstagsrechner</h1>
            <p> Der Geburtstagsrechner ermöglicht (in seiner letzten Ausbaustufe) <b>jeden Tag Geburtstag zu feiern</b>. <br />
                Nach kostenloser Anmeldung können in einer Webmaske Geburtsdaten (nur das eigene oder auch die von FreundInnen, KollegInnen, MitbewohnerInnen... oder auch
                Jahrestage) eingegeben werden. Ein Klick auf "Geburtstage berechnen" gibt dann verschiedene Feiergründe aus, die ihr zusammen, oder alleine erreicht habt.
            </p>
        </section>
        <section id="login">
            <?php
            if (isset($_SESSION['session_userid'])) {
                echo '  <p> Hallo'.$_SESSION['session_username'].' !<br />
                             Du bist eingeloggt.</p> 
                        <div>
                            <form action="birthdayinput.php" method="post">
                                <p><input type="text" name="subj_name">Name</p>
                                <p><input type="date" name="subj-datum">Datum</p>
                                <p><button type="submit" name="birthday-submit">Datum eintragen</button>
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
require "footer.php";
?>