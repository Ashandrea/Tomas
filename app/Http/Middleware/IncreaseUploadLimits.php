<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IncreaseUploadLimits
{
    public function handle(Request $request, Closure $next): Response
    {
        // Increase PHP limits for this request
        @ini_set('upload_max_filesize', '64M');
        @ini_set('post_max_size', '65M');
        @ini_set('memory_limit', '512M');
        @ini_set('max_execution_time', '300');
        @ini_set('max_input_time', '300');
        @ini_set('max_file_uploads', '20');

        return $next($request);
    }
}
