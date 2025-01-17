<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="<?php echo $this->selected_lang->short_form ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo xss_clean($title); ?> - <?php echo xss_clean($this->settings->site_title); ?></title>
    <meta name="description" content="<?php echo xss_clean($description); ?>"/>
    <meta name="keywords" content="<?php echo xss_clean($keywords); ?>"/>
    <meta name="author" content="Codingest"/>
    <link rel="shortcut icon" type="image/png" href="<?php echo get_favicon($this->general_settings); ?>"/>
    <meta property="og:locale" content="en-US"/>
    <meta property="og:site_name" content="<?php echo xss_clean($this->general_settings->application_name); ?>"/>
<?php if (isset($show_og_tags)): ?>
    <meta property="og:type" content="<?php echo $og_type; ?>"/>
    <meta property="og:title" content="<?php echo $og_title; ?>"/>
    <meta property="og:description" content="<?php echo $og_description; ?>"/>
    <meta property="og:url" content="<?php echo $og_url; ?>"/>
    <meta property="og:image" content="<?php echo $og_image; ?>"/>
    <meta property="og:image:width" content="<?php echo $og_width; ?>"/>
    <meta property="og:image:height" content="<?php echo $og_height; ?>"/>
    <meta property="article:author" content="<?php echo $og_author; ?>"/>
    <meta property="fb:app_id" content="<?php echo $this->general_settings->facebook_app_id; ?>"/>
<?php if (!empty($og_tags)):foreach ($og_tags as $tag): ?>
    <meta property="article:tag" content="<?php echo $tag->tag; ?>"/>
<?php endforeach; endif; ?>
    <meta property="article:published_time" content="<?php echo $og_published_time; ?>"/>
    <meta property="article:modified_time" content="<?php echo $og_modified_time; ?>"/>
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:site" content="@<?php echo xss_clean($this->general_settings->application_name); ?>"/>
    <meta name="twitter:creator" content="@<?php echo xss_clean($og_creator); ?>"/>
    <meta name="twitter:title" content="<?php echo xss_clean($og_title); ?>"/>
    <meta name="twitter:description" content="<?php echo xss_clean($og_description); ?>"/>
    <meta name="twitter:image" content="<?php echo $og_image; ?>"/>
<?php else: ?>
    <meta property="og:image" content="<?php echo get_logo($this->general_settings); ?>"/>
    <meta property="og:image:width" content="160"/>
    <meta property="og:image:height" content="60"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="<?php echo xss_clean($title); ?> - <?php echo xss_clean($this->settings->site_title); ?>"/>
    <meta property="og:description" content="<?php echo xss_clean($description); ?>"/>
    <meta property="og:url" content="<?php echo base_url(); ?>"/>
    <meta property="fb:app_id" content="<?php echo $this->general_settings->facebook_app_id; ?>"/>
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:site" content="@<?php echo xss_clean($this->general_settings->application_name); ?>"/>
    <meta name="twitter:title" content="<?php echo xss_clean($title); ?> - <?php echo xss_clean($this->settings->site_title); ?>"/>
    <meta name="twitter:description" content="<?php echo xss_clean($description); ?>"/>
<?php endif; ?>
    <link rel="canonical" href="<?php echo current_url(); ?>"/>
<?php if ($this->general_settings->multilingual_system == 1):
foreach ($this->languages as $language):
if ($language->id == $this->site_lang->id):?>
    <link rel="alternate" href="<?php echo base_url(); ?>" hreflang="<?php echo $language->language_code ?>"/>
<?php else: ?>
    <link rel="alternate" href="<?php echo base_url() . $language->short_form . "/"; ?>" hreflang="<?php echo $language->language_code ?>"/>
<?php endif; endforeach; endif; ?>
    <!-- Icons -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/font-icons/css/font-icon.min.css"/>
    <?php echo !empty($this->fonts->font_url) ? $this->fonts->font_url : ''; ?>
    <!-- Bootstrap CSS -->
	<?php if($this->selected_lang->short_form == 'ar') { ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap-rtl.min.css"/>
	<?php } else { ?>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css"/>
    <?php } ?>
	<!-- Style CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style-1.6.2.min.css"/>
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/plugins-1.6.css"/>
<?php if (!empty($this->general_settings->site_color)): ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/colors/<?php echo $this->general_settings->site_color; ?>.min.css"/>
<?php else: ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/colors/default.min.css"/>
<?php endif; ?>
    <style>body {<?php echo $this->fonts->font_family; ?>} .product-item-options .item-option .icon-heart {color: #f15e4f !important;}  .btn-wishlist .icon-heart {color: #f15e4f !important;}
    #footer,#header,.nav-breadcrumb,.product-details-container,.product-description {display: none;}
    </style>
    <?php echo $this->general_settings->custom_css_codes; ?>
<script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NQ4DBVP');</script>
<!-- End Google Tag Manager -->
    
	<!-- Facebook Pixel Code -->
	<script>
	!function(f,b,e,v,n,t,s)
	{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	n.callMethod.apply(n,arguments):n.queue.push(arguments)};
	if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
	n.queue=[];t=b.createElement(e);t.async=!0;
	t.src=v;s=b.getElementsByTagName(e)[0];
	s.parentNode.insertBefore(t,s)}(window, document,'script',
	'https://connect.facebook.net/en_US/fbevents.js');
	fbq('init', '1995880600546492');

	fbq('track', 'PageView');
	
	<?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        if( isset($product) ) {
            $slug = $product->slug;
        } else {
            $slug = 'not found';
        }
        // echo $slug; die;
        if(strpos($actual_link, "register") !== false){
			echo "fbq('track', 'CompleteRegistration');";
		}
        elseif(strpos($actual_link, $slug) !== false && strpos($actual_link, '#add_to_cart') == false){
			echo "fbq('track', 'ViewContent');";
		}
        elseif(strpos($actual_link, "shipping") !== false){
            echo "fbq('track', 'ViewContent');";
			echo "fbq('track', 'AddToCart');";
		}
		elseif(strpos($actual_link, "cart") !== false){
            echo "fbq('track', 'ViewContent');";
			echo "fbq('track', 'AddToCart');";
		}
		elseif(strpos($actual_link, "order-completed") !== false){
            echo "fbq('track', 'ViewContent');";
			echo "fbq('track', 'AddToCart');";
			// echo "fbq('track', 'Purchase');";
		}


		// if(strpos($actual_link, "cart") !== false){
		// 	echo "fbq('track', 'AddToCart');";
		// }
		// /*if(strpos($actual_link, "order-completed") !== false){
		// 	echo "fbq('track', 'Purchase');";
		// }*/
		// if(strpos($actual_link, "register") !== false){
		// 	echo "fbq('track', 'CompleteRegistration');";
		// }
		// if(strpos($actual_link, "promotions") !== false){
		// 	echo "fbq('track', 'ViewContent');";
		// }
	?>
	</script>
	<noscript><img height="1" width="1" style="display:none"
	src="https://www.facebook.com/tr?id=1995880600546492&ev=PageView&noscript=1"
	/></noscript>
	<!-- End Facebook Pixel Code -->
	<!-- Snap Pixel Code -->
	<script type='text/javascript'>
	(function(e,t,n){if(e.snaptr)return;var a=e.snaptr=function()
	{a.handleRequest?a.handleRequest.apply(a,arguments):a.queue.push(arguments)};
	a.queue=[];var s='script';r=t.createElement(s);r.async=!0;
	r.src=n;var u=t.getElementsByTagName(s)[0];
	u.parentNode.insertBefore(r,u);})(window,document,
	'https://sc-static.net/scevent.min.js');

	snaptr('init', 'a462e26a-3918-4a1d-9437-4b1f0bdade99', {
	'user_email': 'planetofthegoods@gmail.com'
	});

	snaptr('track', 'PAGE_VIEW');
	<?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        if(strpos($actual_link, "register") !== false){
            echo "snaptr('track','SIGN_UP');";
        }
        elseif(strpos($actual_link, $slug) !== false){
            echo "snaptr('track', 'VIEW_CONTENT');";
        }
        elseif(strpos($actual_link, "shipping") !== false){
            echo "snaptr('track', 'VIEW_CONTENT');";
            echo "snaptr('track', 'ADD_CART');";
        }
        elseif(strpos($actual_link, "cart") !== false){
            echo "snaptr('track', 'VIEW_CONTENT');";
            echo "snaptr('track','ADD_CART');";
        }
        elseif(strpos($actual_link, "order-completed") !== false){
            echo "snaptr('track', 'VIEW_CONTENT');";
            echo "snaptr('track', 'ADD_CART');";
            echo "snaptr('track','PURCHASE');";
        }

		// if(strpos($actual_link, "cart") !== false){
		// 	echo "snaptr('track','ADD_CART');";
		// }
		// if(strpos($actual_link, "order-completed") !== false){
		// 	echo "snaptr('track','PURCHASE');";
		// }
		// if(strpos($actual_link, "register") !== false){
		// 	echo "snaptr('track','SIGN_UP');";
		// }
		// if(strpos($actual_link, "promotions") !== false){
		// 	echo "snaptr('track','VIEW_CONTENT');";
		// }
	?>
	</script>
	<script>
!function (w, d, t) {
  w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=i,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};var o=document.createElement("script");o.type="text/javascript",o.async=!0,o.src=i+"?sdkid="+e+"&lib="+t;var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(o,a)};


  ttq.load('BVCVPE4OL5LLUC37OK0G');
  ttq.page();
}(window, document, 'ttq');
</script>
<script language="JavaScript" src="http://www.geoplugin.net/javascript.gp" type="text/javascript"></script>
	<!-- End Snap Pixel Code -->
    <?php echo $this->general_settings->google_adsense_code; ?>
</head>
<body>
    
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NQ4DBVP"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<header id="header">
    <?php $this->load->view("partials/_top_bar"); ?>
    <div class="main-menu">
        <div class="container-fluid">
            <div class="row">
                <div class="nav-top">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-8 nav-top-left">
                                <div class="row-align-items-center">
                                    <div class="logo">
                                        <a href="<?php echo lang_base_url(); ?>"><img src="<?php echo get_logo($this->general_settings); ?>" alt="logo"></a>
                                    </div>

                                    <div class="top-search-bar">
                                        <?php echo form_open(generate_url('search'), ['id' => 'form_validate_search', 'class' => 'form_search_main', 'method' => 'get']); ?>
                                        <?php if ($this->general_settings->multi_vendor_system == 1): ?>
                                            <div class="left">
                                                <div class="dropdown search-select">
                                                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                        <?php if (isset($search_type)): ?>
                                                            <?php echo trans("member"); ?>
                                                        <?php else: ?>
                                                            <?php echo trans("product"); ?>
                                                        <?php endif; ?>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" data-value="product" href="javascript:void(0)"><?php echo trans("product"); ?></a>
                                                        <a class="dropdown-item" data-value="member" href="javascript:void(0)"><?php echo trans("member"); ?></a>
                                                    </div>
                                                </div>
                                                <?php if (isset($search_type)): ?>
                                                    <input type="hidden" class="search_type_input" name="search_type" value="member">
                                                <?php else: ?>
                                                    <input type="hidden" class="search_type_input" name="search_type" value="product">
                                                <?php endif; ?>
                                            </div>
                                            <div class="right">
                                                <input type="text" name="search" maxlength="300" pattern=".*\S+.*" id="input_search" class="form-control input-search" value="<?php echo (!empty($filter_search)) ? $filter_search : ''; ?>" placeholder="<?php echo trans("search_exp"); ?>" required autocomplete="off">
                                                <button class="btn btn-default btn-search"><i class="icon-search"></i></button>
                                                <div id="response_search_results" class="search-results-ajax"></div>
                                            </div>
                                        <?php else: ?>
                                            <input type="text" name="search" maxlength="300" pattern=".*\S+.*" id="input_search" class="form-control input-search" value="<?php echo (!empty($filter_search)) ? $filter_search : ''; ?>" placeholder="<?php echo trans("search_products"); ?>" required autocomplete="off">
                                            <input type="hidden" class="search_type_input" name="search_type" value="product">
                                            <button class="btn btn-default btn-search"><i class="icon-search"></i></button>
                                            <div id="response_search_results" class="search-results-ajax"></div>
                                        <?php endif; ?>
                                        <?php echo form_close(); ?>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4 nav-top-right">
                                <ul class="nav align-items-center">
                                    <?php if (is_sale_active()): ?>
                                        <li class="nav-item nav-item-cart li-main-nav-right">
                                            <a href="<?php echo generate_url("cart"); ?>">
                                                <i class="icon-cart"></i><span><?php echo trans("cart"); ?></span>
                                                <?php $cart_product_count = get_cart_product_count();
                                                if ($cart_product_count > 0): ?>
                                                    <span class="notification"><?php echo $cart_product_count; ?></span>
                                                <?php endif; ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php if ($this->auth_check): ?>
                                        <li class="nav-item li-main-nav-right">
                                            <a href="<?php echo generate_url("wishlist") . "/" . $this->auth_user->slug; ?>">
                                                <i class="icon-heart-o"></i><?php echo trans("wishlist"); ?>
                                            </a>
                                        </li>
                                    <?php else: ?>
                                        <li class="nav-item li-main-nav-right">
                                            <a href="<?php echo generate_url("wishlist"); ?>">
                                                <i class="icon-heart-o"></i><?php echo trans("wishlist"); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <!--Check auth-->
                                    <?php if ($this->auth_check): ?>
                                        <?php if (is_multi_vendor_active()): ?>
                                            <li class="nav-item m-r-0"><a href="<?php echo generate_url("sell_now"); ?>" class="btn btn-md btn-custom btn-sell-now m-r-0"><?php echo trans("sell_now"); ?></a></li>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php if (is_multi_vendor_active()): ?>
                                            <li class="nav-item m-r-0"><a href="javascript:void(0)" class="btn btn-md btn-custom btn-sell-now m-r-0" data-toggle="modal" data-target="#loginModal"><?php echo trans("sell_now"); ?></a></li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="nav-main">
                    <!--main navigation-->
                    <?php $this->load->view("partials/_main_nav"); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile-nav-container">
        <div class="nav-mobile-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="nav-mobile-header-container">
                        <div class="menu-icon">
                            <a href="javascript:void(0)" class="btn-open-mobile-nav"><i class="icon-menu"></i></a>
                        </div>
                        <div class="mobile-logo">
                            <a href="<?php echo lang_base_url(); ?>"><img src="<?php echo get_logo($this->general_settings); ?>" alt="logo" class="logo"></a>
                        </div>
                        <?php if (is_sale_active()): ?>
                            <div class="mobile-cart">
                                <a href="<?php echo generate_url("cart"); ?>"><i class="icon-cart"></i>
                                    <?php $cart_product_count = get_cart_product_count(); ?>
                                    <span class="notification"><?php echo $cart_product_count; ?></span>
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="mobile-search">
                            <a class="search-icon"><i class="icon-search"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="top-search-bar mobile-search-form">
                        <?php echo form_open(generate_url('search'), ['id' => 'form_validate_search_mobile', 'method' => 'get']); ?>
                        <?php if ($this->general_settings->multi_vendor_system == 1): ?>
                            <div class="left">
                                <div class="dropdown search-select">
                                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                        <?php if (isset($search_type)): ?>
                                            <?php echo trans("member"); ?>
                                        <?php else: ?>
                                            <?php echo trans("product"); ?>
                                        <?php endif; ?>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" data-value="product" href="javascript:void(0)"><?php echo trans("product"); ?></a>
                                        <a class="dropdown-item" data-value="member" href="javascript:void(0)"><?php echo trans("member"); ?></a>
                                    </div>
                                </div>
                                <?php if (isset($search_type)): ?>
                                    <input type="hidden" class="search_type_input" name="search_type" value="member">
                                <?php else: ?>
                                    <input type="hidden" class="search_type_input" name="search_type" value="product">
                                <?php endif; ?>
                            </div>
                            <div class="right">
                                <input type="text" name="search" maxlength="300" pattern=".*\S+.*" class="form-control input-search" value="<?php echo (!empty($filter_search)) ? $filter_search : ''; ?>" placeholder="<?php echo trans("search"); ?>" required>
                                <button class="btn btn-default btn-search"><i class="icon-search"></i></button>
                            </div>
                        <?php else: ?>
                            <input type="text" name="search" maxlength="300" pattern=".*\S+.*" id="input_search" class="form-control input-search" value="<?php echo (!empty($filter_search)) ? $filter_search : ''; ?>" placeholder="<?php echo trans("search_products"); ?>" required autocomplete="off">
                            <button class="btn btn-default btn-search btn-search-single-vendor-mobile"><i class="icon-search"></i></button>
                        <?php endif; ?>

                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div id="overlay_bg" class="overlay-bg"></div>
<!--include mobile menu-->
<?php $this->load->view("partials/_mobile_nav"); ?>

<?php if (!$this->auth_check): ?>
    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered login-modal" role="document">
            <div class="modal-content">
                <div class="auth-box">
                    <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                    <h4 class="title"><?php echo trans("login"); ?></h4>
                    <!-- form start -->
                    <form id="form_login" novalidate="novalidate">
                        <div class="social-login-cnt">
                            <?php $this->load->view("partials/_social_login", ["or_text" => trans("login_with_email")]); ?>
                        </div>
                        <!-- include message block -->
                        <div id="result-login" class="font-size-13"></div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control auth-form-input" placeholder="<?php echo trans("email_address"); ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control auth-form-input" placeholder="<?php echo trans("password"); ?>" minlength="4" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-md btn-custom btn-block"><?php echo trans("login"); ?></button>
                        </div>

                    </form>
                    <!-- form end -->
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="modal fade" id="locationModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered login-modal" role="document">
        <div class="modal-content">
            <div class="auth-box">
                <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                <h4 class="title"><?php echo trans("select_location"); ?></h4>
                <!-- form start -->
                <?php echo form_open('set-default-location-post','id="country-selector"'); ?>
                <p class="location-modal-description"><?php echo trans("location_exp"); ?></p>
                <div class="selectdiv select-location">
                    <select name="location_id" id="dropdown_location" class="form-control"></select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-md btn-custom btn-block"><?php echo trans("update_location"); ?></button>
                </div>
                <?php echo form_close(); ?>
                <!-- form end -->
            </div>
        </div>
    </div>
</div>

<div id="menu-overlay"></div>