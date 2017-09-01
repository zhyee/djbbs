<?php
/**
 * 点赞逻辑处理
 */

$TopicID = (int)Request('Post', 'TopicID');
$Title = trim(Request('Post', 'Title'));

$Title = addslashes($Title);

if ($TopicID)
{
    echo json_encode(array(
        'code' => 1,
        'message' => '缺少参数TopicID'
    ));
    exit();
}

$Favourite = $DB->row("SELECT ID FROM " . PREFIX . "favorites WHERE `UserID` = ? AND `Type` = '1' AND `FavoriteID` = ?", array($CurUserID, $TopicID));

if ($Favourite['ID'])
{
    echo json_encode(array(
        'code' => 2,
        'message' => '已点过赞'
    ));

    exit();
}

$DB->query("INSERT INTO " . PREFIX . "favorites (`UserID`, `Title`, `Type`, `FavoriteID`, `DateCreated`) VALUES ('$CurUserID', '$Title', '1', '$TopicID', ". time() .")");

echo json_encode(
    array(
        'code' => 0,
        'message' => 'ok'
    )
);

