<?php

// hotels
$app->get("/hotels","hotelsIndex");
$app->get("/hotels/:id","hotelsShow");
$app->get('/hotels/search/:query', 'hotelFindByName');
$app->post("/hotels","hotelCreate");
$app->put("/hotels/:id","hotelUpdate");
$app->delete("/hotels/:id","hotelDestroy");

function hotelsIndex(){
    $app = \Slim\Slim::getInstance();
    $app->contentType('application/json');
    $sql = "SELECT `id`, `name`, `slug`, `type`, `logo`, `food`, `service`, `venue`, `front_office`, `house_keeping`, `spa`, `fitness_center`, `business_center` FROM hotels ";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $hotels = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        $response = array( "message"=>"success", "description"=>"Hotel Fetched Successfully","data"=> $hotels);
        $db = null;
        echo json_encode($response);
    } catch(PDOException $e) {
        $response = array( "message"=>"failure", "description"=>"Exception while fetching hotels.","data"=>$e->getMessage());
        echo json_encode($response);
    }
}

function hotelsShow($id) {
    $app = \Slim\Slim::getInstance();
    $app->contentType('application/json');
    $sql = "SELECT `id`, `name`, `slug`, `type`, `logo`, `food`, `service`, `venue`, `front_office`, `house_keeping`, `spa`, `fitness_center`, `business_center` FROM hotels WHERE id=$id LIMIT 1";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $hotel = $stmt->fetchAll(PDO::FETCH_ASSOC);
//        var_dump($hotel);exit;
        $response = array( "message"=>"success", "description"=>"Hotel Fetched Successfullycc","data"=> $hotel);
        $db = null;
        echo json_encode($response);
    } catch(PDOException $e) {
        $response = array( "message"=>"failure", "description"=>"Exception while creating hotel.","data"=>$e->getMessage());
        echo json_encode($response);
    }
}



function hotelCreate(){
    $app = \Slim\Slim::getInstance();
    $app->contentType('application/json');
    $request = $app->request();
    parse_str($request->getBody(),$hotel);

    $sql = "INSERT INTO hotels (name, slug, logo,type,food, service, venue, front_office, house_keeping, spa, fitness_center, business_center ) VALUES (:name, :slug, :logo, :type, :food, :service, :venue, :front_office, :house_keeping, :spa, :fitness_center, :business_center)";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("name", $hotel["name"]);
        $name = $hotel["name"];
        $slug = slugify($name);
        $stmt->bindParam("slug", $slug);
        $stmt->bindParam("logo", $hotel["logo"]);
        $stmt->bindParam("type", $hotel["type"]);
        $stmt->bindParam("food", $hotel["food"]);
        $stmt->bindParam("service", $hotel["service"]);
        $stmt->bindParam("venue", $hotel["venue"]);
        $stmt->bindParam("front_office", $hotel["front_office"]);
        $stmt->bindParam("house_keeping", $hotel["house_keeping"]);
        $stmt->bindParam("spa", $hotel["spa"]);
        $stmt->bindParam("fitness_center", $hotel["fitness_center"]);
        $stmt->bindParam("business_center", $hotel["business_center"]);

        $stmt->execute();
        $response = array( "message"=>"success", "description"=>"Hotel Created Successfully","data"=>$db->lastInsertId());
        $db = null;
        echo json_encode($response);
    } catch(PDOException $e) {
        $response = array( "message"=>"failure", "description"=>"Exception while creating hotel.","data"=>$e->getMessage());
        echo json_encode($response);
    }
}


function hotelUpdate($id) {
    $app = \Slim\Slim::getInstance();
    $app->contentType('application/json');
    $request = $app->request();
    parse_str($request->getBody(),$hotel);
    $sql = "UPDATE hotels SET name=:name, slug=:slug,logo=:logo,type=:type ,food=:food, service=:service, venue=:venue, front_office=:front_office, house_keeping=:house_keeping, spa=:spa, fitness_center=:fitness_center, business_center=:business_center WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("name", $hotel["name"]);
        $stmt->bindParam("slug", $hotel["slug"]);
        $stmt->bindParam("logo", $hotel["logo"]);
        $stmt->bindParam("type", $hotel["type"]);
        $stmt->bindParam("food", $hotel["food"]);
        $stmt->bindParam("service", $hotel["service"]);
        $stmt->bindParam("venue", $hotel["venue"]);
        $stmt->bindParam("front_office", $hotel["front_office"]);
        $stmt->bindParam("house_keeping", $hotel["house_keeping"]);
        $stmt->bindParam("spa", $hotel["spa"]);
        $stmt->bindParam("fitness_center", $hotel["fitness_center"]);
        $stmt->bindParam("business_center", $hotel["business_center"]);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $response = array( "message"=>"success", "description"=>"Hotel Updated Successfully");
        $db = null;
        echo json_encode($response);
    } catch(PDOException $e) {
        $response = array( "message"=>"failure", "description"=>"Exception while updating hotel.","data"=>$e->getMessage());
        echo json_encode($response);
    }
}

function hotelDestroy($id) {
    $app = \Slim\Slim::getInstance();
    $app->contentType('application/json');
    $sql = "DELETE FROM hotels WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $response = array( "message"=>"success", "description"=>"Hotel Deleted Successfully");
        $db = null;
        echo json_encode($response);
    } catch(PDOException $e) {
        $response = array( "message"=>"failure", "description"=>"Exception while creating hotel.","data"=>$e->getMessage());
        echo json_encode($response);
    }
}

function hotelFindByName($query) {
    $app = \Slim\Slim::getInstance();
    $app->contentType('application/json');
    $sql = "SELECT * FROM hotels WHERE UPPER(name) LIKE :query ORDER BY name";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $query = "%".$query."%";
        $stmt->bindParam("query", $query);
        $stmt->execute();
        $hotels = $stmt->fetchAll(PDO::FETCH_OBJ);
        $response = array( "message"=>"success", "description"=>"Hotels Searched Successfully","data"=>$hotels);
        $db = null;
        echo json_encode($response);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
