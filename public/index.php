<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

require "requsr.php";

// Get Metoed

$app->get('/api/v1/{name}', function (Request $request, Response $response, array $args) {
   
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});                                                                 

//POST Method

$app->post('/api/v1/user', function(Request $req, Response $res) {
    $data = $req->getParsedBody();

    $inputdata = [];
    $inputdata['name'] = filter_var($data['name'], FILTER_SANITIZE_STRING);
    $inputdata['phone'] = filter_var($data['phone'], FILTER_SANITIZE_NUMBER_INT);
    $res->getBody()->write("Dear {$inputdata['name']}, your phone is {$inputdata['phone']}");
    return $res;

});

//Two args
$app->get('/user/{name}/{phone}', function ($request,$response,$args) {
    $name = $args['name'];
    $phone = $args['phone'];
    $response->getBody()->write("Your name is:, $name,and your phone is $phone");
    return $response;
}); 

//JSON Response 

$app->get('/json/{LastName}/{firstname}', function($request, $response, $args) {
    $firstname = $args['firstname'];
    $LastName = $args['LastName'];
    $out = [];
    $out['Status'] = 200;
    $out['Message'] = "This is JSON";
    $out['firstname'] = $firstname;
    $out['LastName']=$LastName;
    $response->getBody()->write(json_encode($out));
    return $response;

});

//PUT 
$app->put('/put',function($request,$response){
    $data=$request->getParsedBody();
    $username=$data['Username'];
    $Password=$data['Password'];
    $response->getBody()->write("Your username is : $username, your Password is: $Password");
    return $response;
});
//Mutliple methods 
$app->map(['PUT','GET'],'/Mutliple/{id}',function($request,$response,$args){
  $id=$args['id'];
// if($request->is_Put()){
$response->getBody()->write("This id will be updated $id");
       return $response;
    // }else
    // if($request->isget()){

    $response->getBody()->write("This id will be updated $id");
    return $response;
// };

});
//Optional
$app->get('/optional[/{id}]',function($request,$response,$args){
    $id=$args['id'];
    if($id == NUll){
        $response->getBody()->write("This id will be updated NUll");
        return $response;
        }else{
     $response->getBody()->write("This id will be updated $id");
    return $response;
        }
});

//Mutliple param
$app->get('/unlimited[/{parms:.*}]', function($request, $response, $args) {
    $parms = explode('/', $request->getAttribute('parms'));

    if (empty($parms[0])) {
        $response->getBody()->write("This id will be updated Null");
        return $response;
    } else {
        $response->getBody()->write("This id will be updated " . implode(', ', $parms));
        return $response;
    }
});




//group of routes
// $app->group('/group', function ($request, $response){
//     $app->get('', function ($request, $response) {
//         $response->getBody()->write("GET empty method");
//         return $response;
//     });

//     $app->put('', function ($request, $response) {
//         $response->getBody()->write("PUT empty method");
//         return $response;
//     });

//     $app->post('', function ($request, $response) {
//         $response->getBody()->write("POST empty method");
//         return $response;
//     });

//     $app->get('/{id}', function ($request, $response, $args) {
//         $id = $args['id'];
//         $response->getBody()->write("GET with id=$id");
//         return $response;
//     });
// });

$app->run();
