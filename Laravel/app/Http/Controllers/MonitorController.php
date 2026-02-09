<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MonitorController extends Controller
{
    // Путь к файлу хранения данных
    private $filePath = 'public/monitors.json';

    /**
     * Отображает главную страницу с формой и списком мониторов.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $monitors = $this->getMonitorsFromFile();
        return view('monitor', ['monitors' => $monitors]);
    }

    /**
     * Сохраняет или обновляет данные монитора в JSON-файл.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        // Валидация
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
            $monitors = $this->getMonitorsFromFile();
            $id = $request->input('id');

            if ($id) {
                foreach ($monitors as &$monitor) {
                    if ($monitor['id'] == $id) {
                        $monitor = array_merge($monitor, $validated);
                        break;
                    }
                }
            } else {
                $validated['id'] = count($monitors) + 1;
                $monitors[] = $validated;
            }

            Storage::put($this->filePath, json_encode($monitors, JSON_PRETTY_PRINT));

            return redirect()->route('monitor.index')->with('success', $id ? 'Монитор обновлён!' : 'Монитор сохранён!');
        } catch (\Exception $e) {
            return redirect()->route('monitor.index')->with('error', 'Ошибка: ' . $e->getMessage());
        }
    }

    /**
     * Ищет мониторы по параметрам
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function find(Request $request)
    {
        $search = $request->only(['name', 'price_min', 'price_max', 'releaseDate', 'matrix', 'resolution', 'refreshRate', 'description']); // Добавили price_min/max

        $monitors = $this->getMonitorsFromFile();

        $found = array_filter($monitors, function ($monitor) use ($search) {
            if (!empty($search['name']) && stripos($monitor['name'], $search['name']) === false) return false;
            if (!empty($search['price_min']) && $monitor['price'] < $search['price_min']) return false;
            if (!empty($search['price_max']) && $monitor['price'] > $search['price_max']) return false;
            if (!empty($search['releaseDate']) && $monitor['releaseDate'] != $search['releaseDate']) return false;
            if (!empty($search['matrix']) && stripos($monitor['matrix'], $search['matrix']) === false) return false;
            if (!empty($search['resolution']) && stripos($monitor['resolution'], $search['resolution']) === false) return false;
            if (!empty($search['refreshRate']) && $monitor['refreshRate'] != $search['refreshRate']) return false;
            if (!empty($search['description']) && stripos($monitor['description'], $search['description']) === false) return false;
            return true;
        });

        return view('monitor', [
            'monitors' => $this->getMonitorsFromFile(), // Полный список для отображения
            'found' => $found,
            'message' => empty($found) ? 'Не найдено.' : null,
        ]);
    }

    /**
     * Удаляет монитор по ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        try {
            $monitors = $this->getMonitorsFromFile();
            $monitors = array_filter($monitors, fn($m) => $m['id'] != $id);
            $monitors = array_values($monitors); // Переиндексация
            Storage::put($this->filePath, json_encode($monitors, JSON_PRETTY_PRINT));
            return redirect()->route('monitor.index')->with('success', 'Удалено!');
        } catch (\Exception $e) {
            return redirect()->route('monitor.index')->with('error', 'Ошибка удаления.');
        }
    }

    /**
     * Экспортирует данные в CSV.
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export()
    {
        $monitors = $this->getMonitorsFromFile();
        $headers = ['id', 'name', 'price', 'releaseDate', 'matrix', 'resolution', 'refreshRate', 'description'];

        return response()->streamDownload(function () use ($monitors, $headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            foreach ($monitors as $monitor) {
                fputcsv($file, $monitor);
            }
            fclose($file);
        }, 'monitors.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * Читает данные из JSON.
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
