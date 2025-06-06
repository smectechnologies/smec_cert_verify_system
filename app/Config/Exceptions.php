<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Debug\ExceptionHandler;
use CodeIgniter\Debug\ExceptionHandlerInterface;
use Psr\Log\LogLevel;
use Throwable;

/**
 * Setup how the exception handler works.
 */
class Exceptions extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * LOG EXCEPTIONS
     * --------------------------------------------------------------------------
     *
     * If true, then exceptions will be logged
     * through Services::Log.
     *
     * Default: true
     */
    public bool $log = true;

    /**
     * --------------------------------------------------------------------------
     * DO NOT LOG STATUS CODES
     * --------------------------------------------------------------------------
     *
     * When enabled, exceptions will not be logged for the HTTP status codes.
     * See `log_exceptions` for more details.
     *
     * Default: []
     */
    public array $ignoreCodes = [404];

    /**
     * --------------------------------------------------------------------------
     * Error Views Path
     * --------------------------------------------------------------------------
     *
     * This is the path to the directory that contains the 'cli' and 'html'
     * directories that hold the views used to generate errors.
     *
     * Default: APPPATH.'Views/errors'
     */
    public string $errorViewPath = APPPATH . 'Views/errors';

    /**
     * --------------------------------------------------------------------------
     * HIDE FROM DEBUG TRACE
     * --------------------------------------------------------------------------
     *
     * Any data that you would like to hide from the debug trace.
     * In order to specify 2 levels, use "/" to separate.
     * ex. ['server', 'setup/password', 'secret_token']
     *
     * Default: []
     */
    public array $sensitiveDataInTrace = [];

    /**
     * --------------------------------------------------------------------------
     * LOG DEPRECATIONS INSTEAD OF THROWING?
     * --------------------------------------------------------------------------
     *
     * By default, CodeIgniter converts deprecations into exceptions. Also,
     * starting in PHP 8.1 will cause a lot of deprecated usage warnings.
     * Use this option to temporarily cease the warnings and instead log those.
     * This option also works for user deprecations.
     */
    public bool $logDeprecations = true;

    /**
     * --------------------------------------------------------------------------
     * LOG LEVEL THRESHOLD FOR DEPRECATIONS
     * --------------------------------------------------------------------------
     *
     * If `$logDeprecations` is set to `true`, this sets the log
     * level to which the deprecation will be logged. This should be
     * one of the log levels recognized by PSR-3.
     *
     * The related `Config\Logger::$threshold` should be adjusted, if needed,
     * to capture logging the deprecations.
     */
    public string $deprecationLogLevel = LogLevel::WARNING;

    /**
     * --------------------------------------------------------------------------
     * LOG EXCEPTIONS WITH SILENCE
     * --------------------------------------------------------------------------
     *
     * If true, then exceptions will be logged even when there is a `silent` flag.
     * See `log_exceptions` for more details.
     *
     * Default: false
     */
    public bool $logSilent = true;

    /**
     * --------------------------------------------------------------------------
     * EXCEPTION HANDLER CLASS
     * --------------------------------------------------------------------------
     *
     * The name of the class responsible for handling uncaught exceptions.
     * The class should be relative to the namespace configured in Config\Autoload.
     *
     * Default: \CodeIgniter\Debug\ExceptionHandler
     */
    public string $handler = ExceptionHandler::class;

    /**
     * --------------------------------------------------------------------------
     * EXCEPTION HANDLER INTERFACE
     * --------------------------------------------------------------------------
     *
     * The name of the interface responsible for handling uncaught exceptions.
     * The interface should be relative to the namespace configured in Config\Autoload.
     *
     * Default: \CodeIgniter\Debug\ExceptionHandlerInterface
     */
    public string $handlerInterface = ExceptionHandlerInterface::class;

    /*
     * DEFINE THE HANDLERS USED
     * --------------------------------------------------------------------------
     * Given the HTTP status code, returns exception handler that
     * should be used to deal with this error. By default, it will run CodeIgniter's
     * default handler and display the error information in the expected format
     * for CLI, HTTP, or AJAX requests, as determined by is_cli() and the expected
     * response format.
     *
     * Custom handlers can be returned if you want to handle one or more specific
     * error codes yourself like:
     *
     *      if (in_array($statusCode, [400, 404, 500])) {
     *          return new \App\Libraries\MyExceptionHandler();
     *      }
     *      if ($exception instanceOf PageNotFoundException) {
     *          return new \App\Libraries\MyExceptionHandler();
     *      }
     */
    public function handler(int $statusCode, Throwable $exception): ExceptionHandlerInterface
    {
        return new ExceptionHandler($this);
    }
}
