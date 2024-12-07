<?php

namespace App\Repositories;

use App\Repositories\Contracts\CharacterPersentageRepositoryInterface;

class CharacterPersentageRepository implements CharacterPersentageRepositoryInterface
{
    public function calculateMatch(string $input1, string $input2): array
    {
        $uniqueCharsInput1 = array_unique(str_split($input1));
        $matchCount = 0;
        foreach ($uniqueCharsInput1 as $char) {
            if (strpos($input2, $char) !== false) {
                $matchCount++;
            }
        }
        $totalUniqueChars = count($uniqueCharsInput1);
        $percentage = ($totalUniqueChars > 0) ? ($matchCount / $totalUniqueChars) * 100 : 0;
        return [
            'percentage' => round($percentage, 2),
            'matched_characters' => $matchCount,
            'total_characters' => $totalUniqueChars,
        ];
    }
}
