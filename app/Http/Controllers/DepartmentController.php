<?php

namespace App\Http\Controllers;

use App\Services\DepartmentService;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function showHierarchyTree()
    {
        $data = $this->departmentService->getFormattedHierarchy();
        return view('department.hierarchy.index', compact('data'));
    }
}
