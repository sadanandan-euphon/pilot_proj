<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Test Pilot Project</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo $this->config->item('assets_path');?>bootstrap/css/bootstrap.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?php echo $this->config->item('assets_path');?>bootstrap/js/html5shiv.js"></script>
      <script src="<?php echo $this->config->item('assets_path');?>bootstrap/js/respond.min.js"></script>
    <![endif]-->
    
    <style type="text/css">
    	.top-section{
			margin-top:10px;			
			padding:0px;
			height:150px;			
		}
		
		.logo img{
			padding-top:10px;
			width:auto;
			height:auto;
			float:left;
		}
		
		.site-name {
			padding-top:1px;
			float:left;
			width:350px;
		}
		
		.top-right {
			float:right;
		}
    </style>
    
    <script src="<?php echo $this->config->item('assets_path');?>bootstrap/js/jquery.js"></script>
    <script src="<?php echo $this->config->item('assets_path');?>bootstrap/js/bootstrap.min.js"></script>    
    <script src="<?php echo $this->config->item('assets_path');?>bootstrap/js/bootstrap-datepicker.js"></script> 
	<script src="<?php echo $this->config->item('assets_path');?>bootstrap/js/jquery.validate.min.js"></script> 
	<script src="<?php echo $this->config->item('assets_path');?>bootstrap/js/bootstrap-alert.js"></script> 
	
	<script src="<?php echo $this->config->item('assets_path');?>js/bootbox.js"></script> 
    
    <script type="text/javascript">
		base_url	=	"<?php echo base_url();?>";
	</script>
    
    <script type="text/javascript">
	$(document).ready(function() {		
		$('#addNewUser').click(function(){
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "<?php echo site_url('members/check-permission/add/1')?>",
				data: {
					
				},
				success: function (data) {
					if(data.status){
							window.location="<?php echo base_url('members/add-user');?>";
						}else{
							alert("You do not have enough permission to add records.");	
						}
					}
			});	
			
		});
		
	});
	</script>
  </head>

  <body>

    <div class="container">
	  <div class="top-section">
      	<div class="logo"><img src="<?php echo $this->config->item('assets_path');?>bootstrap/img/logo.png"></div>
        <div class="site-name">
        	<h1>Test pilot project</h1>
            <span>Slogan</span>
        </div>
        <div class="top-right">
        	<div class="log-out"><a href="<?php echo base_url('members/view-user').'/'.$this->session->userdata('user_id');;?>"><?php echo $this->session->userdata('first_name');?></a>&nbsp;(<a href="<?php echo base_url('members/logout');?>">log out</a>)</div><br>
            <div class="logged-profile"><?php echo date('m/d/Y');?></div>
        </div>
      </div>
      <!-- Static navbar -->
      <div class="navbar navbar-default">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!--<a class="navbar-brand" href="#">Project name</a>-->
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="<?php echo base_url('members/dashboards');?>">Home</a></li>
            <li><a href="#">Clients</a></li>
            <li><a href="#">Services</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Help</a></li><!--
          </ul>
        </div><!--/.nav-collapse -->
      </div>

     <!-- Start Content -->
	<div id="contents"><?= $content ?></div>
	<!-- End Content  -->
    
    
    </div> <!-- /container -->
    
  </body>
</html>
