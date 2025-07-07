<?php
// Include security configuration
require_once '../config.php';

// Security functions
function escape_html($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function validate_url($url) {
    $url = filter_var($url, FILTER_SANITIZE_URL);
    return filter_var($url, FILTER_VALIDATE_URL) ? $url : '#';
}

// Site variables
$site_name = escape_html(SITE_NAME);
$site_url = validate_url(SITE_URL);

// Generate CSRF token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment'])) {
    // Verify CSRF token
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        die('CSRF token mismatch');
    }
    
    // Sanitize and validate input
    $name = escape_html(trim($_POST['name'] ?? ''));
    $phone = escape_html(trim($_POST['phone'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $comment = escape_html(trim($_POST['comment'] ?? ''));
    
    // Basic validation
    if (empty($name) || empty($email) || empty($comment)) {
        $error_message = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address.";
    } else {
        // Here you would typically save to database
        $success_message = "Thank you for your comment! It will be reviewed before publishing.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<!-- For IE -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!-- For Resposive Device -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- For Window Tab Color -->
		<!-- Chrome, Firefox OS and Opera -->
		<meta name="theme-color" content="#09c541">
		<!-- Windows Phone -->
		<meta name="msapplication-navbutton-color" content="#09c541">
		<!-- iOS Safari -->
		<meta name="apple-mobile-web-app-status-bar-style" content="#09c541">
		<title>Blog Details - <?php echo $site_name; ?></title>
		<!-- Favicon -->
		<link rel="icon" type="image/png" sizes="56x56" href="images/fav-icon/milogoleg-removebg-preview.png">
		<!-- Main style sheet -->
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<!-- responsive style sheet -->
		<link rel="stylesheet" type="text/css" href="css/responsive.css">
		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

		<!-- Fix Internet Explorer ______________________________________-->
		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
			<script src="vendor/html5shiv.js"></script>
			<script src="vendor/respond.js"></script>
		<![endif]-->	
		
		<style>
		* {
			box-sizing: border-box;
		}
		
		body {
			font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
			line-height: 1.6;
			color: #333;
		}
		
		.professional-blog-container {
			max-width: 1000px;
			margin: 0 auto;
			padding: 0 20px;
		}
		
		.blog-header {
			text-align: center;
			padding: 60px 0 40px;
			border-bottom: 1px solid #e5e7eb;
			margin-bottom: 40px;
		}
		
		.blog-header h1 {
			font-size: 2.5rem;
			font-weight: 700;
			color: #1f2937;
			margin-bottom: 20px;
			line-height: 1.2;
		}
		
		.blog-meta {
			display: flex;
			justify-content: center;
			align-items: center;
			gap: 30px;
			color: #6b7280;
			font-size: 0.9rem;
			margin-bottom: 20px;
		}
		
		.blog-meta .meta-item {
			display: flex;
			align-items: center;
			gap: 8px;
		}
		
		.blog-meta .meta-item i {
			color: #09c541;
		}
		
		.blog-intro {
			background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
			border-left: 4px solid #09c541;
			padding: 30px;
			margin: 40px 0;
			border-radius: 8px;
			font-size: 1.125rem;
			line-height: 1.7;
			color: #374151;
			box-shadow: 0 2px 10px rgba(9, 197, 65, 0.1);
		}
		
		.content-section {
			margin-bottom: 60px;
		}
		
		.content-section h2 {
			font-size: 2rem;
			font-weight: 600;
			color: #1f2937;
			margin: 50px 0 30px 0;
			line-height: 1.3;
			position: relative;
			padding-bottom: 15px;
		}
		
		.content-section h2:after {
			content: '';
			position: absolute;
			bottom: 0;
			left: 0;
			width: 60px;
			height: 3px;
			background: linear-gradient(90deg, #09c541, #34d058);
			border-radius: 2px;
		}
		
		.content-image {
			width: 100%;
			height: 400px;
			object-fit: cover;
			border-radius: 12px;
			margin: 30px 0;
			box-shadow: 0 10px 30px rgba(0,0,0,0.1);
			transition: transform 0.3s ease, box-shadow 0.3s ease;
		}
		
		.content-image:hover {
			transform: translateY(-5px);
			box-shadow: 0 20px 40px rgba(0,0,0,0.15);
		}
		
		.content-section p {
			font-size: 1.1rem;
			line-height: 1.8;
			color: #4b5563;
			text-align: justify;
			margin-bottom: 25px;
		}
		
		.share-section {
			margin-top: 60px;
			padding: 40px 0;
			border-top: 2px solid #e5e7eb;
			background: #f9fafb;
			border-radius: 12px;
		}
		
		.share-option {
			display: flex;
			justify-content: space-between;
			align-items: center;
			flex-wrap: wrap;
			gap: 20px;
			padding: 0 30px;
		}
		
		.tag-meta {
			display: flex;
			align-items: center;
			gap: 15px;
			flex-wrap: wrap;
		}
		
		.tag-meta li {
			list-style: none;
		}
		
		.tag-meta li:first-child {
			font-weight: 600;
			color: #374151;
		}
		
		.tag-meta a {
			background: #09c541;
			color: white;
			padding: 6px 12px;
			border-radius: 20px;
			text-decoration: none;
			font-size: 0.875rem;
			font-weight: 500;
			transition: all 0.3s ease;
		}
		
		.tag-meta a:hover {
			background: #078934;
			transform: translateY(-2px);
		}
		
		.social-share {
			display: flex;
			align-items: center;
			gap: 15px;
		}
		
		.social-share li {
			list-style: none;
		}
		
		.social-share li:first-child {
			font-weight: 600;
			color: #374151;
		}
		
		.social-share a {
			display: flex;
			align-items: center;
			justify-content: center;
			width: 40px;
			height: 40px;
			background: #f3f4f6;
			color: #6b7280;
			border-radius: 50%;
			text-decoration: none;
			transition: all 0.3s ease;
		}
		
		.social-share a:hover {
			background: #09c541;
			color: white;
			transform: translateY(-2px);
		}
		
		.comment-section {
			background: white;
			border-radius: 12px;
			padding: 40px;
			margin-top: 60px;
			box-shadow: 0 4px 20px rgba(0,0,0,0.05);
			border: 1px solid #e5e7eb;
		}
		
		.comment-section h2 {
			font-size: 1.75rem;
			font-weight: 600;
			color: #1f2937;
			margin-bottom: 30px;
			text-align: center;
		}
		
		.comment-form {
			max-width: 600px;
			margin: 0 auto;
		}
		
		.form-row {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 20px;
			margin-bottom: 20px;
		}
		
		.form-group {
			margin-bottom: 20px;
		}
		
		.form-group.full-width {
			grid-column: 1 / -1;
		}
		
		.form-group input,
		.form-group textarea {
			width: 100%;
			padding: 15px;
			border: 2px solid #e5e7eb;
			border-radius: 8px;
			font-size: 1rem;
			transition: border-color 0.3s ease;
			font-family: inherit;
		}
		
		.form-group input:focus,
		.form-group textarea:focus {
			outline: none;
			border-color: #09c541;
			box-shadow: 0 0 0 3px rgba(9, 197, 65, 0.1);
		}
		
		.form-group textarea {
			height: 120px;
			resize: vertical;
		}
		
		.submit-btn {
			background: linear-gradient(135deg, #09c541 0%, #34d058 100%);
			color: white;
			padding: 15px 40px;
			border: none;
			border-radius: 8px;
			font-size: 1rem;
			font-weight: 600;
			cursor: pointer;
			transition: all 0.3s ease;
			display: block;
			margin: 30px auto 0;
		}
		
		.submit-btn:hover {
			transform: translateY(-2px);
			box-shadow: 0 10px 25px rgba(9, 197, 65, 0.3);
		}
		
		.alert {
			padding: 15px 20px;
			border-radius: 8px;
			margin-bottom: 20px;
			font-weight: 500;
		}
		
		.alert-success {
			background: #d1fae5;
			border: 1px solid #34d058;
			color: #065f46;
		}
		
		.alert-danger {
			background: #fee2e2;
			border: 1px solid #f87171;
			color: #991b1b;
		}
		
		@media (max-width: 768px) {
			.professional-blog-container {
				padding: 0 15px;
			}
			
			.blog-header h1 {
				font-size: 2rem;
			}
			
			.blog-meta {
				flex-direction: column;
				gap: 15px;
			}
			
			.content-section h2 {
				font-size: 1.5rem;
			}
			
			.content-image {
				height: 250px;
			}
			
			.share-option {
				flex-direction: column;
				align-items: flex-start;
			}
			
			.form-row {
				grid-template-columns: 1fr;
			}
		}
		</style>
	</head>

	<body>
		<div class="main-page-wrapper">

			<!-- ===================================================
				Loading Transition
			==================================================== -->
			<div id="loader-wrapper">
				<div id="loader"></div>
			</div>

			

			<!-- 
			=============================================
				Theme Header One
			============================================== 
			-->
			<header class="header-one">
				<div class="top-header">
					<div class="container clearfix">
						<div class="logo float-left"><a href="index.php">
							<img src="./images/logo/milogoleg.png" alt="" style="width: 230px; height: 90px;">

						<div class="address-wrapper float-right">
							<ul>
						<li class="address">
							<a href="https://wa.me/50256867313" target="_blank" style="text-decoration: none; color: inherit;">
								<div style="display: flex; align-items: center; gap: 10px;">
									<i class="ic--baseline-whatsapp" style="
										display: inline-block;
										width: 24px;
										height: 24px;
										--svg: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Cpath fill=\'%2325D366\' d=\'M19.05 4.91A9.82 9.82 0 0 0 12.04 2c-5.46 0-9.91 4.45-9.91 9.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91c0-2.65-1.03-5.14-2.9-7.01m-7.01 15.24c-1.48 0-2.93-.4-4.2-1.15l-.3-.18l-3.12.82l.83-3.04l-.2-.31a8.26 8.26 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24c2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 0 1 2.41 5.83c.02 4.54-3.68 8.23-8.22 8.23m4.52-6.16c-.25-.12-1.47-.72-1.69-.81c-.23-.08-.39-.12-.56.12c-.17.25-.64.81-.78.97c-.14.17-.29.19-.54.06c-.25-.12-1.05-.39-1.99-1.23c-.74-.66-1.23-1.47-1.38-1.72c-.14-.25-.02-.38.11-.51c.11-.11.25-.29.37-.43s.17-.25.25-.41c.08-.17.04-.31-.02-.43s-.56-1.34-.76-1.84c-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31c-.22.25-.86.85-.86 2.07s.89 2.4 1.01 2.56c.12.17 1.75 2.67 4.23 3.74c.59.26 1.05.41 1.41.52c.59.19 1.13.16 1.56.1c.48-.07 1.47-.6 1.67-1.18c.21-.58.21-1.07.14-1.18s-.22-.16-.47-.28\'/%3E%3C/svg%3E');
										background-color: currentColor;
										-webkit-mask-image: var(--svg);
										mask-image: var(--svg);
										-webkit-mask-repeat: no-repeat;
										mask-repeat: no-repeat;
										-webkit-mask-size: 100% 100%;
										mask-size: 100% 100%;
										color: #25D366;
									"></i>

									<div>
										<h6 style="margin: 0;">Whatsapp:</h6>
										<p style="margin: 0;">(+502) 5686 7313</p>
									</div>
								</div>
							</a>
						</li>

								<li class="address">
									
								</li>
								<li class=""><a href=""></a></li>
							</ul>
						</div> <!-- /.address-wrapper -->
					</div> <!-- /.container -->
				</div> <!-- /.top-header -->

				<div class="theme-menu-wrapper">
					<div class="container">
						<div class="bg-wrapper clearfix" style="background-color: #275e96;">

							<!-- ============== Menu Warpper ================ -->
					   		<div class="menu-wrapper float-left">
					   			<nav id="mega-menu-holder" class="clearfix">
								   <ul class="clearfix">
									   <li><a href="../index.php" style="color: white; text-decoration: none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Home</a></li>
									    <!-- <li><a href="#">PAGES</a>
									    	<ul class="dropdown">
									    		<li><a href="about.html">About us</a></li>
									    		<li><a href="team.html">Our team</a></li>
									    		<li><a href="faq.html">Faq's</a></li>
									    		<li><a href="404.html">404</a></li>
									    		<li><a href="shop.html">Shop</a></li>
									    		<li><a href="shop-details.html">Shop details</a></li>
									            <li><a href="#">Third Level menu</a>
									    			<ul>
									    				<li><a href="#">Demo one</a></li>
									    				<li><a href="#">Demo two</a></li>
									    			</ul>
									    		</li>
									       </ul>
									    </li> -->
									    <li><a href="#" style="color: white; text-decoration: none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Servicios</a>
									    	<ul class="dropdown">
									        	<li><a href="https://homecare.global/cuidadora">Cuidadora de Salud</a></li>
									        	<li><a href="https://homecare.global/auxiliar">Auxiliar de Enfermeria</a></li>
									        	<li><a href="https://homecare.global/profesional">Enfermera Profesional</a></li>
									       </ul>
									    </li>
									    <!-- <li><a href="#">Portfolio</a>
									    	<ul class="dropdown">
									        	<li><a href="project.html">project</a></li>
									        	<li><a href="project-details.html">Project details</a></li>
									       </ul>
									    </li> -->
									    <li>
												<a href="#" style="color: white; text-decoration: none;" 
													onmouseover="this.style.textDecoration='underline'" 
													onmouseout="this.style.textDecoration='none'">
													Blog
												</a>
												<ul class="dropdown">
													<?php
													$dir = './';
													$archivos = scandir($dir);

													foreach ($archivos as $archivo) {
															// Saltar . y ..
															if ($archivo === '.' || $archivo === '..') continue;

															// Solo archivos .php
															if (pathinfo($archivo, PATHINFO_EXTENSION) === 'php') {
																	$nombre = pathinfo($archivo, PATHINFO_FILENAME);
																	// Convertir guiones o guiones bajos a espacios y capitalizar
																	$nombre_legible = ucwords(str_replace(['-', '_'], ' ', $nombre));
																	// Generar URL sin .php y apuntando a blogs/
																	echo "<li><a href=\"https://homecare.global/blogs/$nombre\">$nombre_legible</a></li>";
															}
													}
													?>
												</ul>
											</li>

									    <!-- <li><a href="contact.html">contact</a></li> -->
								   </ul>
								</nav> <!-- /#mega-menu-holder -->
					   		</div> <!-- /.menu-wrapper -->

					   		<!-- <div class="right-widget float-right">
					   			<ul>
					   				<li class="social-icon">
					   					<ul>
											<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
											<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
											<li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
											<li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
										</ul>
					   				</li>
					   				<li class="cart-icon">
					   					<a href="#"><i class="flaticon-tool"></i> <span>2</span></a>
					   				</li>
					   				<li class="search-option">
					   					<div class="dropdown">
					   						<button type="button" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-search" aria-hidden="true"></i></button>
											<form action="#" class="dropdown-menu">
												<input type="text" Placeholder="Enter Your Search">
												<button><i class="fa fa-search"></i></button>
											</form>
					   					</div>
					   				</li>
					   			</ul>
					   		</div>  -->
						</div> <!-- /.bg-wrapper -->
					</div> <!-- /.container -->
				</div> <!-- /.theme-menu-wrapper -->
			</header> <!-- 

			
			<!-- 
			=============================================
				Theme Inner Banner
			============================================== 
			-->
			<div class="theme-inner-banner section-spacing">
				<div class="overlay">
					<div class="container" >
						<h1 style="color: white;">Cuidado Profesional de Salud en el Hogar</h1>
					</div>
				</div>
			</div>


			<!-- 
			=============================================
				Professional Blog Content
			============================================== 
			-->
			<div class="our-blog section-spacing">
				<div class="professional-blog-container">
					
					<!-- Blog Header -->
					<div class="blog-header">
						
						<div class="blog-meta">
							<div class="meta-item">
								<i class="fa fa-calendar"></i>
								<span><?php echo date('M d, Y'); ?></span>
							</div>
							<div class="meta-item">
								<i class="fa fa-user"></i>
								<span>Equipo Médico</span>
							</div>
							<div class="meta-item">
								<i class="fa fa-clock-o"></i>
								<span>5 min lectura</span>
							</div>
						</div>
					</div>

					<!-- Blog Introduction -->
					<div class="blog-intro">
						En el panorama actual de la salud en Guatemala, el cuidado profesional en el hogar se ha convertido en una alternativa esencial y efectiva para brindar atención médica de calidad. Nuestros servicios especializados combinan la comodidad del hogar con la experiencia profesional, ofreciendo una solución integral que mejora significativamente la calidad de vida de nuestros pacientes y sus familias.
					</div>


					<div class="feature-banner section-spacing">
						<div class="opacity">
							<div class="container">
								<h2>Nuestras enfermeras pueden atender a tus seres queridos llegando a tu casa</h2>
								<a href="https://wa.me/50256867313" class="theme-button-one" >Escribenos al whatsapp</a>
							</div> <!-- /.container -->
						</div> <!-- /.opacity -->
					</div> 

					<!-- Content Sections -->
					<div class="content-section">
						<h2>Cuidadoras de Salud: Compañía y Apoyo Integral</h2>
						<img src="images/services/cuidadora-salud.jpg" alt="Cuidadora de Salud Profesional" class="content-image">
						<p>
							Nuestras cuidadoras de salud ofrecen un servicio personalizado que va más allá del cuidado básico. Estas profesionales capacitadas brindan compañía, asistencia en actividades diarias, administración de medicamentos bajo supervisión, y monitoreo constante del bienestar general del paciente. Su presencia reconfortante y su atención dedicada crean un ambiente seguro y cálido que promueve la recuperación y el bienestar emocional.
						</p>
					</div>

					<div class="content-section">
						<h2>Auxiliares de Enfermería: Cuidado Técnico Especializado</h2>
						<img src="images/services/auxiliar-enfermeria.jpg" alt="Auxiliar de Enfermería" class="content-image">
						<p>
							Los auxiliares de enfermería constituyen el pilar técnico de nuestros servicios de salud domiciliar. Con formación especializada en procedimientos médicos básicos, estos profesionales realizan curaciones, control de signos vitales, administración de medicamentos, fisioterapia básica y apoyo en la rehabilitación. Su expertise técnico combinado con un enfoque humano garantiza una atención médica de calidad en la comodidad del hogar.
						</p>
					</div>

					<div class="content-section">
						<h2>Enfermeras Profesionales: Excelencia en Atención Médica</h2>
						<img src="images/services/enfermera-profesional.jpg" alt="Enfermera Profesional" class="content-image">
						<p>
							Nuestras enfermeras profesionales representan el más alto nivel de atención médica domiciliar. Con licenciatura en enfermería y experiencia clínica comprobada, estas especialistas están capacitadas para manejar casos complejos, administrar tratamientos avanzados, coordinar con médicos tratantes, y proporcionar educación sanitaria a pacientes y familias. Su liderazgo profesional asegura estándares de calidad equiparables a los de instituciones hospitalarias.
						</p>
					</div>

					<div class="content-section">
						<h2>Ventajas del Cuidado de Salud en el Hogar</h2>
						<img src="images/services/cuidado-hogar.jpg" alt="Beneficios del Cuidado en Casa" class="content-image">
						<p>
							El cuidado de salud en el hogar ofrece múltiples beneficios que impactan positivamente en la recuperación y calidad de vida. Entre las principales ventajas se encuentran: la reducción del riesgo de infecciones hospitalarias, el mantenimiento del entorno familiar que acelera la recuperación emocional, la atención personalizada uno a uno, la flexibilidad en horarios y tratamientos, y la significativa reducción de costos comparado con hospitalizaciones prolongadas. Además, permite que las familias mantengan su rutina diaria mientras aseguran el mejor cuidado para sus seres queridos.
						</p>
					</div>

					<!-- Share Section -->
					<div class="share-section">
						<div class="share-option">
							<ul class="tag-meta">
								<li>Etiquetas:</li>
								<li><a href="#" rel="noopener noreferrer">Salud</a></li>
								<li><a href="#" rel="noopener noreferrer">Enfermería</a></li>
								<li><a href="#" rel="noopener noreferrer">Cuidado Domiciliar</a></li>
								<li><a href="#" rel="noopener noreferrer">Guatemala</a></li>
							</ul>
							<ul class="social-share">
								<li>Compartir:</li>
								<li><a href="#" rel="noopener noreferrer"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#" rel="noopener noreferrer"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#" rel="noopener noreferrer"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#" rel="noopener noreferrer"><i class="fa fa-whatsapp"></i></a></li>
							</ul>
						</div>
					</div>

					<!-- Comment Section -->
					<!-- <div class="comment-section">
					
						
						<?php if (isset($success_message)): ?>
							<div class="alert alert-success"><?php echo $success_message; ?></div>
						<?php endif; ?>
						
						<?php if (isset($error_message)): ?>
							<div class="alert alert-danger"><?php echo $error_message; ?></div>
						<?php endif; ?>
						
						<form action="" class="comment-form" method="POST">
							<input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
							<div class="form-row">
								<div class="form-group">
									<input type="text" name="name" placeholder="Nombre *" maxlength="100" required>
								</div>
								<div class="form-group">
									<input type="text" name="phone" placeholder="Teléfono" maxlength="20">
								</div>
							</div>
							<div class="form-group">
								<input type="email" name="email" placeholder="Email *" maxlength="100" required>
							</div>
							<div class="form-group">
								<textarea name="comment" placeholder="Comentarios *" maxlength="1000" required></textarea>
							</div>
							<button type="submit" name="submit_comment" class="submit-btn">Enviar Comentario</button>
						</form>
					</div> -->

				</div> <!-- /.professional-blog-container -->
			</div> <!-- /.our-blog -->
			

			<!--
			=====================================================
				Footer
			=====================================================
			-->
			<footer class="theme-footer-one">
				<div class="top-footer">
					<div class="container">
						<div class="row">
							<div class="col-xl-3 col-lg-4 col-sm-6 about-widget">
								<h6 class="title">Políticas</h6>
									<ul style="color: white;">
										<li>Política de Calidad</li>
										<li>Declaración de sostenibilidad</li>
										<li>Política de Salud y Seguridad Ocupacional</li>
										<li>Declaración Sostenibilidad Política Ambiental ISO 14001 2024</li>
									</ul>
								<div class="queries"><i class="flaticon-phone-call"></i> Teléfono : <a href="https://wa.me/50256867313">(+502) 5686-7313</a></div>
								
							</div> <!-- /.about-widget -->
							

								<div class="col-xl-4 col-lg-3 col-sm-6 footer-recent-post">
									<h6 class="title">Articulos Recientes</h6>
									<ul>
											<?php
											$carpeta = './';
											$archivos = array_filter(glob($carpeta . '*.php'), 'is_file');

											// Ordenar por fecha de modificación (más recientes primero)
											usort($archivos, function($a, $b) {
													return filemtime($b) - filemtime($a);
											});

											$posts_mostrados = 0;
											foreach ($archivos as $archivo) {
													if ($posts_mostrados >= 2) break;

													$nombre = pathinfo($archivo, PATHINFO_FILENAME);
													$titulo_legible = ucwords(str_replace(['-', '_'], ' ', $nombre));
													$fecha = date('M d, Y', filemtime($archivo));
													$url = $archivo; // Ruta al archivo del blog

													echo '<li class="clearfix">';
													echo '    <div class="post float-left">';
													echo "        <a href=\"$url\">$titulo_legible</a>";
													echo "        <div class=\"date\"><i class=\"fa fa-calendar-o\" aria-hidden=\"true\"></i> $fecha</div>";
													echo '    </div>';
													echo '</li>';

													$posts_mostrados++;
											}
											?>
									</ul>
							</div>


							<div class="col-xl-2 col-lg-3 col-sm-6 footer-list">
								<h6 class="title">Servicios</h6>
								<ul>
									<li><a href="../cuidadora.php">Cuidadora de Salud</a></li>
									<li><a href="../auxiliar.php">Auxiliar de Enfermeria</a></li>
									<li><a href="../profesional.php">Enfermera Profesional</a></li>
								</ul>
							</div> <!-- /.footer-list -->
							
						</div> <!-- /.row -->
					</div> <!-- /.container -->
				</div> <!-- /.top-footer -->
				<div class="bottom-footer">
					<div class="container">
						<div class="row">
							<div class="col-md-6 col-12"><p>&copy; Derechos Reservados <?php echo date('Y'); ?>. Todos los Derechos Reservados.</p></div>
							
						</div>
					</div>
				</div> <!-- /.bottom-footer -->
			</footer> <!-- /.theme-footer -->
			

	        

	        <!-- Scroll Top Button -->
			<button class="scroll-top tran3s">
				<i class="fa fa-angle-up" aria-hidden="true"></i>
			</button>
			



		<!-- Optional JavaScript _____________________________  -->

    	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    	<!-- jQuery -->
		<script src="vendor/jquery.2.2.3.min.js"></script>
		<!-- Popper js -->
		<script src="vendor/popper.js/popper.min.js"></script>
		<!-- Bootstrap JS -->
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<!-- Camera Slider -->
		<script src='vendor/Camera-master/scripts/jquery.mobile.customized.min.js'></script>
	    <script src='vendor/Camera-master/scripts/jquery.easing.1.3.js'></script> 
	    <script src='vendor/Camera-master/scripts/camera.min.js'></script>
	    <!-- menu  -->
		<script src="vendor/menu/src/js/jquery.slimmenu.js"></script>
		<!-- WOW js -->
		<script src="vendor/WOW-master/dist/wow.min.js"></script>
		<!-- owl.carousel -->
		<script src="vendor/owl-carousel/owl.carousel.min.js"></script>
		<!-- js count to -->
		<script src="vendor/jquery.appear.js"></script>
		<script src="vendor/jquery.countTo.js"></script>
		<!-- Fancybox -->
		<script src="vendor/fancybox/dist/jquery.fancybox.min.js"></script>

		<!-- Theme js -->
		<script src="js/theme.js"></script>
		</div> <!-- /.main-page-wrapper -->
	</body>
</html>