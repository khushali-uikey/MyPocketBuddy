<?php
include 'db.php';

if(isset($_POST['submit'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // check if email already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($check) > 0){
        echo "<script>alert('Email already registered');</script>";
    } else {

        mysqli_query($conn,"
            INSERT INTO users(name,email,password)
            VALUES('$name','$email','$password')
        ");

        echo "<script>alert('Signup successful');</script>";
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header>
    <div class="logo">MyPocketBuddy</div>
</header>

<div class="signup-container">

    <form class="signup-box" method="POST">

        <h2>Signup Page</h2>

        <input 
            type="text" 
            name="name" 
            placeholder="Enter your name" 
            required
        >

        <input 
            type="email" 
            name="email" 
            placeholder="Enter your email" 
            required
        >

        <input 
            type="password" 
            name="password" 
            placeholder="Enter your password" 
            required
        >

        <button type="submit" name="submit">Signup</button>

        <button type="reset">Reset</button>

        <p>
            Already have an account? 
            <a href="login.php">Login</a>
        </p>

    </form>

</div>

</body>
</html>