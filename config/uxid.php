<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Char List
    |--------------------------------------------------------------------------
    |
    | List of characters to use when generating UXIDs.
    |
    */
    'char_list' => env('UXID_CHAR_LIST', '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'),


    /*
    |--------------------------------------------------------------------------
    | Entropy
    |--------------------------------------------------------------------------
    |
    | The entropy (in bytes) to use when generating UXIDs.
    |
    */
    'entropy' => env('UXID_ENTROPY', 16),
];