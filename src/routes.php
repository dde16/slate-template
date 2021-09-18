<?php

use App\Controller\Api\TestController;
use Slate\Mvc\Router;
use App\Controller\RedirectController;
use Slate\Http\HttpRequest;
use Slate\Http\HttpResponse;

Router::redirect("/", "/home");

Router::add("/api/test/ping", [TestController::class, "ping"]);
Router::add("/api/test/entity", [TestController::class, "entities"]);

Router::add("/api/test/closure", function(HttpRequest $request, HttpResponse $response): mixed {
    return "<h1>Closure</h1>";
});

// Add many actions for a given path
// The route that is chosen is that which matches the environment,
// eg. when http methods match.
Router::many("/api/methods", [
    [ TestController::class, "get" ],
    [ TestController::class, "post" ]
]);

// Fallback to a controller action if no other routes match
Router::fallback([RedirectController::class, "index"]);


// ... or a view
// Router::fallback("/404");

// ... or a Closure
// Router::fallback(function(HttpRequest $request, HttpResponse $response): string {
//     return "<h1>404</h1>";
// });

?>
