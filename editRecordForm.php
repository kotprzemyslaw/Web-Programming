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
    if(check_login()) {
        try {


            $dbConnection = getDatabaseConnection();

            $recordID = filter_has_var(INPUT_GET, 'recordID')
                ? $_GET['recordID'] : null;

            if ($recordID == null) {
                echo("Please choose a movie from a list, by clicking on the title.\n");
                echo("DO NOT ENTER WEB ADDRESS MANUALLY");
            } else {
                $sqlQuery = "SELECT recordID, recordTitle, recordYear, catDesc, pubName
                             FROM nmc_records 
                             INNER JOIN nmc_category
                             ON nmc_category.catID = nmc_records.catID
                             INNER JOIN nmc_publisher
                             ON nmc_publisher.pubID = nmc_records.pubID
                             WHERE recordID = $recordID";

                $queryResult = $dbConnection->query($sqlQuery);

                $rowObj = $queryResult->fetchObject();

                $recordTitle = $rowObj->recordTitle;
                $recordYear = $rowObj->recordYear;
                $recordCategoryDescription = $rowObj->catDesc;
                $recordPublisher = $rowObj->pubName;

                echo "<form id='recordUpdateForm' action='updateRecord.php' method='get' name='recordUpdateForm'>
                                    <ul>                                    
                                        <h1>Edit $recordTitle</h1>  
                                                                              
                                            <label>Record ID</label>
                                            <input type='text' name='recordID' id='recordID' 
                                                value='$recordID' readonly/>                                                                      
                                            <br/>                           
                                                    
                                            <label>Title</label>
                                            <input type='text' name='recordTitle' id='recordTitle'
                                                value='$recordTitle' required/>                                       
                                            <br/>     
                                                                           
                                            <label>Year</label>
                                            <input type='text' name='recordYear' id='recordYear'
                                                value='$recordYear' required/>
                                            <br/> 
                                               
                                            <label>Category</label>";
                echo querySelectCategoriesOptions($dbConnection, $recordCategoryDescription);
                echo "<br/>  
                                            <label>Publisher</label>";
                echo querySelectPublisherOptions($dbConnection, $recordPublisher);
                echo "<br/>
                                            <button type='submit'>Update Record</button>                                                                                     
                                    </ul>
                                  </form>";
            }
        } catch (Exception $e) {
            echo "<p>Query failed: " . $e->getMessage() . "</p>";
        }
    }else{
        echo "<p>You need to be <a href='loginForm.php'>logged on</a> to edit a record</p>";
    }
    function querySelectCategoriesOptions($dbConnection, $recordCategoryDescription){
        $sqlQueryCategories = "SELECT catID, catDesc
                               FROM nmc_category
                               ORDER BY catDesc";

        $queryCategoriesResult = $dbConnection -> query($sqlQueryCategories);

        $output = "<select name='recordCategory' id='recordCategory'>\n";

        while($rowObj = $queryCategoriesResult->fetchObject()){
            $catID = $rowObj -> catID;
            $catDescription = $rowObj ->catDesc;

            if($catDescription === $recordCategoryDescription){
                $output .= "<option value='$catID' selected>$catDescription</option>'\n";
            }else{
                $output .= "<option value='$catID' >$catDescription</option>'\n";
            }

        }

        $output.= "</select>";

        return $output;
    }

    function querySelectPublisherOptions($dbConnection, $selectedPublisher){
        $sqlQueryPublisher = "SELECT pubID, pubName
                              FROM nmc_publisher
                              ORDER BY pubName";

        $queryPublisherResult = $dbConnection -> query($sqlQueryPublisher);

        $output = "<select name='publisherName' id='publisherName'>\n";

        while($rowObj = $queryPublisherResult->fetchObject()){
            $pubID = $rowObj -> pubID;
            $pubName = $rowObj -> pubName;

            if($pubName === $selectedPublisher){
                $output .= "<option value='$pubID' selected>$pubName</option>\n";
            }else{
                $output .= "<option value='$pubID'>$pubName</option>\n";
            }
        }

        $output .= "</select>";

        return $output;
    }
    ?>
</main>
</body>
</html>
