<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/newbook.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>PayBuddy</title>
</head>

<body>
    <div class="area">
        <span class="context">
            <h1>PayBuddy</h1>
        </span>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <div class="d-flex align-items-end flex-column" style="height: 200px;">
                <div class="p-2"><span style="color:white">Book name</span></div>
                <div class="p-2"><input type="text" name="name" id="name" class="b_name" placeholder="e.g. Daily Expense"></div>
                <div class="s mt-auto p-2 "><input type="submit" value="Save" class="save"></div>
            </div>
        </form>

    </div>
</body>

</html>


<?php

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" and !empty($_POST["name"])) {

    $name = ($_POST["name"]);

    // Initialize the session
    session_start();

    // Store the submitted data sent
    // via POST method, stored 

    // Temporarily in $_POST structure.
    $_SESSION['name'] = $name;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {


        // $name = $_POST['name'];
        $sql1 = "SELECT * FROM registration WHERE email = ?";

        if ($stmt1 = mysqli_prepare($link, $sql1)) {
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
                    $sql = "INSERT INTO book (name,id) VALUES (?,?)";

                    if ($stmt = mysqli_prepare($link, $sql)) {
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "si", $param_name, $id);

                        // Set parameters
                        $param_name = $name;
                        $_SESSION['name'] = $name;


                        // Attempt to execute the prepared statement
                        if (mysqli_stmt_execute($stmt)) {
                            // Records created successfully. Redirect to landing page
                            header("location: in&out.html");
                            exit();
                        } else {
                            echo "Something went wrong. Please try again later.";
                        }
                    }

                    // Close statement
                    mysqli_stmt_close($stmt);

                    // Close connection
                    mysqli_close($link);
                }
            }
        }
    }
}
