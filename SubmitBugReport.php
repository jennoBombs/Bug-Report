<!DOCTYPE html>
<title>Submit Bug Report</title>
<html>
    <body>
        <h3>Jennifer Reisinger CS316</h3>
        <h3>Assignment 8-3</h3>
        <h3>Submit Bug Report</h3><hr />
    <h2>Enter the following information to submit your bug report:</h2>
    <form method="POST" action="SubmitBugReport.php">
            <p>First Name: <input type="text" name="first_name"/></p>
            <p>Last Name: <input type="text" name="last_name"/></p>
            <p>Email Address: <input type="text" name="email"/></p>
            <p>Software or Webapp Bug Was Located:</p> 
            <p><input type="text" name="bug_location" maxlength="25"></p>
            <p>Description of bug (255 characters or less):</p>
            <textarea name="bug_description" rows="5" cols="30" maxlength="255"></textarea>
            <p><input type="submit" value="Submit" /></p>
        </form>
    <?php

        $servername = "localhost";
        $username = "root";
        $password = "";

        //ensure visitors enter their first and last name
        if(empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email']) || empty($_POST['bug_location'])
        || empty($_POST['bug_description']))
            echo "<p>You must complete all fields to submit your bug report! Click your browser's Back button to return
                to the Submit Bug Report Form.</p>";
        else{ 
            //connect and create a database using W3 schools technique
            $DBConnect = new mysqli($servername, $username, $password);

            if($DBConnect -> connect_error){
                die("<p>Unable to connect to the database server.</p>" . $DBConnect -> connect_error . "</p>");
            }    
                    
            //create a database named guestbook if it doesn't already exist
            $DBName = "bug_reports";
            $DBCreate = "CREATE DATABASE $DBName";
            if($DBConnect -> query($DBCreate)===TRUE){
                echo "<p>You are the first visitor!</p>";
            }
            else{
                     echo "<p>Error creating database: " . $DBConnect->error . "</p>";
            }    

            //create an auto incrementing table named count if it doesn't already exist
            $TableName = "reports";
            $SQLstring = "SHOW TABLES LIKE $TableName";

            if($DBConnect -> query($SQLstring)==FALSE){
            $DBConnect = new mysqli($servername, $username, $password, $DBName);

                $SQLstring = "CREATE TABLE $TableName(countID INT
                NOT NULL AUTO_INCREMENT PRIMARY KEY, last_name
                VARCHAR(40), first_name VARCHAR(40), email VARCHAR(30), bug_location VARCHAR(40),
                bug_description VARCHAR(255))";

                if($DBConnect -> query($SQLstring) ===TRUE){
                    echo "Table $TableName created successfully</p>";
                }
                else{
                    echo "<p>Unable to create the table." . $DBConnect -> error . " </p>";
                }
            }

                //add the bug report to the database
                $LastName = stripslashes($_POST['last_name']);
                $FirstName = stripslashes($_POST['first_name']);
                $Email = stripslashes($_POST['email']);
                $Location = stripslashes($_POST['bug_location']);
                $Description = stripslashes($_POST['bug_description']);
                $SQLstring = "INSERT INTO $TableName (last_name, first_name, email, bug_location, bug_description)
                VALUES('$LastName', '$FirstName', '$Email', '$Location', '$Description')";
                $DBConnect = new mysqli($servername, $username, $password, $DBName);
                if($DBConnect -> query($SQLstring)===TRUE){
                    echo "<h1>Thank you for submitting your bug report!</h1>";
                }
                else{
                    echo "<p>Unable to insert new values to the table.</p>" . "<br>" . $DBConnect -> error; 
                }
                mysqli_close($DBConnect);
            }
        
    ?>
    </body>
    
    <p><a href="ViewBugReports.php">View Submitted Reports</a></p>
</html>