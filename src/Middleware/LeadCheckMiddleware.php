<?php

namespace A1ex7\Cpa\Middleware;

use A1ex7\Cpa\Lead\LeadService;
use App\Helpers\System;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class LeadCheckMiddleware
{
    /**
     * @var LeadService
     */
    private $leadService;

    /**
     * LeadCheckMiddleware constructor.
     * @param  LeadService  $leadService
     */
    public function __construct(LeadService $leadService)
    {
        $this->leadService = $leadService;
    }

    /**
     * Parse incoming request for cpa sources
     * and store cpa get params to db if user is authenticated
     * or store this data to cookie if anonymous user
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (System::getConfig('enable_new_cpa', false)) {
            try {

                if ($request->has('utm_source')) {
                    $leadGuard = Config::get('cpa.lead_guard');
                    $requestUrl = $request->fullUrl();
                    if (Auth::guard($leadGuard)->check()) {
                        $this->leadService->create(Auth::guard($leadGuard)->user(), $requestUrl);
                    } else {
                        $this->leadService->storeToCookie($requestUrl);
                    }
                }
            } catch (Exception $e) {
                Log::error('CPA Error: ' . $e->getMessage());
            }
        }
        return $next($request);
    }
}
