	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  	
    <link key="index" href="/res/index.css" rel="stylesheet" type="text/css" />
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>	
<div class='content'>
		<?php 
			require ROOT.'/res/left.php';
		?>
		<div class='c_fr'>
		<?php 
			require ROOT.'/res/head.php';
		?>
			<div class='nav'>
				<div class='fl'>
					修改客户信息
				</div>
				<div class='fr'>
					<a href='/'>首页</a> / 修改信息
				</div>
			</div>
			<div class='clear'></div>
			
			<div class='wd74 c42'>
				<div class='tit'>客户列表 / Data List</div>

				<?php echo $t->show(); ?>
				<div class="footer_op">
					<div class="footer_op_right"><?php echo $pagelink; ?></div>
				</div>			
			</div>
<div class="clear"></div>

<div class="space"></div>
</div>
</div>