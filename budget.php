<?php
	
	include'function.php';
	include 'dbconn.php';
	  include 'session.php';
	unset($_SESSION['msg']);
  //include'loginck.php';
	//include 'budgetexec.php';
	if(isset($_SESSION ['eeid'])){
		
		$eeid = $_SESSION['eeid'];
		//getuser($userid)
		$sql = "SELECT * FROM entertainmentestablishment WHERE eeid=?";
		$stm = $con->prepare($sql);
		$stm->execute(array($eeid));
		$user = $stm->fetch();
		$seller = $_SESSION['id'] = $user['eeid'];
		$_SESSION['mem_id'] = $user['mem_id'];

		$fullname = ucfirst($user['name']);

		include'sell_image.php';
	 }
		

  
     	
      if(isset($_POST['submit'])){
          $name= $_POST['name'];
          $description= $_POST['description'];
          $price= $_POST['price'];
 						
		
		

					 $sql = "INSERT INTO eventbudget (name, description, price)VALUES (:name, :description, :price);";
            $stm = $con->prepare($sql);
            $stm->execute(array(

               ":name" =>$name, 
               ":description" =>$description, 
                ":price" =>$price));
 
 
     
      // header("Location: inakala.php");
    
      
		}	
   
   ?>      
			
		


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Event Budget</title>

    <meta name="description" content="Source code generated using layoutit.com">
    <meta name="author" content="LayoutIt!">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
   <link rel="shortcut icon" href="ico/camera.ico">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
    <link href="css/style.css" rel="stylesheet">


    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.0.min.js"></script>
    <script type="text/javascript" src="js/jquery.tooltipster.min.js"></script>



    
   

    <style>

   
			.scr {
			   				     /* Just for the demo          */
			    overflow-x: auto;    /* Trigger vertical scroll    */
			    overflow-y: hidden;  /* Hide the horizontal scroll */
			}
			td{
				padding: 6px;		
			}

			table label{

				font-family: helvetica;
				color:#949494;
			}

			table tr td strong{
				color:#1975FF;
			}

body 
    { 
      background-color: #F0F8FF; 
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-size: cover;
     
    }
  

    </style>
 
		
		


  </head>
  <body>

    <div class="container-fluid">
    	<div class="row">
			<div class="col-md-12">
				
				<br><br><br><br>
				<div class="row">
					<div class="col-md-12">
							
						<?php include 'main-menu.php';?>
						<br><br>

						<form class="form-horizontal" role="form"   method="POST" enctype="multipart/form-data">
								 <div class="" style="color:#1975FF;font-family:cambria" align="center"><h4>Add Event Budget </h4>
								 </div>
								 <center>
								 <div class="form-group">	
								 	<label for="name">
										Package Name
									</label>
                         <input type="text" name="name" required><br></div>

                         <div class="form-group">	<label for="description">
                        Description </label>

                        <textarea rows="6" cols="50" name="description" required></textarea><br></div>


                         <div class="form-group">	<label for="description">
                        Price </label> <input type="decimal" name="price" required><br> </div>

                        <input type="submit" name="submit" value="Submit">
    </center>

    <script>
    $(document).ready(function(){
    	
			    $('[data-toggle="popover"]').popover();   
				
			    $(".btn-info").click(function(){
		        $(".collapse").collapse('toggle');
		    	});

		    	
			});
    </script>
   	
				</div>
			</div>
		</div>
	</div>		


						
						
					
					
       
           
                        
                                                                    
			 					
  
	
															


								
														
												




              


							



														
																			
																				
																				     
	
	

	

  </body>
</html>