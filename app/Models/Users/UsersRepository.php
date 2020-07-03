<?php


namespace App\Models\Users;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersRepository extends Model
{
    protected $table = 'users';
    protected $fillable
        = [
            'name',
            'last_name',
            'email',
            'user_name',
            'password',
            'role',
            'status',
        ];
    CONST ADMIN_ROLE = 'admin';

    public function getUserById(int $id)
    {
        $user = $this->find($id);
        if (!empty($user)) {
            unset($user['password']);

            return $user;
        }

        return [];
    }

    public function getUsers(): array
    {
        $users = $this->all()->toArray();
        foreach ($users as $index => $data) {
            unset($users[$index]['password']);
        }

        return $users;
    }

    public function delete()
    {
        $this->status = 0;
        $this->save();
    }

    public function updateData(Users $users)
    {
        $this->name = $users->getName();
        $this->last_name = $users->getLastName();
        $this->email = $users->getEmail();
        $this->user_name = $users->getUserName();
        $this->role = $users->getRole();
        $this->save();

    }

    public function login($user, $password)
    {
        $loginUser = DB::table($this->table)
            ->where('user_name', $user)
            ->where('role', self::ADMIN_ROLE)
            ->where('status', 1)
            ->get()->first();
        if (!empty($loginUser)) {
            if (Hash::check($password, $loginUser->password)) {
                return $loginUser;
            }
        }

        return false;

    }

}