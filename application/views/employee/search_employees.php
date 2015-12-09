<div class="container" id="all_data">
<div class="row margin-bottom">
	<div class="col-md-12 text-center">
        <h1> Employees List </h1>
    </div>

</div>

<div class="row margin-bottom">
	<div class="col-md-12 text-center">
          <?php $attributes = array("name" => "search","id"=>"search_form","class"=>"form-inline");
            echo form_open("employees/search", $attributes);
            ?>     
				<div class="form-group">
					<label for="email">Email address</label>
					<input type="text" class="form-control" name="email" value="<?php echo $email; ?>" id="email">
				</div>
				<div class="form-group">
					<label for="name">Name </label>
					<input type="text" class="form-control" name="name" value="<?php echo $name; ?>" id="name">
			  </div>
       
				  
			  <div class="form-group">
				<label for="jd">Join Date</label>
				<input type="text" class="form-control" name="jd" value="<?php echo $jd; ?>" placeholder="yyyy-mm-dd" id="jd">
			  </div>
			
				<button type="submit" class="btn btn-success"  id="search"  name="search">Search</button>

		<?php echo form_close(); ?>
    </div>

</div>

				<?php 				  
				  $page_num = (int)$this->uri->segment(5);
				  if($page_num==0) $page_num=1;
				  $order_seg = $this->uri->segment(4,"asc"); 
				  if($order_seg == "asc") $order = "desc"; else $order = "asc";
				?>    

	<div class="row margin-bottom">
		<div class="col-md-6 col-md-offset-3">
			<?php echo $this->session->flashdata('delete'); ?>
		</div>
	</div>
 <div class="table-responsive margin-bottom">          
  <table class="table">
    <thead>
      <tr>
        <th>S.No</th>
        <th><a href="<?php echo base_url();?>employees/search/name/<?=$order?>/<?=$page_num?>">Name</a></th>
        <th><a href="<?php echo base_url();?>employees/search/email/<?=$order?>/<?=$page_num?>">Email</a></th>
        <th>Mobile</th>
        <th><a href="<?php echo base_url();?>employees/search/create_date/<?=$order?>/<?=$page_num?>">Join Date</a></th>
        <th>Action</th>
        
      </tr>
    </thead>
    <tbody>
		
		 <?php 	
		 
		 
		 if(is_array($emp_data)):
			$page = $this->uri->segment(5);
			$sn=1;
			if(isset($page) && !empty($page) && $page !=1 )
			{
			 $sn=($page-1)*5+1;
			}
			foreach($emp_data as $emp) : 
			?>
			<tr>
				<td><?php echo $sn; ?></td>
				<td><?php echo $emp['name']; ?></td>
				<td><?php echo $emp['email']; ?></td>
				<td><?php echo $emp['mobile']; ?></td>
				<td><?php echo date('d-m-Y',strtotime($emp['create_date']));  ?></td>
				<td><a href="<?php echo site_url('employees/view').'/'.$emp['id'] ; ?>">View</a> | <a href="<?php echo site_url('employees/edit').'/'.$emp['id'] ; ?>">Edit</a> | <a href="<?php echo site_url('employees/delete').'/'.$emp['id'] ; ?>" onclick="return confirm('Are you sure');">Delete</a></td>
		   </tr>
		  <?php 
		  $sn++;
		  endforeach;
		  endif;
		  ?> 
    </tbody>
  </table>
  </div>
  <?php echo $links; ?>
</div>
		

</div>
