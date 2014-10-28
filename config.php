<?php
 require_once "vendor/autoload.php";
 require_once "includes/archersys-connect/asos-gravatar-fetch.php";
 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Component\HttpFoundation\Request;
 $response = new Response();
 $request = new Request();
 session_start();
 ?>
 