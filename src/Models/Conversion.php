<?php

namespace A1ex7\Cpa\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Config;

/**
 * @property string conversion_id
 * @property string event
 * @property string request
 * @property string response
 */
class Conversion extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'request'  => 'json',
        'response' => 'json',
    ];

    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = Config::get('cpa.conversions_table');
    }


    /**
     * @return BelongsTo
     */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class, 'user_lead_id');
    }

    /**
     * @param Lead|null $lead
     * @return Conversion
     */
    public function setLead(Lead $lead = null): Conversion
    {
        $this->lead()->associate($lead);
        return $this;
    }

    /**
     * @return bool
     */
    public function isExists(): bool
    {
        return static::query()
            ->where('conversion_id', $this->conversion_id)
            ->where('event', $this->event)
            ->exists();
    }

    public function getId(): string
    {
        return $this->conversion_id;
    }

    public function getUser(): int
    {
        return $this->lead->user_id;
    }

    public function getConfig(): array
    {
        return $this->lead->config;
    }

    public function getProduct(): ?string
    {
        return $this->lead->product;
    }
}
