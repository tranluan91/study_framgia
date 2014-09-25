<?php
namespace Libs\Model;

class RedisModel extends \Phalcon\Mvc\Model
{
    protected static $redis = null;
    protected $di;

    public function initialize() {
        $config = [];      //FIXME
        self::$redis = new \Redis();

        $redis = $this->getDI()->get("redis");
        if (empty($redis))  throw new \Exception("Missing redis setting.");


        $is_connected = self::$redis->connect(
            $redis['host'], $redis['port']
        );

        //Switch DB
        if (!empty($redis['database_number'])) {
            self::$redis->select($redis['database_number']);
        }

        if (!$is_connected) {
            throw new \Exception(
                "Failed to connect to redis[RedisModel->initialize](" .
                $redis['host'] . ":" .
                $redis['port'] . ")"
            );
        }

        return true;
    }

    function close(){
        self::$redis->close();
    }

    public function __call($method, $arguments=null)
    {
        if (method_exists(self::$redis, $method ))
        {
            //self::$redis->{$method}( $arguments )
            return call_user_func_array(array(self::$redis, $method), $arguments );
        } else {
            throw new \Exception(
                "Failed to connect to redis[RedisModel->initialize] (function name is " .
                $method . ")"
            );
        }
    }

    public function multi($commands) {
        self::$redis->multi();
        foreach($commands as $command) {
            $method = array_shift($command);
            call_user_func_array( array( self::$redis, $method ), $command);
        }
        self::$redis->exec();
    }
}