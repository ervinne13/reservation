<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class FilesController extends Controller {

    public function upload() {
        // <editor-fold defaultstate="collapsed" desc="Validation">
        $input = Input::all();
        $rules = array(
            'file' => 'image|max:3000',
        );

        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {
            return Response::make($validation->errors->first(), 400);
        }
        // </editor-fold>

        $file = Input::file('file');

        $generatedFilename = "";

        if ($file) {
            $extension         = $this->getFileExtension($file->getClientOriginalName());
            $generatedFilename = $this->generateFileName($extension);
//            $fileFullPath      = public_path() . '/uploads/' . $generatedFilename;

//            if (File::exists($fileFullPath)) {                
//                //wait a bit then re generate file name
//                sleep(1);    //  1 second
//                $generatedFilename = $this->generateFileName($extension);
//            }

            $file->move(public_path() . '/uploads/', $generatedFilename);
        } else {
            return response("File invalid or no file uploaded", 500);
        }

        return $generatedFilename;
    }

    public function remove(Request $request) {
        try {
            File::delete(public_path() . '/uploads/' . $request->file);
            return "SUCCESS";
        } catch (Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    private function getFileExtension($fileName) {
        $splittedFileName = explode(".", $fileName);
        return $splittedFileName[count($splittedFileName) - 1];
    }

    private function generateFileName($extension) {
        $fileName = date('Y_m_d_His') . "_" . microtime();
        return "{$fileName}.{$extension}";
    }

}
