<?php
    /**
     *  My functions
     *
     *  IF you want to use global function in this system,
     *  you write it on this.
     */
    define('DATETIME_NULL', '1970-1-1 00:00:00');

    function pr($args) {
        echo "<pre>";
        var_dump($args);
         echo "</pre>";
    }

    /**
     * safty pickup value from array by using key.
     * @param array $array
     * @param strin $key
     */
    function array_has($array, $key, $default=null){
        if (!is_string($key) || !is_array($array)) return $default;
        if (!array_key_exists($key, $array)) return $default;
        if ($array[$key] === '0') return (String)'0';
        return $array[$key];
    }
?>
