<?php
/**
 *  RedisのHASH型用のクラス
 */

namespace Libs\Model;

class RedisHashModel extends RedisModel
{
    public static $key_pattern = "";
    protected static $key;

    /**
     *  Get the table's key
     *  @param  mixed [$arg1],[$arg2],...
     *  @return String
     */
    public static function key() {
        $args = func_get_args();
        if (is_array($args[0])) $args = $args[0];
        array_unshift($args, static::$key_pattern);
        self::$key = call_user_func_array('sprintf', $args);
        return self::$key;
    }


    /**
     *  insert or update records
     *  @param  String $key
     *  @param  Array  $value
     *  @return Bool
     */
    public function save($key=NULL, $value = null) {
        if (is_array($key) && !$value) {
            if (!empty($key['key'])  && !empty($key['value'])) {
                if (is_array($key['value'])) {
                    $value = $key["value"];
                    $key = $key['key'];
                }
            } else {
                throw new \Exception("Params is Invalid [RedisListModel->save]");
            }
        }
        if (!$key) throw new \Exception("key is required [RedisHashModel->save]");
        if (!$value) throw new \Exception("value is required [RedisHashModel->save]");

        $expire = array_has($value, "expire");
        if (is_numeric($expire)) {
            return self::$redis->HMSET(static::key($key), $value) &&
                   self::$redis->EXPIRE(static::key($key), $expire);
        } else {
            return self::$redis->HMSET(static::key($key), $value);
        }
    }

    public function create($key=null, $value=null) {
        if (!$key) throw new \Exception("key is required [RedisHashModel->save]");
        if (!$value) throw new \Exception("value is required [RedisHashModel->save]");
        if ($this->count($key)) throw new \Exception("key is exists[RedisHashModel->create]");

        return $this->save($key, $value);
    }

    /**
     *  Find record
     *  @param  String $key
     *  @return Array
     */
    public static function find($key=null) {
        if (!$key) throw new \Exception("key is required [RedisHashModel->find]");
        return self::$redis->HGETALL(static::key($key));
    }

    /**
     *  Get count of record
     *  @param  String $key
     *  @return Numeric
     */
    public static function count($key=null) {
        if (!$key) throw new \Exception("key is required [RedisHashModel->count]");
        return self::$redis->EXISTS(static::key($key));
    }

    public function delete() {
        return self::$redis->DEL(static::$key);
    }

    /**
     *  All Records Delete by any key
     *  @param  String  $key
     *  @return bool
     */
    public function truncate() {
        foreach($this->KEYS(self::key("*", "*")) as $key) {
            $this->DEL($key);
        }
    }

    /**
     *  All Record get
     *  @return Array
     */
    public function findAll() {
        $result = [];
        foreach($this->KEYS(self::key("*")) as $key) {
            $result[$key] = self::$redis->HGETALL($key);
        }
        return $result;
    }
}