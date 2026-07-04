<?php
session_start();
include 'db.php';

/* Protect page */
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];

/* USER BUDGET */
$total = 0;

$res = mysqli_query($conn,"
    SELECT total_amount 
    FROM budget 
    WHERE user_id='$user_id'
");

if(mysqli_num_rows($res) > 0){
    $data = mysqli_fetch_assoc($res);
    $total = $data['total_amount'];
}

/* USER SPENT */
$spent = 0;

$res2 = mysqli_query($conn,"
    SELECT SUM(amount) as total 
    FROM transactions 
    WHERE user_id='$user_id'
");

$data2 = mysqli_fetch_assoc($res2);
$spent = $data2['total'] ?? 0;

/* REMAINING */
$remaining = $total - $spent;
?>

<!DOCTYPE html>
<html>
<head>
    <title>MyPocketBuddy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header>
    <div class="logo">MyPocketBuddy</div>

    <div class="user-menu">
        <div class="avatar" onclick="toggleMenu()">
            <?php echo strtoupper(substr($name,0,1)); ?>
        </div>

        <div class="dropdown" id="dropdownMenu">
            <p><?php echo $name; ?></p>
            <a href="resetpassword.html">Reset Password</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</header>

<div class="dashboard">

    <!-- TOP CARDS -->
    <div class="cards">

        <div class="card add-budget-card">
            <h3>Add Budget</h3>

            <form action="budget.php" method="POST">
                <input 
                    type="number" 
                    name="budget" 
                    placeholder="Enter amount" 
                    required
                >

                <div style="text-align:center;">
                    <button type="submit">Add Budget</button>
                </div>
            </form>
        </div>

        <div class="card stat-card">
            <span>Total Budget</span>
            <h2>₹<?php echo $total; ?></h2>
        </div>

        <div class="card stat-card">
            <span>Remaining</span>
            <h2>₹<?php echo $remaining; ?></h2>
        </div>

    </div>

    <!-- CONTENT -->
    <div class="content">

        <!-- TRANSACTION FORM -->
        <div class="transaction-box">
            <h2>Add Transaction</h2>

            <form action="transaction.php" method="POST">

                <input 
                    type="text" 
                    name="description" 
                    placeholder="Description" 
                    required
                >

                <input 
                    type="number" 
                    name="amount" 
                    placeholder="Amount" 
                    required
                >

                <select name="category" required>
                    <option value="">Select Category</option>
                    <option>Food</option>
                    <option>Travel</option>
                    <option>Shopping</option>
                    <option>Health</option>
                    <option>Other</option>
                </select>

                <input type="date" name="date" required>

                <div style="text-align:center;">
                    <button type="submit">Add Transaction</button>
                </div>

            </form>
        </div>

        <!-- HISTORY -->
        <div class="history-box">
            <h2>Transaction History</h2>

            <table>
                <tr>
                    <th>Date</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Description</th>
                </tr>

                <?php
                $result = mysqli_query($conn,"
                    SELECT * 
                    FROM transactions 
                    WHERE user_id='$user_id'
                    ORDER BY date DESC
                ");

                while($row = mysqli_fetch_assoc($result)){
                    echo "<tr>";
                    echo "<td>".$row['date']."</td>";
                    echo "<td>".$row['category']."</td>";
                    echo "<td>₹".$row['amount']."</td>";
                    echo "<td>".$row['description']."</td>";
                    echo "</tr>";
                }
                ?>

            </table>
        </div>

    </div>

</div>

<script>
function toggleMenu(){
    var menu = document.getElementById("dropdownMenu");
    menu.style.display =
    menu.style.display === "block" ? "none" : "block";
}
</script>

</body>
</html>