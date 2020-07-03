<?php


namespace App\Models\Files;

use Illuminate\Support\Facades\Validator;

class Files
{
    private $id;
    private $user_id;
    private $file_name;
    private $extension;
    private $type;
    private $url;

    private $validateRules = [];
    private $errors = [];

    function __construct()
    {
        $this->validateRules = [
            'user_id'   => 'required',
            'file_name' => 'required|max:50',
            'extension' => 'required|in:pdf,jpg,jpeg',
            'type'      => 'required|in:picture,cv',
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
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->file_name;
    }

    /**
     * @param mixed $file_name
     */
    public function setFileName($file_name): void
    {
        $this->file_name = $file_name;
    }

    /**
     * @return mixed
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param mixed $extension
     */
    public function setExtension($extension): void
    {
        $this->extension = $extension;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
    }

    public static function factory(array $parameters): Files
    {
        $files = new self;
        $parameters["extension"]
            = $files->getImageBase64Extension($parameters['file']);

        $parameters["type"] = ($parameters["extension"] == 'pdf') ? 'cv'
            : 'picture';
        $validate = $files->validateFields($parameters);
        if (!$validate->fails()) {
            $files->setUserId($parameters['user_id']);
            $files->setFileName($parameters['file_name']);
            $files->setExtension($parameters['extension']);
            $files->setType($parameters['type']);
            $path = $files->generatePath();
            $files->setUrl($path);
        } else {
            $errorList = $validate->errors()->toArray();
            foreach ($errorList as $error => $value) {
                array_push($files->errors, $value[0]);
            }
        }

        return $files;
    }

    public static function update(array $parameters): Files
    {
        $files = new self;
        $parameters["extension"]
            = $files->getImageBase64Extension($parameters['file']);

        $parameters["type"] = ($parameters["extension"] == 'pdf') ? 'cv'
            : 'picture';
        $validate = $files->validateFields($parameters);
        if (!$validate->fails()) {
            $files->setUserId($parameters['user_id']);
            $files->setFileName($parameters['file_name']);
            $files->setExtension($parameters['extension']);
            $files->setType($parameters['type']);
            $path = $files->generatePath();
            $files->setUrl($path);
        } else {
            $errorList = $validate->errors()->toArray();
            foreach ($errorList as $error => $value) {
                array_push($files->errors, $value[0]);
            }
        }

        return $files;
    }

    public function generateFile($base64File, $path)
    {
        $base64Image = explode(',', $base64File);
        $image = base64_decode($base64Image[1]);
        file_put_contents($path, $image);
    }

    public function getPathImage()
    {
        $path = $this->getType().'/'.$this->getFileName().'.'
            .$this->getExtension();

        return public_path($path);

    }

    private function getImageBase64Extension($base64)
    {
        $fileExtension = explode(';base64', $base64);
        $fileExtension = explode('/', $fileExtension[0]);

        return $fileExtension[1];
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

    private function generatePath()
    {
        return env('APP_URL').$this->getType().'/'.$this->getFileName()
            .'.'.$this->getExtension();

    }


}