<?php
session_start();

if (isset($_POST["customerID"]) && isset($_POST["LastName"]) && isset($_POST["FirstName"]) && isset($_POST["Address"]) && isset($_POST["City"]) && isset($_POST["State"]) && isset($_POST["Zip"]) && isset($_POST["Telephone"]) && isset($_POST["AutoID"]) && isset($_POST["BidDate"]) && isset($_POST["BidPrice"])) {
    $customerID = $_POST["customerID"];
    $lastname = $_POST["LastName"];
    $firstname = $_POST["FirstName"];
    $address = $_POST["Address"];
    $city = $_POST["City"];
    $state = $_POST["State"];
    $zip = $_POST["Zip"];
    $telephone = $_POST["Telephone"];
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

    // 开始事务
    $conn->begin_transaction();

    $sql1 = "INSERT INTO customers (CustomerID, LastName, FirstName, Address, City, State, Zip, Telephone) VALUES ('$customerID','$lastname','$firstname','$address','$city','$state','$zip','$telephone')";
    $sql2 = "INSERT INTO bids (CustomerID, AutoID, BidDate, BidPrice) VALUES ('$customerID', '$autoID', '$bidDate', '$bidPrice')";

    $success = true;

    if (!$conn->query($sql1) || !$conn->query($sql2)) {
        // 如果任何一个插入操作失败，标记事务为失败
        $success = false;
    }

    if ($success) {
        // 如果两个插入操作都成功，提交事务
        $conn->commit();
        $_SESSION["customerID"] = $customerID;
        $redirectURL = "1_client.php?customerID=" . urlencode($customerID);
        header("Location: $redirectURL");
        exit();
        echo "注册成功！";
    } else {
        echo "注册失败: " . $conn->error;
        // 如果有任何一个插入操作失败，回滚事务
        $conn->rollback();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>注册</title>
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
    <h2>注册</h2>
    <form action="2_register.php" method="POST">
        <label for="customerID">CustomerID:</label>
        <input type="text" id="customerID" name="customerID" required>
        <br>
        <label for="LastName">LastName:</label>
        <input type="text" id="LastName" name="LastName" required>
        <br>
        <label for="FirstName">FirstName:</label>
        <input type="text" id="FirstName" name="FirstName" required>
        <br>
        <label for="Address">Address:</label>
        <input type="text" id="Address" name="Address" required>
        <br>
        <label for="City">City:</label>
        <input type="text" id="City" name="City" required>
        <br>
        <label for="State">State:</label>
        <input type="text" id="State" name="State" required>
        <br>
        <label for="Zip">Zip:</label>
        <input type="text" id="Zip" name="Zip" required>
        <br>
        <label for="Telephone">Telephone:</label>
        <input type="text" id="Telephone" name="Telephone" required>
        <br>
        <label for="AutoID">AutoID:</label>
        <input type="text" id="AutoID" name="AutoID" required>
        <br>
        <label for="BidDate">BidDate:</label>
        <input type="text" id="BidDate" name="BidDate" required>
        <br>
        <label for="BidPrice">BidPrice:</label>
        <input type="text" id="BidPrice" name="BidPrice" required>
        <br>
        <input type="submit" value="注册">
    </form>
</body>
</html>
