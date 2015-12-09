<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if (isset($title)) { echo $title;  }  ?></title>
    <link href="<?php echo base_url("css/bootstrap.css"); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url("css/style.css"); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url("css/jquery.Jcrop.css"); ?>" rel="stylesheet" type="text/css" />
   
</head>
<body>
<div class="container">
	<nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a href="<?php echo site_url(); ?>" class="navbar-brand">CI TEST</a>
          </div>
          <div class="navbar-collapse collapse" id="navbar">
            <ul class="nav navbar-nav">
              <li class="active"><a href="<?php echo site_url(); ?>">Home</a></li>
            <?php   if($this->auth->get_userrole() == 1)
				{
					echo ' <li><a href="'.site_url('employees/add_emp').'">Add Employee</a></li>';
					echo '<li><a href="'.site_url('employees/view_list').'">View Employees</a></li>';
				} ?>
               <?php 
              if($this->auth->logged_in())
				{
					echo '<li><a href="'.site_url('user/home').'">Profile</a></li>';
					echo '<li><a href="'.site_url('user/logout').'">Logout</a></li>';
				}
				else
				{
					//echo ' <li><a href="'.site_url('user/login').'">Login User</a></li>';
					 echo '<li><a href="'.site_url('user/register').'">Register User</a></li>';
				}
              ?>
             </ul>
            
          </div>
        </div>
      </nav>

<?php if (isset($content)) { echo $content;  }  ?>



</div>
<script type="text/javascript" src="<?php echo base_url("js/jquery.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/jquery.validate.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/bootstrap.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/jquery.Jcrop.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/bootstrap-datepicker.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/script.js"); ?>"></script>
<script type="text/javascript">
$(document).ready(function() {
	  
	  $(document).on("click","#jd", function(){
		  $(this).datepicker({
			  format: "yyyy-mm-dd"
			});
	  });
		 $('#jd').datepicker({
			  format: "yyyy-mm-dd"
			});
			
			
		$("#add_employee").validate({
			debug: false,
			errorElement: "p",
			errorClass:"text-danger",
			rules: {
				name: "required",
				email: {
					required: true,
					email: true
				},
				mobile: {
					required: true,
					number: true,
					minlength: 10,
					
				},
				images: "required"
			},
			messages: {
				name: "Please enter your name",
				email: {
					required: "Please enter a email",
					email: "Please enter a valid email address"
				},
				mobile: {
					required: "Please enter your mobile",
					number: "Please enter a valid Mobile number",
					minlength: "Your mobile number must be at least 10 characters long"
				},
				images: "Please select at least 1 image"
			},
			  submitHandler: function(form) {
					form.submit();
				}
		});
		
		
		
		$("#add_new_employee").validate({
			debug: false,
			errorElement: "p",
			errorClass:"text-danger",
			rules: {
				name: "required",
				email: {
					required: true,
					email: true
				},
				mobile: {
					required: true,
					number: true,
					minlength: 10,
					
				},
				images: "required"
			},
			messages: {
				name: "Please enter your name",
				email: {
					required: "Please enter a email",
					email: "Please enter a valid email address"
				},
				mobile: {
					required: "Please enter your mobile",
					number: "Please enter a valid Mobile number",
					minlength: "Your mobile number must be at least 10 characters long"
				},
				images: "Please select at least 1 image"
			},
			  submitHandler: function(form) {
					form.submit();
				}
		});
		
		$("#add_new_employee").submit(function()
		{
				
				checkForm();
				//return false;
		});
	
	
		$("#edit_employee").validate({
			debug: false,
			errorElement: "p",
			errorClass:"text-danger",
			rules: {
				name: "required",
				email: {
					required: true,
					email: true
				},
				mobile: {
					required: true,
					number: true,
					minlength: 10,
					
				}
				
			},
			messages: {
				name: "Please enter your name",
				email: {
					required: "Please enter a email",
					email: "Please enter a valid email address"
				},
				mobile: {
					required: "Please enter your mobile",
					number: "Please enter a valid Mobile number",
					minlength: "Your mobile number must be at least 10 characters long"
				}
				
			}
			
		});
		
		
		$("#user_login").validate({
			debug: false,
			errorElement: "p",
			errorClass:"text-danger",
			rules: {
				password: "required",
				email: {
					required: true,
					email: true
				}
			},
			messages: {
				password: "Please enter your password",
				email: {
					required: "Please enter a email",
					email: "Please enter a valid email address"
				}
			},
			  submitHandler: function(form) {
					form.submit();
				}
		});
		
		$("#add_new_user").validate({
			debug: false,
			errorElement: "p",
			errorClass:"text-danger",
			rules: {
				name: "required",
				image_file:"required",
				email: {
					required: true,
					email: true
				},
				password: {
					required: true,
					minlength: 5
				}
				
			},
			messages: {
				name: "Please enter your name",
				image_file: "Please select image",
				email: {
					required: "Please enter a email",
					email: "Please enter a valid email address"
				},
				password: {
					required: "Please enter your Password",
					minlength: "Your Password must be at least 5 characters long"
				}				
			}
			
		});
		
		$(document).on("click",".ajax a", function(){
			var url=$(this).attr('href');
			if(url)
			{
				$.ajax({
				type: "POST",
				url: $(this).attr('href'),
				data:$("#search_form").serialize(),
				success: function(html){				
					$("#all_data").html(html);
					}
				});  
			}
		
		return false;
			
		}); 
		$(document).on("click","#search", function(){
			$.ajax({
					type: "POST",
					url: $("#search_form").attr('action'),
					data:$("#search_form").serialize(),
					success: function(html){
						$("#all_data").html(html);
					}
				});
			return false;
		
		}); 
			
	});
	
	
		
</script>
</body>
</html>
