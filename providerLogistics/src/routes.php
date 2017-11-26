<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

//Teste de autenticação
$app->get("/api/{nome}", function (Request $request, Response $response) {
    $nome = $request->getAttribute("nome");
    $response->getBody()->write("Bem vindo a API! Testando autenticação, $nome");
    return $response;
});

//Atualiza a entrega especifica
$app->put('/delivery/{id}', function (Request $request, Response $response) {

    $id = $request->getAttribute('id');
    $body = $request->getParsedBody();

    $delivery = $this->db->delivery[$id];
    if ($delivery) {
        if (isset($body["receiver_name"]) && isset($body["receiver_cpf"]) && isset($body["deliveryDatae"])){
            $data = array(
                "order_number" => $body["order_number"],
                "client_id" =>  $body["client_id"],
                "receiver_name" =>  $body["receiver_name"],
                "receiver_cpf" =>  $body["receiver_cpf"],
                "date" => $body["deliveryDate"]
            );
            $result = $delivery->update($data);
            return $response->withStatus(204);
        }else {
            return $response->withStatus(404);
        }
    } 
});

$app->delete('/delivery/{id}', function (Request $request, Response $response) {
    
    
        $id = $request->getAttribute('id');

        //Delete a entrega
        $delivery = $this->db->delivery()->where('id', $id);
        
        print_r($delivery);
        
        if ($delivery->fetch()) {
            $deleted = $delivery->delete();
        }
    });

