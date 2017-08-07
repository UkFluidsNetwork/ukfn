<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\Log;

final class LogAfterRequest
{

    /**
     * Dispatches the class
     * @see http://blog.phakeapps.com/2015/06/23/log-every-request-and-response-in-laravel-5/
     * @see https://gist.github.com/Shelob9/174f6093c6b388f325157ba3dea82a46
     * @param string $request
     * @param Closure $next
     * @return obj
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    /**
     * @param string $request
     * @return void
     */
    public function terminate($request)
    {
        $this->logRequest($request);
    }

    /**
     * Create a new log entry
     *
     * @param string $data
     * @return void
     */
    private function logRequest($data)
    {
        $log = new Log;
        $log->user_id = isset(Auth::user()->id) ? Auth::user()->id : null;
        $log->ip = $this->getIpAddress();
        $log->browser = $this->getBrowserInfo();
        $log->request = $this->getRequest();
        $log->data = $data;
        $log->requested = date("Y-m-d H:i:s");
        $log->save();
    }

    /**
     * @see http://php.net/manual/en/function.filter-input.php
     * @return string
     */
    private function getBrowserInfo()
    {
        return filter_input(INPUT_SERVER, 'HTTP_USER_AGENT');
    }

    /**
     * @see http://php.net/manual/en/function.filter-input.php
     * @access private
     * @return string
     */
    private function getIpAddress()
    {
        return filter_input(INPUT_SERVER, 'REMOTE_ADDR');
    }

    /**
     * @see http://php.net/manual/en/function.filter-input.php
     * @access private
     * @return string
     */
    private function getRequest()
    {
        return filter_input(INPUT_SERVER, 'REQUEST_URI');
    }
}

