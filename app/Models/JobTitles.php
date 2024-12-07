<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobTitles extends Model
{
    use HasFactory;

    protected $table = 'job_titles';

    protected $fillable = [
        'department_id',
        'name',
        'status',
    ];

    public $timestamps = true;

    public function SetDepartment()
    {
        return $this->belongsTo(Departments::class, 'department_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'job_title_id');
    }
}
