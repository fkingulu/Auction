<?php
session_start();

$customerID = 0;
    
$servername = "localhost";
$username = "root";
$password = "0812";
$database = "autoauction";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("连接数据库失败: " . $conn->connect_error);
}

// 登录成功，将 CustomerID 存储在会话中
$_SESSION["customerID"] = $customerID;
$redirectURL = "1_client.php?customerID=" . urlencode($customerID);
header("Location: $redirectURL"); // 重定向到客户端页面，并传递 CustomerID
exit(); // 终止脚本以确保重定向生效


$conn->close();
?>



