<?php
 require_once "vendor/autoload.php";
 define('ASOS_ROOT', getcwd());
   Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem(ASOS_ROOT.'/views');
$twig = new Twig_Environment($loader, array(
'cache' => 'bin-cache',
));
$asosmenu = array("ASOSDesk" => 
array("title" => "ASOSDesk",
      "type" => "submenu",
 "submenu" => array(
   array("title" => "About ASOS Desk")
)
)
); 
 echo $twig->render('asosmenu.twig',$asosmenu);
 