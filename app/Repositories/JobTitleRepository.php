<?php

namespace App\Repositories;

use App\Models\Departments;
use App\Models\JobTitles;
use App\Repositories\Contracts\JobTitleRepositoryInterface;

class JobTitleRepository implements JobTitleRepositoryInterface
{
    public function showAll()
    {

        return JobTitles::get();
    }

    public function showByDepartmentID($id)
    {
        $data  = JobTitles::select('*')->where('job_titles.department_id', '=', $id)->get();
        return $data;
    }
}
