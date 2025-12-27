<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="nl"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="nl"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="nl"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="nl"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php wp_title(); ?> <?php bloginfo( 'name' ); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<link rel="apple-touch-icon" href="apple-touch-icon.png">-->

    <!--<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Roboto:700" rel="stylesheet">-->
    <!-- connect to domain of font files -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- optionally increase loading priority -->
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Roboto:700&display=swap">

    <!-- async CSS -->
    <link rel="stylesheet" media="print" onload="this.onload=null;this.removeAttribute('media');" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Roboto:700&display=swap">

    <!-- no-JS fallback -->
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Roboto:700&display=swap">
    </noscript>

    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/bootstrap-theme.min.css">
    <?php if(!is_front_page()) { ?>
        <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/lightbox.min.css">
        <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/jquery.fancybox.min.css">
        <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/jquery.mcustomscrollbar.min.css">
    <?php } ?>

    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/libs/slick/slick.css">
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/libs/slick/slick-theme.css">
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/main.css?v=10">

    <!--<script src="<?php bloginfo('template_directory'); ?>/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>-->
    <?php wp_head(); ?>


    <?php if (get_page_template_slug() == 'keyplan.php'){ ?>
        <!-- Add Smartlook for keyplan page -->
        <script type="text/javascript">
            window.smartlook||(function(d) {
                var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];
                var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
                c.charset='utf-8';c.src='https://rec.smartlook.com/recorder.js';h.appendChild(c);
            })(document);
            smartlook('init', 'c8e79885924dc8fce18b299c7bafcec1c73cb58e');
        </script>
    <?php } ?>
    <?php /*<!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '2702534816727902');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=2702534816727902&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Facebcontainer-fluid main-top-itemsook Pixel Code -->*/ ?>
</head>
<body <?php body_class((isset($class) ? $class : '')); ?>>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<?php
$excl_btw = isset($_COOKIE["excl_btw"]) && $_COOKIE["excl_btw"] ? true : false;

//get theme options
$options = get_option( 'theme_settings' ); ?>
<div class="inner-div">

    <div class="container-fluid header-section">
        <div class="container">
            <header>
                <div class="row">
                    <div class="col-md-6 col-sm-5 col-xs-12 left-side hidden-xs">
                        <div class="phone">
                            <div class="phone-icon"></div>
                            <div class="phone-text">
                                <span class="phone-number"><?php echo $options['phone']; ?></span><br/>
                                Direct hulp!
                            </div>
                        </div>
                        <div class="email">
                            <div class="email-icon"></div>
                            <div class="email-text">
                                <a href="mailto:info@mc-cilinder.nl" class="email-number">info@mc-cilinder.nl</a><br/>
                                Voor meer informatie.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-7 col-xs-12 text-right">
                        <div class="price text-left">
                            <div class="price-icon"></div>
                            <div class="price-text">
                                <span class="price-number">Prijsweergave</span><br/>
                                <div class="btw-wrapper">
                                    <span id="enable-btw" class="btw<?php if(!$excl_btw) { ?> active<?php } ?>">Incl. BTW</span><span id="disable-btw" class="btw<?php if($excl_btw) { ?> active<?php } ?>">Excl. BTW</span>
                                </div>
                            </div>
                        </div>

                        <div class="cart text-left"<?php if ( WC()->cart->get_cart_contents_count() != 0 ) {?> style="cursor: pointer;" onclick="location.href='/cart/';"<?php } ?>>
                            <div class="cart-icon"></div>
                            <?php
                            if(isset($_GET["empty_cart"]))
                            {
                                WC()->cart->empty_cart();
                            }
                            ?>
                            <div class="cart-text">
                                <div class="cart-title">Winkelwagen</div>
                                <div class="cart-info"><?php echo WC()->cart->get_cart_contents_count();?> artikelen - <?php echo ($excl_btw ? WC()->cart->get_total_ex_tax() : WC()->cart->get_total()); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        </div>
    </div>

    <div class="container-fluid">
        <div class="container header-middle-section">
            <div class="row">
                <div class="col-lg-4 col-sm-3 col-xs-12 logo-wrapper">
                    <a class="logo-link" href="<?php echo home_url(); ?>"><img src="<?php header_image(); ?>" alt="logo" title="<?php echo @$options["logo_title"]; ?>" /></a>
                </div>
                <div class="col-lg-8 col-sm-9 col-xs-12 text-right kiyoh-wrapper">
                    <div class="kiyoh">
                        <!--<iframe loading="lazy" frameborder="0"  scrolling="no" allowtransparency="true" src="https://www.kiyoh.com/retrieve-widget.html?color=white&button=true&lang=nl&tenantId=98&locationId=1045436" width="210" height="175"></iframe>-->
                        <a href="https://www.kiyoh.com/reviews/1045436/mr-beveiliging_nl?from=widget&lang=nl" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/img/kiyoh_static.png" width="210" height="75" alt="kiyoh" /></a>
                    </div>
                    <div class="service-review hidden-xs">
                        Fantastische service, snelle levering en goede kwaliteit tegen een scherpe prijs. Echt een aanrader!
                    </div>
                    <div class="service-review service-mobile visible-xs">
                        <span class="tick-icon">✓</span> Voor <strong>16:59</strong> uur besteld, morgen <strong>gratis</strong> in huis
                    </div>
                    <a href="http://www.keurmerk.info/Leden-en-Partners/Lid-Details/8857?s=1" class="keurmerk hidden-sm hidden-xs" target="_blank"></a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid logo-menu">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <nav class="main-menu navbar navbar-default" role="navigation">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <a class="home" href="<?php echo home_url(); ?>"></a>
                        <div id="navbar" class="navbar-collapse collapse">
                            <?php wp_nav_menu( array('theme_location' => 'main_menu', 'menu' => 'Top Bar', 'menu_class' => 'nav navbar-nav', 'depth'=> 2, 'container'=> false)); ?>
                        </div>
                    </nav>
                </div>
                <div class="col-md-4 col-sm-3 search-wrapper">
                    <?php get_search_form(); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="main">
