<?php
// Database credentials
$host = "localhost";
$username = "root"; // Replace with your DB username
$password = "";     // Replace with your DB password
$dbname = "rays_of_hope";

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect and sanitize form data
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $date_of_birth = $conn->real_escape_string($_POST['date_of_birth']);
    $skills = $conn->real_escape_string($_POST['skills']);
    $availability = $conn->real_escape_string($_POST['availability']);

    // Insert data into the database
    $sql = "INSERT INTO volunteers (full_name, email, phone, date_of_birth, skills, availability) 
            VALUES ('$full_name', '$email', '$phone', '$date_of_birth', '$skills', '$availability')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();
?>
