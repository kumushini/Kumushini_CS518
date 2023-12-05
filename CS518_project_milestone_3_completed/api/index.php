<?php
session_start();

require_once "./../src/config.php";

//$page_number = isset($_GET['page']) ? (int)$_GET['page'] :1;
//$per_page_count = isset($_GET['perpage']) ? (int)$_GET['perpage'] :10;



//https://amirkamizi.com/blog/php-simple-rest-api

require __DIR__ . './../vendor/autoload.php';

//require 'pagination_cli.php';
require_once './../src/es_config.php';


// Define a route with a callback function
//$app = new \Slim\Slim();

//$app->get('/api/:name', function ($name) {
//	echo "Hello, $name\n";
//	echo $_SERVER['REQUEST_URI'];
//	echo $_SERVER['REQUEST_METHOD'];
//	header("location:test.php");
//	
//});

//$app->run();

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
//$searchterm = $_GET['searchterm'];

//https://www.geeksforgeeks.org/register?name=Amit&email=amit1998@gmail.com'
//http://localhost/api/search?key=[key]&query=[term1+term2]&range=24



switch ($method | $uri) {
   /*
   * Path: GET /api/users
   * Task: show all the users
   */
   case ($method == 'GET' && $uri == '/api'):
   	echo 'hellooo root/';
       break;

   case ($method == 'GET' && preg_match('/\/api\/search?[a-zA-Z0-9=?@.]*/', $uri) ):  
   	//if isset($_GET['searchterm'])
 
   	//echo $_GET['searchterm'];
	//echo "\n";
	//echo "\n";
	//echo $_GET['key'];
	//echo "\n";
	//echo "\n"; 
	//echo $_GET['email'];
	//echo "\n";
	//echo "\n"; 
	//echo $_GET['filter'];
	//echo "\n";
	//echo "\n"; 
	
	
	//user authentication
	if (isset($_GET['key']) && isset($_GET['email'])) {
		$key = $_GET['key'];
		$param_username = $_GET['email'];
		
		//prepare sql statement
		$sql = "SELECT rest_api_key FROM user WHERE email = ?";
		
		if ($stmt = mysqli_prepare($link, $sql)) {
        		// Bind variables to the prepared statement as parameters
       		 	mysqli_stmt_bind_param($stmt, "s", $param_username);

        		// Set parameters
        		$param_username = $_GET['email'];
        
        		// Attempt to execute the prepared statement
        		if (mysqli_stmt_execute($stmt)) {
            			//echo "inside mysqli_stmt_execute";
            			// Store result
            			mysqli_stmt_store_result($stmt);

            			// Check if username exists, if yes then verify the key
            			if (mysqli_stmt_num_rows($stmt) == 1) {
                			// Bind result variables
                			mysqli_stmt_bind_result($stmt, $rest_api_key);

                		if (mysqli_stmt_fetch($stmt)) {
                		
                			if ($rest_api_key == $key) {
                        			 echo "access allowed";
                        			 //start search fuction
                        			 if (isset($_GET['searchterm'])){
                        			 	echo "\n"; 
							echo "\n"; 
                        			 	echo "You are searching for :" .$_GET['searchterm'];
                        			 	echo "\n"; 
							echo "\n";  
							$filter = $_GET['filter'];
                        			 	
                        			 	$searchterm = $_GET['searchterm'];
   							//#validate searchterm
        						$searchterm = trim($searchterm ); 
        						// #sanitize searchterm
        						$searchterm = strip_tags($searchterm);
        
							$json_ = '{
								"from": 0,
								"size":  '.$filter.',
						  		"query": {
						  			"bool":{
						  				"should":[
						    			{"match_phrase": 
						    			{"advisor":  "'.$searchterm.'"}},
							     		{"match_phrase": 
							     		{"author":  "'.$searchterm.'"}},
							    		 {"match_phrase": 
							     		{"degree":  "'.$searchterm.'"}},
							     		{"match_phrase": 
							     		{"program":  "'.$searchterm.'"}},
							     		{"match_phrase": 
							     		{"text":  "'.$searchterm.'"}},
							     		{"match_phrase": 
							     		{"title":  "'.$searchterm.'"}},
							     		{"match_phrase": 
							     		{"university":  "'.$searchterm.'"}}
							    
							    		]
							    		}
							    		},
							    		"highlight" : {
										"type":"unified",
						       	 			"number_of_fragments": 3,
										"fields": {
							  				"title":{}
										}
						    			}
							    	}';
							//echo $json_;
							$params_ = [
							 'index' => 'metadata',
							 'body' => $json_
							 
							];
	
							$response = $client->search($params_);
							//echo serialize($response);
						     
							$output_n = ($response['hits']['total']['value']);
							echo ($response['hits']['total']['value']);
							
							if((int)$output_n==0){
								echo "No results found, Please try again";
							}else if((int)$output_n!=0){
								foreach($response['hits']['hits'] as $r){
									echo "Tilte:" .($r['_source']['title']);
									//$url = "http://localhost:5000/src/search_summary.php?searchterm=science&doc_id=I-qUwYsB7qMBvh1_chcr";
									
								//echo "<a href="" >$r['_source']['title'])</a>";
									echo "\n";
								}
							
							}
		
                        			 }
                        			 
                   			 } else {
                        			 echo 'verification error';
                    			}

                    	// Close statement
                    	mysqli_stmt_close($stmt);
                	}
            	}
        }
    }
     // Close connection
    mysqli_close($link);
}	
   	break;
   	//$searchterm = basename($uri);
   	//echo $searchterm;
   	//echo $uri;
   	//$url_components = parse_url($uri);
   	//parse_str($url_components['query'], $params);
   	//echo ' Hi '.$params['searchterm'];	
   	//echo $url_components;
   	
   	//$_SESSION['searchterm_cli'] = $params['searchterm'];
   	//echo $_SESSION['searchterm_cli']; 
   	
   	//header('location:pagination_cli.php');
   	
   	$searchterm = $params['searchterm'];
   	//#validate searchterm
        $searchterm = trim($searchterm ); 
        // #sanitize searchterm
        $searchterm = strip_tags($searchterm);
        
        $json_ = '{
        	"from": '.((($page_number-1)*$per_page_count)+1).',
		"size": '.$per_page_count.',
  		"query": {
  			"bool":{
  				"should":[
    			{"match_phrase": 
    			{"advisor":  "'.$searchterm.'"}},
             		{"match_phrase": 
             		{"author":  "'.$searchterm.'"}},
            		 {"match_phrase": 
             		{"degree":  "'.$searchterm.'"}},
             		{"match_phrase": 
             		{"program":  "'.$searchterm.'"}},
             		{"match_phrase": 
             		{"text":  "'.$searchterm.'"}},
             		{"match_phrase": 
             		{"title":  "'.$searchterm.'"}},
             		{"match_phrase": 
             		{"university":  "'.$searchterm.'"}}
            
            		]
            		}
            		},
            		"highlight" : {
        			"type":"unified",
       	 			"number_of_fragments": 3,
        			"fields": {
          				"title":{}
        			}
    			}
            	}';
	//echo $json_;
	$params_ = [
	 'index' => 'metadata',
	 'body' => $json_
	 
	];
	
	$response = $client->search($params_);
	//echo serialize($response);
       
	//$_SESSION['response'] = serialize($response);
	//echo $_SESSION['response'];
	
   	//echo 'hellooo';
       break;
   /*
   * Path: GET /api/users/{id}
   * Task: get one user
   */
   
   case ($method == 'GET' && preg_match('/\/api\/search[?]searchterm[=a-z]/', $uri)):
    	$last_term = basename($uri);
    	//echo $last_term;
    	echo "\r\n";
    	$searchterm_ = explode("=",$last_term);
    	//echo $searchterm_[1];
    	
    	$searchterm_cli = $searchterm_[1];
    	//echo $searchterm_cli;
    	
        $searchterm = $searchterm_cli;
   	//#validate searchterm
        $searchterm = trim($searchterm ); 
        // #sanitize searchterm
        $searchterm = strip_tags($searchterm);
        
        $json_ = '{
        	"from": '.((($page_number-1)*$per_page_count)+1).',
		"size": '.$per_page_count.',
  		"query": {
  			"bool":{
  				"should":[
    			{"match_phrase": 
    			{"advisor":  "'.$searchterm.'"}},
             		{"match_phrase": 
             		{"author":  "'.$searchterm.'"}},
            		 {"match_phrase": 
             		{"degree":  "'.$searchterm.'"}},
             		{"match_phrase": 
             		{"program":  "'.$searchterm.'"}},
             		{"match_phrase": 
             		{"text":  "'.$searchterm.'"}},
             		{"match_phrase": 
             		{"title":  "'.$searchterm.'"}},
             		{"match_phrase": 
             		{"university":  "'.$searchterm.'"}}
            
            		]
            		}
            		},
            		"highlight" : {
        			"type":"unified",
       	 			"number_of_fragments": 3,
        			"fields": {
          				"title":{}
        			}
    			}
            	}';
	//echo $json_;
	$params_ = [
	 'index' => 'metadata',
	 'body' => $json_
	 
	];
	
	$response = $client->search($params_);
	//echo serialize($response);
	//$result = serialize($response);
	$output_n = ($response['hits']['total']['value']);
	//echo ($response['hits']['total']['value']);
	
	if((int)$output_n==0){
		echo "No results found, Please try again";
	}else if((int)$output_n!=0){
		foreach($response['hits']['hits'] as $r){
			echo ($r['_source']['title']);
			echo "\n";
		}
	
	}
	
	
       
	//$_SESSION['response'] = serialize($response);
	//echo $_SESSION['response'];
        
        	
    	//echo 'hello!';
       break;
   
   case ($method == 'GET' && preg_match('/\/api\/users[?]searchterm[=a-z+a-z&]/', $uri)):
   	echo 'hellooo';
       break;
   /*
   * Path: PUT /api/users/{id}
   * Task: update one user
   */

   default:
       break;
}



?>


