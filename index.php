<?php
$site_root = '/demos/2019/ajax-navigation';

// GO
$content = '';
if ($path = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '') {
  $is_ajax_request = isset($_SERVER['HTTP_X_REQUESTED_WITH']);
  if ($is_ajax_request && ($i = strrpos($path, '.php'))) // strip ".php" added in AJAX request.

  $path = substr($path, 0, $i);
  $path_folders = explode('/', ltrim($path, '/'));

  $cur_area = $path_folders[0];
  if ($cur_section = end($path_folders)) { // last folder in path.

    if ($cur_area == 'items' && (count($path_folders) > 1)) { // if path is "items/" + some ID.

      // get some data from mySQL db.
      $content = 'here is some data for item #'.$cur_section.' retrieved from MySQL db.';

    }elseif (file_exists($fn = dirname(__FILE__).'/'.$cur_section.'.php')) {
      $content = file_get_contents($fn);
    }else {
      http_response_code(404);
      $site_url = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '';
      $content = <<<END
HTTP error #404, Not Found. Requested URL "$site_url$path" doesn't exists.

END;
    }
  }

  if ($is_ajax_request) { // is AJAX request?
    print $content; // output for "content-fill" area.
    exit;
  }
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="#">
		<meta name="keywords" content="#">
		<meta name="author" content="#">
		<title>Project</title>
		<link rel="apple-touch-icon" sizes="180x180" href="<?=$site_root?>/assets/images/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="<?=$site_root?>/assets/images/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="<?=$site_root?>/assets/images/favicon-16x16.png">
		<link rel="stylesheet" href="<?=$site_root?>/assets/css/normalize.css">
		<link rel="stylesheet" href="<?=$site_root?>/assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?=$site_root?>/assets/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?=$site_root?>/assets/css/ie10-viewport-bug-workaround.css">
		<link rel="stylesheet" href="<?=$site_root?>/assets/css/project.css">

            <script src="<?=$site_root?>/assets/js/hourglass.min.js" defer></script>
            <script src="<?=$site_root?>/assets/js/ajax_navigation.js" defer></script>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>

		<div class="container">
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">PROJECT</a>
					</div>
					<div id="navbar" class="navbar-collapse collapse">
						<ul class="nav navbar-nav">
							<li><a href="<?=$site_root?>/home">HOME</a></li>
							<li><a href="<?=$site_root?>/about">ABOUT</a></li>
							<li><a href="<?=$site_root?>/items">ITEMS</a></li>
							<li><a href="<?=$site_root?>/contact">CONTACT</a></li>
						</ul>
					</div>
				</div>
			</nav>
			<div class="jumbotron">
				<h3>STATIC CONTENT</h3>
				<p>
					The navbar, this box and the footer are static.
				</p>
			</div>
			<div class="jumbotron" id="content-fill" style="border: 2px dotted red;">
				<!-- THE PAGES LOAD INTO THIS DIV. -->
<?=$content?>
			</div>
			<div class="footer">
				<p>
					FOOTER
				</p>
			</div>
		</div>
		<script src="<?=$site_root?>/assets/js/jquery-3.3.1.min.js"></script>
		<script src="<?=$site_root?>/assets/js/bootstrap.min.js"></script>
		<script src="<?=$site_root?>/assets/js/ie10-viewport-bug-workaround.js"></script>
	</body>
</html>