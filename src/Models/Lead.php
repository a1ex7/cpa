<?php

namespace A1ex7\Cpa\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

/**
 * @property string source
 */
class Lead extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    protected $fillable = ['user_id', 'source', 'config', 'product', 'last_cookie_at'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'last_cookie_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'config' => 'json',
    ];

    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = Config::get('cpa.user_leads_table');
    }
}
