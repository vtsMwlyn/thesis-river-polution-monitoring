<?php

namespace App\Helpers;

class KNN {
    // Predict
    public static function predict($currTemperature, $currPH, $currTurbidity, $currDissolvedSolids){
        $temperatures = [
            2, 2, 2, 2.4, 1.4, 2.3, 2.6, 1, 2.5, 1.8, 2.2, 1.9, 2.3, 1.7, 2.1, 2.4, 2.05, 2.35, 2.5, 2, 1.85, 2.15, 2.25, 1.95, 2.3, 2.1, 2.2, 1.9, 2.35, 2.45, 2.05, 1.8, 2, 2.25, 3, 3, 4, 5, 5, 10, 5, 7, 6, 5, 12, 6, 6, 16, 26, 1, 1, 1, 2, 2, 2, 2, 2, 3, 3, 3, 4, 4, 4, 6, 6, 7, 7, 8, 8, 15, 17, 17, 20, 23, 24, 25, 28, 8, 18, 20, 21, 22, 7, 45, 8, 7, 28, 33, 10, 10, 8, 21, 16, 23, 13, 28, 30, 32, 8, 9, 32, 7, 12, 16, 17, 17, 24, 24, 21, 21, 11, 33, 24, 16, 29, 11, 24, 21, 9, 15, 19, 23, 19, 10, 22, 27, 24, 27, 12, 21, 16, 15, 39, 30, 42, 35, 35, 38, 13, 20, 11, 25, 35, 35, 35, 35, 35.5, 34, 35, 36.5, 12, 30, 35, 24, 32, 34, 36, 27, 33, 28, 35, 34.5, 31, 34, 35, 35, 13, 34, 20, 35
        ];

        $phs = [
            7.98, 7.81, 6.89, 7.1, 6.85, 8.01, 7.4, 7.50, 8.00, 6.50, 7.9, 7.33, 6.95, 6.75, 7.2, 7.75, 7.85, 7, 7.1, 7.6, 6.9, 7.4, 7.5, 6.8, 7.95, 7.35, 7.25, 7.1, 7.8, 7.65, 6.95, 6.6, 7, 7.5, 6.65, 7.23, 7.09, 7.77, 6.55, 7.96, 7.61, 7.82, 8.14, 7.6, 6.65, 7.24, 7.24, 6.81, 7.86, 6.55, 7.52, 7.71, 6.13, 6.14, 6.15, 6.17, 6.18, 6.7, 6.7, 6.71, 8.42, 8.42, 8.42, 7.71, 7.71, 8.04, 8.05, 8.8, 9.69, 8.3, 8.3, 8.3, 7.9, 7.9, 7.4, 7.6, 7.6, 5.53, 6.71, 7.98, 8.23, 6.01, 7.6, 5.5, 5.5, 8.15, 6.31, 6.78, 8.55, 7.01, 7.41, 7.92, 6.52, 7.21, 7.31, 8.24, 8.69, 5.41, 6.36, 5.5, 5.5, 6.38, 5.44, 8.6, 8.7, 8.7, 7.7, 10.71, 4.90, 6.21, 9.75, 9.20, 6.33, 5.93, 4.98, 9.75, 8.72, 5.53, 3.93, 6.09, 8.66, 4.2, 4.29, 3.31, 3.63, 4.5, 9.55, 5.38, 5.33, 4.9, 10.23, 4.79, 5.76, 5.11, 9.72, 5.26, 4.50, 10.00, 12.43, 1.89, 13.91, 13.21, 5, 5.07, 5.14, 5.2, 4.78, 5, 5.11, 9.95, 13.2, 5.1, 5.03, 12.2, 5.15, 5.18, 4.6, 11, 4.9, 5, 5.17, 4.95, 12, 5.17, 5.12, 5.08, 13, 4.55, 2.5, 5.05
        ];

        $tdss = [
            96, 177, 172, 47, 55, 74, 51, 46, 69, 58, 115, 59, 65, 52, 70, 150, 138, 62, 90, 100, 50, 83, 97, 58, 110, 69, 76, 49, 130, 115, 57, 55, 73, 90, 37, 28, 50, 64, 445, 100, 350, 96, 376, 242, 75, 95, 95, 41, 19, 223, 360, 182, 204, 546, 351, 553, 364, 46, 477, 209, 226, 455, 134, 431, 104, 167, 317, 64, 271, 480, 490, 490, 550, 560, 260, 280, 500, 564, 22, 531, 485, 28, 273, 384, 380, 80, 348, 418, 171, 422, 282, 21, 580, 226, 304, 76, 62, 267, 128, 237, 236, 142, 570, 750, 550, 520, 420, 524, 514, 376, 140, 2200, 414, 467, 70, 140, 415, 102, 43, 407, 471, 269, 2, 12, 13, 251, 315, 554, 415, 514, 424, 332, 452, 516, 362, 317, 1500, 2500, 648, 523, 830, 801, 1685, 1710, 1735, 1760, 1605, 1700, 1720, 2400, 700, 1620, 1695, 750, 1705, 1750, 1580, 800, 1650, 1680, 1742, 1722, 765, 1625, 1730, 1702, 810, 1520, 600, 1708
        ];

        $turbidities = [
            0.03, 0.10, 0.4, 0.5, 3.53, 1.09, 1.05, 0.00, 0.12, 0.07, 0.07, 0.27, 0.8, 0.56, 1.02, 0.1, 0.06, 1.01, 0.75, 0.12, 0.25, 0.91, 0.43, 0.65, 0.04, 0.52, 0.82, 0.3, 0.06, 0.08, 0.71, 0.4, 0.94, 0.58, 0.26, 0.86, 1.07, 0.67, 0.01, 0.17, 2.41, 0.13, 1.05, 0.04, 0.65, 18.59, 18.59, 0.96, 0.14, 0.06, 0.45, 2.6, 0.02, 0.04, 0.09, 3.29, 7.28, 0.01, 0.82, 0, 0.06, 0.02, 0.1, 0.15, 0.43, 0.4, 0.27, 0.32, 0.04, 3.40, 2.77, 3.59, 3.20, 1.30, 7.41, 13.00, 1.64, 0, 18.05, 17.59, 16.97, 16.58, 16.45, 0.01, 1.02, 13.08, 13.07, 12.96, 12.88, 12.86, 12.85, 8.91, 8.9, 12.75, 12.72, 12.7, 12.69, 1.65, 12.54, 0.1, 1.62, 9.37, 0.32, 25.20, 212.00, 81.00, 137.00, 0.02, 9.39, 15.31, 16.45, 60.00, 19.3, 18.78, 16.57, 16.45, 16.3, 13.06, 13.01, 13.01, 12.95, 3, 3, 2.7, 2.7, 12.65, 12.6, 1.65, 9.4, 9.39, 5, 4.99, 6.48, 9.37, 5.61, 5.6, 70.00, 100.00, 73, 119, 91, 98, 79.7, 81.1, 82.5, 83.9, 78, 80, 81.7, 95, 85, 80.4, 80.5, 90, 81.8, 83, 75, 92, 79, 78.5, 82.8, 82.1, 89, 80, 82, 81.3, 88, 76, 100, 81
        ];

        $labels = [
            "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Excellent", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Good", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Moderate", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad", "Very Bad"
        ];

        $k = 15;
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

    public static function confusion_matrix(){
        $temperatures = [
            1.95, 2.15, 2, 2.4, 2.1, 2.3, 8, 9, 9, 10, 10, 12,
            27, 9, 11, 35, 28, 15, 23, 12, 19, 22, 13, 6,
            32, 35, 25, 36, 34.5, 35
        ];

        $phs = [
            7.15, 7.45, 7.6, 7.3, 6.85, 7.7, 8.81, 7.31, 7.31, 8.09, 8.09, 6.54,
            7.29, 7.38, 9.58, 7.2, 7.2, 5.5, 5.45, 4.99, 5, 2.54, 2.54, 2.56,
            5.18, 5.13, 12.7, 5.2, 5.06, 5.09
        ];

        $tdss = [
            66, 101, 122, 105, 60, 126, 75, 225, 50, 11, 33, 49,
            5, 500, 168, 483, 293, 211, 189, 360, 438, 465, 214, 490,
            1718, 1740, 790, 1775, 1720, 1715
        ];

        $turbidities = [
            0.78, 0.49, 0.33, 0.69, 0.85, 0.08, 0.02, 0.03, 0.01, 0.53, 0.02, 0.03,
            5.3, 5.3, 9.36, 0.33, 1.15, 0.08, 5.6, 0.76, 1.93, 1.58, 0.02, 0.26,
            82.3, 82.6, 95, 84.2, 81.6, 81.2
        ];

        $true_labels = [
            'Excellent', 'Excellent', 'Excellent', 'Excellent', 'Excellent', 'Excellent',
            'Good', 'Good', 'Good', 'Good', 'Good', 'Good',
            'Moderate', 'Moderate', 'Moderate', 'Moderate', 'Moderate', 'Moderate',
            'Bad', 'Bad', 'Bad', 'Bad', 'Bad', 'Bad',
            'Very Bad', 'Very Bad', 'Very Bad', 'Very Bad', 'Very Bad', 'Very Bad'
        ];

        $predicted_labels = [];

        foreach($temperatures as $i => $temp){
            $predicted_labels[] = KNN::predict($temp, $phs[$i], $tdss[$i], $turbidities[$i]);
        }

        return [
            'true' => $true_labels,
            'predicted' => $predicted_labels
        ];
    }
}


