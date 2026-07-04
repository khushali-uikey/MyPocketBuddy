<?php
session_start();
include 'db.php';

if(isset($_POST['budget'])){

    $user_id = $_SESSION['user_id'];
    $budget = mysqli_real_escape_string($conn, $_POST['budget']);

    // check if this user already has a budget
    $check = mysqli_query($conn,"
        SELECT * FROM budget 
        WHERE user_id='$user_id'
    ");

    if(mysqli_num_rows($check) > 0){

        // add new budget to old budget
        mysqli_query($conn,"
            UPDATE budget 
            SET total_amount = total_amount + '$budget'
            WHERE user_id='$user_id'
        ");

    } else {

        // first time budget insert
        mysqli_query($conn,"
            INSERT INTO budget(user_id,total_amount)
            VALUES('$user_id','$budget')
        ");
    }
}

header("Location:index.php");
exit();
?>