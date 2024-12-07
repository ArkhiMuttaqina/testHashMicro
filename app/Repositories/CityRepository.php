<?php

namespace App\Repositories;

use App\Models\cities;
use App\Models\Departments;
use App\Models\JobTitles;
use App\Repositories\Contracts\CityRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CityRepository implements CityRepositoryInterface
{
    public function getPaginatedCities($search, $perPage, $page)
    {
        $query = cities::select('id', 'name');

        if (!empty($search)) {
            $query->where('name', 'LIKE', '%' . strtoupper($search) . '%');
        }

        $total = $query->count();
        $data = $query
            ->offset(($page - 1) * $perPage)
            ->limit($perPage)
            ->get();

        return [
            'data' => $data,
            'pagination' => [
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $page,
                'last_page' => ceil($total / $perPage),
            ]
        ];
    }
}
