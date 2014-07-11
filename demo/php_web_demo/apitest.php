<?phpif(isset($_POST["serverurl"]) && isset($_POST["data"]) && isset($_POST["appid"]) && isset($_POST["channel"]) && isset($_POST["expired"])){	$serverUrl = $_POST["serverurl"];	$data = $_POST["data"];	$appid = $_POST["appid"];	$channel = $_POST["channel"];	$expired = $_POST["expired"];		$post = 'expired='.$expired.'&channel='.$channel."&appid=".$appid."&data=".$data;	$curl = curl_init ( $serverUrl );	curl_setopt ( $curl, CURLOPT_HEADER, 0 );	$header = array ();	$header [] = 'Connection: keep-alive';	$header [] = 'User-Agent: ozilla/5.0 (X11; Linux i686) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/14.0.835.186 Safari/535.1';	$header [] = 'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';	$header [] = 'Accept-Language: zh-CN,zh;q=0.8';	$header [] = 'Accept-Charset: GBK,utf-8;q=0.7,*;q=0.3';	$header [] = 'Cache-Control:max-age=0';	$header [] = 'Cookie:t_skey=p5gdu1nrke856futitemkld661; t__CkCkey_=29f7d98';	$header [] = 'Content-Type:application/x-www-form-urlencoded';	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:'));	curl_setopt ( $curl, CURLOPT_HTTPHEADER, $header );	curl_setopt ( $curl, CURLOPT_POST, 1);	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);	curl_setopt ( $curl, CURLOPT_POSTFIELDS, $post );	    $result = curl_exec ( $curl );	curl_close ( $curl );}?><!DOCTYPE html><html lang="en"><head>	<meta charset="utf-8">	<title>Toaster 推送系统Web接口测试</title>	<style type="text/css">	::selection{ background-color: #E13300; color: white; }	::moz-selection{ background-color: #E13300; color: white; }	::webkit-selection{ background-color: #E13300; color: white; }	body {		background-color: #fff;		margin: 40px;		font: 13px/20px normal Helvetica, Arial, sans-serif;		color: #4F5155;	}	a {		color: #003399;		background-color: transparent;		font-weight: normal;	}	h1 {		color: #444;		background-color: transparent;		border-bottom: 1px solid #D0D0D0;		font-size: 19px;		font-weight: normal;		margin: 0 0 14px 0;		padding: 14px 15px 10px 15px;	}	code {		font-family: Consolas, Monaco, Courier New, Courier, monospace;		font-size: 12px;		background-color: #f9f9f9;		border: 1px solid #D0D0D0;		color: #002166;		display: block;		margin: 14px 0 14px 0;		padding: 12px 10px 12px 10px;	}	#body{		margin: 0 15px 0 15px;	}		p.footer{		text-align: right;		font-size: 11px;		border-top: 1px solid #D0D0D0;		line-height: 32px;		padding: 0 10px 0 10px;		margin: 20px 0 0 0;	}		#container{		margin: 10px;		border: 1px solid #D0D0D0;		-webkit-box-shadow: 0 0 8px #D0D0D0;	}	#fm {	margin: 0;	padding: 10px 30px;}.ftitle {	font-size: 14px;	font-weight: bold;	padding: 5px 0;	margin-bottom: 10px;	border-bottom: 1px solid #ccc;}.fitem {	margin-bottom: 5px;}.fitem label {	display: inline-block;	width: 80px;}	</style></head><body><div id="container">	<h1>Toaster 推送系统Web Service 推送DEMO</h1>	<div id="body">		<p>Toaster 推送系统与外部系统均通过WEB SERVICE接口进行交互.</p>		<p>以下为系统提供的推送接口测试DEMO:</p>				<p>		<form action="apitest.php" method="POST">		<div class="fitem">		<label>Server:</label><input type="text" id="serverurl" name="serverurl" style="width:400px" value="http://pro.cobub.com/pub"></input>  		单个或者多个推送 /pub，tag 推送地址:/tagpub ，To App 推送 /allpub		<div>		<div class="fitem">		<label>expired:</label> <input type="text" id="expired" name="expired" style="width:400px" value="0"></input>		</div>		<div class="fitem">		<label>APPID:</label> <input type="text" id="appid" name="appid" style="width:400px" value=""></input>		</div>		<div class="fitem">		<label>Channel:</label> <input type="text" id="channel" name="channel" style="width:400px" value=""></input> 单推送时Channel为客户端UID，Tag推送时为ChannelID,To App 无需此参数		</div>				<div class="fitem">		<label>Data:</label> <textarea id="data" name="data" rows=7 style="width:400px">{"type":"notification","style":"1","config":{"icondata":"XXXXXXX","vibrate":"1","sound":"1","title":"XXXXXX","ticker":"XXXXXXX","body":"XXXXXXX","clickconfig":{"operation":"launchActivity","package":"com.example.pushimpdemo","targetActivity":"com.wbkit.icclient.MainActivity"}}}</textarea>		</div>				<div>		<input type="submit" value="推送消息">				<p><b>返回结果信息：</b></p>		<code style="color:blue">		<?php if(isset($result)):?>		<?php echo $result;?>		<?php endif;?>		</code>		</div>		</form>		</p>				<b>输入参数说明：</b>		<code>		"expired": "1403521931"		<br>		"appid": "XXX"		<br>		"channel": "wink@qq.com"，单推送时Channel为客户端UID，Tag推送时为ChannelID,To App 无需此参数		<br>		"data": JSON 格式数据		</code>		<p>		expired: 为 unix 时间戳, 最长为 30 天(在上面配置文件中设置), 超出这个时间将不再下发此 消息的离线消息, 且无法继续通过 web service 查询到此消息的相关信息.值得注意的是, 如果 提供了大于 0 的 expired, 那么默认是会保存离线消息的, 没有收到消息的客户端在下次登录 时会收到此离线消息, 但是如果设置 expired 为 0, 表示此消息是即时消息, 不需要保存离线 消息, 所以即时客户端没有收到消息, 那么也是不会有离线消息产生的.		</p>				<p>		channel: 表示要下发的通道名称, 可以提供多个 channel		</p>				<p>		data: 要下发的数据需要使用固定的模板		<br>		对于 POST 数据中 data 字段的格式要求,参照如下 json 串(详细说明参照文档):		<code>{"type":"notification", "style":"1", "config":{"icondata":"XXXXXXX", "vibrate":"1", "sound":"1", "title":"XXXXXX", "ticker":"XXXXXXX", "body":"XXXXXXX", "clickconfig":{￼￼￼￼￼￼￼￼￼￼"operation":"launchActivity", "package":"com.wbkit.icclient", "targetActivity":"com.wbkit.icclient.MainActivity"} }}		</code>		</p>				<p>		appid: 要推送的 appid. appid 只能提供一个		</p>		<p>		<b>输入参数说明：</b>		如果出错, 将会以 http status 非 200 的状态返回		正常返回, HTTP STATUS 为 200				<code>		返回格式: {"status": "200","pushedCount": 100,"offCount": 1,"elapsed": 0.52,"mid": "489c4464de66000",}				</code>		<p>		status: 200 表示成功, 400 表示请求封包格式错误.		</p>				<p>		pushedCount: 已经下发的链接数量, 这个数值并不代表正在接收到消息的用户数量, 仅仅表 示服务器已经对 100 个链接下发了数据, 只有用户提交了回执, 服务器才会认为该用户收到 了消息.		</p>				<p>		offCount: 表示提交的 user channel 中, 当前不在线的数量				</p>						<p>		elapsed: 这次推送在服务器端下发所消耗的时间, 以毫秒为单位, 是一个 float 型的数字		</p>				<p>		mid: 这次推送消息的唯一 ID, 以后可以通过此 mid 查询到相应消息的信息, 如客户接收到的 数量, 客户阅读的数量, 消息内容, 等等				</p>	</div>	<p class="footer"><strong>Toaster推送系统</strong></p></div></body></html>