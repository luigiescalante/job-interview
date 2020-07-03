<?php

namespace App\Http\Controllers;

use App\Models\ApiResponse;
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

    }

    public function show($id)
    {

    }

    public function store(Request $request)
    {

    }

    public function update(Request $request, $id)
    {

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
