<?php

/**
 * Функция для вычисления значений B и Y по заданным формулам.
 *
 * @param float $a Первое число.
 * @param float $b Второе число.
 * @param float $k Третье число (знаменатель).
 * @return array|string Массив с результатами ['B' => ..., 'Y' => ...] или сообщение об ошибке.
 */
function calculateTask1(float $a, float $b, float $k): array|string
{
    if ($k == 0) {
        return "Ошибка: Деление на ноль невозможно (k не может быть равно 0).";
    }

    $b_val = (($a - $b) ** 2) / ($k ** 2);

    $y_val = ($b_val ** 3) - sqrt(abs($b_val - $k));

    return [
        'B' => $b_val,
        'Y' => $y_val
    ];
}

$test_cases = [
    ['a' => 5, 'b' => 3, 'k' => 2],
    ['a' => 2, 'b' => 6, 'k' => 2],
    ['a' => 10, 'b' => 10, 'k' => 5],
    ['a' => 5, 'b' => 3, 'k' => 0]
];

echo "РЕЗУЛЬТАТЫ ВЫПОЛНЕНИЯ ЗАДАНИЯ 1\n";
echo "==================================\n";

foreach ($test_cases as $index => $data) {
    echo "Тест " . ($index + 1) . ":\n";
    echo "Входные данные: a = {$data['a']}, b = {$data['b']}, k = {$data['k']}\n";

    $result = calculateTask1($data['a'], $data['b'], $data['k']);

    if (is_array($result)) {
        echo "Результат: B = " . round($result['B'], 4) . ", Y = " . round($result['Y'], 4) . "\n";
    } else {
        echo "Результат: " . $result . "\n";
    }
    echo "----------------------------------\n";
}

?>