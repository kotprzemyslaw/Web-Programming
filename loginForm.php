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
require_once 'functions.php';
echo makeNavMenu();
set_session('previousPage', $_SERVER['HTTP_REFERER']);

    echo "<div>
            <form method='post' action='loginProcess.php'>
                Username <input type='text' name='username' />
                Password <input type='password' name='password'/>                
                <input type='submit' value='Logon' />
            </form>
            </div>";
?>
</body>
</html>