<?php
require_once "config.php";
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "DELETE FROM entry WHERE entry_id = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        //which id you want to delete
        $param_id = $id;
        session_start();
        if (mysqli_stmt_execute($stmt)) {
            // Records updated successfully. Redirect to reading page
            header("location: recent_entry.php?id=" . $_SESSION['book_id'] . "");
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($link);
}
?>
