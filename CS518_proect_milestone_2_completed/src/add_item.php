<?php

session_start();

require_once "es_config.php";

$title = $author = $advisor = $degree = $program = $text = $university = $year ="";
$title_err = "";

if(isset($_POST["title"])){
	$title = trim($_POST['title']); 
	$title = strip_tags($title);}
if(isset($_POST["author"])){
	$author = trim($_POST['author']); 
	$author = strip_tags($author);}
if(isset($_POST["advisor"])){
	$advisor = trim($_POST['advisor']); 
	$advisor = strip_tags($advisor);}
if(isset($_POST["year"])){
	$year = trim($_POST['year']); 
	$year = strip_tags($year);}
if(isset($_POST["university"])){
	$university = trim($_POST['university']); 
	$university = strip_tags($university);}
if(isset($_POST["degree"])){
	$degree = trim($_POST['degree']); 
	$degree = strip_tags($degree);}
if(isset($_POST["program"])){
	$program = trim($_POST['program']); 
	$program = strip_tags($program);}
if(isset($_POST["text"])){
	$text = trim($_POST['text']); 
	$text = strip_tags($text);}

//if (empty($title)){
 //     echo  "Title can't be empty";
//	exit();
//	}

if (!empty(isset($_POST['title']))){

$json_ = '{
	"query": {
        "match_all": {}
    	}
}';

$params_ = [
    'index' => 'metadata',
     	'body' => $json_
      ];
      
    $results = $client->search($params_);
    $etd_id = $results['hits']['total']['value'] + 1;
    //echo $etd_id;
    
//$json ='{
//	"advisor": "'.$advisor.'",
//	"author": "'.$author.'",
//	"degree": "'.$degree.'",
//	"program": "'.$program.'",
//	"text": "'.$text.'",
//	"title": "'.$title.'",
//	"university": "'.$university.'",
//	"etd_file_id": "'.$etd_id.'",
//	"year": "'.$year.'",
//	"wikifier_terms": " "
//	}' ;  

//$params = ['index' => 'metadata',
//	'body' => $json
//		];	

	
$params = ['index' => 'metadata',
	'body' => [
		'advisor' => $advisor,
		'author' => $author,
		'degree' => $degree,
                'etd_file_id' => $etd_id,
		'program' => $program,
		'text' => $text,
		'title' => $title, 
		'university' => $university,
		'year' => $year]
		];	

$response = $client->index($params);

//echo "<br><br><br>" ;
//echo "New item added succesfully! ";

header("location:upload_file.php");   
}
	
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add new item</title>
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

    <div class="wrapper container">

        <h2>Add new dissertation item</h2>
        <p>Enter information to add new file</p>
        <form action="add_item.php" method="post">

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control"> 
            </div>
            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" name="author" id="author" class="form-control">
            </div>
            <div class="form-group">
                <label for="year">Year</label>
                <input type="year" name="year" id="year" class="form-control">
            </div>
            <div class="form-group">
                <label for="advisor">Advisor</label>
                <input type="text" name="advisor" id="advisor" class="form-control">
            </div>
            <div class="form-group">
                <label for="university">University</label>
                <input type="text" name="university" id="university" class="form-control">
            </div>
            <div class="form-group">
                <label for="degree">Degree</label>
                <input type="text" name="degree" id="degree" class="form-control">
            </div>
            <div class="form-group">
                <label for="program">Program</label>
                <input type="text" name="program" id="program" class="form-control">
            </div>
            <div class="form-group">
                <label for="text">Abstract</label>
                <input type="text" name="abstract" id="abstract" class="form-control">
            </div>
          
            <div class="form-group">
                    <!--<input type="file" id="myFile" name="file" >
                    <br><br>-->
                    <input type="submit" class="btn btn-primary" value="Add item" >
                
            </div>
        </form>
    </div>


    <script src="./../assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="./../assets/js/popper.min.js"></script>
    <script src="./../assets/js/bootstrap.min.js"></script>
</body>

</html>
