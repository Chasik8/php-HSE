<?php

/**
 * Задание 5.
 * Вычисляет сумму ряда Y с заданной точностью xi.
 * Y = x/3 - x^3/15 + x^5/75 - ...
 * Общий член: a_k = (-1)^(k+1) * x^(2k-1) / (3 * 5^(k-1))
 *
 * @param float $x Значение x (по условию |x| <= 1).
 * @param float $xi Точность (эпсилон, |a_k| < xi).
 * @return array|string Ассоциативный массив с результатом или сообщение об ошибке.
 */
function calculateTask5(float $x, float $xi): array|string
{
    // 1. Валидация входных данных
    if (abs($x) > 1) {
        return "Ошибка: Модуль |x| должен быть меньше или равен 1.";
    }
    if ($xi <= 0) {
        return "Ошибка: Точность xi должна быть положительным числом.";
    }

    $Y = 0.0;
    $k = 1;
    $term = 0.0; // Текущий член ряда
    $terms_counted = 0;

    do {
        // 2. Расчет k-го члена ряда
        $sign = ($k % 2 === 1) ? 1.0 : -1.0; // (-1)^(k+1)
        $numerator = pow($x, 2 * $k - 1);
        $denominator = 3 * pow(5, $k - 1);

        // Эта проверка избыточна, т.к. 3 * 5^n никогда не 0,
        // но является хорошей практикой.
        if ($denominator == 0) {
            return "Критическая ошибка: Деление на ноль при k=$k.";
        }

        $term = $sign * $numerator / $denominator;

        // 3. Суммирование, если член ряда >= точности
        if (abs($term) >= $xi) {
            $Y += $term;
            $terms_counted++;
        }

        $k++; // Переход к следующему члену

        // 4. Условие остановки
    } while (abs($term) >= $xi);

    return [
        'Y' => $Y,
        'last_term_abs' => abs($term),
        'terms_counted' => $terms_counted
    ];
}

// --- Набор тестовых случаев ---
$test_cases = [
    ['x' => 0.5, 'xi' => 0.001],
    ['x' => 1.0, 'xi' => 0.0001],
    ['x' => -0.8, 'xi' => 0.01],
    ['x' => 2.0, 'xi' => 0.01], // Ошибочный случай: |x| > 1
    ['x' => 0.5, 'xi' => -0.01] // Ошибочный случай: xi <= 0
];

// --- Выполнение и вывод результатов ---
echo "РЕЗУЛЬТАТЫ ВЫПОЛНЕНИЯ ЗАДАНИЯ 5\n";
echo "==================================\n";

foreach ($test_cases as $index => $data) {
    echo "Тест " . ($index + 1) . ":\n";
    echo "Входные данные: x = {$data['x']}, xi = {$data['xi']}\n";

    $result = calculateTask5($data['x'], $data['xi']);

    if (is_array($result)) {
        echo "Результат:\n";
        echo "  Y = " . round($result['Y'], 8) . "\n";
        echo "  (Просуммировано членов: " . $result['terms_counted'] . ")\n";
        echo "  (Модуль последнего члена: " . round($result['last_term_abs'], 8) . " < $xi)\n";
    } else {
        echo "Результат: " . $result . "\n";
    }
    echo "----------------------------------\n";
}

?>