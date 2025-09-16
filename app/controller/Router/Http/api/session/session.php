<?php
session_start();
// die("good");
// Check if the user role is stored in the session
die("hhhhh") ;
if (isset($_SESSION['role'])) {
    $userRole = $_SESSION['role'];
    // Send the user role as a response
    echo json_encode(['role' => $userRole]);
} else {
    // Send an error response or handle unauthorized access
    echo json_encode(['message' => 'Unauthorized access']);
}