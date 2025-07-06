<?php
// Incluir configuración
require_once 'inc/config.php';

// Función para sanitizar salida
function escape_html($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Función para validar y sanitizar URLs
function validate_url($url) {
    $url = filter_var($url, FILTER_SANITIZE_URL);
    return filter_var($url, FILTER_VALIDATE_URL) ? $url : '#';
}

// Variables del sitio (sanitizadas)
$site_name = escape_html(SITE_NAME);
$site_url = validate_url(SITE_URL);
$site_email = escape_html(SITE_EMAIL);

// Token CSRF para formularios
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

// Página general - sin lógica específica
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
		<title>Página no encontrada - <?php echo $site_name; ?></title>
		<!-- Favicon -->
		<link rel="icon" type="image/png" sizes="56x56" href="images/fav-icon/icon.png">
		<!-- Main style sheet -->
		<link rel="stylesheet" type="text/css" href="<?php echo $site_url; ?>/css/style.css">
		<!-- responsive style sheet -->
		<link rel="stylesheet" type="text/css" href="<?php echo $site_url; ?>/css/responsive.css">

		<!-- Fix Internet Explorer ______________________________________-->
		<!--[if lt IE 9]>
			<script src="<?php echo $site_url; ?>/http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
			<script src="<?php echo $site_url; ?>/vendor/html5shiv.js"></script>
			<script src="<?php echo $site_url; ?>/vendor/respond.js"></script>
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
						<div class="logo float-left"><a href="<?php echo $site_url; ?>"><img src="<?php echo $site_url; ?>/images/logo/logo.png" alt=""></a></div>
						<div class="address-wrapper float-right">
							<ul>
								<li class="address">
									<i class="icon flaticon-placeholder"></i>
									<h6>Address:</h6>
									<p>Guatemala City, Guatemala</p>
								</li>
								<li class="address">
									<i class="icon flaticon-multimedia"></i>
									<h6>Mail us:</h6>
									<p><?php echo $site_email; ?></p>
								</li>
								<li class="quotes"><a href="#" rel="noopener noreferrer">GET A QUOTES</a></li>
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
									    <li><a href="#" rel="noopener noreferrer">Home</a>
									    	<ul class="dropdown">
									        	<li><a href="<?php echo $site_url; ?>">Home version one</a></li>
									        	<li><a href="index-2.html">Home version two</a></li>
									      </ul>
									    </li>
									    <li class="active"><a href="#" rel="noopener noreferrer">PAGES</a>
									    	<ul class="dropdown">
									    		<li><a href="<?php echo $site_url; ?>/about.php">About us</a></li>
									    		<li><a href="team.html">Our team</a></li>
									    		<li><a href="<?php echo $site_url; ?>/faq.php">Faq's</a></li>
									    		<li><a href="404.html">404</a></li>
									    		<li><a href="shop.html">Shop</a></li>
									    		<li><a href="shop-details.html">Shop details</a></li>
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
									        	<li><a href="<?php echo $site_url; ?>/services.php">Service Version one</a></li>
									        	<li><a href="service-v2.html">Service version two</a></li>
									        	<li><a href="service-details.html">Service Details</a></li>
									       </ul>
									    </li>
									    <li><a href="#" rel="noopener noreferrer">Portfolio</a>
									    	<ul class="dropdown">
									        	<li><a href="project.html">project</a></li>
									        	<li><a href="project-details.html">Project details</a></li>
									       </ul>
									    </li>
									    <li><a href="#" rel="noopener noreferrer">Blog</a>
									    	<ul class="dropdown">
									        	<li><a href="<?php echo $site_url; ?>/blog.php">Blog List</a></li>
									        	<li><a href="blog-grid.html">Blog Grid</a></li>
									        	<li><a href="blog-details.html">Blog details</a></li>
									       </ul>
									    </li>
									    <li><a href="<?php echo $site_url; ?>/contact.php">contact</a></li>
								   </ul>
								</nav> <!-- /#mega-menu-holder -->
					   		</div> <!-- /.menu-wrapper -->

					   		<div class="right-widget float-right">
					   			<ul>
					   				<li class="social-icon">
					   					<ul>
											<li><a href="#" rel="noopener noreferrer"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
											<li><a href="#" rel="noopener noreferrer"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
											<li><a href="#" rel="noopener noreferrer"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
											<li><a href="#" rel="noopener noreferrer"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
										</ul>
					   				</li>
					   				<li class="cart-icon">
					   					<a href="#" rel="noopener noreferrer"><i class="flaticon-tool"></i> <span>2</span></a>
					   				</li>
					   				<li class="search-option">
					   					<div class="dropdown">
					   						<button type="button" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-search" aria-hidden="true"></i></button>
											<form action="#" class="dropdown-menu" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
												<input type="text" Placeholder="Enter Your Search" maxlength="100">
												<button><i class="fa fa-search"></i></button>
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
			=============================================
				Theme Inner Banner
			============================================== 
			-->
			<div class="theme-inner-banner section-spacing">
				<div class="overlay">
					<div class="container">
						<h2>SHOP DETAILS</h2>
					</div> <!-- /.container -->
				</div> <!-- /.overlay -->
			</div> <!-- /.theme-inner-banner -->


			<!-- 
			=============================================
				Shop Details
			============================================== 
			-->
			<div class="shop-details">
				<div class="container">
					<div class="product-details">
						<div class="row">
							<div class="col-lg-5 col-12">
								<div class="product-tab clearfix">
									<div class="product-preview">
										<div class="tab-content">
										    <div id="tag-one" class="tab-pane active">
										      <img src="<?php echo $site_url; ?>/images/shop/13.jpg" alt="">
										    </div>
										    <div id="tag-two" class="tab-pane fade">
										      <img src="<?php echo $site_url; ?>/images/shop/14.jpg" alt="">
										    </div>
										</div>
									</div> <!-- /.product-preview -->
									<div class="product-thumbnail">
										<ul class="nav-tabs nav">
										    <li class="nav-item">
										      <a class="nav-link active" data-toggle="tab" href="#tag-one" rel="noopener noreferrer"><img src="<?php echo $site_url; ?>/images/shop/15.jpg" alt=""></a>
										    </li>
										    <li class="nav-item">
										      <a class="nav-link" data-toggle="tab" href="#tag-two" rel="noopener noreferrer"><img src="<?php echo $site_url; ?>/images/shop/16.jpg" alt=""></a>
										    </li>
										  </ul>
									</div> <!-- /.product-thumbnail -->
								</div> <!-- /.product-tab -->
							</div>
							<div class="col-lg-7 col-12">
								<div class="product-info">
									<h5 class="title">Contract and Fee-Setting Guide for Consultants</h5>
									<div class="price"><del>$43.00</del>$38.00</div>
									<p>A tale of a fateful trip that started from this tropic port aboard this tiny ship today still wanted by the government  apartment in the sky moving on up to the east side a family to explore strange new worlds to seek out new life and new civilizations to boldly go where no man has gone before you would see the biggest gift would be from me and the card attached would say thank you for being a friend.</p>
									<ul class="order-box">
										<li>Qty:</li>
										<li>
											<button id="value-decrease">-</button>
											<input type="number" min="1" max="22" value="3" class="val" disabled id="product-value">
											<button id="value-increase">+ </button>
										</li>
									</ul>
									<a href="#" class="theme-button-one" rel="noopener noreferrer"><i class="fa fa-shopping-cart" aria-hidden="true"></i> ADD TO CART</a>
								</div> <!-- /.product-info -->
							</div>
						</div>
					</div> <!-- /.product-details -->
					<div class="product-review-tab">
						<ul class="nav nav-tabs">
						    <li class="nav-item">
						      <a class="nav-link active" data-toggle="tab" href="#description" rel="noopener noreferrer">Description</a>
						    </li>
						    <li class="nav-item">
						      <a class="nav-link" data-toggle="tab" href="#review" rel="noopener noreferrer">Reviews(02)</a>
						    </li>
						</ul>
						<!-- Tab panes -->
						<div class="tab-content">
						    <div id="description" class="tab-pane active">
						      <p>This tropic port aboard this tiny ship today still wanted by the government apartment in the sky moving on up to the east side a family to explore strange new worlds to seek out new life and new civilizations to boldly go where new worlds to seek out new life and new civilizations to boldly no man has gone before you would see the biggest gift would be from me and the card.</p>
						      <p>That this group would somehow form a family that's the way we all became the Brady Bunch apartment in the sky moving on up to the east side a family to explore strange new worlds.</p>
						    </div>
						    <div id="review" class="tab-pane fade">
						      <div class="single-review clearfix">
									<img src="<?php echo $site_url; ?>/images/blog/17.jpg" alt="" class="float-left">
									<div class="comment float-left">
										<h6>Alex Martin</h6>
										<ul>
											<li><i class="fa fa-star" aria-hidden="true"></i></li>
											<li><i class="fa fa-star" aria-hidden="true"></i></li>
											<li><i class="fa fa-star" aria-hidden="true"></i></li>
											<li><i class="fa fa-star" aria-hidden="true"></i></li>
											<li><i class="fa fa-star-half-o" aria-hidden="true"></i></li>
										</ul>
										<p>Its a civilizations to boldly go where no man has gone before you would see the biggest gift would be from me and the card attached would say thank you.</p>
									</div> <!-- /.comment -->
								</div> <!-- /.single-review -->
								<div class="single-review clearfix">
									<img src="<?php echo $site_url; ?>/images/blog/17.jpg" alt="" class="float-left">
									<div class="comment float-left">
										<h6>James Frank</h6>
										<ul>
											<li><i class="fa fa-star" aria-hidden="true"></i></li>
											<li><i class="fa fa-star" aria-hidden="true"></i></li>
											<li><i class="fa fa-star" aria-hidden="true"></i></li>
											<li><i class="fa fa-star" aria-hidden="true"></i></li>
											<li><i class="fa fa-star-half-o" aria-hidden="true"></i></li>
										</ul>
										<p>Its a civilizations to boldly go where no man has gone before you would see the biggest gift would be from me and the card attached would say thank you.</p>
									</div> <!-- /.comment -->
								</div> <!-- /.single-review -->
						    </div>
						</div>
					</div> <!-- /.product-review-tab -->
					<div class="related-product shop-page">
						<div class="theme-title-one">
							<h2>RELATED PRODUCTS</h2>
						</div> <!-- /.theme-title-one -->
						<div class="celarfix">
							<div class="related-product-slider">
								<div class="item">
									<div class="single-product">
										<div class="image-box">
											<img src="<?php echo $site_url; ?>/images/shop/1.jpg" alt="">
										</div> <!-- /.image-box -->
										<div class="product-name">
											<h5><a href="#" rel="noopener noreferrer">Power of Elevation</a></h5>
											<div class="price">$32.70</div>
											<div class="add-to-cart"><a href="#" rel="noopener noreferrer"><i class="fa fa-shopping-cart" aria-hidden="true"></i> ADD TO CART</a></div>
										</div>
									</div> <!-- /.single-product -->
								</div> <!-- /.col- -->
								<div class="item">
									<div class="single-product">
										<div class="image-box">
											<img src="<?php echo $site_url; ?>/images/shop/2.jpg" alt="">
										</div> <!-- /.image-box -->
										<div class="product-name">
											<h5><a href="#" rel="noopener noreferrer">Business Plans</a></h5>
											<div class="price">$47.70</div>
											<div class="add-to-cart"><a href="#" rel="noopener noreferrer"><i class="fa fa-shopping-cart" aria-hidden="true"></i> ADD TO CART</a></div>
										</div>
									</div> <!-- /.single-product -->
								</div> <!-- /.col- -->
								<div class="item">
									<div class="single-product">
										<div class="image-box">
											<img src="<?php echo $site_url; ?>/images/shop/3.jpg" alt="">
										</div> <!-- /.image-box -->
										<div class="product-name">
											<h5><a href="#" rel="noopener noreferrer">Consulting Bible</a></h5>
											<div class="price">$26.00</div>
											<div class="add-to-cart"><a href="#" rel="noopener noreferrer"><i class="fa fa-shopping-cart" aria-hidden="true"></i> ADD TO CART</a></div>
										</div>
									</div> <!-- /.single-product -->
								</div> <!-- /.col- -->
								<div class="item">
									<div class="single-product">
										<div class="image-box">
											<img src="<?php echo $site_url; ?>/images/shop/4.jpg" alt="">
										</div> <!-- /.image-box -->
										<div class="product-name">
											<h5><a href="#" rel="noopener noreferrer">Process Consulting</a></h5>
											<div class="price">$46.00</div>
											<div class="add-to-cart"><a href="#" rel="noopener noreferrer"><i class="fa fa-shopping-cart" aria-hidden="true"></i> ADD TO CART</a></div>
										</div>
									</div> <!-- /.single-product -->
								</div> <!-- /.col- -->
								<div class="item">
									<div class="single-product">
										<div class="image-box">
											<img src="<?php echo $site_url; ?>/images/shop/5.jpg" alt="">
										</div> <!-- /.image-box -->
										<div class="product-name">
											<h5><a href="#" rel="noopener noreferrer">Science of overcoming</a></h5>
											<div class="price"><del>$36.00 </del> $32.70</div>
											<div class="add-to-cart"><a href="#" rel="noopener noreferrer"><i class="fa fa-shopping-cart" aria-hidden="true"></i> ADD TO CART</a></div>
										</div>
									</div> <!-- /.single-product -->
								</div> <!-- /.col- -->
								<div class="item">
									<div class="single-product">
										<div class="image-box">
											<img src="<?php echo $site_url; ?>/images/shop/6.jpg" alt="">
										</div> <!-- /.image-box -->
										<div class="product-name">
											<h5><a href="#" rel="noopener noreferrer">Threescore & More</a></h5>
											<div class="price">$30.10</div>
											<div class="add-to-cart"><a href="#" rel="noopener noreferrer"><i class="fa fa-shopping-cart" aria-hidden="true"></i> ADD TO CART</a></div>
										</div>
									</div> <!-- /.single-product -->
								</div> <!-- /.col- -->
								<div class="item">
									<div class="single-product">
										<div class="image-box">
											<img src="<?php echo $site_url; ?>/images/shop/7.jpg" alt="">
										</div> <!-- /.image-box -->
										<div class="product-name">
											<h5><a href="#" rel="noopener noreferrer">The Mckinsey Way</a></h5>
											<div class="price"><del>$43.00 </del>$40.00</div>
											<div class="add-to-cart"><a href="#" rel="noopener noreferrer"><i class="fa fa-shopping-cart" aria-hidden="true"></i> ADD TO CART</a></div>
										</div>
									</div> <!-- /.single-product -->
								</div> <!-- /.col- -->
								<div class="item">
									<div class="single-product">
										<div class="image-box">
											<img src="<?php echo $site_url; ?>/images/shop/8.jpg" alt="">
										</div> <!-- /.image-box -->
										<div class="product-name">
											<h5><a href="#" rel="noopener noreferrer">Outlier Approach</a></h5>
											<div class="price">$33.00</div>
											<div class="add-to-cart"><a href="#" rel="noopener noreferrer"><i class="fa fa-shopping-cart" aria-hidden="true"></i> ADD TO CART</a></div>
										</div>
									</div> <!-- /.single-product -->
								</div> <!-- /.col- -->
								<div class="item">
									<div class="single-product">
										<div class="image-box">
											<img src="<?php echo $site_url; ?>/images/shop/9.jpg" alt="">
										</div> <!-- /.image-box -->
										<div class="product-name">
											<h5><a href="#" rel="noopener noreferrer">Velocity Advantage</a></h5>
											<div class="price">$26.15</div>
											<div class="add-to-cart"><a href="#" rel="noopener noreferrer"><i class="fa fa-shopping-cart" aria-hidden="true"></i> ADD TO CART</a></div>
										</div>
									</div> <!-- /.single-product -->
								</div> <!-- /.col- -->
							</div> <!-- /.related-product-slider -->
						</div>
					</div> <!-- /.related-product -->
				</div> <!-- /.container -->
			</div> <!-- /.shop-details -->
			
			
			


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
								<div class="queries"><i class="flaticon-phone-call"></i> Any Queries : <a href="#" rel="noopener noreferrer">(+1) 234 567 900</a></div>
							</div> <!-- /.about-widget -->
							<div class="col-xl-4 col-lg-3 col-sm-6 footer-recent-post">
								<h6 class="title">RECENT POSTS</h6>
								<ul>
									<li class="clearfix">
										<img src="<?php echo $site_url; ?>/images/blog/1.jpg" alt="" class="float-left">
										<div class="post float-left">
											<a href="blog-details.html">Till wanted by theam govern they survive as soldiers.</a>
											<div class="date"><i class="fa fa-calendar-o" aria-hidden="true"></i> Feb 06, 2018</div>
										</div>
									</li>
									<li class="clearfix">
										<img src="<?php echo $site_url; ?>/images/blog/2.jpg" alt="" class="float-left">
										<div class="post float-left">
											<a href="blog-details.html">World don't move to beat of just one drum.</a>
											<div class="date"><i class="fa fa-calendar-o" aria-hidden="true"></i> Mar 20, 2018</div>
										</div>
									</li>
								</ul>
							</div> <!-- /.footer-recent-post -->
							<div class="col-xl-2 col-lg-3 col-sm-6 footer-list">
								<h6 class="title">SOLUTIONS</h6>
								<ul>
									<li><a href="#" rel="noopener noreferrer">Travel and Aviation</a></li>
									<li><a href="#" rel="noopener noreferrer">Business Services</a></li>
									<li><a href="#" rel="noopener noreferrer">Consumer Products</a></li>
									<li><a href="#" rel="noopener noreferrer">Financial Services</a></li>
									<li><a href="#" rel="noopener noreferrer">Software Research</a></li>
									<li><a href="#" rel="noopener noreferrer">Quality Resourcing</a></li>
								</ul>
							</div> <!-- /.footer-list -->
							<div class="col-xl-3 col-lg-2 col-sm-6 footer-newsletter">
								<h6 class="title">NEWSLETTER</h6>
								<form action="#" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
									<input type="text" placeholder="Name *" maxlength="100">
									<input type="email" placeholder="Email *" maxlength="100">
									<button class="theme-button-one">SUBSCRIBE</button>
								</form>
							</div>
						</div> <!-- /.row -->
					</div> <!-- /.container -->
				</div> <!-- /.top-footer -->
				<div class="bottom-footer">
					<div class="container">
						<div class="row">
							<div class="col-md-6 col-12"><p>&copy; <?php echo date("Y"); ?> <?php echo $site_name; ?>. All Rights Reserved.</p></div>
							<div class="col-md-6 col-12">
								<ul>
									<li><a href="<?php echo $site_url; ?>/about.php">About</a></li>
									<li><a href="<?php echo $site_url; ?>/services.php">Solutions</a></li>
									<li><a href="#" rel="noopener noreferrer">FAQ’s</a></li>
									<li><a href="<?php echo $site_url; ?>/contact.php">Contact</a></li>
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
		<script src="<?php echo $site_url; ?>/vendor/jquery.2.2.3.min.js"></script>
		<!-- Popper js -->
		<script src="<?php echo $site_url; ?>/vendor/popper.js/popper.min.js"></script>
		<!-- Bootstrap JS -->
		<script src="<?php echo $site_url; ?>/vendor/bootstrap/js/bootstrap.min.js"></script>
		<!-- Camera Slider -->
		<script src='vendor/Camera-master/scripts/jquery.mobile.customized.min.js'></script>
	    <script src='vendor/Camera-master/scripts/jquery.easing.1.3.js'></script> 
	    <script src='vendor/Camera-master/scripts/camera.min.js'></script>
	    <!-- menu  -->
		<script src="<?php echo $site_url; ?>/vendor/menu/src/js/jquery.slimmenu.js"></script>
		<!-- WOW js -->
		<script src="<?php echo $site_url; ?>/vendor/WOW-master/dist/wow.min.js"></script>
		<!-- owl.carousel -->
		<script src="<?php echo $site_url; ?>/vendor/owl-carousel/owl.carousel.min.js"></script>
		<!-- js count to -->
		<script src="<?php echo $site_url; ?>/vendor/jquery.appear.js"></script>
		<script src="<?php echo $site_url; ?>/vendor/jquery.countTo.js"></script>
		<!-- Fancybox -->
		<script src="<?php echo $site_url; ?>/vendor/fancybox/dist/jquery.fancybox.min.js"></script>

		<!-- Theme js -->
		<script src="<?php echo $site_url; ?>/js/theme.js"></script>
		</div> <!-- /.main-page-wrapper -->
	</body>
</html>
