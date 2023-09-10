<?php

namespace wfm;
class Cache
{
    use TSingleton;

    /**
     * функция создания кэша
     * @param $key ключ по которому записываем данные
     * @param $data данные
     * @param $seconds количество секунд, на которые мы сохраним данные в кэше
     * @return bool сохранили данные или нет
     */
    public function set($key, $data, $seconds = 3600): bool
    {
        // записываем данные
        $content['data'] = $data;

        // вычисляем время которое будет храниться кэш (текущее время + переданное время)
        $content['end_time'] = time() + $seconds;

        // записываем данные в файл, ключ хешируем, массив сериализуем
        if (file_put_contents(CACHE . '/' . md5($key) . '.txt', serialize($content))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * достает данные из кеша по ключу
     * @param $key
     * @return false|mixed
     */
    public function get($key)
    {
        $file = CACHE . '/' . md5($key) . '.txt';
        // если искомый файл существует
        if (file_exists($file)) {
            // рассериализовываем данные из файла
            $content = unserialize(file_get_contents($file));
            // если время хранения кеша не истекло возвращаем кеш
            if (time() <= $content['end_time']) {
                return $content['data'];
            }
            // либо удаляем файл
            unlink($file);
        }
        return false;
    }

    /**
     * удаляет данные из кеша
     * @param $key
     * @return void
     */
    public function delete($key)
    {
        $file = CACHE . '/' . md5($key) . '.txt';

        if (file_exists($file)) {
            unlink($file);
        }
    }
}