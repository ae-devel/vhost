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
		<div class="page__title">MEMCACHE SESSION</div>
		<div class="page__navigation g-mb50">
			<a href="/">Front</a> |
			<span>Memcache session</span>
		</div>
		<div class="g-mb10">
			<div><strong>Server name:</strong></div>
			<?php echo $Data[ 'server_name' ]; ?>
		</div>
		<div class="page__data-block">
			<span class="page__data-title">SESSION DATA</span>
			<div>
				<?php echo $Data[ 'session_data' ]; ?>
			</div>
		</div>
	</div>
</body>
</html>
