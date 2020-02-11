<?php

//攻击防御
if(strlen($_SERVER['REQUEST_URI']) > 384 ||
    strpos($_SERVER['REQUEST_URI'], "eval(") ||
	strpos($_SERVER['REQUEST_URI'], "base64")) {
		@header("HTTP/1.1 414 Request-URI Too Long");
		@header("Status: 414 Request-URI Too Long");
		@header("Connection: Close");
		@exit;
}


if (preg_match('/MicroMessenger/i',$_SERVER['HTTP_USER_AGENT' ])) {
    $ua = 'WX';
    $echoTips = true;
} 
else 
{
  if (preg_match('/QQ/i',$_SERVER['HTTP_USER_AGENT' ])) {
   $ua = 'QQ';
   $echoTips = true;
  } else{
     if (preg_match('/Alipay/i',$_SERVER['HTTP_USER_AGENT' ])) {
      $ua = 'Alipay';
	  $echoTips = false;
     } else {
	    $ua = 'Other';
	 }
  }
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="shortcut icon" href="favicon.ico">
    <meta name="robots" content="noindex, nofollow" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
</head>
<?php
if($echoTips) {
    echo '
<title>☆请在浏览器打开☆</title>';
} else {
  echo '
<title>Loading....</title>';
}
?>
<?php if($echoTips) { ?>
<link rel="stylesheet" href="css/ua.css">
<body>

    <?php
    if($ua == 'WX') {
    echo '<div class="div_text">检测到您是在微信打开</div>';
    } else
    if($ua == 'QQ') {
    echo '<div class="div_text">检测到您是在QQ打开</div>';
    }

    ?>
    <div id="pic"><p><img src="img/ua.png" alt=“浏览器打开” /></p></div>

</body>


<?php 
} else {
preg_match('/url=(.*)/i', $_SERVER["QUERY_STRING"], $jumpUrl);

// 如果没获取到跳转链接，直接跳回首页
if(!isset($jumpUrl[1])) {
    header("location:/");
    exit();
}
// 传递数据
$jumpUrl = $jumpUrl[1];
$myDomain = 'yejiah.com';

function isMyDomain($domain, $my) {
    preg_match('/([^\?]*)/i', $domain, $match);
    if(isset($match[1])) $domain = $match[1];
    preg_match('/([\w-]*\.[\w-]*)\/.*/i', $domain.'/', $match);
    if(isset($match[1]) && $match[1] == $my) return true;
    return false;
}

if(!empty($jumpUrl)) {
    //判断取值是否加密
    if ($jumpUrl == base64_encode(base64_decode($jumpUrl))) {
        $jumpUrl =  base64_decode($jumpUrl);
    }

    // 判断是否包含 http:// 头，如果没有则加上
    preg_match('/(http|https):\/\//', $jumpUrl, $matches);

    $url = $matches? $jumpUrl: 'http://'. $jumpUrl;


    // 判断网址是否完整
    preg_match('/[\w-]*\.[\w-]*/i', $url, $matche);

    // 是否需要给出跳转提示
    $echoTips = true;

    if($matche){
    // 如果是本站的链接，不展示动画直接跳转
        if(isMyDomain($url, $myDomain)) {
         header("location:{$url}");
        exit();    // 退出,后续操作不再执行
    }

    $title = 'Loading...';
    $fromUrl = isset($_SERVER["HTTP_REFERER"])? $_SERVER["HTTP_REFERER"]: ''; // 获取来源url

    // 如果来源和跳转后的地址都不是本站，那么就要给出提示
    if(!isMyDomain($fromUrl, $myDomain)) {
        $echoTips = true;
    }
} else {    // 网址参数不完整
    $url = 'http://'.$_SERVER['HTTP_HOST'];
    $title = '跳转参数错误...';
    $echoTips = false; //防傻逼
}
} else {
    $title = '解密后参数缺失...';
    $url = 'http://'.$_SERVER['HTTP_HOST'];
    $echoTips = false;// 同理
}
  ?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="shortcut icon" href="favicon.ico">
    <meta name="robots" content="noindex, nofollow" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
</head>
<?php
if($echoTips) {
    echo '
<title>离开老猫的博客</title>';
} else {
  echo '
<meta http-equiv="refresh" content="1;url='.$url.'">';

  echo '
<title>'.$title.'</title>';
}
?>
<?php if($echoTips) { ?>
<style>

    body {
        background: #fff;
        font-family: Microsoft Yahei;
        -webkit-animation: fadeIn 1s linear;
        animation: fadeIn 1s linear
    }

    @-webkit-keyframes fadeIn {
        from {
            opacity: 0
        }

        to {
            opacity: 1
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0
        }

        to {
            opacity: 1
        }
    }

    #circle {
        background-color: rgba(0,0,0,0);
        border: 5px solid rgba(0,183,229,0.9);
        opacity: .9;
        border-right: 5px solid rgba(0,0,0,0);
        border-left: 5px solid rgba(0,0,0,0);
        border-radius: 50px;
        box-shadow: 0 0 35px #2187e7;
        width: 50px;
        height: 50px;
        margin: 0 auto;
        position: fixed;
        left: 30px;
        bottom: 30px;
        -moz-animation: spinPulse 1s infinite ease-in-out;
        -webkit-animation: spinPulse 1s infinite ease-in-out;
        -o-animation: spinPulse 1s infinite ease-in-out;
        -ms-animation: spinPulse 1s infinite ease-in-out
    }

    #circle1 {
        background-color: rgba(0,0,0,0);
        border: 5px solid rgba(0,183,229,0.9);
        opacity: .9;
        border-left: 5px solid rgba(0,0,0,0);
        border-right: 5px solid rgba(0,0,0,0);
        border-radius: 50px;
        box-shadow: 0 0 15px #2187e7;
        width: 30px;
        height: 30px;
        margin: 0 auto;
        position: fixed;
        left: 40px;
        bottom: 40px;
        -moz-animation: spinoffPulse 1s infinite linear;
        -webkit-animation: spinoffPulse 1s infinite linear;
        -o-animation: spinoffPulse 1s infinite linear;
        -ms-animation: spinoffPulse 1s infinite linear
    }

    @-webkit-keyframes spinPulse {
        0% {
            -webkit-transform: rotate(160deg);
            opacity: 0;
            box-shadow: 0 0 1px #505050
        }

        50% {
            -webkit-transform: rotate(145deg);
            opacity: 1
        }

        100% {
            -webkit-transform: rotate(-320deg);
            opacity: 0
        }
    }

    @-webkit-keyframes spinoffPulse {
        0% {
            -webkit-transform: rotate(0deg)
        }

        100% {
            -webkit-transform: rotate(360deg)
        }
    }

    #loading-text {
        position: fixed;
        left: 110px;
        bottom: 35px;
        color: #736D6D
    }

    @media screen and (max-width:600px) {
        #circle, #circle1 {
            left: 0;
            right: 0;
            top: 0;
            bottom: 0
        }

        #loading-text {
            display: block;
            text-align: center;
            margin-top: 220px;
            position: static;
            margin-left: 10px
        }
    }

    .warning {
        max-width: 500px;
        margin: 20px auto;
    }

    .wtitle {
        font-size: 22px;
        color: #d68300;
    }

    .wurl {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #827777;
    }

    .btn {
        display: inline-block;
        line-height: 20px;
        cursor: pointer;
        border: 1px solid #A9A6A6;
        padding: 6px 10px;
        font-size: 14px;
        text-decoration: none;
    }

    .btn-green {
        color: #fff;
        background-color: #238aca;
        border: 1px solid #238aca;
    }

    .btn:hover {
        background-color: #A9A6A6;
        border: 1px solid #A9A6A6;
        color: #fff;
    }
</style>
<body>

    <div class="warning">
        <p class="wtitle">您将要访问：</p>
        <p class="wurl" title="<?php echo $url;?>"><?php echo $url;?></p>
        <p>该网站不属于老猫的博客，我们无法确认该网页是否安全，它可能包含未知的安全隐患。</p>
        <a class="btn btn-green" href="<?php echo $url;?>" rel="nofollow">继续访问</a>
        <span class="btn" onclick="closePage()">关闭网页</span>
    </div>
    <script>

        function closePage() {
        // 通用窗口关闭
        window.opener=null;
        window.open('','_self');
        window.close();
        // 微信浏览器关闭
        WeixinJSBridge.call('closeWindow');
        }
    </script>
</body>
    <?php } else { ?>
<style type="text/css">

    html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video {
        margin: 0;
        padding: 0;
        border: 0;
        font-size: 100%;
        font: inherit;
        vertical-align: baseline
    }

    body {
        background: #3498db;
    }

    #loader-container {
        width: 188px;
        height: 188px;
        color: white;
        margin: 0 auto;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-right: -50%;
        transform: translate(-50%, -50%);
        border: 5px solid #3498db;
        border-radius: 50%;
        -webkit-animation: borderScale 1s infinite ease-in-out;
        animation: borderScale 1s infinite ease-in-out;
    }

    #loadingText {
        font-family: 'Raleway', sans-serif;
        font-size: 1.4em;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-right: -50%;
        transform: translate(-50%, -50%);
    }

    @-webkit-keyframes borderScale {
        0% {
            border: 5px solid white;
        }

        50% {
            border: 25px solid #3498db;
        }

        100% {
            border: 5px solid white;
        }
    }

    @keyframes borderScale {
        0% {
            border: 5px solid white;
        }

        50% {
            border: 25px solid #3498db;
        }

        100% {
            border: 5px solid white;
        }
    }
</style>

<body>
    <div id="loader-container">
        <p id="loadingText">
            页面加载中...
        </p>
    </div>
</body>

    <?php } ?>

</html>
<?php } ?>
</html>