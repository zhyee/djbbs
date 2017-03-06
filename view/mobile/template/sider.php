<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');
?>


<ul class="list">
	<li>
		<a class="icon home" href="<?php echo $Config['WebsitePath']; ?>/?token=<?php echo $accessToken; ?>" data-transition="slide" data-refresh="true"><?php echo $Lang['Home']; ?></a>
	</li>
	<li>
		<a class="icon pin" href="<?php echo $Config['WebsitePath']; ?>/tags?token=<?php echo $accessToken; ?>" data-transition="slide"><?php echo $Lang['Hot_Tags']; ?></a>
	</li>
	<li>
		<a class="icon question" href="JavaScript:Search();" data-transition="slide"><?php echo $Lang['Search']; ?></a>
	</li>
<?php
if($CurUserID){
?>
	<li>
		<a class="icon add" href="<?php echo $Config['WebsitePath']; ?>/new?token=<?php echo $accessToken; ?>" data-transition="slide"><?php echo $Lang['Create_New_Topic']; ?></a>
	</li>
	<li class="divider"><?php echo $Lang['User_Panel']; ?></li>
	<li>
		<a href="<?php echo $Config['WebsitePath']; ?>/u/<?php echo urlencode($CurUserID); ?>?token=<?php echo $accessToken; ?>">
			<?php echo GetAvatar($CurUserID, $CurUserName, 'small'); ?>&nbsp;&nbsp;<span style="line-height:24px;vertical-align: top;font-size:20px;font-weight:bold;"><?php echo $CurUserName; ?></span>
		</a>
	</li>
	<li>
		<a class="icon message" href="<?php echo $Config['WebsitePath']; ?>/notifications?token=<?php echo $accessToken; ?>" data-refresh="true">
			<?php echo $Lang['Notifications']; ?>
			<span class="af-badge" id="MessageNumber" style="visibility:hidden;"><?php echo $CurUserInfo['NewNotification']; ?></span>
		</a>
	</li>
	<li>
		<a class="icon settings" href="<?php echo $Config['WebsitePath']; ?>/settings?token=<?php echo $accessToken; ?>" data-transition="slide">
			<?php echo $Lang['Settings']; ?>
		</a>
	</li>
	<li>
		<a class="icon star" href="<?php echo $Config['WebsitePath']; ?>/favorites?token=<?php echo $accessToken; ?>" data-transition="slide">
			<?php echo $Lang['Favorite_Topics']; ?>(<?php echo $CurUserInfo['NumFavTopics']; ?>)
		</a>
	</li>
	<li>
		<a class="icon tag" href="<?php echo $Config['WebsitePath']; ?>/tags/following?token=<?php echo $accessToken; ?>" data-transition="slide">
			<?php echo $Lang['Tags_Followed']; ?>(<?php echo $CurUserInfo['NumFavTags']; ?>)
		</a>
	</li>
	<li>
		<a class="icon user" href="<?php echo $Config['WebsitePath']; ?>/users/following?token=<?php echo $accessToken; ?>" data-transition="slide">
			<?php echo $Lang['Users_Followed']; ?>(<?php echo $CurUserInfo['NumFavUsers']; ?>)
		</a>
	</li>
<?php
}
?>
</ul>