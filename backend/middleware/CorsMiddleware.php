<?php
namespace MyApp\Middleware;

use Phalcon\Mvc\Micro;
use Phalcon\Events\Event;
use Phalcon\Mvc\Micro\MiddlewareInterface;

class CorsMiddleware implements MiddlewareInterface
{
    public function beforeHandleRoute(Micro $app)
    {
        $origin = $app->request->getHeader('Origin');
        $allowedOrigins = ['https://zicare-test.web.app/', 'http://localhost:5173/']; // Specify your allowed origins

        if (in_array($origin, $allowedOrigins)) {
            $app->response->setHeader('Access-Control-Allow-Origin', $origin);
            $app->response->setHeader('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');
            $app->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        }

        // Allow the request to continue to the next middleware/route handler
        return true;
    }

    public function call(Micro $app)
    {
        // Not used in this example
    }
}
