<?php

namespace Core;

use App\Config;

/**
 * Error and exception handler
 *
 * PHP version 5.4
 */
class Error
{
    /**
     * Error handler. Convert all errors to Exceptions by throwing an ErrorException.
     *
     * @param int $level  Error level
     * @param string $message  Error message
     * @param string $file  Filename the error was raised in
     * @param int $line  Line number in the file
     *
     * @return void
     */
    public static function errorHandler($level, $message, $file, $line)
    {
        if (error_reporting() !== 0) {  // to keep the @ operator working
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Exception handler.
     *
     * @param Exception $exception  The exception
     *
     * @return void
     */
    public static function exceptionHandler($exception)
    {
        $code = $exception->getCode();
        if ($code != 404) {
            $code = 500;
        }

        http_response_code($code);

        if (Config::SHOW_ERROR) {
            echo '<h1>Fatal error</h1>';
            echo "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
            echo "<p>Message: '" . $exception->getMessage() . "'</p>";
            echo '<p>Stack trace:<pre>' . $exception->getTraceAsString() . '</pre></p>';
            echo "<p>Thrown in '" . $exception->getFile() . "' on line " .
                 $exception->getLine() . '</p>';
        } else {
            $logpath = dirname(__DIR__) . '/logs/' . date('Y-m-d') . '.txt';
            ini_set('error_log', $logpath);

            $message = "Uncaught Exception: '" . get_class($exception) . "'";
            $message .= "with message '" . $exception->getMessage() . "'";
            $message .= "\nwith stack trace :" . $exception->getTraceAsString();
            $message .= "\n Throw in '" . $exception->getFile() . "' on line" . $exception->getLine();

            error_log($message);
            View::renderTemplate($code . '.html');
        }
    }
}
