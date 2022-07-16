<?php
require_once "config.php";
if (isset($_GET["id"]) && !empty(($_GET["id"]))) {

    $id = $_GET["id"];
    $sql = "SELECT * FROM entry WHERE book_id = $id";
    // echo($row['entry_id']);



    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $temp
                    = $row['entry_id'];
                $sql1 = "DELETE FROM entry WHERE entry_id = ?";
                // echo ($row["entry_id"]);
                $stmt = mysqli_prepare($link, $sql1);
                mysqli_stmt_bind_param($stmt, "i", $param_id);
                $param_id=$temp;
                mysqli_stmt_execute($stmt); 
                    

                    // header("location: index.php");
                    // exit();
                
            }
            mysqli_stmt_close($stmt);
            mysqli_free_result($result);
            
        } else {
            echo '<em>No records were found.</em>';
        }
        $sql2 = "DELETE FROM book WHERE book_id = ?";

        if ($stmt1 = mysqli_prepare($link, $sql2)) {
            mysqli_stmt_bind_param($stmt1, "i", $param_id);

            //which id you want to delete
            $param_id = $id;

            if (mysqli_stmt_execute($stmt1)) {
                // Records updated successfully. Redirect to reading page
                header("location: recent.php");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt1);
        mysqli_close($link);

        // $sql2 = "DELETE FROM book WHERE book_id = ?";

        // if ($stmt1 = mysqli_prepare($link, $sql2)) {
        //     mysqli_stmt_bind_param($stmt1, "i", $param_id);

        //     //which id you want to delete
        //     $param_id = $id;

        //     if (mysqli_stmt_execute($stmt1)) {
        //         // Records updated successfully. Redirect to reading page
        //         header("location: recent.php");
        //     } else {
        //         echo "Oops! Something went wrong. Please try again later.";
        //     }
        // }
        // mysqli_stmt_close($stmt1);
        // mysqli_close($link);
    }

    // if (isset($_GET["id"]) && !empty(($_GET["id"]))) {
    //     $id = $_GET["id"];
    //     $sql = "DELETE FROM entry WHERE book_id = ?";
    //     if ($stmt = mysqli_prepare($link, $sql)) {
    //         mysqli_stmt_bind_param($stmt, "i", $param_id);

    //         //which id you want to delete
    //         $param_id = $id;
    //     }
    //     mysqli_stmt_close($stmt);


    
}
