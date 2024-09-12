<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		body {
			background: linear-gradient(to right, #6a11cb, #2575fc);
			color: #fff;
			display: flex;
			justify-content: center;
			align-items: center;
			min-height: 100vh;
			margin: 0;
			text-align: center;
			overflow: hidden;
		}
		.container {
			background: rgba(255, 255, 255, 0.1);
			border-radius: 12px;
			padding: 40px;
			box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
			backdrop-filter: blur(10px);
		}
		.error-code {
			font-size: 10rem;
			font-weight: 500;
			text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
		}
		.message {
			font-size: 1.5rem;
			margin: 20px 0;
		}
		.button {
			background: #ff4c4c;
			color: #fff;
			padding: 10px 20px;
			border-radius: 5px;
			text-decoration: none;
			font-weight: 500;
			transition: background 0.3s, transform 0.3s;
		}
		.button:hover {
			background: #ff1e1e;
			transform: scale(1.05);
		}

	</style>
	<?php wp_head(); ?>
</head>
<body class="antialiased">
	<div class="container">
		<div class="error-code">404</div>
		<p class="message"><?php _e( 'Sorry, the page you are looking for could not be found.', 'minimalflow' ); ?></p>
	</div>
</body>
</html>
