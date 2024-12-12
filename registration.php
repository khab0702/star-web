<?php
// Include database connection file
require 'db-connection.php';

// Create (Insert) operation
if(isset($_POST['create'])) {
    $name = $_POST['name'];
    $num = $_POST['num'];
    $od = isset($_POST['od']) ? $_POST['od'] : ''; // Set default value if 'od' is not provided
    
    $sql = "INSERT INTO registration (name, num, od) VALUES (?, ?, ?)";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);
    
    // Bind parameters
    $stmt->bind_param("sss", $name, $num, $od);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "Information successfully inserted.";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    // Close the statement
    $stmt->close();
}

// Read operation
$sql = "SELECT * FROM registration";
$result = $conn->query($sql);

echo "<h2>Registered Users</h2>";
echo "<table border='1'>";
echo "<tr><th>name</th><th>num</th><th>od</th><th>Actions</th></tr>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["name"]."</td>";
        echo "<td>".$row["num"]."</td>";
        echo "<td>".$row["od"]."</td>";
        echo "<td>";
        echo "<form method='post'>";
        echo "<input type='hidden' name='id' value='".$row["id"]."'>";
        echo "<input type='hidden' name='action' value='update'>";
        echo "<input type='submit' value='Update'>";
        echo "</form>";
        echo "<form method='post'>";
        echo "<input type='hidden' name='id' value='".$row["id"]."'>";
        echo "<input type='hidden' name='action' value='delete'>";
        echo "<input type='submit' value='Delete'>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>0 results</td></tr>";
}
echo "</table>";

// Update operation
if(isset($_POST['action']) && $_POST['action'] == 'update') {
    $id = $_POST['id']; // Assuming you have an input field for ID
    
    // Retrieve existing data for the selected ID
    $sql = "SELECT * FROM registration WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    // Display update form
    echo "<h2>Update User</h2>";
    echo "<form method='post'>";
    echo "<input type='hidden' name='id' value='".$row["id"]."'>";
    echo "name: <input type='text' name='name' value='".$row["name"]."'><br>";
    echo "num: <input type='text' name='num' value='".$row["num"]."'><br>";
    echo "od: <input type='text' name='od' value='".$row["od"]."'><br>";
    echo "<input type='submit' name='update' value='Update'>";
    echo "</form>";
}

// Update operation (continued)
if(isset($_POST['update'])) {
    $id = $_POST['id']; // Assuming you have an input field for ID
    $name = $_POST['name'];
    $num = $_POST['num'];
    $od = isset($_POST['od']) ? $_POST['od'] : ''; // Set default value if 'od' is not provided
    
    $sql = "UPDATE registration SET name=?, num=?, od=? WHERE id=?";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);
    
    // Bind parameters
    $stmt->bind_param("sssi", $name, $num, $od, $id);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "Information successfully updated.";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    // Close the statement
    $stmt->close();
}

// Delete operation
if(isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = $_POST['id']; // Assuming you have an input field for ID
    
    $sql = "DELETE FROM registration WHERE id=?";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);
    
    // Bind parameters
    $stmt->bind_param("i", $id);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "Information successfully deleted.";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
