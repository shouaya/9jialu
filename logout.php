<?php 
//clear session
session_start();
$_SESSION['user'] = null;
header("Location: index.html");