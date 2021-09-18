<?php

namespace App\Controller {
    use Slate\Mvc\Controller;
    use Slate\Mvc\Env;
    use Slate\Http\HttpRequest;
    use Slate\Http\HttpResponse;
    use Slate\Exception\HttpException;

    use App\Middleware\RequiresAuth;
    use App\Middleware\RateLimited;

    use Closure;
    use Slate\Facade\Log;
    use Slate\Mvc\Attribute\Route;
    use Slate\Mvc\Attribute\Preprocessor;
    use Slate\Mvc\Attribute\Postprocessor;
    use Throwable;
    use App\Middleware\AuthMiddleware;
    use App\Middleware\RateLimiterMiddlware;

    abstract class RestController extends Controller {
        public const VERSION = 1.0;
        public const POSTPROCESSORS  = ["ApiWrapper", "ApiBeautifier"];

        public const VERBOSE = false;

        private array $additionals = [];

        #[Postprocessor("ApiWrapper")]
        public function apiWrap(HttpRequest $request, HttpResponse $response, mixed $data, object $next): mixed {
            $version = static::VERSION;

            $rest = array_merge(
                $this->additionals, [
                    "api" => [
                        "version" => \Str::val(fmod($version, 1.0) === 0.0 ? $version.".0" : $version)
                    ]
                ]
            );

            if(is_object($data) ? \Cls::isSubclassInstanceOf($data, Throwable::class) : false) {
                $rest["error"]   = $data->httpCode ?: 500;
                $rest["message"] = $data->getMessage() ?: 500;
                $rest["file"] = $data->getFile();
                $rest["line"] = $data->getLine();
                $rest["trace"] = \Str::split($data->getTraceAsString(), "\n");
            }
            else {
                $rest["data"] = $data;
            }

            return $next($request, $response, $rest);
        }

        public function inject(string $key, mixed $value): void {
            $this->additionals[$key] = $value;
        }

        #[Postprocessor("ApiBeautifier")]
        public function apiBeautify(HttpRequest $request, HttpResponse $response, mixed $data, object $next): mixed {
            if($request->headers["Sec-Fetch-Mode"] === "navigate") {
                if(static::VERBOSE === true) {
                    $data["header"]["request"] = [
                        "query"      => $request->query->toArray(),
                        "parameters" => $request->parameters->toArray()
                    ];
                }

                return view("/apiview", $data); 
            }

            return $next($request, $response, $data);
        }
    }
}

?>