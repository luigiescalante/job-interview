<?php


namespace App\Models\Users;

use Illuminate\Support\Facades\Validator;


class Users
{
    private $id;
    private $name;
    private $last_name;
    private $email;
    private $user_name;
    private $password;
    private $role;
    private $status;
    private $validateRules = [];

    private $errors = [];

    CONST STATUS_DEFAULT = 1;

    function __construct()
    {
        $this->status = self::STATUS_DEFAULT;
        $this->validateRules = [
            'name'      => 'required|max:80',
            'last_name' => 'required|max:80',
            'email'     => 'required|email:rfc,dns|max:50',
            'user_name' => 'required|max:6',
            'password'  => 'required',
            'role'      => 'required|in:admin,employee',
        ];
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = trim(strtolower($name));
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name): void
    {
        $this->last_name = trim(strtolower($last_name));
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = trim(strtolower($email));
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * @param mixed $user_name
     */
    public function setUserName($user_name): void
    {
        $this->user_name = trim(strtolower($user_name));
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = bcrypt($password);
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role): void
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }


    public static function factory(array $parameters): Users
    {
        $user = new self;
        $validate = $user->validateFields($parameters);
        if (!$validate->fails()) {
            $user->setName($parameters['name']);
            $user->setLastName($parameters['last_name']);
            $user->setEmail($parameters['email']);
            $user->setUserName($parameters['user_name']);
            $user->setPassword($parameters['password']);
            $user->setRole($parameters['role']);
        } else {
            $errorList = $validate->errors()->toArray();
            foreach ($errorList as $error => $value) {
                array_push($user->errors, $value[0]);
            }
        }

        return $user;
    }

    public static function update(array $parameters): Users
    {
        $user = new self;
        unset($user->validateRules['password']);
        $validate = $user->validateFields($parameters);
        if (!$validate->fails()) {
            $user->setName($parameters['name']);
            $user->setLastName($parameters['last_name']);
            $user->setEmail($parameters['email']);
            $user->setUserName($parameters['user_name']);
            $user->setPassword($parameters['password']);
            $user->setRole($parameters['role']);
        } else {
            $errorList = $validate->errors()->toArray();
            foreach ($errorList as $error => $value) {
                array_push($user->errors, $value[0]);
            }
        }

        return $user;
    }

    private function validateFields(array $parameters)
    {

        $validate = Validator::make($parameters, $this->validateRules);

        return $validate;
    }

    public function toArray(): array
    {
        return get_object_vars($this);

    }
}