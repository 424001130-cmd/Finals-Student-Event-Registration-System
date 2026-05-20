<?php
session_start();

// REMOVE ALL SESSION DATA
session_unset();
session_destroy();

// REDIRECT TO LOGIN PAGE
header("Location: login.php");
exit();
?>