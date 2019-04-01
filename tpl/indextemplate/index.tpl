<html lang="en">
<head>
  <meta http-equiv="Content-type" content="text/html;charset=utf-8" />
  <title><?php echo $Data[ 'page_title' ]; ?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo $Data[ 'template_path' ]?>/css/normalize.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo $Data[ 'template_path' ]?>/css/stylesheet.css" />
</head>
<body>
	<div class="index-page">
		<div class="index-page__title"><?php echo $Data[ 'server_name' ] ?></div>
		<div>Training yard</div>
		<div class="index-page__navigator">
			<div class="navigator__item">
				<a class="navigator__link" href="/replication/">Replication</a>
			</div>
			<div class="navigator__item">
				<a class="navigator__link" href="/failover/">Failover</a>
			</div>
		</div>
	</div>
</body>
</html>
