<?php
session_start();
include 'db.php';

if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // find user by email
    $res = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($res) > 0){

        $data = mysqli_fetch_assoc($res);

        // verify hashed password
        if(password_verify($password, $data['password'])){

            $_SESSION['user_id'] = $data['id'];
            $_SESSION['name'] = $data['name'];

            header("Location: index.php");
            exit();

        } else {
            echo "<script>alert('Wrong password');</script>";
        }

    } else {
        echo "<script>alert('User not found');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header>
    <div class="logo">MyPocketBuddy</div>
</header>

<div class="signup-container">

    <form class="signup-box" method="POST">

        <h2>Login</h2>

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

        <button type="submit" name="login">Login</button>

        <button type="reset">Reset</button>

        <p>
            Don't have an account? 
            <a href="signup.php">Signup</a>
        </p>

    </form>

</div>

</body>
</html>