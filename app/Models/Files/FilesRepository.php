<?php


namespace App\Models\Files;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FilesRepository extends Model
{
    protected $table = 'files';
    protected $fillable = ['user_id', 'file_name', 'extension', 'role', 'url'];

    public function getFileById(int $id)
    {
        $file = $this->find($id);
        if (!empty($file)) {

            return $file;
        }

        return [];
    }

    public function getFiles(): array
    {
        $files = $this->all()->toArray();

        return $files;
    }


    public function getFilesByUserId(int $userId)
    {
        $files = DB::table($this->table)
            ->where('user_id', $userId)->get()->toArray();

        return $files;
    }

    public function deleteFile()
    {

        $this->delete();
    }

    public function updateData(Files $files)
    {
        $this->user_id = $files->getUserId();
        $this->file_name = $files->getFileName();
        $this->extension = $files->getExtension();
        $this->type = $files->getType();
        $this->url = $files->getUrl();
        $this->save();

    }


}