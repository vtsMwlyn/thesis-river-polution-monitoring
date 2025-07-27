@extends('layouts.app')

@section('content')
    <x-section-container>
        @php
            $classes = ['Excellent', 'Good', 'Moderate', 'Bad', 'Very Bad'];
            $true_labels = $labels['true'];
            $predicted_labels = $labels['predicted'];

            // Initialize the confusion matrix
            $confusionMatrix = [];
            foreach ($classes as $actual) {
                foreach ($classes as $predicted) {
                    $confusionMatrix[$actual][$predicted] = 0;
                }
            }

            // Populate the confusion matrix
            foreach ($true_labels as $index => $actual) {
                $predicted = $predicted_labels[$index];
                $confusionMatrix[$actual][$predicted]++;
            }

            $total = 0;
            $correct = 0;
            $precision = [];
            $recall = [];
            $f1 = [];

            foreach ($classes as $class) {
                $tp = $confusionMatrix[$class][$class];
                $fp = 0;
                $fn = 0;

                foreach ($classes as $other) {
                    if ($other !== $class) {
                        $fp += $confusionMatrix[$other][$class]; // predicted as class, but should be other
                        $fn += $confusionMatrix[$class][$other]; // should be class, predicted as other
                    }
                }

                $precision[$class] = ($tp + $fp) > 0 ? round($tp / ($tp + $fp), 2) : 0;
                $recall[$class] = ($tp + $fn) > 0 ? round($tp / ($tp + $fn), 2) : 0;
                $f1[$class] = ($precision[$class] + $recall[$class]) > 0
                    ? round(2 * $precision[$class] * $recall[$class] / ($precision[$class] + $recall[$class]), 2)
                    : 0;

                $total += array_sum($confusionMatrix[$class]);
                $correct += $tp;
            }

            $accuracy = $total > 0 ? round($correct / $total, 2) : 0;
        @endphp

        <h2 class="text-xl font-bold mb-4">Confusion Matrix</h2>
        <table class="table-auto border border-collapse border-gray-400">
            <thead>
                <tr>
                    <th class="border px-2 py-1">Actual \ Predicted</th>
                    @foreach ($classes as $predicted)
                        <th class="border px-2 py-1">{{ $predicted }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($classes as $actual)
                    <tr>
                        <td class="border px-2 py-1 font-semibold">{{ $actual }}</td>
                        @foreach ($classes as $predicted)
                            <td class="border px-2 py-1 text-center">
                                {{ $confusionMatrix[$actual][$predicted] }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>


        <h2 class="text-xl font-bold mt-8 mb-4">Evaluation Metrics</h2>
        <table class="table-auto border border-collapse border-gray-400 mb-4">
            <thead>
                <tr>
                    <th class="border px-2 py-1">Class</th>
                    <th class="border px-2 py-1">Precision</th>
                    <th class="border px-2 py-1">Recall</th>
                    <th class="border px-2 py-1">F1-Score</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($classes as $class)
                    <tr>
                        <td class="border px-2 py-1 font-semibold">{{ $class }}</td>
                        <td class="border px-2 py-1 text-center">{{ number_format($precision[$class] * 100, 2) }}%</td>
                        <td class="border px-2 py-1 text-center">{{ number_format($recall[$class] * 100, 2) }}%</td>
                        <td class="border px-2 py-1 text-center">{{ number_format($f1[$class] * 100, 2) }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p class="font-semibold">Overall Accuracy: <span class="text-blue-600">{{ number_format($accuracy * 100, 2) }}%</span></p>

    </x-section-container>
@endsection
