<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>查看记录</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            display: block;
            margin-bottom: 10px;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php
    $conn = new mysqli("localhost","root","0812","autoauction");
    
    if($conn->connect_error){
        die("链接数据库失败：".$conn->connect_error);
    }

    $tablename = $_GET['table'];
    echo "<h1>表格名称： $tablename</h1>"; 

      // 查询获取表格的所有数据
    $dataResult = $conn->query("SELECT * FROM $tablename");

    if ($dataResult->num_rows > 0) {
        echo "<h2>表格数据：</h2>";
        echo "<table border='3'>";
        
        $columnNames = [];
        while ($fieldInfo = $dataResult->fetch_field()) { //fetch_field() 返回一个包含有关查询结果中的列的信息的对象。
            $columnNames[] = $fieldInfo->name;
        }

        echo "<tr>"; //<tr>为行标记符，用于定义表格中一行数据，通常会包含一个或多个 <td> 或 <th> 标签，分别表示表格中的数据单元格和表头单元格。
        foreach ($columnNames as $columnName) {
            echo "<th>$columnName</th>";
        }
        echo "</tr>";

        while ($row = $dataResult->fetch_assoc()) { // 使用 fetch_assoc() 获取下一行数据
            echo "<tr>";
            foreach ($columnNames as $columnName) {
                echo "<td>{$row[$columnName]}</td>"; // 获取名为 'column1' 的列的数据
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "表格中没有数据。";
    }

    // 关闭数据库连接
    $conn->close();
    ?>

     <!-- 链接 -->
    <a href="insert_form.php?table=<?php echo $tablename; ?>">插入数据</a>
    <a href="tdelete_record.php?table=<?php echo $tablename; ?>">删除数据</a>
    <a href="search_form.php?table=<?php echo $tablename; ?>">查找数据</a>
    <a href="select_record.php?table=<?php echo $tablename; ?>">修改数据</a>
    <a href="experiment2.php?table=<?php echo $tablename; ?>">返回数据库</a>
</body>
</html>

