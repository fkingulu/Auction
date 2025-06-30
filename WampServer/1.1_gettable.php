<?php
$servername = "localhost";
$username = "root";
$password = "0812";
$database = "autoauction";

// 创建数据库连接
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("连接数据库失败: " . $conn->connect_error);
}

$tableName = $_GET['table']; // 从客户端页面获取要显示的表格名称

// 确保表格名称有效，以避免潜在的SQL注入
$validTables = array('vehicles', 'bids'); // 添加其他有效表格名称
if (!in_array($tableName, $validTables)) {
    die("无效的表格名称");
}

// 查询数据库中的数据
$sql = "SELECT * FROM $tableName";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 输出数据表格
    echo "<table border='1'>
            <tr>";
    
    // 动态生成表头列名
    $row = $result->fetch_assoc();
    foreach ($row as $columnName => $value) {
        echo "<th>$columnName</th>";
    }
    
    echo "</tr>";
    
    // 输出表格数据
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . $value . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "没有找到数据";
}


$conn->close();
?>
