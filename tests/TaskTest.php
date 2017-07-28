<?php

require __DIR__ . '/../vendor/autoload.php';
require_once  __DIR__ . '/../Models/Task.php';
use PHPUnit\Framework\TestCase;

final class TaskTest extends TestCase
{

    public function testValidationTitleWithScript()
    {
        $this->assertEquals(
            [
                'Пустой заголовок задачи'
            ],
            \Models\Task::validate(
                [
                    'title' => 'alert(1);<script>alert(1);</script>',
                    'content' => 'Описание задачи',
                    'date_to' => '2017-12-12'
                ]
            )
        );
    }

    public function testValidationTitleAndContentWithScript()
    {
        $this->assertEquals(
            [
                'Пустой заголовок задачи',
                'Пустое тело задачи',
            ],
            \Models\Task::validate(
                [
                    'title' => 'alert(1);<script>alert(1);</script>',
                    'content' => '<script>alert(1);</script>',
                    'date_to' => '2017-12-12'
                ]
            )
        );
    }
}
