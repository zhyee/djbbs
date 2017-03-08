<?php
require(LanguagePath . 'new.php');
Auth(1, 0, true);

$ErrorCodeList = require(LibraryPath . 'code/new.error.code.php');
$Error     = '';
$ErrorCode = $ErrorCodeList['Default'];
$Title     = '';
$Content   = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	SetStyle('api', 'API');
	if (!ReferCheck(Request('Post', 'FormHash'))) {
		AlertMsg($Lang['Error_Unknown_Referer'], $Lang['Error_Unknown_Referer'], 403);
	}
	$Title     = Request('Post', 'Title');
    $BoardID   = intval(Request('Post', 'BoardID'));
    $Content   = Request('Post', 'Content');


	$TagsArray = isset($_POST['Tag']) ? $_POST['Tag'] : array();
	do {
		if (DEBUG_MODE === false && ($TimeStamp - $CurUserInfo['LastPostTime']) <= 8) { //发帖至少要间隔8秒
			$Error     = $Lang['Posting_Too_Often'];
			$ErrorCode = $ErrorCodeList['Posting_Too_Often'];
			break;
		}

		if (!$Title) {
			$Error     = $Lang['Title_Empty'];
			$ErrorCode = $ErrorCodeList['Title_Empty'];
			break;
		}

		if (!$BoardID)
        {
            $Error      = '请选择版块';
            $ErrorCode = $ErrorCodeList['BoardID_Empty'];
            break;
        }
		
		
		if (strlen($Title) > $Config['MaxTitleChars'] || strlen($Content) > $Config['MaxPostChars']) {
			$Error     = str_replace('{{MaxPostChars}}', $Config['MaxPostChars'], str_replace('{{MaxTitleChars}}', $Config['MaxTitleChars'], $Lang['Too_Long']));
			$ErrorCode = $ErrorCodeList['Too_Long'];
			break;
		}

		$BoardInfo = $DB->row("SELECT * FROM `" . PREFIX . "boards` WHERE ID = ? AND GroupID = ? LIMIT 1", array($BoardID, $CurGroupID));

        if (!is_array($BoardInfo) || !$BoardInfo['ID'])
        {
            $Error      = '该版块不存在';
            $ErrorCode  = $ErrorCodeList['Board_Not_Exists'];
            break;
        }

		// 内容过滤系统
		$TitleFilterResult = Filter($Title);
		$ContentFilterResult = Filter($Content);
		$GagTime = ($TitleFilterResult['GagTime'] > $ContentFilterResult['GagTime']) ? $TitleFilterResult['GagTime'] : $ContentFilterResult['GagTime'];
		$GagTime = $CurUserRole < 3 ? $GagTime : 0;
		$Prohibited = $TitleFilterResult['Prohibited'] | $ContentFilterResult['Prohibited'];
		if ($Prohibited){
			$Error     = $Lang['Prohibited_Content'];
			$ErrorCode = $ErrorCodeList['Prohibited_Content'];
			if ($GagTime) {
				//禁言用户 $GagTime 秒
				UpdateUserInfo(array(
					"LastPostTime" => $TimeStamp + $GagTime
				));
			}
			break;	
		}

		$Title = $TitleFilterResult['Content'];
		$Content = $ContentFilterResult['Content'];

		//往Topics表插入数据
		$TopicData      = array(
			"ID" => null,
            "GroupID" => $CurGroupID,
			"Topic" => htmlspecialchars($Title),
			"Tags" => "111", //过滤不合法的标签请求
            "BoardID" => $BoardID,
			"UserID" => $CurUserID,
			"UserName" => $CurUserName,
			"LastName" => "",
			"PostTime" => $TimeStamp,
			"LastTime" => $TimeStamp,
			"IsGood" => 0,
			"IsTop" => 0,
			"IsLocked" => 0,
			"IsDel" => 0,
			"IsVote" => 0,
			"Views" => 0,
			"Replies" => 0,
			"Favorites" => 0,
			"RatingSum" => 0,
			"TotalRatings" => 0,
			"LastViewedTime" => 0,
			"PostsTableName" => null,
			"ThreadStyle" => "",
			"Lists" => "",
			"ListsTime" => $TimeStamp,
			"Log" => ""
		);
        
		$NewTopicResult = $DB->query("INSERT INTO `" . PREFIX . "topics` (
				`ID`, 
				`GroupID`,
				`Topic`, 
				`Tags`, 
				`BoardID`,
				`UserID`, 
				`UserName`, 
				`LastName`, 
				`PostTime`, 
				`LastTime`, 
				`IsGood`, 
				`IsTop`, 
				`IsLocked`, 
				`IsDel`, 
				`IsVote`, 
				`Views`, 
				`Replies`, 
				`Favorites`, 
				`RatingSum`, 
				`TotalRatings`, 
				`LastViewedTime`, 
				`PostsTableName`, 
				`ThreadStyle`, 
				`Lists`, 
				`ListsTime`, 
				`Log`
			) VALUES (
				:ID,
				:GroupID,
				:Topic,
				:Tags,
				:BoardID,
				:UserID,
				:UserName,
				:LastName,
				:PostTime,
				:LastTime,
				:IsGood,
				:IsTop,
				:IsLocked,
				:IsDel,
				:IsVote,
				:Views,
				:Replies,
				:Favorites,
				:RatingSum,
				:TotalRatings,
				:LastViewedTime,
				:PostsTableName,
				:ThreadStyle,
				:Lists,
				:ListsTime,
				:Log
			)", $TopicData);
		
		$TopicID       = $DB->lastInsertId();

		//往Posts表插入数据
		$PostData      = array(
			"ID" => null,
			"TopicID" => $TopicID,
			"IsTopic" => 1,
			"UserID" => $CurUserID,
			"UserName" => $CurUserName,
			"Subject" => htmlspecialchars($Title),
			"Content" => XssEscape($Content),
			"PostIP" => $CurIP,
			"PostTime" => $TimeStamp
		);
		$NewPostResult = $DB->query("INSERT INTO `" . PREFIX . "posts` 
			(`ID`, `TopicID`, `IsTopic`, `UserID`, `UserName`, `Subject`, `Content`, `PostIP`, `PostTime`) 
			VALUES (:ID,:TopicID,:IsTopic,:UserID,:UserName,:Subject,:Content,:PostIP,:PostTime)", $PostData);
		
		$PostID = $DB->lastInsertId();
		
		if ($NewTopicResult && $NewPostResult) {
			//更新全站统计数据
			$NewConfig = array(
				"NumTopics" => $Config["NumTopics"] + 1,
				"DaysTopics" => $Config["DaysTopics"] + 1
			);
			UpdateConfig($NewConfig, $CurGroupID);

			//更新用户自身统计数据
			UpdateUserInfo(array(
				"Topics" => $CurUserInfo['Topics'] + 1,
				"LastPostTime" => $TimeStamp + $GagTime
			));
			//标记附件所对应的帖子标签
			$DB->query("UPDATE `" . PREFIX . "upload` SET PostID=? WHERE `PostID`=0 and `UserName`=?", array(
				$PostID,
				$CurUserName
			));

			/* 更新版块统计信息 */
            if (date('Ymd', $TimeStamp) === date('Ymd', $BoardInfo['MostRecentPostTime']))
            {
                $TodayPosts = (int)$BoardInfo['TodayPosts'] + 1;
            }
            else
            {
                $TodayPosts = 1;
            }
            $TotalPosts = (int)$BoardInfo['TotalPosts'] + 1;

            $DB->query("UPDATE `" . PREFIX . "boards` SET TotalPosts = ?, TodayPosts = ?, MostRecentPostTime = ? WHERE `ID` = ?", array(
                $TotalPosts,
                $TodayPosts,
                $TimeStamp,
                $BoardID
            ));


			//添加提醒消息
//			AddingNotifications($Content, $TopicID, $PostID);
			//清理首页内存缓存
			if ($MCache) {
				$MCache->delete(MemCachePrefix . 'Homepage');
			}
			//跳转到主题页
			//Redirect('t/'.$TopicID);
		}
	} while (false);
}

/*获取所有版块*/
$TotalBoards = $DB->query("SELECT * FROM `" . PREFIX . "boards` WHERE `IsEnabled` = 1 ORDER BY TotalPosts DESC, ID ASC");
if (!$TotalBoards)
{
    $TotalBoards = array();
}

$DB->CloseConnection();
// 页面变量
$PageTitle   = $Lang['Create_New_Topic'];
$ContentFile = $TemplatePath . 'new.php';
include($TemplatePath . 'layout.php');