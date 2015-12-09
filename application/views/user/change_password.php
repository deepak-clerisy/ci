<div class="row">
	<div class="col-md-12 text-center">
        <h1> Change Password </h1>
    </div>

</div>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"></h3>
        </div>
        <div class="panel-body">
            <?php $attributes = array("name" => "change_password","id"=>"change_password");
            echo form_open("user/change_password", $attributes);?>
            

            <div class="form-group">
                <label for="password">Current Password</label>
                <input class="form-control" name="password" placeholder="password" type="password" value="<?php echo set_value('password'); ?>" />
                <span class="text-danger"><?php echo form_error('password'); ?></span>
            </div>
             <div class="form-group">
                <label for="n_password">New Password</label>
                <input class="form-control" name="n_password" placeholder="New password" type="password" value="<?php echo set_value('n_password'); ?>" />
                <span class="text-danger"><?php echo form_error('n_password'); ?></span>
            </div>
             <div class="form-group">
                <label for="c_password">Confirm Password</label>
                <input class="form-control" name="c_password" placeholder="Confirm password" type="password" value="<?php echo set_value('c_password'); ?>" />
                <span class="text-danger"><?php echo form_error('c_password'); ?></span>
            </div>
            
            <div class="form-group">
                <button name="submit" type="submit" class="btn btn-success">Update</button>
            </div>
            <?php echo form_close(); ?>
            <?php echo $this->session->flashdata('msg'); ?>
        </div>
    </div>
</div>


</div>
