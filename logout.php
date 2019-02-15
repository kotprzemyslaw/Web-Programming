<?php
ini_set("session.save_path", "/home/unn_w17018747/public_html/assigment/sessionData");
session_start();
$_SESSION = array();
session_destroy();
$previousPage = $_SERVER['HTTP_REFERER'];
header("Location: $previousPage");