<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');
?>
<!-- main-content start -->
<script>
$(document).ready(function(){
	$("#notifications").easyResponsiveTabs({
		type: 'default', //Types: default, vertical, accordion           
		width: 'auto', //auto or any custom width
		fit: true,   // 100% fits in a container
		closed: false, // Close the panels on start, the options 'accordion' and 'tabs' keep them closed in there respective view types
		activate: function() {}  // Callback function, gets called if tab is switched
	});
<?php
if($MentionArray && (!$ReplyArray || ($ReplyArray && ($MentionArray[0]['PostTime'] > $ReplyArray[0]['PostTime']) ) ) ){
?>
	$(".resp-tab-item")[1].click();
<?php
}
?>
});
</script>
<div class="main-content">
	<div id="notifications" class="tab-container">
		<ul class='resp-tabs-list'>
			<li><?php echo $Lang['Notifications_Replied_To_Me']; ?></li>
			<li><?php echo $Lang['Notifications_Mentioned_Me']; ?></li>
		</ul>
		<div class="resp-tabs-container main-box home-box-list">
			<div>
				<!-- posts list start -->
				<?php
				foreach($ReplyArray as $Post)
				{
				?>
					<div class="comment-item">
						<div class="user-comment-data">
							<div class="comment-content">
							<span class="user-activity-title">
							<a href="<?php echo $Config['WebsitePath']; ?>/u/<?php echo urlencode($Post['UserName']); ?>"><?php echo $Post['UserName'];?></a>
							&nbsp;&nbsp;<?php echo $Lang['Replied_To_Topic']; ?>&nbsp;›&nbsp;
							<a href="<?php echo $Config['WebsitePath']; ?>/goto/<?php echo $Post['TopicID']; ?>-<?php echo $Post['ID']; ?>#Post<?php echo $Post['ID']; ?>"><?php echo $Post['Subject'];?></a></span>
							<?php echo strip_tags(mb_substr($Post['Content'], 0, 512, 'utf-8'),'<p><br><a>'); ?>
							</div>
							
							<div class="comment-data-date">
								<div class="float-right">
					&laquo;&nbsp;&nbsp;<?php echo FormatTime($Post['PostTime']); ?></div>
								<div class="c"></div>
							</div>
							<div class="c"></div>
						</div>
						<div class="c"></div>
					</div>
				<?php
				}
				?>
				<!-- posts list end -->
			</div>
			<div>
				<!-- posts list start -->
				<?php
				foreach($MentionArray as $Post)
				{
				?>
					<div class="comment-item">
						<div class="user-comment-data">
							<div class="comment-content">
							<span class="user-activity-title"><a href="<?php echo $Config['WebsitePath']; ?>/u/<?php echo urlencode($Post['UserName']); ?>"><?php echo $Post['UserName'];?></a>
							&nbsp;&nbsp;<?php echo $Lang['Mentioned_Me']; ?>&nbsp;›&nbsp;
							<a href="<?php echo $Config['WebsitePath']; ?>/goto/<?php echo $Post['TopicID']; ?>-<?php echo $Post['ID']; ?>#Post<?php echo $Post['ID']; ?>"><?php echo $Post['Subject'];?></a></span>
							<?php echo strip_tags(mb_substr($Post['Content'], 0, 512, 'utf-8'),'<p><br><a>'); ?>
							</div>
							
							<div class="comment-data-date">
								<div class="float-right">
					&laquo;&nbsp;&nbsp;<?php echo FormatTime($Post['PostTime']); ?></div>
								<div class="c"></div>
							</div>
							<div class="c"></div>
						</div>
						<div class="c"></div>
					</div>
				<?php
				}
				?>
				<!-- posts list end -->
			</div>
		</div>
	</div>
</div>
<!-- main-content end -->
<!-- main-sider start -->
<div class="main-sider">
	<?php include($TemplatePath.'sider.php'); ?>
</div>
<!-- main-sider end -->