<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 03/09/16
 * Time: 10:22
 */

namespace App\Controllers;


class UploadImages
{
    const ORIGIN_POTS = 'post';
    const ORIGIN_CONFIG = 'config';
    const ORIGIN_AVATAR = 'avatar';
    const ORIGIN_MENU = 'menu';
    const ORIGIN_COLECAO = 'colecao';
    const ORIGIN_ALBUM = 'album';
    
    /**
     * @var string
     */
    private $origin;
    
    /**
     * @var string
     */
    private $image;
    
    /**
     * @param $image
     * @param $origin
     * @param null $lastImage
     * @return mixed
     * @throws \Exception
     */
    public function upload($image, $origin, $lastImage = null)
    {
        $this->origin = $origin;

        $this->generateNameImage(substr(is_array($image['name']) ? current($image['name']) : $image['name'], -4));

        if ($lastImage) {
            $this->removeImage($this->getDirectoryToUpload(), $lastImage);
        }

        move_uploaded_file(is_array($image['tmp_name']) ? current($image['tmp_name']) : $image['tmp_name'], $this->getDirectoryToUpload().$this->getNameImage());

        return $this->getNameImage();
    }
    
    /**
     * @param $extension
     */
    public function generateNameImage($extension)
    {
        $this->image = md5(microtime()).'.'.$extension;
    }
    
    /**
     * @return mixed
     */
    public function getNameImage()
    {
        return $this->image;
    }
    
    /**
     * @param $directory
     * @param $nameImage
     * @return bool
     */
    public function removeImage($directory, $nameImage)
    {
        return unlink($directory.''.$nameImage);
    }
    
    /**
     * @return string
     * @throws \Exception
     */
    public function getDirectoryToUpload()
    {
        switch ($this->origin) {
            case 'post':
                return __DIR__ . '/../../../web/assets/blog/img/posts/';
                break;
            case 'config':
                return __DIR__ . '/../../../web/assets/blog/img/config/';
                break;
            case 'avatar':
                return __DIR__ . '/../../../web/assets/blog/img/avatar/';
                break;
            case 'menu':
                return __DIR__ . '/../../../web/assets/blog/img/menu/';
                break;
            case 'colecao':
                return __DIR__ . '/../../../web/assets/blog/img/colecoes/';
                break;
            case self::ORIGIN_ALBUM :
                return __DIR__ . '/../../../web/assets/blog/img/albuns/';
                break;
            default :
                throw new \Exception('Erro ao salvar imagem.');
                break;
        }
        
    }

}