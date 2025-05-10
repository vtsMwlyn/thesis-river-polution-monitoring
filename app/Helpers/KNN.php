<?php

namespace App\Helpers;

class KNN {
    // Predict
    public static function predict($currTemperature, $currPH, $currTurbidity, $currDissolvedSolids){
        $temperatures = [2, 2, 3, 3, 4, 5, 5, 10, 8, 15, 17, 17, 20, 23, 24, 25, 28, 12, 16, 17, 17, 17, 24, 24, 21, 21, 11, 33, 35, 38];
        $phs = [7.98, 7.81, 6.65, 7.23, 7.09, 7.77, 6.55, 7.96, 9.69, 8.3, 8.3, 8.3, 7.9, 7.9, 7.4, 7.6, 7.6, 5.44, 8.6, 8.7, 8.7, 3.67, 7.7, 10.71, 4.90, 6.21, 9.75, 9.20, 4.50, 10.00];
        $turbidities = [0.03, 0.1, 0.26, 0.86, 1.07, 0.67, 0.01, 0.17, 0.04, 3.4, 2.77, 3.59, 3.2, 1.3, 7.41, 13, 1.64, 0.32, 25.2, 212, 81, 5.21, 137, 0.02, 9.39, 15.31, 16.45, 60, 70, 100];
        $tdss = [96, 177, 37, 28, 50, 64, 445, 100, 271, 480, 490, 490, 550, 560, 260, 280, 500, 570, 750, 550, 520, 522, 420, 524, 514, 376, 140, 2200, 1500, 2500];
        $labels = ['Excellent', 'Excellent', 'Good', 'Good', 'Good', 'Good', 'Good', 'Good', 'Moderate', 'Moderate', 'Moderate', 'Moderate', 'Moderate', 'Moderate', 'Moderate', 'Moderate', 'Moderate', 'Bad', 'Bad', 'Bad', 'Bad', 'Bad', 'Bad', 'Bad', 'Bad', 'Bad', 'Bad', 'Bad', 'Very Bad', 'Very Bad'];

        $k = 5;
        $distances = [];

        foreach($temperatures as $i => $temp){
            $temp2 = pow($temp - $currTemperature, 2);
            $pH2 = pow($phs[$i] - $currPH, 2);
            $tds2 = pow($tdss[$i] - $currDissolvedSolids, 2);
            $turbidity2 = pow($turbidities[$i] - $currTurbidity, 2);

            $distance = sqrt($temp2 + $pH2 + $tds2 + $turbidity2);
            array_push($distances, ['quality' => $labels[$i], 'distance' => $distance]);
        }
        usort($distances, fn($a, $b) => $a['distance'] <=> $b['distance']);

        $nearestNeighbors = array_slice($distances, 0, $k);
        $qualities = array_count_values(array_column($nearestNeighbors, 'quality'));
        arsort($qualities);

        return array_key_first($qualities);
    }
}


