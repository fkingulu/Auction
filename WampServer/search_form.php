<!-- search_form.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>查找数据</title>
</head>
<body>
    <?php
    $conn = new mysqli("localhost", "root", "0812", "autoauction");

    if ($conn->connect_error) {
        die("连接数据库失败: " . $conn->connect_error);
    }

    $tableName = $_GET['table'];
    echo "<h1>表格名称： $tableName</h1>";

    // 查询获取表格的所有列信息
    $columnsResult = $conn->query("SHOW COLUMNS FROM $tableName");

    if ($columnsResult->num_rows > 0) {
        echo "<h2>表格列信息：</h2>";
        echo "<form method='post' action='search.php'>";
        echo "<input type='hidden' name='table_name' value='$tableName'>";
        while ($columnRow = $columnsResult->fetch_assoc()) {
            $columnName = $columnRow['Field'];
            echo "<label for='$columnName'>$columnName ：</label>";
            echo "<input type='text' id='$columnName' name='$columnName'><br><br>";
        }
        echo "<input type='submit' value='查找'>";
        echo "<a href='view.php?table=$tableName'><br/>返回查看表格</a>";
        echo "</form>";
    } else {
        echo "表格中没有列信息。";
    }

    $conn->close();
    ?>
</body>
</html>
