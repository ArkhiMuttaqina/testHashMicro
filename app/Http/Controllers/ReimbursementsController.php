<?php

namespace App\Http\Controllers;

use App\Helpers\generalHelpers;
use App\Models\reimbursements;
use App\Repositories\FileServiceRepository;
use App\Repositories\ReimbursementRepository;
use App\Services\ReimbursementService;
use Illuminate\Http\Request;

use DataTables;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use IntlDateFormatter;

class reimbursementsController extends Controller
{

    protected $reimbursement;
    protected $fileService;

    public function __construct(
        ReimbursementService $reimbursement,
        FileServiceRepository $fileService
    ) {
        $this->reimbursement = $reimbursement;
        $this->fileService = $fileService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        // dd(Hash::make("123456"));

        return view('reimbursements.index');
    }
    public function indexAll()
    {

        return view('reimbursements.all_special_access.index');
    }


    public function create()
    {
        return view('reimbursements.create');
    }

    public function downloadFile(Request $req)
    {
        try {
            $data = $this->reimbursement->findById($req->id);

            if (!$data) {
                return response()->json(['error' => 'Reimbursement not found'], 404);
            }

            $fileName = $data->files;
            $filePath = $this->fileService->getFilePath($fileName);

            $this->fileService->validateFileExists($filePath);

            $fileSize = filesize($filePath);

            return response()->stream(function () use ($filePath) {
                $file = fopen($filePath, 'rb');
                fpassthru($file);
                fclose($file);
            }, 200, [
                'Content-Type' => 'application/octet-stream',
                'Content-Length' => $fileSize,
                'Content-Disposition' => 'attachment; filename="' . basename($filePath) . '"',
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pengajuan' => 'required|string',
            'nominal' => 'required',
            'desc' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'isSuccess' => 'no',
                'msg' => 'Periksa kembali isian kamu, ada yang kurang sepertinya.',
            ]);
        }


        $data = [
            'name' => $request->nama_pengajuan,
            'creator_id' => auth()->user()->id,
            'approver_id' => null,
            'nominal' => generalHelpers::RPtoNumber($request->nominal),
            'desc' => $request->desc,
        ];

        $result = $this->reimbursement->storeReimbursement($data, $request->file('unggah'));
        return response()->json($result);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:reimbursements,id',
            'nama_pengajuan' => 'required|string',
            'nominal' => 'required',
            'desc' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'isSuccess' => 'no',
                'msg' => 'Periksa kembali isian kamu, ada yang kurang sepertinya.',
            ]);
        }
            $data = [
                'name' => $request->nama_pengajuan,
                'nominal' => generalHelpers::RPtoNumber($request->nominal),
                'desc' => $request->desc,
            ];

            $result =  $this->reimbursement->updateReimbursement($request->id, $data, $request->file('unggah'));

            return response()->json($result);
    }
    public function show($id)
    {
        $reimbursements =  $this->reimbursement->findById($id);
        $state = 'true';

        return view('reimbursements.show', compact('reimbursements', 'state'));
    }

    public function edit($id)
    {

        $reimbursements =  $this->reimbursement->findById($id);
        $state = 'true';

        return view('reimbursements.edit', compact('reimbursements', 'state'));
    }

    public function destroy(Request $req, reimbursements $reimbursements)
    {
        $msg = '';
    try{
        $this->reimbursement->deleteReimbursement($req->id);
            return [
                'isSuccess' => 'yes',
                'msg' => 'Pengajuan berhasil dihapus'
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'isSuccess' => 'no',
                'msg' => $e->getMessage()
            ];
        };
    }

    public function approval(Request $req)
    {
        $msg = '';
        $data = $this->reimbursement->approvalReimbursement($req->id);
        return Response::json($data);
    }

    public function approved(Request $req)
    {

        $data = $this->reimbursement->approvedReimbursement($req->id);
        return Response::json($data);
    }
    public function rejected(Request $req)
    {
        $data = $this->reimbursement->rejectedReimbursement($req->id);
        return Response::json($data);
    }

    public function cancelled(Request $req)
    {
        $data = $this->reimbursement->cancelledReimbursement($req->id);
        return Response::json($data);
    }

    public function apiByID($id)
    {
        
        $users = DB::table('reimbursements')->select(
            'reimbursements.*',
            'users_creator.name as creator',
            'users_approver.name as approver'
        )
            ->leftjoin('users as users_creator', 'users_creator.id', '=', 'reimbursements.creator_id')
            ->leftjoin('users as users_approver', 'users_approver.id', '=', 'reimbursements.approver_id')
            ->where('reimbursements.id', '=', $id)->first();
        return Response::json($users);
    }


    public function api(Request $request)
    {

        $data = DB::table('reimbursements')->select(
            'reimbursements.*',
            'users_creator.name as creator',
            'users_approver.name as approver'
        )
            ->leftjoin('users as users_creator', 'users_creator.id', '=', 'reimbursements.creator_id')
            ->leftjoin('users as users_approver', 'users_approver.id', '=', 'reimbursements.approver_id')->where('reimbursements.creator_id', '=', auth()->user()->id)->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('status', function ($data) {
                $status = $data->status;

                if ($status == 'IN PROCESS') {
                    $var = '<span class="badge rounded-pill text-white" style="background-color:#87AFC7;">IN PROCESS</span>';
                } else if ($status == 'IN APPROVAL') {
                    $var = '<span class="badge rounded-pill text-white" style="background-color:#FFA500;">IN APPROVAL</span>';
                } else if ($status == 'REJECTED') {
                    $var = '<span class="badge rounded-pill text-white" style="background-color:#FF0000;">REJECTED</span>';
                } else if ($status == 'APPROVED') {
                    $var = '<span class="badge rounded-pill text-white" style="background-color:#008000;">APPROVED</span>';
                } else if ($status == 'POST') {
                    $var = '<span class="badge rounded-pill text-white" style="background-color:#008000;">POST</span>';
                } else if ($status == 'CLOSED') {
                    $var = '<span class="badge rounded-pill text-white" style="background-color:#0000A0;">CLOSED</span>';
                } else if ($status == 'DELETED') {
                    $var = '<span class="badge rounded-pill text-white" style="background-color:black;">DELETED</span>';
                } else if ($status == 'CANCELED') {
                    $var = '<span class="badge rounded-pill text-white" style="background-color:#C11B17;">CANCELED</span>';
                } else if ($status == 'PENDING') {
                    $var = '<span class="badge rounded-pill text-white" style="background-color:#FFA500;">PENDING !</span>';
                } else {
                    $var = '<span class="badge rounded-pill text-white">NULL</span>';
                }

                return $var;
            })
            ->editColumn('creator', function ($data) {
                $creator = $data->creator;
                if ($creator == '' || $creator == null) {
                    $var = '-';
                } else {
                    $var = $creator;
                }
                return $var;
            })
            ->editColumn('approver', function ($data) {
                $approver = $data->approver;
                if ($approver == '' || $approver == null) {
                    $var = '-';
                } else {
                    $var = $approver;
                }
                return $var;
            })
            ->editColumn('nominal', function ($data) {
                $grand_total = 'Rp. ' . number_format($data->nominal, 2, ',', '.');
                return '<div style="float: right; display: block">' . $grand_total . ',-</div>';
            })
            ->editColumn('created_at', function ($data) {
                $tanggal = $data->created_at;
                $date = new DateTime($tanggal);
                $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::FULL, IntlDateFormatter::LONG);
                $result = $formatter->format($date);
                return '<div style="float: right; display: block">' . $result . '</div>';
            })
            ->editColumn('action', function ($data) {
                $btn = '';


                if ($data->status == 'IN PROCESS' || $data->status == 'REJECTED' || $data->status == 'CANCELED') {
                    $btn = $btn . '<a href="' . url('reimbursements/edit/' . $data->id) . '"  style="margin-left:3px;  margin-right:3px;"class="btn btn-sm btn-info">Edit</a>';
                    $btn = $btn . '<a href="javascript:void(0)" onclick="hapus(' . $data->id . ', `' . $data->name . '`);" style="margin-left:3px;  margin-right:3px;"class="btn btn-sm btn-danger">hapus</a>';
                    $btn = $btn . '<a href="javascript:void(0)" onclick="approval(' . $data->id . ', `' . $data->name . '`);" style="margin-left:3px;  margin-right:3px;"class="btn btn-sm btn-secondary">Ajukan</a>';
                } else if ($data->status == 'APPROVED') {
                    $btn = $btn . '<a href="' . url('reimbursements/show/' . $data->id) . '"  style="margin-left:3px;  margin-right:3px;"class="btn btn-sm btn-info">Lihat</a>';
                } else if ($data->status == 'PENDING') {
                    $btn = $btn . '<a href="' . url('reimbursements/show/' . $data->id) . '"  style="margin-left:3px;  margin-right:3px;"class="btn btn-sm btn-info">Lihat</a>';
                } else if ($data->status == 'IN APPROVAL') {
                    $btn = $btn . '<a href="javascript:void(0)" onclick="canceled(' . $data->id . ', `' . $data->name . '`);" style="margin-left:3px;  margin-right:3px;"class="btn btn-sm btn-danger">Batalkan</a>';
                }

                return $btn;
            })

            ->rawColumns(['status', 'creator', 'approver', 'nominal', 'created_at', 'action'])
            ->make(true);
    }

    public function apiAllreimbursements(Request $request)
    {
        $state = $request->state ?? 'approved';
        return $this->reimbursement->getReimbursementsForDataTable($state);
    }
}
