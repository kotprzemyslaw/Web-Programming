<?php
ini_set("session.save_path", "/home/unn_w17018747/public_html/assigment/sessionData");
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="style.css">
</head>
<body>
<main>
    <?php
    require_once("functions.php");
    echo makeNavMenu();

    if (check_login()) {
        try {
            $dbConnection = getDatabaseConnection();

            //Queries all the records from the database and orders them by the record title.
            $sqlQuery = "SELECT recordID, recordTitle, recordYear, recordPrice, catDesc
                         FROM nmc_records 
                         INNER JOIN nmc_category
                         ON nmc_category.catID = nmc_records.catID
                         ORDER BY recordTitle";

            $queryResult = $dbConnection->query($sqlQuery);

            echo "<table> 
                    <tr>
                        <th>Title</th>
                        <th>Year</th>
                        <th>Price</th>
                        <th>Category</th>                        
                    </tr>";
            while ($rowObj = $queryResult->fetchObject()) {
                echo "<tr>
                <td><a href='editRecordForm.php?recordID={$rowObj -> recordID}'>{$rowObj->recordTitle}</a></td>
                <td>{$rowObj->recordYear}</td>
                <td>{$rowObj -> recordPrice}</td>
                <td>{$rowObj->catDesc}</td>
                     </tr>";
            }
            echo "</table>";

        } catch (Exception $e) {
            echo "<p>Query failed: " . $e->getMessage() . "</p>\n";
        }
    } else {
        echo "<p>You need to be <a href='loginForm.php'>logged on</a> to edit a record</p>";
    }
    ?>
</main>
</body>
</html>
