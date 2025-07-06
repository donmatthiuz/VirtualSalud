<?php
// Include security configuration
require_once 'config.php';

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

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        die('CSRF token mismatch');
    }
    
    // Handle quote form submission
    if (isset($_POST['submit_quote'])) {
        $name = escape_html(trim($_POST['name'] ?? ''));
        $phone = escape_html(trim($_POST['phone'] ?? ''));
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $service = escape_html(trim($_POST['service'] ?? ''));
        $message = escape_html(trim($_POST['message'] ?? ''));
        
        if (empty($name) || empty($email) || empty($service)) {
            $error_message = "Please fill in all required fields.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Please enter a valid email address.";
        } else {
            // Process quote request here
            $success_message = "Thank you for your quote request! We'll get back to you soon.";
        }
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
		<meta name="theme-color" content="#061948">
		<!-- Windows Phone -->
		<meta name="msapplication-navbutton-color" content="#061948">
		<!-- iOS Safari -->
		<meta name="apple-mobile-web-app-status-bar-style" content="#061948">
		<title>Home Version Two - <?php echo $site_name; ?></title>
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
				Theme Header Two
			============================================== 
			-->
			<header class="header-two">
				<div class="top-header">
					<div class="container">
						<div class="row">
							<div class="col-md-6 col-sm-8 col-12">
								<ul class="left-widget">
									<li>We are leading consultant firm!</li>
									<li>
										<div id="polyglotLanguageSwitcher">
											<form action="#" method="POST">
												<input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
												<select id="polyglot-language-options">
													<option id="en" value="en" selected>English</option>
													<option id="fr" value="fr">French</option>
													<option id="de" value="de">German</option>
													<option id="it" value="it">Italian</option>
													<option id="es" value="es">Spanish</option>
												</select>
											</form>
										</div> <!-- End #polyglotLanguageSwitcher -->
									</li>
								</ul>
							</div>
							<div class="col-md-6 col-sm-4 col-12">
								<ul class="social-icon">
									<li><a href="#" rel="noopener noreferrer"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
									<li><a href="#" rel="noopener noreferrer"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
									<li><a href="#" rel="noopener noreferrer"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
									<li><a href="#" rel="noopener noreferrer"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
									<li><a href="#" rel="noopener noreferrer"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
								</ul>
							</div>
						</div> <!-- /.row -->
					</div> <!-- /.container -->
				</div> <!-- /.top-header -->

				<div class="theme-menu-wrapper">
					<div class="container">
						<div class="bg-wrapper clearfix">
							<div class="logo float-left"><a href="index.php"><img src="images/logo/logo.png" alt="<?php echo $site_name; ?>"></a></div>
							<!-- ============== Menu Warpper ================ -->
					   		<div class="menu-wrapper float-left">
					   			<nav id="mega-menu-holder" class="clearfix">
								   <ul class="clearfix">
									    <li class="active"><a href="#" rel="noopener noreferrer">Home</a>
									    	<ul class="dropdown">
									        	<li><a href="index.php">Home version one</a></li>
									        	<li><a href="index-2.php">Home version two</a></li>
									      </ul>
									    </li>
									    <li><a href="#" rel="noopener noreferrer">PAGES</a>
									    	<ul class="dropdown">
									    		<li><a href="about.php">About us</a></li>
									    		<li><a href="team.php">Our team</a></li>
									    		<li><a href="faq.php">Faq's</a></li>
									    		<li><a href="404.php">404</a></li>
									    		<li><a href="shop.php">Shop</a></li>
									    		<li><a href="shop-details.php">Shop details</a></li>
									            <li><a href="#" rel="noopener noreferrer">Third Level menu</a>
									    			<ul>
									    				<li><a href="#" rel="noopener noreferrer">Demo one</a></li>
									    				<li><a href="#" rel="noopener noreferrer">Demo two</a></li>
									    			</ul>
									    		</li>
									       </ul>
									    </li>
									    <li><a href="#" rel="noopener noreferrer">Service</a>
									    	<ul class="dropdown">
									        	<li><a href="service.php">Service Version one</a></li>
									        	<li><a href="service-v2.php">Service version two</a></li>
									        	<li><a href="service-details.php">Service Details</a></li>
									       </ul>
									    </li>
									    <li><a href="#" rel="noopener noreferrer">Portfolio</a>
									    	<ul class="dropdown">
									        	<li><a href="project.php">project</a></li>
									        	<li><a href="project-details.php">Project details</a></li>
									       </ul>
									    </li>
									    <li><a href="#" rel="noopener noreferrer">Blog</a>
									    	<ul class="dropdown">
									        	<li><a href="blog.php">Blog List</a></li>
									        	<li><a href="blog-grid.php">Blog Grid</a></li>
									        	<li><a href="blog-details.php">Blog details</a></li>
									       </ul>
									    </li>
									    <li><a href="contact.php">contact</a></li>
								   </ul>
								</nav> <!-- /#mega-menu-holder -->
					   		</div> <!-- /.menu-wrapper -->
					   		<div class="right-widget float-right">
					   			<ul>
					   				<li class="cart-icon">
					   					<a href="#" rel="noopener noreferrer"><i class="flaticon-tool"></i> <span>2</span></a>
					   				</li>
					   				<li class="search-option">
					   					<div class="dropdown">
					   						<button type="button" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-search" aria-hidden="true"></i></button>
											<form action="search.php" class="dropdown-menu" method="POST">
												<input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
												<input type="text" name="search_query" placeholder="Enter Your Search" maxlength="100" required>
												<button type="submit"><i class="fa fa-search"></i></button>
											</form>
					   					</div>
					   				</li>
					   			</ul>
					   		</div> <!-- /.right-widget -->
						</div> <!-- /.bg-wrapper -->
					</div> <!-- /.container -->
				</div> <!-- /.theme-menu-wrapper -->
			</header> <!-- /.header-two -->

			
			<!-- 
			=============================================
				Theme Main Banner
			============================================== 
			-->
			<div id="theme-main-banner" class="banner-one">
				<div data-src="images/home/slide-5.jpg">
					<div class="camera_caption">
						<div class="container">
							<p class="wow fadeInUp animated">The government they survive artical of fortune</p>
							<h1 class="wow fadeInUp animated" data-wow-delay="0.2s">HIGH-QUALITY MARKET <br> EXPERIENCES</h1>
							<a href="about.php" class="theme-button-one wow fadeInUp animated" data-wow-delay="0.39s">ABOUT US</a>
						</div> <!-- /.container -->
					</div> <!-- /.camera_caption -->
				</div>
				<div data-src="images/home/slide-3.jpg">
					<div class="camera_caption">
						<div class="container">
							<p class="wow fadeInUp animated">The government they survive artical of fortune</p>
							<h1 class="wow fadeInUp animated" data-wow-delay="0.2s">HIGH-QUALITY MARKET <br> EXPERIENCES</h1>
							<a href="about.php" class="theme-button-one wow fadeInUp animated" data-wow-delay="0.39s">ABOUT US</a>
						</div> <!-- /.container -->
					</div> <!-- /.camera_caption -->
				</div>
				<div data-src="images/home/slide-1.jpg">
					<div class="camera_caption">
						<div class="container">
							<p class="wow fadeInUp animated">The government they survive artical of fortune</p>
							<h1 class="wow fadeInUp animated" data-wow-delay="0.2s">HIGH-QUALITY MARKET <br> EXPERIENCES</h1>
							<a href="about.php" class="theme-button-one wow fadeInUp animated" data-wow-delay="0.39s">ABOUT US</a>
						</div> <!-- /.container -->
					</div> <!-- /.camera_caption -->
				</div>
			</div> <!-- /#theme-main-banner -->
			
			
			<!-- 
			=============================================
				CallOut Banner 
			============================================== 
			-->
			<div class="callout-banner section-spacing">
				<div class="container clearfix">
					<h3 class="title">Provide solutions for the realiable growth</h3>
					<p>A tale of a fateful trip that started from this tropic port aboard this tiny ship today still wanted by the government they survive as soldiers of fortune to ever wondered the east side to a deluxe apartment.</p>
					<a href="#" class="theme-button-one" rel="noopener noreferrer">FREE QUOTES</a>
				</div>
			</div> <!-- /.callout-banner -->


			<!-- 
			=============================================
				Our Solution
			============================================== 
			-->
			<div class="our-solution section-spacing">
				<div class="container">
					<div class="theme-title-one">
						<h2>Our SOLUTIONS</h2>
					</div> <!-- /.theme-title-one -->
					<div class="wrapper">
						<div class="row">
							<div class="col-lg-4 col-sm-6 col-12">
								<div class="single-solution-block">
									<img src="images/icon/5.png" alt="Business Services" class="icon">
									<h5><a href="service-details.php">Business Services</a></h5>
									<p>The explore strange new worlds to seek fout new life and new civilizations to boldly where no man has before gone. </p>
								</div> <!-- /.single-solution-block -->
							</div> <!-- /.col- -->
							<div class="col-lg-4 col-sm-6 col-12">
								<div class="single-solution-block">
									<img src="images/icon/6.png" alt="Business Services" class="icon">
									<h5><a href="service-details.php">Business Services</a></h5>
									<p>The explore strange new worlds to seek fout new life and new civilizations to boldly where no man has before gone. </p>
								</div> <!-- /.single-solution-block -->
							</div> <!-- /.col- -->
							<div class="col-lg-4 col-sm-6 col-12">
								<div class="single-solution-block">
									<img src="images/icon/7.png" alt="Business Services" class="icon">
									<h5><a href="service-details.php">Business Services</a></h5>
									<p>The explore strange new worlds to seek fout new life and new civilizations to boldly where no man has before gone. </p>
								</div> <!-- /.single-solution-block -->
							</div> <!-- /.col- -->
							<div class="col-lg-4 col-sm-6 col-12">
								<div class="single-solution-block">
									<img src="images/icon/8.png" alt="Business Services" class="icon">
									<h5><a href="service-details.php">Business Services</a></h5>
									<p>The explore strange new worlds to seek fout new life and new civilizations to boldly where no man has before gone. </p>
								</div> <!-- /.single-solution-block -->
							</div> <!-- /.col- -->
							<div class="col-lg-4 col-sm-6 col-12">
								<div class="single-solution-block">
									<img src="images/icon/9.png" alt="Business Services" class="icon">
									<h5><a href="service-details.php">Business Services</a></h5>
									<p>The explore strange new worlds to seek fout new life and new civilizations to boldly where no man has before gone. </p>
								</div> <!-- /.single-solution-block -->
							</div> <!-- /.col- -->
							<div class="col-lg-4 col-sm-6 col-12">
								<div class="single-solution-block">
									<img src="images/icon/10.png" alt="Business Services" class="icon">
									<h5><a href="service-details.php">Business Services</a></h5>
									<p>The explore strange new worlds to seek fout new life and new civilizations to boldly where no man has before gone. </p>
								</div> <!-- /.single-solution-block -->
							</div> <!-- /.col- -->
						</div> <!-- /.row -->
					</div> <!-- /.wrapper -->
				</div> <!-- /.container -->
			</div> <!-- /.our-solution -->


			<!-- 
			=============================================
				About Company Stye Two
			============================================== 
			-->
			<div class="about-compnay-two section-spacing">
				<div class="overlay">
					<div class="container">
						<div class="row no-gutters">
							<div class="col-lg-7 col-12 text">
								<div class="theme-title-one">
									<h2>ABOUT US</h2>
								</div> <!-- /.theme-title-one -->
								<p>A tale of a fateful trip that started from this tropic port aboard this tiny ship today still wanted by the government they survive as soldiers of fortune to a deluxe you apartment in the sky to explore strange new worlds to seek out new life and new civilizations to boldly go where no man has gone.</p>
								<p>You would see the biggest gift would be from me and the card attached would so thank you for being a friend the biggest gift.</p>
								<img src="images/home/sign.png" alt="Signature" class="sign">
							</div> <!-- /.col- -->
							<div class="col-lg-5 col-12">
								<div class="quote-form">
									<?php if (isset($success_message)): ?>
										<div class="alert alert-success"><?php echo $success_message; ?></div>
									<?php endif; ?>
									
									<?php if (isset($error_message)): ?>
										<div class="alert alert-danger"><?php echo $error_message; ?></div>
									<?php endif; ?>
									
									<form action="" class="theme-form-one" method="POST">
										<input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
										<div class="row">
											<div class="col-md-6"><input type="text" name="name" placeholder="Name *" maxlength="100" required></div>
											<div class="col-md-6"><input type="text" name="phone" placeholder="Phone *" maxlength="20" required></div>
											<div class="col-md-6"><input type="email" name="email" placeholder="Email *" maxlength="100" required></div>
											<div class="col-md-6">
												<select class="form-control" name="service" required>
											      <option value="">Choose Services?</option>
											      <option value="business">Business Services</option>
											      <option value="consumer">Consumer Product</option>
											      <option value="financial">Financial Services</option>
											      <option value="software">Software Research</option>
											    </select>
											</div>
											<div class="col-12"><textarea name="message" placeholder="Message" maxlength="1000"></textarea></div>
										</div> <!-- /.row -->
										<button type="submit" name="submit_quote" class="theme-button-one">GET A QUOTES</button>
									</form>
								</div> <!-- /.quote-form -->
							</div>
						</div> <!-- /.row -->
					</div> <!-- /.container -->
				</div> <!-- /.overlay -->
			</div> <!-- /.about-compnay-two -->


			<!-- 
			=============================================
				Our Case
			============================================== 
			-->
			<div class="our-case section-spacing">
				<div class="container">
					<div class="theme-title-one">
						<h2>Our CASES</h2>
						<p>A tale of a fateful trip that started from this tropic port aboard this tiny ship today stillers</p>
					</div> <!-- /.theme-title-one -->
					<div class="wrapper">
						<div class="row">
							<div class="col-lg-4 col-sm-6 col-12">
								<div class="single-case-block">
									<img src="images/portfolio/1.jpg" alt="Business Meeting">
									<div class="hover-content">
										<div class="text clearfix">
											<div class="float-left">
												<h5><a href="project-details.php">Business Meeting</a></h5>
												<p>Explore strange new worlds</p>
											</div>
											<a href="project-details.php" class="details float-right"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
										</div> <!-- /.text -->
									</div> <!-- /.hover-content -->
								</div> <!-- /.single-case-block -->
							</div> <!-- /.col- -->
							<div class="col-lg-4 col-sm-6 col-12">
								<div class="single-case-block">
									<img src="images/portfolio/2.jpg" alt="Business Meeting">
									<div class="hover-content">
										<div class="text clearfix">
											<div class="float-left">
												<h5><a href="project-details.php">Business Meeting</a></h5>
												<p>Explore strange new worlds</p>
											</div>
											<a href="project-details.php" class="details float-right"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
										</div> <!-- /.text -->
									</div> <!-- /.hover-content -->
								</div> <!-- /.single-case-block -->
							</div> <!-- /.col- -->
							<div class="col-lg-4 col-sm-6 col-12">
								<div class="single-case-block">
									<img src="images/portfolio/3.jpg" alt="Business Meeting">
									<div class="hover-content">
										<div class="text clearfix">
											<div class="float-left">
												<h5><a href="project-details.php">Business Meeting</a></h5>
												<p>Explore strange new worlds</p>
											</div>
											<a href="project-details.php" class="details float-right"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
										</div> <!-- /.text -->
									</div> <!-- /.hover-content -->
								</div> <!-- /.single-case-block -->
							</div> <!-- /.col- -->
							<div class="col-lg-4 col-sm-6 col-12">
								<div class="single-case-block">
									<img src="images/portfolio/4.jpg" alt="Business Meeting">
									<div class="hover-content">
										<div class="text clearfix">
											<div class="float-left">
												<h5><a href="project-details.php">Business Meeting</a></h5>
												<p>Explore strange new worlds</p>
											</div>
											<a href="project-details.php" class="details float-right"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
										</div> <!-- /.text -->
									</div> <!-- /.hover-content -->
								</div> <!-- /.single-case-block -->
							</div> <!-- /.col- -->
							<div class="col-lg-4 col-sm-6 col-12">
								<div class="single-case-block">
									<img src="images/portfolio/5.jpg" alt="Business Meeting">
									<div class="hover-content">
										<div class="text clearfix">
											<div class="float-left">
												<h5><a href="project-details.php">Business Meeting</a></h5>
												<p>Explore strange new worlds</p>
											</div>
											<a href="project-details.php" class="details float-right"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
										</div> <!-- /.text -->
									</div> <!-- /.hover-content -->
								</div> <!-- /.single-case-block -->
							</div> <!-- /.col- -->
							<div class="col-lg-4 col-sm-6 col-12">
								<div class="single-case-block">
									<img src="images/portfolio/6.jpg" alt="Business Meeting">
									<div class="hover-content">
										<div class="text clearfix">
											<div class="float-left">
												<h5><a href="project-details.php">Business Meeting</a></h5>
												<p>Explore strange new worlds</p>
											</div>
											<a href="project-details.php" class="details float-right"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
										</div> <!-- /.text -->
									</div> <!-- /.hover-content -->
								</div> <!-- /.single-case-block -->
							</div> <!-- /.col- -->
						</div> <!-- /.row -->
					</div> <!-- /.wrapper -->
					<div class="view-all"><a href="project.php" class="theme-button-one">VIEW ALL</a></div>
				</div> <!-- /.container -->
			</div> <!-- /.our-case -->


			<!--
			=====================================================
				Faq Section
			=====================================================
			-->
			<div class="faq-section">
				<div class="overlay">
					<div class="container">
						<div class="theme-title-one">
							<h2>Faq's</h2>
							<p>A tale of a fateful trip that started from this tropic port aboard this tiny ship today stillers</p>
						</div> <!-- /.theme-title-one -->

						<div class="wrapper row no-gutters">
							<div class="col-xl-6 col-lg-7 order-last">
								<div class="faq-content">
									<div class="accordion-one">
										<div class="panel-group theme-accordion" id="accordion">
										  <div class="panel">
										    <div class="panel-heading">
										      <h6 class="panel-title">
										        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" rel="noopener noreferrer">
										        1. What industries do you specialize in?</a>
										      </h6>
										    </div>
										    <div id="collapse1" class="panel-collapse collapse">
										      <div class="panel-body">
										      	<p>A tale of a fateful trip that started from this tropic port aboard this tiny ship today still wanted by the government they survive as soldiers of fortune to a deluxe you apartment.</p>
										      </div>
										    </div>
										  </div> <!-- /panel 1 -->
										  <div class="panel">
										    <div class="panel-heading active-panel">
										      <h6 class="panel-title">
										        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" rel="noopener noreferrer">
										        2. You guarantee that our plan will raise capital?</a>
										      </h6>
										    </div>
										    <div id="collapse2" class="panel-collapse collapse show">
										      <div class="panel-body">
										      	<p>A tale of a fateful trip that started from this tropic port aboard this tiny ship today still wanted by the government they survive as soldiers of fortune to a deluxe you apartment.</p>
										      </div>
										    </div>
										  </div> <!-- /panel 2 -->
										  <div class="panel">
										    <div class="panel-heading">
										      <h6 class="panel-title">
										        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3" rel="noopener noreferrer">
										        3. Do you ever invest in your clients?</a>
										      </h6>
										    </div>
										    <div id="collapse3" class="panel-collapse collapse">
										      <div class="panel-body">
										      	<p>A tale of a fateful trip that started from this tropic port aboard this tiny ship today still wanted by the government they survive as soldiers of fortune to a deluxe you apartment.</p>
										      </div>
										    </div>
										  </div> <!-- /panel 3 -->
										  <div class="panel">
										    <div class="panel-heading">
										      <h6 class="panel-title">
										        <a data-toggle="collapse" data-parent="#accordion" href="#collapse4" rel="noopener noreferrer">
										       4. What makes your financial projections special?</a>
										      </h6>
										    </div>
										    <div id="collapse4" class="panel-collapse collapse">
										      <div class="panel-body">
										      	<p>A tale of a fateful trip that started from this tropic port aboard this tiny ship today still wanted by the government they survive as soldiers of fortune to a deluxe you apartment.</p>
										      </div>
										    </div>
										  </div> <!-- /panel 4 -->
										  <div class="panel">
										    <div class="panel-heading">
										      <h6 class="panel-title">
										        <a data-toggle="collapse" data-parent="#accordion" href="#collapse5" rel="noopener noreferrer">
										       5. Will you agree with everything I say?</a>
										      </h6>
										    </div>
										    <div id="collapse5" class="panel-collapse collapse">
										      <div class="panel-body">
										      	<p>A tale of a fateful trip that started from this tropic port aboard this tiny ship today still wanted by the government they survive as soldiers of fortune to a deluxe you apartment.</p>
										      </div>
										    </div>
										  </div> <!-- /panel 5 -->
										</div> <!-- end #accordion -->
									</div> <!-- End of .accordion-one -->
								</div> <!-- /.faq-content -->
							</div> <!-- /.col- -->
							<div class="col-xl-6 col-lg-5 order-first"><div class="img-box"><a data-fancybox href="https://www.youtube.com/embed/r-AuLm7S3XE?rel=0&amshowinfo=0" class="play"><i class="fa fa-play" aria-hidden="true"></i></a></div></div>
						</div> <!-- /.wrapper -->
					</div> <!-- /.container -->
				</div> <!-- /.overlay -->
			</div> <!-- /.faq-section -->


			<!--
			=====================================================
				Why Choose us
			=====================================================
			-->
			<div class="why-choose-us section-spacing">
				<div class="container">
					<div class="theme-title-one">
						<h2>Why Choose Us</h2>
					</div> <!-- /.theme-title-one -->

					<div class="wrapper">
						<div class="row">
							<div class="col-lg-4 col-12">
								<div class="single-block">
									<i class="icon flaticon-puzzle"></i>
									<h5><a href="#" rel="noopener noreferrer">Best Strategy</a></h5>
									<p>The Love Boat soon will be making another run explore strange tools enter new worlds.</p>
								</div> <!-- /.single-block -->
							</div> <!-- /.col- -->
							<div class="col-lg-4 col-12">
								<div class="single-block">
									<i class="icon flaticon-presentation"></i>
									<h5><a href="#" rel="noopener noreferrer">High-Quality Services</a></h5>
									<p>The Love Boat soon will be making another run explore strange tools enter new worlds.</p>
								</div> <!-- /.single-block -->
							</div> <!-- /.col- -->
							<div class="col-lg-4 col-12">
								<div class="single-block">
									<i class="icon flaticon-people"></i>
									<h5><a href="#" rel="noopener noreferrer">Friendly Support</a></h5>
									<p>The Love Boat soon will be making another run explore strange tools enter new worlds.</p>
								</div> <!-- /.single-block -->
							</div> <!-- /.col- -->
						</div> <!-- /.row -->
					</div> <!-- /.wrapper -->
				</div> <!-- /.container -->
			</div> <!-- /.why-choose-us -->


			<!--
			=====================================================
				Short Banner
			=====================================================
			-->
			<div class="short-banner section-spacing">
				<div class="overlay">
					<div class="container">
						<h2>Our business plan consultants have real world experience</h2>
					</div>
				</div> <!-- /.overlay -->
			</div> <!-- /.short-banner -->


			<!--
			=====================================================
				Latest News
			=====================================================
			-->
			<div class="our-blog latest-news section-spacing">
				<div class="container">
					<div class="theme-title-one">
						<h2>Latest News</h2>
						<p>A tale of a fateful trip that started from this tropic port aboard this tiny ship today stillers </p>
					</div> <!-- /.theme-title-one -->
					<div class="wrapper">
						<div class="clearfix">
							<div class="latest-news-slider">
								<div class="item">
									<div class="single-blog">
										<div class="image-box">
											<img src="images/blog/3.jpg" alt="Blog Post">
											<div class="overlay"><a href="#" class="date" rel="noopener noreferrer">Feb 06, 2018</a></div>
										</div> <!-- /.image-box -->
										<div class="post-meta">
											<h5 class="title"><a href="blog-details.php">Trouble with the law since to eastern side of yellow mint</a></h5>
											<a href="blog-details.php" class="read-more">READ MORE</a>
										</div> <!-- /.post-meta -->
									</div> <!-- /.single-blog -->
								</div> <!-- /.col- -->
								<div class="item">
									<div class="single-blog">
										<div class="image-box">
											<img src="images/blog/4.jpg" alt="Blog Post">
											<div class="overlay"><a href="#" class="date" rel="noopener noreferrer">Mar 30, 2018</a></div>
										</div> <!-- /.image-box -->
										<div class="post-meta">
											<h5 class="title"><a href="blog-details.php">Kind of torture to have to watch the show the one day</a></h5>
											<a href="blog-details.php" class="read-more">READ MORE</a>
										</div> <!-- /.post-meta -->
									</div> <!-- /.single-blog -->
								</div> <!-- /.col- -->
								<div class="item">
									<div class="single-blog">
										<div class="image-box">
											<img src="images/blog/5.jpg" alt="Blog Post">
											<div class="overlay"><a href="#" class="date" rel="noopener noreferrer">Apr 14, 2018</a></div>
										</div> <!-- /.image-box -->
										<div class="post-meta">
											<h5 class="title"><a href="blog-details.php">Make the best of things its an uphill climb long time</a></h5>
											<a href="blog-details.php" class="read-more">READ MORE</a>
										</div> <!-- /.post-meta -->
									</div> <!-- /.single-blog -->
								</div> <!-- /.col- -->
							</div> <!-- /.latest-news-slider -->
						</div> <!-- /.row -->
					</div> <!-- /.wrapper -->
				</div> <!-- /.container -->
			</div> <!-- /.our-blog -->



			<!--
			=====================================================
				Google Map
			=====================================================
			-->
			<!-- Google Map -->
			<div class="google-map-one"><div class="map-canvas"></div></div>
			

			<!--
			=====================================================
				Footer
			=====================================================
			-->
			<footer class="theme-footer-two">
				<div class="top-footer">
					<div class="container">
						<div class="row">
							<div class="col-lg-4 col-sm-6 col-12 logo-widget">
								<div class="logo"><a href="index.php"><img src="images/logo/logo2.png" alt="<?php echo $site_name; ?>"></a></div>
								<p>Tthis tropic port aboard this tiny ship today still wanted by theam government they survive on up east side to a deluxe as soldiers.</p>
								<ul class="social-icon">
									<li><a href="#" rel="noopener noreferrer"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
									<li><a href="#" rel="noopener noreferrer"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
									<li><a href="#" rel="noopener noreferrer"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
									<li><a href="#" rel="noopener noreferrer"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
									<li><a href="#" rel="noopener noreferrer"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
								</ul>
							</div> <!-- /.logo-widget -->
							<div class="col-lg-2 col-sm-6 col-12 footer-list">
								<h6 class="title">EXPLORE</h6>
								<ul>
									<li><a href="about.php">About us</a></li>
									<li><a href="service.php">Our Solutions</a></li>
									<li><a href="project.php">Case Studies</a></li>
									<li><a href="blog.php">Blog</a></li>
									<li><a href="contact.php">Contact us</a></li>
								</ul>
							</div> <!-- /.footer-list -->
							<div class="col-lg-3 col-sm-6 col-12 footer-gallery">
								<h6 class="title">Gallery</h6>
								<div class="wrapper">
									<div class="row">
										<div class="col-4">
											<a href="images/portfolio/7.jpg" data-fancybox="gallery" data-caption="Caption for single image" class="fancybox"><img src="images/portfolio/7.jpg" alt="Gallery Image"></a>
										</div>
										<div class="col-4">
											<a href="images/portfolio/8.jpg" data-fancybox="gallery" data-caption="Caption for single image" class="fancybox"><img src="images/portfolio/8.jpg" alt="Gallery Image"></a>
										</div>
										<div class="col-4">
											<a href="images/portfolio/9.jpg" data-fancybox="gallery" data-caption="Caption for single image" class="fancybox"><img src="images/portfolio/9.jpg" alt="Gallery Image"></a>
										</div>
										<div class="col-4">
											<a href="images/portfolio/10.jpg" data-fancybox="gallery" data-caption="Caption for single image" class="fancybox"><img src="images/portfolio/10.jpg" alt="Gallery Image"></a>
										</div>
										<div class="col-4">
											<a href="images/portfolio/11.jpg" data-fancybox="gallery" data-caption="Caption for single image" class="fancybox"><img src="images/portfolio/11.jpg" alt="Gallery Image"></a>
										</div>
										<div class="col-4">
											<a href="images/portfolio/12.jpg" data-fancybox="gallery" data-caption="Caption for single image" class="fancybox"><img src="images/portfolio/12.jpg" alt="Gallery Image"></a>
										</div>
									</div>
								</div>
							</div> <!-- /.footer-gallery -->
							
							<div class="col-lg-3 col-sm-6 col-12 contact-widget">
								<h6 class="title">CONTACT</h6>
								<ul>
									<li>
										<i class="flaticon-direction-signs"></i>
										23A, Queenstown St, Log Vegas, United States.
									</li>
									<li>
										<i class="flaticon-multimedia-1"></i>
										<a href="#" rel="noopener noreferrer">mailhere@support.com</a>
									</li>
									<li>
										<i class="fa fa-phone" aria-hidden="true"></i>
										<a href="#" rel="noopener noreferrer">(+2) 345  9808  000</a>
									</li>
								</ul>
							</div> <!-- /.contact-widget -->
						</div> <!-- /.row -->
					</div> <!-- /.container -->
				</div> <!-- /.top-footer -->
				<div class="bottom-footer">
					<div class="container">
						<p>&copy; <?php echo date('Y'); ?> <?php echo $site_name; ?>. All Rights Reserved.</p>
					</div>
				</div> <!-- /.bottom-footer -->
			</footer> <!-- /.theme-footer-two -->
			

	        

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
		<!-- Language Stitcher -->
		<script src="vendor/language-switcher/jquery.polyglot.language.switcher.js"></script>
		<!-- Google map js -->
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjQLCCbRKFhsr8BY78g2PQ0_bTyrm_YXU"></script>
		<script src="vendor/sanzzy-map/dist/snazzy-info-window.min.js"></script>

		<!-- Theme js -->
		<script src="js/theme.js"></script>
		<script src="js/map-script.js"></script>
		</div> <!-- /.main-page-wrapper -->
	</body>
</html>
