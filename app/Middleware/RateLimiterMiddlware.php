<?php

namespace App\Middleware {
    use Closure;
    use Slate\Http\HttpEnvironment;
    use Slate\Http\HttpRequest;
    use Slate\Mvc\Attribute\Preprocessor;
    use App\Auxiliary\RateLimiter;

    trait RateLimiterMiddlware {

        #[Preprocessor("RateLimiter")]
        public function authRateLimiter(HttpRequest $request, object $next): mixed {
            $ip = HttpEnvironment::getClientIpAddress();
            $decay = \Cls::getConstant(static::class, "RL_DECAY", 60);
            $maxAttempts = \Cls::getConstant(static::class, "RL_ATTEMPTS", 100);

            if(RateLimiter::getInstance()->tooManyAttempts($ip, $maxAttempts) === true) {
                return code(429);
            }
            else {
                RateLimiter::getInstance()->hit($ip, $decay);
            }

            return $next($request);
        }
    }
}

?>