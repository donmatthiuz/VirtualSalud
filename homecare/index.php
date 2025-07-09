<?php
// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');

// Start session for CSRF protection
session_start();

// Function to sanitize output
function sanitize_output($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// Function to sanitize input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Function to send contact form to API
function send_contact_to_api($data) {
    $api_url = 'http://localhost:8000/contact';
    
    // Prepare JSON payload
    $json_data = json_encode($data);
    
    // Initialize cURL
    $ch = curl_init();
    
    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($json_data)
    ]);
    
    // Execute request
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    
    curl_close($ch);
    
    // Return response data
    return [
        'success' => $http_code >= 200 && $http_code < 300,
        'http_code' => $http_code,
        'response' => $response,
        'error' => $error
    ];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token'])) {
    // Verify CSRF token
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        http_response_code(403);
        echo json_encode(['error' => 'Invalid CSRF token']);
        exit;
    }
    
    // Validate and sanitize input
    $name = sanitize_input($_POST['name'] ?? '');
    $phone = sanitize_input($_POST['phone'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $service = sanitize_input($_POST['service'] ?? '');
    $message = sanitize_input($_POST['message'] ?? '');
    
    // Basic validation
    $errors = [];
    if (empty($name)) $errors[] = 'Name is required';
    if (empty($phone)) $errors[] = 'Phone is required';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required';
    if (empty($service)) $errors[] = 'Service selection is required';
    
    if (empty($errors)) {
        // Map service values to display names
        $service_map = [
            'domiciliar' => 'Atención Domiciliar',
            'adulto_mayor' => 'Cuidado de Adultos Mayores',
            'paliativos' => 'Cuidados Paliativos',
            'medicamentos' => 'Administración de Medicamentos',
            'postoperatorios' => 'Post Operatorios'
        ];
        
        $service_name = $service_map[$service] ?? $service;
        
        // Prepare data for API
        $api_data = [
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'service_type' => $service_name,
            'message' => $message
        ];
        
        // Send to API
        $api_response = send_contact_to_api($api_data);
        
        if ($api_response['success']) {
            echo json_encode(['success' => true, 'message' => 'Form submitted successfully']);
        } else {
            error_log("API Error: HTTP {$api_response['http_code']}, Response: {$api_response['response']}, cURL Error: {$api_response['error']}");
            echo json_encode(['success' => false, 'message' => 'Error sending form. Please try again.']);
        }
    } else {
        echo json_encode(['success' => false, 'errors' => $errors]);
    }
    exit;
}

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Set page title
$page_title = "Home";
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		
		<meta charset="UTF-8">
		<!-- For IE -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!-- For Resposive Device -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- For Window Tab Color -->
		<!-- Chrome, Firefox OS and Opera -->
		<meta name="theme-color" content="#061948">
		<!-- Windows Phone -->
		<meta name="msapplication-navbutton-color" content="#061948">
		<!-- iOS Safari -->
		<meta name="apple-mobile-web-app-status-bar-style" content="#061948">

		<title><?php echo sanitize_output($page_title); ?> - Care Global</title>
		<!-- Favicon -->
		<link rel="icon" type="image/png" sizes="56x56" href="images/fav-icon/milogoleg-removebg-preview.png">
		<!-- Main style sheet -->
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<!-- responsive style sheet -->
		<link rel="stylesheet" type="text/css" href="css/responsive.css">

		<!-- Fix Internet Explorer ______________________________________-->
		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
			<script src="vendor/html5shiv.js"></script>
			<script src="vendor/respond.js"></script>
		<![endif]-->	
	</head>

	<body>
		<div class="main-page-wrapper">

			<!-- ===================================================
				Loading Transition
			==================================================== -->
			<div id="loader-wrapper">
				<div id="loader"></div>
			</div>

			

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
									   <li><a href="index.php" style="color: white; text-decoration: none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Home</a></li>
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
									    	<ul class="dropdown" style="color: white;">
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
												$dir = 'blogs/';
												if (is_dir($dir)) {
													$archivos = scandir($dir);

													foreach ($archivos as $archivo) {
														// Saltar . y ..
														if ($archivo === '.' || $archivo === '..') continue;

														// Solo archivos .php
														if (pathinfo($archivo, PATHINFO_EXTENSION) === 'php') {
															$nombre = pathinfo($archivo, PATHINFO_FILENAME);
															// Convertir guiones o guiones bajos a espacios y capitalizar
															$nombre_legible = ucwords(str_replace(['-', '_'], ' ', $nombre));
															echo "<li><a href=\"https://homecare.global/blogs/$nombre\">$nombre_legible</a></li>";
														}
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
				Theme Main Banner
			============================================== 
			-->
			
			<div id="theme-main-banner" class="banner-one">
				<div data-src="images/home/new-slider.png">
					<div class="camera_caption">
						<div class="container">
				<h1 class="wow fadeInUp animated" data-wow-delay="0.2s" style="
					color: #2c5f94;
					background-color: rgba(224, 224, 224, 0.7); /* gris claro con opacidad */
					padding: 12px 8px; /* 12px arriba/abajo, 8px izquierda/derecha */
					display: inline-block;
					border-radius: 6px;
				">
					Brindamos servicios de enfermería en casa
				</h1>


							<a href="https://wa.me/50256867313" class="theme-button-one wow fadeInUp animated" data-wow-delay="0.39s">CONTACTANOS</a>
						</div> <!-- /.container -->
					</div> <!-- /.camera_caption -->
				</div>
				<div data-src="images/home/changer-2.png">
					<div class="camera_caption">
						<div class="container">
							
							<h1 class="wow fadeInUp animated" data-wow-delay="0.2s" style="
								color: #2c5f94;
								background-color: rgba(224, 224, 224, 0.7); /* gris claro con opacidad */
								padding: 12px 8px; /* 12px arriba/abajo, 8px izquierda/derecha */
								display: inline-block;
								border-radius: 6px;
							">
								Llamanos a cualquier hora del dia
							</h1>


							<a href="https://wa.me/50256867313" class="theme-button-one wow fadeInUp animated" data-wow-delay="0.39s">CONTACTANOS</a>
						</div> <!-- /.container -->
					</div> <!-- /.camera_caption -->
				</div>
				<div data-src="images/home/changer-3.png">
					<div class="camera_caption">
						<div class="container">
							
							<h1 class="wow fadeInUp animated" data-wow-delay="0.2s" style="
								color: #2c5f94;
								background-color: rgba(224, 224, 224, 0.7); /* gris claro con opacidad */
								padding: 12px 8px; /* 12px arriba/abajo, 8px izquierda/derecha */
								display: inline-block;
								border-radius: 6px;
							">
								Nuestras enfermeras estan altamente capacitadas
							</h1>



							<a href="https://wa.me/50256867313" class="theme-button-one wow fadeInUp animated" data-wow-delay="0.39s">CONTACTANOS</a>
						</div> <!-- /.container -->
					</div> <!-- /.camera_caption -->
				</div>
			</div> 
			<!-- 
			=============================================
				Top Feature
			============================================== 
			-->
			<div class="top-feature section-spacing">
				<div class="top-features-slide">
					<div class="item">
						<div class="main-content" style="background:#fafafa;">
							<img src="images/icon/nurse.png" alt="Consumer Insights">
							<h4>Enfermeras a domicilio</h4>
							<p>Ofrecemos enfermeras a domilio, que llegan a tu casa a dar atencion medica</p>
						</div> <!-- /.main-content -->
					</div> <!-- /.item -->
					<div class="item">
						<div class="main-content" style="background:#f6f6f6;">
							<img src="images/icon/medicine.png" alt="Emerging Ideas">
							<h4>Administracion de Medicamentos</h4>
							<p>Nuestras enfermeras tienen la capacidad de administrar diferentes medicamentos</p>
						</div> <!-- /.main-content -->
					</div> <!-- /.item -->
					<div class="item">
						<div class="main-content" style="background:#efefef;">
							<img src="images/icon/24-hours (1).png" alt="Thought Leadership">
							<h4>Atencion 24 horas</h4>
							<p>Atencion a toda hora del dia a tus seres queridos</p>
							<br/>
							<br/>
						</div> 
					</div> <!-- /.item -->
					<div class="item">
						<div class="main-content" style="background:#e9e9e9;">
							<img src="images/icon/price-down (1).png" alt="Marketing Goals">
							<h4>Bajo Costo</h4>
							<p>Servicios a bajo costo, cotiza con nosotros en nuestro whatsapp +502 5686-7560</p>
							
						</div> <!-- /.main-content -->
					</div> <!-- /.item -->
				</div> <!-- /.top-features-slide -->
			</div> <!-- /.top-feature -->


			<!-- 
			=============================================
				About Company
			============================================== 
			-->
			<div class="about-compnay section-spacing">
				<div class="container">
					<div class="row">
						<div class="col-lg-6 col-12"><img src="images/home/det.jpg" alt="About our company"></div>
						<div class="col-lg-6 col-12">
							<div class="text">
								<div class="theme-title-one">
									<h2>Nuestros Servicios</h2>
									<p>Ofrecemos servicios enfocados en el cuidado de la salud y el bienestar, basados en la innovación tecnológica para preservar y mejorar la calidad de vida. Brindamos atención con altos estándares de profesionalismo, cultivando la confianza de nuestros pacientes, sus familias, los profesionales y las instituciones de salud con las que colaboramos.</p>
									
								</div> <!-- /.theme-title-one -->
								<ul class="mission-goal clearfix">
									<li>
										
										<h4>Atención domiciliar</h4>
									</li>
									<li>
										
										<h4>Enfermería en casa</h4>
									</li>
									<li>
										
										<h4>Cuidados en casa</h4>
									</li>
								</ul> <!-- /.mission-goal -->
							</div> <!-- /.text -->
						</div> <!-- /.col- -->
					</div> <!-- /.row -->
				</div> <!-- /.container -->
			</div> <!-- /.about-compnay -->


			<!-- 
			=============================================
				Feature Banner
			============================================== 
			-->
			<div class="feature-banner section-spacing">
				<div class="opacity">
					<div class="container">
						<h2>Nuestras enfermeras pueden atender a tus seres queridos llegando a tu casa</h2>
						<a href="https://wa.me/50256867313" class="theme-button-one" >Escribenos al whatsapp</a>
					</div> <!-- /.container -->
				</div> <!-- /.opacity -->
			</div> <!-- /.feature-banner -->


			<!-- 
			=============================================
				Service Style One
			============================================== 
			-->
			

			<!--
			=====================================================
				Testimonial Slider
			=====================================================
			-->
			

			<!--
			=====================================================
				Our Team
			=====================================================
			-->
		 <!-- /.our-team -->


			<!--
			=====================================================
				Theme Counter
			=====================================================
			

			<!--
			=====================================================
				Free Consultation - FORMULARIO MEJORADO
			=====================================================
			-->
			<div class="consultation-form section-spacing">
				<div class="container">
					<div class="theme-title-one">
						<h2>¿Necesitas apoyo?</h2>
						<p>Llena el formulario para hablarnos de tu caso</p>
					</div> <!-- /.theme-title-one -->
					<div class="clearfix main-content no-gutters row">
						<div class="col-xl-6 col-lg-5 col-12">
							<img src="images/home/changer.webp" alt="Servicios de cuidado médico">
						</div>
						<div class="col-xl-6 col-lg-7 col-12">
							<div class="form-wrapper">
								<!-- Alerta para mostrar mensajes -->
								<div id="form-message" class="alert" style="display: none; margin-bottom: 20px; padding: 15px; border-radius: 5px;"></div>
								
								<form method="POST" class="theme-form-one" id="consultationForm">
									<input type="hidden" name="csrf_token" value="<?php echo sanitize_output($_SESSION['csrf_token']); ?>">
									<div class="row">
										<div class="col-md-6">
											<input type="text" 
												   name="name" 
												   placeholder="Nombres y Apellidos *" 
												   maxlength="50" 
												   required
												   class="form-input">
											<div class="error-message" id="name-error"></div>
										</div>
										
										<div class="col-md-6">
											<input type="tel" 
												   name="phone" 
												   placeholder="Teléfono *" 
												   maxlength="20" 
												   pattern="[0-9+\-\s]+"
												   required
												   class="form-input">
											<div class="error-message" id="phone-error"></div>
										</div>
										
										<div class="col-md-6">
											<input type="email" 
												   name="email" 
												   placeholder="Correo Electrónico *" 
												   maxlength="100" 
												   required
												   class="form-input">
											<div class="error-message" id="email-error"></div>
										</div>
										
										<div class="col-md-6">
											<select class="form-control" name="service" required>
												<option value="">Seleccione un Servicio *</option>
												<option value="domiciliar">Atención Domiciliar</option>
												<option value="adulto_mayor">Cuidado de Adultos Mayores</option>
												<option value="paliativos">Cuidados Paliativos</option>
												<option value="medicamentos">Administración de Medicamentos</option>
												<option value="postoperatorios">Post Operatorios</option>
											</select>
											<div class="error-message" id="service-error"></div>
										</div>
										
										<div class="col-12">
											<textarea name="message" 
													  placeholder="Cuéntanos más detalles sobre tu caso..." 
													  maxlength="1000" 
													  rows="4"
													  class="form-input"></textarea>
											<div class="char-counter">
												<span id="char-count">0</span>/1000 caracteres
											</div>
										</div>
									</div> <!-- /.row -->
									
									<button type="submit" class="theme-button-one" id="submit-btn">
										<span class="btn-text">ENVIAR CONSULTA</span>
										<span class="btn-loading" style="display: none;">
											<i class="fa fa-spinner fa-spin"></i> ENVIANDO...
										</span>
									</button>
								</form>
							</div> <!-- /.form-wrapper -->
						</div> <!-- /.col- -->
					</div> <!-- /.main-content -->
				</div> <!-- /.container -->
			</div> <!-- /.consultation-form -->



			<!--
			=====================================================
				Partner Slider
			=====================================================
			-->
			 <!-- /.partner-section -->

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
								<h6 class="title">Politicas</h6>
									<ul style="color: white;">
										<li>Política de Calidad</li>

										<li>Declaración de sostenibilidad</li>
										<li>Política de Salud y Seguridad Ocupacional</li>
										<li>Declaración Sostenibilidad Política Ambiental ISO 14001 2024</li>
									</ul>
								<div class="queries"><i class="flaticon-phone-call"></i> Telefono : <a href="https://wa.me/50256867313">(+502) 5686-7313</a></div>
								
							</div> <!-- /.about-widget -->

							<div class="col-xl-4 col-lg-3 col-sm-6 footer-recent-post">
									<h6 class="title">Articulos Recientes</h6>
									<ul>
											<?php
											$carpeta = 'blogs/';
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
									<li><a href="https://homecare.global/cuidadora">Cuidadora de Salud</a></li>
									<li><a href="https://homecare.global/auxiliar">Auxiliar de Enfermeria</a></li>
									<li><a href="https://homecare.global/profesional">Enfermera Profesional</a></li>
								</ul>
							</div> <!-- /.footer-list -->
							
						</div> <!-- /.row -->
					</div> <!-- /.container -->
				</div> <!-- /.top-footer -->
				<div class="bottom-footer">
					<div class="container">
						<div class="row">
							<div class="col-md-6 col-12"><p>&copy; Copyrights <?php echo date('Y'); ?>. All Rights Reserved.</p></div>
							
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

		<!-- SCRIPT MEJORADO PARA EL FORMULARIO -->
		<script>
			document.addEventListener('DOMContentLoaded', function() {
					const form = document.getElementById('consultationForm');
					const messageTextarea = document.querySelector('textarea[name="message"]');
					const charCount = document.getElementById('charCount');
					const submitButton = form.querySelector('button[type="submit"]');
					const btnText = submitButton.querySelector('.btn-text');
					const spinner = submitButton.querySelector('.btn-loading');
					
					// Contador de caracteres
					if (messageTextarea && charCount) {
							messageTextarea.addEventListener('input', function() {
									const count = this.value.length;
									charCount.textContent = count;
									
									if (count > 1000) {
											charCount.style.color = '#dc3545';
									} else {
											charCount.style.color = '#6c757d';
									}
							});
					}
					
					// Validación del formulario
					form.addEventListener('submit', function(e) {
							e.preventDefault();
							
							// Validar formulario
							if (!form.checkValidity()) {
									e.stopPropagation();
									form.classList.add('was-validated');
									return;
							}
							
							// Mostrar spinner
							btnText.textContent = 'ENVIANDO...';
							spinner.classList.remove('d-none');
							submitButton.disabled = true;
							
							// Enviar formulario
							const formData = new FormData(form);
							
							fetch('consultation.php', {
									method: 'POST',
									body: formData
							})
							.then(response => response.text())
							.then(data => {
												const messageBox = document.getElementById('form-message');
												messageBox.style.display = 'block';
												messageBox.classList.add('alert-success');
												messageBox.textContent = 'Formulario enviado correctamente. ¡Gracias por contactarnos!';

												form.reset();
												inputs.forEach(input => input.classList.remove('is-valid', 'is-invalid'));
												
												btnText.textContent = 'ENVIAR CONSULTA';
												spinner.classList.add('d-none');
												submitButton.disabled = false;
										})

							.catch(error => {
								const messageBox = document.getElementById('form-message');
								messageBox.style.display = 'block';
								messageBox.classList.add('alert-danger');
								messageBox.textContent = 'Error al enviar el formulario. Intente de nuevo.';

								btnText.textContent = 'ENVIAR CONSULTA';
								spinner.classList.add('d-none');
								submitButton.disabled = false;
						});

					});
					
					// Validación en tiempo real
					const inputs = form.querySelectorAll('input, select, textarea');
					inputs.forEach(input => {
							input.addEventListener('blur', function() {
									if (this.checkValidity()) {
											this.classList.remove('is-invalid');
											this.classList.add('is-valid');
									} else {
											this.classList.remove('is-valid');
											this.classList.add('is-invalid');
									}
							});
					});
			});
		</script>

	</body>
</html>
				