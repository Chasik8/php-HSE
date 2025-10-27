<?php

/**
 * Задание 4.
 * Вычисляет массив n по формуле n_j = m_j * S, где S = Σ(m_k^2) для k=1..7.
 *
 * @param array $m Массив из 7 числовых элементов (m_1, ..., m_7).
 * @return array|string Массив n (n_1, ..., n_7) или сообщение об ошибке.
 */
function calculateTask4(array $m): array|string
{
    // 1. Валидация входных данных
    if (count($m) !== 7) {
        return "Ошибка: Входной массив m должен содержать ровно 7 элементов.";
    }

    foreach ($m as $value) {
        if (!is_numeric($value)) {
            return "Ошибка: Все элементы массива m должны быть числами.";
        }
    }

    // 2. Вычисление S = Σ(m_k^2)
    $S = 0.0;
    foreach ($m as $value) {
        $S += $value ** 2; // $value * $value
    }

    // 3. Вычисление массива n
    $n = [];
    foreach ($m as $mj) {
        $n[] = $mj * $S;
    }

    // Возвращаем ассоциативный массив для ясности
    return [
        'S' => $S,
        'n' => $n
    ];
}

// --- Набор тестовых случаев ---
$test_cases = [
    ['m' => [1, 2, 3, 4, 5, 6, 7]],
    ['m' => [1, 0, 1, 0, 1, 0, 1]],
    ['m' => [0.1, 0.2, -0.3, 0.4, 0.5, -0.6, 0.7]],
    ['m' => [1, 2, 3]] // Ошибочный случай
];

// --- Выполнение и вывод результатов ---
echo "РЕЗУЛЬТАТЫ ВЫПОЛНЕНИЯ ЗАДАНИЯ 4\n";
echo "==================================\n";

foreach ($test_cases as $index => $data) {
    echo "Тест " . ($index + 1) . ":\n";
    echo "Входные данные: m = [" . implode(", ", $data['m']) . "]\n";

    $result = calculateTask4($data['m']);

    if (is_array($result)) {
        echo "Результат:\n";
        echo "  Сумма квадратов S = " . round($result['S'], 4) . "\n";
        echo "  Массив n = [" . implode(", ", array_map(fn($val) => round($val, 4), $result['n'])) . "]\n";
    } else {
        echo "Результат: " . $result . "\n";
    }
    echo "----------------------------------\n";
}

?>