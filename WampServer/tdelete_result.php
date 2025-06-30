<!-- delete_result.php -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "0812", "autoauction");

    if ($conn->connect_error) {
        die("连接数据库失败：" . $conn->connect_error);
    }

    $tableName = $_GET['table'];

    // 获取列名
    $columnNames = [];
    $dataResult = $conn->query("SELECT * FROM $tableName");
    while ($columnRow = $dataResult->fetch_field()) {
        $columnName = $columnRow->name;
        $columnNames[] = $columnName;
    }

    if (isset($_POST['delete_ids'])) {
        $deleteIds = $_POST['delete_ids'];
        if (!empty($deleteIds)) {
            $deleteIdsStr = implode("', '", $deleteIds); // 在每个值周围添加单引号
            $sql = "DELETE FROM $tableName WHERE {$columnNames[0]} IN ('$deleteIdsStr')";


            if ($conn->query($sql) === TRUE) {
                echo "已成功删除选定的数据。<br>";
                echo "<a href='view.php?table=$tableName'>返回查看表格</a>"; // 提供返回链接
            } else {
                echo "删除数据时出现错误：" . $conn->error . "<br>";
            }
        }
    }

    $conn->close();
}
?>
