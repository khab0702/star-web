<?php
session_start();
if(isset($_post['menu_but'])){require'db-connection.php';

    $menu= $_POST['menu'];
    $sql = "INSERT INTO menu (arrivale, departure, Destination, source, airline, Seats, duration, Price, status, issue)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, '', '')";
 
    // Prepare the statement
    $stmt = $conn->prepare($sql);
 
    // Bind parameters
    $stmt->bind_param("sssssiis", $arrival, $departure, $arr_city, $dep_city, $air_id, $seats, $dura, $price);
 
    // Execute the statement if validation passes
    if ($flag && $stmt->execute()) {
        echo "Flight details inserted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
 
    // Close the statement
    $stmt->close();
 
    // Close the database connection
    $conn->close();
}
?> 

