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

class Strings
{

    /**
     * Appends a link with value(s). The existing link query (if any) is used
     * to determine the leading appending character (? or &). (The leading ? or &
     * is therefore stripped from the value provided.)
     * @param string $link
     * @param string $value
     * @return string
     */
    public static function appendLink(string $link, string $value): string
    {
        $value  = ltrim($value,'?&');

        if(strpos($link,'?')>0){
            return $link.'&'.$value;
        }else{
            return $link.'&'.$value;
        }
    }


    public static function hyphenate($str, $charCont): string
    {
        return implode("-", str_split($str, $charCont));
    }


    public static function generateKey(int $length = 64): string
    {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces [] = $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }


    public static function addQueryToUrl(string $url, string $key, string $value): string
    {
        $query = parse_url($url, PHP_URL_QUERY);
        if ($query) {
            $url .= "&{$key}={$value}";
        } else {
            $url .= "?{$key}={$value}";
        }
        return $url;
    }



    public static function formatPhoneNumberForDatabase(string $number): string
    {
        $res = preg_replace("/[^0-9]/", "", $number);
        return (strpos($number, '+') === 0 ? '+' : '') . $res;
    }

}