<?php

namespace App\Models;

use Database\Factories\StateFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $country_id
 * @property-read Country $country
 * @method static State create(array $attributes = [])
 */
class State extends Model
{
    /** @use HasFactory<StateFactory> */
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'code',
        'country_id',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
