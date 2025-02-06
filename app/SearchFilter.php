<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SearchFilter extends Model
{
    
    public function filters()
    {
        return $this->belongsTo(Filter::class);
    }
}
