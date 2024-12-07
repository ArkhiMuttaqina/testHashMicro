<?php

namespace App\Repositories\Contracts;

interface UsersRepositoryInterface
{

    public function getLastCode($departmentId);
    public function findById($id);
}
