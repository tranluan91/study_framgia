<?php

namespace Libs\Model;

class RedisListModel extends RedisModel
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
     *  insert data, but can't update.
     *  @param  mixed $key
     *  @param  Array  $value
     *  @return Bool
     *
     *  note: paramater "key" is multiple.
     *        case 1:   $key = ["key"=>"123", "value"=>"asdfg"]
     *                  $value = null
     *        case 2:   $key = ["123", "asdfg"]
     *                  $value = null
     *
     *        each pattern are key is '123' and 'value' is 'asdfg'
     */
    public function save($key=NULL, $value = null) {
        if (is_array($key)) {
            if (!empty($key['key'])  && !empty($key['value'])) {
                $key = $key['key'];
                $value = $key["value"];
            } else if (count($key) >= 2) {
                $value = $key[1];
                $key = $key[0];
            } else {
                throw new \Exception("Params is Invalid [RedisListModel->save]");
            }
        }
        if (!$key) throw new \Exception("key is required [RedisListModel->save]");
        if (!$value) throw new \Exception("value is required [RedisListModel->save]");

        return self::$redis->RPUSH(static::key($key), $value);
    }

    /**
     *  save's alias
     *  @see save
     */
    public function create($key=null, $value=null) {
        return $this->save($key, $value);
    }

    /**
    *   TODO:
     *  Find record
     *  @param  String $key
     *  @return Array
     */
    public static function find($options=null) {
        $key = array_has($options, "key");
        $start = array_has($options, "start");
        $range = array_has($options, "range");

       if (!$key) throw new \Exception("key is required [RedisListModel->find]");
       return self::get($key, $start, $range);
   }


    /**
     *  Find Records
     *  @param  String  $key
     *  @param  int     $start=0
     *  @param  int     $range=0
     *  @return Array
     */
    public static function get($key, $start=0, $range=0) {
        $key = static::key($key);
        $length = self::$redis->LLEN($key);

        if ($start < 0) $start = $length + $start;

        if ($range===0) {
            // N番目から最後まで取得
            $end = $length - 1;
        } elseif ($range > 0) {
            // N番目からN+l番目(または最後まで取得する);
            $end = $start + $range - 1;
        } else {
            if ($start + $range >= 0) {
                $end = $start;
                $start = $start + $range + 1;
            } else {
                $end = $start;
                $start = 0;
            }
        }
        \Libs\Debugger::log('List start end', $start . '---' . $end);
        return self::$redis->LRANGE($key, $start, $end);
    }

    /**
     *  Get count of record
     *  @param  String $key
     *  @return Numeric
     */
    public static function count($key=null) {
        if (!$key) throw new \Exception("key is required [RedisListModel->count]");
        return self::$redis->LLEN(static::key($key));
    }

    /**
     *  All Records Delete by one key
     *  @return mixed   Last record
     */
    public function delete() {
        $key = static::$key;
        if (!$key) throw new \Exception("key is required [RedisListModel->delete]");
        return self::$redis->DEL($key);
    }

    /**
     *  Delete Last Records
     *  @param  String  $key
     *  @return bool
     */
    public function pop($key=null) {
        if (!$key) {
            $key = static::$key;
        } else {
            $key = static::key($key);
        }
        if (!$key) throw new \Exception("key is required [RedisListModel->pop]");
        return self::$redis->RPOP($key);
    }


    /**
     *  All Records Delete by any key
     *  @param  String  $key
     *  @return bool
     */
    public function truncate() {
        foreach($this->KEYS(self::key("*")) as $key) {
            $this->DEL($key);
        }
    }
}