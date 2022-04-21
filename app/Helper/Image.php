<?php

namespace App\Helper;


class Image extends AbstractHelper
{

    /**
     * @param $source
     * @return false|int
     */
    private static function colorTransparent($source)
    {
        $color = imagecolorallocate($source, 255, 255, 255);
        imagecolortransparent($source, $color);
        imagefill($source, 0, 0, $color);
        return $color;
    }

    /**
     * 裁剪
     * 左上角(0,0)
     * @param $srcSource
     * @param array $params 500,500,1200,1200 (x1,y1,x2,y2) 坐标以左上角为(0,0)
     * @return false|resource
     */
    public static function thumb($srcSource, array $params)
    {
        if (count($params) === 4) {
            $thumbWidth = floor(abs($params[2] - $params[0]));
            $thumbHeight = floor(abs($params[3] - $params[1]));
            $tempSource = imagecreatetruecolor($thumbWidth, $thumbHeight);
            self::colorTransparent($tempSource);
            imagecopy($tempSource, $srcSource, 0, 0, $params[0], $params[1], $thumbWidth, $thumbHeight);
            return $tempSource;
        }
        return false;
    }

    /**
     * 缩放
     * @param $srcSource
     * @param array $params 100,100 | 100%,100% 支持百分比（urlencode=%25）及固定参数,height可省略
     * @return false|resource
     */
    public static function resize($srcSource, array $params)
    {
        if (isset($params[0])) {
            $imageWidth = imagesx($srcSource);
            $imageHeight = imagesy($srcSource);
            $resizeWidth = floor(
                strpos($params[0], '%') === false ? $params[0]
                    : $imageWidth * 0.01 * substr($params[0], 0, strlen($params[0]) - 1)
            );
            if (!isset($params[1])) {
                $resizeHeight = floor($imageHeight * $resizeWidth / $imageWidth);
            } else {
                $resizeHeight = floor(
                    strpos($params[1], '%') === false ? $params[1]
                        : $imageHeight * 0.01 * substr($params[1], 0, strlen($params[1]) - 1)
                );
            }
            $tempSource = imagecreatetruecolor($resizeWidth, $resizeHeight);
            self::colorTransparent($tempSource);
            imagecopyresized($tempSource, $srcSource, 0, 0, 0, 0, $resizeWidth, $resizeHeight, $imageWidth, $imageHeight);
            return $tempSource;
        }
        return false;
    }

    /**
     * X轴(左右)翻转
     * @param $srcSource
     * @return false|resource
     */
    public static function flipX($srcSource)
    {
        $imageWidth = imagesx($srcSource);
        $imageHeight = imagesy($srcSource);
        $tempSource = imagecreatetruecolor($imageWidth, $imageHeight);
        self::colorTransparent($tempSource);
        for ($x = 0; $x < $imageWidth; $x++) {
            imagecopy($tempSource, $srcSource, $imageWidth - $x - 1, 0, $x, 0, 1, $imageHeight);
        }
        return $tempSource;
    }

    /**
     * Y轴(上下)翻转
     * @param $srcSource
     * @return false|resource
     */
    public static function flipY($srcSource)
    {
        $imageWidth = imagesx($srcSource);
        $imageHeight = imagesy($srcSource);
        $tempSource = imagecreatetruecolor($imageWidth, $imageHeight);
        self::colorTransparent($tempSource);
        for ($y = 0; $y < $imageHeight; $y++) {
            imagecopy($tempSource, $srcSource, 0, $imageHeight - $y - 1, 0, $y, $imageWidth, 1);
        }
        return $tempSource;
    }

    /**
     * 旋转(顺时针)
     * @param $srcSource
     * @param $angle
     * @return false|resource
     */
    public static function rotate($srcSource, $angle)
    {
        $angle = round($angle);
        if ($angle == 0) {
            return false;
        }
        $imageWidth = imagesx($srcSource);
        $imageHeight = imagesy($srcSource);
        $tempSource = imagecreatetruecolor($imageWidth, $imageHeight);
        $color = self::colorTransparent($tempSource);
        imageCopyResized($tempSource, $srcSource, 0, 0, 0, 0, $imageWidth, $imageHeight, $imageWidth, $imageHeight);
        $tempSource = imagerotate($tempSource, $angle, $color);
        return $tempSource;
    }

    /**
     * 灰度化(黑白化)
     * @param $srcSource
     * @return false|resource
     */
    public static function grayscale($srcSource)
    {
        $imageWidth = imagesx($srcSource);
        $imageHeight = imagesy($srcSource);
        $tempSource = imagecreatetruecolor($imageWidth, $imageHeight);
        self::colorTransparent($tempSource);
        for ($y = 0; $y < $imageHeight; $y++) {
            for ($x = 0; $x < $imageWidth; $x++) {
                $gray = (ImageColorAt($srcSource, $x, $y) >> 8) & 0xFF;
                $hex = imagecolorallocate($tempSource, $gray, $gray, $gray);
                imagesetpixel($tempSource, $x, $y, $hex);
            }
        }
        return $tempSource;
    }

    /**
     * 反相
     * @param $srcSource
     * @return false|resource
     */
    public static function reverse($srcSource)
    {
        $imageWidth = imagesx($srcSource);
        $imageHeight = imagesy($srcSource);
        $tempSource = imagecreatetruecolor($imageWidth, $imageHeight);
        self::colorTransparent($tempSource);
        for ($y = 0; $y < $imageHeight; $y++) {
            for ($x = 0; $x < $imageWidth; $x++) {
                $index = imagecolorat($srcSource, $x, $y);
                $color = imagecolorsforindex($srcSource, $index);
                $red = 255 - $color['red'];
                $green = 255 - $color['green'];
                $blue = 255 - $color['blue'];
                $hex = imagecolorallocate($tempSource, $red, $green, $blue);
                imagesetpixel($tempSource, $x, $y, $hex);
            }
        }
        return $tempSource;
    }

    /**
     * 模糊
     * @param $srcSource
     * @param $blur
     * @return false|resource
     */
    public static function blur($srcSource, $blur)
    {
        $blur = floor($blur);
        if ($blur < 1) {
            return false;
        }
        $imageWidth = imagesx($srcSource);
        $imageHeight = imagesy($srcSource);
        $smallestWidth = ceil($imageWidth * pow(0.5, $blur));
        $smallestHeight = ceil($imageHeight * pow(0.5, $blur));
        $prevImage = [null];
        $prevWidth = $imageWidth;
        $prevHeight = $imageHeight;
        $nextWidth = 0;
        $nextHeight = 0;
        for ($i = 0; $i < $blur; $i += 1) {
            $nextWidth = $smallestWidth * pow(2, $i);
            $nextHeight = $smallestHeight * pow(2, $i);
            $prevImage[] = imagecreatetruecolor($nextWidth, $nextHeight);
            imagecopyresized($prevImage[1], $prevImage[0] ?? $srcSource, 0, 0, 0, 0, $nextWidth, $nextHeight, $prevWidth, $prevHeight);
            imagefilter($prevImage[1], IMG_FILTER_GAUSSIAN_BLUR);
            $prevWidth = $nextWidth;
            $prevHeight = $nextHeight;
            $im = array_shift($prevImage);
            if ($im !== null) {
                imagedestroy($im);
            }
        }
        if ($prevImage[0] !== false) {
            $tempSource = imagecreatetruecolor($imageWidth, $imageHeight);
            self::colorTransparent($tempSource);
            imagecopyresized($tempSource, $prevImage[0], 0, 0, 0, 0, $imageWidth, $imageHeight, $nextWidth, $nextHeight);
            imagefilter($tempSource, IMG_FILTER_GAUSSIAN_BLUR);
        }
        return $tempSource;
    }

}