<?php
ini_set("session.save_path", "/home/unn_w17018747/public_html/assigment/sessionData");
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>

</head>
<body>
<main>
    <?php
    require_once("functions.php");
    echo makeNavMenu();

    list($input, $errors) = validate_form();

    echo($errors ? show_errors($errors) : process_form($input));

    /**
     * Validates all the input received from the form.
     * @return $input array with validated data received from the form.
     * @return $errors array with information about errors in validating the data.
     */
    function validate_form(){
        $input = array();
        $errors = array();

        //Receives the data from the form.
        $input['recordID'] = filter_has_var(INPUT_GET, 'recordID')
                                ? $_GET['recordID'] : null;
        $input['recordTitle'] = filter_has_var(INPUT_GET, 'recordTitle')
                                ? $_GET['recordTitle'] : null;
        $input['recordYear'] = filter_has_var(INPUT_GET, 'recordYear')
                                ? $_GET['recordYear'] : null;
        $input['recordCategory'] = filter_has_var(INPUT_GET, 'recordCategory')
                                ? $_GET['recordCategory'] : null;
        $input['publisherName'] = filter_has_var(INPUT_GET, 'publisherName')
                                ? $_GET['publisherName'] : null;

        //Trims all the input data received from the form.
        $input['recordID'] = trim($input['recordID']);
        $input['recordTitle'] = trim($input['recordTitle']);
        $input['recordYear'] = trim($input['recordYear']);

        //Checks if the recordID isn't empty and if it's an integer.
        if((empty($input['recordID'])) || (!filter_var($input['recordID'], FILTER_VALIDATE_INT))){
            $errors['invalidRecordID'] = "<p>Invalid record ID. Choose the record, by left mouse clicking the 
                record title displayed on the website. If this error reappears contact the page administrator.</p>";
        }

        if(empty($input['recordTitle'])){
            $errors['invalidTitle'] = "<p>You have not entered a record title!</p>";
        }
        if(strlen($input['recordTitle'] > 100)){
            $errors['invalidTitleLength'] = "<p>Record title can't have more than 100!<</p>";
        }

        if(empty($input['recordYear'])){
            $errors['invalidRecordYear'] = "<p>You have not entered a record year!</p>";
        }
        if(!filter_var($input['recordYear'], FILTER_VALIDATE_INT)){
            $errors['invalidRecordYearType'] = "<p>Invalid record year! Record year must be entered as integers.</p>";
        }
        if(strlen($input['recordTitle'] > 4)){
            $errors['invalidTitleLength'] = "<p>Invalid record year! Record year can't have more than 4 digits.<</p>";
        }

        if(empty($input['recordCategory'])){
            $errors['invalidCategory'] = "<p>Record category cannot be empty. Try selecting category again, 
                if this error reappears contact the page administrator.</p>";
        }

        if(empty($input['publisherName'])){
            $errors['invalidCategory'] = "<p>Publisher name cannot be empty. Try selecting publisher name again, 
                if this error reappears contact the page administrator.</p>";
        }

        return array($input, $errors);
    }

    function show_errors($errors){
        $output = "";

        foreach($errors as $error){
            $output .= $error;
        }

        $output .= "<p>Please try editing the record again. 
                <a href='queryRecords.php'>Click here to try again.</a>
                </p>";

        return $output;
    }

    function process_form($input){
        try {
            require_once("functions.php");
            $dbConnection = getDatabaseConnection();

            $sqlUpdate = "UPDATE nmc_records SET recordTitle = :recordTitle, recordYear = :recordYear, 
                          catID = :catID, pubID = :pubID
                          WHERE recordID = :recordID";

            $statement = $dbConnection -> prepare($sqlUpdate);
            $statement -> execute(array(':recordTitle' => $input['recordTitle'], ':recordYear' => $input['recordYear'],
                    ':catID' => $input['recordCategory'],  'pubID' => $input['publisherName'],':recordID' => $input['recordID']));

            echo "<div class='information'>\n
            <h1>Record details were updated succesfully.</h1>
            <h2><a href='queryRecords.php'>Click here to select another record</a></h2>
            </div>\n";
        }
        catch (Exception $e){
            echo "<p>Query failed: ".$e->getTraceAsString()."</p>\n";
        }
    }
    ?>
</main>
</body>
</html>

