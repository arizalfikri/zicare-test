<?php

use Phalcon\Loader;
use Phalcon\Mvc\Micro;
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;
use Phalcon\Http\Response;

$loader = new Loader();
$loader->registerNamespaces(
    [
        'MyApp\Models' => __DIR__ . '/models/',
    ]
);
$loader->register();

$container = new FactoryDefault();
$container->set(
    'db',
    function () {
        return new PdoMysql(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'admin',
                'dbname'   => 'phalcon_db',
            ]
        );
    }
);

$app = new Micro($container);

$app->before(function() use ($app) {
    $origin = $app->request->getHeader("ORIGIN") ? $app->request->getHeader("ORIGIN") : ['http://localhost:5173/', 'https://zicare-test.web.app/'];
    
    $app->response->setHeader("Access-Control-Allow-Origin", $origin)
        ->setHeader("Access-Control-Allow-Methods", 'GET,PUT,POST,DELETE,OPTIONS')
        ->setHeader("Access-Control-Allow-Headers", '*')
        ->setHeader('Content-type', 'application/json')
        ->setHeader("Access-Control-Allow-Credentials", true);
});
    
$app->options('/{catch:(.*)}', function() use ($app) { 
    $app->response->setStatusCode(200, "OK")->send();
});


$app->get('/', function () {
        echo '<p>hello, wellcome to api pasiens<p>';
    }
);

$app->get(
    '/api/pasiens',
    function () use ($app) {
        $phql = 'SELECT * '
              . 'FROM MyApp\Models\tb_pasien '
        ;

        $pasiens = $app
            ->modelsManager
            ->executeQuery($phql)
        ;

        $data = [];

        foreach ($pasiens as $pasien) {
            $data[] = [
                'id'   => $pasien->id,
                'name' => $pasien->name,
                'sex'=> $pasien->sex,
                'religion'=> $pasien->religion,
                'phone'=> $pasien->phone,
                'address'=> $pasien->address,
                'nik'=> $pasien->nik,
            ];
        }

        $response = new Response();
        $response->setJsonContent(
            [
                'status' => [
                    'code' => 200,
                    'response' => 'success',
                    'message' => 'success get data'
                ],
                'result' => $data
            ]
        );

        return $response;
    }
);

$app->get(
    '/api/pasiens/{id:[0-9]+}',
    function ($id) use ($app) {
        $phql = 'SELECT * '
            . 'FROM MyApp\Models\tb_pasien '
            . 'WHERE id = :id:'
        ;

        $pasien = $app
            ->modelsManager
            ->executeQuery(
                $phql,
                [
                    'id' => $id,
                ]
            )
            ->getFirst()
        ;
        
        $response = new Response();
        if ($pasien === null) {
            $response->setJsonContent(
                [
                    'status' => [
                        'code' => 404,
                        'response' => 'error',
                        'message' => 'data not found'
                    ]
                ]
            );
        } else {
            $response->setJsonContent(
                [
                    'status' => [
                        'code' => 200,
                        'response' => 'success',
                        'message' => 'success get one data'
                    ],
                    'result' => $pasien
                ]
            );
        };

        return $response;
    }
);

$app->post(
    '/api/pasiens',
    function () use ($app) {
        $pasien = $app->request->getJsonRawBody();
        $phql  = 'INSERT INTO MyApp\Models\tb_pasien '
                . '(name, sex, religion, phone, address, nik) '
                . 'VALUES '
                . '(:name:, :sex:, :religion:, :phone:, :address:, :nik:)'
        ;

        $status = $app
            ->modelsManager
            ->executeQuery(
                $phql,
                [
                    'name' => $pasien->name,
                    'sex' => $pasien->sex,
                    'religion' => $pasien->religion,
                    'phone' => $pasien->phone,
                    'address' => $pasien->address,
                    'nik' => $pasien->nik,
                ]
            )
        ;

        $response = new Response();
        if ($status->success() === true) {
            $pasien->id = $status->getModel()->id;

            $response->setJsonContent(
                [
                    'status' => [
                        'code' => 201,
                        'response' => 'created',
                        'message' => 'success created data'
                    ],
                    'result'   => $pasien,
                ]
            );
        } else {
            $errors = [];
            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response->setJsonContent(
                [
                    'status'   => [
                        'code' => 409,
                        'response' => 'failed',
                        'message' => $errors
                    ],
                ]
            );
        }

        return $response;
    }
);

$app->put(
    '/api/pasiens/{id:[0-9]+}',
    function ($id) use ($app) {
        
        $pasien = $app->request->getJsonRawBody();
        $phql  = 'UPDATE MyApp\Models\tb_pasien '
               . 'SET name = :name:, sex = :sex:, religion = :religion:, phone = :phone:, address = :address:, nik = :nik:'
               . 'WHERE id = :id:';

        $status = $app
            ->modelsManager
            ->executeQuery(
                $phql,
                [
                    'id'   => $id,
                    'name' => $pasien->name,
                    'sex' => $pasien->sex,
                    'religion' => $pasien->religion,
                    'phone' => $pasien->phone,
                    'address' => $pasien->address,
                    'nik' => $pasien->nik,
                ]
            )
        ;

        $response = new Response();
        if ($status->success() === true) {
            $response->setJsonContent(
                [
                    'status' => [
                        'code' => 200,
                        'response' => 'success',
                        'message' => 'success updated data'
                    ],
                    'result' => $pasien,
                ]
            );
        } else {
            $errors = [];
            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response->setJsonContent(
                [
                    'status'   => [
                        'status' => 409,
                        'response' => 'failed',
                        'message' => $errors
                    ],
                ]
            );
        }

        return $response;
    }
);

$app->delete(
    '/api/pasiens/{id:[0-9]+}',
    function ($id) use ($app) {
        $phql = 'DELETE '
              . 'FROM MyApp\Models\tb_pasien '
              . 'WHERE id = :id:';

        $status = $app
            ->modelsManager
            ->executeQuery(
                $phql,
                [
                    'id' => $id,
                ]
            )
        ;

        $response = new Response();
        if ($status->success() === true) {
            $response->setJsonContent(
                [
                    'status' => [
                        'code' => 200,
                        'response' => 'success',
                        'message' => 'success deleted data'
                    ]
                ]
            );
        } else {
            $errors = [];
            foreach ($status->getMessages() as $message) {
                $errors[] = $message->getMessage();
            }

            $response->setJsonContent(
                [
                    'status'   => [
                        'code' => 409,
                        'response' => 'failed',
                        'message' => $errors
                    ],
                ]
            );
        }

        return $response;
    }
);

$app->notFound(function () use ($app) {
    $app->response->setStatusCode(404, "Not Found")->sendHeaders();
    echo 'Page was not found!';
});

$app->handle($_SERVER["REQUEST_URI"]);