<?php
require(LanguagePath . 'board.php');
$BoardID = (int)Request('Get', 'id');
$Page    = (int)Request('Get', 'page');
$type    = (int)Request('Get', 'type');

var_dump($type);

$BoardInfo = array();

if ($BoardID)
	$BoardInfo = $DB->row('SELECT * FROM `' . PREFIX . 'boards`  WHERE ID = ? AND GroupID = ?',
		array($BoardID, $CurGroupID)
	);
if (empty($BoardInfo) || ($BoardInfo['IsEnabled'] == 0 && $CurUserRole < 3))
{
    AlertMsg('404 Not Found', '404 Not Found', 404);
}
$TotalPage = ceil($BoardInfo['TotalPosts'] / $Config['TopicsPerPage']);
if ($Page < 1)
{
//    Redirect('tag/' . $TagInfo['Name']);
    $Page = 1;
}
else if ($Page > $TotalPage)
{
//    Redirect('tag/' . $TagInfo['Name'] . '/page/' . $TotalPage);
    $Page = $TotalPage;
}

$TopicsArray = $DB->query("SELECT `ID`, `Topic`, `UserID`, `UserName`, `PostTime`, `LastName`, `LastTime`, `Replies` FROM `" . PREFIX . "topics` WHERE 
BoardID = :BoardID AND IsDel = 0 ORDER BY ID DESC LIMIT :offset,:limit", array(
    'BoardID' => $BoardID,
    'offset'    => ($Page - 1) * $Config['TopicsPerPage'],
    'limit' => $Config['TopicsPerPage']
));


$DB->CloseConnection();
$PageTitle = $BoardInfo['Name'];
$PageTitle .= $Page > 1 ? ' Page' . $Page : '';
$PageMetaDesc = $BoardInfo['Name'] . ' - ' . htmlspecialchars(mb_substr(trim(strip_tags($BoardInfo['Description'])), 0, 150, 'utf-8'));
$ContentFile  = $TemplatePath . 'board.php';
include($TemplatePath . 'layout.php');