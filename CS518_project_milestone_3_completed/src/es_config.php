<?php

require '../vendor/autoload.php';

//use Elastic\Elasticsearch\ClientBuilder;
use Elasticsearch\ClientBuilder;

//vendor/elasticsearch/elasticsearch/src/Elasticsearch/

// $client = Elastic\Elasticsearch\ClientBuilder::create()->build();

$hosts = [
    'localhost:9200'     
];

$client = ClientBuilder::create()->setHosts($hosts)->build();

// $params = [
//   'index' => 'my_index',
//   'id'    => 'my_id',
//   'body'  => ['testField' => 'abc']
// ];

// $response = $client->index($params);
// echo "<h3>We indexed these.</h3>";
// print_r($params);
// echo "<h3><Response/h3>";
// print_r($response);
// echo "<br>";
?>

       
