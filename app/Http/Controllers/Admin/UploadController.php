<?php

namespace App\Http\Controllers;

use Exception;
use Input;

class UploadController extends Controller
{
    const UPLOAD_KEY = 'file';

    /**
     * 上传文件.
     *
     * @return json
     */
    public function postIndex()
    {
        if(!Input::get('type')) {
            throw new Exception('file type error.', 422);
        }

        if (!Input::hasFile(self::UPLOAD_KEY)) {
            throw new Exception('no file found.', 422);
        }

        $type = Input::get('type');
        $file = Input::file(self::UPLOAD_KEY);
        $mime = $file->getMimeType();

        $ext = $this->checkMime($mime, $type);

        $filesize = $file->getSize();

        $this->checkSize($filesize, $type);

        if (!$ext) {
            throw new Exception('Error file type', 422);
        }

        $originalName = $file->getClientOriginalName();

        $filename = md5_file($file->getRealpath()).'.'.$ext;

        $datedir = date('Ym').'/';
        $dir = config('material.'.$type.'.storage_path').$datedir;

        is_dir($dir) || mkdir($dir, 0755, true);

        if (!file_exists($dir.$filename)) {
            $file->move($dir, $filename);
        }

        $response = [
            'originalName' => $originalName,
            'name' => $originalName,
            'size' => $filesize,
            'type' => ".{$ext}",
            'path' => $datedir.$filename,
            'url' =>  config('material.'.$type.'.prefix').'/'.$datedir.$filename,
            'state' => 'SUCCESS',
        ];

        return json_encode($response);
    }

    /**
     * 检查大小.
     *
     * @param int $size
     * @param string $type 上传文件类型
     *
     * @throws Exception If too big.
     */
    protected function checkSize($size, $type)
    {
        if($size > config('material.'.$type.'.upload_max_size')) {
            throw new Exception('Too big file.', 422);
        }
    }

    /**
     * 检测Mime类型
     *
     * @param string $mime mime类型
     * @param string $type 文件上传类型
     *
     * @return bool
     */
    protected function checkMime($mime, $type)
    {
        $allowTypes = config('material.'.$type.'.allow_types');

        return array_search($mime, $allowTypes);
    }
}
