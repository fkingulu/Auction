<!-- delete.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>选择要删除的数据</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1, h2 {
            color: #333;
            margin-bottom: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        input[type="checkbox"] {
            margin-right: 5px;
        }
        input[type="submit"] {
            padding: 8px 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php
    $conn = new mysqli("localhost", "root", "0812", "autoauction");

    if ($conn->connect_error) {
        die("连接数据库失败: " . $conn->connect_error);
    }

    $tableName = $_GET['table'];
    echo "<h1>表格名称： $tableName</h1>";

    $dataResult = $conn->query("SELECT * FROM $tableName");

    if ($dataResult->num_rows > 0) {
        echo "<h2>表格数据：</h2>";
        echo "<form method='post' action='tdelete_result.php?table=$tableName'>"; // 提交到 delete_result.php 页面
        echo "<table border='3'>";
        echo "<tr><th>选择</th>";

        $columnNames = []; // 用于存储列名
        while ($columnRow = $dataResult->fetch_field()) {
            $columnName = $columnRow->name;
            $columnNames[] = $columnName; // 将列名添加到数组中
            echo "<th>$columnName</th>";
        }

        echo "</tr>";

        while ($row = $dataResult->fetch_assoc()) {
            echo "<tr>";
            echo "<td><input type='checkbox' name='delete_ids[]' value='{$row[$columnNames[0]]}'></td>";
            
            foreach ($columnNames as $columnName) {
                echo "<td>{$row[$columnName]}</td>";
            }
            
            echo "</tr>";
        }

        echo "</table>";
        echo "<input type='submit' value='删除选定的数据'>";
        echo "</form>";
    } else {
        echo "表格中没有数据。";
    }

    $conn->close();
    ?>

    
</body>
</html>
