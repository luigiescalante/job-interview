<?php


namespace App\Models\Files;


use Illuminate\Database\Eloquent\Model;

class FilesRepository extends Model
{
    protected $table = 'files';
    protected $fillable = ['user_id', 'file_name', 'extension', 'role'];

    public function getFileById(int $id)
    {
        $file = $this->find($id);
        if (!empty($file)) {

            return $file;
        }

        return [];
    }

    public function getFilesByUser(int $userId): array
    {
        $users = $this->all()->toArray();
        foreach ($users as $index => $data) {
            unset($users[$index]['password']);
        }

        return $users;
    }

    public function deleteFile()
    {

        $this->delete();
    }
}