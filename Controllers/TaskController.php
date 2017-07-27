<?php

namespace Controllers;
require_once __DIR__ . '/../Models/Task.php';
use Carbon\Carbon;
use Models\Task;
use \Route;
use \View;
use \Controller;
use \Request;

class TaskController extends Controller {

    public function __construct(Route $route) {
        parent::__construct($route);

        if (!Request::isUserLoggedIn()) {
            $_SESSION['errors'] = ['Эта страница доступна только после регистрации'];
            Route::redirectTo('/');
            exit();
        }
    }

    public function getTasksAction() {
        $request = $this->request;
        $sortType = $request->get('sort', 'asc');
        $page = $request->get('page', 1);

        $tasksAll = Task::orderBy('date_to', $sortType);
        $tasks = $tasksAll;
        $totalCount = $tasksAll->count();
        $tasks = $tasks->offset(10 * ($page - 1))->take(10)->get();
        $pagesCount = ceil($totalCount / 10);

        $paginationLinks = [];

        if ($pagesCount > 1) {
            for ($i = 1; $i <= $pagesCount; $i++) {
                $paginationLinks[$i] = [
                    'class' => $page == $i ? 'active' : '',
                    'url' => $this->route->getFullUrlWithNewParameter('page', $i)
                ];
            }
        }

        $this->route->getFullUrlWithNewParameter();

        View::render('task/tasks',
            [
                'tasks' => $tasks,
                'url' => $this->route->getCurrentBaseUrl(),
                'pages' => $pagesCount,
                'links' => $paginationLinks,
                'sort' => $sortType
            ]
        );
    }

    public function getCreateAction() {
        View::render('task/create');
    }

    public function getEditAction() {
        $id = $this->request->get('id');
        $task = Task::find($id);

        if (!empty($task)) {
            View::render('task/edit', ['task' => $task]);
        }
    }

    public function postEditAction() {
        $request = $this->request;
        $id = $request->get('id');
        $task = Task::find($id);
        $validate = Task::validate($request->getRequestData());

        if ($validate === true) {
            try {
                $task->title = $request->get('title');
                $task->content = $request->get('content');
                $task->date_to = Carbon::parse($request->get('date_to'));

                if ($task->save()) {
                    $_SESSION['success'] = 'Задача обновлена';
                    Route::redirectTo('task/tasks');
                } else {
                    $_SESSION['errors'] = ['Ошибка'];
                    Route::redirectTo('task/edit?id=' . $id);
                }
            } catch (\Exception $e) {
                $_SESSION['errors'] = ['Ошибка'];
                Route::redirectTo('task/edit?id=' . $id);
            }
        } else {
            $_SESSION['errors'] = $validate;
            Route::redirectTo('task/edit?id=' . $id);
        }
    }

    public function postCreateAction() {
        $request = $this->request;
        $validate = Task::validate($request->getRequestData());

        if ($validate === true) {
            if (Task::create($request->getRequestData())) {
                $_SESSION['success'] = 'Задача создана';
                Route::redirectTo('task/tasks');
            } else {
                $_SESSION['errors'] = ['Ошибка'];
                Route::redirectTo('task/create');
            }
        } else {
            $_SESSION['errors'] = $validate;
            Route::redirectTo('task/create');
        }
    }

    public function postStatusAction() {
        $request = $this->request;
        $ids = $request->get('ids');
        $complete = $request->get('complete');
        $idArray = explode('-', $ids);
        $updatedCount = Task::changeTasksStatus($idArray, $complete);

        if ($updatedCount) {
            if ($updatedCount == 1) {
                $_SESSION['success'] = 'Задача обновлена';
            } else {
                $_SESSION['success'] = 'Обновлено задач: ' . $updatedCount;
            }
        } else {
            $_SESSION['errors'] = ['Задачи не обновлены'];
        }

        Route::redirectTo('task/tasks');
    }

    public function postDeleteAction() {
        $request = $this->request;
        $ids = $request->get('ids');
        $idArray = explode('-', $ids);
        $deletedCount = Task::deleteTasks($idArray);

        if ($deletedCount) {
            if ($deletedCount == 1) {
                $_SESSION['success'] = 'Задача удалена';
            } else {
                $_SESSION['success'] = 'Удалено задач: ' . $deletedCount;
            }
        } else {
            $_SESSION['errors'] = ['Задачи не удалены'];
        }

        Route::redirectTo('task/tasks');
    }
}
