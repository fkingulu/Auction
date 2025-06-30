<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>客户端</title>
  <style>
    /* 添加背景视频 */
    .video-container {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
    }

    video {
      min-width: 100%;
      min-height: 100%;
      width: auto;
      height: auto;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
    /* 修改文本颜色 */
    body {
      color: #fff; /* 更明亮的文本颜色，可以根据需要调整 */
    }
    

    /* 修改背景颜色 */
    .overlay {
      background-color: rgba(0, 0, 0, 0.7); /* 更浅的半透明背景颜色，可以根据需要调整 */
    }

    /* CSS 样式用于标签栏 */
    .tab {
      display: inline-block;
      padding: 5px 10px;
      background-color: #333;
      cursor: pointer;
      position: relative;
      top: 100px;
    }
    
    a {
      display: block;
      text-decoration: none;
      padding: 10px 20px;
      border: 2px solid #fff;
      border-radius: 5px;
      font-size: 20px;
      color: #fff;
      background-color: transparent;
      transition: all 0.3s ease;
    }

    a:hover {
      background-color: #fff;
      color: #000;
    }


    /* CSS 样式用于隐藏表格 */
    .table-container {
      display: none;
      position: relative;
      top: 50px;
    }

    /* CSS 样式用于欢迎文本和退出按钮容器 */
    .welcome-container {
      position: absolute;
      top: 100px; /* 调整垂直位置，可以根据需要进行调整 */
      right: 10px; /* 调整水平位置，可以根据需要进行调整 */
    }

    /* CSS 样式用于退出按钮 */
    .logout-button {
      background-color: #fff;
      color: #000;
      padding: 4px 20px;
      cursor: pointer;
      transition: background-color 0.3s, color 0.3s; 
    }
    .logout-button:hover {
      background-color: #000; 
      color: #fff; 
    }
    .login-button {
      background-color: #070;
      color: #000;
      padding: 5px 10px;
      cursor: pointer;
      transition: background-color 0.3s, color 0.3s; 
    }
    .login-button:hover {
      background-color: #0c0; 
      color: #fff; 
    }
    .register-button {
      background-color: #808;
      color: #000;
      padding: 5px 10px;
      cursor: pointer;
      transition: background-color 0.3s, color 0.3s; 
    }
    .register-button:hover {
      background-color: #f0f; 
      color: #fff; 
    }
    .bid-button {
      background-color: #fff;
      color: #000;
      padding: 4px 20px;
      cursor: pointer;
      transition: background-color 0.3s, color 0.3s; 
    }
    .bid-button:hover {
      background-color: #000; 
      color: #fff; 
    }
  </style>
</head>
<body>
  <!-- 视频容器 -->
  <div class="video-container">
    <video autoplay loop muted>
      <source src="../H2.mp4" type="video/mp4">
      <!-- 如果需要，可以添加其他视频格式的源 -->
      Your browser does not support the video tag.
    </video>
  </div>


  <!-- 欢迎文本和退出按钮容器 -->
  <div class="welcome-container">
    <?php
    session_start();

      $customerID = 0; // 设置默认值

      if (isset($_SESSION["customerID"])) {
        // 用户已登录，更新 $customerID 为用户的实际 CustomerID
        $customerID = $_SESSION["customerID"];
        // 在此处添加其他用户相关的内容
      }

      if (isset($_GET["customerID"])) {
          // 从 URL 参数中获取 CustomerID 并显示
          $customerIDFromURL = $_GET["customerID"];
          if ($customerIDFromURL !== $customerID) {
              // 如果从 URL 中获取的 CustomerID 与当前 $customerID 不同，更新 $customerID
              $customerID = $customerIDFromURL;
          }
      }

      if ($customerID != 0) {
        // 用户已登录，显示欢迎文本和退出按钮
        echo "欢迎，$customerID ！";
        echo "<br>";
        echo "<button class='bid-button' onclick='bid()'>竞标</button>";
        echo "<br>";
        echo "<button class='logout-button' onclick='logout()'>退出</button>";
      } else {
        echo "未登录";
        echo "<br>";
        echo "<button class='login-button' onclick='login()'>登录</button>";
        echo "<br>";
        echo "<button class='register-button' onclick='register()'>注册</button>";
      }
    ?>
  </div>

  <!-- 标签栏 -->
  <div class="tab" onclick="showTable('bids')">竞标记录</div>
  <div class="tab" onclick="showTable('vehicles')">可用汽车 </div>
  <div class="tab" onclick="showProcedure('AvailableFords')">可用的 Ford 汽车</div>
  <div class="tab" onclick="showProcedure('AvailableChevs')">可用的 Chev 汽车</div>
  <div class="tab" onclick="showProcedure('MaxBid')"> 最大竞标</div>
  <a href="3_index.php">查找车辆</a>

  <!-- 在客户端页面 (1_client.php) 中添加新的标签按钮 -->

  <!-- 表格容器 -->
  <div class="table-container" id="bids-table"></div>
  <div class="table-container" id="vehicles-table"></div>
  <div class="table-container" id="AvailableFords-table"></div>
  <div class="table-container" id="AvailableChevs-table"></div>
  <div class="table-container" id="Maxbid-table"></div>

  <script>
    function login() {
      // 使用 window.location 导航到登录页面
      window.location.href = '2_login.php';
    }

    function logout() {
      window.location.href = '2_logout.php';
    }

    function register() {
      window.location.href = '2_register.php';
    }

    function bid() {
      window.location.href = '2_bid.php';
    }

    function showSearchForm() {
      // 使用 window.location 导航到输入表单页面
      window.location.href = '3_index.php';
    }

    function showProcedure(procedureName) {
      // 隐藏所有表格容器
      const tableContainers = document.querySelectorAll('.table-container');
      tableContainers.forEach(container => {
        container.style.display = 'none';
      });

      // 显示选定的表格容器
      const selectedTable = document.getElementById(`${procedureName}-table`);
      selectedTable.style.display = 'block';

      // 发送 AJAX 请求以获取存储过程的数据
      fetch(`1.2_getprocedure.php?procedure=${procedureName}`)
        .then(response => response.text())
        .then(data => {
        document.getElementById(`${procedureName}-table`).innerHTML = data;
        })
        .catch(error => console.error('获取存储过程数据失败:', error));
    }

    function showTable(tableName) {
      // 隐藏所有表格容器
      const tableContainers = document.querySelectorAll('.table-container');
      tableContainers.forEach(container => {
        container.style.display = 'none';
      });

      // 显示选定的表格容器
      const selectedTable = document.getElementById(`${tableName}-table`);
      selectedTable.style.display = 'block';

      // 发送 AJAX 请求以获取表格数据
      fetch(`1.1_gettable.php?table=${tableName}`)
        .then(response => response.text())
        .then(data => {
          document.getElementById(`${tableName}-table`).innerHTML = data;
        })
        .catch(error => console.error('获取表格数据失败:', error));
    }

  </script>
</body>
</html>
