<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $fillable = [
        'name',
        'status',
    ];

    public function SetJobTitles()
    {
        return $this->hasMany(JobTitles::class, 'department_id');
    }

    public $timestamps = true;
}
