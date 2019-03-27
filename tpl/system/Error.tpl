<html lang="en">
<head>
  <meta http-equiv="Content-type" content="text/html;charset=utf-8" />
  <title><?php echo $Data[ 'page_title' ]; ?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo $Data[ 'template_path' ]?>/css/normalize.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo $Data[ 'template_path' ]?>/system/css/stylesheet.css" />
</head>
<body>
	<div class="page-container">
		<div class="page-container__title-1">500</div>
		<div class="page-container__title-2">Something going wrong</div>
		<div class="page-container__error-info"><?php echo $Data[ 'ErrorMessage' ];?></div>
	</div>
</body>
</html>
