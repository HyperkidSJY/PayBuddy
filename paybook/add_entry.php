<?php
require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/css/color.css">
    <link rel="stylesheet" href="/css/addentry.css">
    <title>Document</title>
</head>

<body>
    <span class="context">
        <h1>PayBuddy</h1>
    </span>

    <div class="login-body">
        <div class="login-div">
            <div class="login-content">
                <div class="hybrid-login-form-main">
                    <h1> Add Entry </h1>

                    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                        <div class="nffname">
                            <div class="nffnamecontrol">
                                <label for="category" class="placelabel">Category</label>
                                <input type="text" name="category" class="emailinput" /><br><br>

                            </div>
                        </div>

                        <label class="placelabel">Payment Mode</label>

                        <div class="wrapper">

                            <input type="radio" name="payment_mode" value="online" id="option-1" checked>
                            <input type="radio" name="payment_mode" id="option-2" value="cash">
                            <label for="option-1" class="option option-1">
                                <div class="dot"></div>
                                <span>Online</span>
                            </label>
                            <label for="option-2" class="option option-2">
                                <div class="dot"></div>
                                <span>Cash</span>
                            </label>
                        </div>
                        <div class="nffname">
                            <div class="nffnamecontrol">
                                <label for="amount" class="placelabel">amount</label>

                                <input type="text" name="amount" class="emailinput" /><br><br>
                            </div>
                        </div>
                        <button type="submit" value="submit" class="btn login-button btn-submit btn-small"> Add</button>

                    </form>
                    <form action="paybook.html" method="post">

                        <button type="submit" value="home" class="btn login-button btn-submit btn-small">Home</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_POST['category']) and  !empty($_POST['amount'])) {
        // $name = $_POST['name'];
        $sql1 = "SELECT * FROM book WHERE name = ?";

        if ($stmt1 = mysqli_prepare($link, $sql1)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt1, "s", $param_name);

            $param_name = $_SESSION['name'];


            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt1)) {
                $result = mysqli_stmt_get_result($stmt1);

                if (mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $id = $row["book_id"];


                    $category = trim($_POST["category"]);
                    $amount = $_POST["amount"];
                    $sql2 = "INSERT INTO entry (category,payment_mode,amount,book_id) VALUES (?, ?, ?,?)";

                    if ($stmt2 = mysqli_prepare($link, $sql2)) {
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt2, "ssii", $param_category, $param_mode, $param_amount, $param_book_id);

                        // Set parameters
                        $param_category = $category;
                        if (isset($_POST["payment_mode"])) {
                            $param_mode = $_POST['payment_mode'];
                        }
                        $param_amount = $amount;
                        $param_book_id = $id;
                        if (mysqli_stmt_execute($stmt2)) {
                        } else {
                            echo "Something went wrong. Please try again later.";
                        }
                    }
                }
            }
        }

        $sql3 = "SELECT total_out FROM book WHERE book_id=? ;";
        if ($stmt3 = mysqli_prepare($link, $sql3)) {
            mysqli_stmt_bind_param($stmt3, "i", $param_book_id);
            $param_book_id = $id;
            if (mysqli_stmt_execute($stmt3)) {
                $result = mysqli_stmt_get_result($stmt3);

                if (
                    mysqli_num_rows($result) == 1
                ) {

                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $old_total_out = $row["total_out"];
                }
            }
        }

        $sql4 = "UPDATE book SET total_out=? WHERE book_id=$id";

        if ($stmt4 = mysqli_prepare($link, $sql4)) {
            // Bind variables to the prepared statement as parameters

            mysqli_stmt_bind_param($stmt4, "i", $param_total_out);

            // Set parameters
            $param_total_out = $amount + $old_total_out;
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt4)) {
                // Records updated successfully. Redirect to landing page
                // header("location: add_entry.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }




        mysqli_stmt_close($stmt1);
        mysqli_stmt_close($stmt2);
        mysqli_stmt_close($stmt3);
        mysqli_stmt_close($stmt4);

        mysqli_close($link);
    }
}
?>