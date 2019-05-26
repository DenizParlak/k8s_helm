<h1>k8s application to accessing MySQL deployment. -deniz-</h1>

<?php

$conn = NULL;
try{
    $db_name = getenv("MYSQL_DATABASE");
    $db_host = getenv("MYSQL_HOST");
    $db_port = getenv("MYSQL_PORT");
    $db_user = getenv("MYSQL_USER");

    echo "<h3>Database Information</h3>";
    echo "Database Name: " . $db_name . "<br />";
    echo "Database Host: " . $db_host . "<br />";
    echo "Database Port: " . $db_port . "<br />";
    echo "Database User: " . $db_user . "<br />";

    // Connect to database
    $conn = new mysqli($db_host, $db_user, $db_password, $db_name, $db_port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error . "<br />");
    }

    $sql = "Select 1 from `test_table` LIMIT 1;";
    if ($conn->query($sql) === FALSE)
    {
        $sql = "CREATE TABLE IF NOT EXISTS test_table(id INT AUTO_INCREMENT PRIMARY KEY , firstname TEXT, lastname TEXT);";
        if ($conn->query($sql) === TRUE) {
            echo "Created test_table as it didn't exists previously.<br />";
    
            $sql = "INSERT INTO test_table (firstname, lastname) VALUES ('Deniz', 'Parlak'), ('Jim', 'Moriarty'), ('Nicola', 'Tesla')";    
            if ($conn->query($sql) === TRUE) {
                echo "Successfully created new records in test_table.<br />";
            } else {
                echo "Error in creating new records for test_table.<br />";
                echo "Error: " . $conn->error . "<br />";
            }
        }
    }
    
    $sql = "SELECT * FROM test_table;";
    $result = $conn->query($sql);
    echo "<h3>Database Records</h3>";

    $date = new DateTime();
    echo "<p>". $date->format('Y-m-d H:i:s') . "</p>";

    if ($result->num_rows > 0) {
        echo "<table><tr><th>ID</th><th>First Name</th><th>Last Name</th></tr>";

        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['id'] . "</td><td>" . $row['firstname'] . "</td><td>" . $row['lastname'] . "</td></tr>";
        }

        echo "</table>";
    } else {
        echo "0 results";
    }
}
catch(Exception $ex) {
    echo "Something went wrong: " . $ex->getMessage() . "<br />";
}
finally {
    if ($conn != NULL) {
        $conn->close();
    }
}

?>
