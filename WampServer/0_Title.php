<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>汽车拍卖系统</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      flex-direction: column;
      overflow: hidden; /* 隐藏视频溢出部分 */
    }

    /* 视频容器样式 */
    .video-container {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
      z-index: -1; /* 将视频放置在最底层 */
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
    .overlay {
      position: absolute;
      background-color: rgba(0, 0, 0, 0.5); /* 半透明背景 */
      width: 50%; /* 调整宽度 */
      padding: 20px;
      text-align: center;
      z-index: 1; /* 将遮罩放在视频之上 */
    }

    h1 {
      font-size: 36px;
      color: #fff;
    }

    p {
      font-size: 18px;
      color: #fff;
    }

    ul {
      list-style: none;
      padding: 0;
    }

    li {
      margin: 10px;
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
  </style>
</head>
<body>
  <!-- 视频容器 -->
  <div class="video-container">
    <video autoplay loop muted>
      <source src="../H1.mp4" type="video/mp4">
      <!-- 如果需要，可以添加其他视频格式的源 -->
      Your browser does not support the video tag.
    </video>
  </div>

  <!-- 半透明遮罩 -->
  <div class="overlay">
    <h1>欢迎来到汽车拍卖系统</h1>
    <p>请选择您的身份：</p>
    <ul>
      <li><a href="1_client.php">客户端</a></li>
      <li><a href="experiment2.php">管理员端</a></li>
    </ul>
  </div>
</body>
</html>
