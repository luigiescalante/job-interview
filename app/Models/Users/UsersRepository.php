<?php


namespace App\Models\Users;


use Illuminate\Database\Eloquent\Model;

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

}