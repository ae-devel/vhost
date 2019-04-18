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
	<div class="page js-jobserver-page">
		<div class="page__title">JOBSERVER</div>
		<div class="page__navigation g-mb50">
			<a href="/">Front</a> |
			<span>Jobserver</span>
		</div>
		<div class="g-mb10">
			<div><strong>Database Master host:</strong></div>
			<?php echo $Data[ 'master_host' ]; ?>
		</div>
		<div class="g-mb10">
			<div><strong>Gearman server host:</strong></div>
			<?php echo $Data[ 'gearman_settings' ][ 'host' ]; ?>:<?php echo $Data[ 'gearman_settings' ][ 'port' ]; ?>
		</div>
		<div class="g-mb10">
			<div><strong>To start gearman workers:</strong></div>
			php JobserverWorker.php &
		</div>
		<div class="g-mb10">
			<div><strong>To start gearman-job-server w/MySQL run:</strong></div>
			<?php echo $Data[ 'gearman_run_command' ]; ?>
		</div>
		<div class="page__data-block">
			<span class="page__data-title">SELECT FROM THE MASTER ( <?php echo $Data[ 'master_host' ]; ?> )</span>
			<div class="g-mb10">
				<a class="js-insert-code-button" href="#">Insert new code</a>&nbsp;&nbsp;
				<a class="js-refresh-codes-button" href="#">Refresh</a>&nbsp;&nbsp;
				<a class="js-clear-codes-button" href="#">Clear</a>
			</div>
			<div class="js-codes-container">
				<?php foreach( $Data[ 'codes' ] as $CodeRow ): ?>
				<div class="g-mb10 js-row" data-row-id="<?php echo $CodeRow[ 'id' ] ?>" data-row-processed="<?php echo intval( ! empty( $CodeRow[ 'row_code_processed' ] ) ); ?>">
					<?php echo $CodeRow[ 'id' ] ?> |
					<?php echo $CodeRow[ 'row_time' ] ?> |
					<?php echo $CodeRow[ 'row_code' ] ?>  |
					<span class="js-processed">
						<?php if ( $CodeRow[ 'row_code_processed' ] ): ?>
							<?php echo $CodeRow[ 'row_code_processed' ]; ?>
						<?php else: ?>
							processing...
						<?php endif; ?>
					</span>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</body>
</html>
