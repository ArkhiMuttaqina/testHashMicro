<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reimbursements extends Model
{
    use HasFactory;

    protected $table = 'reimbursements';

    protected $fillable = [
        'name',
        'creator_id',
        'approver_id',
        'nominal',
        'approved_at',
        'status',
        'desc',
        'files',
    ];

    // Relasi ke tabel 'role' untuk 'creator_id'
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    // Relasi ke tabel 'role' untuk 'approver_id'
    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
