<?php
session_start();
include 'db.php';

if(isset($_POST['amount'])){

    $user_id = $_SESSION['user_id'];

    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);

    // insert transaction for this user
    $sql = "
        INSERT INTO transactions
        (user_id, amount, category, description, date)
        VALUES
        ('$user_id','$amount','$category','$desc','$date')
    ";

    mysqli_query($conn, $sql);
}

header("Location:index.php");
exit();
?>