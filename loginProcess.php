<?php
ini_set("session.save_path", "/home/unn_w17018747/public_html/assigment/sessionData");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Process</title>
</head>
<body>
    <?php
    require_once('functions.php');

    list($input, $errors) = validate_logon();

    if($errors){
        echo show_errors($errors);
    }else{
        $previousPage = get_session('previousPage');
        set_session('username', $input['username']);
        set_session('logged-in', 'true');
        $queryPage = get_session("queryPage");
        header("Location: $previousPage");
    }

    function validate_logon(){
        $input = array();
        $errors = array();

        $input['username'] = filter_has_var(INPUT_POST, 'username')
            ? $_POST['username'] : null;
        $input['password'] = filter_has_var(INPUT_POST, 'password')
            ? $_POST['password'] : null;

        $input['username'] = trim($input['username']);
        $input['password'] = trim($input['password']);

        if(empty($input['username']) || empty($input['password'])){
            $errors['emptyLogin'] = "<p>You need to provide a username and a password.  
                <a href='loginForm.php'>Click here to try again</a></p>";
        }else{
            try{
                unset($_SESSION['username']);
                unset($_SESSION['logged-in']);


                $dbConnection = getDatabaseConnection();

                $sqlQuery = "SELECT passwordHash 
                             FROM nmc_users
                             WHERE username = :username";

                $statement = $dbConnection->prepare($sqlQuery);
                $statement->execute(array(':username' => $input['username']));
                $user = $statement->fetchObject();

                if($user){
                    if(!(password_verify($input['password'], $user->passwordHash))) {
                        $errors['invalidLogin'] = "<p>The username or password were incorrect.  
                                    <a href='loginForm.php'>Click here to try again</a></p>";
                    }
                }else{
                    $errors['invalidLogin'] = "<p>The username or password were incorrect.  
                <a href='loginForm.php'>Click here to try again</a></p>";
                }

            }catch(Exception $e){
                echo "Record not found: ". $e->getMessage();
            }
        }

        return array($input, $errors);
    }

    function show_errors($errors){
        $output = "";

        foreach($errors as $error){
            $output .= $error;
        }

        return $output;
    }
    ?>
</body>
</html>
