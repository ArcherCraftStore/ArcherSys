<?php 
include("program_files/config.php");

$_SESSION = array();

if (isset($_COOKIE[session_name()])) {
   setcookie(session_name(), '', time()-42000, '/');
}

@session_destroy();

header("Location: {$PHPFFL_WEB_ROOT}login.php");
?>
