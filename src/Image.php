<?php
/*
 * This file is part of the deloachtech/utilities package.
 *
 * Copyright (c) DeLoach Tech
 * https://deloachtech.com
 *
 * This source code is protected under international copyright law. All
 * rights reserved and protected by the copyright holders. This file is
 * confidential and only available to authorized individuals with the
 * permission of the copyright holder. If you encounter this file, and do
 * not have permission, please contact the copyright holder and delete
 * this file. Unauthorized copying of this file, via any medium is strictly
 * prohibited.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DeLoachTech\Utilities;


class Image
{
    /**
     * @param string $originalFile
     * @param int $newWidth
     * @param string $targetFile The file name without extension.
     * @param bool $keepOriginal
     * @return bool
     */
    function resize(string $originalFile, int $newWidth, string $targetFile, bool $keepOriginal = true): bool
    {

        //https://stackoverflow.com/questions/13596794/resize-images-with-php-support-png-jpg

        list($width, $height, $type) = getimagesize($originalFile);

        switch ($type) {
            case IMAGETYPE_JPEG:
            case IMAGETYPE_JPEG2000:
                $image_create_func = 'imagecreatefromjpeg';
                $image_save_func = 'imagejpeg';
                $new_image_ext = 'jpg';
                break;

            case IMAGETYPE_PNG:
                $image_create_func = 'imagecreatefrompng';
                $image_save_func = 'imagepng';
                $new_image_ext = 'png';
                break;

            case IMAGETYPE_GIF:
                $image_create_func = 'imagecreatefromgif';
                $image_save_func = 'imagegif';
                $new_image_ext = 'gif';
                break;

            default:
                return false;
        }

        $img = $image_create_func($originalFile);

        $newHeight = ($height / $width) * $newWidth;

        $tmp = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        if (file_exists($targetFile)) {
            unlink($targetFile);
        }

        if(!$keepOriginal){
            unlink($originalFile);
        }

        $image_save_func($tmp, "$targetFile.$new_image_ext");
        return true;
    }

}