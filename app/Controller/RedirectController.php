<?php

namespace App\Controller {

    use Closure;
    use Slate\Mvc\Controller;
    use Slate\Mvc\Env;
    use Slate\Http\HttpRequest;
    use Slate\Http\HttpResponse;
    use Slate\Exception\HttpException;
    use Slate\Http\HttpEnvironment;
    use Slate\Mvc\Attribute\Postprocessor;
    use Slate\Mvc\Attribute\Route;
    use App\Entity\Frontend\FrontendAccount;
    use App\Entity\Frontend\FrontendCookie;

    class RedirectController extends BaseController {
        public const POSTPROCESSORS  = ["Catcher"];

        #[Route]
        public function index(HttpRequest $request, HttpResponse $response): mixed {
            return $request->headers["Standalone"] == 1
                ? view($request->path, [ "request" => $request ])
                : view("/home");
        }
        
        #[Postprocessor("Catcher")]
        public function catcher(HttpRequest $request, HttpResponse $response, mixed $data, object $next): mixed {
            if(is_object($data) ? \Cls::isSubclassInstanceOf($data, \Throwable::class) : false) {
                throw $data;
            }

            return $next($request, $response, $data);
        }
    }
}

?>
