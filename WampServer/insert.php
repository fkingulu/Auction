<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>插入结果</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        p {
            margin-bottom: 10px;
        }
        a {
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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $conn = new mysqli("localhost", "root", "0812", "autoauction");

        if ($conn->connect_error) {
            die("连接数据库失败：" . $conn->connect_error);
        }

        $tableName = $_POST['table_name'];

        // 获取用户输入的数据
        $data = [];
        foreach ($_POST as $key => $value) {
            if ($key != 'table_name') {
                $data[$key] = $value;
            }
        }

        // 构建 SQL 插入语句
        $columns = implode(", ", array_keys($data));
        $values = "'" . implode("', '", $data) . "'";
        $sql = "INSERT INTO $tableName ($columns) VALUES ($values)";

        if ($conn->query($sql) === TRUE) {
            echo "<h2>记录插入成功</h2>";
            echo "<p><a href='view.php?table=$tableName'>返回查看表格</a></p>";
        } else {
            echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
            echo "<p><a href='view.php?table=$tableName'>返回查看表格</a></p>";
        }

        $conn->close();
    }
    ?>
</body>
</html>

<!-- 从表单中获取了表名 $tableName，这是通过隐藏的输入字段传递的。

创建了一个空数组 $data 用于存储用户输入的数据。

使用 foreach 循环遍历 $_POST 中的所有数据，将除了表名字段以外的数据都存储到 $data 数组中。

构建了一个SQL插入语句，使用 $data 数组中的键（字段名）和值（用户输入的数据）：

$columns 存储了所有字段名，用 , 分隔。
$values 存储了所有字段值，每个值被单引号包裹，并用 , 分隔。
执行 SQL 插入语句，将用户输入的数据插入到指定的数据表中。 -->