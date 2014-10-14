<?php
 require_once "vendor/autoload.php";
   Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem($_SERVER["DOCUMENT_ROOT"].'/views');
 
  $twig = new Twig_Environment($loader,array(
'cache' => '/bin_cache'
));