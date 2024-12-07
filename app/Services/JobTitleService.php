<?php

namespace App\Services;

use App\Repositories\Contracts\JobTitleRepositoryInterface;

class JobTitleService
{
    protected $JobTitleRepository;

    public function __construct(JobTitleRepositoryInterface $JobTitleRepository)
    {
        $this->JobTitleRepository = $JobTitleRepository;
    }


    public function getAll()
    {
        $jt = $this->JobTitleRepository->showAll();
        return $jt;
    }

    public function getByDepartment(int $id)
    {
        $jt = $this->JobTitleRepository->showByDepartmentID($id);
        return $jt;
    }
}
