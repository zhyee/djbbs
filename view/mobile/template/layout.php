<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');
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
	<link rel="stylesheet" type="text/css" href="<?php echo $Config['WebsitePath']; ?>/static/css/font-awesome.min.css?version=<?php echo $Config['Version']; ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo $Config['WebsitePath']; ?>/static/css/appframework.css?version=<?php echo $Config['Version']; ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo $Config['WebsitePath']; ?>/static/css/style.css?version=<?php echo $Config['Version']; ?>" />
	<link rel="search" type="application/opensearchdescription+xml" title="<?php echo mb_substr($Config['SiteName'], 0, 15, 'utf-8'); ?>" href="<?php echo $Config['WebsitePath']; ?>/search.xml" />
	<script type="text/javascript">
		var Prefix="<?php echo PREFIX; ?>";
		var WebsitePath="<?php echo $Config['WebsitePath'];?>";
		var accessToken = "<?php echo $accessToken; ?>";
	</script>
	<script type="text/javascript" charset="utf-8" src="<?php echo $Config['WebsitePath']; ?>/static/js/jquery.js?version=<?php echo $Config['Version']; ?>"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo $Config['WebsitePath']; ?>/static/js/appframework.ui.min.js?version=<?php echo $Config['Version']; ?>"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo $Config['WebsitePath']; ?>/static/js/mobile.global.js?version=1.002"></script>
	<script type="text/javascript" charset="utf-8" src="<?php echo $Config['WebsitePath']; ?>/language/<?php echo ForumLanguage; ?>/global.js?version=<?php echo $Config['Version']; ?>"></script>
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
			<a class="board-new" href="<?php echo $Config['WebsitePath']; ?>/new?token=<?php echo $accessToken; ?>">发帖</a>
            <a class="board-new" href="javascript:PageFresh();"><i class="fa fa-refresh" aria-hidden="true"></i></a>
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