<?php

namespace App\Http\Controllers;

use App\Models\ApiResponse;
use App\Models\Files\Files;
use App\Models\Files\FilesRepository;
use Illuminate\Http\Request;

class FilesController extends Controller
{
    private $filesRepository;

    function __construct()
    {
        $this->filesRepository = new FilesRepository();
    }

    public function index()
    {
        try {

            return ApiResponse::success($this->filesRepository->getFiles());
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }

    public function show($userId)
    {
        try {

            return ApiResponse::success($this->filesRepository->getFilesByUserId((int)$userId));
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $files = Files::factory($request->toArray());

            if (!empty($files->getErrors())) {
                return ApiResponse::errorValidation($files->getErrors());
            }

            $filesRepository = new FilesRepository($files->toArray());
            $filesRepository->save();
            $fileId = $filesRepository->getQueueableId();
            $path = $files->getPathImage($fileId);
            $files->generateFile($request->get('file'), $path);

            return ApiResponse::success(['id' => $fileId],
                "file save successfully");
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $files = $this->filesRepository->getFileById((int)$id);
            if (empty($files)) {
                return ApiResponse::errorValidation(["the file doesn't exist"]);
            }


            $filesIns = Files::update($request->toArray());
            if (!empty($filesIns->getErrors())) {
                return ApiResponse::errorValidation($filesIns->getErrors());
            }
            $files->updateData($filesIns);


            $path = $filesIns->getPathImage($id);
            $filesIns->generateFile($request->get('file'), $path);

            return ApiResponse::success(['id' => $id],
                "user file successfully");
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }

    }

    public function destroy($id)
    {
        try {
            $files = $this->filesRepository->getFileById((int)$id);

            if (empty($files)) {
                return ApiResponse::errorValidation(["the file doesn't exist"]);
            }
            $files->deleteFile();

            return ApiResponse::success(['id' => $id],
                "the file delete successfully");
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }

    }
}
