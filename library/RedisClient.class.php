<?php


/* redis单例类 */

class RedisClient
{
    private static $_instance = NULL;

    private function __construct()
    {
    }

    /**
     * 获取redis连接，成功返回redis连接，失败返回
     * @return null|Redis Obj
     */
    public static function getInstance()
    {

        if (self::$_instance === NULL) {
            self::$_instance = new Redis();
            if (!self::$_instance->connect(RedisHost, RedisPort)) {
                self::$_instance = NULL;
            }
        }

        return self::$_instance;
    }

    public function __destruct()
    {
        if (self::$_instance) {
            self::$_instance->close();
            self::$_instance = NULL;
        }
    }
}