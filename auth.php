<?php
session_start();
require_once 'config.php';

// Handle Login
if(isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if(empty($email) || empty($password)) {
        header("Location: login.php?error=empty");
        exit();
    }
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
            $_SESSION['user_email'] = $user['email'];
            
            header("Location: index.php");
            exit();
        } else {
            header("Location: login.php?error=invalid");
            exit();
        }
    } catch(PDOException $e) {
        header("Location: login.php?error=db");
        exit();
    }
}

// Handle Signup
if(isset($_POST['signup'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate input
    if(empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password)) {
        header("Location: signup.php?error=empty");
        exit();
    }
    
    if($password !== $confirm_password) {
        header("Location: signup.php?error=password");
        exit();
    }
    
    try {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if($stmt->rowCount() > 0) {
            header("Location: signup.php?error=email");
            exit();
        }
        
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert new user
        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$first_name, $last_name, $email, $hashed_password]);
        
        // Get the new user's ID
        $user_id = $pdo->lastInsertId();
        
        // Set session variables
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $first_name . ' ' . $last_name;
        $_SESSION['user_email'] = $email;
        
        header("Location: index.php");
        exit();
    } catch(PDOException $e) {
        header("Location: signup.php?error=db");
        exit();
    }
}

// Handle Logout
if(isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?> 