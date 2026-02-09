<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MonitorController extends Controller
{
    // Путь к файлу хранения данных
    private $filePath = 'public/monitors.json';

    /**
     * Отображает главную страницу с формой.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('monitor');
    }

    /**
     * Сохраняет данные монитора в JSON-файл.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        // Валидация входных данных (минимум 5 полей обязательны для сохранения)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'releaseDate' => 'required|date',
            'matrix' => 'required|string|max:50',
            'resolution' => 'required|string|max:50',
            'refreshRate' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        try {
            // Чтение существующих данных из файла
            $monitors = $this->getMonitorsFromFile();

            // Добавление нового монитора с уникальным ID
            $newMonitor = $validated;
            $newMonitor['id'] = count($monitors) + 1;
            $monitors[] = $newMonitor;

            // Сохранение обратно в файл
            Storage::put($this->filePath, json_encode($monitors, JSON_PRETTY_PRINT));

            return redirect()->route('monitor.index')->with('success', 'Монитор успешно сохранен!');
        } catch (\Exception $e) {
            return redirect()->route('monitor.index')->with('error', 'Ошибка сохранения: ' . $e->getMessage());
        }
    }

    /**
     * Ищет мониторы по введенным параметрам.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function find(Request $request)
    {
        // Получаем данные из формы
        $search = $request->only(['name', 'price', 'releaseDate', 'matrix', 'resolution', 'refreshRate', 'description']);

        // Чтение всех мониторов из файла
        $monitors = $this->getMonitorsFromFile();

        // Фильтрация
        $found = array_filter($monitors, function ($monitor) use ($search) {
            foreach ($search as $key => $value) {
                if (!empty($value) && stripos($monitor[$key] ?? '', $value) === false) {
                    return false;
                }
            }
            return true;
        });

        // Отображаем результаты в том же шаблоне
        return view('monitor', [
            'found' => $found,
            'message' => empty($found) ? 'Мониторы с заданными параметрами не найдены.' : null,
        ]);
    }

    /**
     * Вспомогательный метод: Читает данные из JSON-файла.
     *
     * @return array
     */
    private function getMonitorsFromFile()
    {
        if (Storage::exists($this->filePath)) {
            return json_decode(Storage::get($this->filePath), true) ?? [];
        }
        return [];
    }
}
