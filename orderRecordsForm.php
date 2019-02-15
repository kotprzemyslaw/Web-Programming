<?php
ini_set("session.save_path", "/home/unn_w17018747/public_html/assigment/sessionData");
session_start();
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Order Records</title>
</head>
<body>

<?php
require_once 'functions.php';
echo makeNavMenu();

/* This code dynamically generates a web page containing a form designed with the html required to display one
checkbox for each of the records currently held in the nmc_records database table has been provided for you in the
assessment section for the module on blackboard. The user can select one or more records that they are interested in
ordering by clicking the checkboxes.
Use the browser to look at the structure of the html generated by the php code. */

$url = "http://unn-izge1.newnumyspace.co.uk/KF5002/assessment/orderRecordsFormInc.php";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);
curl_close($curl);
echo $result;
?>

<script type="text/javascript" src="orderFormProcess.js"></script>
</body>
</html>