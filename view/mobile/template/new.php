
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
	<p>
		<label for="upfile" class="fa fa-paperclip fa-2x add-attachment" onclick></label>
		<input type="file" class="add-attachment" id="upfile" onchange="javascript:UploadPicture('Content');" accept="image/*" />
	</p>
	<p>
		<textarea name="Content" id="Content" rows="10" placeholder="<?php echo $Lang['Content']; ?>"></textarea>
	</p>
	<p>
		<input type="text" name="AlternativeTag" id="AlternativeTag" value="" onclick="JavaScript:GetTags();" placeholder="<?php echo $Lang['Add_Tags']; ?>" />
		<ul id="SelectTags" class="tag-list">
			<li class="divider"><?php echo $Lang['Tags']; ?></li>
		</ul>
	</p>
	<p>
		<div id="TagsList">
		</div>
	</p>
	<p><input type="button" value="<?php echo $Lang['Submit']; ?>" name="submit" class="button block red" onclick="JavaScript:CreateNewTopic();" id="PublishButton" style="width:100%;" /></p>
</form>