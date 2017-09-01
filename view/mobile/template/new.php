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
		<div>
			<input type="text" name="Title" id="Title" value="<?php echo htmlspecialchars($Title); ?>" placeholder="请输入你的标题内容" />
		</div>

		<div class="textarea">
			<textarea name="Content" id="Content" rows="8" placeholder="请输入你的文字内容"></textarea>
			<ul class="picture-list hide"></ul>
            <ul class="emotion-list hide"></ul>
            <div class="thumb-list">
                <div class="button-block">
                    <button type="button" class="iconfont icon-add add-attachment" onclick="MyUploadPicture(this);"></button>
                    <input type="file" accept="image/*" id="upfile" class="hide" onchange="javascript:UploadPicture('Content');" />
                </div>
            </div>
		</div>

        <p class="select-board">
            <i class="iconfont icon-classify-red x1-5 select-board-icon-fenlei"></i>
            <select name="BoardID" id="BoardID">
                <option value="0">选择版块</option>
                <?php foreach ($TotalBoards as $board): ?>
                    <option value="<?php echo $board['ID']; ?>"><?php echo htmlspecialchars($board['Name']); ?></option>
                <?php endforeach; ?>
            </select>
            <i class="iconfont icon-iconfontfront-copy x1-5 select-board-icon-front"></i>
        </p>

		<p>
			<!--input type="button" value="<?php echo $Lang['Submit']; ?>" name="submit" class="button block red" onclick="JavaScript:CreateNewTopic();" id="PublishButton" style="width:100%;" /-->

		</p>
	</form>

</div>

<div class="hide custom-header">
    <a name="submit" class="board-new board-new-submit" onclick="JavaScript:CreateNewTopic();" id="PublishButton">发送</a>
    <a href="javascript:;" class="emotion-btn board-new"><i class="iconfont icon-emoji x1-2"></i></a>
</div>


