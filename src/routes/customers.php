<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
$app = new \Slim\app;

//Get all costumers

$app->get('/api/customers', function (Request $request, Response $response) {
    $sql = "SELECT * FROM customers";

    try{
        //Get DB Object
        $db = new db();
        
        //Connect
        $db = $db->connect();
        $stmt = $db->query($sql);
         
        $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($customers);
        
    } catch(PDOException $e){
        echo '{"error": {"text":'.$e->getMessage().'}';
    }

});

//Get single costumers

$app->get('/api/customers/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $sql = "SELECT * FROM customers WHERE id = $id";

    try{
        //Get DB Object
        $db = new db();
        
        //Connect
        $db = $db->connect();
        $stmt = $db->query($sql);
         
        $customer = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($customer);
        
    } catch(PDOException $e){
        echo '{"error": {"text":'.$e->getMessage().'}';
    }

});

//Add costumers

$app->post('/api/customers/add', function (Request $request, Response $response) {
    $name = $request->getParam('name');
    $surname = $request->getParam('surname');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');
    
    $sql = "INSERT INTO customers (name, surname, phone, email, address, city, state) VALUES 
    (:name, :surname, :phone, :email, :address, :city, :state)";

    try{
        //Get DB Object
        $db = new db();
        
        //Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':surname', $surname);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);

        $stmt->execute();

        echo '{"notice": {"text" : "Customer added !"}';

    } catch(PDOException $e){
        echo '{"error": {"text":'.$e->getMessage().'}';
    }

});


//Update costumers

$app->put('/api/customers/update/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $name = $request->getParam('name');
    $surname = $request->getParam('surname');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');
    
    $sql = " UPDATE customers SET
            name = :name,
            surname = :surname,
            phone = :phone,
            email = :email,
            address = :address,
            city = :city,
            state = :state
            WHERE id = $id
            ";
    try{
        //Get DB Object
        $db = new db();
        
        //Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':surname', $surname);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':state', $state);

        $stmt->execute();

        echo '{"notice": {"text" : "Customer updated!"}';

    } catch(PDOException $e){
        echo '{"error": {"text":'.$e->getMessage().'}';
    }

});


//Delete costumers

$app->delete('/api/customers/delete/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $sql = "DELETE FROM customers WHERE id = $id";

    try{
        //Get DB Object
        $db = new db();
        
        //Connect
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice" : {"text" : "Customer deleted!"}';
        
    } catch(PDOException $e){
        echo '{"error": {"text":'.$e->getMessage().'}';
    }

});