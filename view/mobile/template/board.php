<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');
?>

<ul class="list topic-list board-list">
<?php
if($Page>1){
?>
	<li class="pagination"><a href="<?php echo $Config['WebsitePath']; ?>/tag/<?php echo $BoardInfo['ID'].'/page/'.($Page-1); ?>?token=<?php echo $accessToken; ?>" data-transition="slide"><?php echo $Lang['Page_Previous']; ?></a></li>

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
					<?php echo GetAvatar($Topic['UserID'], $Topic['UserName'], 'middle'); ?>
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
	<li class="pagination"><a href="<?php echo $Config['WebsitePath']; ?>/tag/<?php echo $BoardInfo['ID'] .'/page/'.($Page+1); ?>" data-transition="slide" data-persist-ajax="false"><?php echo $Lang['Page_Next']; ?></a></li>
<?php } ?>

</ul>
<ul class="list">
	<li>共 <?php echo $BoardInfo['TodayPosts']; ?> / <?php echo $BoardInfo['TotalPosts']; ?> <?php echo $Lang['Topics']; ?></li>
	<li><?php echo $Lang['Created_In']; ?><?php echo FormatTime($BoardInfo['DateCreated']); ?></li>
</ul>
