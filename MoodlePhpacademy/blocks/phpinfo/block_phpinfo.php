<?php
class block_phpinfo extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_phpinfo');
    }

    public function get_content() {
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->text = '
            <div style="background:#f8f9fa; padding:15px; border-radius:8px;">
                <h4>PHP Info Dashboard</h4>
                <p><strong>Версия PHP:</strong> ' . phpversion() . '</p>
                <p><strong>Текущая дата:</strong> ' . date('d.m.Y H:i:s') . '</p>
                <p><strong>Сервер:</strong> Docker + Moodle 5.1</p>
                <hr>
                <p><strong>Это мой собственный плагин!</strong><br>
                Написан на чистом PHP специально для курсовой работы.</p>
            </div>
        ';
        return $this->content;
    }
}