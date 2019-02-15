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

<h1>Name: Przemyslaw Kotowicz<br/>
Student ID: 17018747</h1>

<h2>Credits: Hodgson, D. (2018). PS3 Tutors Contents Page. [online] Unn-cgdh2.newnumyspace.co.uk. Available at:
    <a href="http://unn-cgdh2.newnumyspace.co.uk/JSTutors/index.html">http://unn-cgdh2.newnumyspace.co.uk/JSTutors/index.html</a></h2>

</body>
</html>