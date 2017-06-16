<?php
require(LanguagePath . 'login.php');
$Error     = '';
$ErrorCode     = 101000;
$UserName  = '';
$ReturnUrl = isset($_SERVER['HTTP_REFERER']) ? htmlspecialchars($_SERVER["HTTP_REFERER"]) : '';

if ($CurUserCode && Request('Get', 'logout') == $CurUserCode) {
	LogOut();
	if ($ReturnUrl) {
		header('location: ' . $ReturnUrl);
		exit('logout');
	} else {
		Redirect('', 'logout');
	}
}

/**
 * 接口初始化
 * @param $params
 * @param $privateKey
 * @return int
 */
function getToken($params, $privateKey)
{
    $params['ac'] = 'login';
    $params['f'] = 'tysxInit';

    ksort($params);
    $url = '';
    foreach ($params as $key => $val)
    {
        $url .= $key . '=' . $val . '&';
    }

    $url .= 'time=' . date('YmdHis') . '&';
    $prevUrl = $url . $privateKey;
    $sign = md5($prevUrl);
    $encodeUrl = $url . 'sign=' . $sign;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, APIHost . '?' . $encodeUrl);

    $ret = curl_exec($ch);
    curl_close($ch);

    $ret = json_decode($ret, TRUE);
    if (is_array($ret) && $ret['code'] == 0)
    {
        return $ret['info']['token'];
    }
    return 0;
}

/**
 * 调用API登陆
 * @param $params
 * @param $privateKey
 * @return int|mixed
 */
function apiLogin($params, $privateKey)
{
    $token = getToken(array(
        'appid' => '111010310220',
        'devid' => '000001'
    ), '4D93FAE86E640BEAFE9907DA8089A434');

    if (!$token)
    {
        return 0;
    }

    $params['ac'] = 'login';
    $params['f'] = 'userlogin';
    $params['clienttype'] = 2;
    $params['token'] = $token;

    ksort($params);
    $url = '';
    foreach ($params as $key => $val)
    {
        $url .= $key . '=' . $val . '&';
    }
    $url .= 'time=' . date('YmdHis') . '&';
    $prevUrl = $url . $privateKey;
    $sign = md5($prevUrl);
    $encodeUrl = $url . 'sign=' . $sign;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, APIHost . '?' . $encodeUrl);
    $ret = curl_exec($ch);
    curl_close($ch);
    $ret = json_decode($ret, TRUE);
    if (is_array($ret) && $ret['code'] == 0)
    {
        return $ret['info'];
    }
    return 0;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' || $IsApp) {

	if (!ReferCheck(Request('Post', 'FormHash'))) {
		AlertMsg($Lang['Error_Unknown_Referer'], $Lang['Error_Unknown_Referer'], 403);
	}
	$ReturnUrl  = htmlspecialchars(Request('Post', 'ReturnUrl'));
	$UserName   = strtolower(Request('Post', 'UserName'));
	$Password   = Request('Post', 'Password');
	$Expires    = min(intval(Request('Post', 'Expires', 30)), 30); //最多保持登陆30天
	$VerifyCode = intval(Request('Post', 'VerifyCode'));
	do{
		if (!$UserName || !$Password || !$VerifyCode) {
			$Error = $Lang['Forms_Can_Not_Be_Empty'];
			$ErrorCode     = 101001;
			break;
		}

		session_start();
		$TempVerificationCode = "";
		if (isset($_SESSION[PREFIX . 'VerificationCode'])) {
			$TempVerificationCode = intval($_SESSION[PREFIX . 'VerificationCode']);
			unset($_SESSION[PREFIX . 'VerificationCode']);
		} elseif (DEBUG_MODE === true) {
			$TempVerificationCode = 1234;
		} else {
			$Error = $Lang['Verification_Code_Error'];
			$ErrorCode     = 101002;
			break;
		}
		session_write_close();
		if ($VerifyCode !== $TempVerificationCode) {
			$Error = $Lang['Verification_Code_Error'];
			$ErrorCode     = 101002;
			break;
		}


		$DBUser = $DB->row("SELECT ID,UserName,Salt,Password,UserRoleID,UserMail,UserIntro FROM " . PREFIX . "users WHERE UserName = :UserName", array(
			"UserName" => $UserName
		));
		if (!$DBUser) {
			$Error = $Lang['User_Does_Not_Exist'];
			$ErrorCode     = 101003;
			break;
		}

		if (!HashEquals($DBUser['Password'], md5($Password . $DBUser['Salt']))) {
			$Error = $Lang['Password_Error'];
			$ErrorCode     = 101004;
			break;
		}


/*调用API登录接口*/
        $DBUser = apiLogin(array(
            'uname' => $UserName,
            'upass' => $Password,
            'appid' => '115020310073',
            'devid' => '000001'
        ), '8A3B41BEA744F6CCD76DD1F9366EA04C');

        if (!$DBUser)
        {
            $Error = $Lang['User_Or_Password_Error'];
            $ErrorCode  = 101005;
            break;
        }

        UpdateUserInfo(array(
            'UserName'  => $DBUser['nickName'],
			'LastLoginTime' => $TimeStamp,
			'UserLastIP' => CurIP()
		), $DBUser['uid']);

		$TemporaryUserExpirationTime = $Expires * 86400 + $TimeStamp;
		if( !$IsApp ){
			SetCookies(array(
				'UserID' => $DBUser['uid'],
				'UserExpirationTime' => $TemporaryUserExpirationTime,
				'UserCode' => md5($TemporaryUserExpirationTime . SALT),
                'UserName' => $DBUser['nickName'] ? $DBUser['nickName'] : ''
			), $Expires);

			if ( $ReturnUrl ) {
				header('location: ' . $ReturnUrl);
				exit('logined');
			} else {
				Redirect('', 'logined');
			}
		}
	}while(false);
}

$DB->CloseConnection();
// 页面变量
$PageTitle   = $Lang['Log_In'];
$ContentFile = $TemplatePath . 'login.php';
include($TemplatePath . 'layout.php');