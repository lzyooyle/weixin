<?php
/**
  * wechat php test
  */
require 'class.wechatCallbackapiTest.php';
require 'class.WxService.php';
//define your token
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->valid();

error_reporting(1);
header('Content-type:text/html; Charset=utf-8');
/* 配置开始 */
$appid = 'wx4a21eb993c9a3062';  //微信公众平台->开发->基本配置->AppID
$appKey = 'b5997983c24d4fa45113dbdbb8292fb5';   //微信公众平台->开发->基本配置->AppSecret
/* 配置结束 */

//①、获取用户openid
$wxPay = new WxService($appid,$appKey);
$data = $wxPay->GetOpenid();      //获取openid
if(!$data['openid']) exit('获取openid失败');
//②、获取用户信息
$user = $wxPay->getUserInfo($data['openid'],$data['access_token']);
    $appid = 'wx4a21eb993c9a3062';  //此处填写绑定的微信公众号的appid
    $appsecret = 'b5997983c24d4fa45113dbdbb8292fb5'; //此处填写绑定的微信公众号的密钥id

    // 步骤2.生成签名的随机串
    function nonceStr($length){
        $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJK1NGJBQRSTUVWXYZ';//随即串，62个字符
        $strlen = 62;
        while($length > $strlen){
        $str .= $str;
        $strlen += 62;
        }
        $str = str_shuffle($str);
        return substr($str,0,$length);
    }

    // 步骤3.获取access_token
    $result = http_get('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret);
    $json = json_decode($result,true);
    $access_token = $json['access_token'];

    function http_get($url){
        $oCurl = curl_init();
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if(intval($aStatus["http_code"])==200){
            return $sContent;
        }else{
            return false;
        }
    }

    // 步骤4.获取ticket
    $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$access_token";
    $res = json_decode ( http_get ( $url ) );
    $ticket = $res->ticket;


    // 步骤5.生成wx.config需要的参数
    $surl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $ws = getWxConfig( $ticket,$surl,time(),nonceStr(16) );
	//var_dump(nonceStr(16));
    function getWxConfig($jsapiTicket,$url,$timestamp,$nonceStr) {
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $signature = sha1 ( $string );

        $WxConfig["appId"] = $appid;
        $WxConfig["nonceStr"] = $nonceStr;
        $WxConfig["timestamp"] = $timestamp;
		var_dump($timestamp);
        $WxConfig["url"] = $url;
        $WxConfig["signature"] = $signature;
        $WxConfig["rawString"] = $string;
        return $WxConfig;
    }
//var_dump($_GET);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <title>旅游共享会</title>
    <link href="https://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/jquery/2.1.0/jquery.min.js"></script>
	<!--步骤6.调用JS接口-->
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>	
</head>
<body>
<script>
wx.config({
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: 'wx4a21eb993c9a3062', // 必填，公众号的唯一标识
        timestamp: "<?php echo $ws["timestamp"]; ?>", // 必填，生成签名的时间戳
        nonceStr: '<?php echo $ws["nonceStr"]; ?>', // 必填，生成签名的随机串
        signature: '<?php echo $ws["signature"]; ?>',// 必填，签名，见附录1
        jsApiList: [
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo'
        ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
    });
  var wstitle = "旅游共享会";  //此处填写分享标题
  var wsdesc = "分享旅游产品，赚取高额佣金！"; //此处填写分享简介
  var wslink = "<?php echo "http://".$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]."?from_openid=".$user['openid']."&from_nickname=".$user['nickname']; ?>"; //此处获取分享链接
  var wsimg = "https://ss1.baidu.com/6ONXsjip0QIZ8tyhnq/it/u=3243730018,2989919252&fm=58&bpow=729&bpoh=1050"; //此处获取分享缩略图


</script>
<script src="http://www.yudouyudou.com/demo/wxshare/wxshare.js"></script>
<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<div class="alert alert-success">亲，您的分享人id是:<?=$_GET['from_openid']?></div>
<div class="alert alert-info">亲，您的分享人网名是:<?=$_GET['from_nickname']?></div>
<div class="container">
    <div class="row">
        <h1>你的基本信息如下：</h1>
        <table class="table table-bordered">
            <tr>
                <td>openid</td>
                <td><?=$user['openid']?></td>
            </tr>
            <tr>
                <td>unionid</td>
                <td><?=$user['unionid']?></td>
            </tr>
            <tr>
                <td>昵称</td>
                <td><?=$user['nickname']?></td>
            </tr>
            <tr>
                <td>头像</td>
                <td><img src="<?=$user['headimgurl']?>" style="width: 100px;" alt=""></td>
            </tr>               
            <tr>
                <td>性别</td>
                <td><?php
                    switch (strtoupper($user['sex'])){
                        case 1:
                            echo '男性';
                            break;
                        case 2:
                            echo '女性';
                            break;
                        default:
                            echo '未知';
                            break;
                    }
                    ?></td>
            </tr>
            <tr>
                <td>省份 / 城市</td>
                <td><?=$user['province'].' / '.$user['city']?></td>
            </tr>
            <tr>
                <td>language</td>
                <td><?=$user['language']?></td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
