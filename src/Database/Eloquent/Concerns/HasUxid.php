<?php

namespace AndreGumieri\LaravelUxid\Database\Eloquent\Concerns;

use AndreGumieri\LaravelUxid\Services\UxidService;

trait HasUxid
{
    /**
     * Initialize the trait.
     *
     * @return void
     */
    public function initializeHasUxid()
    {
        $this->usesUniqueIds = true;
    }

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
        return UxidService::uxid($this->uniqueIdEntropy(), $this->uniqueIdPrefix(), $this->uniqueIdCharList());
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

    /**
     * Get the entropy of the unique ID.
     *
     * @return int The entropy value.
     */
    public function uniqueIdEntropy(): int
    {
        return config('uxid.entropy');
    }

    /**
     * Returns the unique ID prefix for the given table.
     *
     * @return string|null The unique ID prefix for the table, or null if it fails to generate the prefix
     */
    public function uniqueIdPrefix(): ?string
    {
        $table = $this->getTable();
        return UxidService::prefixGenerator($table);
    }

    /**
     * Returns the character list used for generating the unique ID.
     *
     * @return string|null The character list used for generating the unique ID, or null to use the default character set.
     */
    public function uniqueIdCharList(): ?string
    {
        return config('uxid.char_list');
    }

}