<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <?php if (!isset($_POST['name'])): ?>
        <form action="/index.php" method="post">
            <label for="name">name : </label><input type="text" name="name">
            <input type="submit" value="提交">
        </form>
    <?php else: ?>
        <?= wb_api_widgetgetuid($_POST['name']) ?>
        <br>
        <a href="/">返回</a>
    <?php endif; ?>
</head>
<body>

</body>
</html>
<?php

function wb_api_widgetgetuid($name)
{
    $ch = curl_init();//初始化一个CURL会话
    curl_setopt($ch, CURLOPT_URL, "http://open.weibo.com/widget/ajax_getuidnick.php");//设置CURL请求URL
    $data = "nickname=" . urlencode($name);//设置POST数据（用户昵称）
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.8.0.11)  Firefox/1.5.0.11;");//设置User-Agent
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $header = array();
    $header [] = 'Accept-Language: zh-cn';
    $header [] = 'Pragma: no-cache';
    $header [] = 'Referer: http://open.weibo.com/widget/followbutton.php';//经测试，请求必须有Referer，否则将返回NULL
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $page = curl_exec($ch);//运行抓取
    $matches = json_decode($page, true);//将页面返回的json数据解析为数组
    curl_close($ch);
    if (empty($matches['data'])) {//判断返回的UID是否为空
        return '未找到';
    } else {
        return $matches['data'];
    }
}
