<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');
?>
<ul class="list topic-list">
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
			<a href="<?php echo $Config['WebsitePath']; ?>/tag/<?php echo urlencode($Board['Name']); ?>">
				<?php echo GetTagIcon($Board['ID'], $Board['Icon'], $Board['Name'], 'middle'); ?>
			</a>
		</div>
		<div class="content">
		<h2>
			<a href="<?php echo $Config['WebsitePath']; ?>/tag/<?php echo urlencode($Board['Name']); ?>">
				<?php echo $Board['Name']; ?>    (<?php echo $Board['TotalPosts']; ?>)
			</a>
		</h2>
		<p><?php echo ($Board['Description']? mb_strlen($Board['Description']) > 60 ? mb_substr($Board['Description'], 0, 60, 'utf-8').'……' : $Board['Description'] : '' ); ?>
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

<p><button type="button" style="width: 100%;" onclick="javascript:createBoard();" class="button block red">新建版块</button></p>