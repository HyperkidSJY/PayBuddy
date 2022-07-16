<?php
require_once 'config.php';

session_start();
$reg_id = $_SESSION['id'];
$total_in = 0;
$name = $_SESSION['name'];

$sql = "SELECT book_id FROM book WHERE name=? AND id=? ;";
if ($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "si", $param_name, $param_id);
    $param_name = $name;
    $param_id = $reg_id;
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {

            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $book_id = $row["book_id"];
        }
    }
}

$sql = "SELECT total_in FROM book WHERE book_id=? ;";
if ($stmt3 = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt3, "i", $param_book_id);
    $param_book_id = $book_id;
    if (mysqli_stmt_execute($stmt3)) {
        $result = mysqli_stmt_get_result($stmt3);

        if (mysqli_num_rows($result) == 1) {

            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $old_total_in = $row["total_in"];
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayBuddy</title>
    <link rel="stylesheet" href="/css/total_in.css">
</head>

<body>
    <span class="logout">
        <a href="/index.html" target="_self">Log Out</a>
    </span>
    <span class="context">
        <h1>PayBuddy</h1>
    </span>


    <div class="login-body">
        <div class="login-div">
            <div class="login-content">
                <div class="hybrid-login-form-main">
                    <h1>CASH IN</h1>
                    <form method="post" class="login-form">
                        <div class="nfemail">
                            <div class="nfemailcontrol">
                                <label for="total_in" class="placelabel">Enter Amount</label>

                                <input type="int" id="total_in" name="total_in" class="emailinput" />
                            </div>
                        </div>
                        <div class="empty">
                            <?php
                            if (empty($_POST['total_in'])) {

                                echo "Please fill in the fields";
                            } else {
                                $total_in = $_POST['total_in'];
                            } ?>
                        </div>

                        <button type="submit" value="submit" class="btn login-button btn-submit btn-small"> Submit</button>

                    </form>
                    <form action="paybook.html" method="post">

                        <button type="submit" value="home" class="btn login-button btn-submit btn-small">Home</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>


    </div>
</body>

</html>







<?php
$sql1 = "UPDATE book SET total_in=? WHERE book_id=$book_id";

if ($stmt1 = mysqli_prepare($link, $sql1)) {


    mysqli_stmt_bind_param($stmt1, "i", $param_total_in);


    $param_total_in = $total_in + $old_total_in;

    if (mysqli_stmt_execute($stmt1)) {

        exit();
    } else {
        echo "Something went wrong. Please try again later.";
    }
}


mysqli_stmt_close($stmt1);
mysqli_stmt_close($stmt);


mysqli_close($link);


?>