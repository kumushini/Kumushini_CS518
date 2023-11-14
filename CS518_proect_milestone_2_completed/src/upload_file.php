<?php  
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$target_path = "/home/kthen001/Documents/CS518_project/assets/ETD_papers/";  
		$target_path = $target_path.basename( $_FILES['fileToUpload']['name']);   

		if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_path)) {  
		echo "File uploaded successfully!";  
		} else{  
		echo "Sorry, file not uploaded, please try again!";  
		}
	}  
?>  

<!doctype html>
<html lang="en">

<head>
   <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload item</title>
    <link rel="stylesheet" type="text/css" href="./../assets/css/distcssbootstrap453.min.css" />

    <!--<link rel="stylesheet" type="text/css" href="./assets/css/distcssbootstrap453.min.css" />-->
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
    	<br><br>
    	
    	<a class="btn btn-secondary" href="add_item.php" role="button">Previous page</a>
    	<br><br>
    	
    	<div>
	<h4>Upload pdf here...</h4>
	</div>
	<br><br>
    
    	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
      
        Select File:  
        <input type="file" name="fileToUpload"/>  
        <input type="submit" value="Upload Image" name="submit"/>  
     </form>  




    <script src="./assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="./assets/js/popper.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
</body>

</html> 
