<?php
require(LanguagePath . 'board.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    Auth(4, 0, true);
    /**
     * 新建版块
     */
    if ($_FILES['BoardIcon'])
    {
        include(LibraryPath . 'Uploader.class.php');
        $UploadConfig = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents(LibraryPath . 'Uploader.config.json')), true);
        $fieldName = 'BoardName';
        $config    = array(
            "pathFormat" => $Config['WebsitePath'] . $UploadConfig['imagePathFormat'],
            "maxSize" => $UploadConfig['imageMaxSize'],
            "allowFiles" => $UploadConfig['imageAllowFiles']
        );
        /* 生成上传实例对象并完成上传 */
        $up = new Uploader($fieldName, $config, 'upload', $CurUserName, $DB);
        print_r($up->getFileInfo());
    }
    $BoardName = trim(Request('Post', 'BoardName'));


}



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