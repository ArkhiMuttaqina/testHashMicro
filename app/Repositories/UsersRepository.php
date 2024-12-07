<?php

namespace App\Repositories;

use App\Models\Departments;
use App\Models\User;
use App\Repositories\Contracts\UsersRepositoryInterface;
use Carbon\Carbon;

class UsersRepository implements UsersRepositoryInterface
{
    public function getLastCode($departmentId = null)
    {
        $getLastCode = User::select('employee_number')
        ->orderBy('id', 'desc')
            ->pluck('employee_number')
            ->first();
            $year = Carbon::now()->year;
            $month = Carbon::now()->month;
            $lastEmployeeNumber = $getLastCode ?? '000000000';
            $employeeSequence = (int)substr($lastEmployeeNumber, 9);

            $newEmployeeSequence = $employeeSequence + 1;
            $monthFormatted = str_pad($month, 2, "0", STR_PAD_LEFT);
            $departmentFormatted = str_pad($departmentId, 3, "0", STR_PAD_LEFT);
            $sequenceFormatted = str_pad($newEmployeeSequence, 3, "0", STR_PAD_LEFT);
            $newEmployeeNumber = $year . $monthFormatted . $departmentFormatted . $sequenceFormatted;

        return $newEmployeeNumber;
    }

    public function findById($id)
    {
        return User::find($id);
    }
}
