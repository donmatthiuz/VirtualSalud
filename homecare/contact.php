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

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$message = '';
$message_type = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $message = 'Security token mismatch. Please try again.';
        $message_type = 'error';
    } else {
        // Validate and sanitize form data
        $name = sanitize_input($_POST['name'] ?? '');
        $phone = sanitize_input($_POST['phone'] ?? '');
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $website = sanitize_input($_POST['web'] ?? '');
        $user_message = sanitize_input($_POST['message'] ?? '');
        
        // Validate required fields
        if (empty($name) || empty($phone) || empty($email) || empty($user_message)) {
            $message = 'Please fill in all required fields.';
            $message_type = 'error';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = 'Please enter a valid email address.';
            $message_type = 'error';
        } else {
            // Here you would typically save to database or send email
            // For now, we'll just show a success message
            $message = 'Thank you for your message. We will get back to you soon!';
            $message_type = 'success';
            
            // Generate new CSRF token for security
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }
}

// Set page title
$page_title = "Contact Us";
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
		<title><?php echo sanitize_output($page_title); ?> - Charles Business Consulting</title>
		<!-- Favicon -->
		<link rel="icon" type="image/png" sizes="56x56" href="images/fav-icon/icon.png">
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
						<div class="logo float-left"><a href="index.php"><img src="images/logo/logo.png" alt="Charles Business Consulting"></a></div>
						<div class="address-wrapper float-right">
							<ul>
								<li class="address">
									<i class="icon flaticon-placeholder"></i>
									<h6>Address:</h6>
									<p>2A0, Queenstown St, USA.</p>
								</li>
								<li class="address">
									<i class="icon flaticon-multimedia"></i>
									<h6>Mail us:</h6>
									<p>supporthere@mail.com</p>
								</li>
								<li class="quotes"><a href="contact.php">GET A QUOTES</a></li>
							</ul>
						</div> <!-- /.address-wrapper -->
					</div> <!-- /.container -->
				</div> <!-- /.top-header -->

				<div class="theme-menu-wrapper">
					<div class="container">
						<div class="bg-wrapper clearfix">
							<!-- ============== Menu Warpper ================ -->
					   		<div class="menu-wrapper float-left">
					   			<nav id="mega-menu-holder" class="clearfix">
								   <ul class="clearfix">
									    <li><a href="#">Home</a>
									    	<ul class="dropdown">
									        	<li><a href="index.php">Home version one</a></li>
									        	<li><a href="index-2.php">Home version two</a></li>
									      </ul>
									    </li>
									    <li><a href="#">PAGES</a>
									    	<ul class="dropdown">
									    		<li><a href="about.php">About us</a></li>
									    		<li><a href="team.php">Our team</a></li>
									    		<li><a href="faq.php">Faq's</a></li>
									    		<li><a href="404.php">404</a></li>
									    		<li><a href="shop.php">Shop</a></li>
									    		<li><a href="shop-details.php">Shop details</a></li>
									            <li><a href="#">Third Level menu</a>
									    			<ul>
									    				<li><a href="#">Demo one</a></li>
									    				<li><a href="#">Demo two</a></li>
									    			</ul>
									    		</li>
									       </ul>
									    </li>
									    <li><a href="#">Service</a>
									    	<ul class="dropdown">
									        	<li><a href="service.php">Service Version one</a></li>
									        	<li><a href="service-v2.php">Service version two</a></li>
									        	<li><a href="service-details.php">Service Details</a></li>
									       </ul>
									    </li>
									    <li><a href="#">Portfolio</a>
									    	<ul class="dropdown">
									        	<li><a href="project.php">project</a></li>
									        	<li><a href="project-details.php">Project details</a></li>
									       </ul>
									    </li>
									    <li><a href="#">Blog</a>
									    	<ul class="dropdown">
									        	<li><a href="blog.php">Blog List</a></li>
									        	<li><a href="blog-grid.php">Blog Grid</a></li>
									        	<li><a href="blog-details.php">Blog details</a></li>
									       </ul>
									    </li>
									    <li class="active"><a href="contact.php">contact</a></li>
								   </ul>
								</nav> <!-- /#mega-menu-holder -->
					   		</div> <!-- /.menu-wrapper -->

					   		<div class="right-widget float-right">
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
											<form action="search.php" method="GET" class="dropdown-menu">
												<input type="text" name="q" placeholder="Enter Your Search" maxlength="100" required>
												<button type="submit"><i class="fa fa-search"></i></button>
											</form>
					   					</div>
					   				</li>
					   			</ul>
					   		</div> <!-- /.right-widget -->
						</div> <!-- /.bg-wrapper -->
					</div> <!-- /.container -->
				</div> <!-- /.theme-menu-wrapper -->
			</header> <!-- /.header-one -->

			
			<!--
			=====================================================
				Google Map
			=====================================================
			-->
			<!-- Google Map -->
			<div class="google-map-two section-spacing"><div class="map-canvas"></div></div>


			<!-- 
			=============================================
				Conatct us Section
			============================================== 
			-->
			<div class="contact-us-section section-spacing">
				<div class="container">
					<div class="theme-title-one">
						<h2>GET IN TOUCH</h2>
						<p>A tale of a fateful trip that started from this tropic port aboard this tiny ship today stillers</p>
					</div> <!-- /.theme-title-one -->
					
					<?php if (!empty($message)): ?>
						<div class="alert alert-<?php echo $message_type === 'success' ? 'success' : 'danger'; ?>" role="alert">
							<?php echo sanitize_output($message); ?>
						</div>
					<?php endif; ?>
					
					<div class="clearfix main-content no-gutters row">
						<div class="col-lg-5 col-12"><div class="img-box"></div></div>
						<div class="col-lg-7 col-12">
							<div class="form-wrapper">
								<form action="contact.php" method="POST" class="theme-form-one form-validation" autocomplete="off">
									<input type="hidden" name="csrf_token" value="<?php echo sanitize_output($_SESSION['csrf_token']); ?>">
									<div class="row">
										<div class="col-sm-6 col-12">
											<input type="text" placeholder="Name *" name="name" maxlength="50" required 
												   value="<?php echo isset($_POST['name']) ? sanitize_output($_POST['name']) : ''; ?>">
										</div>
										<div class="col-sm-6 col-12">
											<input type="tel" placeholder="Phone *" name="phone" maxlength="20" required 
												   value="<?php echo isset($_POST['phone']) ? sanitize_output($_POST['phone']) : ''; ?>">
										</div>
										<div class="col-sm-6 col-12">
											<input type="email" placeholder="Email *" name="email" maxlength="100" required 
												   value="<?php echo isset($_POST['email']) ? sanitize_output($_POST['email']) : ''; ?>">
										</div>
										<div class="col-sm-6 col-12">
											<input type="url" placeholder="Website" name="web" maxlength="100" 
												   value="<?php echo isset($_POST['web']) ? sanitize_output($_POST['web']) : ''; ?>">
										</div>
										<div class="col-12">
											<textarea placeholder="Message *" name="message" maxlength="1000" required><?php echo isset($_POST['message']) ? sanitize_output($_POST['message']) : ''; ?></textarea>
										</div>
									</div> <!-- /.row -->
									<button type="submit" class="theme-button-one">SEND MESSAGE</button>
								</form>
							</div> <!-- /.form-wrapper -->
						</div> <!-- /.col- -->
					</div> <!-- /.main-content -->
				</div> <!-- /.container -->
			</div> <!-- /.contact-us-section -->



			<!-- 
			=============================================
				Compnay Branch Address
			============================================== 
			-->
			<div class="branch-address">
				<div class="container">
					<div class="row">
						<div class="address-slider">
							<div class="item">
								<div class="wrapper">
									<h6>United States Office</h6>
									<p><i class="fa fa-address-book-o" aria-hidden="true"></i> 23A, Queenstown St, Log Vegas, United States.</p>
								</div> <!-- /.wrapper -->
							</div>
							<div class="item">
								<div class="wrapper">
									<h6>Australia Office</h6>
									<p><i class="fa fa-address-book-o" aria-hidden="true"></i> consult floor, melbourne, Australia.</p>
								</div> <!-- /.wrapper -->
							</div>
							<div class="item">
								<div class="wrapper">
									<h6>Germany Office</h6>
									<p><i class="fa fa-address-book-o" aria-hidden="true"></i> no:108, shshi st, berlin, <br> Germany.</p>
								</div> <!-- /.wrapper -->
							</div>
							<div class="item">
								<div class="wrapper">
									<h6>London Office</h6>
									<p><i class="fa fa-address-book-o" aria-hidden="true"></i> cityhigh, clock bell floor, United Kingdom.</p>
								</div> <!-- /.wrapper -->
							</div>
						</div> <!-- /.address-slider -->
					</div>
				</div> <!-- /.container -->
			</div> <!-- /.branch-address -->
			
			


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
								<h6 class="title">About OUR Consulting</h6>
								<p>That started from this tropic port aboard this tiny ship today still want by theam government they survive on up to thetre east side to a deluxe as soldiers of artics fortune.</p>
								<div class="queries"><i class="flaticon-phone-call"></i> Any Queries : <a href="tel:+1234567900">(+1) 234 567 900</a></div>
							</div> <!-- /.about-widget -->
							<div class="col-xl-4 col-lg-3 col-sm-6 footer-recent-post">
								<h6 class="title">RECENT POSTS</h6>
								<ul>
									<li class="clearfix">
										<img src="images/blog/1.jpg" alt="Blog post" class="float-left">
										<div class="post float-left">
											<a href="blog-details.php">Till wanted by theam govern they survive as soldiers.</a>
											<div class="date"><i class="fa fa-calendar-o" aria-hidden="true"></i> Feb 06, 2018</div>
										</div>
									</li>
									<li class="clearfix">
										<img src="images/blog/2.jpg" alt="Blog post" class="float-left">
										<div class="post float-left">
											<a href="blog-details.php">World don't move to beat of just one drum.</a>
											<div class="date"><i class="fa fa-calendar-o" aria-hidden="true"></i> Mar 20, 2018</div>
										</div>
									</li>
								</ul>
							</div> <!-- /.footer-recent-post -->
							<div class="col-xl-2 col-lg-3 col-sm-6 footer-list">
								<h6 class="title">SOLUTIONS</h6>
								<ul>
									<li><a href="service.php">Travel and Aviation</a></li>
									<li><a href="service.php">Business Services</a></li>
									<li><a href="service.php">Consumer Products</a></li>
									<li><a href="service.php">Financial Services</a></li>
									<li><a href="service.php">Software Research</a></li>
									<li><a href="service.php">Quality Resourcing</a></li>
								</ul>
							</div> <!-- /.footer-list -->
							<div class="col-xl-3 col-lg-2 col-sm-6 footer-newsletter">
								<h6 class="title">NEWSLETTER</h6>
								<form action="newsletter.php" method="POST">
									<input type="hidden" name="csrf_token" value="<?php echo sanitize_output($_SESSION['csrf_token']); ?>">
									<input type="text" name="name" placeholder="Name *" maxlength="50" required>
									<input type="email" name="email" placeholder="Email *" maxlength="100" required>
									<button type="submit" class="theme-button-one">SUBSCRIBE</button>
								</form>
							</div>
						</div> <!-- /.row -->
					</div> <!-- /.container -->
				</div> <!-- /.top-footer -->
				<div class="bottom-footer">
					<div class="container">
						<div class="row">
							<div class="col-md-6 col-12"><p>&copy; Copyrights <?php echo date('Y'); ?>. All Rights Reserved.</p></div>
							<div class="col-md-6 col-12">
								<ul>
									<li><a href="about.php">About</a></li>
									<li><a href="service.php">Solutions</a></li>
									<li><a href="faq.php">FAQ's</a></li>
									<li><a href="contact.php">Contact</a></li>
								</ul>
							</div>
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
		<!-- Validation -->
		<script type="text/javascript" src="vendor/contact-form/validate.js"></script>
		<script type="text/javascript" src="vendor/contact-form/jquery.form.js"></script>
		<!-- Google map js -->
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjQLCCbRKFhsr8BY78g2PQ0_bTyrm_YXU"></script>
		<script src="vendor/sanzzy-map/dist/snazzy-info-window.min.js"></script>

		<!-- Theme js -->
		<script src="js/theme.js"></script>
		<script src="js/map-script.js"></script>
		</div> <!-- /.main-page-wrapper -->
	</body>
</html>
