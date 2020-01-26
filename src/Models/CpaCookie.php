<?php

namespace A1ex7\Cpa\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class CpaCookie extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    protected $casts = [
        'payload' => 'array'
    ];

    protected $fillable = ['id', 'payload'];

    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = Config::get('cpa.cpa_cookies_table');
    }
}
