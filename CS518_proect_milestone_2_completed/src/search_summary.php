<?php 

require_once 'es_config.php';

session_start();

$curr_page = isset($_SESSION['curr_page']) ? $_SESSION['curr_page'] :1;
//echo $curr_page;
//$response_ =$_SESSION['response'];


$response_ = unserialize($_SESSION['response']);
 //echo $response_;

 //echo $_SESSION['test1'];
 //echo $_GET['doc_id'];
 
 if (!empty($_GET['doc_id']))
 	//session_start();
 	
	$doc_id = $_GET['doc_id']; 
	//echo $doc_id;
	$searchterm = $_GET['searchterm'];
	//echo $searchterm;

	   $params = [
		'index' => 'metadata',
		'body'  => [
		    'query' => [
			'bool' => [
			    'must' => [
			        'match' => ['_id' => $doc_id]
			    ]
			]
		    ]
		]
	    ];
	    
	    $doc_details = $client->search($params);
	    //echo $doc_details;
	    

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>search summary</title>

    <link rel="stylesheet" type="text/css" href="./../assets/css/distcssbootstrap453.min.css" />

    <style>
        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 360px;
            padding: 20px;
        }
    </style>


</head>

<body>

    <?php
    include("navbar.php");
    ?>
    
<br>
<br> 

<!-- <button type="button" class="btn btn-secondary"><a href ="search_.php">Previous page</a></button>-->
<a class="btn btn-secondary" href="pagination_index.php?page=<?php echo $curr_page;?>&perpage=<?php echo "10";?>&searchterm=<?php echo $searchterm;?>" role="button">Previous page</a>

<br>
<br> 

<div class="container">
        <table class="table table-bordered table-hover">
            <tbody>
                        <tr>
                            <td>Title</td>
                            <td><?php echo $doc_details['hits']['hits'][0]['_source']['title']; ?></td>
                        </tr>
                        <tr>
                            <td>Author</td>
                            <td><?php echo $doc_details['hits']['hits'][0]['_source']['author']; ?></td>
                        </tr>
                        <tr>
                            <td>Year</td>
                            <td><?php echo $doc_details['hits']['hits'][0]['_source']['year']; ?></td>
                        </tr>
                        <tr>
                            <td>University</td>
                            <td><?php echo $doc_details['hits']['hits'][0]['_source']['university']; ?></td>
                        </tr>
                        <tr>
                            <td>Program</td>
                            <td><?php echo $doc_details['hits']['hits'][0]['_source']['program']; ?></td>
                        </tr>
                        <tr>
                            <td>Degree</td>
                            <td><?php echo $doc_details['hits']['hits'][0]['_source']['degree']; ?></td>
                        </tr>
                        <tr>
                            <td>Advisor</td>
                            <td><?php echo $doc_details['hits']['hits'][0]['_source']['advisor']; ?></td>
                        </tr>
                        <tr>
                            <td>abstract</td>
                            <td><?php $text = $doc_details['hits']['hits'][0]['_source']['text']; 
                             echo trim($text, "['']" ); ?></td>
                        </tr>

            </tbody>
        </table>
        
        <button type="button" class="btn btn-secondary"><a href="./../assets/ETD_papers/<?php echo $doc_details['hits']['hits'][0]['_source']['etd_file_id'];?>.pdf" download target="_blank">Download pdf</a></button>
        
        <br>
        <br>
    </div>

    

    <script src="./../assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="./../assets/js/popper.min.js"></script>
    <script src="./../assets/js/bootstrap.min.js"></script>

</body>

</html>
