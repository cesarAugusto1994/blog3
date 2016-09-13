<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 03/09/16
 * Time: 10:22
 */

namespace App\Controllers;


trait UploadImages
{
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

        $this->generateNameImage(substr($image['name'], -4));

        if ($lastImage) {
            $this->removeImage($this->getDirectoryToUpload(), $lastImage);
        }

        move_uploaded_file($image['tmp_name'], $this->getDirectoryToUpload().$this->getNameImage());

        return $this->getNameImage();
    }
    
    /**
     * @param $extension
     */
    public function generateNameImage($extension)
    {
        $this->image = md5(microtime()).$extension;
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
        if ($this->origin == 'post') {
            return __DIR__.'/../../../web/assets/blog/img/posts/';
        } elseif ($this->origin == 'config') {
            return __DIR__.'/../../../web/assets/blog/img/config/';
        }
        throw new \Exception('Erro ao salvar imagem.');
    }

}