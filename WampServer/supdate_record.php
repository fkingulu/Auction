<!-- supdate_record.php -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "0812", "autoauction");

    if ($conn->connect_error) {
        die("连接数据库失败：" . $conn->connect_error);
    }

    $tableName = $_POST['table_name'];
    $primaryKeyValue = $_POST['primary_key_value'];
    $primaryKeyColumn = $_POST['primary_key_column']; // 接收主键列名
    $updates = [];

    // 获取用户输入的更新数据
    foreach ($_POST as $columnName => $value) {
        if ($columnName != 'table_name' && $columnName != 'primary_key_value' && $columnName != 'primary_key_column') {
            $updates[] = "$columnName = '$value'";
        }
    }

    if (!empty($updates)) {
        $updateClause = implode(", ", $updates);
        $sql = "UPDATE $tableName SET $updateClause WHERE $primaryKeyColumn = '$primaryKeyValue'"; // 使用传递的主键列名

        if ($conn->query($sql) === TRUE) {
            echo "记录更新成功<br>";
            echo "<a href='view.php?table=$tableName'>返回查看表格</a>"; // 提供返回链接
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "请输入要修改的数据。";
    }

    $conn->close();
}
?>
<!-- 
从$_POST数组中获取以下数据：

$tableName：要更新的表格的名称。
$primaryKeyValue：要更新的记录的主键值。
$primaryKeyColumn：主键列的名称，这是用于唯一标识要更新的记录的列名。
$updates数组：用于存储用户输入的更新数据。
使用foreach循环遍历$_POST数组，将每个列名（字段名）和对应的值添加到$updates数组中。这个循环排除了table_name、primary_key_value和primary_key_column这三个字段，因为它们不是要更新的数据。

检查$updates数组是否为空，如果不为空，表示用户输入了要更新的数据。然后，将$updates数组中的元素用逗号分隔，并构建一个SQL UPDATE语句，用于将用户输入的更新应用到数据库中。主要语句部分包括SET子句和WHERE子句，其中SET子句用于指定要更新的列和对应的新值，WHERE子句用于指定要更新的记录，通过主键值和主键列名唯一标识。

如果更新操作成功执行（$conn->query($sql) === TRUE），则输出"记录更新成功"的消息，并提供一个链接，让用户返回查看表格的页面。

如果更新操作失败，输出错误消息，包括SQL语句和数据库连接的错误信息。

如果$updates数组为空，表示用户没有输入要更新的数据，输出"请输入要修改的数据"的消息。
-->