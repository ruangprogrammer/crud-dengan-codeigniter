<!doctype html>
<html>
    <head>
        <title>ruangprogrammer.com - crud dengan codeigniter</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Books <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Name <?php echo form_error('name') ?></label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo $name; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Author <?php echo form_error('author') ?></label>
            <input type="text" class="form-control" name="author" id="author" placeholder="Author" value="<?php echo $author; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Isbn <?php echo form_error('isbn') ?></label>
            <input type="text" class="form-control" name="isbn" id="isbn" placeholder="Isbn" value="<?php echo $isbn; ?>" />
        </div>
	    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('books') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>