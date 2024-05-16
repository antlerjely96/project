<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Major extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name'];

    public function classStudents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ClassStudent::class);
    }

    public function subjects(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->hasMany(Subject::class);
    }

    public function instructors(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Instructor::class);
    }
}
