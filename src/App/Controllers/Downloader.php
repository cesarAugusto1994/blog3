<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 13/09/16
 * Time: 10:34
 */

namespace App\Controllers;

trait Downloader
{
    public function downloadFile($file)
    {
        //set_time_limit(0);

        $path = '/assets/blog/musicas/';

        $filePath = $path . $file;

        if (!file_exists($filePath)) {
            throw new \Exception('Erro no download.');
        }

        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($file));
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Expires: 0');

        return readfile($file);
    }
}