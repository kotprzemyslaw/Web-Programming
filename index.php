<?php
ini_set("session.save_path", "/home/unn_w17018747/public_html/assigment/sessionData");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<?php
require_once("functions.php");
echo makeNavMenu();
?>

<aside id="offers">
<h1>html</h1>
</aside>

<aside id="XMLoffers">
<h1>xml</h1>
</aside>
<script type="text/javascript" src="specialOffer.js"></script>
</body>
</html>