<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');

$Config['Version'] = '5.9.6';

ob_start();
if(!$IsAjax){
?><!DOCTYPE html>
<html lang="<?php echo $Lang['Language']; ?>">
<head>
	<title><?php
	echo $CurUserID && $CurUserInfo['NewNotification']?str_replace('{{NewMessage}}', $CurUserInfo['NewNotification'], $Lang['New_Message']):'';
	echo $PageTitle;
	echo $UrlPath=='home'?'':' - '.$Config['SiteName']; ?></title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="Cache-Control" content="no-siteapp" />
	<meta http-equiv="cleartype" content="on" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, minimal-ui" />
	<meta name="MobileOptimized" content="320" />
	<meta name="HandheldFriendly" content="True" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="mobile-web-app-capable" content="yes" />
	<meta name="full-screen" content="yes" />
	<meta name="browsermode" content="application" />
	<meta name="x5-fullscreen" content="true" />
	<meta name="msapplication-TileColor" content="#0088D1" />
	<meta name="msapplication-TileImage" content="<?php echo $Config['WebsitePath']; ?>/static/img/retinahd_icon.png" />
	<meta name="theme-color" content="#0088D1" />
	<link rel="icon" sizes="192x192" href="<?php echo $Config['WebsitePath']; ?>/static/img/nice-highres.png" />
	<link rel="apple-touch-icon-precomposed" href="<?php echo $Config['WebsitePath']; ?>/static/img/apple-touch-icon-57x57-precomposed.png" />
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $Config['WebsitePath']; ?>/static/img/apple-touch-icon-72x72-precomposed.png" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $Config['WebsitePath']; ?>/static/img/apple-touch-icon-114x114-precomposed.png" />
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $Config['WebsitePath']; ?>/static/img/apple-touch-icon-144x144-precomposed.png" />
	<link rel="apple-touch-icon-precomposed" sizes="180x180" href="<?php echo $Config['WebsitePath']; ?>/static/img/retinahd_icon.png" />
	<link rel="shortcut icon" type="image/ico" href="<?php echo $Config['WebsitePath']; ?>/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="<?php echo $Config['WebsitePath']; ?>/view/mobile/theme/iconfont.css?version=<?php echo $Config['Version']; ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo $Config['WebsitePath']; ?>/view/mobile/theme/appframework.css?version=<?php echo $Config['Version']; ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo $Config['WebsitePath']; ?>/view/mobile/theme/style.css?version=<?php echo $Config['Version']; ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo $Config['WebsitePath']; ?>/view/mobile/theme/swiper-3.4.2.min.css?version=<?php echo $Config['Version']; ?>">
	<link rel="search" type="application/opensearchdescription+xml" title="<?php echo mb_substr($Config['SiteName'], 0, 15, 'utf-8'); ?>" href="<?php echo $Config['WebsitePath']; ?>/search.xml" />
	<script type="text/javascript">
		var Prefix="<?php echo PREFIX; ?>";
		var WebsitePath="<?php echo $Config['WebsitePath'];?>";
		var accessToken = "<?php echo $accessToken; ?>";
		var EmotionRoot = '<?php echo $Config['WebsitePath']; ?>/static/img/emotions/';
	</script>
	
	<script type="text/javascript" charset="utf-8" src="<?php echo $Config['LoadJqueryUrl']; ?>"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo $Config['WebsitePath']; ?>/static/js/appframework.ui.min.js?version=<?php echo $Config['Version']; ?>"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo $Config['WebsitePath']; ?>/static/js/mobile.global.js?version=<?php echo $Config['Version']; ?>"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo $Config['WebsitePath']; ?>/language/<?php echo ForumLanguage; ?>/global.js?version=<?php echo $Config['Version']; ?>"></script>

	<script type="text/javascript" src="<?php echo $Config['WebsitePath']; ?>/static/js/emotions.js?version=<?php echo $Config['Version']; ?>"></script>

<?php
if ($Config['PageHeadContent']) {
	echo $Config['PageHeadContent'].'
';
}
if (isset($PageMetaKeyword) && $PageMetaKeyword) {
	echo '	<meta name="keywords" content="', $PageMetaKeyword, '" />
';
}
if (isset($PageMetaDesc) && $PageMetaDesc) {
	echo '	<meta name="description" content="', $PageMetaDesc, '" />
';
}
if ( IsSSL() ) {
	echo '	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
';
}
if($Config['MobileDomainName']){
?>
	<meta http-equiv="mobile-agent" content="format=xhtml; url=<?php echo $CurProtocol . $Config['MobileDomainName'] . $RequestURI; ?>" />
<?php } ?>
</head>

<body>
	<!-- this is the main container div.  This way, you can have only part of your app use UI -->
	<div id="mainview" class="view splitview">
		<header>
			<h1><?php echo $PageTitle; ?></h1>
			<a class="board-new" href="<?php echo $Config['WebsitePath']; ?>/new?token=<?php echo $accessToken; ?>">
				<i class="iconfont icon-edit bold" aria-hidden="true"></i> 发帖
			</a>
            <a class="board-new" href="javascript:PageFresh();"><i class="iconfont icon-refresh bold x1-3" aria-hidden="true"></i></a>
		</header>
		<div class="pages">
			<div data-title="<?php echo $PageTitle; ?>" id="ID<?php echo md5($PageTitle); ?>" class="panel" selected="true">
				<?php include($ContentFile); ?>
			</div>
		</div>
	</div>

<?php
if($CurUserID){
?>
	<div class="view container" id="ReplyView">
		<div class="pages">
			<div class="panel" id="Reply">
				<p>
					<br />
				<h1 id="ReplyViewTitle"></h1>
				<br />
				</p>
				<div id="ReplyViewHTML">
				</div>
				<p><a class="button red block" href="javascript:;" id="ReplyViewSubmitButton"></a></p>
				<p><a class="button gray block" href="#main" data-transition="up-reveal:dismiss" id="ReplyViewCancelButton"></a></p>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		//GetNotification();
	</script>
<?php
}
?>

	<div class="emotion visibility-hidden"  id="emotion-container">
		<div class="swiper-container">
			<div class="swiper-wrapper" id="wrapper"></div>
			<div class="swiper-pagination" style="bottom:1px"></div>
		</div>
		<p class="cancel" id="emotion-cancel">取消</p>
	</div>

	<script>

		$(function () {

			$(document).on('click', ".emotion-btn,#emotion-cancel", function (e) {
				e.stopPropagation();
				$('#emotion-container').slideToggle(800);
			});

			var index = 0;
			var step = 24;
			var slideCont = $('<div class="swiper-slide"></div>');
			for(var key in emotions)
			{
				$('<img />').attr({alt:key, src: EmotionRoot + emotions[key]}).appendTo(slideCont);
				index ++;

				if (index % step == 0)
				{
					slideCont.appendTo('#wrapper');

					slideCont = $('<div class="swiper-slide"></div>');
				}
			}
			/* 最后一个不满的容器 */
			if (index % step > 0)
			{
				slideCont.appendTo('#wrapper');
			}

			loadScript('<?php echo $Config['WebsitePath']; ?>/static/js/swiper-3.4.2.jquery.min.js?version=<?php echo $Config['Version']; ?>', function(){
				var mySwiper = new Swiper ('.swiper-container', {
					direction: 'horizontal',
					loop: false,

					// 如果需要分页器
					pagination: '.swiper-pagination'
				});

				var wrapperO = $("#wrapper");
				var wrapperWidth = wrapperO.width();
				$("#emotion-container").hide().removeClass('visibility-hidden');
				var itemWidth = wrapperWidth / 8;
				var itemMargin = (itemWidth - 24) / 2;

				var emotiomItem = wrapperO.find('img');

				emotiomItem.css({'margin-left': itemMargin + 'px', 'margin-right' : itemMargin + 'px'});

				emotiomItem.click(function (e) {
					var name = $(this).attr('alt');
					var href = $(this).attr('src');
					var textar = $($.afui.activeDiv).find('textarea:first');
					textar.val(textar.val() + '[' + name  + ']');
					var emotionList = $($.afui.activeDiv).find('.emotion-list:first');
					$('<li/>').attr({'rel' : name, 'title' : href}).appendTo(emotionList);
				});

				$('.view').click (function (e) {
				    if ($(e.target).hasClass('emotion-btn')) return;
					$('#emotion-container').hide();
				});
			});

		});

	</script>

</body>
</html>
<?php
}else{
?>
<title><?php
	echo $CurUserID && $CurUserInfo['NewNotification']?str_replace('{{NewMessage}}', $CurUserInfo['NewNotification'], $Lang['New_Message']):'';
	echo $PageTitle;
	echo $UrlPath=='home'?'':' - '.$Config['SiteName']; ?></title>
<?php
	include($ContentFile);
	//Pjax
?>
<script>
PageAjaxLoad("<?php echo $PageTitle; ?>", "//<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>");
</script>
<?php
}
$MicroTime = explode(' ', microtime());
$TotalTime = number_format(($MicroTime[1] + $MicroTime[0] - $StartTime), 6) * 1000;
header("X-Response-Time: " . $TotalTime . "ms");
ob_end_flush();
?>