<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Http\Console;

use Ebcms\Config;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

class Upload extends Common
{

    public function post(
        ServerRequestInterface $request,
        Config $config
    ) {
        foreach ($request->getUploadedFiles() as $file) {
            /**
             * @var UploadedFileInterface $file
             */
            $ext = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
            $type = $file->getClientMediaType();

            if (!in_array($ext, explode(',', $config->get('upload.exts@ebcms.ucenter', 'jpg,png,gif')))) {
                return $this->failure('不支持的上传类型！');
            }
            if (!in_array($type, explode(',', $config->get('upload.types@ebcms.ucenter', 'image/gif,image/jpeg,image/jpg,image/pjpeg,image/x-png,image/png')))) {
                return $this->failure('不支持的上传类型！');
            }

            $filename = uniqid();
            $path = './uploads/' . date('Y/m-d');
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }
            $file->moveTo($path . '/' . $filename . '.' . $ext);

            $script_name = '/' . implode('/', array_filter(explode('/', $_SERVER['SCRIPT_NAME'])));
            $root = strlen(dirname($script_name)) > 1 ? dirname($script_name) : '';

            return $this->success('上传成功！', '', [
                'src' => $root . substr($path, 1) . '/' . $filename . '.' . $ext,
            ]);
        }
    }
}
