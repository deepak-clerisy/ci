<div class="row">
	<div class="col-md-12 text-center">
        <h1> Registration Form </h1>
    </div>

</div>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Enter User Details</h3>
        </div>
        <div class="panel-body">
            <?php $attributes = array("name" => "user_new","id"=>"add_new_user");
            echo form_open_multipart("user/register", $attributes);?>
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
                <label for="password">Password</label>
                <input class="form-control" name="password" placeholder="password" type="password" value="<?php echo set_value('password'); ?>" />
                <span class="text-danger"><?php echo form_error('password'); ?></span>
            </div>
            
            <div class="form-group">
                <label for="file">Image</label>                
                <input name="image_file" id="image_file" onchange="fileSelectHandler()" type="file">
                <p class="help-block">jpg,jpeg,png,  Max File Size 5 Mb.</p>
                <span class="text-danger"><?php echo form_error('image_file'); ?></span>
                <span class="text-danger error"></span>
            </div>
            <input id="x1" name="x1" type="hidden">
			<input id="y1" name="y1" type="hidden">
			<input id="x2" name="x2" type="hidden">
			<input id="y2" name="y2" type="hidden">
            <div class="step2" style="display:none;">
                        <p class="text-danger">Please select a crop region</p>
                        <img id="preview">

                        <div class="info" style="display:none;">
                            <label>File size</label> <input id="filesize" name="filesize" type="text">
                            <label>Type</label> <input id="filetype" name="filetype" type="text">
                            <label>Image dimension</label> <input id="filedim" name="filedim" type="text">
                            <label>W</label> <input id="w" name="w" type="text">
                            <label>H</label> <input id="h" name="h" type="text">
                        </div>

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
