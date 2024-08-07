<?php

class Loto {
    private static $numbers = [];
    private static $nbChances = [];

    public function __construct() {
        self::$numbers = range(1, 49);
        self::$nbChances = [6 => 13983816, 7 => 85900584];
    }

    /**
     * Calculates the percentage of even and odd numbers for each position in the combinations.
     *
     * @param array $combinations An array of combinations where each combination is an array of numbers.
     * @return array An array containing the even and odd counts, percentages, and dominant type for each position.
     */
    public static function calculateEvenOddPercentages(array $combinations): array {
        $total = count($combinations);
        $stats = [];

        foreach ($combinations as $combination) {
            foreach ($combination as $pos => $num) {
                $isEven = $num % 2 === 0;
                $stats[$pos]['even'] = ($stats[$pos]['even'] ?? 0) + (int)$isEven;
                $stats[$pos]['odd'] = ($stats[$pos]['odd'] ?? 0) + (int)!$isEven;
            }
        }

        return array_map(function ($s) use ($total) {
            $evenPct = $total ? round(($s['even'] / $total) * 100, 2) : 0;
            $oddPct = $total ? round(($s['odd'] / $total) * 100, 2) : 0;
            return [
                'even' => ['count' => $s['even'], 'percentage' => $evenPct],
                'odd' => ['count' => $s['odd'], 'percentage' => $oddPct],
                'dominant' => $evenPct > $oddPct ? 'even' : ($oddPct > $evenPct ? 'odd' : 'equal')
            ];
        }, $stats);
    }

    /**
     * Categorizes numbers in each combination based on predefined ranges.
     *
     * @param array $combinations An array of combinations where each combination is an array of numbers.
     * @return array An array where each number is categorized into 'entier', 'dizaine', 'vintaine', 'trentaine', or 'quarantaine'.
     */
    public static function categorizeNumbers(array $combinations): array {
        $categories = [10 => 'entier', 19 => 'dizaine', 29 => 'vintaine', 39 => 'trentaine', 49 => 'quarantaine'];

        return array_map(function ($comb) use ($categories) {
            return array_map(function ($num) use ($categories) {
                foreach ($categories as $max => $cat) if ($num <= $max) return $cat;
                return 'uncategorized';
            }, $comb);
        }, $combinations);
    }

    /**
     * Finds the most common category for each position in the categorized combinations.
     *
     * @param array $categorized An array of categorized combinations where each combination is an array of categories.
     * @return array An array containing the most common category and its percentage for each position.
     */
    public static function findMostCommonCategories(array $categorized): array {
        $posCats = $totals = [];

        foreach ($categorized as $comb) {
            foreach ($comb as $pos => $cat) {
                $posCats[$pos][$cat] = ($posCats[$pos][$cat] ?? 0) + 1;
                $totals[$pos] = ($totals[$pos] ?? 0) + 1;
            }
        }

        return array_map(function ($cats, $total) {
            $mostCommon = array_search(max($cats), $cats);
            return [
                'category' => $mostCommon,
                'percentage' => round(($cats[$mostCommon] / $total) * 100, 2)
            ];
        }, $posCats, $totals);
    }
}
