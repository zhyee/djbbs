<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');
?>
<div class="card user-card-header-pic">
	<div style="color:#FFFFFF;background-image:url(<?php echo $Config['WebsitePath'] . '/upload/avatar/large/' . $UserInfo['ID'] . '.png?' . time() ; ?>)" valign="bottom" class="card-header color-white no-border">
		<?php echo $UserInfo['UserName']; ?>
	</div>
	<div class="card-content">
		<div class="card-content-inner">
			<p class="color-gray"><?php echo $Lang['Registered_In']; ?>：<?php echo FormatTime($UserInfo['UserRegTime']); ?></p>
			<p><?php echo $Lang['UserName']; ?>：<strong><?php echo $UserInfo['UserName']; ?></strong></p>
			<p><?php echo $Lang['Topics_Number']; ?>： <?php echo $UserInfo['Topics']; ?>  &nbsp;&nbsp;&nbsp; <?php echo $Lang['Posts_Number']; ?>： <?php echo $UserInfo['Replies']; ?></p>
		</div>
	</div>
	<div class="card-footer">
	</div>
</div>
<!-- User Infomation end -->
<!-- posts list start -->
<div class="content-block-title"><?php echo $Lang['Last_Activity_In']; ?> <?php echo FormatTime($UserInfo['LastPostTime']); ?></div>
<?php
foreach($PostsArray as $Post) {
?>
<div class="card">
	<div class="card-header">
		<!--<?php echo FormatTime($Post['PostTime']); ?>-->
		<a href="<?php echo $Config['WebsitePath']; ?>/goto/<?php echo $Post['TopicID']; ?>-<?php echo $Post['ID']; ?>?token=<?php echo $accessToken; ?>" data-transition="slide"><?php echo $Post['Subject'];?></a>
	</div>
	<div class="card-content">
		<div class="card-content-inner">
			<?php echo strip_tags(mb_substr($Post['Content'], 0, 300, 'utf-8'),'<p><br>'); ?>
		</div>
	</div>
	<div class="card-footer"><?php echo FormatTime($Post['PostTime']); ?></div>
</div>
<?php
}
?>