<?php
namespace Models;

class Carts extends \Libs\Model\RedisListModel
{

    public static $key_pattern = "cart:%s"; // cart ID (user_id)

    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $user_id;

    /**
     * @var integer
     */
    public $item;

    /**
     * @var datetime
     */
    public $created;

    /**
     *  Table's alias name
     */
    protected static $alias = 'Carts';

    /**
     *  Default columns for SELECT Query
     */
    protected static $default_columns = ['id', 'user_id', 'item', 'created'];

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id',
            'user_id' => 'user_id',
            'item' => 'item',
            'created' => 'created'
        );
    }
}
