<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');
?>

<p class="board-a">
	<a <?php if (!$type): ?>class="active"<?php endif; ?> href="<?php echo $Config['WebsitePath']; ?>/board/<?php echo $BoardInfo['ID']; ?>?token=<?php echo $accessToken; ?>">全部</a>
	&nbsp;|&nbsp;
	<a <?php if ($type == 1): ?>class="active"<?php endif; ?> href="<?php echo $Config['WebsitePath']; ?>/board/<?php echo $BoardInfo['ID']; ?>/type/1?token=<?php echo $accessToken; ?>">与我相关</a>
</p>

<ul class="list topic-list board-list">
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
			<a class="board-nickname" href="<?php echo $Config['WebsitePath']; ?>/u/<?php echo $Topic['UserID']; ?>?token=<?php echo $accessToken; ?>" data-transition="slide">
				<?php echo htmlspecialchars($Topic['UserName']); ?>
			</a>
		</div>
		<div class="content">
			<a href="<?php echo $Config['WebsitePath']; ?>/t/<?php echo $Topic['ID']; ?>?token=<?php echo $accessToken; ?>" data-transition="slide">
				<h2><?php echo $Topic['Topic']; ?></h2>
			</a>
			<p>
				发表于 <?php echo FormatTime($Topic['PostTime']); ?>
			</p>

			<p class="replies-num"><span class="aside"><?php echo $Topic['Replies']; ?></span> &nbsp;回帖数</p>

		</div>
		
		<div class="c"></div>
	</li>
<?php
} 
if($Page<$TotalPage){
?>
	<li class="pagination"><a href="<?php echo $Config['WebsitePath']; ?>/board/<?php echo $BoardInfo['ID'] .'/page/'.($Page+1); ?>" data-transition="slide" data-persist-ajax="false"><?php echo $Lang['Page_Next']; ?></a></li>
<?php } ?>

</ul>

<p class="topic-nums">共 <?php echo $BoardInfo['TodayPosts']; ?> / <?php echo $BoardInfo['TotalPosts']; ?> <?php echo $Lang['Topics']; ?></p>
