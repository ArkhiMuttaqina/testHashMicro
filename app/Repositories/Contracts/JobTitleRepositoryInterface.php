<?php

namespace App\Repositories\Contracts;

interface JobTitleRepositoryInterface
{
    public function showAll();
    public function showByDepartmentID(int $id);
}
