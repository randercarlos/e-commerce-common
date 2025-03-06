<?php

namespace Ecommerce\Common\Logging;

use Monolog\Formatter\NormalizerFormatter;
use Throwable;

class JsonLogFormmater extends NormalizerFormatter
{
    public function __construct()
    {
        parent::__construct('Y-m-d H:i:s');
    }

    public function format(array $record): string
    {
        $exception = $record['context']['exception'] ?? null;

        $log = [
            'requestId' => request()->header('X-Request-Id'),
            'timestamp' => $record['datetime']->format($this->dateFormat),
            'level' => $record['level_name'],
            'service' => config('app.name'),
            'environment' => config('app.env'),
            'message' => $record['message'],
            'file' => $this->getFile($record, $exception),
            'line' => $this->getLine($record, $exception),
            'context' => $record['context'] ?? [],
            'stacktrace' => $this->formatStackTrace($exception),
        ];


        return json_encode($log, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
            . PHP_EOL;
    }

    private function formatStackTrace(?Throwable $exception): ?array
    {
        if (!$exception) {
            return null;
        }

        $traceLines = []; // Adiciona cabeçalho igual ao log padrão do Laravel
        foreach ($exception->getTrace() as $index => $trace) {
            $traceLines[] = sprintf(
                "#%d %s(%s): %s%s%s(%s)",
                $index,
                $trace['file'] ?? '[internal]',
                $trace['line'] ?? '?',
                $trace['class'] ?? '',
                $trace['type'] ?? '',
                $trace['function'] ?? '',
                $this->formatArgs($trace['args'] ?? [])
            );
        }

        return $traceLines;
    }

    private function formatArgs(array $args): string
    {
        return implode(', ', array_map(fn ($arg) => gettype($arg), $args)); // Mostra apenas os tipos dos argumentos
    }

    private function getFile(array $record, ?Throwable $exception): ?string
    {
        return $record['extra']['file'] ?? ($exception ? $exception->getFile() : null);
    }

    private function getLine(array $record, ?Throwable $exception): ?int
    {
        return $record['extra']['line'] ?? ($exception ? $exception->getLine() : null);
    }
}
