<?php

namespace App\Services;

use App\Repositories\Contracts\DepartmentRepositoryInterface;

class DepartmentService
{
    protected $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function getFormattedHierarchy()
    {
        $departments = $this->departmentRepository->showHirarchy();

        $hierarchy = [];
        foreach ($departments as $department) {
            $ArrJobTitles = [];
            foreach ($department->SetJobTitles as $JobTitles) {
                $users = $JobTitles->users->map(function ($user) {
                    return $user->name;
                })->toArray();

                $ArrJobTitles[] = [
                    'name' => $JobTitles->name,
                    'user_count' => $JobTitles->users->count(),
                    'users' => $users,
                ];
            }

            $hierarchy[] = [
                'department_name' => $department->name,
                'job_Title' => $ArrJobTitles,
            ];
        }

        return $hierarchy;
    }

    public function getAll()
    {
        $departments = $this->departmentRepository->getAllDepartment();

        return $departments;
    }
}
