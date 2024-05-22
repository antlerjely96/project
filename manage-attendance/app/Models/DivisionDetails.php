<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DivisionDetails extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'division_id',
        'day_of_week',
        'division_date',
        'division_start_time',
        'division_end_time',
    ];

    public function division(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Division::class);
    }
}
