<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>查询车辆信息</title>
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
    <h2>查询车辆信息</h2>
    <form action="3_index.php" method="GET">
        <label for="autoID">AutoID:</label>
        <input type="text" id="autoID" name="autoID">
        <br>
        <label for="location">Location:</label>
        <input type="text" id="location" name="location">
        <br>
        <label for="year">Year:</label>
        <input type="text" id="year" name="year">
        <br>
        <label for="type">Type:</label>
        <input type="text" id="type" name="type">
        <br>
        <label for="mileage">最大里程:</label>
        <input type="text" id="mileage" name="mileage">
        <br>
        <label for="searchString">车型:</label>
        <input type="text" id="searchString" name="searchString">
        <br>
        <label for="earliest">最早生产年份:</label>
        <input type="text" id="earliest" name="earliest">
        <br>
        <input type="submit" value="查询">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // 获取查询参数
        $autoID = isset($_GET['autoID']) ? $_GET['autoID'] : '';
        $location = isset($_GET['location']) ? $_GET['location'] : '';
        $year = isset($_GET['year']) ? $_GET['year'] : '';
        $type = isset($_GET['type']) ? $_GET['type'] : '';
        $mileage = isset($_GET['mileage']) ? $_GET['mileage'] : '';
        $searchString = isset($_GET['searchString']) ? $_GET['searchString'] : '';
        $earliest = isset($_GET['earliest']) ? $_GET['earliest'] : '';


        // 构建SQL查询语句
        $sql = "SELECT * FROM vehicles WHERE 1=1";

        if (!empty($autoID)) {
            $sql .= " AND AutoID = '$autoID'";
        }
        if (!empty($location)) {
            $sql .= " AND Location = '$location'";
        }
        if (!empty($year)) {
            $sql .= " AND Year = '$year'";
        }
        if (!empty($type)) {
            $sql .= " AND Type = '$type'";
        }
        if (!empty($mileage) && is_numeric($mileage)) {
            $sql .= " AND Mileage < $mileage";
        }
        if (!empty($searchString)) {
            $sql .= " AND Type LIKE '%$searchString%'";
        }
        if (!empty($earliest)) {
            $sql .= " AND Year >= $earliest";
        }

        // 连接到数据库并执行查询
        $servername = "localhost";
        $username = "root";
        $password = "0812";
        $database = "autoauction";

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("连接数据库失败: " . $conn->connect_error);
        }

        $result = $conn->query($sql);

        // 显示查询结果
        if ($result->num_rows > 0) {
            echo "<h3>查询结果：</h3>";
            echo "<table border='1'>";
            echo "<tr><th>AutoID</th><th>Location</th><th>Year</th><th>Type</th><th>Mileage</th><th>Vin</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["AutoID"] . "</td>";
                echo "<td>" . $row["Location"] . "</td>";
                echo "<td>" . $row["Year"] . "</td>";
                echo "<td>" . $row["Type"] . "</td>";
                echo "<td>" . $row["Mileage"] . "</td>";
                echo "<td>" . $row["Vin"] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "未找到匹配的记录。";
        }

        $conn->close();
    }
    ?>
    <button onclick="goBack()">返回</button>
    <script>
        function goBack() {
            // 返回到1_client.php
            window.location.href = '1_client.php';
        }
    </script>

</body>
</html>
