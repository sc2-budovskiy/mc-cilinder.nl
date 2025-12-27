</div>

<footer>
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="menu-col-title">Over ons</div>
                    <?php
                    if(is_active_sidebar('footer-sidebar-1')){
                        dynamic_sidebar('footer-sidebar-1');
                    }
                    ?>
                    <?php echo do_shortcode('[gtranslate]'); ?>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="menu-col-title">Contact informatie</div>
                    <?php
                    //get theme options
                    $options = get_option( 'theme_settings' ); ?>
                    <p><strong>Bezoek adres</strong><br/>
                        (Alleen op afspraak):<br/>
                        <?php echo $options['address']; ?></p>
                    <p><strong>Telefoon:</strong><br/>
                        <?php echo $options['phone']; ?>
                        <?php if($options['whatsapp_icon'] && $options['phone']) { ?>
                            <?php $phoneNumber = preg_replace('/\D/', '', $options['phone']); ?>
                            <br/>
                            <a class="whatsapp-link" href="https://api.whatsapp.com/send/?phone=<?php echo $phoneNumber; ?>"><i class="whatsapp-icon"></i> <span class="whatsapp-text"><?php echo $options['whatsapp_text']; ?></span></a>
                        <?php } ?>
                    </p>
                    <p><strong>E-mailadres:</strong><br/>
                        <?php echo $options['email']; ?></p>
                    <p><strong>Openingstijden:</strong><br/>
                        <?php echo $options['opening_hours']; ?></p>
                </div>
                <div class="visible-sm visible-xs clearfix"></div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="menu-col-title"><?php echo get_cat_name( 34 ); ?></div>
                    <ul class="menu-col-refs">
                        <?php
                        $links = get_posts( array('numberposts' => 20, 'category' => 34) );
                        foreach($links as $post)
                        {
                            ?>
                            <li><a href="<?=get_permalink($post)?>"><?=$post->post_title?></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="menu-col-title"><?php echo get_cat_name( 35 ); ?></div>
                    <ul class="menu-col-refs">
                        <?php
                        $links = get_posts( array('numberposts' => 20, 'category' => 35) );
                        foreach($links as $post)
                        {
                            ?>
                            <li><a href="<?=get_permalink($post)?>"><?=$post->post_title?></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="footer-top-social">
                <span><strong>Helemaal niets missen?</strong> Volg ons via</span>
                <div class="social-icons">
                    <a class="si-linkedin" href="#"></a>
                    <a class="si-tw" href="#"></a>
                    <a class="si-fb" href="#"></a>
                    <a class="si-youtube" href="#"></a>
                    <a class="si-vimeo" href="#"></a>
                    <a class="si-instagram" href="#"></a>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-middle">
        <div class="container">
            <div class="row payment-list">
                <div class="col-md-9ths">
                    <div class="img-wrapper">
                        <img src="<?php bloginfo('template_directory'); ?>/img/payment/webshop.png" alt="webshop" title="" />
                    </div>
                </div>
                <div class="col-md-9ths">
                    <div class="img-wrapper">
                        <img src="<?php bloginfo('template_directory'); ?>/img/payment/klarna.png" alt="klarna" title="" />
                    </div>
                </div>
                <div class="col-md-9ths">
                    <div class="img-wrapper">
                        <img src="<?php bloginfo('template_directory'); ?>/img/payment/sofort.png" alt="sofort" title="" />
                    </div>
                </div>
                <div class="col-md-9ths">
                    <div class="img-wrapper">
                        <img src="<?php bloginfo('template_directory'); ?>/img/payment/bancontact.png" alt="bancontact" title="" />
                    </div>
                </div>
                <div class="col-md-9ths">
                    <div class="img-wrapper">
                        <img src="<?php bloginfo('template_directory'); ?>/img/payment/postnl.png" alt="postnl" title="" />
                    </div>
                </div>
                <div class="col-md-9ths">
                    <div class="img-wrapper">
                        <img src="<?php bloginfo('template_directory'); ?>/img/payment/ideal.png" alt="ideal" title="" />
                    </div>
                </div>
                <div class="col-md-9ths">
                    <div class="img-wrapper">
                        <img src="<?php bloginfo('template_directory'); ?>/img/payment/Paypal.png" alt="PayPal" title="" />
                    </div>
                </div>
                <div class="col-md-9ths">
                    <div class="img-wrapper">
                        <img src="<?php bloginfo('template_directory'); ?>/img/payment/mastercard.png" alt="MasterCard" title="" />
                    </div>
                </div>
                <div class="col-md-9ths">
                    <div class="img-wrapper">
                        <img src="<?php bloginfo('template_directory'); ?>/img/payment/PIN-LOGO.png" alt="PIN-LOGO" title="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            Copyright © 2017-<?=date("Y");?> - MC-Cilinder - Ontwikkeld door: MR-Beveiliging
        </div>
    </div>
</footer>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<script>window.jQuery || document.write('<script src="<?php bloginfo('template_directory'); ?>/js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

<?php if(!is_front_page()) { ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<?php } ?>
<script src="<?php bloginfo('template_directory'); ?>/js/vendor/bootstrap.min.js"></script>

<?php if(!is_front_page()) { ?>
    <script src="<?php bloginfo('template_directory'); ?>/js/lightbox.min.js"></script>
    <script src="<?php bloginfo('template_directory'); ?>/js/jquery.fancybox.min.js"></script>
    <script src="<?php bloginfo('template_directory'); ?>/js/jquery.mcustomscrollbar.concat.min.js"></script>
<?php } ?>
<script src="<?php bloginfo('template_directory'); ?>/libs/slick/slick.min.js"></script>

<script src="<?php bloginfo('template_directory'); ?>/js/main.js?v=21"></script>

<?php wp_footer(); ?>
<!--Это закрытие innerDiv-->
</div>

</body>
</html>
