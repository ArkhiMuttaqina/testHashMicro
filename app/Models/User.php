<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Helpers\generalHelpers;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    protected $table = 'users';
    protected $fillable = [
        'job_title_id',
        'department_id',
        'birth_place_id',
        'employee_number',
        'name',
        'email',
        'birth_place',
        'sex',
        'birth_date',
        'status_employee',
        'status',
        'join_date',
        
        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'datetime',
        'join_date' => 'datetime',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];




    public function SetJobTitles()
    {
        return $this->belongsTo(JobTitles::class, 'job_title_id');
    }

    public function SetDepartment()
    {
        return $this->belongsTo(Departments::class, 'department_id');
    }

    public function getCurrentQuotaLeave()
    {
        $year = (int) date("Y");
        return $this->hasMany(Leaves::class, 'user_id')->where('status', 'disetujui')
        ->whereYear('request_date', $year)
        ->sum('count_day');
    }

}
