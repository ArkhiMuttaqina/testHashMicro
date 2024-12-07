<?php

namespace App\Repositories\Contracts;

interface CharacterPersentageRepositoryInterface
{
    public function calculateMatch(string $input1, string $input2): array;
}
