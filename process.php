<?php
header('Content-Type: application/json');

// Database connection
$db = new mysqli('localhost', 'username', 'password','birthday', 'medstock_db');

if ($db->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

// Get form data
$fullname = $db->real_escape_string($_POST['fullname'] ?? '');
$email = $db->real_escape_string($_POST['email'] ?? '');
$password = password_hash($_POST['password'] ?? '', PASSWORD_BCRYPT);
$birthday = $db->real_escape_string($_POST['birthday'] ?? '');

// Validation
if (empty($fullname) || empty($email) || empty($_POST['password']) || empty($birthday)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

// Insert to database
$sql = "INSERT INTO users (fullname, email, password, birthday) 
        VALUES ('$fullname', '$email', '$password', '$birthday')";

if ($db->query($sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $db->error]);
}

$db->close();
?>