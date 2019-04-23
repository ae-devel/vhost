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
	<div class="page js-memcache-page">
		<div class="page__title">MEMCACHE</div>
		<div class="page__navigation g-mb50">
			<a href="/">Front</a> |
			<span>Memcache</span>
		</div>
		<div class="g-mb10">
			<div><strong>Exec time:</strong></div>
			<?php echo $Data[ 'exec_time' ]; ?>
		</div>
		<div class="g-mb10">
			<div><strong>Cache is found in Memcache:</strong></div>
			<?php echo $Data[ 'cache_is_found' ]; ?>
		</div>
		<div class="page__data-block">
			<span class="page__data-title">SELECT FROM THE MASTER ( <?php echo $Data[ 'master_host' ]; ?> )</span>
			<div class="g-mb10">
				<a class="js-flush-button" href="#">Flush cache</a>&nbsp;&nbsp;
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
