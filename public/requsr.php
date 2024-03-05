<?php
// requsr.php
$app->get('/request/{id}', function ($request, $response, $args) {
    $OUT=[];
    $OUT['method']=$request->getMethod();
    $OUT['content']=$request->getContentType();
    $OUT['isget']=$request->getGet();
    $OUT['Port']=$request->getUri()->getPort();
    $OUT['Host']=$request->getUri()->getHost();


    $Headers=$request->getHeaders();
    $I=-1;
    foreach($Headers as $key => $value){
     $OUT[++$I]= $key . ":" .implode(",",$value);
    }
    $response->getBody()->write(json_decode($OUT));
    return $response;
});