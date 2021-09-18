<?php

namespace App\Controller {
    use Slate\Mvc\Controller;
    use Slate\Mvc\Env;
    use Slate\Http\HttpRequest;
    use Slate\Http\HttpResponse;
    use Slate\Exception\HttpException;
    use App\Middleware\AuthMiddleware;
    use App\Middleware\RateLimiterMiddlware;

    abstract class BaseController extends Controller {
        public const PREPROCESSORS  = ["RateLimiter"];
        use RateLimiterMiddlware;
    }
}

?>