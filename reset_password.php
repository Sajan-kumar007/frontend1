<?php
// Database connection parameters
$servername = "localhost"; // Change this to your database server name
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "arrowgrub"; // Change this to your database name

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the email address and new password from the form
    $email = $_POST['email'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_new_password'];

    // Validate the email address (you may add more sophisticated validation)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit; // Stop further execution if the email is invalid
    }

    // Validate new password and confirmation
    if ($newPassword != $confirmPassword) {
        echo "Passwords do not match";
        exit;
    }

    // Create a PDO connection to the database
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL update statement
        $stmt = $conn->prepare("UPDATE signup SET password = :password WHERE email = :email");

        // Bind parameters
        $stmt->bindParam(':password', $newPassword);
        $stmt->bindParam(':email', $email);

        // Execute the update statement
        $stmt->execute();

        // Output success message
        echo "Password updated successfully";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage(); // Output any errors
    }

    // Close connection
    $conn = null;
}
?>
