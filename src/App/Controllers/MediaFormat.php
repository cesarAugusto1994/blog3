<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 13/09/16
 * Time: 08:38
 */

namespace App\Controllers;


class MediaFormat
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
    public static function getFormatTipo($media)
    {
        switch ($media) {
            case 'application/pdf':
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' :
            case 'application/vnd.openxmlformats-officedocument.presentationml.template' :
            case 'application/vnd.openxmlformats-officedocument.presentationml.slideshow' :
            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation' :
            case 'application/vnd.ms-powerpointtd' :
            case 'application/msword':
            case 'text/plain':
                return 3;
            case 'audio/mpeg':
            case 'audio/mp3':
                return 1;
                break;
            case 'image/jpeg':
            case 'image/jpg':
            case 'image/gif' :
            case 'image/png' :
                return 2;
            case 'audio/x-midi' :
            case 'video/mpeg' :
            case 'application/ogg' :
            case 'application/x-tar' :
            case 'audio/x-wav' :
            default:
                return 5;
        }
    }
}