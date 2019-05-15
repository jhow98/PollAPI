<?php

namespace Api;

use Illuminate\Database\Eloquent\Model;
use Api\Options;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poll extends Model
{
    public $timestamps = false;
    protected $table = 'poll';
    protected $fillable = [
        'id', 'views', 'description'
    ];

    public function options()
    {
        return $this->hasMany('Api\Options');
    }
}