<?php
// Database configuration
$host = 'localhost';
$dbname = 'star_kebab';
$username = 'root'; // Replace with your database username
$password = '';     // Replace with your database password

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the SQL query for order insertion
    $sql = "INSERT INTO orders (name, contact_number, menu_items, sauces, toppings, pickup_date, pickup_time, subtotal, payment_proof_path) 
            VALUES (:name, :contact, :menu_items, :sauces, :toppings, :pickup_date, :pickup_time, :subtotal, :payment_proof)";

    $stmt = $conn->prepare($sql);

    // Gather data from the form
    $name = $_POST['name'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $pickup_date = $_POST['pickup_date'] ?? '';
    $pickup_time = $_POST['pickup_time'] ?? '';
    $subtotal = $_POST['subtotal'] ?? 0;

    // Decode and format menu_items and sauces
    $menu_items = isset($_POST['menu_items']) ? json_decode($_POST['menu_items'], true) : [];
    $sauces = isset($_POST['sauces']) ? json_decode($_POST['sauces'], true) : [];
    $toppings = isset($_POST['toppings']) ? $_POST['toppings'] : []; // Capture toppings

    // Convert arrays to JSON for database storage
    $menu_items_json = json_encode($menu_items);
    $sauces_json = json_encode($sauces);
    $toppings_json = json_encode($toppings); // Encode toppings as JSON

    // Bind parameters
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':contact', $contact);
    $stmt->bindParam(':menu_items', $menu_items_json);
    $stmt->bindParam(':sauces', $sauces_json);
    $stmt->bindParam(':toppings', $toppings_json); // Bind toppings
    $stmt->bindParam(':pickup_date', $pickup_date);
    $stmt->bindParam(':pickup_time', $pickup_time);
    $stmt->bindParam(':subtotal', $subtotal);

    // File upload handling
    if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                throw new Exception("Unable to create upload directory.");
            }
        } elseif (!is_writable($uploadDir)) {
            throw new Exception("Upload directory is not writable. Check directory permissions.");
        }

        $uploadFile = $uploadDir . basename($_FILES['payment_proof']['name']);
        if (!move_uploaded_file($_FILES['payment_proof']['tmp_name'], $uploadFile)) {
            throw new Exception("Error moving the uploaded file.");
        }

        // Read the uploaded file into a BLOB
        $payment_proof_path = file_get_contents($uploadFile);
        if ($payment_proof_path === false) {
            throw new Exception("Error reading the file contents.");
        }
    } else {
        throw new Exception("No file uploaded or there was an error with the upload.");
    }

    // Bind the payment proof path as BLOB in the query
    $stmt->bindParam(':payment_proof', $payment_proof_path, PDO::PARAM_LOB);

    // Execute the order insertion query
    $stmt->execute();

    // Success message
    echo "Order successfully placed! Thanks, $name. We will contact you at $contact within 5 minutes. STAR KEBAB!";
} catch (PDOException $e) {
    // Database error
    echo "Database Error: " . $e->getMessage();
} catch (Exception $e) {
    // General error
    echo "Error: " . $e->getMessage();
} finally {
    // Close the database connection
    $conn = null;
}
?>
