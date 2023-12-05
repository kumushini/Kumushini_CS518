<?php

session_start();

require './../vendor/autoload.php'; // remove this line if you use a PHP Framework.

use Orhanerday\OpenAi\OpenAi;

//$open_ai_key = getenv('OPENAI_API_KEY');
$open_ai_key  = "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";
$open_ai = new OpenAi($open_ai_key);





if(isset($_POST['text'])){
	$message =  $_POST['text'];
	//echo $message;
	echo "<script>console.log('Lemos Test console debug')</script>";
	
	if(!isset($_SESSION['messages'])){
		$_SESSION['messages'] = array(array("role" => "user" , "content"=>$message));
		echo "<script>console.log('inside if')</script>";		

	}else{
		
		$_SESSION['messages'][] = array("role" => "user" , "content"=>$message);
		echo "<script>console.log('inside else')</script>";	
	}
	
	$chat = $open_ai->chat([
	   'model' => 'gpt-3.5-turbo',
	   'messages' => $_SESSION['messages'],
	   'temperature' => 1.0,
	   'max_tokens' => 1000,
	   'frequency_penalty' => 0,
	   'presence_penalty' => 0,
	]);
		
	$d = json_decode($chat);
	
	// Get Content
	
	//storing replay to a varible which we'll send to ajax
	if (is_null($d->choices[0]->message->content)){
		$replay = "SORRY, there is a mistake in provided text";
	}else{
		$replay = $d->choices[0]->message->content;		
		$_SESSION['messages'][] = array("role" => "assistant" , "content"=>$replay);
		
	
	}
	echo $replay;
	
}else{
	$message =  "Who won the world series in 2020?";
}


?>
