<?php

namespace App\Repositories\Contracts;

interface ReimbursementRepositoryInterface
{


    public function findById($id);
    public function create(array $data): \App\Models\Reimbursements;
    public function update($id, array $data): bool;
    public function delete($id): bool;
    public function getReimbursements(string $state): \Illuminate\Support\Collection;


}
