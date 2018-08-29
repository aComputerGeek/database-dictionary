<?php

namespace Jw\Database\Dictionary\Models;

use Illuminate\Database\Eloquent\Model;

class DatabaseDictionary extends Model
{
    public $table = 'database_dictionary';

    protected $guarded = [];

    public function table_data()
    {
        return $this->belongsTo(Table::class, 'title', 'TABLE_NAME');
    }

    public function child()
    {
        return $this->hasMany(self::class, 'father_id');
    }
}