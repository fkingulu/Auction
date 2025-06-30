<!-- search.php -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "0812", "autoauction");

    if ($conn->connect_error) {
        die("连接数据库失败：" . $conn->connect_error);
    }

    $tableName = $_POST['table_name'];
    $conditions = [];

    // 获取用户输入的条件
    foreach ($_POST as $columnName => $value) {
        if ($columnName != 'table_name' && !empty($value)) {
            $conditions[] = "$columnName = '$value'";
        }
    }

    if (!empty($conditions)) {
        $whereClause = implode(" AND ", $conditions);
        $sql = "SELECT * FROM $tableName WHERE $whereClause";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h1>查找结果：</h1>";
            echo "<table border='3'>";
            $columnNames = [];
            while ($fieldInfo = $result->fetch_field()) {
                $columnNames[] = $fieldInfo->name;
            }
            echo "<tr>";
            foreach ($columnNames as $columnName) {
                echo "<th>$columnName</th>";
            }
            echo "</tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($columnNames as $columnName) {
                    echo "<td>{$row[$columnName]}</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
            echo "<a href='search_form.php?table=$tableName'><br/>返回查找</a>";
        } else {
            echo "未找到匹配的记录。";
            echo "<a href='search_form.php?table=$tableName'><br/>返回查找</a>";
        }
    } else {
        echo "请输入搜索条件。";
    }

    $conn->close();
}
?>
