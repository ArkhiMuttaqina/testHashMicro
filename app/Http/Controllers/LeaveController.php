<?php

namespace App\Http\Controllers;

use App\Helpers\generalHelpers;
use App\Models\Leaves;
use Carbon\Carbon;
use Illuminate\Http\Request;

use DataTables;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use IntlDateFormatter;

class LeaveController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {

        return view('leave.index');
    }
    public function indexAll()
    {

        return view('leave.all_special_access.index');
    }


    public function create()
    {


        $year = (int) date("Y");
        $getcurrentDoc = Leaves::where('user_id', Auth()->user()->id)
            ->where('status', 'diajukan')
            ->whereYear('request_date', $year)
            ->first();
        $usedQuota = Leaves::where('user_id', Auth()->user()->id)
            ->where('status', 'disetujui')
            ->whereYear('request_date', $year)
            ->sum('count_day');
        $getDefaultQuotaLeave = generalHelpers::leaveQuota(Auth()->user()->join_date);
        $difMonth = generalHelpers::difMonth(Auth()->user()->join_date);
        if ($usedQuota != 0) {
            $default_quota_leave = $getDefaultQuotaLeave;
            $current_quota_leave = $getDefaultQuotaLeave - $usedQuota;
            $current_quota_daterange_leave = $current_quota_leave - 1;
        } else {
            if ($getDefaultQuotaLeave != 0) {
                $default_quota_leave = $getDefaultQuotaLeave;
                $current_quota_leave = $getDefaultQuotaLeave;
                $current_quota_daterange_leave = $getDefaultQuotaLeave - 1;
            } else {
                $default_quota_leave = 0;
                $current_quota_leave = 0;
                $current_quota_daterange_leave = 0;
            }
        }
        if( $getcurrentDoc != null){
            $getcurrentDoc_ = $getcurrentDoc->id;
        }else{
            $getcurrentDoc_ = null;
        }
        $data = [
            'currentDoc' => $getcurrentDoc_,
            'masa_kerja' => $difMonth,
            'default_quota_leave' => $default_quota_leave,
            'current_quota_leave' => $current_quota_leave,
            'current_quota_daterange_leave' => $current_quota_daterange_leave
        ];
        return view('leave.create',  compact('data'));
    }


    public function post(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'startDate' => 'required',
            'endDate' => 'required',
            'desc' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'isSuccess' => 'no',
                'msg' => 'periksa kembali isian kamu, Ada yang kurang sepertinya'
            ];
            return response()->json($data);
        }


        $count_day = generalHelpers::calculateDaysBetweenID($request->startDate, $request->endDate);
        $request_date = Carbon::now();

        $year = (int) date("Y");
        $usedQuota = Leaves::where('user_id', Auth()->user()->id)
            ->where('status', 'disetujui')
            ->whereYear('request_date', $year)
            ->sum('count_day');
        $getDefaultQuotaLeave = generalHelpers::leaveQuota(Auth()->user()->join_date);

        if ($usedQuota >= $getDefaultQuotaLeave) {
            $data = [
                'isSuccess' => 'no',
                'msg' => 'jatah cuti kamu telah habis.'
            ];
            return response()->json($data);
        }

        $msg = '';
        try {
            DB::beginTransaction();
            $store = new Leaves();
            $store->name = auth()->user()->name;
            $store->user_id = auth()->user()->id;
            $store->creator_id = auth()->user()->id;
            $store->approver_id = null;
            $store->status =  'diajukan';
            $store->approved_at = null;
            $store->desc = $request->desc;
            $store->count_day = $count_day;
            $store->request_date = $request_date;
            $store->start_date = generalHelpers::dateIDtoISO($request->startDate);
            $store->end_date = generalHelpers::dateIDtoISO($request->endDate);
            $store->save();
            DB::commit();
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            DB::rollback();
            // dd($e);
        }


        if ($msg == null) {
            $data = [
                'isSuccess' => 'yes',
                'msg' => ''
            ];
        } else {
            $data = [
                'isSuccess' => 'no',
                'msg' => $msg
            ];
        }
        return response()->json($data);
    }


    public function show($id)
    {


        $data = Leaves::find($id);
        $state = 'true';

        return view('leave.show', compact('data', 'state'));
    }



    public function destroy(Request $req, Leaves $Leaves)
    {
        $msg = '';

        $Leaves = Leaves::find($req->id);
        try {
            // $Leaves = Leaves::find($id);
            $Leaves->delete();
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            DB::rollback();
            // dd($e);
        }


        if ($msg == null) {
            $data = [
                'isSuccess' => 'yes',
                'msg' => ''
            ];
        } else {
            $data = [
                'isSuccess' => 'no',
                'msg' => $msg
            ];
        }
        return response()->json($data);
    }
    public function approval(Request $req, Leaves $Leaves)
    {
        $msg = '';
        try {
            $Leaves = Leaves::find($req->id);
            $Leaves->status = 'IN APPROVAL';
            $Leaves->save();
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            DB::rollback();
            // dd($e);
        }


        if ($msg == null) {
            $data = [
                'isSuccess' => 'yes',
                'msg' => ''
            ];
        } else {
            $data = [
                'isSuccess' => 'no',
                'msg' => $msg
            ];
        }
        return response()->json($data);
    }

    public function approved(Request $req,  Leaves $Leaves)
    {
        $now = new DateTime();
        $msg = '';

        try {
            $Leaves = Leaves::find($req->id);
            $Leaves->status = 'disetujui';
            $Leaves->approved_at =  $now->format('Y-m-d H:i:s');
            $Leaves->approver_id = auth()->user()->id;
            $Leaves->save();
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            DB::rollback();
            // dd($e);
        }


        if ($msg == null) {
            $data = [
                'isSuccess' => 'yes',
                'msg' => ''
            ];
        } else {
            $data = [
                'isSuccess' => 'no',
                'msg' => $msg
            ];
        }
        return response()->json($data);
    }
    public function rejected(Request $req, Leaves $Leaves)
    {
        $now = new DateTime();

        $msg = '';
        try {
            $Leaves = Leaves::find($req->id);
            $Leaves->status = 'ditolak';
            $Leaves->approved_at =  $now->format('Y-m-d H:i:s');
            $Leaves->approver_id = auth()->user()->id;
            $Leaves->save();
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            DB::rollback();
            // dd($e);
        }


        if ($msg == null) {
            $data = [
                'isSuccess' => 'yes',
                'msg' => ''
            ];
        } else {
            $data = [
                'isSuccess' => 'no',
                'msg' => $msg
            ];
        }
        return response()->json($data);
    }
    public function cancelled(Request $req, Leaves $Leaves)
    {
        $now = new DateTime();

        $msg = '';
        try {
            $Leaves = Leaves::find($req->id);
            $Leaves->status = 'diajukan';
            $Leaves->approved_at =  $now->format('Y-m-d H:i:s');
            $Leaves->approver_id = auth()->user()->id;
            $Leaves->save();
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            DB::rollback();
            // dd($e);
        }


        if ($msg == null) {
            $data = [
                'isSuccess' => 'yes',
                'msg' => ''
            ];
        } else {
            $data = [
                'isSuccess' => 'no',
                'msg' => $msg
            ];
        }
        return response()->json($data);
    }
    public function api(Request $request)
    {

        if ($request->id != null) {
            $data = Leaves::find($request->id);
            return Response::json($data);
        }
        $data = Leaves::where('user_id', auth()->user()->id);

        return Datatables::of($data->get())
            ->addIndexColumn()
            ->editColumn('status', function ($data) {
                $status = $data->status;

                if ($status == 'diajukan') {
                    $var = '<span class="badge rounded-pill text-white" style="background-color:#FFA500;">DIAJUKAN</span>';
                } else if ($status == 'ditolak') {
                    $var = '<span class="badge rounded-pill text-white" style="background-color:#FF0000;">DITOLAK</span>';
                } else if ($status == 'disetujui') {
                    $var = '<span class="badge rounded-pill text-white" style="background-color:#008000;">DISETUJUI</span>';
                } else {
                    $var = '<span class="badge rounded-pill text-white">NULL</span>';
                }

                return $var;
            })
            ->editColumn('creator', function ($data) {
                $creator = $data->creator?->name;
                if ($creator == '' || $creator == null) {
                    $var = '-';
                } else {
                    $var = $creator;
                }
                return $var;
            })
            ->editColumn('approver', function ($data) {
                $approver = $data->approver?->name;
                if ($approver == '' || $approver == null) {
                    $var = '-';
                } else {
                    $var = $approver;
                }
                return $var;
            })
            ->editColumn('desc', function ($data) {
                $desc = $data->desc;
                return $desc;
            })
            ->editColumn('dateLeave', function ($data) {
                $var = generalHelpers::dMY_converter($data->start_date) . ' - ' . generalHelpers::dMY_converter($data->end_date);
                return $var;
            })

            ->editColumn('totalDay', function ($data) {
                $count_day = '<b>' . $data->count_day . ' Hari</b>';
                return $count_day;
            })
            ->editColumn('created_at', function ($data) {
                $tanggal = $data->request_date;
                $date = new DateTime($tanggal);
                $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::FULL, IntlDateFormatter::LONG);
                $result = $formatter->format($date);
                return '<div style="float: right; display: block">' . $result . '</div>';
            })
            ->editColumn('action', function ($data) {
                $btn = '';
                if ($data->status == 'diajukan') {

                    $btn = $btn . '<a href="javascript:void(0)" onclick="hapus(' . $data->id . ', `' . $data->name . '`);" style="margin-left:3px;  margin-right:3px;"class="btn btn-sm btn-danger">hapus</a>';
                    // $btn = $btn . '<a href="javascript:void(0)" onclick="approval(' . $data->id . ', `' . $data->name . '`);" style="margin-left:3px;  margin-right:3px;"class="btn btn-sm btn-secondary">Ajukan</a>';
                } else if ($data->status == 'disetujui') {
                    $btn = $btn . '<a href="' . url('leave/show/' . $data->id) . '"  style="margin-left:3px;  margin-right:3px;"class="btn btn-sm btn-info">Lihat</a>';
                } else if ($data->status == 'ditolak') {
                    $btn = $btn . '<a href="' . url('leave/show/' . $data->id) . '"  style="margin-left:3px;  margin-right:3px;"class="btn btn-sm btn-info">Lihat</a>';
                $btn = $btn . '<a href="javascript:void(0)" onclick="hapus(' . $data->id . ', `' . $data->name . '`);" style="margin-left:3px;  margin-right:3px;"class="btn btn-sm btn-danger">hapus</a>';
                }
                return $btn;
            })


            ->rawColumns([
                'status',
                'creator',
                'approver',
                'desc',
                'dateLeave',
                'totalDay',
                'created_at',
                'action',
            ])
            ->make(true);
    }

    public function apiAllLeaves(Request $request)
    {
        $data = Leaves::with(
            'creator',
            'approver',
            'user'
        );

        if ($request->state == 'update') {
            $data->where('status', 'diajukan');
        } else {
            $data->whereIn('status',  ['disetujui', 'ditolak']);
        }

        return Datatables::of($data->get())
            ->addIndexColumn()
            ->editColumn('status', function ($data) {
                $status = $data->status;

                if ($status == 'diajukan') {
                    $var = '<span class="badge rounded-pill text-white" style="background-color:#FFA500;">DIAJUKAN</span>';
                } else if ($status == 'ditolak') {
                    $var = '<span class="badge rounded-pill text-white" style="background-color:#FF0000;">DITOLAK</span>';
                } else if ($status == 'disetujui') {
                    $var = '<span class="badge rounded-pill text-white" style="background-color:#008000;">DISETUJUI</span>';
                } else {
                    $var = '<span class="badge rounded-pill text-white">NULL</span>';
                }

                return $var;
            })
            ->editColumn('creator', function ($data) {
                $creator = $data->creator?->name;
                if ($creator == '' || $creator == null) {
                    $var = '-';
                } else {
                    $var = $creator;
                }
                return $var;
            })
            ->editColumn('approver', function ($data) {
                $approver = $data->approver?->name;
                if ($approver == '' || $approver == null) {
                    $var = '-';
                } else {
                    $var = $approver;
                }
                return $var;
            })
            ->editColumn('desc', function ($data) {
                $desc = $data->desc;
                return $desc;
            })
            ->editColumn('dateLeave', function ($data) {
                $var = generalHelpers::dMY_converter($data->start_date) . ' - ' . generalHelpers::dMY_converter($data->end_date);
                return $var;
            })

            ->editColumn('totalDay', function ($data) {
                $count_day = '<b>' . $data->count_day . ' Hari</b>';
                return $count_day;
            })
            ->editColumn('created_at', function ($data) {
                $tanggal = $data->request_date;
                $date = new DateTime($tanggal);
                $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::FULL, IntlDateFormatter::LONG);
                $result = $formatter->format($date);
                return '<div style="float: right; display: block">' . $result . '</div>';
            })
            ->editColumn('action', function ($data) {
                $btn = '';
                if ($data->status == 'diajukan') {
                    $btn = $btn . '<a href="' . url('leave/show/' . $data->id) . '"  style="margin-left:3px;  margin-right:3px;"class="btn btn-sm btn-info">Lihat</a>';
                    $btn = $btn . '<a href="javascript:void(0)" onclick="showDetail(' . $data->id . ', `' . $data->name . '`);" style="margin-left:3px;  margin-right:3px;"class="btn btn-sm btn-secondary">Setujui</a>';
                } else if ($data->status == 'disetujui') {
                    $btn = $btn . '<a href="' . url('leave/show/' . $data->id) . '"  style="margin-left:3px;  margin-right:3px;"class="btn btn-sm btn-info">Lihat</a>';
                } else if ($data->status == 'ditolak') {
                }
                return $btn;
            })


            ->rawColumns([
                'status',
                'creator',
                'approver',
                'desc',
                'dateLeave',
                'totalDay',
                'created_at',
                'action'
            ])
            ->make(true);
    }
}
