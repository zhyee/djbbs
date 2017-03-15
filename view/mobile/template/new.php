<script async="async">
	function load() {
		callbackForJava('{"msg":"成功","uuid":194,"code":0}');
	}

	// 	document.getElementsByTagName('a')[0].addEventListener("click", load(),
	// 			false);

	// Global variable
	var JsInterfaceObject = mAndroid;

	// 获取token
	function getDataFromAndroid() {
		document.getElementById("getTokenShow").innerHTML = JsInterfaceObject
			.getDataFromAndroid();
	}

	// 隐藏/显示播放器
	function setVPlayerGone(isShow) {
		JsInterfaceObject.setVPlayerGone(isShow);
		document.getElementById("setVPlayerGoneShow").innerHTML = "setVPlayerGone("
			+ isShow + ")";
	}

	function playNext(){
		var params="{'action':'doEpisodePlay','contentId':'C36433387'}";
		JsInterfaceObject.doVideoDetail(params);
		document.getElementById("playNext").innerHTML = "playNext("
			+ params + ")";
	}

	// 获取15天活动鉴权数据
	function getAuthData() {
		document.getElementById("getAuthDataShow").innerHTML = JsInterfaceObject
			.getAuthData();
	}

	// 天天领取，分享dialog
	function showSucessDialog() {
		var isTempVIP = document.getElementById("isTempVIP").value;
		var tempVip = "";
		if (isTempVIP != '') {
			tempVip = "'isTempVIP':" + isTempVIP + ",";
		}
		var shareType = document.getElementById("shareTypeIn").value;
		var shareTypeVal = "";
		if (shareType !== '') {
			shareTypeVal = ", 'shareType':" + shareType;
		}
		var data = "{"
			+ tempVip
			+ "'shareUrl':'http://www.tv189.com', 'title': '天翼视讯', 'content':'天翼视讯'"
			+ shareTypeVal + "}";
		JsInterfaceObject.showSucessDialog(data);
		document.getElementById("shareShow").innerHTML = data;
	}

	// 跳转到具体客户端功能界面
	function toAndroidActivity(activityName, params) {
		JsInterfaceObject.toAndroidActivity(activityName, params)
	}
	function toInteractDetailActivity(){
		var className = "InteractiveDetailActivity";
		var data = "{'url':'http://e.tv189.com/','title':'翼乐购'}";
		toAndroidActivity(className, data);
		document.getElementById("toInteractDetailActivity").innerHTML = className
			+ "<->" + data;
	}
	function toVideoDetailNewActivity(){
		var className = "VideoDetailNewActivity";
		var data = "{'contentId':'C36759926','clickParam':'0','webUrl':'http://www.baidu.com'}";
		toAndroidActivity(className, data);
		document.getElementById("toVideoDetailActivity").innerHTML = className
			+ "<->" + data;
	}
	function onVideoComplete(){
		var action="on_video_complete";
		var data = "{'contentId':'C36759926','clickParam':'0','webUrl':'http://www.baidu.com'}";
		JsInterfaceObject.invokeJsApi(action,data);
		document.getElementById("onVideoComplete").innerHTML = data;
	}

	function onUploadPic() {
		var action = "forum_upload_photo";
		var data = "{'contentId':'C36759926','clickParam':'0','webUrl':'http://www.baidu.com'}";
		JsInterfaceObject.invokeJsApi(action, data);
	}

	function toVipCouponsActivity(){
		var className = "VipCouponsActivity";
		var data = "";
		toAndroidActivity(className, data);
		document.getElementById("toVipCouponsActivity").innerHTML = className
			+ "<->" + data;
	}
	function toLoginAndRegister() {
		var className = "LoginAndRegisterActivity";
		var data = "{'url':'http://www.tv189.com'}";
		toAndroidActivity(className, data);
		document.getElementById("toAndroidActivityShow").innerHTML = className
			+ "<->" + data;
	}
	function toGoodsDetails() {
		var className = "VideoAndWebActivity";
		var data = "{'contentId':'C35716991','url':'http://www.tv189.com'}";
		toAndroidActivity(className, data);
		document.getElementById("toAndroidActivityShow").innerHTML = className
			+ "<->" + data;
	}
	function toActivityInteractive() {
		var className = "LiveInteractActivity";
		var data = "{'liveId':'C8000000000000000001428999394066','title':'爱购物','startTime':'2016-04-10 15:15:15','endTime':'2016-04-10 16:16:16','webUrl':'http://tv189.itulies.com/tpl/other/2015/tycj/view/index.php'}";
		toAndroidActivity(className, data);
		document.getElementById("toAndroidActivityShow").innerHTML = className
			+ "<->" + data;
	}

	//收藏
	function doCollect(){
		var action="do_video_detail";
		var params="{'action':'doCollect','successCb':'successCallback','errorCb':'errorCallback'}";
		JsInterfaceObject.invokeJsApi(action,params);
		document.getElementById("doCollect").innerHTML = params;
	}

	//直播回看(深圳卫视)
	function playLiveBack(){
		var action="do_video_detail";
		var params="{'action':'doLivePlay','contentId':'C8000000000000000001427180449279','startTime':'2016-07-26 19:36:30','endTime':'2016-07-26 21:10:00','successCb':'successCallback','errorCb':'errorCallback'}";
		JsInterfaceObject.invokeJsApi(action,params);
		document.getElementById("playLiveBack").innerHTML = params;
	}
	//直播(深圳卫视)
	function playLive(){
		var action="do_video_detail";
		var params="{'action':'doLivePlay','contentId':'C8000000000000000001427180449279','successCb':'successCallback','errorCb':'errorCallback'}";
		JsInterfaceObject.invokeJsApi(action,params);
		document.getElementById("playLive").innerHTML = params;
	}
	//视频下载
	function downloadVideo(){
		var action="cont_download";
		var params="{'definition':'2','contentId':'C36433387','successCb':'successCallback','errorCb':'errorCallback'}";
		JsInterfaceObject.invokeJsApi(action,params);
		document.getElementById("downloadVideo").innerHTML = params;
	}
	//成功回掉
	function successCallback(result){
		alert(result);
	}
	//失败回掉
	function errorCallback(result){
		alert(result);
	}
	//视频下载查询
	function queryDownloadStatus(){
		var action="cont_download_status";
		var params="{'contentId':'C36433387','successCb':'successCallback','errorCb':'errorCallback'}";
		JsInterfaceObject.invokeJsApi(action,params);
		document.getElementById("queryDownloadStatus").innerHTML = params;
	}
	//通用js调用方法
	function invokeJsApi(){
		var action="do_video_detail";
		var params="{'action':'doEpisodePlay','contentId':'C36433387'}";
		JsInterfaceObject.invokeJsApi(action,params);
		document.getElementById("invokeJsApi").innerHTML = params;
	}
	//通用js调用方法--剪贴板
	function copyToClipboard(){
		var action="copy_to_clipboard";
		var params="{'content':'剪贴板'}";
		JsInterfaceObject.invokeJsApi(action,params);
		document.getElementById("copyToClipboard").innerHTML = params;
	}
	//通用js调用方法--设置闹钟
	function setAlarm(){
		var action="set_alarm_clock";
		var params="{'content':'剪贴板'}";
		JsInterfaceObject.invokeJsApi(action,params);
		document.getElementById("setAlarm").innerHTML = params;
	}
	//通用js调用方法--打开外部浏览器
	function openInBrowser(){
		var action="open_in_browser";
		var params="{'url':'http://e.tv189.com/?appid=115020310073&token=563abd1bc0b5e&devid=000001&version=5.2.19.7'}";
		JsInterfaceObject.invokeJsApi(action,params);
		document.getElementById("openInBrowser").innerHTML = params;
	}

	//通用js调用方法--打开外部浏览器
	function goBackHome(){
		var action="go_back_home_view";
		var params="{'url':'http://e.tv189.com/?appid=115020310073&token=563abd1bc0b5e&devid=000001&version=5.2.19.7','index':4}";
		JsInterfaceObject.invokeJsApi(action, params);
		document.getElementById("gobackhome").innerHTML = params;
	}
	//检查对应app有没有存在
	function checkAppInstalled(){
		var action="check_app_installed";
		var data="{'appList':[{'packageName':'com.telecom.video'},{'packageName':'com.tencent.mobileqq'}], 'successCb': 'success_cb', 'errorCb': 'error_cb'}";
		JsInterfaceObject.invokeJsApi(action, data);
	}

	//直播预约功能,查询是否预约过
	function checkIsSubscribed(){
		var action = "is_program_reminded";
		var data = "{'checklist':[{'liveid':'C8000000000000000001426665783098','pid':'10376849','startTime':'2016-08-02 23:34:00','endTime':'2016-08-02 23:59:59'}]}";
		JsInterfaceObject.invokeJsApi(action,data);
	}

	//添加或者取消预约
	function addOrCancelSubscribe(){
		var action = "program_remind";
		var data = "{'otype':1,'liveid':'C8000000000000000001426665783098','pid':'10376849','startTime':'2016-08-02 23:34:00','endTime':'2016-08-02 23:59:59','title':'大揭秘','description':'2015-11-02 15:33:00直播：光影星播客'}";
		JsInterfaceObject.invokeJsApi(action,data);
	}

	//检查action 对应方法平台是否存在
	function checkJsApi(){
		var data="{'jsApiList':[{'action':'get_detail_load_time'},{'action':'fun2'}], 'successCb': 'success_cb', 'errorCb': 'error_cb'}";
		JsInterfaceObject.checkJsApi(data);
	}
	function success_cb(res){
		alert(res);
	}
	// 上传图片
	function doUpLoadImage(type) {
		var data;
		if (type == 1) {
			data = "{'phone':'18900000001','name':'土豪','webUrl':'file:///android_asset/jscheck.html'}"
		} else if (type == 2) {
			data = "{'phone':'18900000001','name':'土豪','webUrl':'file:///android_asset/jscheck.html','callback':'callbackForJava'}"
		}
		JsInterfaceObject.doUpLoadImage(data);
		document.getElementById("doUpLoadShow").innerHTML = "image<->" + data;
	}
	// 上传视频
	function doUpLoadVideo(type) {
		var data;
		if (type == 1) {
			data = "{'phone':'18900000001','name':'土豪','webUrl':'file:///android_asset/jscheck.html'}"
		} else if (type == 2) {
			data = "{'phone':'18900000001','name':'土豪','webUrl':'file:///android_asset/jscheck.html','callback':'callbackForJava'}"
		}
		JsInterfaceObject.doUpLoadVideo(data);
		document.getElementById("doUpLoadShow").innerHTML = "video<->" + data;
	}

	//通用js调用方法--设置摇一摇
	function setShake(){
		var action="set_shake_state";
		var params="{'callback':'paycallback','state':1}";
		JsInterfaceObject.invokeJsApi(action,params);
		document.getElementById("setShake").innerHTML = params;
	}

	// 本地回调接口
	function callbackForJava(json) {
		document.getElementById("java2Js").innerHTML = json;
	}

	// 支付
	function invokePay(type) {
		var data = '{"payType":"'
			+ type
			+ '","channelId":"000058","contentId":"C000001","productID":"1000000015","productName":"CCTV开心综艺","productDesc":"集原创动漫，原创短剧，相声曲艺，流行金曲于一体的手机综艺平台，活泼不失传统，风趣不失感动，给您一个全新的视听体验。\r\n直播频道： CCTV3综艺、CCTV音乐\r\n特色内容：CCTV品牌综艺栏目，同一首歌、艺术人生、开心词典等。\r\n*节目如有调整以实际播出情况为准。","purchaseType":"0","fee":"1","rebuild":1,"callback":"paycallback","businessId":"b123","webUrl":"http://www.tv189.com"}';
		JsInterfaceObject.invokePay(data);
		document.getElementById("invokePayShow").innerHTML = data;
	}

	// 内部下载类
	function doDownLoadInside() {
		var data = '{"title":"'
			+ "TV189院线"
			+ '","clickParam":"com.telecom.video.shyx","path":"http://api.tv189.com/v2/10260036000__01752021.apk","ver":"5.0.0.8","appname":"TV189院线","cover":"http://pic01.v.vnet.mobi/image/tmpl/2014/10/29/7000069289.jpg"}';
		JsInterfaceObject.doDownLoadInside(data);
		document.getElementById("doDownLoadInside").innerHTML = data;
	}

	//鉴权订购
	function commonOrder() {
		var data = '{"contentId":"'
			+ "C36068260"
			+ '","productId":"","callback":"paycallback","webUrl":"http://www.tv189.com"}';
		JsInterfaceObject.commonOrder(data);
		document.getElementById("commonOrder").innerHTML = data;
	}


	// 本地回调接口
	function paycallback(json) {
		document.getElementById("payjava2Js").innerHTML = json;
		alert(json);
	}

	function setShareInfo() {
		var data = '{"shareUrl":'
			+ '"http://www.tv189.com"'
			+ ',"cover":"http://v1.qzone.cc/avatar/201407/14/09/32/53c33337759f0153.jpg%21200x200.jpg"'
			+ ',"title":"title","successCb":"successCb"'
			+ ',"content":"share content"}';
		JsInterfaceObject.invokeJsApi("set_shareInfo", data);
	}
</script>

<div>


	<div id="helloweb"></div>

	<div class="tysx">
		<button id="getToken" onclick="getDataFromAndroid()">获取token</button>
		<div id="getTokenShow" class="show"></div>
	</div>

	<div class="tysx">
		<button onclick="setVPlayerGone(1)">隐藏播放器</button>
		<button onclick="setVPlayerGone(2)">显示播放器</button>
		<div id="setVPlayerGoneShow" class="show"></div>
	</div>

	<div class="tysx">
		<button onclick="getAuthData()">获取15天活动鉴权数据</button>
		<div id="getAuthDataShow" class="show"></div>
	</div>

	<div class="tysx">
		<div>分享dialog；isTempVIP是否领取成功1为成功，0为失败；表示分享类型:0弹出对话框选择,1微博,2短信,3微信,4微信朋友圈,5易信,6易信朋友圈</div>
		isTempVIP<input type="text" id="isTempVIP" value="1">&nbsp;&nbsp;<br />shareType&nbsp;<input type="text" id="shareTypeIn" value="0">
		<button onclick="showSucessDialog()">分享dialog</button>
		<div id="shareShow" class="show"></div>
	</div>

	<div class="tysx">
		<button onclick="setShareInfo()">设置分享参数</button>
		<div id="setShareInfo" class="show"></div>
	</div>

	<div class="tysx">
		<div>跳转到具体客户端功能界面</div>
		<button onclick="toLoginAndRegister()">登录/注册</button>
		<button onclick="toGoodsDetails()">商品详情页</button>
		<button onclick="toActivityInteractive()">互动界面</button>
		<div id="toAndroidActivityShow" class="show"></div>
	</div>

	<div class="tysx">
		<div>调用 上传事件</div>
		<table style="width: 100%;">
			<tr style="width: auto;">
				<td style="width: 50%;"><button onclick="doUpLoadImage(1)">图片-url</button></td>
				<td style="width: 50%;"><button onclick="doUpLoadImage(2)">图片-callback</button></td>
			</tr>
			<tr style="width: auto;">
				<td style="width: 50%;"><button onclick="doUpLoadVideo(1)">视频-url</button></td>
				<td style="width: 50%;"><button onclick="doUpLoadVideo(2)">视频-callback</button></td>
			</tr>
		</table>
		<div id="doUpLoadShow" class="show"></div>
		<div id="java2Js" class="show" style="color: blue;"></div>
	</div>

	<div class="tysx">
		<div>调用支付接口</div>
		<button onclick="invokePay(1)">支付宝</button>
		<button onclick="invokePay(2)">微信</button>
		<button onclick="invokePay(3)">翼支付</button>
		<div id="invokePayShow" class="show"></div>
		<div id="payjava2Js" class="show" style="color: blue;"></div>
	</div>
	<div class="tysx">
		<div>调用点播接口</div>
		<button onclick="toVideoDetailNewActivity()">点播</button>
		<div id="toVideoDetailActivity" class="show"></div>
		<div id="payjava2Js" class="show" style="color: blue;"></div>
	</div>

	<div class="tysx">
		<button onclick="doDownLoadInside()">下载TV189院线</button>
		<div id="doDownLoadInside" class="show"></div>
	</div>

	<div class="tysx">
		<button onclick="commonOrder()">鉴权订购接口</button>
		<div id="commonOrder" class="show"></div>
	</div>
	<div class="tysx">
		<button onclick="toVipCouponsActivity()">会员券接口</button>
		<div id="toVipCouponsActivity" class="show"></div>
	</div>
	<div class="tysx">
		<button onclick="toInteractDetailActivity()">h5界面接口</button>
		<div id="toInteractDetailActivity" class="show"></div>
	</div>
	<div class="tysx">
		<button onclick="invokeJsApi()">通用js调用方法:点播详情页</button>
		<div id="invokeJsApi" class="show"></div>
	</div>
	<div class="tysx">
		<button onclick="checkJsApi()">检查action 对应方法平台是否存在</button>
		<div id="checkJsApi" class="show"></div>
	</div>

	<div class="tysx">
		<button onclick="playNext()">播放下一集</button>
		<div id="playNext" class="show"></div>
	</div>

	<div class="tysx">
		<button onclick="setShake()">摇一摇</button>
		<div id="setShake" class="show"></div>
	</div>

	<div class="tysx">
		<button onclick="copyToClipboard()">剪贴板</button>
		<div id="copyToClipboard" class="show"></div>
	</div>
	<div class="tysx">
		<button onclick="setAlarm()">设置闹钟</button>
		<div id="setAlarm" class="show"></div>
	</div>
	<div class="tysx">
		<button onclick="openInBrowser()">打开外部浏览器</button>
		<div id="openInBrowser" class="show"></div>
	</div>
	<div class="tysx">
		<button onclick="goBackHome()">回到首页</button>
		<div id="gobackhome" class="show"></div>

		<div class="tysx">
			<button onclick="checkAppInstalled()">检测应用是否存在</button>
			<div id="checkAppInstalled" class="show"></div>
			<div class="tysx">
				<button onclick="downloadVideo()">下载视频</button>
				<div id="downloadVideo" class="show"></div>
				<div class="tysx">
					<button onclick="queryDownloadStatus()">查询下载视频状态</button>
					<div id="queryDownloadStatus" class="show"></div>
					<div class="tysx">
						<button onclick="doCollect()">视频收藏</button>
						<div id="doCollect" class="show"></div>
						<div class="tysx">
							<button onclick="playLiveBack()">直播回看（深圳卫视）</button>
							<div id="playLiveBack" class="show"></div>
							<div class="tysx">
								<button onclick="playLive()">直播（深圳卫视）</button>
								<div id="playLive" class="show"></div>
								<div class="tysx">
									<button onclick="checkIsSubscribed()">直播预约功能,查询是否预约过</button>
									<div id="checkIsSubscribed" class="show"></div>
									<div class="tysx">
										<button onclick="addOrCancelSubscribe()">添加或取消预约</button>
										<div id="addOrCancelSubscribe" class="show"></div>
										<div class="tysx">
											<button onclick="onVideoComplete()">H5设置剧集播完后的视频</button>
											<div id="onVideoComplete" class="show"></div>
											</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>


<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');
?>
<script type="text/javascript">
	var MaxTagNum = <?php echo $Config["MaxTagsNum"]; ?>;//最多的话题数量
	var MaxTitleChars = <?php echo $Config['MaxTitleChars']; ?>;//主题标题最多字节数
	var MaxPostChars = <?php echo $Config['MaxPostChars']; ?>;//主题内容最多字节数
	loadScript("<?php echo $Config['WebsitePath']; ?>/static/js/mobile.new.function.js?version=<?php echo $Config['Version']; ?>", function() {
		$.each(<?php echo json_encode(ArrayColumn($HotTagsArray, 'Name')); ?>,function(Offset,TagName) {
			TagsListAppend(TagName, Offset);
		});
	});
</script>
<div class="container">
	<form name="NewForm">
		<input type="hidden" name="FormHash" value="<?php echo $FormHash; ?>" />
		<input type="hidden" name="ContentHash" value="" />
		<input type="hidden" name="token" value="<?php echo $accessToken; ?>" />
		<p>
			<input type="text" name="Title" id="Title" value="<?php echo htmlspecialchars($Title); ?>" placeholder="<?php echo $Lang['Title']; ?>" />
		</p>
		<p>
			<select name="BoardID" id="BoardID">
				<option value="0">选择版块</option>
				<?php foreach ($TotalBoards as $board): ?>
					<option value="<?php echo $board['ID']; ?>"><?php echo htmlspecialchars($board['Name']); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<button onclick="onUploadPic()">测试测试</button>
			<label id="label-upfile" class="fa fa-paperclip fa-2x add-attachment" onclick="onUploadPic()"></label>
			<input type="file" class="add-attachment" id="upfile" onchange="javascript:UploadPicture('Content');" />
		</p>
		<p>
			<textarea name="Content" id="Content" rows="10" placeholder="<?php echo $Lang['Content']; ?>"></textarea>
		</p>

		<p>
			<!--input type="button" value="<?php echo $Lang['Submit']; ?>" name="submit" class="button block red" onclick="JavaScript:CreateNewTopic();" id="PublishButton" style="width:100%;" /-->
			<a type="button" name="submit" class="button block red" onclick="JavaScript:CreateNewTopic();" id="PublishButton" style="width:100%;" ><?php echo $Lang['Submit']; ?></a>
		</p>
	</form>
</div>

<script>
	$("#label-upfile").click(function () {
		location.href = "/test.html";
	});
</script>