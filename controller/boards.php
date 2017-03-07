<?php
require(LanguagePath . 'board.php');
$Page      = intval(Request('Get', 'page'));
$TotalPage = ceil($Config['NumBoards'] / $Config['TopicsPerPage']);
if ($Page < 0 || $Page == 1)
	Redirect('tags');
if ($Page > $TotalPage)
	Redirect('tags/page/' . $TotalPage);
if ($Page == 0)
	$Page = 1;

$BoardsArray = array();
$IsFavoriteArray = array();
// UPDATE `carbon_tags` t SET t.Description=(SELECT d.Abstract FROM `carbon_dict` d WHERE d.Title = t.Name limit 1)

$BoardsArray = $DB->query('SELECT * 
	FROM ' . PREFIX . 'boards 
	WHERE IsEnabled=1
	ORDER BY TotalPosts DESC 
	LIMIT ' . ($Page - 1) * $Config['TopicsPerPage'] . ',' . $Config['TopicsPerPage']);

if ($CurUserID && $BoardsArray){
	$IsFavoriteArray = array_flip($DB->column("SELECT FavoriteID FROM " . PREFIX . "favorites 
		Where UserID=".$CurUserID." and Type=2 and FavoriteID in (?)",
		ArrayColumn($TagsArray, 'ID')
	));
	//var_dump($IsFavoriteArray);
}

$DB->CloseConnection();

$PageTitle = $Page > 1 ? ' Page' . $Page . '-' : '';
$PageTitle .= $Lang['Hot_Tags'];
$ContentFile  = $TemplatePath . 'boards.php';
include($TemplatePath . 'layout.php');