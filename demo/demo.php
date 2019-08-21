<?php
    // 步骤1.设置appid和appsecret
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->valid();

class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";             
				if(!empty( $keyword ))
                {
              		$msgType = "text";
                	$contentStr = "Welcome to wechat world!";
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }

        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}	
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


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="gbk">
    <title>微信分享接口示例</title>
	<meta name="keywords" content="微信分享接口示例" />   
    <meta name="description" content="这是一个微信分享接口示例预览页面，可以发送到微信端预览并转发给朋友或者分享朋友圈看看效果如何！" />
</head>
<body>
<p></p>
<h1 style="text-algin:center;">这是一个微信分享接口示例预览页面，可以发送到微信端预览并转发给朋友或者分享朋友圈看看效果如何！</h1>
<!--步骤6.调用JS接口-->
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
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
  var wslink = "<?php echo $surl; ?>"; //此处获取分享链接
  var wsimg = "https://www.baidu.com/s?rsv_idx=1&wd=%E4%B8%8A%E6%B5%B7%E4%B8%AD%E6%97%85%E5%9B%BD%E9%99%85%E6%97%85%E8%A1%8C%E7%A4%BE%E6%9C%89%E9%99%90%E5%85%AC%E5%8F%B8&usm=3&ie=utf-8&rsv_cq=&rsv_dl=0_right_recommends_merge_21102&euri=1b1c5627bf924eb88ed371fe3b3317f9"; //此处获取分享缩略图

</script>
<script src="http://www.yudouyudou.com/demo/wxshare/wxshare.js"></script>
</body>
</html>