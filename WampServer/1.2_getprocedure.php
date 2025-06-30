<?php
$servername = "localhost";
$username = "root";
$password = "0812";
$database = "autoauction";

// 创建数据库连接
$conn = new mysqli($servername, $username, $password, $database);

// 检查数据库连接
if ($conn->connect_error) {
    die("连接数据库失败: " . $conn->connect_error);
} else {
    echo "数据库连接成功<br>";
}

$procedureName = $_GET['procedure']; // 从客户端页面获取要执行的存储过程名称
echo "请求的存储过程是: " . $procedureName . "<br>";

// 确保存储过程名称有效，以避免潜在的安全问题
$validProcedures = array('AvailableFords', 'AvailableChevs', 'MaxBid'); // 添加其他有效存储过程名称
if (!in_array($procedureName, $validProcedures)) {
    die("无效的存储过程名称: " . $procedureName);
} else {
    echo "执行存储过程: " . $procedureName . "<br>";
}

// 执行存储过程
$sql = "CALL ${procedureName}()";
    // 执行存储过程查询
    if ($conn->multi_query($sql)) {
        // 获取存储过程结果
        do {
            if ($result = $conn->store_result()) {
                echo "<table border='1' class='${procedureName}-table'>
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
                
                $result->free();
            }
        } while ($conn->more_results() && $conn->next_result());
    } else {
        echo "调用存储过程失败: " . $conn->error;
    }


$conn->close();
?>
