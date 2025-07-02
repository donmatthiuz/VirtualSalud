<?php
// Include configuration and security functions
require_once 'config.php';

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

// Get search query
$search_query = '';
$search_results = [];

if (isset($_GET['q'])) {
    $search_query = sanitize_input($_GET['q']);
    
    // Basic search functionality (you would implement actual search logic here)
    if (!empty($search_query) && strlen($search_query) >= 3) {
        // Mock search results - replace with actual search implementation
        $search_results = [
            [
                'title' => 'Business Services',
                'description' => 'Comprehensive business consulting services for your company.',
                'url' => 'service-details.php'
            ],
            [
                'title' => 'About Us',
                'description' => 'Learn more about our company and our mission.',
                'url' => 'about.php'
            ],
            [
                'title' => 'Contact Us',
                'description' => 'Get in touch with our team for consultation.',
                'url' => 'contact.php'
            ]
        ];
        
        // Filter results based on search query
        $search_results = array_filter($search_results, function($result) use ($search_query) {
            return stripos($result['title'], $search_query) !== false || 
                   stripos($result['description'], $search_query) !== false;
        });
    }
}

$page_title = "Search Results";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#061948">
    <meta name="msapplication-navbutton-color" content="#061948">
    <meta name="apple-mobile-web-app-status-bar-style" content="#061948">
    <title><?php echo sanitize_output($page_title); ?> - Charles Business Consulting</title>
    <link rel="icon" type="image/png" sizes="56x56" href="images/fav-icon/icon.png">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/responsive.css">
</head>
<body>
    <div class="main-page-wrapper">
        <div id="loader-wrapper">
            <div id="loader"></div>
        </div>

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
                    </div>
                </div>
            </div>

            <div class="theme-menu-wrapper">
                <div class="container">
                    <div class="bg-wrapper clearfix">
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
                                    <li><a href="contact.php">contact</a></li>
                               </ul>
                            </nav>
                        </div>

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
                                            <input type="text" name="q" placeholder="Enter Your Search" maxlength="100" required value="<?php echo sanitize_output($search_query); ?>">
                                            <button type="submit"><i class="fa fa-search"></i></button>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="theme-inner-banner section-spacing">
            <div class="overlay">
                <div class="container">
                    <h2>Search Results</h2>
                </div>
            </div>
        </div>

        <div class="search-results section-spacing">
            <div class="container">
                <?php if (!empty($search_query)): ?>
                    <h3>Search results for: "<?php echo sanitize_output($search_query); ?>"</h3>
                    
                    <?php if (!empty($search_results)): ?>
                        <div class="results-list">
                            <?php foreach ($search_results as $result): ?>
                                <div class="result-item">
                                    <h4><a href="<?php echo sanitize_output($result['url']); ?>"><?php echo sanitize_output($result['title']); ?></a></h4>
                                    <p><?php echo sanitize_output($result['description']); ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p>No results found for your search query. Please try different keywords.</p>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="search-form">
                        <h3>Search our website</h3>
                        <form action="search.php" method="GET">
                            <div class="form-group">
                                <input type="text" name="q" placeholder="Enter your search terms..." maxlength="100" required class="form-control">
                                <button type="submit" class="theme-button-one">Search</button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <footer class="theme-footer-one">
            <div class="top-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-sm-6 about-widget">
                            <h6 class="title">About OUR Consulting</h6>
                            <p>That started from this tropic port aboard this tiny ship today still want by theam government they survive on up to thetre east side to a deluxe as soldiers of artics fortune.</p>
                            <div class="queries"><i class="flaticon-phone-call"></i> Any Queries : <a href="tel:+1234567900">(+1) 234 567 900</a></div>
                        </div>
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
                        </div>
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
                        </div>
                        <div class="col-xl-3 col-lg-2 col-sm-6 footer-newsletter">
                            <h6 class="title">NEWSLETTER</h6>
                            <form action="newsletter.php" method="POST">
                                <input type="hidden" name="csrf_token" value="<?php echo sanitize_output(generate_csrf_token()); ?>">
                                <input type="text" name="name" placeholder="Name *" maxlength="50" required>
                                <input type="email" name="email" placeholder="Email *" maxlength="100" required>
                                <button type="submit" class="theme-button-one">SUBSCRIBE</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
            </div>
        </footer>

        <button class="scroll-top tran3s">
            <i class="fa fa-angle-up" aria-hidden="true"></i>
        </button>

        <script src="vendor/jquery.2.2.3.min.js"></script>
        <script src
