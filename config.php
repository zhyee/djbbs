<?php
// set automatically the time zone
date_default_timezone_set('Asia/Shanghai');
define('DEBUG_MODE', false);

// Salt for Cookie and Form
// Free to modify
define('SALT', 'AuthorIsLinCanbin');
define('PREFIX', 'carbon_');
define('InternalAccess', true);
/*模板文件使用
if (!defined('InternalAccess')) exit('error: 403 Access Denied');
来防止模板文件被游客访问
*/
define('ForumLanguage', 'zh-cn');
//MemCache(d)
define('EnableMemcache', false);
define('MemCacheHost', 'localhost');
define('MemCachePort', 11211);//Memcache: 11211, Redis: 6379
define('MemCachePrefix', 'djbbs_');

//Redis
define('RedisHost', '192.168.23.139');
define('RedisPort', 6379);
define('RedisPrefix', 'djbbs_');
define('RedisUserinfoPrefix', 'userinfo');  //userinfo缓存前缀

//Database
define('DBHost', '192.168.24.66');
define('DBPort', '3306');
define('DBName', 'dj_bbs');
define('DBUser', 'root');
define('DBPassword', 'fXL2bO$RQgaRS^lH');
//Sphinx Server
define('SearchServer', '');
define('SearchPort', '');

define('RootPath', __DIR__);
define('LanguagePath', __DIR__ . '/language/' . ForumLanguage . '/');
define('LibraryPath', __DIR__ . '/library/');
//define('APIHost', 'http://192.168.23.139:8081/cpms/Internet');
define('APIHost', 'http://api.tv189.com/cpms/Internet');

// API checking data
// List<Map<String APIKey, String APISecret>>
// Free to modify
$APISignature = array();
$APISignature['12450'] = 'b40484df0ad979d8ba7708d24c301c38';

if (DEBUG_MODE) {
	//Enable error report
	error_reporting(E_ALL); 
	ini_set('display_errors', 'On');
} else {
	//Disable error report
	ini_set('display_errors', 'Off');
}