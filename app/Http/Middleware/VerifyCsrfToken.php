<?php
namespace App\Http\Middleware;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Closure;
class VerifyCsrfToken extends BaseVerifier
{
    public function handle($request, Closure $next)
    {
     if ($this->isReading($request) || $this->shouldPassThrough($request) || $this->tokensMatch($request)) {
        return $this->addCookieToResponse($request, $next($request));
    }
    return redirect('/')->with('info','csrf token error! try.<a href="javascript:location.reload();" class="alert-link">点击刷新页面</a>');
}
        /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
        protected $except = [
        //
        ];
    }