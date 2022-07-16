<?php
$conn = new mysqli('localhost', 'root', '', 'paybuddy');
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (!empty($_POST["email"]) and !empty($_POST["pwd"]) and isset($_POST["email"]) and isset($_POST["pwd"])) {

        $email = $_POST["email"];
        $password = $_POST["pwd"];
        session_start();
        $_SESSION['email'] = $email;
        $sql = "Select * from registration where email='$email' AND password='$password'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $sql1 = "SELECT * FROM registration WHERE email = ?";

        if ($stmt1 = mysqli_prepare($conn, $sql1)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt1, "s", $param_email);

            $param_email = $_SESSION['email'];


            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt1)) {
                $result = mysqli_stmt_get_result($stmt1);

                if (mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $id = $row["id"];
                    $_SESSION["id"] = $id;
            header("location: /paybook/paybook.html");
            exit();
                }
            }
        }
        } else {
            echo " You Have Entered Incorrect Password";
            exit();
        }
    }
}