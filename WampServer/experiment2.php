<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>数据库管理</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            color: #333;
        }
        a {
            display: block;
            margin-bottom: 5px;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<?php
    $conn = new mysqli("localhost", "root", "0812", "autoauction");

    if ($conn->connect_error) {
        die("连接数据库失败: " . $conn->connect_error);
    }

    $result = $conn->query("SHOW TABLES");
    if ($result->num_rows > 0) {
        echo "<h1>数据库中的表格：</h1>";
        while ($row = $result->fetch_assoc()) {
            $tableName = $row['Tables_in_autoauction'];
            echo "<a href='view.php?table=$tableName'>$tableName</a><br>";
        }
    } else {
        echo "数据库中没有表格。";
    }

    $conn->close();
    ?>
</body>
</html>