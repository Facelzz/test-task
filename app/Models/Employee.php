<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Employee
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @mixin Eloquent
 * @property-read Employee $head
 * @property-read Position $position
 * @property-read Collection|Employee[] $subordinates
 * @property-read int|null $subordinates_count
 * @property mixed id
 * @property string $full_name
 * @property int $position_id
 * @property int|null $head_id
 * @property string $employment_date
 * @property string $phone_number
 * @property string $email
 * @property string $salary
 * @property string $photo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $admin_created_id
 * @property int $admin_updated_id
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAdminCreatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAdminUpdatedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereEmploymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereHeadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUpdatedAt($value)
 */
class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'position_id',
        'head_id',
        'employment_date',
        'phone_number',
        'email',
        'salary',
        'photo',
        'created_at',
        'updated_at',
        'admin_created_id',
        'admin_updated_id'
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function head()
    {
        return $this->belongsTo(self::class, 'head_id');
    }

    public function subordinates()
    {
        return $this->hasMany(self::class, 'head_id');
    }
}
