<?php

namespace App\Http\Controllers;

use App\Helpers\generalHelpers;
use App\Models\Departments;
use App\Models\JobTitles;
use App\Models\Leaves;
use App\Models\User;
use App\Repositories\CityRepository;
use App\Services\DepartmentService;
use App\Services\JobTitleService;
use App\Services\UsersService;
use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

    protected $UsersService;
    protected $departmentService;
    protected $jobTitleService;
    protected $cityRepository;

    public function __construct(
    UsersService $UsersService,
    DepartmentService $DepartmentService,
    JobTitleService $JobTitleService,
    CityRepository $cityRepository)
    {
        $this->UsersService = $UsersService;
        $this->departmentService = $DepartmentService;
        $this->jobTitleService = $JobTitleService;
        $this->cityRepository = $cityRepository;
    }

    public function index()
    {        //inipassword
        if(auth()->user()->department_id == 2 ){

            $departments = $this->departmentService->getAll();
            $job_titles = $this->jobTitleService->getAll();
            // $users = User::all();
            return view('employee.index', compact('job_titles', 'departments'));
        }else{
            return to_route('reimbursements');
        }

    }

    public function apiCities(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('limit', 10);
        $page = $request->input('page', 1);

        $result = $this->cityRepository->getPaginatedCities($search, $perPage, $page);

        if (empty($result['data'])) {
            $result['data'] = [];
        }

        return response()->json($result, 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input_nama' => 'required',
            'input_Email' => 'required|email',
            'input_tanggal_lahir' => 'required',
            'input_birth_place' => 'required',
            'input_birth_place_name' => 'required',
            'input_departments' => 'required',
            'input_title' => 'required',
            'input_sex' => 'required',
            'input_status_employee' => 'required',
            'input_tanggal_gabung' => 'required',
            'password_input' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                'isSuccess' => 'no',
                'msg' => 'periksa kembali isian kamu, Ada yang kurang sepertinya'
            ];
            return response()->json($data);
        }

        $msg = '';
        $result = $this->UsersService->storeUser($request->all());
        return response()->json($result);
    }

    public function destroy(Request $request)
    {
        $result = $this->UsersService->deleteUser($request->id);
        return response()->json($result);
    }

    public function activate(Request $request)
    {
        $result = $this->UsersService->activateUser($request->id);
        return response()->json($result);
    }

    public function deactivate(Request $request)
    {
        $result = $this->UsersService->deactivateUser($request->id);
        return response()->json($result);
    }

    public function Update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'ubah_id' => 'required',
            'ubah_nama' => 'required',
            'ubah_email' => 'required | email',
            'ubah_tanggal_lahir' => 'required',
            'ubah_birth_place_name' => 'required',
            'ubah_birth_place_id' => 'required',
            'ubah_departments' => 'required',
            'ubah_job_tittle' => 'required',
            'ubah_sex' => 'required',
            'ubah_status_employee' => 'required',
            'ubah_tanggal_gabung' => 'required',
            'ubah_password' => 'required',

        ]);

        if ($validator->fails()) {
            $data = [
                'isSuccess' => 'no',
                'msg' => 'periksa kembali isian kamu, Ada yang kurang sepertinya'
            ];
            return response()->json($data);
        }

        $result = $this->UsersService->updateUser($request->all());
        return response()->json($result);
    }


      public function show(Request $request)
    {
            $users = User::select('*')->where('users.id', '=', $request->id)->with('SetDepartment')->first();
            return Response::json($users);
    }

    public function showJobTittle($id)
    {
        $getByDepartment = $this->jobTitleService->getByDepartment($id);
            return Response::json($getByDepartment);
    }
    public function showDepartment()
    {
        $departments = $this->departmentService->getAll();
        return Response::json($departments);
    }

    public function apiUsers(Request $request)
    {

        return $this->UsersService->getUsersForDataTable($request);
    }

}
