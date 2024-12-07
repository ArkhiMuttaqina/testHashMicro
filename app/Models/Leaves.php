<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leaves extends Model
{
    use HasFactory;

    protected $table = 'leaves';


    protected $fillable = [
        'user_id',
        'name',
        'start_date',
        'end_date',
        'count_day',
        'request_date',
        'approved_at',
        'status',
        'desc',
        'creator_id',
        'approver_id',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
