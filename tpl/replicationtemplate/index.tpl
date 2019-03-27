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
	<div class="page js-replication-page">
		<div class="page__title">REPLICATION</div>
		<div class="page__navigation g-mb50">
			<a href="/">Front</a> |
			<span>Replication</span>
		</div>
		<div class="g-mb10">
			Master host: <?php echo $Data[ 'master_host' ]; ?>
		</div>
		<div class="g-mb10">
			Slave host: <?php echo $Data[ 'slave_host' ]; ?>
		</div>
		<div class="page__data-block">
			<span class="page__data-title">SELECT FROM THE SLAVE ( <?php echo $Data[ 'slave_host' ]; ?> )</span>
			<div class="g-mb10">
				<a class="js-insert-code-button" href="#">Insert new code to master</a>&nbsp;&nbsp;
				<a class="js-refresh-codes-button" href="#">Refresh</a>&nbsp;&nbsp;
				<a class="js-clear-codes-button" href="#">Clear</a>
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
