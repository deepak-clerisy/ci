<div class="row">
	<div class="col-md-12 text-center">
        <h1> Employee </h1>
    </div>

</div>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Change Employee Details</h3>
        </div>
        <div class="panel-body">
            <?php $attributes = array("name" => "employee","id"=>"edit_employee");
            echo form_open_multipart("employees/update", $attributes);?>
            <div class="form-group">
				<label for="name">Name</label>
                <input class="form-control" name="name" placeholder="Your Full Name" type="text" value="<?php echo $employee['emp']->name; ?>" />
                <span class="text-danger"><?php echo form_error('name'); ?></span>
            </div>
            
            <div class="form-group">
                <label for="email">Email ID</label>
                <input class="form-control" name="email" placeholder="Email-ID" type="text" value="<?php echo $employee['emp']->email; ?>" />
                <span class="text-danger"><?php echo form_error('email'); ?></span>
            </div>

            <div class="form-group">
                <label for="mobile">Mobile</label>
                <input class="form-control" name="mobile" placeholder="Mobile" type="text" value="<?php echo $employee['emp']->mobile; ?>" />
                <span class="text-danger"><?php echo form_error('mobile'); ?></span>
            </div>
             <input type="hidden" name="e_id" value="<?php echo $employee['emp']->id; ?>" />
            <div class="form-group">
                <button name="submit" type="submit" class="btn btn-success">Submit</button>
            </div>
            <?php echo form_close(); ?>
            <?php echo $this->session->flashdata('msg'); ?>
        </div>
    </div>
</div>


</div>
