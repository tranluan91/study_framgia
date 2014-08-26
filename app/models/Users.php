<?php


use Phalcon\Mvc\Model\Validator\Email as Email;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Security;

class Users extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $fbid;

    /**
     *
     * @var string
     */
    public $username;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $display_name;

    /**
     *
     * @var string
     */
    public $created;

    /**
     *
     * @var string
     */
    public $updated;

    /**
     * Validations and business logic
     */
    public function validation()
    {

        $this->validate(new Email([
                'field' => 'email',
                'required' => true,
            ])
        );

        $this->validate(new Uniqueness([
                'field' => 'email',
                'message' => 'The email is already registered',
            ])
        );

        $this->validate(new Uniqueness([
                'field' => 'username',
                'message' => 'The username is already registered',
            ])
        );

        if ($this->username != $this->email) {
            $this->validate(new UsernameValidator(['field' => 'username']));
        }

        if ($this->validationHasFailed() == true) {
            return false;
        }
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id',
            'fbid' => 'fbid',
            'username' => 'username',
            'password' => 'password',
            'email' => 'email',
            'display_name' => 'display_name',
            'created' => 'created',
            'updated' => 'updated',
        );
    }

    /**
     * @return array Save Attributes name
     */
    public function getSaveAttributesName()
    {
        return ['username', 'email', 'display_name'];
    }

    /**
     * Find by email or username
     * @param string $key
     * @return Users|null
     */
    public static function findByKey($key)
    {
        $user = self::findFirstByEmail($key);
        if (!$user) {
            $user = self::findFirstByUsername($key);
        }

        return $user;
    }

    /**
     * Validate password
     * @param string $raw_pass
     * @return bool
     */
    public function validatePassword($raw_pass)
    {
        $security = new Security();

        return $security->checkHash($raw_pass, $this->password);
    }

    /**
     * If user has display_name, return it. Otherwise, return username
     * Also add class to change color base on role
     * @return string Display Name
     */
    public function getUserDisplayName()
    {
        $name = $this->display_name ? $this->display_name : $this->username;
        return '<span class="text-' . $this->getClassBaseOnRole() . '">' . $name . '</span>';
    }
}
