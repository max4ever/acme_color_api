<?php declare(strict_types=1);

namespace Acme\ColorApi\Framework;

use ErrorException;
use JsonException;
use Throwable;

class ErrorHandler
{
    public static function registerHandlers(): void
    {
        set_error_handler([__CLASS__, 'errorHandler']);
        set_exception_handler([__CLASS__, 'exceptionHandler']);
    }

    /**
     * @throws JsonException
     */
    public static function exceptionHandler(Throwable $throwable): void
    {
        http_response_code(500);
        header('Content-Type: application/json');

        echo json_encode([
            'exception code' => $throwable->getCode(),
            'exception msg' => $throwable->getMessage(),
            'exception file' => $throwable->getFile(),
            'exception line' => $throwable->getLine(),
            'exception stacktrace' => $throwable->getTraceAsString()
        ], JSON_THROW_ON_ERROR);
    }

    public static function errorHandler(int $number, string $msg, string $file, int $line): bool
    {
        throw new ErrorException($msg, 0, $number, $file, $line);
    }
}
