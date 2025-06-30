<!-- select_record.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>选择记录修改</title>
</head>
<body>
    <?php
    $conn = new mysqli("localhost", "root", "0812", "autoauction");

    if ($conn->connect_error) {
        die("连接数据库失败: " . $conn->connect_error);
    }

    $tableName = $_GET['table'];
    echo "<h1>表格名称： $tableName</h1>";

    // 查询获取表格的主键列名
    $primaryKeyQuery = "SHOW KEYS FROM $tableName WHERE Key_name = 'PRIMARY'";
    $primaryKeyResult = $conn->query($primaryKeyQuery);

    $primaryKeyColumn = "";
    if ($primaryKeyResult->num_rows > 0) {
        $primaryKeyRow = $primaryKeyResult->fetch_assoc();
        $primaryKeyColumn = $primaryKeyRow['Column_name'];
    }

    $dataResult = $conn->query("SELECT * FROM $tableName");

    if ($dataResult->num_rows > 0) {
        echo "<h2>选择要修改的记录：</h2>";
        echo "<form method='post' action='smodify_record.php'>";
        echo "<input type='hidden' name='table_name' value='$tableName'>";
        echo "<input type='hidden' name='primary_key_column' value='$primaryKeyColumn'>";
        echo "<table border='3'>";
        $columnNames = [];
        while ($fieldInfo = $dataResult->fetch_field()) {
            $columnNames[] = $fieldInfo->name;
        }
        echo "<tr>";
        foreach ($columnNames as $columnName) {
            echo "<th>$columnName</th>";
        }
        echo "<th>操作</th>";
        echo "</tr>";
        while ($row = $dataResult->fetch_assoc()) {
            echo "<tr>";
            foreach ($columnNames as $columnName) {
                echo "<td>{$row[$columnName]}</td>";
            }
            echo "<td><input type='submit' name='modify' value='修改'></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</form>";
    } else {
        echo "表格中没有数据。";
    }

    $conn->close();
    ?>
</body>
</html>
<!-- 
从URL的GET参数中获取表格名称，参数名为 table，并将其存储在变量 $tableName 中。然后，使用 echo 语句在页面上显示表格的名称。

执行一个SQL查询来获取指定表格的主键列名。通过使用 SHOW KEYS 查询，检查 Key_name 为 'PRIMARY' 的行来确定主键列。查询结果存储在变量 $primaryKeyResult 中。

如果查询返回结果，表示找到了主键列，则从结果中提取主键列的名称，并将其存储在变量 $primaryKeyColumn 中。

执行一个SQL查询，从指定的表格中检索所有数据，并将结果存储在变量 $dataResult 中。

如果查询返回结果（表格中有数据），则代码会生成一个用于选择要修改的记录的表单。表单的 action 属性指向 smodify_record.php，即在提交后将数据发送到 smodify_record.php 处理。

在表单中使用隐藏的输入字段存储了表格名称 $tableName 和主键列名称 $primaryKeyColumn，以便在后续处理中使用。

使用表格（<table>）来呈现查询结果。首先，通过循环遍历表格的列名，并在表头中显示这些列名。然后，通过循环遍历数据行，将每一行的数据显示在表格中，并为每一行添加一个 "修改" 的提交按钮，以便用户可以选择要修改的记录。

如果查询没有返回结果（表格中没有数据），则会显示消息 "表格中没有数据。"。
-->
