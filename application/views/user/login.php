<div class="row">
	<div class="col-md-12 text-center">
        <h1> Login </h1>
    </div>

</div>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Enter Login Details</h3>
        </div>
        <div class="panel-body">
            <?php $attributes = array("name" => "user_login","id"=>"user_login");
            echo form_open_multipart("user/login", $attributes);?>
            
            <div class="form-group">
                <label for="email">Email ID</label>
                <input class="form-control" name="email" placeholder="Email-ID" type="text" value="<?php echo set_value('email'); ?>" />
                <span class="text-danger"><?php echo form_error('email'); ?></span>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input class="form-control" name="password" placeholder="password" type="password" value="<?php echo set_value('password'); ?>" />
                <span class="text-danger"><?php echo form_error('password'); ?></span>
            </div>
            
           
            <div class="form-group">
                <button name="submit" type="submit" class="btn btn-success">Login</button>
            </div>
            <?php echo form_close(); ?>
            <?php echo $this->session->flashdata('msg'); ?>
        </div>
    </div>
</div>


</div>
