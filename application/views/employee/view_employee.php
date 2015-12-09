<div class="row">
	<div class="col-md-12 text-center">
        <h1> Employee  Details </h1>
    </div>

</div>

<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<?php echo $this->session->flashdata('delete_image'); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
		
		<div class="row">
			<div class="col-md-6"><label>Name</label></div>
			<div class="col-md-6"><label><?php  echo $employee['emp']->name;?></label></div>
		</div>
		<div class="row">
			<div class="col-md-6"><label>Email</label></div>
			<div class="col-md-6"><label><?php  echo $employee['emp']->email;?></label></div>
		</div>
		<div class="row">
			<div class="col-md-6"><label>Mobile</label></div>
			<div class="col-md-6"><label><?php  echo $employee['emp']->mobile;?></label></div>
		</div>
		<?php 
		if(count($employee['images']))
		{
			$sn=1;
			echo '<div class="row">';
			foreach($employee['images'] as $img)
			{
				
				$url=base_url()."uploads/".$img['image'];
				echo '<div class="col-md-4"><img src="'.$url.'" class="img-responsive img-thumbnail" style="width:300px;height:auto;max-height: 100px;">
				<a href="'.site_url('employees/delete_image').'/'.$img['id'].'/'.$employee['emp']->id.'">Delete</a></div>';
				$sn++;
			}
			echo '</div>';
		}
		
		?>
		
		
		</div>	
	</div>
</div>


</div>
