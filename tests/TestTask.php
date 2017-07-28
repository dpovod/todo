<?php

require __DIR__ . '/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

final class TestTask extends TestCase
{

    public function testValidationTitleWithScript()
    {
        $this->assertEquals(
            [
                'Пустой заголовок задачи'
            ],
            \Models\Task::validate(
                [
                    '<script>alert(1);</script>',
                    'content',
                    '2017-12-12'
                ]
            )
        );
    }
}