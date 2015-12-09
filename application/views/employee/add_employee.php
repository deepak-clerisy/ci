<div class="row">
	<div class="col-md-12 text-center">
        <h1> Add Employee </h1>
    </div>

</div>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Enter Employee Details</h3>
        </div>
        <div class="panel-body">
            <?php $attributes = array("name" => "employee","id"=>"add_employee");
            echo form_open_multipart("employees/add", $attributes);?>
            <div class="form-group">
                <label for="name">Name</label>
                <input class="form-control" name="name" placeholder="Your Full Name" type="text" value="<?php echo set_value('name'); ?>" />
                <span class="text-danger"><?php echo form_error('name'); ?></span>
            </div>
            
            <div class="form-group">
                <label for="email">Email ID</label>
                <input class="form-control" name="email" placeholder="Email-ID" type="text" value="<?php echo set_value('email'); ?>" />
                <span class="text-danger"><?php echo form_error('email'); ?></span>
            </div>

            <div class="form-group">
                <label for="mobile">Mobile</label>
                <input class="form-control" name="mobile" placeholder="Mobile" type="text" value="<?php echo set_value('mobile'); ?>" />
                <span class="text-danger"><?php echo form_error('mobile'); ?></span>
            </div>
            
            <div class="form-group">
                <label for="file">Image</label>
                <input type="file" name="images[]" required multiple="" accept=".png,.jpg,.gif,.jpeg" />
                <p class="help-block">jpg,jpeg,gif,png,  Max File Size 5 Mb.</p>
                <span class="text-danger"><?php echo form_error('images'); ?></span>
            </div>
            
            <div class="form-group">
                <button name="submit" type="submit" class="btn btn-success">Submit</button>
            </div>
            <?php echo form_close(); ?>
            <?php echo $this->session->flashdata('msg'); 
            $img_er=$this->session->flashdata('image_error');
            if(isset($img_er))
            {
				
				foreach($img_er as $error)
				{
					echo '<div class="alert alert-danger text-center">'.$error.'</div>';
					
				}
			}
            
            ?>
        </div>
    </div>
</div>


</div>
