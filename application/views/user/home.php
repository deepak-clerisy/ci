<div class="row">
	<div class="col-md-12 text-center">
        <h1> User Home </h1>
    </div>
 </div>
 <div class="row margin-bottom">
		<div class="col-md-6 col-md-offset-3">
		<?php 
			$not_admin= $this->session->userdata('not_admin'); 
			if($not_admin===true)
			{
				echo '<div class="alert alert-danger text-center">Oops! Sorry.  Only Admin Allowed to That Page!!!</div>';
				$this->session->unset_userdata("not_admin");
			}	
		?>
		
		<div class="row margin-bottom">
			<div class="col-md-6"><label>Name</label></div>
			<div class="col-md-6"><label><?php  echo $user_data['name'];?></label></div>
		</div>
		<div class="row margin-bottom">
			<div class="col-md-6"><label>Email</label></div>
			<div class="col-md-6"><label><?php  echo $user_data['email'];?></label></div>
		</div>
		<div class="row margin-bottom">
			<div class="col-md-6"><label>Status</label></div>
			<div class="col-md-6"><label><?php  if($user_data['status']){ echo 'Active' ; } else { echo 'In-Active';} ;?></label></div>
		</div>
		<?php 
		if(!empty($user_data['image']))
		{
			echo '<div class="row margin-bottom">';
			echo '<div class="col-md-6"><label>Profile Image</label></div>';	
				$url=base_url()."uploads/".$user_data['image'];
				echo '<div class="col-md-4"><img src="'.$url.'" class="img-responsive img-thumbnail" style="width:300px;height:auto;max-height: 100px;">
				</div>';				
			echo '</div>';
		}
		
		?>
	
		<div class="row margin-bottom">
			<div class="col-md-6 "><?php echo anchor('user/change_password','Change Password',array('class'=>'btn btn-info'))?></div>
			<div class="col-md-6 "><?php echo anchor('user/logout','Logout',array('class'=>'btn btn-success'))?></div>
			
		</div>
		
		
		
		</div>	
</div>
