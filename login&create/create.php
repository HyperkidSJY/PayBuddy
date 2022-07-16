<?php
$conn = new mysqli('localhost','root','','paybuddy');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $password = trim($_POST["password"]);

    
    if($conn->connect_error){
        echo "$conn->connect_error";
        die("Connection Failed : ". $conn->connect_error);
    } else {
        $stmt = $conn->prepare("insert into registration(firstname, lastname, email, phone, password) values(?, ?, ?, ?, ?)");
        $stmt->bind_param("sssis", $firstname, $lastname, $email, $phone,$password );
        if(mysqli_stmt_execute($stmt)){
            header("location: /html/redirect.html");
        }
        $stmt->close();
        $conn->close();
    }
}
