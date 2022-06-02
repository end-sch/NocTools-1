<?php
session_start();
if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true))
{
    session_unset();
	session_destroy();
    header('location:index.html');
    exit;
    }

$logado = $_SESSION['login'];

?>