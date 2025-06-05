<?php

namespace App\Helpers;

class KNN {
    // Predict
    public static function predict($currTemperature, $currPH, $currTurbidity, $currDissolvedSolids){
        $temperatures = [2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 3, 3, 4, 5, 5, 10, 5, 7, 6, 5, 8, 15, 17, 17, 20, 23, 24, 25, 28, 8, 12, 16, 17, 17, 24, 24, 21, 21, 11, 33, 35, 38, 35, 35, 35, 35, 35, 35, 35, 35];
        $phs = [7.98, 7.81, 7.96, 7.94, 7.92, 7.90, 7.90, 7.89, 7.87, 6.89, 6.65, 7.23, 7.09, 7.77, 6.55, 7.96, 7.61, 7.82, 8.14, 7.6, 9.69, 8.3, 8.3, 8.3, 7.9, 7.9, 7.4, 7.6, 7.6, 5.53, 5.44, 8.6, 8.7, 8.7, 7.7, 10.71, 4.90, 6.21, 9.75, 9.20, 4.50, 10.00, 4.63, 4.78, 4.85, 4.92, 5.00, 5.07, 5.14, 5.20];
        $tdss = [96, 177, 103, 110, 118, 125, 132, 139, 146, 172, 37, 28, 50, 64, 445, 100, 350, 96, 376, 242, 271, 480, 490, 490, 550, 560, 260, 280, 500, 564, 570, 750, 550, 520, 420, 524, 514, 376, 140, 2200, 1500, 2500, 1555, 1610, 1635, 1660, 1685, 1710, 1735, 1760];
        $turbidities = [0.03, 0.10, 0.04, 0.04, 0.05, 0.06, 0.07, 0.07, 0.08, 0.4, 0.26, 0.86, 1.07, 0.67, 0.01, 0.17, 2.41, 0.13, 1.05, 0.04, 0.04, 3.4, 2.77, 3.59, 3.2, 1.3, 7.41, 13.00, 1.64, 0, 0.32, 25.2, 212, 81, 137, 0.02, 9.39, 15.31, 16.45, 60.00, 70.00, 100.00, 72.5, 75.5, 76.9, 78.3, 79.7, 81.1, 82.5, 83.9];
        $labels = [95.188, 92.6056, 93.0496, 92.6608, 92.6608, 92.4664, 92.4664, 92.8832, 92.8832, 91.8832, 86.8267, 89.9107, 88.1881, 85.2991, 75.9952, 74.7431, 73.9681, 80.4652, 71.4947, 81.9664, 56.7968, 56.9396, 56.4674, 55.912, 59.4402, 59.7179, 66.0506, 62.0792, 63.0786, 52.2152, 45.1603, 44.7195, 29.3623, 34.9163, 39.5295, 39.2414, 36.6331, 49.2732, 46.6318, 30.6645, 21.3583, 19.8037, 21.9974, 22.303, 22.6086, 22.6365, 22.9421, 22.6644, 22.97, 23.2756];
        $labels = [
            'Excellent','Excellent','Excellent','Excellent','Excellent','Excellent','Excellent','Excellent','Excellent','Excellent',
            'Good','Good','Good','Good','Good','Good','Good','Good','Good','Good',
            'Moderate','Moderate','Moderate','Moderate','Moderate','Moderate','Moderate','Moderate','Moderate','Moderate',
            'Bad','Bad','Bad','Bad','Bad','Bad','Bad','Bad','Bad','Bad',
            'Very Bad','Very Bad','Very Bad','Very Bad','Very Bad','Very Bad','Very Bad','Very Bad','Very Bad','Very Bad'
        ];

        $k = 7;
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


