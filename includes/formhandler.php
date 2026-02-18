<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($name)) {
        echo "Name is required";
        exit;
    }
    if (empty($email)) {
        echo "Email is required";
        exit;
    }
    if (empty($password)) {
        echo "Password is required";
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address";
        exit;
    }
    if (strlen($password) < 8) {
        echo "Password must be at least 8 characters long";
        exit;
    }

    echo "Name: " . htmlspecialchars($name) . "<br>";
    echo "Email: " . htmlspecialchars($email) . "<br>";
    echo "Password: " . password_hash($password, PASSWORD_DEFAULT) . "<br>";

} else {
    echo "Invalid request method";
    exit;
}