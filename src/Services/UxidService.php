<?php

namespace AndreGumieri\LaravelUxid\Services;

use Hidehalo\Nanoid\Client;

class UxidService
{
    public static function uxid($entropy=16, $prefix=null): string
    {
        $client = new Client();
        $base58chars = "123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz";
        $base58 = $client->formattedId($base58chars, $entropy);

        if($prefix) {
            $base58 = sprintf('%s_%s', $prefix, $base58);
        }

        return $base58;
    }

    public static function prefixGenerator($table): string
    {
        $words = explode('_', $table);
        $prefix = '';
        if (count($words) == 1) {
            $consonants = implode('', array_filter(str_split(substr($words[0], 1)), function ($char) {
                return preg_match('/[^aeiou]/i', $char);
            }));
            $prefix = $words[0][0] . substr($consonants, 0, 2);
        } elseif (count($words) == 2) {
            foreach ($words as $word) {
                $consonants = implode('', array_filter(str_split(substr($word, 1)), function ($char) {
                    return preg_match('/[^aeiou]/i', $char);
                }));
                $prefix .= $word[0] . substr($consonants, 0, 1);
            }
        } else {
            foreach ($words as $word) {
                $prefix .= $word[0];
            }
        }

        return $prefix;
    }
}