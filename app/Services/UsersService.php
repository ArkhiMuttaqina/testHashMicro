<?php

namespace App\Services;

use App\Helpers\generalHelpers;
use App\Models\Leaves;
use App\Models\User;
use App\Repositories\Contracts\UsersRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UsersService
{
    protected $UsersRepository;

    public function __construct(UsersRepositoryInterface $UsersRepository)
    {
        $this->UsersRepository = $UsersRepository;
    }



    public function storeUser(array $data)
    {
        try {

            $getLastCode = $this->UsersRepository->getLastCode($data['input_departments']);
            DB::beginTransaction();
            $user = new User();
            $user->name = $data['input_nama'];
            $user->birth_place_id = $data['input_birth_place'];
            $user->birth_place = $data['input_birth_place_name'];
            $user->sex = $data['input_sex'];
            $user->birth_date = $data['input_tanggal_lahir'];
            $user->status_employee = $data['input_status_employee'];
            $user->join_date = $data['input_tanggal_gabung'];
            $user->email = $data['input_Email'];
            $user->department_id = $data['input_departments'];
            $user->job_title_id = $data['input_title'];
            $user->employee_number = $getLastCode;
            $user->status = 'ACTIVE';
            $user->password = Hash::make($data['password_input']);
            $user->save();

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
    public function updateUser(array $data)
    {
        DB::beginTransaction();
        try {
            $user = User::find($data['ubah_id']);

            if (!$user) {
                return [
                    'isSuccess' => 'no',
                    'msg' => 'User not found'
                ];
            }

            $user->name = $data['ubah_nama'];
            $user->email = $data['ubah_email'];
            $user->birth_date = $data['ubah_tanggal_lahir'];
            $user->birth_place = $data['ubah_birth_place_name'];
            $user->birth_place_id = $data['ubah_birth_place_id'];
            $user->department_id = $data['ubah_departments'];
            $user->job_title_id = $data['ubah_job_tittle'];
            $user->sex = $data['ubah_sex'];
            $user->status_employee = $data['ubah_status_employee'];
            $user->join_date = $data['ubah_tanggal_gabung'];
            $user->password = Hash::make($data['ubah_password']);
            $user->save();

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

    public function deleteUser(int $userId)
    {
        try {
            $user = User::find($userId);
            if (!$user) {
                return [
                    'isSuccess' => 'no',
                    'msg' => 'User not found'
                ];
            }

            //HARD DELETE
            DB::beginTransaction();
            $user->delete();
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

    public function activateUser(int $userId)
    {

        try {
            $User = User::find($userId);
            DB::beginTransaction();
            $User->status = 'ACTIVE';
            $User->save();
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

    public function deactivateUser(int $userId)
    {
        try {
            $User = User::find($userId);
            DB::beginTransaction();
            $User->status = 'INACTIVE';
            $User->save();
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


    public function getUsersForDataTable($request)
    {
        $users = User::select('*')->with('SetJobTitles', 'SetDepartment')->get();

        return DataTables::of($users)
            ->addIndexColumn()
            ->editColumn('status', function ($data) {
                return $this->formatStatus($data->status);
            })
            ->editColumn('jatahCuti', function ($data) {
                $usedQuota = $this->getCurrentUsedQuotaLeave($data->id);
                $getDefaultQuotaLeave = generalHelpers::leaveQuota($data->join_date);
                return $this->formatQuota($usedQuota, $getDefaultQuotaLeave);
            })
            ->editColumn('masaKerja', function ($data) {
                $difMonth = generalHelpers::difMonth($data->join_date);
                return $this->formatMasaKerja($difMonth);
            })
            ->editColumn('department', function ($data) {
                return $this->formatBadge($data?->SetDepartment?->name);
            })
            ->editColumn('job_title', function ($data) {
                return $this->formatBadge($data?->SetJobTitles?->name);
            })
            ->editColumn('action', function ($data) {
                return $this->generateActionButtons($data);
            })
            ->rawColumns(['status', 'jatahCuti', 'masaKerja', 'job_title', 'department', 'action'])
            ->make(true);
    }

    private function formatStatus($status)
    {
        $statusClass = $status == 'ACTIVE' ? 'success' : ($status == 'INACTIVE' ? 'danger' : 'warning');
        return "<div class='badge bg-$statusClass text-white rounded-pill'>$status</div>";
    }

    private function formatQuota($usedQuota, $defaultQuota)
    {
        return "<div class='badge bg-dark text-white rounded-pill'>$usedQuota / $defaultQuota Hari</div>";
    }

    private function formatMasaKerja($months)
    {
        return "<div class='badge bg-warning text-white rounded-pill'>$months Bulan</div>";
    }

    private function formatBadge($value)
    {
        $badgeClass = $value ? 'dark' : 'warning';
        return "<div class='badge bg-$badgeClass text-white rounded-pill'>" . ($value ?: '-') . "</div>";
    }

    private function generateActionButtons($data)
    {
        $btn = '<button type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="ubah data karyawan" onclick="change(' . $data->id . ');" class="btn btn-sm btn-info"><i class="fa-solid fa-pencil"></i></button>';
        $btn .= '<button type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Hapus Pengguna" onclick="hapus(' . $data->id . ', `' . $data->name . '`);" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>';
        if ($data->status == 'ACTIVE') {
            $btn .= '<button type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Matikan akses Karyawan" onclick="deactivate(' . $data->id . ', `' . $data->name . '`)" class="btn btn-sm btn-warning"><i class="fa-solid fa-toggle-off"></i></button>';
        } else {
            $btn .= '<button type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Aktifkan akses Karyawan" onclick="activate(' . $data->id . ', `' . $data->name . '`)" class="btn btn-sm btn-success"><i class="fa-solid fa-toggle-on"></i></button>';
        }
        return $btn;
    }

    private function getCurrentUsedQuotaLeave($userId)
    {
        $year = (int) date("Y");
        $totalCountDay = Leaves::where('user_id', $userId)
            ->where('status', 'disetujui')
            ->whereYear('request_date', $userId)
            ->sum('count_day');
        return $totalCountDay;
    }
}
