<?php
/**
 * @package  ProfileBearPlugin
 */
namespace Inc\Classes;

class ManageImg
{
    const PNG = 'png';
    const JPG = 'jpg';
    const JPEG = 'jpeg';

    public function ImgOptimize($pathToImg, $quality, $format)
    {
        $image = '';
        switch ($format) {
            case self::PNG:
                $image = @imagecreatefrompng($pathToImg);
                break;
            case self::JPG:
                $image = @imagecreatefromjpeg($pathToImg);
                break;
            case self::JPEG:
                $image = @imagecreatefromjpeg($pathToImg);
                break;
        }
        if (!$image) {
			LogsProfelebear::getInstance()->setLogs('Wrong img ' . $pathToImg);
            return;
        }
        $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
        imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
        imagealphablending($bg, TRUE);
        imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
        imagedestroy($image);
        imagejpeg($bg, $pathToImg, $quality);
        imagedestroy($bg);
        if (file_exists($pathToImg)){
            return $this->getSizeImg($pathToImg);
        }else{
            return false;
        }
    }

    public function getSizeImg($path){
        $fp = fopen($path, "r");
        $fstat = fstat($fp)['size'];
        fclose($fp);
        return $fstat;
    }

}