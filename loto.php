<?php
class Loto {
    private static $numbers = [];
    private static $nbChances = [];

    public function __construct() {
        self::$numbers = range(1, 49);
        self::$nbChances = [6 => 13983816, 7 => 85900584];
    }

    public static function findMostPopularNumbers(array $combinations): array {
        $flatNumbers = array_merge(...$combinations);
        $totalCount = count($flatNumbers);
        $numberCounts = array_count_values($flatNumbers);

        $maxPercentage = 0;
        $numberPercentages = [];

        foreach ($numberCounts as $number => $count) {
            $percentage = round(($count / $totalCount) * 100, 2);
            $numberPercentages[$number] = ['count' => $count, 'percentage' => $percentage];
            if ($percentage > $maxPercentage) {
                $maxPercentage = $percentage;
            }
        }

        $numberPercentages['mostPopular'] = array_keys(
            array_filter($numberPercentages, function ($data) use ($maxPercentage) {
                return $data['percentage'] === $maxPercentage;
            })
        );

        ksort($numberPercentages);
        return $numberPercentages;
    }

    public static function calculateEvenOddPercentages(array $combinations): array {
        $total = count($combinations);
        $stats = [];

        foreach ($combinations as $combination) {
            foreach ($combination as $pos => $num) {
                $isEven = $num % 2 === 0;
                $stats[$pos]['even'] = ($stats[$pos]['even'] ?? 0) + $isEven;
                $stats[$pos]['odd'] = ($stats[$pos]['odd'] ?? 0) + !$isEven;
            }
        }

        return array_map(function ($s) use ($total) {
            $evenPct = round(($s['even'] / $total) * 100, 2);
            $oddPct = round(($s['odd'] / $total) * 100, 2);
            return [
                'even' => $evenPct,
                'odd' => $oddPct,
                'dominant' => $evenPct > $oddPct ? 'even' : ($oddPct > $evenPct ? 'odd' : 'equal')
            ];
        }, $stats);
    }

    public static function categorizeNumbers(array $combinations): array {
        $categories = [10 => 'entier', 19 => 'dizaine', 29 => 'vintaine', 39 => 'trentaine', 49 => 'quarantaine'];

        return array_map(function ($comb) use ($categories) {
            return array_map(function ($num) use ($categories) {
                foreach ($categories as $max => $cat) {
                    if ($num <= $max) return $cat;
                }
                return 'uncategorized';
            }, $comb);
        }, $combinations);
    }

    public static function findMostCommonCategories(array $categorized): array {
        $posCats = [];

        foreach ($categorized as $comb) {
            foreach ($comb as $pos => $cat) {
                $posCats[$pos][$cat] = ($posCats[$pos][$cat] ?? 0) + 1;
            }
        }

        return array_map(function ($cats) {
            $mostCommon = array_search(max($cats), $cats);
            return [
                'category' => $mostCommon,
                'percentage' => round((max($cats) / array_sum($cats)) * 100, 2)
            ];
        }, $posCats);
    }

    public static function findMostPopularPattern(array $categorizedCombinations): array {
        $patternCounts = array_count_values(array_map(function($combination) {
            return implode(',', $combination);
        }, $categorizedCombinations));

        arsort($patternCounts);
        $mostPopularPattern = key($patternCounts);
        $occurrenceCount = reset($patternCounts);

        return [
            'pattern' => explode(',', $mostPopularPattern),
            'count' => $occurrenceCount
        ];
    }
}