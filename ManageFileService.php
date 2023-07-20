<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\File;

trait ManageFileService
{
    function uploadFile( $request, $fileName, $foldarName)
    {
        if ($request->hasfile($fileName)&&$request->$fileName!==Null) {
            $path = $request->file($fileName)->store($foldarName, 'public');
            return $path;
        } else {
            return null;
        }
    }

    function deleteFile($path)
    {
        if (file_exists(storage_path($path))) {
            File::delete(storage_path($path));
        }
    }

    function getFile($path)
    {
        try {
            return response()->file(storage_path($path));
        } catch (Exception $e) {
            return $e;
        }
    }
}
