<?php
//session definitiv tot machen
session_start();
session_unset();
session_destroy();
//zurück zur Startseite
header("location: ../index.php");