<?php

namespace AndreGumieri\LaravelUxid\Database\Eloquent\Concerns;

use Illuminate\Support\Str;

trait HasUxid
{
    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array
     */
    public function uniqueIds()
    {
        return [$this->getKeyName()];
    }

    /**
     * Generate a new UUID for the model.
     *
     * @return string
     */
    public function newUniqueId()
    {
        $base58chars = "123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz";
        $data = random_bytes(16);
        $hex = bin2hex($data);
        // Convert UUID to base10
        $base10 = base_convert($hex, 16, 10);

        // Convert base10 to base58
        $base58 = '';
        while (bccomp($base10, '0') > 0) {
            $digit = bcmod($base10, '58');
            $base58 = $base58chars[$digit] . $base58;
            $base10 = bcdiv(bcsub($base10, $digit), '58');
        }

        return $base58;
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        if (in_array($this->getKeyName(), $this->uniqueIds())) {
            return 'string';
        }

        return $this->keyType;
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        if (in_array($this->getKeyName(), $this->uniqueIds())) {
            return false;
        }

        return $this->incrementing;
    }

    public function uniqueIdEntropy(): int
    {
        return 16;
    }

}