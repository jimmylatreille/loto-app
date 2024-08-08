<?php

class Loto {
    private static $numbers = [];
    private static $nbChances = [6 => 13983816, 7 => 85900584];

    public function __construct() {
        self::$numbers = range(1, 49);
    }

    public static function findMostPopularNumbers(array $combinations): array {
        $flatNumbers = array_merge(...$combinations);
        $numberCounts = array_count_values($flatNumbers);
        $totalCount = count($flatNumbers);

        $numberPercentages = array_map(function($count) use ($totalCount) {
            return ['count' => $count, 'percentage' => round(($count / $totalCount) * 100, 2)];
        }, $numberCounts);

        $maxPercentage = max(array_column($numberPercentages, 'percentage'));
        $numberPercentages['mostPopular'] = array_keys(array_filter($numberPercentages, function($data) use ($maxPercentage) {
            return $data['percentage'] === $maxPercentage;
        }));

        ksort($numberPercentages);
        return $numberPercentages;
    }

    public static function calculateEvenOddPercentages(array $combinations): array {
        $total = count($combinations);
        $stats = array_fill(0, count($combinations[0]), ['even' => 0, 'odd' => 0]);

        foreach ($combinations as $combination) {
            foreach ($combination as $pos => $num) {
                $stats[$pos][$num % 2 ? 'odd' : 'even']++;
            }
        }

        return array_map(function($s) use ($total) {
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
        return array_map(function($comb) use ($categories) {
            return array_map(function($num) use ($categories) {
                foreach ($categories as $max => $cat) {
                    if ($num <= $max) return $cat;
                }
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

        $mostCommonCategories = array_map(function($cats) {
            $total = array_sum($cats);
            $mostCommon = array_search(max($cats), $cats);
            return [
                'category' => $mostCommon,
                'percentage' => round((max($cats) / $total) * 100, 2)
            ];
        }, $posCats);

        $allCategoriesInOrder = array_map(function($cats) {
            arsort($cats);
            return $cats;
        }, $posCats);

        return [
            'mostCommonCategories' => $mostCommonCategories,
            'allCategoriesInOrder' => $allCategoriesInOrder
        ];
    }

    public static function findMostPopularPattern(array $categorizedCombinations): array {
        $patterns = array_count_values(array_map('implode', array_fill(0, count($categorizedCombinations), ','), $categorizedCombinations));
        arsort($patterns);
        $mostPopularPattern = explode(',', key($patterns));
        return ['pattern' => $mostPopularPattern, 'count' => reset($patterns)];
    }

    public static function findNumberFrequencyByPosition(array $combinations): array {
        $positionCounts = [];
        foreach ($combinations as $combination) {
            foreach ($combination as $pos => $num) {
                $positionCounts[$pos][$num] = ($positionCounts[$pos][$num] ?? 0) + 1;
            }
        }

        return array_map(function($counts) {
            $total = array_sum($counts);
            $percentages = array_map(function($count) use ($total) {
                return ['count' => $count, 'percentage' => round(($count / $total) * 100, 2)];
            }, $counts);
            arsort($percentages);
            return array_slice($percentages, 0, 7, true);
        }, $positionCounts);
    }
}
