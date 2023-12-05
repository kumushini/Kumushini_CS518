<?php 


$page_number = isset($_GET['page']) ? (int)$_GET['page'] :1;
$per_page_count = isset($_GET['perpage']) && $_GET['perpage']<=50 ? (int)$_GET['perpage'] :10;


require_once 'es_config.php';
require_once 'spellcheck_test.php';


if(isset($_GET['searchterm'])){
	//session_destory();
	session_start();
	
        #validate searchterm
        $searchterm = trim($_GET['searchterm']); 
        // #sanitize searchterm
        //$searchterm = strip_tags($searchterm);
        
       
        
        $json_ = '{
        	"from":0,
        	"size":1000,
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
	$params = [
	 'index' => 'metadata',
	 'body' => $json_
	 
	];
	$response = $client->search($params);
	//echo $response;
       
	$_SESSION['response'] = serialize($response);
        
        $output_n = $response['hits']['total']['value'];
        
        //$highlights = $response['hits']['hits'][1]['highlight']['title'][0];
	//echo $highlights;
        
        //echo $output_n;
               
        //echo "\r\n\r\n";
        
        //echo "Did you mean... ";
        //echo "\r\n";
        
        //spell checker added 2023/11/13
        $misspellings = $aspell->check($searchterm, ['en_US'], ['from_example']);

	foreach ($misspellings as $misspelling) {
	    echo $misspelling->getSuggestions()[0]; // ['misspell', ...]
	    echo "\r\n";
	    $misspelling->getContext(); // ['from_example']
        }
        
        //echo $searchterm;
       
        $time = ((int)($response['took'])/1000);
        $output = ($response['hits']['hits']);
        
	
	$pagenumber_fast_prev = $page_number>2 ? $page_number-2 :1;
	$pagenumber_prev = $page_number>1 ? $page_number-1:1;
	$pagenumber_next = $page_number+1;
	$pagenumber_fast_next = $page_number+2;
}
 	
else{	
	session_start();
	$searchterm = $_SESSION['searchterm']; 
	
	$json = '{
  		"query": {
    			"match_phrase": {
    			"text": "information processing in basic and applied science"}}}';

	$json_ = '{
		"from": 0,
		"size": 1000,
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
	$params = [
	 'index' => 'metadata',
	 'body' => $json_
	];
	$response = $client->search($params);
	
	//$_SESSION['response'] = $response;
	$_SESSION['response'] = serialize($response);
	//$_SESSION['test1'] = $response['hits']['total']['value'];
	
	$output_n = $response['hits']['total']['value'];
			
        //spell checker added 2023/11/13
        //$misspellings = $aspell->check($searchterm, ['en_US'], ['from_example']);

	//foreach ($misspellings as $misspelling) {
	//    echo $misspelling->getSuggestions()[0]; // ['misspell', ...]
	//    echo "\r\n";
	//    $misspelling->getContext(); // ['from_example']
	//}
	
	$time = ((int)($response['took'])/1000);
	$output = ($response['hits']['hits']);
	
	//$page_count = (int)($output_n / 10);
	
	$pagenumber_fast_prev = $page_number>2 ? $page_number-2 :1;
	$pagenumber_prev = $page_number>1 ? $page_number-1:1;
	$pagenumber_next = $page_number+1;
	$pagenumber_fast_next = $page_number+2;
	
//session_destroy();
 }
 
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kumushini's demo</title>

    <link rel="stylesheet" type="text/css" href="./../assets/css/distcssbootstrap453.min.css" />
    <link rel="stylesheet" type="text/css" href="./../assets/css/kumu_test.css" />

</head>

<body>
    <!-- <h1>Hello, world!</h1> -->
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="./../index.php">Archiveia</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="./../index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
               
                
                
            </ul>
             <form class="input-group input-group-lg" action="pagination.php" method="get" autocomplete="off">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="searchterm">
                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
            </form> 
        </div>
    </nav>
    <table class = "table">
	<tr> <td>
		<?php
			if((int)$output_n != 0){
				$output_n = $response['hits']['total']['value'];
				echo "You are looking for: ";
				print_r($searchterm);
				echo "<br>";
				print_r($time);
				echo " seconds to display ";
				echo "<br>";
				print_r($output_n);
				echo " matches";
			}else {
			 echo "You are looking for: ";
			 print_r($searchterm);
			 echo "<br>";
			 echo "Did you mean: ";
        		 echo "\r\n";
        
        		//spell checker added 2023/11/13
       			 $misspellings = $aspell->check($searchterm, ['en_US'], ['from_example']);

			foreach ($misspellings as $misspelling) {
	    			echo $misspelling->getSuggestions()[0]; // ['misspell', ...]
	    			echo "\r\n";
	    			$misspelling->getContext(); // ['from_example']
        			}
			
			}
		?>
	     </td>
	</tr>	                	
    </table> 
        <?php
        
        if((int)$output_n==0){
		echo "No results found, Please try again";
	}
        else if((int)$output_n!=0){
        	$output_n = $response['hits']['total']['value'];
		//echo $output_n;
		foreach($response['hits']['hits'] as $r){
		
		?>
			<table class = "table">
			<tr>
			<td>
			<a href="search_summary.php?doc_id=<?php echo$r['_id'];$_SESSION['curr_page']=$page_number;?>"><?php if(!empty($r['highlight']['title'])){echo($r['highlight']['title'][0]);}else{echo $r['_source']['title'];}?>
			</a>
			</td></tr>	
        		</table>            
          	<?php     
            }
        }    
        ?>
        
        <nav aria-label="Page navigation example">
  		<ul class="pagination">
  		    	<li class="<?php if (($pagenumber_fast_prev + 1) < $page_number){ echo "page-item";}else{echo "page-item disabled";}?>">
      				<a class="page-link" href="pagination.php?page=<?php echo $pagenumber_fast_prev;?>perpage=<?php echo "10";?>" aria-label="Previous" aria-disabled=<?php if(((int)($output_n/10)) < $page_number){?>"true"<?php } ?>>fast prev
        				<span aria-hidden="true">&laquo;</span>
        				<span class="sr-only">Previous</span>
      				</a>
    			</li>
    			<li class="<?php if ($pagenumber_prev < $page_number){ echo "page-item";}else{echo "page-item disabled";}?>">
      				<a class="page-link" href="pagination.php?page=<?php echo $pagenumber_prev;?>perpage=<?php echo "10";?>" aria-label="Previous" aria-disabled=<?php if(((int)($output_n/10))+1 < $page_number){?>"true"<?php } ?>>prev
        				<span aria-hidden="true">&laquo;</span>
        				<span class="sr-only">Previous</span>
      				</a>
    			</li>
    			
    			
    			<li class="page-item"><a class="page-link" href="pagination.php?page=<?php echo "1";?>perpage=<?php echo "10";?>">1</a></li>


    			<li class="<?php if (((int)($output_n/10)) > $page_number){ echo "page-item";}else{echo "page-item disabled";}?>">
      				<a class="page-link" href="pagination.php?page=<?php echo $pagenumber_next;?>perpage=<?php echo "10";?>" aria-label="Next" aria-disabled=<?php if(((int)($output_n/10)) < $page_number){?>"true"<?php } ?>>next
        				<span aria-hidden="true">&raquo;</span>
        				<span class="sr-only">Next</span>
      				</a>
    			</li>
    			<li class="<?php if (((int)($output_n/10)) >= ($page_number+1)){ echo "page-item";}else{echo "page-item disabled";}?>">
      				<a class="page-link" href="pagination.php?page=<?php echo $pagenumber_fast_next;?>perpage=<?php echo "10";?>" aria-label="Next">fast next
        				<span aria-hidden="true">&raquo;</span>
        				<span class="sr-only">Next</span>
      				</a>
    			</li>
  		</ul>
	</nav>
        
        
        

    <script src="./../assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="./../assets/js/popper.min.js"></script>
    <script src="./../assets/js/bootstrap.min.js"></script>
</body>

</html>
