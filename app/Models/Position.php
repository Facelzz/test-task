<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


/**
 * App\Models\Position
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Position newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Position newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Position query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $admin_created_id
 * @property int $admin_updated_id
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereAdminCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereAdminUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Position whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Employee[] $employees
 * @property-read int|null $employees_count
 */
class Position extends Model
{

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'admin_created_id',
        'admin_updated_id'
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'position_id');
    }

}
