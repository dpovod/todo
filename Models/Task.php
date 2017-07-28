<?php

namespace Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as Model;

class Task extends Model {

    public static function validate ($data) {
        $errors = [];

        if (empty($data['title'])) {
            $errors[] = 'Пустой заголовок задачи';
        }

        if (empty($data['content'])) {
            $errors[] = 'Пустое тело задачи';
        }

        if (empty($data['date_to'])) {
            $errors[] = 'Пустая назначенная дата';
        }

        if (empty($errors)) {
            $title = preg_replace('.+?<script(.*?)>(.*?)<\/script>', '', $data['title']);

            if (empty($title)) {
                $errors[] = 'Пустой заголовок задачи';
            }

            $content = preg_replace('.+?<script(.*?)>(.*?)<\/script>', '', $data['content']);

            if (empty($content)) {
                $errors[] = 'Пустое тело задачи';
            }

            $dateTo = Carbon::parse($data['date_to']);
            $now = Carbon::now()->tz('Europe/Kiev')->setTime(0, 0, 0);

            if ($now > $dateTo) {
                $errors[] = 'Назначенная дата меньше текущей';
            }
        }

        if (!empty($errors)) {
            return $errors;
        }

        return true;
    }

    public static function create($data) {
        try {
            $task = new Task();
            $task->title = $data['title'];
            $task->content = nl2br($data['content']);
            $task->date_to = Carbon::parse($data['date_to']);

            return $task->save();
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function changeTasksStatus($ids, $complete) {
        $updatedCount = 0;

        foreach ($ids as $id) {
            $task = Task::find($id);

            if (!empty($task)) {
                $task->complete = (bool) $complete;

                if ($task->save()) {
                    $updatedCount++;
                }
            }
        }

        return $updatedCount;
    }

    public static function deleteTasks($ids) {
        $deletedCount = 0;

        foreach ($ids as $id) {
            $task = Task::find($id);

            if (!empty($task)) {
                if ($task->delete()) {
                    $deletedCount++;
                }
            }
        }

        return $deletedCount;
    }
}
