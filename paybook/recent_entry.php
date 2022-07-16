<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayBuddy</title>
    <link rel="stylesheet" href="/css/recent_entry.css">
</head>

<body>
    <span class="context">
        <h1>PayBuddy</h1>
    </span>
    <div class="table">
        <?php
        //here id = bookid

        if (isset($_GET["id"]) && !empty(($_GET["id"]))) {
            session_start();


            require_once "config.php";

            // Prepare a select statement
            $sql = "SELECT * FROM entry WHERE book_id = $_GET[id]";
            if ($result = mysqli_query($link, $sql)) {
                if (mysqli_num_rows($result) > 0) {
                    echo '<table>';
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Category</th>";
                    echo "<th>Amount</th>";
                    echo "<th>Payment Mode</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['category'] . "</td>";
                        echo "<td>" . $row['amount'] . "</td>";
                        echo "<td>" . $row['payment_mode'] . "</td>";
                        echo '<td class="temp">';
                        echo "<a href='delete_entry.php?id=" . $row['entry_id'] . "'>Delete entry</a>";
                        echo "&nbsp;";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    mysqli_free_result($result);

                    // if ($stmt = mysqli_prepare($link, $sql)) {
                    //     // Bind variables to the prepared statement as parameters
                    //     mysqli_stmt_bind_param($stmt, "i", $_GET['id']);

                    //     if (mysqli_stmt_execute($stmt)) {
                    //     } 
                    // }

                } else {
                    echo '<div class="text">Oops! Your book is empty.</div>';
                }
            }
            $_SESSION['book_id'] = $_GET['id'];
            // mysqli_stmt_close($stmt);

            // Close connection
            mysqli_close($link);
        }

        ?>
        <div class="link">
            <?php echo "<a href='add_entry2.php'>Add entries</a>" ?>&nbsp;
            <?php echo "<a href='total_in_2.php' style='
    width: 81px;
'>Cash in</a>" ?>&nbsp;
        </div>
    </div>

    <form action="paybook.html" method="post" class="home_f">
        <input type="submit" value="Home" class="home">
    </form>

</body>

</html>