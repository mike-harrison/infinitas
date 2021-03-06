<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
    	<?php echo $this->Html->charset(); ?>
    	<title>
    		<?php echo __( 'Infinitas Admin :: ', true ), $title_for_layout; ?>
    	</title>
        <?php
            echo $this->Html->meta('icon');
			
			foreach($css_for_layout as $i => $css) {
				if(strstr($css, '/assets/')) {
					unset($css_for_layout[$i]);
				}
			}
			echo $this->Html->css(
				array(
					'/assets/css/960gs/960',
					'/assets/css/admin_nav',
					'/assets/css/960gs/uncompressed/demo'
				) + 
				$css_for_layout
			);
    		echo $scripts_for_layout;
        ?>
		<script type="text/javascript">
			Infinitas = {};
			Infinitas.params.prefix = 'admin';
			if (Infinitas.base != '/') {
				Infinitas.base = Infinitas.base + '/';
			}
		</script>
	</head>
	<body>
		<div id="wrap">
				<div class="module admin-menu ">
					<div class="grid_16 center" id="menucontainer">
						<div id="menunav">
							<ul><li><?php echo $this->Html->link(__('Login'), array('action' => 'login'), array('class' => 'current')); ?></li></ul>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			<div class="container_16">
				<div class="grid_16">
					<?php echo $this->Session->flash(); ?>
				</div>
				<div class="clear"></div>
				<div class="grid_16 dashboard">
					<h1><?php echo __('Infinitas Cms'); ?></h1>
					<?php
						echo $content_for_layout;
						echo $this->Compress->script($js_for_layout);
						echo $scripts_for_layout;
					?>
				</div>
				<div class="powered-by">Powered By: <?php echo $this->Html->link('Infinitas', 'http://infinitas-cms.org');?></div>
			</div>
		</div>
	</body>
</html>