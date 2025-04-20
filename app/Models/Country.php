<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property State[] $states
 * @method static Country create(array $attributes = [])
 * @method static Builder|Country where(string $column, string $value)
 */
class Country extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'code',
    ];

    public function states(): HasMany
    {
        return $this->hasMany(State::class, 'country_id');
    }
}
