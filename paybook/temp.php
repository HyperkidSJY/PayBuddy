<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayBuddy</title>
    <link rel="stylesheet" href="/css/recent.css">
</head>

<body>
    <span class="context">
        <h1>PayBuddy</h1>
    </span>

    <div class="table">
        <?php
        require 'config.php';
        session_start();
        $reg_id = $_SESSION['id'];
        $sql = "SELECT * FROM book WHERE id = $reg_id";
        if ($result = mysqli_query($link, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                echo '<table>';
                echo "<thead>";
                echo "<tr>";
                echo "<th>Name</th>";
                echo "<th>Total in</th>";
                echo "<th>Total out</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['total_in'] . "</td>";
                    echo "<td>" . $row['total_out'] . "</td>";
                    echo '<td class="temp">';
                    echo "<a href='recent_entry.php?id=" . $row['book_id'] . "'>View entries</a>";
                    echo "<a href='delete_book.php?id=" . $row['book_id'] . "'>Delete book</a>";
                    echo "&nbsp;";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                mysqli_free_result($result);
            } else {
                echo '<em>No records were found.</em>';
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        mysqli_close($link);
        ?>

    </div>


    <form action="paybook.html" method="post" class="home_f">
        <input type="submit" value="Home" class="home">
    </form>
</body>
