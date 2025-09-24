<?php

namespace AndreGumieri\LaravelUxid\Services;

use Hidehalo\Nanoid\Client;
use Illuminate\Support\Str;

class UxidService
{
    /**
     * Generates a unique identifier using base58 encoding.
     *
     * @param int $entropy The number of random bytes to use for entropy (optional, default is 16).
     * @param string|null $prefix The optional prefix to be added to the identifier (default is null).
     * @param string|null $charList The optional character list to use for generating the ID (default is null, which uses all alphabet + numbers).
     * @return string The generated unique identifier.
     */
    public static function uxid($entropy=16, $prefix=null, $charList=null): string
    {
        $client = new Client();
        $base58chars = $charList ?? "0123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz";
        $base58 = $client->formattedId($base58chars, $entropy);

        if($prefix) {
            $base58 = sprintf('%s_%s', $prefix, $base58);
        }

        return $base58;
    }


    /**
     * Generates a prefix based on a given table name.
     *
     * @param string $table The table name
     * @return string The generated prefix
     */
    public static function prefixGenerator($table, bool $asSingular = true): string
    {
        $words = explode('_', $table);
        $prefix = '';

        if ($asSingular) {
            $words[count($words) - 1] = Str::singular($words[count($words) - 1]);
        }


        if (strlen($table) <= 3){
            $prefix = $table;
        } else if (count($words) == 1) {
            $prefix = [$words[0][0]];

            // If last letter is a consoant, add to last prefix
            $last = substr($words[0], -1);
            if (preg_match("/[^aeiou]/i", $last)) {
                $prefix[2] = $last;
            }



            $consonants = '';
            $vowels = '';
            for($i = 1 ; $i<strlen($words[0]);$i++){
                if (preg_match("/[^aeiou]/i", $words[0][$i])){
                    $consonants .= $words[0][$i];
                } else {
                    $vowels .= $words[0][$i];
                }
            }

            $index = 1;
            while(count($prefix) < 3) {
                if(!empty($consonants)) {
                    $prefix[$index] = $consonants[0];
                    $consonants = substr($consonants, 1);
                    $index++;
                } else {
                    $prefix[$index] = $vowels[0];
                    $vowels = substr($vowels, 1);
                    $index++;
                }
            }

            ksort($prefix);
            $prefix = implode('', $prefix);
        } else {
            foreach ($words as $word) {
                $prefix .= $word[0];
                if(!empty($word[1])){
                    $consonants = '';
                    $vowels = '';
                    for($i = 1 ; $i<strlen($word);$i++){
                        if (preg_match("/[^aeiou]/i", $word[$i])){
                            $consonants .= $word[$i];
                        }else{
                            $vowels .= $word[$i];
                        }
                        if (!empty($consonants)){
                            break;
                        }
                    }

                    if (!empty($consonants)){
                        $prefix .= $consonants;
                    } else if (!empty($vowels)){
                        $prefix .= $vowels[0];
                    }
                }
                $prefix .= '_';
            }

            $prefix = substr($prefix, 0, -1);
        }
        return $prefix;
    }
}