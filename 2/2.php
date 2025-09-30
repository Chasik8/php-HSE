<?php

/**
 * Функция для вычисления значений M, S и f(S) по заданным формулам.
 *
 * @param float $a
 * @param float $b
 * @param float $c
 * @return array|string Массив с результатами или сообщение об ошибке.
 */
function calculateTask2(float $a, float $b, float $c): array|string
{
    $m_val = ($a ** 2 - $c ** 2) * ($a - $b);

    $s_val = 0;
    if ($m_val >= 0 && $m_val <= 5) {
        if ($a == 0 || $c == 0) {
            return "Ошибка: Деление на ноль при вычислении S (a или c равно 0).";
        }
        $s_val = $m_val / ($a * $c);
    } else {
        $s_val = ($a - $c) * $m_val;
    }

    $f_val = 0;
    if ($s_val == $m_val) {
        if ($c == 0) {
            return "Ошибка: Деление на ноль при вычислении f(S) (c равно 0).";
        }
        $f_val = ($a * $b * $s_val) / $c;
    } else {
        $f_val = $s_val - $m_val;
    }

    return [
        'M' => $m_val,
        'S' => $s_val,
        'f(S)' => $f_val,
    ];
}

$test_cases = [
    ['a' => 2, 'b' => 1, 'c' => 1.5],
    ['a' => 4, 'b' => 1, 'c' => 2],
    ['a' => 3, 'b' => 1, 'c' => 2],
    ['a' => 2, 'b' => 1, 'c' => 0]
];

echo "РЕЗУЛЬТАТЫ ВЫПОЛНЕНИЯ ЗАДАНИЯ 2\n";
echo "==================================\n";

foreach ($test_cases as $index => $data) {
    echo "Тест " . ($index + 1) . ":\n";
    echo "Входные данные: a = {$data['a']}, b = {$data['b']}, c = {$data['c']}\n";

    $result = calculateTask2($data['a'], $data['b'], $data['c']);

    if (is_array($result)) {
        echo "Результат: M = " . round($result['M'], 4) .
            ", S = " . round($result['S'], 4) .
            ", f(S) = " . round($result['f(S)'], 4) . "\n";
    } else {
        echo "Результат: " . $result . "\n";
    }
    echo "----------------------------------\n";
}
?>