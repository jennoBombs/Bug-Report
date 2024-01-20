<!DOCTYPE html>
<title>View Submitted Bug Reports</title>
<html>
    <body>
    <h3>Jennifer Reisinger CS316</h3>
    <h3>Assignment 8-3</h3>
    <h3>View Submitted Bug Reports</h3><hr />
    
    <?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $DBName = "bug_reports";
    $TableName = "reports";

        
        $DBConnect = new mysqli($servername, $username, $password, $DBName);

        if($DBConnect -> connect_error){
            die("<p>Unable to connect to the database server.</p>" . $DBConnect -> connect_error . "</p>");
        }   
        else{

            $SQLstring = "SELECT * FROM $TableName";
            if($DBConnect -> query($SQLstring)=== 0)
                echo "<p>Table does not exist!" . $DBConnect -> error . "</p>";       
            else{
                $result = $DBConnect ->query($SQLstring);
                echo "<p>The following bug reports have been submitted:</p>";
                echo "<table width='100%' border='1'>";
                echo "<tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Location</th><th>Description</th></tr>";
                if($result ->num_rows >0){
                    while ($Row = $result ->fetch_assoc()){
                        echo "<tr><td>{$Row['first_name']}</td>";
                        echo "<td>{$Row['last_name']}</td>";
                        echo "<td>{$Row['email']}</td>";
                        echo "<td>{$Row['bug_location']}</td>";
                        echo "<td>{$Row['bug_description']}</td></tr>";
                    } 
                     
                } 
                else {
                    echo "<p>There are currently no bug reports submitted!</p>";           
                }
                mysqli_free_result($result);
             }
             mysqli_close($DBConnect);
        }

    ?>

    </body>
</html>