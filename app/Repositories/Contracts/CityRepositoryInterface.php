<?php

namespace App\Repositories\Contracts;

interface CityRepositoryInterface
{
    public function getPaginatedCities($search, $perPage, $page);
}
