<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\CharacterPersentageRepositoryInterface;
use Illuminate\Http\Request;

class CharacterPersentageController extends Controller
{
    protected $CharacterPersentageRepository;

    public function __construct(CharacterPersentageRepositoryInterface $CharacterPersentageRepository)
    {
        $this->CharacterPersentageRepository = $CharacterPersentageRepository;
    }


    public function index(Request $request)
    {
        return view('charPersentage.index');
    }

    public function calculateMatch(Request $request)
    {
        $request->validate([
            'input1' => 'required|string',
            'input2' => 'required|string',
        ]);
        $input1 = $request->input('input1');
        $input2 = $request->input('input2');

        $result = $this->CharacterPersentageRepository->calculateMatch($input1, $input2);
        return response()->json($result);
    }
}
