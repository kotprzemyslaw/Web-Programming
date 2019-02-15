<?php
/**
 * Gets a database connection.
 * @return PDO connection.
 * @throws Exception connection error if function won't succeed in getting database connection.
 */
function getDatabaseConnection() {
    try {
        $connection = new PDO("mysql:host=localhost;dbname=unn_w17018747",
            "unn_w17018747", "Chrzaszczyzewoszyce123");
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    } catch (Exception $e) {
        /* We should log the error to a file so the developer can look at any logs. However, for now we won't */
        throw new Exception("Connection error ". $e->getMessage(), 0, $e);
    }
}

function makeNavMenu(){

    $navMenuContent = <<<NAVMENU
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="queryRecords.php">Choose a record to edit</a></li> 
            <li><a href="orderRecordsForm.php">Order records</a></li>             
            <li><a href="credits.php">Credits</a></li>      
        
NAVMENU;
    $navMenuContent .= displayLoginButton();
    $navMenuContent .= "</ul>
    </nav>";
    $navMenuContent .= "\n";
    return $navMenuContent;
}

function displayLoginButton(){
    $loginContent = "";

    if(check_login()){
        $loginContent .= "<li><a href='logout.php'>Log out</a></li>";
    }else{
        $loginContent .= "<li><a href='loginForm.php'>Log in</a></li>";
    }

    return $loginContent;
}

function check_login(){
    $loggedIn = get_session('logged-in');

    return $loggedIn ? true: false;
}

function set_session($key, $value){
    $_SESSION[$key] = $value;
    return true;
}

function get_session($key){
    $sessionValue = "";

    if(isset($_SESSION[$key])){
        $sessionValue = $_SESSION[$key];
    }

    return $sessionValue;
}
