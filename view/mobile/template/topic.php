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
	<div class="card-title"><?php echo $Topic['Topic']; ?></div>
	<div class="card-content" id="p<?php echo $PostsArray[0]['ID']; ?>">
		<div class="card-content-inner">
			<div class="topic-author color-gray">
				<div class="avatar board-avatar">
					<a href="<?php echo $Config['WebsitePath'].'/u/'.$Topic['UserID']; ?>?token=<?php echo $accessToken; ?>">
						<img src="<?php echo MyGetAvatar($Topic['UserID'], $Topic['UserName'], 'middle'); ?>" width="34" height="34" />
					</a>
				</div>
				<div class="card-content-inner-center">
					<a href="<?php echo $Config['WebsitePath'].'/u/'.$Topic['UserID']; ?>?token=<?php echo $accessToken; ?>"><?php echo htmlspecialchars($Topic['UserName']); ?></a>
					<span class="card-role">楼主</span>
				</div>
				<div class="card-content-inner-footer">
					<span>发表于 <?php echo FormatTime($Topic['PostTime']); ?></span>
					<span class="float-right"><?php echo ($Topic['Views']+1); ?><?php echo $Lang['People_Have_Seen']; ?></span>
				</div>
				<div class="c"></div>
			</div>

			<div class="topic-content">
				<?php echo $PostsArray[0]['Content']; ?>
				<div class="area-zan">
					<div class="area-zan-icon">
                    <?php if ($IsFavorite): ?>
						<i class="iconfont icon-zan3 x3"></i>
                    <?php else: ?>
						<i class="iconfont icon-zan4 x3" rel="<?php echo $Topic['ID']; ?>" data-title="<?php echo $Topic['Topic']; ?>"></i>
                    <?php endif; ?>
						<span class="area-zan-add-count hide">+1</span>
					</div>
					<div class="area-zan-count"><span class="orange"><?php echo $FavoriteCount; ?></span>个赞</div>
				</div>

				<?php
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
					<div class="text-right reply"><a href="javascript:;" class="link reply-button" onclick="Reply('<?php echo $Topic['UserName'];?>', 0, 0, '<?php echo $FormHash;?>', <?php echo $ID; ?>);"><i class="iconfont icon-message"></i> <?php echo $Lang['Reply']; ?></a></div>
					<?php
				}
				?>

			</div>


			<?php if ($Topic['Attachment']): ?>
				<div class="download-attachment">
					<div class="download-attachment-header">附件下载:</div>
				<?php $attachs = json_decode($Topic['Attachment'], TRUE); foreach ($attachs as $attach): ?>
					<div class="download-item">
						<div class="download-filetype-icon float-left">
							<svg class="icon" aria-hidden="true">
								<use xlink:href="#<?php $extName = getExtName($attach['fileName']); if (array_key_exists($extName, $fileIcons)) echo $fileIcons[$extName]; else echo $fileIcons['default']; ?>"></use>
							</svg>
						</div>
						<div class="download-fileinfo float-left">
							<div class="download-fileinfo-title"><?php echo $attach['fileName']; ?></div>
							<div class="download-fileinfo-attr">
								<span class="download-fileinfo-size">6.32MB</span>
								<span class="download-fileinfo-date">2017.05.23 16:23</span>
							</div>
						</div>
						<div class="download-icon float-right">
							<i class="iconfont icon-xiazai x2" onclick="downloadAttach(this);return false;" rel="<?php echo $attach['fileUrl']; ?>" title="<?php echo $attach['fileName']; ?>"></i>
						</div>
						<div class="clearfix"></div>
					</div>
				<?php endforeach; ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</div>
<!-- post main content end -->
<?php
	unset($PostsArray[0]);
}
if($Topic['Replies']!=0)
{
?>
<!-- comment list start -->
<!--div class="content-block-title">
	<?php echo $Topic['Replies']; ?> <?php echo $Lang['Replies']; ?>  |  <?php echo $Lang['Last_Updated_In']; ?> <?php echo FormatTime($Topic['LastTime']); ?>
</div-->
<?php
foreach($PostsArray as $key => $Post)
{
	$PostFloor = ($Page-1)*$Config['PostsPerPage']+$key;
?>
<div class="card carbonforum-card">

    <div class="carbonforum-avatar">
        <a href="<?php echo $Config['WebsitePath'].'/u/'.$Post['UserID']; ?>?token=<?php echo $accessToken; ?>">
            <?php echo GetAvatar($Post['UserID'], $Post['UserName'], 'middle'); ?>
        </a>
    </div>

    <div class="carbonforum-right">
        <div class="card-header no-border">
            <div class="carbonforum-center">
                <div class="carbonforum-name"><?php echo $Post['UserName'];?></div>
                <div class="carbonforum-date">发表于 <?php echo FormatTime($Post['PostTime']); ?></div>
            </div>
            <div class="carbonforum-floor"><span class="orange"><?php echo $PostFloor; ?></span> 楼</div>
            <div class="c"></div>
        </div>
        <div class="card-content" id="p<?php echo $Post['ID']; ?>"><p><?php echo $Post['Content']; ?></p></div>

    </div>


		<?php if($CurUserID){
			?>
			<?php if(!$Topic['IsLocked']){ ?>
			<div class="text-right reply">
				<a href="javascript:;" onclick="Reply('<?php echo $Post['UserName'];?>', <?php echo $PostFloor; ?>, <?php echo $Post['ID'];?>, '<?php echo $FormHash;?>', <?php echo $ID;?>);" class="link reply-button"><i class="iconfont icon-message"></i> <?php echo $Lang['Reply']; ?></a>
			</div>
			<?php } ?>
		<?php } ?>

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
//TopicParse();
</script>