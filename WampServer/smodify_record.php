<!-- smodify_record.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>修改记录</title>
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $conn = new mysqli("localhost", "root", "0812", "autoauction");

        if ($conn->connect_error) {
            die("连接数据库失败：" . $conn->connect_error);
        }

        $tableName = $_POST['table_name'];

        // 查询获取表格的主键列名
        $primaryKeyQuery = "SHOW KEYS FROM $tableName WHERE Key_name = 'PRIMARY'";
        $primaryKeyResult = $conn->query($primaryKeyQuery);

        $primaryKeyColumn = "";
        if ($primaryKeyResult->num_rows > 0) {
            $primaryKeyRow = $primaryKeyResult->fetch_assoc();
            $primaryKeyColumn = $primaryKeyRow['Column_name'];
        }

        // 添加一个字段用于输入主键值
        echo "<h1>修改记录：</h1>";
        echo "<form method='post' action='supdate_record.php'>";
        echo "<input type='hidden' name='table_name' value='$tableName'>";
        echo "<input type='hidden' name='primary_key_column' value='$primaryKeyColumn'>"; // 传递主键列名
        echo "<label for='primary_key_value'>主键值：</label>";
        echo "<input type='text' id='primary_key_value' name='primary_key_value' value='' required><br><br>";

        // 查询获取表格的所有列信息
        $columnsResult = $conn->query("SHOW COLUMNS FROM $tableName");

        if ($columnsResult->num_rows > 0) {
            while ($columnRow = $columnsResult->fetch_assoc()) {
                $columnName = $columnRow['Field'];
                echo "<label for='$columnName'>$columnName ：</label>";
                echo "<input type='text' id='$columnName' name='$columnName' value='' required><br><br>";
            }
            echo "<input type='submit' value='保存修改'>";
        } else {
            echo "表格中没有列信息。";
        }

        echo "</form>";

        $conn->close();
    }
    ?>
</body>
</html>
<!-- 
首先，通过 if ($_SERVER["REQUEST_METHOD"] == "POST") 检查是否收到了POST请求，以确保代码只在表单提交时执行。

从表单中获取了表格名称 $tableName，这是通过隐藏的输入字段传递的。

执行一个SQL查询来获取指定表格的主键列名。通过使用 SHOW KEYS 查询，检查 Key_name 为 'PRIMARY' 的行来确定主键列。查询结果存储在变量 $primaryKeyResult 中。

如果查询返回结果，表示找到了主键列，则从结果中提取主键列的名称，并将其存储在变量 $primaryKeyColumn 中。

接着，创建一个表单用于修改记录。表单的 action 属性指向 supdate_record.php，即在提交后将数据发送到 supdate_record.php 处理。

在表单中使用隐藏的输入字段存储了表格名称 $tableName 和主键列名称 $primaryKeyColumn，以便在后续处理中使用。

添加一个用于输入主键值的字段。用户需要输入要修改的记录的主键值，这是唯一标识要修改的记录的方式。

查询获取表格的所有列信息，使用 SHOW COLUMNS 查询。如果查询返回结果，表示找到了列信息，则循环遍历每一列，为每一列生成一个文本输入框，允许用户输入修改后的值。

在表单末尾添加一个提交按钮，以便用户可以保存对记录的修改。

如果查询没有返回列信息，会显示消息 "表格中没有列信息。"。
-->