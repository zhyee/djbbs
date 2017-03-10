<?php
require(LanguagePath . 'board.php');

//if ($_SERVER['REQUEST_METHOD'] == 'POST')
//{
//    /**
//     * 新建版块
//     */
//    Auth(4, 0, true);
//
//    $BoardName = trim(Request('Post', 'BoardName'));
//    if (!$BoardName)
//    {
//        echo json_decode(array('code' => -2, 'msg' => '版块名称不能为空'));
//        exit();
//    }
//
//
//    $row = $DB->row("SELECT ID FROM `" . PREFIX . "boards` WHERE Name = ? AND GroupID = ? LIMIT 1", array($BoardName, $CurGroupID));
//
//    if (is_array($row) && $row['ID'])
//    {
//        echo json_encode(array('code' => 2, 'msg' => '该版块已存在'));
//        exit();
//    }
//
//
//    if ($_FILES['BoardIcon'])
//    {
//        include(LibraryPath . 'Uploader.class.php');
//        $UploadConfig = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents(LibraryPath . 'Uploader.config.json')), true);
//        $fieldName = 'BoardIcon';
//        $config    = array(
//            "pathFormat" => $Config['WebsitePath'] . $UploadConfig['imagePathFormat'],
//            "maxSize" => $UploadConfig['imageMaxSize'],
//            "allowFiles" => $UploadConfig['imageAllowFiles']
//        );
//        /* 生成上传实例对象并完成上传 */
//        $up = new Uploader($fieldName, $config, 'upload', $CurUserName, $DB);
//        $icon = $up->getFileInfo();
//        if ($icon['state'] != 'SUCCESS')
//        {
//            echo json_encode(array('code' => -1, 'msg' => $icon['state']));
//            exit();
//        }
//    }
//
//    $boardData = array(
//        'ID'    => NULL,
//        'Name'  => $BoardName,
//        'GroupID' => $CurGroupID,
//        'Followers' => 0,
//        'Icon'      => isset($icon) ? $icon['url'] : '',
//        'Description'   => '',
//        'IsEnabled'     => 1,
//        'TotalPosts'   => 0,
//        'TodayPosts'    => 0,
//        'MostRecentPostTime'    => 0,
//        'DateCreated'   => $TimeStamp
//    );
//
//    $res = $DB->query("INSERT INTO `" . PREFIX . "boards`
//        (
//            `ID`,
//            `Name`,
//            `GroupID`
//            `Followers`,
//            `Icon`,
//            `Description`,
//            `IsEnabled`,
//            `TotalPosts`,
//            `TodayPosts`,
//            `MostRecentPostTime`,
//            `DateCreated`
//        )
//        VALUES
//        (
//            :ID,
//            :Name,
//            :GroupID
//            :Followers,
//            :Icon,
//            :Description,
//            :IsEnabled,
//            :TotalPosts,
//            :TodayPosts,
//            :MostRecentPostTime,
//            :DateCreated
//        )", $boardData);
//
//    if ($res)
//    {
//        echo json_encode(array('code' => 0, 'msg' => 'OK'));
//    }
//    else
//    {
//        echo json_encode(array('code' => 1, 'msg' => '新建失败，请稍后再试'));
//    }
//    exit();
//}



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
	WHERE IsEnabled=1 AND GroupID = ?
	ORDER BY TotalPosts DESC 
	LIMIT ' . ($Page - 1) * $Config['TopicsPerPage'] . ',' . $Config['TopicsPerPage'], array($CurGroupID));

if ($CurUserID && $BoardsArray) {
	$IsFavoriteArray = array_flip($DB->column("SELECT FavoriteID FROM " . PREFIX . "favorites 
		Where UserID=".$CurUserID." and Type=2 and FavoriteID in (?)",
		ArrayColumn($TagsArray, 'ID')
	));
	//var_dump($IsFavoriteArray);
}

$DB->CloseConnection();

$PageTitle = $Page > 1 ? ' Page' . $Page . '-' : '';
$PageTitle .= $Lang['Board'];
$ContentFile  = $TemplatePath . 'boards.php';
include($TemplatePath . 'layout.php');