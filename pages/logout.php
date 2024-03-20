<?php
session_start(); 
$_SESSION = array();
session_destroy();
header("Location: greetingpage.php");
exit;
?>