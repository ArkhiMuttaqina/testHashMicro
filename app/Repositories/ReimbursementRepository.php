<?php

namespace App\Repositories;

use App\Models\Departments;
use App\Models\JobTitles;
use App\Models\reimbursements;
use App\Repositories\Contracts\ReimbursementRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ReimbursementRepository implements ReimbursementRepositoryInterface
{
    public function findById($id)
    {
        return reimbursements::find($id);
    }
    public function create(array $data): Reimbursements
    {
        return reimbursements::create($data);
    }
    public function update($id, array $data): bool
    {
        $reimbursement = $this->findById($id);
        if (!$reimbursement) {
            return response()->json([
                'isSuccess' => 'no',
                'msg' => 'Terdapat kesahalan',
            ]);
        }


        return $reimbursement->update($data);
    }


    public function delete($id): bool
    {
        $reimbursement = $this->findById($id);
        if (!$reimbursement) {
            return response()->json([
                'isSuccess' => 'no',
                'msg' => 'Terdapat kesahalan',
            ]);
        }

        return $reimbursement->delete();
    }

    public function getReimbursements(string $state): \Illuminate\Support\Collection
    {
        $query = DB::table('reimbursements')
        ->select(
            'reimbursements.*',
            'users_creator.name as creator',
            'users_approver.name as approver'
        )
            ->leftJoin('users as users_creator', 'users_creator.id', '=', 'reimbursements.creator_id')
            ->leftJoin('users as users_approver', 'users_approver.id', '=', 'reimbursements.approver_id');

        if ($state === 'update') {
            $query->where('reimbursements.status', '=', 'IN APPROVAL');
        } else {
            $query->where('reimbursements.status', '=', 'APPROVED');
        }

        return $query->get();
    }
}
