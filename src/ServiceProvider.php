<?php

namespace AndreGumieri\LaravelUxid;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ForeignIdColumnDefinition;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        Blueprint::macro('uxid', function ($column = 'id') {
            $this->addColumn('string', $column, ['length' => 255])->primary();
        });

        Blueprint::macro('foreignUxidFor', function ($model, $column = null) {
            if (is_string($model)) {
                $model = new $model;
            }

            $column = $column ?: $model->getForeignKey();

            return $this->addColumnDefinition(new ForeignIdColumnDefinition($this, [
                'type' => 'string',
                'name' => $column,
                'length' => 255
            ]));
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/uxid.php', 'uxid'
        );
    }
}