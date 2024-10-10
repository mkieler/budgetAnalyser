<?php 

namespace App\Helpers;
use App\Models\AccountStatement;
use App\Models\AccountStatementLine;

trait GroupNamesAlike{
    public function prettify($mappingArray){
        foreach($mappingArray as $standardName => $currentNames){
            AccountStatementLine::whereIn('description', $currentNames)->update(['description' => $standardName]);
        }
    }

    // Names alike function
    public function namesAlike($threshold = 0.85){
        $names = $this->lines->unique('description')->pluck('description')->flatten();
        $clusters = $this->clusterNames($names, $threshold);
        $result = $this->assignStandardNames($clusters);

        $mappedGroups = $result['mappedGroups'];

        return $mappedGroups;
    }

    // Normalize function with stop words
    private function normalizeName($name) {
        $name = strtolower(trim($name));
        // Keep slashes and dots, remove other non-alphanumeric characters except spaces
        $name = preg_replace('/[^a-z0-9\s\/\.]/', '', $name);
        $name = preg_replace('/\s+/', ' ', $name);

        // Remove stop words
        $stopWords = ['bs', 'a/s', 'as', 'af', 'the', 'hilleroed'];
        $nameParts = explode(' ', $name);
        $nameParts = array_filter($nameParts, function($word) use ($stopWords) {
            return !in_array($word, $stopWords);
        });
        $name = implode(' ', $nameParts);

        return $name;
    }

    // Jaro-Winkler implementation
    private function jaroWinkler($str1, $str2) {
        // Convert to lower case
        $str1 = strtolower($str1);
        $str2 = strtolower($str2);

        // Jaro distance
        $jaro = $this->jaroDistance($str1, $str2);

        // Prefix scale
        $prefixLength = 0;
        $prefixScale = 0.1;
        $maxPrefixLength = 4;

        for ($i = 0; $i < min([$maxPrefixLength, strlen($str1), strlen($str2)]); $i++) {
            if ($str1[$i] == $str2[$i]) {
                $prefixLength++;
            } else {
                break;
            }
        }

        return $jaro + ($prefixLength * $prefixScale * (1 - $jaro));
    }

    private function jaroDistance($str1, $str2) {
        $str1_len = strlen($str1);
        $str2_len = strlen($str2);

        if ($str1_len === 0 && $str2_len === 0) {
            return 1;
        }

        $matchDistance = (int) floor(max($str1_len, $str2_len) / 2) - 1;

        $str1_matches = array_fill(0, $str1_len, false);
        $str2_matches = array_fill(0, $str2_len, false);

        $matches = 0;
        $transpositions = 0;

        // Count matches
        for ($i = 0; $i < $str1_len; $i++) {
            $start = max(0, $i - $matchDistance);
            $end = min($i + $matchDistance + 1, $str2_len);
            for ($j = $start; $j < $end; $j++) {
                if ($str2_matches[$j]) continue;
                if ($str1[$i] !== $str2[$j]) continue;
                $str1_matches[$i] = true;
                $str2_matches[$j] = true;
                $matches++;
                break;
            }
        }

        if ($matches === 0) {
            return 0;
        }

        // Count transpositions
        $k = 0;
        for ($i = 0; $i < $str1_len; $i++) {
            if (!$str1_matches[$i]) continue;
            while (!$str2_matches[$k]) {
                $k++;
            }
            if ($str1[$i] !== $str2[$k]) {
                $transpositions++;
            }
            $k++;
        }

        $transpositions /= 2.0;

        return (($matches / $str1_len) + ($matches / $str2_len) + (($matches - $transpositions) / $matches)) / 3.0;
    }

    // Clustering function
    private function clusterNames($names, $threshold = 0.85) {
        $clusters = [];
        foreach ($names as $name) {
            $normalizedName = $this->normalizeName($name);
            $found = false;
            foreach ($clusters as &$cluster) {
                $similarity = $this->jaroWinkler($normalizedName, $cluster['normalized']);
                if ($similarity >= $threshold) {
                    $cluster['names'][] = $name;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $clusters[] = [
                    'normalized' => $normalizedName,
                    'names' => [$name]
                ];
            }
        }
        return $clusters;
    }

    // Assign standard names
    private function assignStandardNames($clusters) {
        $standardized = [];
        $groups = [];
        foreach ($clusters as $cluster) {
            // Choose the most frequent name
            $nameCounts = array_count_values($cluster['names']);
            arsort($nameCounts);
            $standardName = array_key_first($nameCounts);

            foreach ($cluster['names'] as $name) {
                $standardized[$name] = $standardName;
            }

            // Group original names by their standardized names
            $groups[$standardName] = $cluster['names'];
        }

        // Filter groups with multiple original names
        $mappedGroups = array_filter($groups, function($group) {
            return count($group) > 1;
        });

        return [
            'standardized' => $standardized,
            'mappedGroups' => $mappedGroups
        ];
    }
}
