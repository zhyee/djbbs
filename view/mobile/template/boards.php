<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');
?>
<ul class="list topic-list board-list" id="boards-ul">
<?php
if($Page>1){
?>
	<li class="pagination"><a href="<?php echo $Config['WebsitePath']; ?>/tags/page/<?php echo ($Page-1); ?>?token=<?php echo $accessToken; ?>" data-transition="slide"><?php echo $Lang['Page_Previous']; ?></a></li>
<?php
}
foreach ($BoardsArray as $Board) {
?>
	<li>
		<div class="avatar">
				<img src="<?php echo GetBoardIcon($Board['ID'], $Board['Icon'], $Board['Name'], 'middle'); ?>" alt="<?php echo $Board['Name']; ?>" />
		</div>
		<div class="content">
			<h2>
				<a data-title="<?php echo $Board['Name']; ?>" href="<?php echo $Config['WebsitePath']; ?>/board/<?php echo $Board['ID']; ?>?token=<?php echo $accessToken; ?>">
					<?php echo $Board['Name']; ?>
				</a>
			</h2>
		<!--p>
			<?php echo ($Board['Description']? mb_strlen($Board['Description']) > 60 ? mb_substr($Board['Description'], 0, 60, 'utf-8').'……' : $Board['Description'] : '' ); ?>
		</p-->
			<p>
				<span class="number-topic">今日 ( <?php echo $Board['TodayPosts']; ?> )</span>
				<span class="number-topic">总贴 ( <?php echo $Board['TotalPosts']; ?> )</span>
			</p>
		</div>
		
		<div class="c"></div>
	</li>
<?php
} 
if($Page<$TotalPage){
?>
	<li class="pagination"><a href="<?php echo $Config['WebsitePath']; ?>/tags/page/<?php echo ($Page+1); ?>" data-transition="slide"><?php echo $Lang['Page_Next']; ?></a></li>
<?php
}
?>
</ul>

<script type="text/javascript">
	$("#boards-ul>li").unbind('click').click(function (e) {
		if (e.target.tagName.toUpperCase() === 'A')
		{
		}
		else
		{
			$(this).find("a:first").click();
		}
	});

</script>
