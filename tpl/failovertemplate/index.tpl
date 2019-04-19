<html lang="en">
<head>
  <meta http-equiv="Content-type" content="text/html;charset=utf-8" />
  <title><?php echo $Data[ 'page_title' ]; ?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo $Data[ 'template_path' ]?>/css/normalize.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo $Data[ 'template_path' ]?>/css/stylesheet.css" />
  <script type="text/javascript" src="<?php echo $Data[ 'template_path' ]?>/js/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo $Data[ 'template_path' ]?>/js/actions.js"></script>
</head>
<body>
	<div class="page js-failover-page">
		<div class="page__title">FAILOVER</div>
		<div class="page__navigation g-mb50">
			<a href="/">Front</a> |
			<span>Failover</span>
		</div>
		<div class="g-mb10">
			Master host: <?php echo $Data[ 'master_host' ]; ?>
		</div>
		<div class="g-mb10">
			<div><strong>Run in the Cron schedule under root user:</strong></div>
			* * * * * /var/www/vhost.rasp1.dev/shell/db_shutdown.sh
		</div>
		<div class="page__data-block">
			<span class="page__data-title">SELECT FROM THE MASTER ( <?php echo $Data[ 'master_host' ]; ?> )</span>
			<div class="g-mb10">
				<?php if ( $Data[ 'shutdown_in_schedule' ] ):  ?>
				Shutdown in schedule, please wait
				<?php else: ?>
				<a class="js-shutdown-button" href="#">Shutdown master</a>&nbsp;&nbsp;
				<?php endif; ?>
				<a class="js-refresh-page-button" href="#">Refresh page</a>&nbsp;&nbsp;
			</div>
			<div class="js-codes-container">
				<?php foreach( $Data[ 'codes' ] as $CodeRow ): ?>
				<div class="g-mb10">
					<?php echo $CodeRow[ 'id' ] ?> |
					<?php echo $CodeRow[ 'row_time' ] ?> |
					<?php echo $CodeRow[ 'row_code' ] ?> 
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</body>
</html>
