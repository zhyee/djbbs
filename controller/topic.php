<?php
require(LanguagePath . 'topic.php');


$fileIcons = array(
    'mp4' => 'icon-MOV',
    'avi' => 'icon-MOV',
    'wmv' => 'icon-MOV',
    'swf' => 'icon-MOV',
    'mp3' => 'icon-MP',
    'wav' => 'icon-MP',
    'zip' => 'icon-ZIP',
    'rar' => 'icon-RAR',
    'txt' => 'icon-TXT',
    'ppt' => 'icon-PPT',
    'doc' => 'icon-DOC',
    'docx' => 'icon-DOC',
    'xls' => 'icon-XLS',
    'xlsx' => 'icon-XLS',
    'pdf' => 'icon-PDF',
    'png' => 'icon-PNG',
    'jpg' => 'icon-JPEG',
    'jpeg' => 'icon-JPEG',
    'gif' => 'icon-GIF',
    'default' => 'icon-geshi_weizhi'
);

/**
 * 获取扩展名
 */
function getExtName($filename)
{
    $extName = strrchr($filename, '.');
    return strtolower(trim($extName, '.'));
}


$ID   = intval(Request('Request', 'id'));
$Page = intval(Request('Request', 'page'));
if ($MCache) {
	$Topic = $MCache->get(MemCachePrefix . 'Topic_' . $ID);
	if (!$Topic) {
		$Topic = $DB->row("SELECT * FROM " . PREFIX . "topics 
			FORCE INDEX(PRI) 
			WHERE ID=:ID", array(
			'ID' => $ID
		));
		$MCache->set(MemCachePrefix . 'Topic_' . $ID, $Topic, 86400);
	}
} else {
	$Topic = $DB->row("SELECT * FROM " . PREFIX . "topics 
		FORCE INDEX(PRI) 
		WHERE ID=:ID", array(
		'ID' => $ID
	));
}

if (!$Topic || ($Topic['IsDel'] && $CurUserRole < 3)) {
	AlertMsg('404 Not Found', '404 Not Found', 404);
}
$TotalPage = ceil(($Topic['Replies'] + 1) / $Config['PostsPerPage']);
if (($Page < 0 || $Page == 1) && !$IsApp)
	Redirect('t/' . $ID);
if ($Page > $TotalPage) 
	Redirect('t/' . $ID . '-' . $TotalPage);
if ($Page == 0)
	$Page = 1;
$PostsArray = $DB->query("SELECT `ID`, `TopicID`,`UserID`, `UserName`, `Content`, `PostTime`, `IsDel` 
	FROM " . PREFIX . "posts 
	FORCE INDEX(TopicID) 
	WHERE TopicID=:id 
	ORDER BY PostTime ASC 
	LIMIT " . ($Page - 1) * $Config['PostsPerPage'] . "," . $Config['PostsPerPage'], array(
	"id" => $ID
));
if ($CurUserID) {
    // 本人是否已点过赞
	$IsFavorite = intval($DB->single("SELECT ID 
		FROM " . PREFIX . "favorites 
		WHERE UserID=:UserID and Type=1 AND FavoriteID=:FavoriteID", array(
		'UserID' => $CurUserID,
		'FavoriteID' => $ID
	)));
}

// 点赞数
$FavoriteCount = intval($DB->single("SELECT COUNT(ID) AS total FROM " . PREFIX . "favorites WHERE Type = '1' AND FavoriteID=:FavoriteID" , array('FavoriteID' => $ID)));

//更新浏览量
if ($MCache) {
	$TopicViews = $MCache->get(MemCachePrefix . 'Topic_Views_' . $ID);
	//十天内攒满100次点击，Update一次数据库数据
	if ($TopicViews && ($TopicViews - $Topic['Views']) >= 100) {
		$DB->query("UPDATE " . PREFIX . "topics 
			FORCE INDEX(PRI) 
			SET Views = :Views,LastViewedTime = :LastViewedTime Where ID=:ID", array(
			'Views' => $TopicViews + 1,
			"LastViewedTime" => $TimeStamp,
			"ID" => $ID
		));
		//清理主题缓存
		$MCache->delete(MemCachePrefix . 'Topic_' . $ID);
	}
	$Topic['Views'] = (($TopicViews) ? $TopicViews : $Topic['Views']) + 1;
	$MCache->set(MemCachePrefix . 'Topic_Views_' . $ID, $Topic['Views'], 864000);
} else {
	$DB->query("UPDATE " . PREFIX . "topics 
		FORCE INDEX(PRI) 
		SET Views = Views+1,LastViewedTime = :LastViewedTime Where ID=:ID", array(
		"LastViewedTime" => $TimeStamp,
		"ID" => $ID
	));
}

//print_r($Topic);die;

//当回复内容与欲回复内容会同页时，不显示引用按钮
if ($Page != $TotalPage || ($Topic['Replies'] + 1) % $Config['PostsPerPage'] == 0) {
	$EnableQuote = true;
} else {
	$EnableQuote = false;
}
$DB->CloseConnection();
$PageTitle = $Topic['Topic'];
$PageTitle .= $Page > 1 ? ' Page' . $Page : '';
$PageMetaDesc    = htmlspecialchars(mb_substr(trim(strip_tags($PostsArray[0]['Content'])), 0, 150, 'utf-8'));

/*过滤掉文章正文的链接*/
foreach ($PostsArray as $key => $post)
{
    $PostsArray[$key]['Content'] = preg_replace('/href="http[^"]+"/i', 'href="javascript:;"', $post['Content']);
    $PostsArray[$key]['Content'] = str_replace("\n", "<br />", $post['Content']);
}

$PageMetaKeyword = str_replace('|', ',', $Topic['Tags']);
$ContentFile     = $TemplatePath . 'topic.php';
include($TemplatePath . 'layout.php');