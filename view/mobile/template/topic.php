<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');
?>

<div class="container">

<?php
if($Page>1){
?>
<ul class="list topic-list">
	<li class="pagination"><a href="<?php echo $Config['WebsitePath']; ?>/t/<?php echo $ID.'-'.($Page-1); ?>?token=<?php echo $accessToken; ?>" data-transition="slide"><?php echo $Lang['Page_Previous']; ?></a></li>
</ul>
<?php
}
if($Page==1){
?>
<div class="card">
	<div class="card-header"><?php echo $Topic['Topic']; ?></div>
	<div class="card-content" id="p<?php echo $PostsArray[0]['ID']; ?>">
		<div class="card-content-inner">
			<div class="color-gray">
				<div class="avatar board-avatar">
					<a href="<?php echo $Config['WebsitePath'].'/u/'.$Topic['UserID']; ?>?token=<?php echo $accessToken; ?>">
						<img src="<?php echo MyGetAvatar($Topic['UserID'], $Topic['UserName'], 'small'); ?>" width="34" height="34" />
					</a>
					<a class="dj-nickname" href="<?php echo $Config['WebsitePath'].'/u/'.$Topic['UserID']; ?>?token=<?php echo $accessToken; ?>">
						<?php echo htmlspecialchars($Topic['UserName']); ?>
					</a>
				</div>
				<div style="float: left; margin: 5px 0 0 20px;">
					<p>创建于 <?php echo FormatTime($Topic['PostTime']); ?></p>
					<p><?php echo ($Topic['Views']+1); ?><?php echo $Lang['People_Have_Seen']; ?></p>
				</div>
				<div class="c"></div>
			</div>
			<p><?php echo $PostsArray[0]['Content']; ?></p>
			<div class="button-grouped"></div>
		</div>
	</div>
</div>
<!-- post main content end -->
<?php
	unset($PostsArray[0]);
}

if(!$Topic['IsLocked'] && !$CurUserInfo){
?>
	<ul class="list topic-list"><li class="pagination"><?php echo $Lang['Requirements_For_Login']; ?></li></ul>
<?php
}else if($Topic['IsLocked']){
?>
	<ul class="list topic-list"><li class="pagination"><?php echo $Lang['Topic_Has_Been_Locked']; ?></li></ul>
<?php
}else{
?>
	<p><a href="#" class="button block red" onclick="JavaScript:Reply('<?php echo $Topic['UserName'];?>', 0, 0, '<?php echo $FormHash;?>', <?php echo $ID; ?>);"><?php echo $Lang['Reply']; ?></a></p>
<?php
}

if($Topic['Replies']!=0)
{
?>
<!-- comment list start -->
<div class="content-block-title">
	<?php echo $Topic['Replies']; ?> <?php echo $Lang['Replies']; ?>  |  <?php echo $Lang['Last_Updated_In']; ?> <?php echo FormatTime($Topic['LastTime']); ?>
</div>
<?php
foreach($PostsArray as $key => $Post)
{
	$PostFloor = ($Page-1)*$Config['PostsPerPage']+$key;
?>
<div class="card carbonforum-card">
	<div class="card-header no-border">
		<div class="carbonforum-avatar">
			<a href="<?php echo $Config['WebsitePath'].'/u/'.$Post['UserID']; ?>?token=<?php echo $accessToken; ?>">
				<?php echo GetAvatar($Post['UserID'], $Post['UserName'], 'small'); ?>
			</a>
		</div>
		<div class="carbonforum-name"><?php echo $Post['UserName'];?></div>
		<div class="carbonforum-date"><?php echo FormatTime($Post['PostTime']); ?></div>
		<div class="carbonforum-floor">#<?php echo $PostFloor; ?></div>
	</div>
	<div class="card-content" id="p<?php echo $Post['ID']; ?>"><p><?php echo $Post['Content']; ?></p></div>
	<div class="card-footer no-border">
<?php if($CurUserID){
?>

	<?php if(!$Topic['IsLocked']){ ?>
	<a href="#" title="<?php echo $Lang['Reply']; ?>" onclick="JavaScript:Reply('<?php echo $Post['UserName'];?>', <?php echo $PostFloor; ?>, <?php echo $Post['ID'];?>, '<?php echo $FormHash;?>', <?php echo $ID;?>);" class="link"><?php echo $Lang['Reply']; ?></a>
		<?php } ?>
<?php } ?>
	</div>
</div>
<?php
}
?>
<!-- comment list end -->
<?php
}
?>
<ul class="list topic-list">
<?php
if($Page<$TotalPage){
?>
	<li class="pagination"><a href="<?php echo $Config['WebsitePath']; ?>/t/<?php echo $ID.'-'.($Page+1); ?>?token=<?php echo $accessToken; ?>" data-transition="slide"<?php echo (($Page+1)==$TotalPage)?' data-refresh="true"':''; ?>><?php echo $Lang['Page_Next']; ?></a></li>
<?php } ?>
</ul>
</div>
<script type="text/javascript">
TopicParse();
</script>