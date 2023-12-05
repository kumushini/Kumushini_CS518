<?php 

require_once 'es_config.php';

session_start();

$curr_page = isset($_SESSION['curr_page']) ? $_SESSION['curr_page'] :1;
//echo $curr_page;
//$response_ =$_SESSION['response'];


$response_ = unserialize($_SESSION['response']);
 //echo $response_;
 
if (isset($_SESSION['current_doc_id']) && ($_SESSION['current_doc_id'] != $_GET['doc_id'])) {
 	echo "<script>console.log('empty current_doc_id')</script>";	
 	//echo $_GET['doc_id'];
 	//echo '<br>';
 	//echo $_SESSION['current_doc_id'];
 	
 	$params = session_get_cookie_params();
 	setcookie(session_name(), '', 0, $params['path'], $params['domain'], $params['secure'], isset($params['httponly']));
 	
 	//if (isie)
 	//session_destroy();
 	//session_start();
 	//echo 'success';
 }
 	

 //echo $_SESSION['test1'];
 //echo $_GET['doc_id'];
 
 if (!empty($_GET['doc_id']))
 	//session_start();
 	
	$doc_id = $_GET['doc_id']; 
	$_SESSION['current_doc_id'] = $doc_id;
	
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
    <title>Search summary</title>

    <link rel="shortcut icon" href="./../assets/images/favicon.png" type="image/x-icon">
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
    
    <style>
   body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
   }

   .openChatBtn {
      background-color: rgb(123, 28, 179);
      padding: 16px 20px;
      border: none;
      font-weight: 500;
      font-size: 18px;
      cursor: pointer;
      opacity: 0.8;
      position: fixed;
      bottom: 10px;
      right: 28px;
      width:256px;
   }
    .btn-success {
    padding: 16px 20px;
      position: fixed;
      bottom: 10px;
      right: 28px;
      width:256px;
   }
   #data{
      position: fixed;
      bottom: 74px;
      right: 28px;
      width:256px;
   }
   
   .openChat {
      display: none;
      position: fixed;
      
      right: 28px;
      width: 280px;
      
      bottom: 0;
      right: 15px;
      border: 2px solid maroon;
      z-index: 9;
      background-color: rgba(211, 211, 211,0.8);
   }
   form {
      max-width: 300px;
      padding: 16px 20px;
      
   }

   form .btn {
      color: white;
      padding: 16px 20px;
      font-weight: bold;
      border: none;
      cursor: pointer;
      width: 100%;
      margin-bottom: 10px;
      opacity: 0.8;
   }

   form .btn:hover, .openChatBtn:hover {
      opacity: 1;
   }
</style>

    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="./../assets/images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="./../assets/css/distcssbootstrap453.min.css" />

    
    <!--<link rel="stylesheet" href="style.css">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    
    


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
                            <td>

                             <?php 
                             $text = $doc_details['hits']['hits'][0]['_source']['text']; 
                             $text = trim($text, "['']" ); 
                             $abstract_for_chat_bot = $text;
                             
                             $abstract_for_chat_bot = htmlspecialchars(json_encode($abstract_for_chat_bot), ENT_SUBSTITUTE, 'UTF-8');
			    //$new_str =  ltrim($new_str,$new_str[0]);
			    //$abstract_for_chat_bot = rtrim($new_str,$new_str[-1]);
                             
                             foreach($doc_details['hits']['hits'][0]['_source']['wikifier_terms'] as $r){
						
			$repl_text = "<a href='".$r['url']."'>".$r['term']."</a>"; 
			
			
			 $text = str_ireplace($r['term'],$repl_text,$text); 
			 ?>

			<?php 
                        }
                        echo $text;
                        ?>
                           </td>
                        </tr>
                        
                        

            </tbody>
        </table>
        
        
        <button type="button" class="btn btn-secondary"><a href="./../assets/ETD_papers/<?php echo $doc_details['hits']['hits'][0]['_source']['etd_file_id'];?>.pdf" download target="_blank">Download pdf</a></button>
        
        <br>
        <br>
    </div>



<!-- chat bot -->
<button class="openChatBtn" onclick="openForm()">ChatBot</button>

<div class="openChat" style="height: 500px;">
	<button type="button" style="width: 60px;font-size:0.7em;" class="btn-warning btn-sm float-right p-0" onclick="closeForm()">Minimize</button>
	<form method ="post">
	
	
	
	<h4 style="text-align:left;">Archiva ChatBot</h4>
	
	<div style="height: 260px; overflow-y: auto;">
		<div class="form" >
		    <div class="bot-inbox inbox">
		        <div class="icon"><i class="fas fa-user"><span style="padding-left:3px;font-style:italic;font-size:0.7em;"> Archiva</span></i></div>
		        <div class="msg-header">
		            <p class="p-1" style="background-color:rgb(192,192,192);">Hello there, Here is a small summary on the study. Feel free to ask any question!</p>
		        </div>
		    </div>
		</div>
	</div>
	
        <div>
            <div class="input-data">
                <input class='input' id="data" type="text" placeholder="Type something here.." required>
                <button class="btn-success" id="send-btn">Send</button>
            </div>
        </div>
	
	
	</form>
	
	 
</div>


 

    
    <script src="./../assets/js/popper.min.js"></script>
    <script src="./../assets/js/bootstrap.min.js"></script>
    <!-- <script src="./../assets/js/jquery-3.5.1.slim.min.js"></script> -->
    
    
    <script>
   document .querySelector(".openChatBtn") .addEventListener("click", openForm);
   document.querySelector(".btn-warning").addEventListener("click", closeForm);
   
   function openForm() {
      document.querySelector(".openChat").style.display = "block";
      
      $first_question = "Based on this content provide me a single sentence summary".concat(<?php echo $abstract_for_chat_bot;?>);
      $start_message = "Based on this content answer the upcoming questions ".concat(<?php echo $abstract_for_chat_bot;?>);
       console.log($start_message);

        
        $msg_intial = '<div class="user-inbox inbox text-end"><div class="msg-header" style="text-align:right;color:rgb(25,25,112);"><i class="fas fa-user" style="color:rgb(25,25,112);"><span style="padding-left:3px;font-style:italic;font-size:0.7em;"> You</span></i><p style="text-align:right;"><span class="p-1" style="background-color:rgb(173,216,230);">'+ $first_question +'</span></p></div></div>';
        
        
        
        //$(".form").append($msg_intial);
        
        //$("#data").val('');
        
        // start ajax code
        $.ajax({
            url: 'send_request_to_open_ai.php',
            type: 'POST',
            data: 'text='+$first_question,
            success: function(result){
                $replay = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-user"><span style="padding-left:3px;font-style:italic;font-size:0.7em;"> Archiva</span></i></div><div class="msg-header"><p class="p-1" style="background-color:rgb(192,192,192);">'+ result +'</p></div></div>';
                $(".form").append($replay);
                // when chat goes down the scroll bar automatically comes to the bottom
                $(".form").scrollTop($(".form")[0].scrollHeight);
            }
        });

   }
   function closeForm() {
      document.querySelector(".openChat").style.display = "none";
      
   }
</script>


<script>
        $(document).ready(function(){
            $("#send-btn").on("click", function(){
                $value_ = $("#data").val();
                console.log($value_);
                
                //send openai request
                
                //respnonse
                
                $msg_ = '<div class="user-inbox inbox text-end"><div class="msg-header" style="text-align:right;color:rgb(25,25,112);"><i class="fas fa-user" style="color:rgb(25,25,112);"><span style="padding-left:3px;font-style:italic;font-size:0.7em;"> You</span></i><p style="text-align:right;"><span class="p-1" style="background-color:rgb(173,216,230);">'+ $value_ +'</span></p></div></div>';
                
                
                
                $(".form").append($msg_);
                
                $("#data").val('');
                
                // start ajax code
                $.ajax({
                    url: 'send_request_to_open_ai.php',
                    type: 'POST',
                    data: 'text='+$value_,
                    success: function(result){
                        $replay = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-user"><span style="padding-left:3px;font-style:italic;font-size:0.7em;"> Archiva</span></i></div><div class="msg-header"><p class="p-1" style="background-color:rgb(192,192,192);">'+ result +'</p></div></div>';
                        $(".form").append($replay);
                        // when chat goes down the scroll bar automatically comes to the bottom
                        $(".form").scrollTop($(".form")[0].scrollHeight);
                    }
                });
            });
        });
    </script>

  
    
    

</body>

<footer class="bg-body-tertiary text-center text-lg-start" style="width:100%; bottom:0;">
  <!-- Copyright -->
  <div class="text-center p-3" style="background-color: rgba(60, 60, 60); color:white;">
   Please feel free to contact us for any queries.<br>
   Phone:+1-757-1234567 <br>Email:info@archiveia.com | All rights reserved.
  </div>
  <!-- Copyright -->
</footer>

</html>
