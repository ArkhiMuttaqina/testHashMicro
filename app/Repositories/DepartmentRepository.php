<?php

namespace App\Repositories;

use App\Models\Departments;
use App\Repositories\Contracts\DepartmentRepositoryInterface;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    public function showHirarchy()
    {

        return Departments::with(['SetJobTitles.users'])->get();
    }

    public function getAllDepartment()
    {

        return Departments::with('SetJobTitles')->get();
    }
}
