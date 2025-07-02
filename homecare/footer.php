<?php
require_once 'config.php';

// Valores seguros
$telefono = escape_html('(+502) 5686-7560');
$wa_url = validate_url('https://wa.me/50256867313');
$post_1_title = escape_html("Till wanted by theam govern they survive as soldiers.");
$post_2_title = escape_html("World don't move to beat of just one drum.");
?>
<footer class="theme-footer-one">
    <div class="top-footer">
        <div class="container">
            <div class="row">
                <!-- Políticas -->
                <div class="col-xl-3 col-lg-4 col-sm-6 about-widget">
                    <h6 class="title">Políticas</h6>
                    <ul style="color: white;">
                        <li>Política de Calidad</li>
                        <li>Declaración de sostenibilidad</li>
                        <li>Política de Salud y Seguridad Ocupacional</li>
                        <li>Declaración Sostenibilidad Política Ambiental ISO 14001 2024</li>
                    </ul>
                    <div class="queries">
                        <i class="flaticon-phone-call"></i> Teléfono : 
                        <a href="<?php echo $wa_url; ?>"><?php echo $telefono; ?></a>
                    </div>
                </div>

                <!-- Recent Posts -->
                <div class="col-xl-4 col-lg-3 col-sm-6 footer-recent-post">
                    <h6 class="title">RECENT POSTS</h6>
                    <ul>
                        <li class="clearfix">
                            <img src="images/blog/1.jpg" alt="Blog post" class="float-left">
                            <div class="post float-left">
                                <a href="blog-details.php"><?php echo $post_1_title; ?></a>
                                <div class="date">
                                    <i class="fa fa-calendar-o" aria-hidden="true"></i> Feb 06, 2018
                                </div>
                            </div>
                        </li>
                        <li class="clearfix">
                            <img src="images/blog/2.jpg" alt="Blog post" class="float-left">
                            <div class="post float-left">
                                <a href="blog-details.php"><?php echo $post_2_title; ?></a>
                                <div class="date">
                                    <i class="fa fa-calendar-o" aria-hidden="true"></i> Mar 20, 2018
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Servicios -->
                <div class="col-xl-2 col-lg-3 col-sm-6 footer-list">
                    <h6 class="title">Servicios</h6>
                    <ul>
                        <li><a href="service.php">Cuidadora de Salud</a></li>
                        <li><a href="service.php">Auxiliar de Enfermería</a></li>
                        <li><a href="service.php">Enfermera Profesional</a></li>
                    </ul>
                </div>
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </div> <!-- /.top-footer -->

    <div class="bottom-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-12">
                    <p>&copy; Copyright <?php echo date('Y'); ?>. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div> <!-- /.bottom-footer -->
</footer>
