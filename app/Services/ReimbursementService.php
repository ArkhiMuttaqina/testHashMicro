<?php

namespace App\Services;

use App\Models\reimbursements;
use App\Repositories\Contracts\FileServiceRepositoryInterface;
use App\Repositories\Contracts\ReimbursementRepositoryInterface;
use App\Repositories\UsersRepository;
use DateTime;
use Illuminate\Support\Facades\DB;

class ReimbursementService
{
    protected $reimbursementrepository;
    protected $usersrepo;

    protected $fileService;

    public function __construct(
        ReimbursementRepositoryInterface $ReimbursementRepository,
        FileServiceRepositoryInterface $fileService,
        UsersRepository $usersrepo,
        )
    {
        $this->reimbursementrepository = $ReimbursementRepository;
        $this->fileService = $fileService;
    }
    public function findById($id)
    {
        return reimbursements::find($id);
    }

    public function storeReimbursement(array $data, $file = null)
    {
        DB::beginTransaction();

        try {
            if ($file) {
                $uploadPath = public_path('files_upload/');
                $fileName = $this->fileService->uploadFile($file, $uploadPath);
                $data['files'] = $fileName;
            } else {
                $data['files'] = '';
            }

            $data['status'] = 'IN PROCESS';
            $data['approved_at'] = null;

            $reimbursement = $this->reimbursementrepository->create($data);
            DB::commit();

            return [
                'isSuccess' => 'yes',
                'msg' => 'Pengajuan berhasil disimpan'
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'isSuccess' => 'no',
                'msg' => $e->getMessage()
            ];
        }
    }

    public function updateReimbursement($id, array $data, $file = null)
    {
        DB::beginTransaction();
        try {
            $reimbursement = $this->reimbursementrepository->findById($id);
            if (!$reimbursement) {
                throw new \Exception("Reimbursement not found");
            }

            if ($file) {
                $uploadPath = public_path('files_upload/');
                $fileName = $this->fileService->uploadFile($file, $uploadPath);
                $data['files'] = $fileName;
            }

            $this->reimbursementrepository->update($id, $data);

            DB::commit();
            return [
                'isSuccess' => 'yes',
                'msg' => 'Pengajuan berhasil disimpan'
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'isSuccess' => 'no',
                'msg' => $e->getMessage()
            ];
        }
    }


    public function deleteReimbursement($id)
    {
        DB::beginTransaction();
        try {
            $reimbursement = $this->reimbursementrepository->findById($id);
            if (!$reimbursement) {
                throw new \Exception("Reimbursement not found");
            }

            if (!empty($reimbursement->files)) {
                $this->fileService->deleteFile(public_path('files_upload/' . $reimbursement->files));
            }

            $this->reimbursementrepository->delete($id);

            DB::commit();
            return [
                'isSuccess' => 'yes',
                'msg' => 'Pengajuan berhasil disimpan'
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'isSuccess' => 'no',
                'msg' => $e->getMessage()
            ];
        }
    }



    public function approvalReimbursement(int $userId)
    {
        try {
            $reimbursement = $this->reimbursementrepository->findById($userId);
            DB::beginTransaction();
            $reimbursement->status = 'IN APPROVAL';
            $reimbursement->save();
            DB::commit();
            return [
                'isSuccess' => 'yes',
                'msg' => ''
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'isSuccess' => 'no',
                'msg' => $e->getMessage()
            ];
        }
    }


    public function approvedReimbursement(int $userId)
    {
        $now = new DateTime();
        $msg = '';
        try {
            $reimbursement = $this->reimbursementrepository->findById($userId);
            DB::beginTransaction();
            $reimbursement->status = 'APPROVED';
            $reimbursement->approved_at =  $now->format('Y-m-d H:i:s');
            $reimbursement->approver_id = auth()->user()->id;
            $reimbursement->save();
            DB::commit();

            return [
                'isSuccess' => 'yes',
                'msg' => ''
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'isSuccess' => 'no',
                'msg' => $e->getMessage()
            ];
        }
    }

    public function rejectedReimbursement(int $userId)
    {
        $now = new DateTime();
        $msg = '';
        try {
            $reimbursement = $this->reimbursementrepository->findById($userId);
            DB::beginTransaction();

            $reimbursement->status = 'REJECTED';
            $reimbursement->approved_at =  $now->format('Y-m-d H:i:s');
            $reimbursement->approver_id = auth()->user()->id;
            $reimbursement->save();
            DB::commit();

            return [
                'isSuccess' => 'yes',
                'msg' => ''
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'isSuccess' => 'no',
                'msg' => $e->getMessage()
            ];
        }
    }
    public function cancelledReimbursement(int $userId)
    {
        $now = new DateTime();
        $msg = '';
        try {
            $reimbursement = $this->reimbursementrepository->findById($userId);
            DB::beginTransaction();

            $reimbursement->status = 'CANCELED';
            $reimbursement->approved_at =  $now->format('Y-m-d H:i:s');
            $reimbursement->approver_id = auth()->user()->id;
            $reimbursement->save();
            DB::commit();

            return [
                'isSuccess' => 'yes',
                'msg' => ''
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'isSuccess' => 'no',
                'msg' => $e->getMessage()
            ];
        }
    }
    public function getReimbursementsForDataTable(string $state)
    {
        $data = $this->reimbursementrepository->getReimbursements($state);

        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('status', function ($data) {
                return $this->formatStatusBadge($data->status);
            })
            ->editColumn('creator', fn($data) => $data->creator ?? '-')
            ->editColumn('approver', fn($data) => $data->approver ?? '-')
            ->editColumn('nominal', fn($data) => '<div style="float: right;">Rp. ' . number_format($data->nominal, 2, ',', '.') . ',-</div>')
            ->editColumn('created_at', fn($data) => '<div style="float: right;">' . $this->formatDate($data->created_at) . '</div>')
            ->editColumn('action', fn($data) => $this->generateActionButtons($data))
            ->rawColumns(['status', 'nominal', 'created_at', 'action'])
            ->make(true);
    }

    protected function formatStatusBadge(string $status): string
    {
        $badges = [
            'IN PROCESS' => '#87AFC7',
            'IN APPROVAL' => '#FFA500',
            'REJECTED' => '#FF0000',
            'APPROVED' => '#008000',
            'POST' => '#008000',
            'CLOSED' => '#0000A0',
            'DELETED' => 'black',
            'CANCELED' => '#C11B17',
            'PENDING' => '#FFA500',
        ];

        $color = $badges[$status] ?? 'grey';
        return "<span class=\"badge rounded-pill text-white\" style=\"background-color:{$color};\">{$status}</span>";
    }

    protected function formatDate(string $date): string
    {
        $formatter = new \IntlDateFormatter('id_ID', \IntlDateFormatter::FULL, \IntlDateFormatter::LONG);
        return $formatter->format(new \DateTime($date));
    }

    protected function generateActionButtons($data): string
    {
        $btn = '';

        if ($data->status === 'IN PROCESS') {
            $btn .= '<a href="javascript:void(0)" onclick="hapus(' . $data->id . ', `' . $data->name . '`);" class="btn btn-sm btn-danger">Hapus</a>';
            $btn .= '<a href="javascript:void(0)" onclick="approval(' . $data->id . ', `' . $data->name . '`);" class="btn btn-sm btn-secondary">Ajukan</a>';
        } elseif (in_array($data->status, ['APPROVED', 'PENDING'])) {
            $btn .= '<a href="' . url('reimbursements/show/' . $data->id) . '" class="btn btn-sm btn-info">Lihat</a>';
        } elseif ($data->status === 'IN APPROVAL') {
            $btn .= '<a href="javascript:void(0)" onclick="showDetail(' . $data->id . ', `' . $data->name . '`);" class="btn btn-sm btn-secondary">Setujui</a>';
        }

        return $btn;
    }
}
