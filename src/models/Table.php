<?php

namespace Jw\Database\Dictionary\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class Table extends Model
{
    public $table = 'information_schema.TABLES';

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('TABLE_SCHEMA', function (Builder $builder) {
            $builder->where('TABLE_SCHEMA', env('DB_DATABASE'));
        });
    }

}