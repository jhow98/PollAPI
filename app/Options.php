<?php

namespace Api;
use Api\Poll;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Options extends Model
{
    public $timestamps = false;
    protected $table = 'options';
    protected $fillable = [
        'id', 'description', 'qty', 'poll_id'
    ];

    public function poll()
    {
        return $this->belongsTo('Api\Poll');
    }
}
