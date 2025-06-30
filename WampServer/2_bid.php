<?php
session_start();

if (isset($_POST["AutoID"]) && isset($_POST["BidDate"]) && isset($_POST["BidPrice"])) {
    $customerID = $_SESSION["customerID"]; // 从全局Session获取customerID
    $autoID = $_POST["AutoID"];
    $bidDate = $_POST["BidDate"];
    $bidPrice = $_POST["BidPrice"];
    
    $servername = "localhost";
    $username = "root";
    $password = "0812";
    $database = "autoauction";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("连接数据库失败: " . $conn->connect_error);
    }

    $sql = "INSERT INTO bids (CustomerID, AutoID, BidDate, BidPrice) VALUES ('$customerID', '$autoID', '$bidDate', '$bidPrice')";

    if ($conn->query($sql) === TRUE) {
        // 插入成功后，重定向回客户端页面
        $redirectURL = "1_client.php?customerID=" . urlencode($customerID);
        header("Location: $redirectURL"); 
        exit();
    } else {
        echo "竞标失败: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>竞标</title>
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
    <h2>竞标</h2>
    <form action="2_bid.php" method="POST">
        <label for="AutoID">AutoID:</label>
        <input type="text" id="AutoID" name="AutoID" required>
        <br>
        <label for="BidDate">BidDate:</label>
        <input type="text" id="BidDate" name="BidDate" required>
        <br>
        <label for="BidPrice">BidPrice:</label>
        <input type="text" id="BidPrice" name="BidPrice" required>
        <br>
        <input type="submit" value="竞标">
    </form>
</body>
</html>
