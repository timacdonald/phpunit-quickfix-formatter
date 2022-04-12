<?php

namespace VimQuickfix;

use PHPUnit\Exception;
use PHPUnit\Framework\Test;
use ReflectionClass;
use RuntimeException;

class Helper
{
    /**
     * @return array{ 0: string, 1: int, 2: class-string, 3: string }
     */
    public static function parse(Test $test, Exception $exception): array
    {
        $class = $test::class;

        $filename = self::filename($test);

        /**
          * @var array<int, array{ file: string, class: class-string, function: string, line: int }>
          */
        $trace = $exception->getTrace();

        foreach ($trace as $index => $frame) {
            if ($frame['class'] === $class && $frame['file'] === $filename) {
                return [
                    $filename,
                    $frame['line'],
                    $class,
                    $trace[$index + 1]['function'],
                ];
            }
        }

        throw new RuntimeException('Unable to find the test case line of failure in the stack trace.');
    }

    private static function filename(Test $test): string
    {
        $filename = (new ReflectionClass($test))->getFileName();

        if ($filename === false) {
            throw new RuntimeException('Unable to detect the filename of the test');
        }

        return $filename;
    }
}

