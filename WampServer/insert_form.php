<!-- insert_form.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>插入数据</title>
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
        ul {
            list-style: none;
            padding: 0;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            padding: 10px 20px;
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

    // 查询获取表格的所有列信息
    $columnsResult = $conn->query("SHOW COLUMNS FROM $tableName");

    if ($columnsResult->num_rows > 0) {
        echo "<h2>表格列信息：</h2>";
        echo "<ul>";
        $columnNames = []; // 在这里定义 $columnNames 变量
        while ($columnRow = $columnsResult->fetch_assoc()) {
            $columnName = $columnRow['Field'];
            $columnNames[] = $columnName; // 将列名添加到数组中
            echo "<li>$columnName</li>";
        }
        echo "</ul>";
    } else {
        echo "表格中没有列信息。";
    }

    $conn->close();
    ?>

    <br>

    <h2>插入数据：</h2>
    <form method="post" action="insert.php">
        <?php
        foreach ($columnNames as $columnName) {
            echo "<label for='$columnName'>$columnName ：</label>";
            echo "<input type='text' id='$columnName' name='$columnName' required><br><br>";
        }
        ?>
        <input type="hidden" name="table_name" value="<?php echo $tableName; ?>">
        <input type="submit" value="插入数据">
    </form>
</body>
</html>
<!-- 
<h2>插入数据：</h2>：这是一个HTML标题，用于显示在表单上方，表示这是一个用于插入数据的部分。

<form method="post" action="insert.php">：这是一个HTML表单，使用了POST方法提交数据，并将数据提交到 insert.php 页面进行处理。这意味着当用户点击"插入数据"按钮时，表单中的数据将被发送到 insert.php 页面。

foreach ($columnNames as $columnName)：这是一个PHP的foreach循环，用于遍历名为 $columnNames 的数组。每次循环迭代，它会将当前字段的名称存储在变量 $columnName 中。

echo "<label for='$columnName'>$columnName ：</label>";：在表单中，这行代码生成一个 <label> 标签，用于描述字段，同时使用 $columnName 作为标签的文本内容。for 属性与 <input> 元素的 id 属性关联，以确保点击标签时可以聚焦到相应的输入字段。

echo "<input type='text' id='$columnName' name='$columnName' required><br><br>";：这行代码生成一个文本输入框（<input type='text'>），id 和 name 属性都设置为当前字段的名称 $columnName，以便在后端处理数据时能够识别字段。required 属性表示这是一个必填字段。

<input type="hidden" name="table_name" value="<?php echo $tableName; ?>">：这是一个隐藏的输入字段，它的名称是 table_name，值是 $tableName 变量的值。这样，当用户提交表单时，也会将表名传递到 insert.php 页面，以便在后端处理中使用。

<input type="submit" value="插入数据">：这是一个提交按钮，用户点击它时会触发表单的提交操作，将数据发送到 insert.php 页面进行处理。
 -->