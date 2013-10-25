<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Test Pilot Project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?php echo $this->config->item('assets_path');?>bootstrap/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }
	  
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
    <link href="<?php echo $this->config->item('assets_path');?>bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="<?php echo $this->config->item('assets_path');?>bootstrap/js/html5shiv.js"></script>
    <![endif]-->

    
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
        	
        </div>
      </div>    
      
    
    <?php if($error) {?><span class="erro bg"><?php echo $error_message;?></span><?php } ?>
    <?php if(validation_errors()) {?><span class="erro bg"><?php echo validation_errors(); ?></span> <?php }?>
    
    <div id="loginBox">    <?php
								$attibuts= array('id'	=>	'loginForm',
												 'name'	=>	'loginForm',
												 'class'=>	'form-signin');
								echo form_open('members/login',$attibuts);?>
                                
                         
                                <?php $data = array('name'        => 'username',
													'value'		=> set_value('username'),
              									    'id'          => 'username',
													'class'		=>	'form-control',
													'placeholder'	=>'user name or email');
								    echo form_input($data); ?>
                             
                              
								<?php $data = array('name'        => 'password',
              									    'id'          => 'password',
													'class'		=>	'form-control',
													'placeholder'	=>'Password');
								    echo form_password($data); ?>
                             
                               <?php $data = array('name'        => 'login',
                                                   'id'          => 'login',
												   'value'		=>'Login',
												   'class'       => 'btn btn-large btn-primary');
                                    echo form_submit($data); ?>
                            
                                  <span class="senha"><a href="<?php echo base_url().'members/forgotPassword';?>" class="laranja">Forgot password?</a></span>
                          
                            
                        
                                   
                          <?php  //Form close
						         echo form_close();
						  ?>
                          
           
                          
                        </div>
    
    </div>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo $this->config->item('assets_path');?>bootstrap/js/jquery.js"></script>
    <script src="<?php echo $this->config->item('assets_path');?>bootstrap/js/bootstrap-transition.js"></script>
    <script src="<?php echo $this->config->item('assets_path');?>bootstrap/js/bootstrap-alert.js"></script>
    <script src="<?php echo $this->config->item('assets_path');?>bootstrap/js/bootstrap-modal.js"></script>
    <script src="<?php echo $this->config->item('assets_path');?>bootstrap/js/bootstrap-dropdown.js"></script>
    <script src="<?php echo $this->config->item('assets_path');?>bootstrap/js/bootstrap-scrollspy.js"></script>
    <script src="<?php echo $this->config->item('assets_path');?>bootstrap/js/bootstrap-tab.js"></script>
    <script src="<?php echo $this->config->item('assets_path');?>bootstrap/js/bootstrap-tooltip.js"></script>
    <script src="<?php echo $this->config->item('assets_path');?>bootstrap/js/bootstrap-popover.js"></script>
    <script src="<?php echo $this->config->item('assets_path');?>bootstrap/js/bootstrap-button.js"></script>
    <script src="<?php echo $this->config->item('assets_path');?>bootstrap/js/bootstrap-collapse.js"></script>
    <script src="<?php echo $this->config->item('assets_path');?>bootstrap/js/bootstrap-carousel.js"></script>
    <script src="<?php echo $this->config->item('assets_path');?>bootstrap/js/bootstrap-typeahead.js"></script>

  </body>
</html>