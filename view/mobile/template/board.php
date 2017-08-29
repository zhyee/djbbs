<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');
?>

<p class="board-a">
	<a data-update="false" <?php if (!$type): ?>class="on"<?php endif; ?> href="<?php echo $Config['WebsitePath']; ?>/board/<?php echo $BoardInfo['ID']; ?>?token=<?php echo $accessToken; ?>">全部</a>

	<a data-update="false" <?php if ($type == 1): ?>class="on"<?php endif; ?> href="<?php echo $Config['WebsitePath']; ?>/board/<?php echo $BoardInfo['ID']; ?>/type/1?token=<?php echo $accessToken; ?>">与我相关</a>
</p>

<?php if ($TopicsArray) { ?>
<ul class="list topic-list board-list" id="topics-ul">
<?php
if($Page>1){
?>
	<li class="pagination"><a href="<?php echo $Config['WebsitePath']; ?>/board/<?php echo $BoardInfo['ID'].'/page/'.($Page-1); ?>?token=<?php echo $accessToken; ?>" data-transition="slide"><?php echo $Lang['Page_Previous']; ?></a></li>

<?php
}
?>
<!-- main-content start -->
<?php
foreach ($TopicsArray as $Topic) {
?>
	<li>

		<div class="avatar board-avatar">
			<a href="<?php echo $Config['WebsitePath']; ?>/u/<?php echo $Topic['UserID']; ?>?token=<?php echo $accessToken; ?>" data-transition="slide">
				<img width="53" height="53" src="<?php echo MyGetAvatar($Topic['UserID'], $Topic['UserName'], 'middle'); ?>" alt="<?php echo $Topic['UserName']; ?>"/>
			</a>
		</div>

		<div class="content">

			<p>
				<a class="dj-nickname" href="<?php echo $Config['WebsitePath']; ?>/u/<?php echo $Topic['UserID']; ?>?token=<?php echo $accessToken; ?>" data-transition="slide">
					<?php echo htmlspecialchars($Topic['UserName']); ?>
				</a>
			</p>
			<div>
				<p class="float-left">发表于 <?php echo FormatTime($Topic['PostTime']); ?></p>
				<p class="float-right"><span class="replies-num"><?php echo $Topic['Replies']; ?></span> 回帖数</p>
				<p class="c"></p>
			</div>

			<h2 class="article-title">
				<a href="<?php echo $Config['WebsitePath']; ?>/t/<?php echo $Topic['ID']; ?>?token=<?php echo $accessToken; ?>" data-transition="slide"><?php echo $Topic['Topic']; ?></a>
			</h2>
		</div>

		<div class="c"></div>
	</li>
<?php
}
if($Page<$TotalPage){
?>
	<li class="pagination">
		<a href="<?php echo $Config['WebsitePath']; ?>/board/<?php echo $BoardInfo['ID'] .'/page/'.($Page+1); ?>" data-transition="slide" data-persist-ajax="false"><?php echo $Lang['Page_Next']; ?></a>
	</li>
<?php } ?>

</ul>

<?php } else{ ?>


	<div class="list-empty">
		<i class="icon-list-empty"></i>
		<p class="title-list-empty">没有内容</p>
	</div>


<?php } ?>


<script>

	/* 委托点击li事件到a */

	$("#topics-ul>li").unbind('click').click(function (e) {
		if (e.target.tagName.toUpperCase() == 'A' || e.target.tagName.toUpperCase() == 'IMG')
		{
		}
		else
		{
			$(this).find(".content>h2>a").click();
		}

	});

</script>

