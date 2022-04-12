<?php

namespace VimQuickfix;

use PHPUnit\Exception;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestListener;
use Throwable;
use PHPUnit\Framework\Warning;
use PHPUnit\Framework\TestSuite;
use RuntimeException;

class Listener implements TestListener
{
    public const FAILURE = 'e';

    public const WARNING = 'w';

    public const INFO = 'i';

    public const NOTE = 'n';

    protected string $logPath;

    /**
     * @var array{
     *     'type': self::FAILURE|self::WARNING|self::INFO|self::NOTE,
     *     'filename': string,
     *     'line': int,
     *     'class': class-string,
     *     'function': string,
     *     'message': string
     * }
     */
    protected array $logs = [];

    /**
     * @param null|array{ logPath?: string } $args
     */
    public function __construct(?array $args = null)
    {
        $args ??= [];

        $this->logPath = $args['logPath'] ?? '.phpunit.quickfix';
    }

    public function addError(Test $test, Throwable $t, float $time): void
    {
        var_dump(__FUNCTION__);
        die;
    }

    public function addWarning(Test $test, Warning $e, float $time): void
    {
        var_dump(__FUNCTION__);
        die;
    }

    public function addFailure(Test $test, AssertionFailedError $exception, float $time): void
    {
        $this->write(self::FAILURE, $test, $exception);
    }

    public function addIncompleteTest(Test $test, Throwable $t, float $time): void
    {
        var_dump(__FUNCTION__);
        die;
    }

    public function addRiskyTest(Test $test, Throwable $t, float $time): void
    {
        var_dump(__FUNCTION__);
        die;
    }

    public function addSkippedTest(Test $test, Throwable $t, float $time): void
    {
        var_dump(__FUNCTION__);
        die;
    }

    public function endTestSuite(TestSuite $suite): void
    {
        $this->flush();
    }

    /**
     * @param self::FAILURE|self::WARNING|self::INFO|self::NOTE $type
     */
    protected function write(string $type, Test $test, Exception $exception): void
    {
        [$filename, $line,$class, $function] = Helper::parse($test, $exception);

        $this->logs[] = [
            'type' => $type,
            'filename' => $filename,
            'line' => $line,
            'class' => $class,
            'function' => $function,
            'message' => $exception->getMessage(),
        ];
    }

    protected function flush(): void
    {
        $file = fopen($this->logPath, 'w');

        if ($file === false) {
            throw new RuntimeException('Unable to open the quickfix log file');
        }

        foreach ($this->logs as $log) {
            fwrite(
                $file,
                ""
            );
        }


        // 'module' => basename(str_replace('\\', '/', $class)) . '::' . $function,
    }
}
