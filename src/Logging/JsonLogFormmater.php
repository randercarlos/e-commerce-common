<?php

namespace Ecommerce\Common\Logging;

use Monolog\Formatter\JsonFormatter;
use Throwable;

class AppJsonLogFormatter extends JsonFormatter
{
    public function __construct()
    {
        parent::__construct(JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public function format(array $record): string
    {
        $exception = $record['context']['exception'] ?? null;

        $log = [
            'requestId'   => request()->header('X-Request-Id'),
            'timestamp'   => $record['datetime']->format($this->dateFormat),
            'level'       => $record['level_name'],
            'service'     => config('app.name'),
            'environment' => config('app.env'),
            'message'     => $record['message'],
            'file'        => $this->getFile($record, $exception),
            'line'        => $this->getLine($record, $exception),
            'context'     => $record['context'] ?? [],
            'stacktrace'  => $this->formatStackTrace($exception),
        ];

        return parent::format($log);
    }

    private function formatStackTrace(?Throwable $exception): ?array
    {
        if (!$exception) {
            return null;
        }

        return array_map(
            function ($trace, $index) {
                return sprintf(
                    "#%d %s(%s): %s%s%s(%s)",
                    $index,
                    isset($trace['file']) ? $trace['file'] : '[internal]',
                    isset($trace['line']) ? $trace['line'] : '?',
                    isset($trace['class']) ? $trace['class'] : '',
                    isset($trace['type']) ? $trace['type'] : '',
                    isset($trace['function']) ? $trace['function'] : '',
                    $this->formatArgs(isset($trace['args']) ? $trace['args'] : [])
                );
            },
            $exception->getTrace(),
            array_keys($exception->getTrace())
        );
    }

    private function formatArgs(array $args): string
    {
        return implode(', ', array_map('gettype', $args));
    }

    private function getFile(array $record, ?Throwable $exception): ?string
    {
        return isset($record['extra']['file']) ? $record['extra']['file'] : ($exception ? $exception->getFile() : null);
    }

    private function getLine(array $record, ?Throwable $exception): ?int
    {
        return isset($record['extra']['line']) ? $record['extra']['line'] : ($exception ? $exception->getLine() : null);
    }
}
