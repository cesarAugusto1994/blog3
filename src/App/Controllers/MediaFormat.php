<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 13/09/16
 * Time: 08:38
 */

namespace App\Controllers;


trait MediaFormat
{
    /**
     * @param string $media
     * @return string
     */
    public function getFormat($media)
    {
        return substr($media['name'], 0, -4);
    }

    /**
     * @param $media
     * @return int
     */
    public function getFormatTipo($media)
    {
        var_dump($media);

        switch ($media) {
            case 'application/pdf':
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' :
                return 1;
                break;
            case 'audio/mpeg':
                return 2;
                break;
            case 'image/jpeg':
            case 'image/gif' :
            case 'image/png' :
                return 3;
                break;
            default:
                return 1;
                break;
        }
    }
}