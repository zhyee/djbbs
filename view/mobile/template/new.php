<?php

$userAgent = $_SERVER['HTTP_USER_AGENT'];

$ipad = preg_match('/(iPad).*OS\s([\d_]+)/', $userAgent);
$iphone = !$ipad && preg_match('/(iPhone\sOS)\s([\d_]+)/', $userAgent);
$ios = $ipad || $iphone;
?>


<?php
if (!defined('InternalAccess')) exit('error: 403 Access Denied');
?>
<script type="text/javascript">
	var MaxTagNum = <?php echo $Config["MaxTagsNum"]; ?>;//最多的话题数量
	var MaxTitleChars = <?php echo $Config['MaxTitleChars']; ?>;//主题标题最多字节数
	var MaxPostChars = <?php echo $Config['MaxPostChars']; ?>;//主题内容最多字节数
	loadScript("<?php echo $Config['WebsitePath']; ?>/static/js/mobile.new.function.js?version=<?php echo $Config['Version']; ?>", function() {
		$.each(<?php echo json_encode(ArrayColumn($HotTagsArray, 'Name')); ?>,function(Offset,TagName) {
			TagsListAppend(TagName, Offset);
		});
	});
</script>
<div class="container">
	<form name="NewForm">
		<input type="hidden" name="FormHash" value="<?php echo $FormHash; ?>" />
		<input type="hidden" name="ContentHash" value="" />
		<input type="hidden" name="token" value="<?php echo $accessToken; ?>" />
		<p>
			<input type="text" name="Title" id="Title" value="<?php echo htmlspecialchars($Title); ?>" placeholder="<?php echo $Lang['Title']; ?>" />
		</p>
		<p>
			<select name="BoardID" id="BoardID">
				<option value="0">选择版块</option>
				<?php foreach ($TotalBoards as $board): ?>
					<option value="<?php echo $board['ID']; ?>"><?php echo htmlspecialchars($board['Name']); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p class="p-add-attachment">
			<button type="button" class="iconfont icon-camera x2 add-attachment" onclick="MyUploadPicture(this);"></button>
			<input type="file" accept="image/*" id="upfile" style="display: none;" onchange="javascript:UploadPicture('Content');" />

			<button type="button" class="iconfont icon-emoji x2 add-attachment"></button>
		</p>
		<div>
			<textarea name="Content" id="Content" rows="10" placeholder="<?php echo $Lang['Content']; ?>"></textarea>
			<ul class="picture-list" style="display: none;"></ul>
		</div>

		<p>
			<!--input type="button" value="<?php echo $Lang['Submit']; ?>" name="submit" class="button block red" onclick="JavaScript:CreateNewTopic();" id="PublishButton" style="width:100%;" /-->
			<a type="button" name="submit" class="button block red" onclick="JavaScript:CreateNewTopic();" id="PublishButton" style="width:100%;" ><?php echo $Lang['Submit']; ?></a>
		</p>
	</form>
</div>
