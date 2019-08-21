<?php
    // ����1.����appid��appsecret
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
    $appid = 'wx4a21eb993c9a3062';  //�˴���д�󶨵�΢�Ź��ںŵ�appid
    $appsecret = 'b5997983c24d4fa45113dbdbb8292fb5'; //�˴���д�󶨵�΢�Ź��ںŵ���Կid

    // ����2.����ǩ���������
    function nonceStr($length){
        $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJK1NGJBQRSTUVWXYZ';//�漴����62���ַ�
        $strlen = 62;
        while($length > $strlen){
        $str .= $str;
        $strlen += 62;
        }
        $str = str_shuffle($str);
        return substr($str,0,$length);
    }

    // ����3.��ȡaccess_token
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

    // ����4.��ȡticket
    $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$access_token";
    $res = json_decode ( http_get ( $url ) );
    $ticket = $res->ticket;


    // ����5.����wx.config��Ҫ�Ĳ���
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
    <title>΢�ŷ���ӿ�ʾ��</title>
	<meta name="keywords" content="΢�ŷ���ӿ�ʾ��" />   
    <meta name="description" content="����һ��΢�ŷ���ӿ�ʾ��Ԥ��ҳ�棬���Է��͵�΢�Ŷ�Ԥ����ת�������ѻ��߷�������Ȧ����Ч����Σ�" />
</head>
<body>
<p></p>
<h1 style="text-algin:center;">����һ��΢�ŷ���ӿ�ʾ��Ԥ��ҳ�棬���Է��͵�΢�Ŷ�Ԥ����ת�������ѻ��߷�������Ȧ����Ч����Σ�</h1>
<!--����6.����JS�ӿ�-->
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
wx.config({
        debug: false, // ��������ģʽ,���õ�����api�ķ���ֵ���ڿͻ���alert��������Ҫ�鿴����Ĳ�����������pc�˴򿪣�������Ϣ��ͨ��log���������pc��ʱ�Ż��ӡ��
        appId: 'wx4a21eb993c9a3062', // ������ںŵ�Ψһ��ʶ
        timestamp: "<?php echo $ws["timestamp"]; ?>", // �������ǩ����ʱ���
        nonceStr: '<?php echo $ws["nonceStr"]; ?>', // �������ǩ���������
        signature: '<?php echo $ws["signature"]; ?>',// ���ǩ��������¼1
        jsApiList: [
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo'
        ] // �����Ҫʹ�õ�JS�ӿ��б�����JS�ӿ��б����¼2
    });
  var wstitle = "���ι����";  //�˴���д�������
  var wsdesc = "�������β�Ʒ��׬ȡ�߶�Ӷ��"; //�˴���д������
  var wslink = "<?php echo $surl; ?>"; //�˴���ȡ��������
  var wsimg = "https://www.baidu.com/s?rsv_idx=1&wd=%E4%B8%8A%E6%B5%B7%E4%B8%AD%E6%97%85%E5%9B%BD%E9%99%85%E6%97%85%E8%A1%8C%E7%A4%BE%E6%9C%89%E9%99%90%E5%85%AC%E5%8F%B8&usm=3&ie=utf-8&rsv_cq=&rsv_dl=0_right_recommends_merge_21102&euri=1b1c5627bf924eb88ed371fe3b3317f9"; //�˴���ȡ��������ͼ

</script>
<script src="http://www.yudouyudou.com/demo/wxshare/wxshare.js"></script>
</body>
</html>