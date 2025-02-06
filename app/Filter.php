<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    public function searchfilters()
    {
        return $this->hasMany(SearchFilter::class);
    }
}
