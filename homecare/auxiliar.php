<?php
// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');

// Function to sanitize output
function sanitize_output($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// Set page title
$page_title = "Auxiliar de Enfermeria";
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
		<meta name="theme-color" content="#061948">
		<!-- Windows Phone -->
		<meta name="msapplication-navbutton-color" content="#061948">
		<!-- iOS Safari -->
		<meta name="apple-mobile-web-app-status-bar-style" content="#061948">
		<title><?php echo sanitize_output($page_title); ?> - Home Care Global</title>
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
												$archivos = scandir($dir);

												foreach ($archivos as $archivo) {
														// Saltar . y ..
														if ($archivo === '.' || $archivo === '..') continue;

														// Solo archivos .php
														if (pathinfo($archivo, PATHINFO_EXTENSION) === 'php') {
																$nombre = pathinfo($archivo, PATHINFO_FILENAME);
																// Convertir guiones o guiones bajos a espacios y capitalizar
																$nombre_legible = ucwords(str_replace(['-', '_'], ' ', $nombre));
																echo "<li><a href=\"https://homecare.global/sitio/$nombre\">$nombre_legible</a></li>";
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
			</header> <!-- /.header-one -->

			
			<!-- 
			=============================================
				Theme Inner Banner
			============================================== 
			-->
			<div class="theme-inner-banner section-spacing">
				<div class="overlay">
					<div class="container">
						<h2>Auxiliar de Enfermeria</h2>
					</div> <!-- /.container -->
				</div> <!-- /.overlay -->
			</div> <!-- /.theme-inner-banner -->


			<!-- 
			=============================================
				CallOut Banner 
			============================================== 
			-->
			<div class="callout-banner no-bg">
				<div class="container clearfix">
					<h3 class="title">¿ Que Ofrecen  <br> Las Auxiliares ?</br></h3>
					<p>Una Auxiliar de Enfermería es una profesional capacitada para brindar apoyo básico en el cuidado de la salud de pacientes. Se enfoca en tareas como la higiene personal, administración de medicamentos simples (bajo supervisión), toma de signos vitales, movilización del paciente, y apoyo emocional. Su labor es esencial para el bienestar diario de personas en recuperación, de la tercera edad o con enfermedades crónicas.</p>
					<a href="https://wa.me/50256867313" class="theme-button-one">CONTACTANOS</a>
				</div>
			</div> <!-- /.callout-banner -->
			
			
			
			<!-- 
			=============================================
				About Company Stye Two
			============================================== 
			-->
			<div class="about-compnay-two no-bg section-spacing">
				<div class="overlay">
					<div class="container">
						<div class="row">
							<div class="col-lg-6 col-12 text order-lg-last">
								<div class="theme-title-one">
									<h2>Tareas de una Auxiliar</h2>
								</div> <!-- /.theme-title-one -->
								<p>  La auxiliar se enfoca en cuidados generales y asistencia directa, mientras que no está autorizada para realizar procedimientos clínicos complejos. Si buscas un acompañamiento amable y funcional para el día a día de un ser querido, contáctanos por WhatsApp: <a href=https://wa.me/50256867313>aqui</a></p>
								
								
							</div> <!-- /.col- -->
							<div class="col-lg-6 col-12 order-lg-first">
								<img src="images/home/15-1.jpg" alt="About us" class="left-img">
							</div>
						</div> <!-- /.row -->
					</div> <!-- /.container -->
				</div> <!-- /.overlay -->
			</div> <!-- /.about-compnay-two -->

			<div class="feature-banner section-spacing">
				<div class="opacity">
					<div class="container">
						<h2>¿ Necesitas una auxiliar ? </h2>
						<a href="https://wa.me/50256867313" class="theme-button-one" >Escribenos al whatsapp</a>
					</div> <!-- /.container -->
				</div> <!-- /.opacity -->
			</div> 
			<!--
			=====================================================
				Why We Best
			=====================================================
			-->
			<!-- /.why-we-best -->


			<!--
			=====================================================
				Theme Counter
			=====================================================
			-->
			<!-- /.theme-counter -->


			<!-- 
			=============================================
				Core Values
			============================================== 
			-->
			<!-- /.core-values -->



			<!--
			=====================================================
				Partner Slider
			=====================================================
			-->
			


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
		</div> <!-- /.main-page-wrapper -->
	</body>
</html>
