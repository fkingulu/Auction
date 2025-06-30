<?php
session_start();

if (isset($_POST["customerID"])) {
    $customerID = $_POST["customerID"];
    
    $servername = "localhost";
    $username = "root";
    $password = "0812";
    $database = "autoauction";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("连接数据库失败: " . $conn->connect_error);
    }

    // 查询 customers 表格以检查匹配的 CustomerID
    $sql = "SELECT * FROM customers WHERE CustomerID = '$customerID'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // 登录成功，将 CustomerID 存储在会话中
        $_SESSION["customerID"] = $customerID;
        $redirectURL = "1_client.php?customerID=" . urlencode($customerID);
        header("Location: $redirectURL"); // 重定向到客户端页面，并传递 CustomerID
        exit(); // 终止脚本以确保重定向生效
    } else {
        echo "登录失败，请检查 CustomerID。";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登录</title>
    <style>
        /* 添加背景视频 */
        .video-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        }

        video {
        min-width: 100%;
        min-height: 100%;
        width: auto;
        height: auto;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        }
        /* 修改文本颜色 */
        body {
        color: #fff; /* 更明亮的文本颜色，可以根据需要调整 */
        }

        /* 透明的输入框 */
        input[type="text"], input[type="password"] {
            background-color: transparent; /* 输入框背景透明 */
            border: 1px solid #ff00ff; /* 添加边框 */
            border-radius: 5px; /* 圆角边框 */
            padding: 5px; /* 内边距，根据需要调整 */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* 阴影效果 */
            color: #ffffff; /* 文本颜色，根据需要调整 */
            transition: border-color 0.3s, transform 0.2s;
        }

        /* 鼠标悬停时修改输入框边框颜色 */
        input[type="text"]:hover, input[type="password"]:hover {
            border-color: #ffffff; /* 悬停时的边框颜色 */
        }

        /* 透明的按钮 */
        input[type="submit"] {
            background-color: transparent; /* 按钮背景透明 */
            color: #ff00ff; /* 按钮文本颜色 */
            border: 1px solid #ff00ff; /* 添加边框 */
            border-radius: 5px; /* 圆角边框 */
            padding: 10px 20px; /* 内边距，根据需要调整 */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* 阴影效果 */
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s, transform 0.2s;
        }

        /* 鼠标悬停时修改按钮透明度和边框颜色 */
        input[type="submit"]:hover {
            background-color: rgba(255, 0, 255, 0.2); /* 悬停时的背景透明度 */
            border-color: #ff00ff; /* 悬停时的边框颜色 */
            transform: scale(1.05); /* 缩放效果，可以根据需要调整 */
        }
    </style>
</head>
<body>
    <!-- 视频容器 -->
    <div class="video-container">
        <video autoplay loop muted>
        <source src="../H2.mp4" type="video/mp4">
        <!-- 如果需要，可以添加其他视频格式的源 -->
        Your browser does not support the video tag.
        </video>
    </div>
    <h2>登录</h2>
    <form action="2_login.php" method="POST">
        <label for="customerID">CustomerID:</label>
        <input type="text" id="customerID" name="customerID" required>
        <br>
        <input type="submit" value="登录">
    </form>
</body>
</html>
