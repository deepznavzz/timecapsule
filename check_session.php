<?php
session_start(); // Start the session
include 'db_connect.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? '';
    $password = $_POST["password"] ?? '';

    // Debug: Print received data
    echo "<pre>";
    echo "Username: $username\n";
    echo "Password: $password\n";
    echo "</pre>";

    // Validate input
    if (empty($username) || empty($password)) {
        die("Username and password are required.");
    }

    // Fetch user from the database
    $stmt = $conn->prepare("SELECT UserID, Password FROM Users WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userID, $hashed_password);
        $stmt->fetch();

        // Debug: Print fetched data
        echo "<pre>";
        echo "UserID: $userID\n";
        echo "Hashed Password: $hashed_password\n";
        echo "</pre>";

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Login successful
            $_SESSION['userID'] = $userID; // Store user ID in session
            $_SESSION['username'] = $username; // Store username in session

            // Debug: Print session data
            echo "<pre>";
            echo "Session Data:\n";
            print_r($_SESSION);
            echo "</pre>";

            // Pass data to JavaScript
            echo "<script>
                console.log('Setting localStorage...');
                localStorage.setItem('userID', '$userID');
                localStorage.setItem('username', '$username');
                window.location.href = 'dashboard.html';
            </script>";
            exit;
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "User not found.";
    }

    $stmt->close();
    $conn->close();
}
?>