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
        switch ($media) {
            case 'application/pdf':
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' :
                return 3;
                break;
            case 'audio/mpeg':
            case 'audio/mp3':
                return 1;
                break;
            case 'image/jpeg':
            case 'image/jpg':
            case 'image/gif' :
            case 'image/png' :
                return 2;
                break;
            default:
                return 1;
                break;
        }
    }
}