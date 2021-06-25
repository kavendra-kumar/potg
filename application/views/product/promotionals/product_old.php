<?php defined('BASEPATH') or exit('No direct script access allowed'); $info = $product->info; if(!$this->auth_check){
	?>
<script>
	$( document ).ready(function() {
		if(localStorage.getItem('setNewsletter') != '1'){
			setTimeout(function() {
				$("#newsletterModal").modal('show');
			}, 13000);
		}
		$( "#btn-newsletter" ).click(function() {
			setNewsletter();
		});
	});
	function setNewsletter(){
		localStorage.setItem('setNewsletter', 1);
	}
</script>
<?php 
} ?>

<!-- Wrapper -->
<div id="wrapper d-none">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-products">
                        <li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
                        <?php if (!empty($category)):
                            $breadcrumb = get_parent_categories_array($category->id);
                            if (!empty($breadcrumb)):
                                foreach ($breadcrumb as $item_breadcrumb):
                                    $item_category = get_category_by_id($item_breadcrumb->id);
                                    if (!empty($item_category)):?>
                                        <li class="breadcrumb-item"><a href="<?php echo generate_category_url($item_category); ?>"><?php echo category_name($item_category); ?></a>
                                        </li>
                                    <?php endif;
                                endforeach;
                            endif;
                        endif; ?>
                    </ol>
                </nav>
            </div>

            <div class="col-12">
                <div class="product-details-container <?php echo ((!empty($video) || !empty($audio)) && item_count($product_images) < 2) ? "product-details-container-digital" : ""; ?>">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6">
                            <div id="product_slider_container">
                                <?php $this->load->view("product/details/_preview"); ?>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <div id="response_product_details" class="product-content-details">
                                <?php $this->load->view("product/details/_product_details"); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="product-description">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tab_description" data-toggle="tab" href="#tab_description_content" role="tab" aria-controls="tab_description" aria-selected="true"><?php echo trans("description"); ?></a>
                                </li>
                                <?php if (!empty($custom_fields)): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tab_additional_information" data-toggle="tab" href="#tab_additional_information_content" role="tab" aria-controls="tab_additional_information" aria-selected="false"><?php echo trans("additional_information"); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if ($product->product_type != "digital"): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tab_shipping" data-toggle="tab" href="#tab_shipping_content" role="tab" aria-controls="tab_shipping" aria-selected="false"><?php echo trans("shipping_location"); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if ($this->general_settings->reviews == 1): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tab_reviews" data-toggle="tab" href="#tab_reviews_content" role="tab" aria-controls="tab_reviews" aria-selected="false"><?php echo trans("reviews"); ?>&nbsp;(<?php echo $review_count; ?>)</a>
                                    </li>
                                <?php endif; ?>
                                <?php if ($this->general_settings->product_comments == 1): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tab_comments" data-toggle="tab" href="#tab_comments_content" role="tab" aria-controls="tab_comments" aria-selected="false"><?php echo trans("comments"); ?>&nbsp;(<?php echo $comment_count; ?>)</a>
                                    </li>
                                <?php endif; ?>
                                <?php if ($this->general_settings->facebook_comment_status == 1): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tab_facebook_comments" data-toggle="tab" href="#tab_facebook_comments_content" role="tab" aria-controls="facebook_comments" aria-selected="false"><?php echo trans("facebook_comments"); ?></a>
                                    </li>
                                <?php endif; ?>
                            </ul>


                            <div id="accordion" class="tab-content">
                                <div class="tab-pane fade show active" id="tab_description_content" role="tabpanel">
                                    <div class="card">
                                        <div class="card-header">
                                            <a class="card-link" data-toggle="collapse" href="#collapse_description_content">
                                                <?php echo trans("description"); ?><i class="icon-arrow-down"></i><i class="icon-arrow-up"></i>
                                            </a>
                                        </div>
                                        <div id="collapse_description_content" class="collapse-description-content collapse show" data-parent="#accordion">
                                            <div class="description">
                                                <?php echo $product->description; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if (!empty($custom_fields)): ?>
                                    <div class="tab-pane fade" id="tab_additional_information_content" role="tabpanel">
                                        <div class="card">
                                            <div class="card-header">
                                                <a class="card-link collapsed" data-toggle="collapse" href="#collapse_additional_information_content">
                                                    <?php echo trans("additional_information"); ?><i class="icon-arrow-down"></i><i class="icon-arrow-up"></i>
                                                </a>
                                            </div>
                                            <div id="collapse_additional_information_content" class="collapse-description-content collapse" data-parent="#accordion">
                                                <table class="table table-striped table-product-additional-information">
                                                    <tbody>
                                                    <?php foreach ($custom_fields as $custom_field):
                                                        if (!empty($custom_field->field_value) || !empty($custom_field->field_common_ids)):?>
                                                            <tr>
                                                                <td class="td-left"><?php echo html_escape($custom_field->name); ?></td>
                                                                <td class="td-right"><?php echo get_custom_field_value($custom_field); ?></td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if ($product->product_type != "digital"): ?>
                                    <div class="tab-pane fade" id="tab_shipping_content" role="tabpanel">
                                        <div class="card">
                                            <div class="card-header">
                                                <a class="card-link collapsed" data-toggle="collapse" href="#collapse_shipping_content">
                                                    <?php echo trans("shipping_location"); ?><i class="icon-arrow-down"></i><i class="icon-arrow-up"></i>
                                                </a>
                                            </div>
                                            <div id="collapse_shipping_content" class="collapse-description-content collapse" data-parent="#accordion">
                                                <?php if (!empty($product->shipping_cost_type) && $this->form_settings->shipping == 1): ?>
                                                    <table class="table table-product-shipping">
                                                        <tbody>
                                                        <tr>
                                                            <?php $shipping_cost_type = get_shipping_option_by_key($product->shipping_cost_type, $this->selected_lang->id);
                                                            if (!empty($shipping_cost_type)):
                                                                if ($shipping_cost_type->shipping_cost != 1):?>
                                                                    <td class="td-left"><?php echo trans("shipping_cost"); ?></td>
                                                                    <td class="td-right"><span><?php echo html_escape($shipping_cost_type->option_label); ?></span></td>
                                                                <?php else: ?>
                                                                    <td class="td-left"><?php echo trans("shipping_cost"); ?></td>
                                                                    <td class="td-right"><span><?php echo price_formatted($product->shipping_cost, $product->currency); ?></span></td>
                                                                <?php endif;
                                                            endif; ?>
                                                        </tr>
                                                        <tr>
                                                            <td class="td-left"><?php echo trans("shipping_time"); ?></td>
                                                            <td class="td-right"><span><?php echo trans($product->shipping_time); ?></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="td-left"><?php echo trans("location"); ?></td>
                                                            <td class="td-right"><span><?php echo get_location($product); ?></span></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                <?php endif; ?>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <?php /* if (!empty($product->country_id)): ?>
                                                            <div class="product-location-map">
                                                                <!--load map-->
                                                                <iframe src="https://maps.google.com/maps?width=100%&height=600&hl=en&q=<?php echo get_location($product); ?>&ie=UTF8&t=&z=8&iwloc=B&output=embed&disableDefaultUI=true"
                                                                        frameborder="0" scrolling="no" marginheight="0"
                                                                        marginwidth="0"></iframe>
                                                            </div>
                                                        <?php endif; */?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if ($this->general_settings->reviews == 1): ?>
                                    <div class="tab-pane fade" id="tab_reviews_content" role="tabpanel">
                                        <div class="card">
                                            <div class="card-header">
                                                <a class="card-link collapsed" data-toggle="collapse" href="#collapse_reviews_content">
                                                    <?php echo trans("reviews"); ?><i class="icon-arrow-down"></i><i class="icon-arrow-up"></i>
                                                </a>
                                            </div>
                                            <div id="collapse_reviews_content" class="collapse-description-content collapse" data-parent="#accordion">
                                                <div id="review-result">
                                                    <?php $this->load->view('product/details/_reviews'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if ($this->general_settings->product_comments == 1): ?>
                                    <div class="tab-pane fade" id="tab_comments_content" role="tabpanel">
                                        <div class="card">
                                            <div class="card-header">
                                                <a class="card-link collapsed" data-toggle="collapse" href="#collapse_comments_content">
                                                    <?php echo trans("comments"); ?><i class="icon-arrow-down"></i><i class="icon-arrow-up"></i>
                                                </a>
                                            </div>
                                            <div id="collapse_comments_content" class="collapse-description-content collapse" data-parent="#accordion">
                                                <input type="hidden" value="<?php echo $comment_limit; ?>" id="product_comment_limit">
                                                <div class="comments-container">
                                                    <div class="row">
                                                        <div class="col-12 col-md-6">
                                                            <?php $this->load->view('product/details/_comments'); ?>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <div class="col-comments-inner">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="row-custom row-comment-label">
                                                                            <label class="label-comment"><?php echo trans("add_a_comment"); ?></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <form id="form_add_comment">
                                                                            <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                                                                            <?php if (!$this->auth_check): ?>
                                                                                <div class="form-row">
                                                                                    <div class="form-group col-md-6">
                                                                                        <input type="text" name="name" id="comment_name" class="form-control form-input" placeholder="<?php echo trans("name"); ?>">
                                                                                    </div>
                                                                                    <div class="form-group col-md-6">
                                                                                        <input type="email" name="email" id="comment_email" class="form-control form-input" placeholder="<?php echo trans("email_address"); ?>">
                                                                                    </div>
                                                                                </div>
                                                                            <?php endif; ?>
                                                                            <div class="form-group">
                                                                                <textarea name="comment" id="comment_text" class="form-control form-input form-textarea" placeholder="<?php echo trans("comment"); ?>"></textarea>
                                                                            </div>
                                                                            <?php if (!$this->auth_check):
                                                                                generate_recaptcha();
                                                                            endif; ?>
                                                                            <div class="form-group">
                                                                                <button type="submit" class="btn btn-md btn-custom"><?php echo trans("submit"); ?></button>
                                                                            </div>
                                                                        </form>
                                                                        <div id="message-comment-result" class="message-comment-result"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php /* if ($this->general_settings->facebook_comment_status == 1): ?>
                                    <div class="tab-pane fade" id="tab_facebook_comments_content" role="tabpanel">
                                        <div class="card">
                                            <div class="card-header">
                                                <a class="card-link collapsed" data-toggle="collapse" href="#collapse_facebook_comments_content">
                                                    <?php echo trans("facebook_comments"); ?><i class="icon-arrow-down"></i><i class="icon-arrow-up"></i>
                                                </a>
                                            </div>
                                            <div id="collapse_facebook_comments_content" class="collapse-description-content collapse" data-parent="#accordion">

                                                <div class="fb-comments" data-href="<?php echo current_url(); ?>" data-width="100%" data-numposts="5" data-colorscheme="light"></div>

                                            </div>
                                        </div>
                                    </div>
                                <?php endif; */ ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row-custom row-bn">
                    <!--Include banner-->
                    <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "product", "class" => "m-b-30"]); ?>
                </div>
            </div>
            <?php /* if (!empty($user_products)): ?>
                <div class="col-12 section section-related-products m-t-30">
                    <h3 class="title"><?php echo trans("more_from"); ?>&nbsp;<a href="<?php echo generate_profile_url($product->user_slug); ?>"><?php echo html_escape($product->user_username); ?></a></h3>
                    <div class="row row-product">
                        <!--print related posts-->
                        <?php $count = 0;
                        foreach ($user_products as $item):
                            if ($count < 4):?>
                                <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-product">
                                    <?php $this->load->view('product/_product_item', ['product' => $item]); ?>
                                </div>
                            <?php endif;
                            $count++;
                        endforeach; ?>
                    </div>
                    <?php if (item_count($user_products) > 4): ?>
                        <div class="row-custom text-center">
                            <a href="<?php echo generate_profile_url($product->user_slug); ?>" class="link-see-more"><span><?php echo trans("view_all"); ?>&nbsp;</span><i class="icon-arrow-right"></i></a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; */ ?>

            <?php /* if (!empty($related_products)): ?>
                <div class="col-12 section section-related-products">
                    <h3 class="title"><?php echo trans("you_may_also_like"); ?></h3>
                    <div class="row row-product">
                        <!--print related posts-->
                        <?php
                        $count = 0;
                        foreach ($related_products as $item):
                            if ($count < 4):
                                $item = @(object)$item;
                                if (!empty($item)):?>
                                    <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-product">
                                        <?php $this->load->view('product/_product_item', ['product' => $item]); ?>
                                    </div>
                                <?php endif;
                            endif;
                            $count++;
                        endforeach; ?>
                    </div>
                </div>
            <?php endif; */ ?>

            <div class="col-12">
                <div class="row-custom row-bn">
                    <!--Include banner-->
                    <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "product_bottom", "class" => "m-b-30"]); ?>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Wrapper End-->

<!-- include send message modal -->
<?php $this->load->view("partials/_modal_send_message", ["subject" => $product->title]); ?>

<?php if ($this->general_settings->facebook_comment_status == 1):
    echo $this->general_settings->facebook_comment; ?>
    <script>
        $(".fb-comments").attr("data-href", window.location.href);
    </script>
<?php endif; ?>

<!-- Plyr JS-->
<script src="<?php echo base_url(); ?>assets/vendor/plyr/plyr.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/plyr/plyr.polyfilled.min.js"></script>
<script>
    const player = new Plyr('#player');
    $(document).ajaxStop(function () {
        const player = new Plyr('#player');
    });
    const audio_player = new Plyr('#audio_player');
    $(document).ajaxStop(function () {
        const player = new Plyr('#audio_player');
    });
</script>

<script>
    $(function () {
        $('.product-description iframe').wrap('<div class="embed-responsive embed-responsive-16by9"></div>');
        $('.product-description iframe').addClass('embed-responsive-item');
    });
</script>

<html><head>
<?php if($this->selected_lang->id !=2) { ?>
  <style type="text/css" media="screen">
    body{-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;margin:0;width:100%;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif;font-weight:400;background:url(../<?php echo $info->image_background ?>) repeat-y rgb(36,36,36) 48% 0 / auto;}a{text-decoration:none;color:inherit;cursor:pointer;}a:not(.btn):hover{text-decoration:underline;}input,select,textarea,p,h1,h2,h3,h4,h5,h6{margin:0;font-size:inherit;font-weight:inherit;}main{overflow:hidden;}u > span{text-decoration:inherit;}ol,ul{padding-left:2.5rem;margin:.625rem 0;}p{word-wrap:break-word;}iframe{border:0;}*{box-sizing:border-box;}.item-absolute{position:absolute;}.item-relative{position:relative;}.item-block{display:block;height:100%;width:100%;}.item-cover{z-index:1000001;}.item-breakword{word-wrap:break-word;}.item-content-box{box-sizing:content-box;}.hidden{display:none;}.clearfix{clear:both;}@keyframes slide-down{from{opacity:0;transform:translateY(-50px);}}@keyframes fade-in{from{opacity:0;}}@supports (-webkit-overflow-scrolling:touch){@media (-webkit-min-device-pixel-ratio:2), (min-resolution:192dpi){.image[src$=".svg"]{width:calc(100% + 1px);}}}.headline{font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif;font-weight:700;}.section-fit{max-width:400px;}.section-relative{position:relative;margin:0 auto;}.section-inner{height:100%;}#page-block-l3qivrhmtw{height:175.375rem;max-width:100%;}#page-block-l3qivrhmtw .section-holder-border{border:0;}#page-block-l3qivrhmtw .section-block{background:none;height:175.375rem;}#page-block-l3qivrhmtw .section-holder-overlay{display:none;}#element-290{top:4.125rem;left:0;height:149.3125rem;width:24.9375rem;z-index:3;}.circle{border-radius:50%;}.shape{height:inherit;display:block;}.line-horizontal{height:.625rem;}.line-vertical{height:100%;margin-right:.625rem;}[class*='line-']{box-sizing:content-box;}#element-290 .shape{border:0;background:rgb(251,176,59);}#element-291{top:2.375rem;left:0.125rem;height:21.4669rem;width:24.875rem;z-index:4;}#element-291 .cropped{background:url(../<?php echo $info->s1_product_image ?>) 0 -1.125rem / 25.3125rem 23.875rem;}#element-292{top:33.5625rem;left:2.25rem;height:4.1875rem;width:20.4375rem;z-index:5;color:#37465A;font-size:1.1765rem;line-height:1.425rem;text-align:left;}#element-292 .x_78798708{text-align:left;letter-spacing:0px;line-height:1.4375rem;font-size:1.1765rem;}#element-292 .x_7b2817bf{color:#000000;}#element-292 .contents{color:rgb(55,70,90)!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:400!important;}#element-292 .contents p{letter-spacing:0px!important;}#element-292 strong{font-weight:700;}#element-293{top:24.1875rem;left:2.25rem;height:8.5rem;width:20rem;z-index:6;color:#37465A;font-size:2.8483rem;line-height:2.875rem;text-align:left;font-weight:900;}#element-293 .x_a7dced57{text-align:left;line-height:2.875rem;font-size:2.8483rem;}#element-293 .x_7b2817bf{color:#000000;}#element-293 .contents{color:rgb(55,70,90)!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;}#element-293 .contents p{letter-spacing:-5px!important;}#element-293 strong{font-weight:900;}#element-293.paragraph{font-weight:900;}#element-294{top:69.75rem;left:13.875rem;height:7.7759rem;width:8.25rem;z-index:26;}#element-295{top:90.25rem;left:16.25rem;height:2.5455rem;width:3.5rem;z-index:27;}#element-296{top:79.875rem;left:3.4375rem;height:7.5792rem;width:6.5625rem;z-index:28;}#element-297{top:88.5625rem;left:4.5rem;height:5.8823rem;width:4.4375rem;z-index:29;}#element-299{top:83.625rem;left:16.25rem;height:2.1121rem;width:3.0625rem;z-index:30;}#element-300{top:69.75rem;left:3.4375rem;height:7.5904rem;width:6.5625rem;z-index:31;}#element-301{top:1rem;left:1.8125rem;height:1.875rem;width:5rem;z-index:66;}#element-302{top:59.3125rem;left:2.3125rem;height:3.75rem;width:19.75rem;z-index:67;font-size:3.75rem;}@font-face{font-family:BebasNeue;font-style:normal;font-weight:400;src:url(https:https://v.fastcdn.co/a/font/bebasneue-webfont.eot);src:url(https:https://v.fastcdn.co/a/font/bebasneue-webfont.eot) format("embedded-opentype"),url(https:https://v.fastcdn.co/a/font/bebasneue-webfont.woff2) format("woff2"),url(https:https://v.fastcdn.co/a/font/bebasneue-webfont.woff) format("woff"),url(https:https://v.fastcdn.co/a/font/bebasneue-webfont.ttf) format("truetype");}.timer-column{width:20%;float:left;text-align:center;margin-left:5%;}.timer-column:first-child{width:25%;margin-left:0;}.timer-box{position:relative;font-size:.78em;margin-bottom:.12em;border-radius:5px;font-family:BebasNeue,sans-serif;height:100%;line-height:1.28em;}.timer-box:after,.timer-box:before{content:'';display:block;border-radius:50%;background-color:inherit;position:absolute;left:-.215em;width:.1em;height:.1em;}.timer-box:after{bottom:35%;}.timer-box:before{top:35%;}.timer-box:first-child:before,.timer-box:first-child:after{display:none;}.timer-number-zero{visibility:hidden;}.timer-text-none .timer-box{font-size:.78em;}.timer-text-bottom .timer-labels-top,.timer-text-top .timer-labels-bottom,.timer-text-none .timer-labels{display:none;}.timer-labels{text-transform:uppercase;margin-bottom:.18em;font-size:.13333em;position:relative;}.timer-label{padding-bottom:.1875rem;}#element-302 .timer-box{color:#e55211;background-color:#f9f9f9;}#element-302 .timer-labels{color:#f65b00;}#element-303{top:49.625rem;left:2.0625rem;height:4.25rem;width:20rem;z-index:72;}.btn{cursor:pointer;text-align:center;transition:border .5s;width:100%;border:0;white-space:normal;display:table-cell;vertical-align:middle;padding:0;line-height:120%;}.btn-shadow{box-shadow:0 1px 3px rgba(1,1,1,0.5);}#element-303 .btn.btn-effect3d:active{box-shadow:none;}#element-303 .btn:hover{background:#BA3B03;color:#FFFFFF;}#element-303 .btn{background:linear-gradient(#FF791E,#F65B00 50%);color:#FFFFFF;font-size:0.9907rem;font-family:"objektiv-mk3-1","objektiv-mk3-2",sans-serif;font-weight:900;height:4.25rem;width:20rem;border-radius:14px;}#element-124{top:42.5rem;left:2.625rem;height:4rem;width:13.3125rem;z-index:114;color:#37465A;font-size:2.8605rem;line-height:4.0423rem;text-align:left;font-weight:900;}#element-124 .x_460c3378{text-align:left;letter-spacing:-2px;line-height:4rem;font-size:2.8605rem;}#element-124 .x_0e1fbe45{color:#f15a24;}#element-124 .contents{color:rgb(55,70,90)!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;}#element-124 .contents p{letter-spacing:-2px!important;}#element-124 strong{font-weight:900;}#element-124.paragraph{font-weight:900;}#element-132{top:40.0625rem;left:2.625rem;height:2.8125rem;width:13.3125rem;z-index:115;color:#37465A;font-size:1.8326rem;line-height:2.9596rem;text-align:left;font-weight:400;}#element-132 .x_2d956c7b{text-align:left;line-height:2.875rem;font-size:1.8326rem;}#element-132 .x_7b2817bf{color:#000000;}#element-132 strong{font-weight:700;}#element-132.paragraph{font-weight:400;}#element-134{top:40.875rem;left:2.625rem;height:1.375rem;width:9.875rem;z-index:117;}#element-134 .shape{border-bottom:2px dotted #000000;}#element-284{top:46.5625rem;left:2.25rem;height:1.6875rem;width:17rem;z-index:119;color:#37465A;font-size:1.0681rem;line-height:1.725rem;text-align:left;}#element-284 .x_c9994eb2{text-align:left;line-height:1.6875rem;font-size:1.0681rem;}#element-284 .x_7b2817bf{color:#000000;}#page_block_below_fold{height:227rem;max-width:100%;}#page_block_below_fold .section-holder-border{border:0;}#page_block_below_fold .section-block{background:none;height:227rem;}#page_block_below_fold .section-holder-overlay{display:none;}#element-18{top:-79.125rem;left:0;height:8.3781rem;width:24.875rem;z-index:7;}#element-19{top:-74.125rem;left:1.6875rem;height:8.3125rem;width:20.25rem;z-index:8;color:#37465A;font-size:1.6718rem;line-height:1.6875rem;text-align:left;font-weight:800;}#element-19 .x_415503c6{text-align:left;line-height:1.6875rem;font-size:1.6718rem;}#element-19 .x_7b2817bf{color:#000000;}#element-19 .contents{color:rgb(55,70,90)!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:800!important;}#element-19 strong{font-weight:800;}#element-19.paragraph{font-weight:800;}#element-22{top:-63.875rem;left:0;height:49.875rem;width:24.9375rem;z-index:9;}#element-22 .shape{border:0;background:rgb(0,0,0);}#element-24{top:-65.0625rem;left:1.6875rem;height:2.375rem;width:7.125rem;z-index:10;}#element-24 .shape{border:0.0625rem solid #A3BAC6;background:rgb(240,243,245);}#element-23{top:-64.4375rem;left:2.6875rem;height:1rem;width:5.1875rem;z-index:11;color:#37465A;font-size:0.6451rem;line-height:1.0419rem;text-align:left;font-weight:700;}#element-23 .x_c7d6746d{text-align:left;line-height:1rem;font-size:0.6451rem;}#element-23 .x_7b2817bf{color:#000000;}#element-23 strong{font-weight:700;}#element-23.paragraph{font-weight:700;}#element-26{top:-60.4375rem;left:0.125rem;height:13.25rem;width:24.875rem;z-index:12;}.video-holder{height:100%;overflow:hidden;position:relative;}.video-holder-animoto{background-color:#000;}.video-animoto{position:absolute;top:0;bottom:0;width:100%;height:0;padding-bottom:56.25%;margin:auto;}.video-iframe{position:absolute;}.video-overlay:hover{opacity:1;}.video-holder-helpers{transition:opacity .15s ease-in-out;position:absolute;top:0;left:0;right:0;bottom:0;font-size:14px;text-align:center;display:flex;flex-direction:column;justify-content:center;align-items:center;}.video-overlay{background-color:rgba(31,59,82,0.8);color:#ffffff;opacity:0;z-index:1;}.warning-text{margin-top:10px;font-size:13px;}.warning-img{width:25px;}.fake-video{background:#ffffff;}.fake-play{opacity:.8;}.video-overlay:hover ~ .fake-play{opacity:0;}element-26 iframe{width:398px;height:212px;}#element-28{top:-43rem;left:2.1875rem;height:0.75rem;width:7.1875rem;z-index:13;color:#37465A;font-size:0.55rem;line-height:0.8882rem;text-align:left;}#element-28 .x_c6814124{text-align:left;line-height:0.8125rem;font-size:0.55rem;}#element-28 .x_f2074b6c{color:#ffffff;}#element-29{top:-44.75rem;left:2.1875rem;height:1.6875rem;width:7.1875rem;z-index:14;color:#37465A;font-size:1.0999rem;line-height:1.7764rem;text-align:left;font-weight:900;}#element-29 .x_21d8ef23{text-align:left;line-height:1.6875rem;font-size:1.0999rem;}#element-29 .x_80c53a0c{color:#fbb03b;}#element-29 strong{font-weight:900;}#element-29.paragraph{font-weight:900;}#element-33{top:-43rem;left:16.6875rem;height:0.75rem;width:7.1875rem;z-index:15;color:#37465A;font-size:0.55rem;line-height:0.8882rem;text-align:left;}#element-33 .x_c6814124{text-align:left;line-height:0.8125rem;font-size:0.55rem;}#element-33 .x_f2074b6c{color:#ffffff;}#element-35{top:-44.75rem;left:16.6875rem;height:1.6875rem;width:7.1875rem;z-index:16;color:#37465A;font-size:1.0999rem;line-height:1.7764rem;text-align:left;font-weight:900;}#element-35 .x_21d8ef23{text-align:left;line-height:1.6875rem;font-size:1.0999rem;}#element-35 .x_80c53a0c{color:#fbb03b;}#element-35 strong{font-weight:900;}#element-35.paragraph{font-weight:900;}#element-39{top:-43rem;left:8.9375rem;height:1.5625rem;width:7.1875rem;z-index:17;color:#37465A;font-size:0.55rem;line-height:0.8882rem;text-align:left;}#element-39 .x_c6814124{text-align:left;line-height:0.8125rem;font-size:0.55rem;}#element-39 .x_f2074b6c{color:#ffffff;}#element-41{top:-44.75rem;left:8.9375rem;height:1.6875rem;width:7.1875rem;z-index:18;color:#37465A;font-size:1.0999rem;line-height:1.7764rem;text-align:left;font-weight:900;}#element-41 .x_21d8ef23{text-align:left;line-height:1.6875rem;font-size:1.0999rem;}#element-41 .x_80c53a0c{color:#fbb03b;}#element-41 strong{font-weight:900;}#element-41.paragraph{font-weight:900;}#element-48{top:-16.25rem;left:0;height:41.8125rem;width:25.0625rem;z-index:19;}#element-48 .shape{border:0;background:rgb(240,243,245);}#element-46{top:-16.25rem;left:0;height:16.3558rem;width:25.3125rem;z-index:20;}#element-46 .cropped{background:url(../<?php echo $info->s4_image ?>) -0.8125rem 0 / 26.125rem 16.3125rem;}#element-47{top:-13.6875rem;left:2.0625rem;height:11.6875rem;width:13.25rem;z-index:21;color:#37465A;font-size:1.6718rem;line-height:1.6875rem;text-align:left;font-weight:900;}#element-47 .x_415503c6{text-align:left;line-height:1.6875rem;font-size:1.6718rem;}#element-47 .x_80c53a0c{color:#fbb03b;}#element-47 .contents{color:rgb(55,70,90)!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;}#element-47 strong{font-weight:900;}#element-47.paragraph{font-weight:900;}#element-57{top:4.25rem;left:13.75rem;height:1rem;width:8.5625rem;z-index:37;color:#37465A;font-size:0.6192rem;line-height:1rem;text-align:left;}#element-57 .x_d93e4d4c{text-align:left;line-height:1rem;font-size:0.6192rem;}#element-57 .x_c24cab30{color:#6f6f6f;}#element-59{top:2.5625rem;left:13.75rem;height:1.6875rem;width:7.0625rem;z-index:38;color:#37465A;font-size:1.1106rem;line-height:1.7936rem;text-align:left;font-weight:900;}#element-59 .x_32ef35e0{text-align:left;line-height:1.6875rem;font-size:1.1106rem;}#element-59 .x_7b2817bf{color:#000000;}#element-59 strong{font-weight:900;}#element-59.headline{font-weight:900;}#element-62{top:10.875rem;left:1.8125rem;height:0.8125rem;width:9.25rem;z-index:39;color:#37465A;font-size:0.6192rem;line-height:0.875rem;text-align:left;}#element-62 .x_50e3c4eb{text-align:left;line-height:0.875rem;font-size:0.6192rem;}#element-62 .x_c24cab30{color:#6f6f6f;}#element-64{top:9.0625rem;left:1.8125rem;height:1.75rem;width:8.75rem;z-index:40;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:left;font-weight:900;}#element-64 .x_b6c3675a{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-64 .x_7b2817bf{color:#000000;}#element-64 strong{font-weight:900;}#element-64.headline{font-weight:900;}#element-68{top:7.375rem;left:1.8125rem;height:0.8125rem;width:8.75rem;z-index:41;color:#37465A;font-size:0.6192rem;line-height:0.875rem;text-align:left;}#element-68 .x_50e3c4eb{text-align:left;line-height:0.875rem;font-size:0.6192rem;}#element-68 .x_c24cab30{color:#6f6f6f;}#element-70{top:5.5625rem;left:1.8125rem;height:1.75rem;width:8.75rem;z-index:42;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:left;font-weight:900;}#element-70 .x_b6c3675a{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-70 .x_7b2817bf{color:#000000;}#element-70 strong{font-weight:900;}#element-70.headline{font-weight:900;}#element-74{top:14.25rem;left:1.8125rem;height:1rem;width:11.1875rem;z-index:43;color:#37465A;font-size:0.6192rem;line-height:1rem;text-align:left;}#element-74 .x_d93e4d4c{text-align:left;line-height:1rem;font-size:0.6192rem;}#element-74 .x_c24cab30{color:#6f6f6f;}#element-76{top:12.625rem;left:1.8125rem;height:1.6875rem;width:8.75rem;z-index:44;color:#37465A;font-size:1.1106rem;line-height:1.7936rem;text-align:left;font-weight:900;}#element-76 .x_32ef35e0{text-align:left;line-height:1.6875rem;font-size:1.1106rem;}#element-76 .x_7b2817bf{color:#000000;}#element-76 strong{font-weight:900;}#element-76.headline{font-weight:900;}#element-81{top:12.625rem;left:13.75rem;height:1.6875rem;width:4.25rem;z-index:46;color:#37465A;font-size:1.1106rem;line-height:1.7936rem;text-align:left;font-weight:900;}#element-81 .x_32ef35e0{text-align:left;line-height:1.6875rem;font-size:1.1106rem;}#element-81 .x_7b2817bf{color:#000000;}#element-81 strong{font-weight:900;}#element-81.headline{font-weight:900;}#element-165{top:1.375rem;left:1.8125rem;height:1rem;width:10.1875rem;z-index:53;color:#37465A;font-size:0.6192rem;line-height:1rem;text-align:left;}#element-165 .x_d93e4d4c{text-align:left;line-height:1rem;font-size:0.6192rem;}#element-165 .x_c24cab30{color:#6f6f6f;}#element-167{top:2.5625rem;left:1.8125rem;height:1.75rem;width:5.5rem;z-index:54;color:#37465A;font-size:1.1146rem;line-height:1.8rem;font-weight:900;}#element-167 .x_8ae9aa76{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-167 .x_7b2817bf{color:#000000;}#element-167 strong{font-weight:900;}#element-167.headline{font-weight:900;}#element-170{top:7.375rem;left:13.75rem;height:1rem;width:9.25rem;z-index:55;color:#37465A;font-size:0.6192rem;line-height:1rem;text-align:left;}#element-170 .x_d93e4d4c{text-align:left;line-height:1rem;font-size:0.6192rem;}#element-170 .x_c24cab30{color:#6f6f6f;}#element-172{top:5.5625rem;left:13.75rem;height:1.75rem;width:5.5rem;z-index:56;color:#37465A;font-size:1.1146rem;line-height:1.8rem;font-weight:900;}#element-172 .x_8ae9aa76{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-172 .x_7b2817bf{color:#000000;}#element-172 strong{font-weight:900;}#element-172.headline{font-weight:900;}#element-217{top:-38.375rem;left:18.25rem;height:3.3027rem;width:3.0625rem;z-index:74;}#element-218{top:-38.375rem;left:2.1875rem;height:3.3266rem;width:3.75rem;z-index:75;}#element-219{top:-32.75rem;left:10.1875rem;height:3.375rem;width:4.5625rem;z-index:76;}#element-220{top:-27.4375rem;left:2.1875rem;height:3.4375rem;width:4.1875rem;z-index:77;}#element-221{top:-27.4375rem;left:18rem;height:3.5rem;width:3.5625rem;z-index:78;}#element-223{top:-34.0625rem;left:16.625rem;height:1.4375rem;width:6.3125rem;z-index:79;color:#37465A;font-size:0.6192rem;line-height:0.75rem;text-align:center;}#element-223 .x_7ca85f40{text-align:center;line-height:0.75rem;font-size:0.6192rem;}#element-223 .x_f2074b6c{color:#ffffff;}#element-224{top:-34.0625rem;left:0;height:1.4375rem;width:8.875rem;z-index:80;color:#37465A;font-size:0.6192rem;line-height:0.75rem;text-align:center;}#element-224 .x_7ca85f40{text-align:center;line-height:0.75rem;font-size:0.6192rem;}#element-224 .x_f2074b6c{color:#ffffff;}#element-225{top:-28.625rem;left:8.125rem;height:1.4375rem;width:8.875rem;z-index:81;color:#37465A;font-size:0.6192rem;line-height:0.75rem;text-align:center;}#element-225 .x_7ca85f40{text-align:center;line-height:0.75rem;font-size:0.6192rem;}#element-225 .x_f2074b6c{color:#ffffff;}#element-226{top:-23.125rem;left:0.0625rem;height:1.4375rem;width:8.875rem;z-index:82;color:#37465A;font-size:0.6192rem;line-height:0.75rem;text-align:center;}#element-226 .x_7ca85f40{text-align:center;line-height:0.75rem;font-size:0.6192rem;}#element-226 .x_f2074b6c{color:#ffffff;}#element-227{top:-23.125rem;left:15.3125rem;height:1.4375rem;width:8.875rem;z-index:83;color:#37465A;font-size:0.6192rem;line-height:0.75rem;text-align:center;}#element-227 .x_7ca85f40{text-align:center;line-height:0.75rem;font-size:0.6192rem;}#element-227 .x_f2074b6c{color:#ffffff;}#page_block_footer{height:108.0625rem;max-width:100%;}#page_block_footer .section-holder-border{border:0;}#page_block_footer .section-block{background:none;height:108.0625rem;}#page_block_footer .section-holder-overlay{display:none;}#element-93{top:-201.625rem;left:0;height:24.75rem;width:24.9375rem;z-index:22;}#element-93 .shape{border:0;background:rgb(255,255,255);}#element-95{top:-195.625rem;left:3.625rem;height:4.6875rem;width:17.75rem;z-index:23;color:#37465A;font-size:1.6718rem;line-height:2.3625rem;text-align:left;font-weight:900;}#element-95 .x_178516c5{text-align:left;line-height:2.375rem;font-size:1.6718rem;}#element-95 .x_80c53a0c{color:#fbb03b;}#element-95 .contents{color:rgb(55,70,90)!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;}#element-95 .contents p{letter-spacing:-2px!important;}#element-95 strong{font-weight:900;}#element-95.headline{font-weight:900;}#element-98{top:-176.8125rem;left:0;height:133rem;width:24.9375rem;z-index:25;}#element-98 .shape{border:0;background:rgb(0,0,0);}#element-151{top:81.25rem;left:2.5rem;height:2.4375rem;width:20rem;z-index:34;color:#37465A;font-size:1.2384rem;line-height:1.25rem;text-align:left;font-weight:900;}#element-151 .x_9e69c46b{text-align:left;line-height:1.25rem;font-size:1.2384rem;}#element-151 .x_f2074b6c{color:#ffffff;}#element-151 .x_80c53a0c{color:#fbb03b;}#element-151 strong{font-weight:900;}#element-151.headline{font-weight:900;}#element-153{top:-55.5rem;left:2.5rem;height:3.5rem;width:20rem;z-index:35;color:#37465A;font-size:1.1765rem;line-height:1.1875rem;text-align:center;font-weight:400;}#element-153 .x_ce9a991a{text-align:center;line-height:1.1875rem;font-size:1.1765rem;}#element-153 .x_80c53a0c{color:#fbb03b;}#element-153 strong{font-weight:700;}#element-153.headline{font-weight:400;}#element-79{top:-212.6875rem;left:13.75rem;height:1rem;width:8.4375rem;z-index:45;color:#37465A;font-size:0.6192rem;line-height:1rem;text-align:left;}#element-79 .x_d93e4d4c{text-align:left;line-height:1rem;font-size:0.6192rem;}#element-79 .x_c24cab30{color:#6f6f6f;}#element-84{top:-216.25rem;left:13.75rem;height:1rem;width:11.1875rem;z-index:47;color:#37465A;font-size:0.6192rem;line-height:1rem;text-align:left;}#element-84 .x_d93e4d4c{text-align:left;line-height:1rem;font-size:0.6192rem;}#element-84 .x_c24cab30{color:#6f6f6f;}#element-86{top:-217.9375rem;left:13.75rem;height:1.6875rem;width:8.75rem;z-index:48;color:#37465A;font-size:1.1106rem;line-height:1.7936rem;text-align:left;font-weight:900;}#element-86 .x_32ef35e0{text-align:left;line-height:1.6875rem;font-size:1.1106rem;}#element-86 .x_7b2817bf{color:#000000;}#element-86 strong{font-weight:900;}#element-86.headline{font-weight:900;}#element-89{top:-208.625rem;left:1.8125rem;height:1rem;width:9.5625rem;z-index:49;color:#37465A;font-size:0.6192rem;line-height:1rem;text-align:left;}#element-89 .x_d93e4d4c{text-align:left;line-height:1rem;font-size:0.6192rem;}#element-89 .x_c24cab30{color:#6f6f6f;}#element-91{top:-210.375rem;left:1.8125rem;height:1.6875rem;width:8.75rem;z-index:50;color:#37465A;font-size:1.1106rem;line-height:1.7936rem;text-align:left;font-weight:900;}#element-91 .x_32ef35e0{text-align:left;line-height:1.6875rem;font-size:1.1106rem;}#element-91 .x_7b2817bf{color:#000000;}#element-91 strong{font-weight:900;}#element-91.headline{font-weight:900;}#element-160{top:-208.625rem;left:13.625rem;height:1rem;width:11.4375rem;z-index:51;color:#37465A;font-size:0.6192rem;line-height:1rem;text-align:left;}#element-160 .x_d93e4d4c{text-align:left;line-height:1rem;font-size:0.6192rem;}#element-160 .x_c24cab30{color:#6f6f6f;}#element-162{top:-210.4375rem;left:13.625rem;height:1.75rem;width:8.8125rem;z-index:52;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:left;font-weight:900;}#element-162 .x_b6c3675a{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-162 .x_7b2817bf{color:#000000;}#element-162 strong{font-weight:900;}#element-162.headline{font-weight:900;}#element-173{top:-188.125rem;left:1.3125rem;height:4.25rem;width:3.625rem;z-index:57;}#element-104{top:-107.4375rem;left:4.6875rem;height:8.9375rem;width:15.75rem;z-index:58;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:center;}#element-104 .x_077c8203{text-align:center;line-height:1.3125rem;font-size:0.805rem;}#element-104 .x_70ee4658{text-align:center;line-height:1.3125rem;font-size:0.805rem;}#element-104 .x_199030dd{color:#dddddd;}#element-106{top:-110.4375rem;left:7.75rem;height:1.5625rem;width:9.6875rem;z-index:59;color:#37465A;font-size:0.805rem;line-height:0.8125rem;text-align:center;font-weight:400;}#element-106 .x_c2a5648c{text-align:center;line-height:0.8125rem;font-size:0.805rem;}#element-106 .x_9f7a47db{text-align:center;line-height:0.8125rem;font-size:0.805rem;}#element-106 .x_65831597{color:#fbfbfb;}#element-106 strong{font-weight:700;}#element-106.headline{font-weight:400;}#element-146{top:-97.1875rem;left:9.6875rem;height:1.0511rem;width:5.75rem;z-index:60;}#element-175{top:-130.375rem;left:3.125rem;height:18.75rem;width:18.75rem;z-index:61;}#element-103{top:-147.9375rem;left:4.5rem;height:12.75rem;width:15.9375rem;z-index:62;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:center;}#element-103 .x_077c8203{text-align:center;line-height:1.3125rem;font-size:0.805rem;}#element-103 .x_70ee4658{text-align:center;line-height:1.3125rem;font-size:0.805rem;}#element-103 .x_199030dd{color:#dddddd;}#element-107{top:-150.4375rem;left:7.625rem;height:1.5625rem;width:9.75rem;z-index:63;color:#37465A;font-size:0.805rem;line-height:0.8125rem;text-align:center;font-weight:400;}#element-107 .x_c2a5648c{text-align:center;line-height:0.8125rem;font-size:0.805rem;}#element-107 .x_9f7a47db{text-align:center;line-height:0.8125rem;font-size:0.805rem;}#element-107 .x_65831597{color:#fbfbfb;}#element-107 strong{font-weight:700;}#element-107.headline{font-weight:400;}#element-147{top:-133.6875rem;left:9.625rem;height:1rem;width:5.75rem;z-index:64;}#element-176{top:-169.875rem;left:2.6875rem;height:18.6875rem;width:18.6875rem;z-index:65;}#element-102{top:-71.375rem;left:3.8125rem;height:10.25rem;width:17.375rem;z-index:68;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:center;}#element-102 .x_077c8203{text-align:center;line-height:1.3125rem;font-size:0.805rem;}#element-102 .x_70ee4658{text-align:center;line-height:1.3125rem;font-size:0.805rem;}#element-102 .x_199030dd{color:#dddddd;}#element-105{top:-74.25rem;left:7.625rem;height:1.5625rem;width:9.75rem;z-index:69;color:#37465A;font-size:0.805rem;line-height:0.8125rem;text-align:center;font-weight:400;}#element-105 .x_c2a5648c{text-align:center;line-height:0.8125rem;font-size:0.805rem;}#element-105 .x_9f7a47db{text-align:center;line-height:0.8125rem;font-size:0.805rem;}#element-105 .x_65831597{color:#fbfbfb;}#element-105 strong{font-weight:700;}#element-105.headline{font-weight:400;}#element-148{top:-59.625rem;left:10.0625rem;height:1.0625rem;width:5.8125rem;z-index:70;}#element-177{top:-94rem;left:3.125rem;height:18.6875rem;width:18.6875rem;z-index:71;}#element-193{top:-186.875rem;left:0.0625rem;height:8.2561rem;width:24.9375rem;z-index:73;}#element-228{top:-175.3125rem;left:7.6875rem;height:3rem;width:12.0625rem;z-index:84;color:#37465A;font-size:1.4861rem;line-height:1.5rem;text-align:left;font-weight:900;}#element-228 .x_24e44f2f{text-align:left;line-height:1.5rem;font-size:1.4861rem;}#element-228 .x_f2074b6c{color:#ffffff;}#element-228 .x_80c53a0c{color:#fbb03b;}#element-228 strong{font-weight:900;}#element-228.headline{font-weight:900;}#element-229{top:-175.9375rem;left:1.75rem;height:4.25rem;width:3.625rem;z-index:85;}#element-420{top:-203.625rem;left:3.4375rem;height:3.9375rem;width:17.0625rem;z-index:166;}#element-420 .btn.btn-effect3d:active{box-shadow:none;}#element-420 .btn:hover{background:#BA3B03;color:#FFFFFF;}#element-420 .btn{background:linear-gradient(#FF791E,#F65B00 50%);color:#FFFFFF;font-size:0.9907rem;font-family:"objektiv-mk3-1","objektiv-mk3-2",sans-serif;font-weight:900;height:3.9375rem;width:17.0625rem;border-radius:14px;}#page-block-i82xvkz7ji{height:54.875rem;max-width:100%;}#page-block-i82xvkz7ji .section-holder-border{border:0;}#page-block-i82xvkz7ji .section-block{background:none;height:54.875rem;}#page-block-i82xvkz7ji .section-holder-overlay{display:none;}#element-395{top:-152.25rem;left:0.125rem;height:72.25rem;width:24.9375rem;z-index:150;}#element-395 .shape{border:0;background:rgb(251,176,59);}#element-394{top:-155rem;left:1rem;height:15.243rem;width:22.5rem;z-index:151;}#element-396{top:-138.375rem;left:0.125rem;height:23.718rem;width:24.875rem;z-index:152;}#element-397{top:-114.625rem;left:0;height:36.75rem;width:25.0625rem;z-index:153;}#element-397 .shape{border:0;background:rgb(246,225,222);}#element-398{top:-110.75rem;left:3.8125rem;height:6.6875rem;width:16.6875rem;z-index:154;color:#37465A;font-size:2.2291rem;line-height:2.25rem;text-align:left;font-weight:900;}#element-398 .x_a3e05b5f{text-align:left;line-height:2.25rem;font-size:2.2291rem;}#element-398 .x_7b2817bf{color:#000000;}#element-398 strong{font-weight:900;}#element-398.headline{font-weight:900;}#element-399{top:-112.5625rem;left:3.8125rem;height:1.75rem;width:12.125rem;z-index:155;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:left;font-weight:800;}#element-399 .x_b6c3675a{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-399 .x_7b2817bf{color:#000000;}#element-399 strong{font-weight:800;}#element-399.headline{font-weight:800;}#element-400{top:-100.5rem;left:3.8125rem;height:6.125rem;width:17.5rem;z-index:157;color:#37465A;font-size:0.8669rem;line-height:1.225rem;text-align:left;}#element-400 .x_67538361{text-align:left;line-height:1.25rem;font-size:0.8669rem;}#element-400 .x_7b2817bf{color:#000000;}#element-400 strong{font-weight:700;}#element-401{top:-85.0625rem;left:3.8125rem;height:2.5rem;width:16.75rem;z-index:158;}#element-401 .btn.btn-effect3d:active{box-shadow:none;}#element-401 .btn:hover{background:#BA3B03;color:#FFFFFF;}#element-401 .btn{background:linear-gradient(#FF791E,#F65B00 50%);color:#FFFFFF;font-size:0.9907rem;font-family:"objektiv-mk3-1","objektiv-mk3-2",sans-serif;font-weight:900;height:2.5rem;width:16.75rem;border-radius:14px;}#element-402{top:-92.375rem;left:3.875rem;height:2.4375rem;width:17.5rem;z-index:159;color:#37465A;font-size:0.8669rem;line-height:1.225rem;text-align:left;}#element-402 .x_67538361{text-align:left;line-height:1.25rem;font-size:0.8669rem;}#element-402 .x_7b2817bf{color:#000000;}#page-block-5643epclur5{height:97.625rem;max-width:100%;}#page-block-5643epclur5 .section-holder-border{border:0;}#page-block-5643epclur5 .section-block{background:none;height:97.625rem;}#page-block-5643epclur5 .section-holder-overlay{display:none;}#element-380{top:-127.625rem;left:0.0625rem;height:72.5rem;width:24.9375rem;z-index:86;}#element-380 .shape{border:0;background:rgb(251,176,59);}#element-361{top:-132.8125rem;left:0.0625rem;height:12.9375rem;width:25rem;z-index:87;}#element-361 .shape{border:0;background:rgb(240,243,245);}#element-363{top:-114.8125rem;left:2.75rem;height:10rem;width:19.625rem;z-index:88;color:#37465A;font-size:0.807rem;line-height:1.1404rem;text-align:left;}#element-363 .x_2830259f{text-align:left;line-height:1.125rem;font-size:0.807rem;}#element-363 .x_7b2817bf{color:#000000;}#element-362{top:-129.5625rem;left:2.75rem;height:6.6875rem;width:19.75rem;z-index:89;color:#37465A;font-size:1.676rem;line-height:1.6917rem;text-align:left;font-weight:900;}#element-362 .x_0a56100c{text-align:left;line-height:1.6875rem;font-size:1.676rem;}#element-362 .x_7b2817bf{color:#000000;}#element-362 .contents{color:rgb(55,70,90)!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;}#element-362 .contents p{letter-spacing:-1px!important;}#element-362 strong{font-weight:900;}#element-362.headline{font-weight:900;}#element-367{top:-27.375rem;left:2.5rem;height:31.2575rem;width:22.5rem;z-index:92;}#element-367 .cropped{background:url(../<?php echo $info->s9_image ?>) 0 0 / 25.3125rem 31.25rem;}#element-366{top:-96.8125rem;left:0.1875rem;height:1.3125rem;width:24.75rem;z-index:93;}#element-366 .shape{border-bottom:1px dotted #FBFBFB;}#element-364{top:-99.75rem;left:2.375rem;height:7.25rem;width:12.8125rem;z-index:94;}#element-364 .shape{border:0;background:rgb(241,90,36);}#element-365{top:-98.5rem;left:3.0625rem;height:4.4375rem;width:11.4375rem;z-index:95;color:#37465A;font-size:0.9892rem;line-height:1.1982rem;text-align:left;font-weight:700;}#element-365 .x_8d839f14{text-align:left;line-height:1.125rem;font-size:0.9892rem;}#element-365 .x_f2074b6c{color:#ffffff;}#element-365 strong{font-weight:700;}#element-365.paragraph{font-weight:700;}#element-368{top:-80.5rem;left:0.9375rem;height:17.125rem;width:22.4375rem;z-index:98;color:#37465A;font-size:0.8037rem;line-height:1.1358rem;text-align:left;}#element-368 .x_63f4f890{text-align:left;line-height:1.0625rem;font-size:0.8037rem;}#element-368 li{color:#000001;}#element-368 strong{font-weight:700;}#element-371{top:-89.3125rem;left:2.1875rem;height:6.6875rem;width:20rem;z-index:99;color:#37465A;font-size:1.7311rem;line-height:1.7473rem;text-align:left;font-weight:900;}#element-371 .x_03299323{text-align:left;line-height:1.6875rem;font-size:1.7311rem;}#element-371 .x_f2074b6c{color:#ffffff;}#element-371 strong{font-weight:900;}#element-371.headline{font-weight:900;}#element-381{top:-60.625rem;left:4.4375rem;height:2.5rem;width:16.25rem;z-index:102;}#element-381 .btn.btn-effect3d:active{box-shadow:none;}#element-381 .btn:hover{background:#BA3B03;color:#FFFFFF;}#element-381 .btn{background:linear-gradient(#FF791E,#F65B00 50%);color:#FFFFFF;font-size:0.9907rem;font-family:"objektiv-mk3-1","objektiv-mk3-2",sans-serif;font-weight:900;height:2.5rem;width:16.25rem;border-radius:14px;}#element-370{top:-55.25rem;left:0.0625rem;height:55.75rem;width:25rem;z-index:103;}#element-370 .shape{border:0;background:rgb(0,0,0);}#element-369{top:-41.0625rem;left:3.0625rem;height:11.875rem;width:20.25rem;z-index:104;color:#37465A;font-size:0.8078rem;line-height:1.1415rem;text-align:left;}#element-369 .x_838c6f97{text-align:left;line-height:1.125rem;font-size:0.8078rem;}#element-369 .x_f2074b6c{color:#ffffff;}#element-369 .x_6ab41614{text-align:left;color:rgb(255,255,255);}#element-369 strong{font-weight:700;}#element-373{top:-25.5625rem;left:4.375rem;height:6.5rem;width:5.875rem;z-index:105;}#element-375{top:-10.4375rem;left:9.6875rem;height:6.6875rem;width:5.5625rem;z-index:107;}#element-376{top:-23.625rem;left:16.0625rem;height:2.6875rem;width:3.75rem;z-index:108;}#element-377{top:-17.6875rem;left:4.875rem;height:5.75rem;width:4.25rem;z-index:109;}#element-378{top:-16.125rem;left:16.0625rem;height:2.7331rem;width:3.75rem;z-index:110;}#element-372{top:-46.5625rem;left:3.1875rem;height:3.5rem;width:17.625rem;z-index:111;color:#37465A;font-size:1.1806rem;line-height:1.1916rem;text-align:left;font-weight:900;}#element-372 .x_6c8b1a85{text-align:left;line-height:1.1875rem;font-size:1.1806rem;}#element-372 .x_f2074b6c{color:#ffffff;}#element-372 strong{font-weight:900;}#element-372.headline{font-weight:900;}#element-379{top:-49.75rem;left:3.1875rem;height:1.875rem;width:5rem;z-index:113;}#page-block-ceqi3wwonu8{height:46.375rem;max-width:100%;}#page-block-ceqi3wwonu8 .section-holder-border{border:0;}#page-block-ceqi3wwonu8 .section-block{background:none;height:46.375rem;}#page-block-ceqi3wwonu8 .section-holder-overlay{display:none;}#element-343{top:-430.875rem;left:0.8125rem;height:3.5625rem;width:22.5rem;z-index:24;}#element-343 .shape{border:0;background:rgb(0,0,0);}#element-321{top:-81.1875rem;left:0.0625rem;height:127.0625rem;width:24.9375rem;z-index:36;}#element-321 .shape{border:0;background:rgb(255,255,255);}#element-330{top:19.8125rem;left:0;height:26.5625rem;width:25rem;z-index:120;}#element-330 .shape{border:0;background:rgb(251,176,59);}#element-341{top:-73.6875rem;left:6.625rem;height:5.2987rem;width:12rem;z-index:121;}#element-338{top:-92rem;left:2.6875rem;height:19.5896rem;width:20.6875rem;z-index:122;}#element-328{top:14.6875rem;left:3.5625rem;height:1.125rem;width:18.9375rem;z-index:123;color:#37465A;font-size:1.1735rem;line-height:1.1845rem;text-align:left;font-weight:900;}#element-328 .x_1b51740c{text-align:left;letter-spacing:-1px;line-height:1.125rem;font-size:1.1735rem;}#element-328 .x_0e1fbe45{color:#f15a24;}#element-328 .contents{color:rgb(55,70,90)!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;}#element-328 .contents p{letter-spacing:-1px!important;}#element-328 strong{font-weight:900;}#element-328.headline{font-weight:900;}#element-333{top:28.3125rem;left:15.9375rem;height:5.9375rem;width:6.25rem;z-index:124;}#element-332{top:30.375rem;left:11.25rem;height:1.6579rem;width:2.25rem;z-index:125;}#element-331{top:36.625rem;left:3.25rem;height:5.8676rem;width:5.25rem;z-index:126;}#element-334{top:37.5625rem;left:17.5625rem;height:4.0625rem;width:3rem;z-index:127;}#element-336{top:38.8125rem;left:11.5625rem;height:1.6364rem;width:2.25rem;z-index:129;}#element-337{top:27.8125rem;left:2.625rem;height:6.8645rem;width:5.875rem;z-index:130;}#element-342{top:18.5625rem;left:4.125rem;height:3.25rem;width:16.6875rem;z-index:132;font-size:3.25rem;}#element-342 .timer-box{color:#e55211;background-color:#f9f9f9;}#element-342 .timer-labels{color:#f65b00;}#element-319{top:-73.3125rem;left:1.0625rem;height:40.1875rem;width:23.0625rem;z-index:133;}#element-319 .shape{border:0.0625rem solid #A3BAC6;border-radius:0.5rem 0.5rem 0.5rem 0.5rem;background:rgb(255,255,255);}#element-317 .product-title{margin-top: 0;margin-bottom: 10px;font-size: 24px;line-height: 32px;font-weight: 600;}#element-317{top:-43.9375rem;left:2.0625rem;height:41.375rem;width:20.8125rem;z-index:134;}.lightbox{display:none;position:fixed;width:100%;height:100%;top:0;}.lightbox-dim{background:rgba(0,0,0,0.85);height:100%;animation:fade-in .5s ease-in-out;overflow-x:hidden;display:flex;align-items:center;padding:30px 0;}.lightbox-content{background-color:#fefefe;border-radius:3px;position:relative;margin:auto;animation:slide-down .5s ease-in-out;}.lightbox-opened{display:block;}.lightbox-close{width:25px;right:0;top:-10px;cursor:pointer;}.lightbox-close-icon{fill:#fff;}.notification-text{font-size:1.5rem;color:#fff;text-align:center;width:100%;}.modal-on{overflow:hidden;}.form{font-size:1.25rem;}.form-input{color:transparent;background-color:transparent;border:1px solid transparent;border-radius:3px;font-family:inherit;width:100%;height:3.5rem;margin:0.5rem 0;padding:0.5rem 0.625rem 0.5625rem;}.form-input::placeholder{opacity:1;color:transparent;}.form-textarea{display:inline-block;vertical-align:top;}.form-select{background:url("https://v.fastcdn.co/a/img/builder2/select-arrow-drop-down.png") no-repeat right;-webkit-appearance:none;-moz-appearance:none;color:transparent;}.form-label{display:inline-block;color:transparent;}.form-label-title{display:block;line-height:1.1;width:100%;padding:0.75rem 0 0.5625rem;margin:0.5rem 0 0.125rem;}.form-multiple-label:empty{display:block;height:0.8rem;margin-top:.375rem;}.form-label-outside{margin:0.3125rem 0 0;}.form-multiple-input{position:absolute;opacity:0;}.form-multiple-label{position:relative;padding-top:0.75rem;line-height:1.05;margin-left:1.5625rem;}.form-multiple-label:before{content:"";display:inline-block;box-sizing:inherit;width:1rem;height:1rem;background-color:#fff;border-radius:0.25rem;border:1px solid #8195a8;margin-right:0.5rem;vertical-align:-2px;position:absolute;left:-1.5625rem;}.form-checkbox-label:after{content:"";width:0.25rem;height:0.5rem;position:absolute;top:0.8rem;left:-1.25rem;transform:rotate(45deg);border-right:0.1875rem solid;border-bottom:0.1875rem solid;color:#fff;}.form-radio-label:before{border-radius:50%;}.form-multiple-input:focus + .form-multiple-label:before{border:2px solid #308dfc;}.form-multiple-input:checked + .form-radio-label:before{border:0.3125rem solid #308dfc;}.form-multiple-input:checked + .form-checkbox-label:before{background-color:#308dfc;border:0;}.form-btn{-webkit-appearance:none;-moz-appearance:none;background-color:transparent;border:0;cursor:pointer;min-height:100%;}.form-input-inner-shadow{box-shadow:inset 0 1px 3px rgba(0,0,0,0.28);}body#landing-page .user-invalid-label{color:#e85f54;}body#landing-page .user-invalid{border-color:#e85f54;}.form-messagebox{transform:translate(0.4375rem,-0.4375rem);}.form-messagebox:before{content:"";position:absolute;display:block;width:0.375rem;height:0.375rem;transform:rotate(45deg);background-color:#e85f54;top:-0.1875rem;left:25%;}.form-messagebox-contents{font-size:0.875rem;font-weight:500;color:#fff;background-color:#e85f54;padding:0.4375rem 0.9375rem;max-width:250px;word-wrap:break-word;margin:auto;}.form-messagebox-top{transform:translate(0,-1rem);}.form-messagebox-top:before{bottom:-0.1875rem;top:auto;}#element-317 .btn.btn-effect3d:active{box-shadow:none;}#element-317 .btn:hover{background:#C34B21;color:#FFFFFF;}#element-317 .btn-product-cart{background:linear-gradient(#FF7842,#F15A24 50%);color:#FFFFFF;font-size:1.1146rem;font-family:"objektiv-mk3-1","objektiv-mk3-2",sans-serif;font-weight:900;height:3.25rem;width:21.0625rem;border-radius:15px;}#element-317 .form-label{color:#B4B4B4;}#element-317 ::placeholder{color:#B4B4B4;}#element-317 .form-input{color:#000000;background-color:#FFFFFF;border-color:#FBB03B;}#element-317 .user-invalid{border-color:#E12627;}#element-317 input::placeholder,#element-317 .form-label-inside{color:#B4B4B4;}#element-317 select.valid{color:#000000;}#element-317 .form-btn-geometry{top:42.9375rem;left:-0.1875rem;height:3.25rem;width:21.0625rem;z-index:134;}#element-320{top:6.5rem;left:1.8125rem;height:1.0625rem;width:13.5625rem;z-index:135;color:#37465A;font-size:0.8895rem;line-height:1.0774rem;text-align:center;font-weight:800;}#element-320 .x_b3792fa3{text-align:center;line-height:1.0625rem;font-size:0.8895rem;}#element-320 .x_7b2817bf{color:#000000;}#element-320 strong{font-weight:800;}#element-320.paragraph{font-weight:800;}#element-329{top:5.4375rem;left:18.3125rem;height:3.2818rem;width:4.75rem;z-index:136;}#element-327{top:-62.3125rem;left:2.6875rem;height:4.5625rem;width:19.75rem;z-index:145;color:#37465A;font-size:2.303rem;line-height:2.3245rem;text-align:left;font-weight:900;}#element-327 .x_bbae5241{text-align:left;letter-spacing:-3px;line-height:2.3125rem;font-size:2.303rem;}#element-327 .x_7b2817bf{color:#000000;}#element-327 .contents{color:rgb(55,70,90)!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;}#element-327 .contents p{letter-spacing:-3px!important;}#element-327 strong{font-weight:900;}#element-327.paragraph{font-weight:900;}#element-340{top:-65.125rem;left:2.75rem;height:2.1455rem;width:5.75rem;z-index:146;}#element-322{top:-99.5rem;left:2.0625rem;height:7.9375rem;width:21.375rem;z-index:148;}#element-322 .shape{border:0;background:rgb(255,255,255);}#element-323{top:-98.875rem;left:2.6875rem;height:6.4375rem;width:19.6875rem;z-index:149;color:#37465A;font-size:1.6677rem;line-height:1.6833rem;text-align:left;font-weight:900;}#element-323 .x_413e62cc{text-align:left;letter-spacing:-3px;line-height:1.625rem;font-size:1.6677rem;}#element-323 .x_0e1fbe45{color:#f15a24;}#element-323 .contents{color:rgb(55,70,90)!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;}#element-323 .contents p{letter-spacing:-1px!important;}#element-323 strong{font-weight:900;}#element-323.headline{font-weight:900;}#element-348{top:-53.625rem;left:2.375rem;height:5.3125rem;width:15.3125rem;z-index:160;color:#37465A;font-size:3.3563rem;line-height:5.4204rem;font-weight:900;}#element-348 .x_3d96d8be{text-align:left;line-height:5.375rem;font-size:3.3563rem;letter-spacing:-2px;}#element-348 .x_0e1fbe45{color:#f15a24;}#element-348 .contents{color:rgb(55,70,90)!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;}#element-348 .contents p{letter-spacing:-2px!important;}#element-348 strong{font-weight:900;}#element-348.paragraph{font-weight:900;}#element-350{top:-55.1875rem;left:2.375rem;height:3rem;width:10.75rem;z-index:161;color:#37465A;font-size:1.8795rem;line-height:3.0354rem;font-weight:400;}#element-350 .x_b43521ac{text-align:left;line-height:3rem;font-size:1.8795rem;}#element-350 .x_7b2817bf{color:#000000;}#element-350 strong{font-weight:700;}#element-350.paragraph{font-weight:400;}#element-352{top:-54.25rem;left:2.6875rem;height:1.3125rem;width:8.6875rem;z-index:163;}#element-352 .shape{border-bottom:1px dotted #000000;}#element-354{top:-49.125rem;left:2.5625rem;height:1.625rem;width:14.3125rem;z-index:165;color:#37465A;font-size:0.9907rem;line-height:1.6rem;}#element-354 .x_3579aa00{text-align:left;line-height:1.625rem;font-size:0.9907rem;}#element-354 .x_7b2817bf{color:#000000;}#page-block-j8wabyhcyyb{height:6rem;max-width:100%;}#page-block-j8wabyhcyyb .section-holder-border{border:0;}#page-block-j8wabyhcyyb .section-block{background:none;height:6rem;}#page-block-j8wabyhcyyb .section-holder-overlay{display:none;}#element-137{top:0;left:0;height:6rem;width:24.9375rem;z-index:32;}#element-137 .shape{border:0;background:rgb(0,0,0);}#element-138{top:1.3125rem;left:2.4375rem;height:3.3125rem;width:20rem;z-index:33;color:#37465A;font-size:0.805rem;line-height:1.1375rem;text-align:center;}#element-138 .x_bc7e314d{text-align:center;line-height:1.125rem;font-size:0.805rem;}#element-138 .x_dc6c6e10{text-align:center;line-height:1.125rem;font-size:0.805rem;}#element-138 .x_80c53a0c{color:#fbb03b;}@media screen and (max-width:400px){:root{font-size:4vw;}}@media screen and (min-width:401px) and (max-width:767px){:root{font-size:16px;}}@media screen and (min-width:768px) and (max-width:1200px){:root{font-size:1.33vw;}}@media screen and (max-width:767px){.hidden-mobile{display:none;}}@media screen and (min-width:768px){.section-fit{max-width:60rem;}#page-block-l3qivrhmtw{height:50.5625rem;max-width:100%;}#page-block-l3qivrhmtw .section-holder-border{border:0;}#page-block-l3qivrhmtw .section-block{background:none;height:50.5625rem;}#page-block-l3qivrhmtw .section-holder-overlay{display:none;}#element-290{top:3.25rem;left:0;height:64.75rem;width:59.9375rem;z-index:3;}#element-290 .shape{border:0;background:rgb(251,176,59);}#element-291{top:0.5625rem;left:27.5625rem;height:30.3125rem;width:35.25rem;z-index:4;}#element-291 .cropped{background:url(../<?php echo $info->s1_product_image ?>) 0 -1.625rem / 35.875rem 33.75rem;}#element-292{top:20.1875rem;left:3rem;height:5.1875rem;width:23.125rem;z-index:5;color:#37465A;font-size:1.2384rem;line-height:1.75rem;text-align:left;}#element-292 .x_ee409d31{text-align:left;letter-spacing:0px;line-height:1.75rem;font-size:1.2384rem;}#element-292 .x_7b2817bf{color:#000000;}#element-292 .contents{font-size:1.2384rem!important;line-height:1.75rem!important;color:rgb(55,70,90)!important;width:23.125rem!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:400!important;height:auto;}#element-292 .contents p{line-height:1.75rem!important;font-size:1.2384rem!important;letter-spacing:0px!important;}#element-292 strong{font-weight:700;}#element-293{top:6.25rem;left:3rem;height:13rem;width:31.4375rem;z-index:6;color:#37465A;font-size:4.9536rem;line-height:5rem;text-align:left;font-weight:900;}#element-293 .x_d4149e5e{text-align:left;line-height:5rem;font-size:4.9536rem;}#element-293 .x_7b2817bf{color:#000000;}#element-293 .contents{font-size:4.9536rem!important;line-height:5rem!important;color:rgb(55,70,90)!important;width:31.4375rem!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;height:auto;}#element-293 .contents p{line-height:4.375rem!important;font-size:4.9536rem!important;letter-spacing:-5px!important;}#element-293 strong{font-weight:900;}#element-293.paragraph{font-weight:900;}#element-294{top:42.9375rem;left:4.0625rem;height:5.125rem;width:5.4375rem;z-index:26;}#element-295{top:44.625rem;left:14rem;height:1.5rem;width:2.0625rem;z-index:27;}#element-296{top:42.9375rem;left:21.5625rem;height:5.125rem;width:4.4375rem;z-index:28;}#element-297{top:43.5625rem;left:32.25rem;height:3.5625rem;width:2.6875rem;z-index:29;}#element-299{top:44.75rem;left:41.9375rem;height:1.25rem;width:1.8125rem;z-index:30;}#element-300{top:42.4375rem;left:48.625rem;height:6rem;width:5.25rem;z-index:31;}#element-301{top:0.9375rem;left:3rem;height:1.875rem;width:5rem;z-index:66;}#element-302{top:33.1875rem;left:37.1875rem;height:4.25rem;width:16.625rem;z-index:67;font-size:4.25rem;}.timer-box{font-size:.6em;}.timer-date{height:auto;}#element-302 .timer-box{color:#e55211;background-color:#f9f9f9;}#element-302 .timer-labels{color:#f65b00;}#element-303{top:36.3125rem;left:3rem;height:2.5rem;width:23rem;z-index:72;}#element-303 .btn.btn-effect3d:active{box-shadow:none;}#element-303 .btn:hover{background:#BA3B03;color:#FFFFFF;}#element-303 .btn{background:linear-gradient(#FF791E,#F65B00 50%);color:#FFFFFF;font-size:0.9907rem;font-family:"objektiv-mk3-1","objektiv-mk3-2",sans-serif;font-weight:900;height:2.5rem;width:23rem;border-radius:14px;}#element-124{top:29.5625rem;left:3rem;height:2.25rem;width:14.125rem;z-index:114;color:#37465A;font-size:3.096rem;line-height:5rem;text-align:left;font-weight:900;}#element-124 .x_68437d79{text-align:left;letter-spacing:-2px;line-height:2.1875rem;font-size:3.096rem;}#element-124 .x_0e1fbe45{color:#f15a24;}#element-124 .contents{font-size:4.9536rem!important;line-height:8rem!important;color:rgb(55,70,90)!important;width:14.125rem!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;height:2.1875rem!important;}#element-124 .contents p{line-height:2.1875rem!important;font-size:2.5rem!important;letter-spacing:-2px!important;}#element-124 strong{font-weight:900;}#element-124.paragraph{font-weight:900;}#element-132{top:26.5625rem;left:3rem;height:2.75rem;width:8.75rem;z-index:115;color:#37465A;font-size:1.7337rem;line-height:2.8rem;text-align:left;font-weight:400;}#element-132 .x_30e7fb47{text-align:left;line-height:2.75rem;font-size:1.712rem;}#element-132 .x_7b2817bf{color:#000000;}#element-132 strong{font-weight:700;}#element-132.paragraph{font-weight:400;}#element-134{top:27.3125rem;left:3.125rem;height:1.25rem;width:8.25rem;z-index:117;}#element-134 .shape{border-bottom:1px dotted #000000;}#element-284{top:32.5rem;left:3.1875rem;height:1.625rem;width:14.25rem;z-index:119;color:#37465A;font-size:0.9907rem;line-height:1.6rem;text-align:left;}#element-284 .x_3579aa00{text-align:left;line-height:1.625rem;font-size:0.9907rem;}#element-284 .x_7b2817bf{color:#000000;}#page_block_below_fold{height:81.25rem;max-width:100%;}#page_block_below_fold .section-holder-border{border:0;}#page_block_below_fold .section-block{background:none;height:81.25rem;}#page_block_below_fold .section-holder-overlay{display:none;}#element-18{top:-1.625rem;left:0;height:20.1875rem;width:59.9375rem;z-index:7;}#element-19{top:4.625rem;left:4.0625rem;height:10.8125rem;width:26.75rem;z-index:8;color:#37465A;font-size:2.4768rem;line-height:2.5rem;text-align:left;font-weight:800;}#element-19 .x_e985c108{text-align:left;line-height:2.5rem;font-size:2.4768rem;}#element-19 .x_7b2817bf{color:#000000;}#element-19 .contents{font-size:2.4768rem!important;line-height:2.5rem!important;color:rgb(55,70,90)!important;width:26.6875rem!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:800!important;height:auto;}#element-19 .contents p{line-height:2.1875rem!important;font-size:2.4768rem!important;}#element-19 strong{font-weight:800;}#element-19.paragraph{font-weight:800;}#element-22{top:18.4375rem;left:-0.0625rem;height:38.9375rem;width:60rem;z-index:9;}#element-22 .shape{border:0;background:rgb(0,0,0);}#element-24{top:17.25rem;left:4.0625rem;height:2.25rem;width:9.5rem;z-index:10;}#element-24 .shape{border:0.0625rem solid #A3BAC6;background:rgb(240,243,245);}#element-23{top:17.75rem;left:5rem;height:1.625rem;width:8rem;z-index:11;color:#37465A;font-size:0.9907rem;line-height:1.6rem;text-align:left;font-weight:700;}#element-23 .x_3579aa00{text-align:left;line-height:1.625rem;font-size:0.9907rem;}#element-23 .x_7b2817bf{color:#000000;}#element-23 strong{font-weight:700;}#element-23.paragraph{font-weight:700;}#element-26{top:23.0625rem;left:4.0625rem;height:19.5rem;width:32.875rem;z-index:12;}element-26 iframe{width:526px;height:312px;}#element-28{top:27.4375rem;left:42.375rem;height:1.25rem;width:10.5rem;z-index:13;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-28 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-28 .x_f2074b6c{color:#ffffff;}#element-29{top:25.4375rem;left:42.375rem;height:2.625rem;width:10.5rem;z-index:14;color:#37465A;font-size:1.6099rem;line-height:2.6rem;text-align:left;font-weight:900;}#element-29 .x_f4b5a1e3{text-align:left;line-height:2.625rem;font-size:1.6099rem;}#element-29 .x_80c53a0c{color:#fbb03b;}#element-29 strong{font-weight:900;}#element-29.paragraph{font-weight:900;}#element-33{top:32.4375rem;left:42.375rem;height:1.25rem;width:10.5rem;z-index:15;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-33 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-33 .x_f2074b6c{color:#ffffff;}#element-35{top:30.4375rem;left:42.375rem;height:2.625rem;width:10.5rem;z-index:16;color:#37465A;font-size:1.6099rem;line-height:2.6rem;text-align:left;font-weight:900;}#element-35 .x_f4b5a1e3{text-align:left;line-height:2.625rem;font-size:1.6099rem;}#element-35 .x_80c53a0c{color:#fbb03b;}#element-35 strong{font-weight:900;}#element-35.paragraph{font-weight:900;}#element-39{top:37.5rem;left:42.375rem;height:2.5625rem;width:10.5rem;z-index:17;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-39 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-39 .x_f2074b6c{color:#ffffff;}#element-41{top:35.5rem;left:42.375rem;height:2.625rem;width:10.5rem;z-index:18;color:#37465A;font-size:1.6099rem;line-height:2.6rem;text-align:left;font-weight:900;}#element-41 .x_f4b5a1e3{text-align:left;line-height:2.625rem;font-size:1.6099rem;}#element-41 .x_80c53a0c{color:#fbb03b;}#element-41 strong{font-weight:900;}#element-41.paragraph{font-weight:900;}#element-48{top:57.375rem;left:24.0625rem;height:39.375rem;width:35.9375rem;z-index:19;}#element-48 .shape{border:0;background:rgb(240,243,245);}#element-46{top:57.375rem;left:0;height:39.375rem;width:60.9375rem;z-index:20;}#element-46 .cropped{background:url(../<?php echo $info->s4_image ?>) -1.9375rem 0 / 62.875rem 39.375rem;}#element-47{top:68.125rem;left:5.3125rem;height:13rem;width:23.125rem;z-index:21;color:#37465A;font-size:2.4768rem;line-height:2.5rem;text-align:left;font-weight:900;}#element-47 .x_a33937de{text-align:left;line-height:2.1875rem;font-size:2.4768rem;}#element-47 .x_80c53a0c{color:#fbb03b;}#element-47 .contents{font-size:2.4768rem!important;line-height:2.5rem!important;color:rgb(55,70,90)!important;width:23.125rem!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;height:auto;}#element-47 .contents p{line-height:2.1875rem!important;font-size:2.4768rem!important;}#element-47 strong{font-weight:900;}#element-47.paragraph{font-weight:900;}#element-57{top:68.125rem;left:40.125rem;height:1.25rem;width:17.75rem;z-index:37;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-57 .x_2c6a6bea{text-align:left;line-height:1.3125rem;font-size:0.8064rem;}#element-57 .x_c24cab30{color:#6f6f6f;}#element-59{top:66.3125rem;left:40.125rem;height:1.75rem;width:7.4375rem;z-index:38;color:#37465A;font-size:1.1165rem;line-height:1.8032rem;text-align:left;font-weight:900;}#element-59 .x_60c047dd{text-align:left;line-height:1.8125rem;font-size:1.1165rem;}#element-59 .x_7b2817bf{color:#000000;}#element-59 strong{font-weight:900;}#element-59.headline{font-weight:900;}#element-62{top:71.25rem;left:40.125rem;height:1.25rem;width:17.75rem;z-index:39;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-62 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-62 .x_c24cab30{color:#6f6f6f;}#element-64{top:69.4375rem;left:40.125rem;height:1.75rem;width:8.8125rem;z-index:40;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:left;font-weight:900;}#element-64 .x_8ae9aa76{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-64 .x_7b2817bf{color:#000000;}#element-64 strong{font-weight:900;}#element-64.headline{font-weight:900;}#element-68{top:74.375rem;left:40.125rem;height:1.25rem;width:17.75rem;z-index:41;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-68 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-68 .x_c24cab30{color:#6f6f6f;}#element-70{top:72.5625rem;left:40.125rem;height:1.75rem;width:8.8125rem;z-index:42;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:left;font-weight:900;}#element-70 .x_8ae9aa76{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-70 .x_7b2817bf{color:#000000;}#element-70 strong{font-weight:900;}#element-70.headline{font-weight:900;}#element-74{top:77.8125rem;left:40.125rem;height:1.25rem;width:17.75rem;z-index:43;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-74 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-74 .x_c24cab30{color:#6f6f6f;}#element-76{top:75.6875rem;left:40.125rem;height:1.75rem;width:8.8125rem;z-index:44;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:left;font-weight:900;}#element-76 .x_8ae9aa76{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-76 .x_7b2817bf{color:#000000;}#element-76 strong{font-weight:900;}#element-76.headline{font-weight:900;}#element-81{top:79.5625rem;left:40.125rem;height:1.75rem;width:8.8125rem;z-index:46;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:left;font-weight:900;}#element-81 .x_8ae9aa76{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-81 .x_7b2817bf{color:#000000;}#element-81 strong{font-weight:900;}#element-81.headline{font-weight:900;}#element-165{top:61.875rem;left:40.125rem;height:1.25rem;width:17.75rem;z-index:53;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-165 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-165 .x_c24cab30{color:#6f6f6f;}#element-167{top:60.0625rem;left:40.125rem;height:1.75rem;width:5.5rem;z-index:54;color:#37465A;font-size:1.1146rem;line-height:1.8rem;font-weight:900;}#element-167 .x_8ae9aa76{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-167 .x_7b2817bf{color:#000000;}#element-167 strong{font-weight:900;}#element-167.headline{font-weight:900;}#element-170{top:65rem;left:40.125rem;height:1.25rem;width:17.75rem;z-index:55;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-170 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-170 .x_c24cab30{color:#6f6f6f;}#element-172{top:63.1875rem;left:40.125rem;height:1.75rem;width:5.5rem;z-index:56;color:#37465A;font-size:1.1146rem;line-height:1.8rem;font-weight:900;}#element-172 .x_8ae9aa76{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-172 .x_7b2817bf{color:#000000;}#element-172 strong{font-weight:900;}#element-172.headline{font-weight:900;}#element-217{top:45.6875rem;left:4.0625rem;height:3.4375rem;width:3.25rem;z-index:74;}#element-218{top:45.6875rem;left:14.625rem;height:3.4375rem;width:3.875rem;z-index:75;}#element-219{top:45.75rem;left:26.3125rem;height:3.25rem;width:4.5625rem;z-index:76;}#element-220{top:45.75rem;left:38.6875rem;height:3.25rem;width:4.1875rem;z-index:77;}#element-221{top:45.75rem;left:51.125rem;height:3.5rem;width:3.75rem;z-index:78;}#element-223{top:50.75rem;left:4.0625rem;height:2rem;width:6.3125rem;z-index:79;color:#37465A;font-size:0.805rem;line-height:0.975rem;text-align:left;}#element-223 .x_70b443d1{text-align:left;line-height:1rem;font-size:0.805rem;}#element-223 .x_f2074b6c{color:#ffffff;}#element-224{top:50.75rem;left:15.1875rem;height:3rem;width:8.75rem;z-index:80;color:#37465A;font-size:0.805rem;line-height:0.975rem;text-align:left;}#element-224 .x_70b443d1{text-align:left;line-height:1rem;font-size:0.805rem;}#element-224 .x_f2074b6c{color:#ffffff;}#element-225{top:50.75rem;left:26.3125rem;height:2rem;width:8.875rem;z-index:81;color:#37465A;font-size:0.805rem;line-height:0.975rem;text-align:left;}#element-225 .x_70b443d1{text-align:left;line-height:1rem;font-size:0.805rem;}#element-225 .x_f2074b6c{color:#ffffff;}#element-226{top:50.75rem;left:38.75rem;height:2rem;width:8.75rem;z-index:82;color:#37465A;font-size:0.805rem;line-height:0.975rem;text-align:left;}#element-226 .x_70b443d1{text-align:left;line-height:1rem;font-size:0.805rem;}#element-226 .x_f2074b6c{color:#ffffff;}#element-227{top:50.75rem;left:51.125rem;height:2rem;width:8.875rem;z-index:83;color:#37465A;font-size:0.805rem;line-height:0.975rem;text-align:left;}#element-227 .x_70b443d1{text-align:left;line-height:1rem;font-size:0.805rem;}#element-227 .x_f2074b6c{color:#ffffff;}#page_block_footer{height:128.4375rem;max-width:100%;}#page_block_footer .section-holder-border{border:0;}#page_block_footer .section-block{background:none;height:128.4375rem;}#page_block_footer .section-holder-overlay{display:none;}#element-93{top:15.4375rem;left:0;height:29.125rem;width:59.9375rem;z-index:22;}#element-93 .shape{border:0;background:rgb(255,255,255);}#element-95{top:21rem;left:5.4375rem;height:4rem;width:55.375rem;z-index:23;color:#37465A;font-size:2.4768rem;line-height:4rem;text-align:left;font-weight:900;}#element-95 .x_49caa87c{text-align:left;line-height:4rem;font-size:2.4768rem;}#element-95 .x_80c53a0c{color:#fbb03b;}#element-95 .contents{font-size:2.4768rem!important;line-height:4rem!important;color:rgb(55,70,90)!important;width:55.375rem!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;height:auto;}#element-95 .contents p{line-height:4rem!important;font-size:2.4768rem!important;letter-spacing:-2px!important;}#element-95 strong{font-weight:900;}#element-95.headline{font-weight:900;}#element-98{top:44.375rem;left:0;height:86.25rem;width:59.9375rem;z-index:25;}#element-98 .shape{border:0;background:rgb(0,0,0);}#element-151{top:49.75rem;left:32.125rem;height:3rem;width:23.25rem;z-index:34;color:#37465A;font-size:1.4861rem;line-height:1.5rem;text-align:left;font-weight:900;}#element-151 .x_275d245b{text-align:left;line-height:1.5rem;font-size:1.4861rem;}#element-151 .x_f2074b6c{color:#ffffff;}#element-151 .x_80c53a0c{color:#fbb03b;}#element-151 strong{font-weight:900;}#element-151.headline{font-weight:900;}#element-153{top:119.25rem;left:7.1875rem;height:3rem;width:45.5625rem;z-index:35;color:#37465A;font-size:1.2384rem;line-height:1.5rem;text-align:center;font-weight:400;}#element-153 .x_bdb4a4e4{text-align:center;line-height:1.5rem;font-size:1.2384rem;}#element-153 .x_80c53a0c{color:#fbb03b;}#element-153 strong{font-weight:700;}#element-153.headline{font-weight:400;}#element-79{top:0.125rem;left:40.125rem;height:1.25rem;width:17.75rem;z-index:45;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-79 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-79 .x_c24cab30{color:#6f6f6f;}#element-84{top:3.75rem;left:40.125rem;height:1.25rem;width:17.75rem;z-index:47;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-84 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-84 .x_c24cab30{color:#6f6f6f;}#element-86{top:1.9375rem;left:40.125rem;height:1.75rem;width:8.8125rem;z-index:48;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:left;font-weight:900;}#element-86 .x_8ae9aa76{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-86 .x_7b2817bf{color:#000000;}#element-86 strong{font-weight:900;}#element-86.headline{font-weight:900;}#element-89{top:6.875rem;left:40.125rem;height:1.25rem;width:17.75rem;z-index:49;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-89 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-89 .x_c24cab30{color:#6f6f6f;}#element-91{top:5.0625rem;left:40.125rem;height:1.75rem;width:8.8125rem;z-index:50;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:left;font-weight:900;}#element-91 .x_8ae9aa76{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-91 .x_7b2817bf{color:#000000;}#element-91 strong{font-weight:900;}#element-91.headline{font-weight:900;}#element-160{top:10.375rem;left:40.125rem;height:1.25rem;width:17.75rem;z-index:51;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-160 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-160 .x_c24cab30{color:#6f6f6f;}#element-162{top:8.5625rem;left:40.125rem;height:1.75rem;width:8.8125rem;z-index:52;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:left;font-weight:900;}#element-162 .x_8ae9aa76{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-162 .x_7b2817bf{color:#000000;}#element-162 strong{font-weight:900;}#element-162.headline{font-weight:900;}#element-173{top:49.125rem;left:6.6875rem;height:4.25rem;width:3.625rem;z-index:57;}#element-104{top:84.8125rem;left:5.75rem;height:3.5rem;width:31.4375rem;z-index:58;color:#37465A;font-size:0.743rem;line-height:1.2rem;text-align:left;}#element-104 .x_4cb1d84e{text-align:left;line-height:1.1875rem;font-size:0.743rem;}#element-104 .x_1a2319a0{text-align:justify;line-height:1.1875rem;font-size:0.743rem;}#element-104 .x_199030dd{color:#dddddd;}#element-106{top:82.625rem;left:27.5rem;height:1.5625rem;width:9.75rem;z-index:59;color:#37465A;font-size:0.805rem;line-height:0.8125rem;text-align:left;font-weight:400;}#element-106 .x_c9387aab{text-align:left;line-height:0.8125rem;font-size:0.805rem;}#element-106 .x_1952c174{text-align:right;line-height:0.8125rem;font-size:0.805rem;}#element-106 .x_65831597{color:#fbfbfb;}#element-106 strong{font-weight:700;}#element-106.headline{font-weight:400;}#element-146{top:89.0625rem;left:31.1875rem;height:1.0625rem;width:5.75rem;z-index:60;}#element-175{top:77.25rem;left:38.0625rem;height:18.6875rem;width:18.75rem;z-index:61;}#element-103{top:64.125rem;left:27.1875rem;height:7rem;width:26.25rem;z-index:62;color:#37465A;font-size:0.743rem;line-height:1.2rem;text-align:left;}#element-103 .x_4cb1d84e{text-align:left;line-height:1.1875rem;font-size:0.743rem;}#element-103 .x_1a2319a0{text-align:justify;line-height:1.1875rem;font-size:0.743rem;}#element-103 .x_199030dd{color:#dddddd;}#element-107{top:61.75rem;left:27.375rem;height:1.5625rem;width:9.6875rem;z-index:63;color:#37465A;font-size:0.805rem;line-height:0.8125rem;text-align:left;font-weight:400;}#element-107 .x_c9387aab{text-align:left;line-height:0.8125rem;font-size:0.805rem;}#element-107 .x_87ee4901{text-align:left;line-height:0.8125rem;font-size:0.805rem;}#element-107 .x_65831597{color:#fbfbfb;}#element-107 strong{font-weight:700;}#element-107.headline{font-weight:400;}#element-147{top:71.75rem;left:27.1875rem;height:1rem;width:5.75rem;z-index:64;}#element-176{top:58.125rem;left:6.6875rem;height:18.75rem;width:18.6875rem;z-index:65;}#element-102{top:104.875rem;left:26.625rem;height:5.8125rem;width:29.8125rem;z-index:68;color:#37465A;font-size:0.743rem;line-height:1.2rem;text-align:left;}#element-102 .x_4cb1d84e{text-align:left;line-height:1.1875rem;font-size:0.743rem;}#element-102 .x_1a2319a0{text-align:justify;line-height:1.1875rem;font-size:0.743rem;}#element-102 .x_199030dd{color:#dddddd;}#element-105{top:102.375rem;left:26.4375rem;height:1.5625rem;width:9.6875rem;z-index:69;color:#37465A;font-size:0.805rem;line-height:0.8125rem;text-align:left;font-weight:400;}#element-105 .x_c9387aab{text-align:left;line-height:0.8125rem;font-size:0.805rem;}#element-105 .x_87ee4901{text-align:left;line-height:0.8125rem;font-size:0.805rem;}#element-105 .x_65831597{color:#fbfbfb;}#element-105 strong{font-weight:700;}#element-105.headline{font-weight:400;}#element-148{top:112.25rem;left:26.625rem;height:1.0625rem;width:5.8125rem;z-index:70;}#element-177{top:95.9375rem;left:5.4375rem;height:18.6875rem;width:18.6875rem;z-index:71;}#element-193{top:26.0625rem;left:3.3125rem;height:18.3125rem;width:55.25rem;z-index:73;}#element-228{top:49.75rem;left:11.9375rem;height:3rem;width:12.0625rem;z-index:84;color:#37465A;font-size:1.4861rem;line-height:1.5rem;text-align:left;font-weight:900;}#element-228 .x_275d245b{text-align:left;line-height:1.5rem;font-size:1.4861rem;}#element-228 .x_f2074b6c{color:#ffffff;}#element-228 .x_80c53a0c{color:#fbb03b;}#element-228 strong{font-weight:900;}#element-228.headline{font-weight:900;}#element-229{top:49.125rem;left:27.3125rem;height:4.25rem;width:3.625rem;z-index:85;}#element-420{top:14.1875rem;left:39.75rem;height:2.5rem;width:14.5rem;z-index:166;}#element-420 .btn.btn-effect3d:active{box-shadow:none;}#element-420 .btn:hover{background:#BA3B03;color:#FFFFFF;}#element-420 .btn{background:linear-gradient(#FF791E,#F65B00 50%);color:#FFFFFF;font-size:0.9907rem;font-family:"objektiv-mk3-1","objektiv-mk3-2",sans-serif;font-weight:900;height:2.5rem;width:14.5rem;border-radius:14px;}#page-block-i82xvkz7ji{height:50.75rem;max-width:100%;}#page-block-i82xvkz7ji .section-holder-border{border:0;}#page-block-i82xvkz7ji .section-block{background:none;height:50.75rem;}#page-block-i82xvkz7ji .section-holder-overlay{display:none;}#element-395{top:2.25rem;left:0;height:48.625rem;width:59.9375rem;z-index:150;}#element-395 .shape{border:0;background:rgb(251,176,59);}#element-394{top:-3.75rem;left:9rem;height:30.0625rem;width:44.375rem;z-index:151;}#element-396{top:25.25rem;left:0;height:25.625rem;width:26.875rem;z-index:152;}#element-397{top:25.25rem;left:26.875rem;height:25.625rem;width:33.0625rem;z-index:153;}#element-397 .shape{border:0;background:rgb(246,225,222);}#element-398{top:28.5rem;left:30.75rem;height:6.6875rem;width:16.6875rem;z-index:154;color:#37465A;font-size:2.2291rem;line-height:2.25rem;text-align:left;font-weight:900;}#element-398 .x_9b7a1e0d{text-align:left;line-height:2.25rem;font-size:2.2291rem;}#element-398 .x_7b2817bf{color:#000000;}#element-398 strong{font-weight:900;}#element-398.headline{font-weight:900;}#element-399{top:26.6875rem;left:31.0625rem;height:1.75rem;width:12.25rem;z-index:155;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:left;font-weight:800;}#element-399 .x_8ae9aa76{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-399 .x_7b2817bf{color:#000000;}#element-399 strong{font-weight:800;}#element-399.headline{font-weight:800;}#element-400{top:36.5rem;left:30.6875rem;height:5.3125rem;width:25.25rem;z-index:157;color:#37465A;font-size:0.8669rem;line-height:1.4rem;text-align:left;}#element-400 .x_48aa50a2{text-align:left;line-height:1.375rem;font-size:0.8669rem;}#element-400 .x_7b2817bf{color:#000000;}#element-400 strong{font-weight:700;}#element-401{top:46.8125rem;left:30.6875rem;height:2.5rem;width:12.1875rem;z-index:158;}#element-401 .btn.btn-effect3d:active{box-shadow:none;}#element-401 .btn:hover{background:#BA3B03;color:#FFFFFF;}#element-401 .btn{background:linear-gradient(#FF791E,#F65B00 50%);color:#FFFFFF;font-size:0.9907rem;font-family:"objektiv-mk3-1","objektiv-mk3-2",sans-serif;font-weight:900;height:2.5rem;width:12.1875rem;border-radius:14px;}#element-402{top:43.9375rem;left:30.75rem;height:1.3125rem;width:25.25rem;z-index:159;color:#37465A;font-size:0.8669rem;line-height:1.4rem;text-align:left;}#element-402 .x_48aa50a2{text-align:left;line-height:1.375rem;font-size:0.8669rem;}#element-402 .x_7b2817bf{color:#000000;}#page-block-5643epclur5{height:97.25rem;max-width:100%;}#page-block-5643epclur5 .section-holder-border{border:0;}#page-block-5643epclur5 .section-block{background:none;height:97.25rem;}#page-block-5643epclur5 .section-holder-overlay{display:none;}#element-380{top:12.625rem;left:0;height:61.375rem;width:59.9375rem;z-index:86;}#element-380 .shape{border:0;background:rgb(251,176,59);}#element-361{top:0;left:0;height:12.625rem;width:59.9375rem;z-index:87;}#element-361 .shape{border:0;background:rgb(240,243,245);}#element-363{top:15.0625rem;left:5.3125rem;height:5.3125rem;width:48.25rem;z-index:88;color:#37465A;font-size:0.8669rem;line-height:1.4rem;text-align:left;}#element-363 .x_48aa50a2{text-align:left;line-height:1.375rem;font-size:0.8669rem;}#element-363 .x_7b2817bf{color:#000000;}#element-362{top:2.5625rem;left:5.0625rem;height:7.5rem;width:52.75rem;z-index:89;color:#37465A;font-size:2.4768rem;line-height:2.5rem;text-align:left;font-weight:900;}#element-362 .x_e985c108{text-align:left;line-height:2.5rem;font-size:2.4768rem;}#element-362 .x_7b2817bf{color:#000000;}#element-362 .contents{font-size:2.4768rem!important;line-height:2.5rem!important;color:rgb(55,70,90)!important;width:52.75rem!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;height:auto;}#element-362 .contents p{line-height:2.5rem!important;font-size:2.4768rem!important;letter-spacing:-1px!important;}#element-362 strong{font-weight:900;}#element-362.headline{font-weight:900;}#element-367{top:25.75rem;left:28.625rem;height:43.5rem;width:31.3125rem;z-index:92;}#element-367 .cropped{background:url(../<?php echo $info->s9_image ?>) 0 0 / 35.25rem 43.5rem;}#element-366{top:28.5rem;left:0;height:1.375rem;width:59.9375rem;z-index:93;}#element-366 .shape{border-bottom:2px dotted #FBFBFB;}#element-364{top:25.75rem;left:4.875rem;height:6.625rem;width:13.25rem;z-index:94;}#element-364 .shape{border:0;background:rgb(241,90,36);}#element-365{top:26.8125rem;left:6rem;height:4.6875rem;width:11.4375rem;z-index:95;color:#37465A;font-size:0.9907rem;line-height:1.2rem;text-align:left;font-weight:700;}#element-365 .x_178925bc{text-align:left;line-height:1.1875rem;font-size:0.9907rem;}#element-365 .x_f2074b6c{color:#ffffff;}#element-365 strong{font-weight:700;}#element-365.paragraph{font-weight:700;}#element-368{top:41.875rem;left:3.5rem;height:21.25rem;width:25.125rem;z-index:98;color:#37465A;font-size:0.8669rem;line-height:1.4rem;text-align:left;}#element-368 .x_48aa50a2{text-align:left;line-height:1.375rem;font-size:0.8669rem;}#element-368 .x_e1c17884{color:#000001;}#element-368 strong{font-weight:700;}#element-371{top:33.25rem;left:4.875rem;height:8rem;width:24.5625rem;z-index:99;color:#37465A;font-size:1.9814rem;line-height:2rem;text-align:left;font-weight:900;}#element-371 .x_df21e2f7{text-align:left;line-height:2rem;font-size:1.9814rem;}#element-371 .x_f2074b6c{color:#ffffff;}#element-371 strong{font-weight:900;}#element-371.headline{font-weight:900;}#element-381{top:64.6875rem;left:5.6875rem;height:2.5rem;width:16.25rem;z-index:102;}#element-381 .btn.btn-effect3d:active{box-shadow:none;}#element-381 .btn:hover{background:#BA3B03;color:#FFFFFF;}#element-381 .btn{background:linear-gradient(#FF791E,#F65B00 50%);color:#FFFFFF;font-size:0.9907rem;font-family:"objektiv-mk3-1","objektiv-mk3-2",sans-serif;font-weight:900;height:2.5rem;width:16.25rem;border-radius:14px;}#element-370{top:69.3125rem;left:0;height:28.0625rem;width:59.9375rem;z-index:103;}#element-370 .shape{border:0;background:rgb(0,0,0);}#element-369{top:79.25rem;left:34.875rem;height:12.0625rem;width:21.6875rem;z-index:104;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-369 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-369 .x_f2074b6c{color:#ffffff;}#element-369 .x_6ab41614{text-align:left;color:rgb(255,255,255);}#element-369 strong{font-weight:700;}#element-373{top:73.375rem;left:9.25rem;height:6.5rem;width:5.75rem;z-index:105;}#element-375{top:73.375rem;left:22.5rem;height:6.6875rem;width:5.5625rem;z-index:107;}#element-376{top:83.3125rem;left:7rem;height:2.6875rem;width:3.75rem;z-index:108;}#element-377{top:81.8125rem;left:16.25rem;height:5.75rem;width:4.25rem;z-index:109;}#element-378{top:83.3125rem;left:26.25rem;height:2.6875rem;width:3.6875rem;z-index:110;}#element-372{top:73.875rem;left:34.8125rem;height:3rem;width:21.375rem;z-index:111;color:#37465A;font-size:1.2384rem;line-height:1.5rem;text-align:left;font-weight:900;}#element-372 .x_7be91d29{text-align:left;line-height:1.5rem;font-size:1.2384rem;}#element-372 .x_f2074b6c{color:#ffffff;}#element-372 strong{font-weight:900;}#element-372.headline{font-weight:900;}#element-379{top:71.3125rem;left:34.8125rem;height:1.75rem;width:5rem;z-index:113;}#page-block-ceqi3wwonu8{height:70.25rem;max-width:100%;}#page-block-ceqi3wwonu8 .section-holder-border{border:0;}#page-block-ceqi3wwonu8 .section-block{background:none;height:70.25rem;}#page-block-ceqi3wwonu8 .section-holder-overlay{display:none;}#element-343{top:50.8125rem;left:0;height:3.5625rem;width:59.9375rem;z-index:24;}#element-343 .shape{border:0;background:rgb(0,0,0);}#element-321{top:0.125rem;left:0;height:50.875rem;width:59.9375rem;z-index:36;}#element-321 .shape{border:0;background:rgb(255,255,255);}#element-330{top:54.375rem;left:0;height:15.875rem;width:59.875rem;z-index:120;}#element-330 .shape{border:0;background:rgb(251,176,59);}#element-341{top:16.625rem;left:15.5rem;height:8.5rem;width:19.25rem;z-index:121;}#element-338{top:6.8125rem;left:2.75rem;height:21.1875rem;width:22.25rem;z-index:122;}#element-328{top:51.875rem;left:5.3125rem;height:2.5rem;width:20.625rem;z-index:123;color:#37465A;font-size:1.2384rem;line-height:1.25rem;text-align:left;font-weight:900;}#element-328 .x_4a9c0ff4{text-align:left;letter-spacing:-1px;line-height:1.25rem;font-size:1.2384rem;}#element-328 .x_0e1fbe45{color:#f15a24;}#element-328 .contents{font-size:1.2384rem!important;line-height:1.25rem!important;color:rgb(55,70,90)!important;width:20.625rem!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;height:2.5rem!important;}#element-328 .contents p{letter-spacing:-1px!important;line-height:1.25rem!important;font-size:1.2384rem!important;}#element-328 strong{font-weight:900;}#element-328.headline{font-weight:900;}#element-333{top:58.875rem;left:5.5625rem;height:5.9375rem;width:6.25rem;z-index:124;}#element-332{top:61.4375rem;left:16.4375rem;height:1.75rem;width:2.375rem;z-index:125;}#element-331{top:59.375rem;left:23.75rem;height:5.9375rem;width:5.25rem;z-index:126;}#element-334{top:60.25rem;left:35.5625rem;height:4.0625rem;width:3rem;z-index:127;}#element-336{top:61.5625rem;left:44.9375rem;height:1.5rem;width:2.125rem;z-index:129;}#element-337{top:58.875rem;left:50.25rem;height:6.9375rem;width:5.9375rem;z-index:130;}#element-342{top:49.4375rem;left:36.625rem;height:4.125rem;width:16.75rem;z-index:132;font-size:4.125rem;}#element-342 .timer-box{color:#e55211;background-color:#f9f9f9;}#element-342 .timer-labels{color:#f65b00;}#element-319{top:2.4375rem;left:34.1875rem;height:40.375rem;width:21.75rem;z-index:133;}#element-319 .shape{border:0.0625rem solid #A3BAC6;border-radius:0.5rem 0.5rem 0.5rem 0.5rem;background:rgb(255,255,255);}#element-317{top:3.4375rem;left:36.0625rem;height:36.8125rem;width:18.25rem;z-index:134;}.notification-text{font-size:3.125rem;}.form{font-size:0.8125rem;}.form-input{font-size:0.9375rem;height:2.6875rem;}.form-textarea{height:6.25rem;}.form-label-title{margin:0.3125rem 0 0.5rem;font-size:0.89375rem;padding:0;line-height:1.1875rem;}.form-multiple-label{margin-bottom:0.625rem;font-size:0.9375rem;line-height:1.1875rem;padding:0;}.form-multiple-label:empty{display:inline;}.form-checkbox-label:after{top:0.1rem;}.form-label-outside{margin-bottom:0;}.form-multiple-label:before{transition:background-color 0.1s,border 0.1s;}.form-radio-label:hover:before{border:0.3125rem solid #9bc7fd;}.form-messagebox{transform:translate(0);display:flex;}.form-messagebox-left{transform:translateX(-100%);left:-0.625rem;}.form-messagebox-right{transform:translateX(100%);right:-0.625rem;}.form-messagebox:before{top:calc(50% - 0.1875rem);left:auto;}.form-messagebox-left:before{right:-0.1875rem;}.form-messagebox-right:before{left:-0.1875rem;}#element-317 .btn.btn-effect3d:active{box-shadow:none;}#element-317 .btn-product-cart:hover{background:#C34B21;color:#FFFFFF;}#element-317 .btn-product-cart{background:linear-gradient(#FF7842,#F15A24 50%);color:#FFFFFF;font-size:1.1146rem;font-family:"objektiv-mk3-1","objektiv-mk3-2",sans-serif;font-weight:900;height:3.25rem;width:17.75rem;border-radius:15px;}#element-317 .form-label{color:#B4B4B4;}#element-317 ::placeholder{color:#B4B4B4;}#element-317 .form-input{color:#000000;background-color:#FFFFFF;border-color:#FBB03B;}#element-317 .user-invalid{border-color:#E12627;}#element-317 input::placeholder,#element-317 .form-label-inside{color:#B4B4B4;}#element-317 select.valid{color:#000000;}#element-317 .form-btn-geometry{top:37.5rem;left:0.375rem;height:3.25rem;width:17.75rem;z-index:134;}#element-320{top:46.1875rem;left:34.1875rem;height:1.25rem;width:12.25rem;z-index:135;color:#37465A;font-size:0.9288rem;line-height:1.3125rem;text-align:center;font-weight:800;}#element-320 .x_0d0d8539{text-align:center;line-height:1.3125rem;font-size:0.9288rem;}#element-320 .x_7b2817bf{color:#000000;}#element-320 strong{font-weight:800;}#element-320.paragraph{font-weight:800;}#element-329{top:45.25rem;left:52.75rem;height:2.25rem;width:3.4375rem;z-index:136;}#element-327{top:30.5rem;left:5.8125rem;height:6.25rem;width:20.9375rem;z-index:145;color:#37465A;font-size:3.096rem;line-height:3.125rem;text-align:left;font-weight:900;}#element-327 .x_bebc2881{text-align:left;letter-spacing:-3px;line-height:3.125rem;font-size:3.7152rem;}#element-327 .x_7b2817bf{color:#000000;}#element-327 .contents{font-size:2.4768rem!important;line-height:6.25rem!important;color:rgb(55,70,90)!important;width:20.9375rem!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;height:6.25rem!important;}#element-327 .contents p{line-height:3.125rem!important;font-size:3.096rem!important;letter-spacing:-3px!important;}#element-327 strong{font-weight:900;}#element-327.paragraph{font-weight:900;}#element-340{top:28.9375rem;left:5.8125rem;height:1.5625rem;width:4.25rem;z-index:146;}#element-322{top:-3.1875rem;left:5.125rem;height:11.625rem;width:27.875rem;z-index:148;}#element-322 .shape{border:0;background:rgb(255,255,255);}#element-323{top:-1.9375rem;left:6.5625rem;height:8.6875rem;width:26.375rem;z-index:149;color:#37465A;font-size:2.4768rem;line-height:2.5rem;text-align:left;font-weight:900;}#element-323 .x_38bba600{text-align:left;letter-spacing:-3px;line-height:2.1875rem;font-size:2.4768rem;}#element-323 .x_0e1fbe45{color:#f15a24;}#element-323 .contents{font-size:2.4768rem!important;line-height:2.5rem!important;color:rgb(55,70,90)!important;width:26.375rem!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;height:auto;}#element-323 .contents p{line-height:2.1875rem!important;font-size:2.4768rem!important;letter-spacing:-1px!important;}#element-323 strong{font-weight:900;}#element-323.headline{font-weight:900;}#element-348{top:42.1875rem;left:6rem;height:2.25rem;width:14.125rem;z-index:160;color:#37465A;font-size:3.096rem;line-height:5rem;font-weight:900;}#element-348 .x_7575f895{text-align:left;line-height:2.1875rem;font-size:3.096rem;letter-spacing:-2px;}#element-348 .x_0e1fbe45{color:#f15a24;}#element-348 .contents{font-size:4.9536rem!important;line-height:8rem!important;color:rgb(55,70,90)!important;width:14.125rem!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;height:2.1875rem!important;}#element-348 .contents p{line-height:2.1875rem!important;font-size:2.6rem!important;letter-spacing:-2px!important;}#element-348 strong{font-weight:900;}#element-348.paragraph{font-weight:900;}#element-350{top:39.1875rem;left:6rem;height:2.75rem;width:8.75rem;z-index:161;color:#37465A;font-size:1.7337rem;line-height:2.8rem;font-weight:400;}#element-350 .x_30e7fb47{text-align:left;line-height:2.75rem;font-size:1.712rem;}#element-350 .x_7b2817bf{color:#000000;}#element-350 strong{font-weight:700;}#element-350.paragraph{font-weight:400;}#element-352{top:39.9375rem;left:6rem;height:1.3125rem;width:8.125rem;z-index:163;}#element-352 .shape{border-bottom:1px dotted #000000;}#element-354{top:45.125rem;left:6.1875rem;height:1.625rem;width:14.25rem;z-index:165;color:#37465A;font-size:0.9907rem;line-height:1.6rem;}#element-354 .x_3579aa00{text-align:left;line-height:1.625rem;font-size:0.9907rem;}#element-354 .x_7b2817bf{color:#000000;}#page-block-j8wabyhcyyb{height:6.125rem;max-width:100%;}#page-block-j8wabyhcyyb .section-holder-border{border:0;}#page-block-j8wabyhcyyb .section-block{background:none;height:6.125rem;}#page-block-j8wabyhcyyb .section-holder-overlay{display:none;}#element-137{top:0;left:0;height:6.0625rem;width:59.9375rem;z-index:32;}#element-137 .shape{border:0;background:rgb(0,0,0);}#element-138{top:2.375rem;left:5.3125rem;height:1.25rem;width:51.1875rem;z-index:33;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-138 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-138 .x_70ee4658{text-align:center;line-height:1.3125rem;font-size:0.805rem;}#element-138 .x_80c53a0c{color:#fbb03b;}}@media all and (-ms-high-contrast:none),(-ms-high-contrast:active){.form-messagebox{height:auto !important;}} 
  </style>
<?php } else{ ?>
  <style type="text/css" media="screen">
    body{-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;margin:0;width:100%;font-family:Almarai;font-weight:400;background:url(../../<?php echo $info->image_background ?>) repeat-y rgb(255,255,255) 48% 0 / auto;}a{text-decoration:none;color:inherit;cursor:pointer;}a:not(.btn):hover{text-decoration:underline;}input,select,textarea,p,h1,h2,h3,h4,h5,h6{margin:0;font-size:inherit;font-weight:inherit;}main{overflow:hidden;}u > span{text-decoration:inherit;}ol,ul{padding-left:2.5rem;margin:.625rem 0;}p{word-wrap:break-word;}iframe{border:0;}*{box-sizing:border-box;}.item-absolute{position:absolute;}.item-relative{position:relative;}.item-block{display:block;height:100%;width:100%;}.item-cover{z-index:1000001;}.item-breakword{word-wrap:break-word;}.item-content-box{box-sizing:content-box;}.hidden{display:none;}.clearfix{clear:both;}@keyframes slide-down{from{opacity:0;transform:translateY(-50px);}}@keyframes fade-in{from{opacity:0;}}@supports (-webkit-overflow-scrolling:touch){@media (-webkit-min-device-pixel-ratio:2), (min-resolution:192dpi){.image[src$=".svg"]{width:calc(100% + 1px);}}}.headline{font-family:Almarai;font-weight:800;}.section-fit{max-width:400px;}.section-relative{position:relative;margin:0 auto;}.section-inner{height:100%;}#page-block-iyknujnh3rr{height:117.25rem;max-width:100%;}#page-block-iyknujnh3rr .section-holder-border{border:0;}#page-block-iyknujnh3rr .section-block{background:none;height:117.25rem;}#page-block-iyknujnh3rr .section-holder-overlay{display:none;}#element-298{top:4.125rem;left:0;height:113.25rem;width:24.9375rem;z-index:3;}.circle{border-radius:50%;}.shape{height:inherit;}.line-horizontal{height:.625rem;}.line-vertical{height:100%;margin-right:.625rem;}[class*='line-']{box-sizing:content-box;}#element-298 .shape{border:0;background:rgb(251,176,59);width:100%;height:100%;}#element-310{top:61.5625rem;left:2.6875rem;height:3.8125rem;width:19.75rem;z-index:4;font-size:3.8125rem;}@font-face{font-family:BebasNeue;font-style:normal;font-weight:400;src:url(https://v.fastcdn.co/a/font/bebasneue-webfont.eot);src:url(https://v.fastcdn.co/a/font/bebasneue-webfont.eot) format("embedded-opentype"),url(https://v.fastcdn.co/a/font/bebasneue-webfont.woff2) format("woff2"),url(https://v.fastcdn.co/a/font/bebasneue-webfont.woff) format("woff"),url(https://v.fastcdn.co/a/font/bebasneue-webfont.ttf) format("truetype");}.timer-column{width:20%;float:left;text-align:center;margin-left:5%;}.timer-column:first-child{width:25%;margin-left:0;}.timer-box{position:relative;font-size:.78em;margin-bottom:.12em;border-radius:5px;font-family:BebasNeue,sans-serif;height:100%;line-height:1.28em;}.timer-box:after,.timer-box:before{content:'';display:block;border-radius:50%;background-color:inherit;position:absolute;left:-.215em;width:.1em;height:.1em;}.timer-box:after{bottom:35%;}.timer-box:before{top:35%;}.timer-box:first-child:before,.timer-box:first-child:after{display:none;}.timer-number-zero{visibility:hidden;}.timer-text-none .timer-box{font-size:.78em;}.timer-text-bottom .timer-labels-top,.timer-text-top .timer-labels-bottom,.timer-text-none .timer-labels{display:none;}.timer-labels{text-transform:uppercase;margin-bottom:.18em;font-size:.13333em;position:relative;}.timer-label{padding-bottom:.1875rem;}#element-310 .timer-box{color:#e55211;background-color:#f9f9f9;}#element-310 .timer-labels{color:#f65b00;}#element-299{top:2.375rem;left:0.125rem;height:21.4669rem;width:24.875rem;z-index:5;}#element-299 .cropped{background:url(../../<?php echo $info->s1_product_image ?>) 0 -1.125rem / 25.375rem 23.875rem;}#element-302{top:72.375rem;left:13.75rem;height:6.3621rem;width:6.75rem;z-index:22;}#element-303{top:89.75rem;left:10.5rem;height:2.0909rem;width:2.875rem;z-index:23;}#element-304{top:80.8125rem;left:3.9375rem;height:6.2077rem;width:5.375rem;z-index:24;}#element-305{top:87.9375rem;left:4.8125rem;height:4.8052rem;width:3.625rem;z-index:25;}#element-306{top:80.8125rem;left:14.625rem;height:5.9564rem;width:5.3125rem;z-index:26;}#element-307{top:89.875rem;left:16.0625rem;height:1.7241rem;width:2.5rem;z-index:27;}#element-308{top:72.4375rem;left:3.9375rem;height:6.2169rem;width:5.375rem;z-index:28;}#element-309{top:1rem;left:1.8125rem;height:1.875rem;width:5rem;z-index:49;}#element-311{top:54.3125rem;left:2.9375rem;height:2.125rem;width:20rem;z-index:54;}.btn{cursor:pointer;text-align:center;transition:border .5s;width:100%;border:0;white-space:normal;display:table-cell;vertical-align:middle;padding:0;line-height:120%;}.btn-shadow{box-shadow:0 1px 3px rgba(1,1,1,0.5);}#element-311 .btn.btn-effect3d:active{box-shadow:none;}#element-311 .btn:hover{background:#BA3B03;color:#FFFFFF;}#element-311 .btn{background:linear-gradient(#FF791E,#F65B00 50%);color:#FFFFFF;font-size:0.9907rem;font-family:Almarai;font-weight:900;height:2.125rem;width:20rem;border-radius:14px;}#element-244{top:26.0625rem;left:1.875rem;height:7.6875rem;width:20rem;z-index:66;color:#37465A;font-size:2.5387rem;line-height:2.5625rem;text-align:right;}#element-244 .x_ddc196a5{text-align:right;line-height:2.5625rem;font-size:2.5387rem;}#element-244 .x_df78330b{color:#2d2d2d;}#element-245{top:34.875rem;left:6.875rem;height:5.3125rem;width:15.25rem;z-index:67;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:right;}#element-245 .x_695a2def{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-245 .x_df78330b{color:#2d2d2d;}#element-245 strong{font-weight:700;}#element-9{top:43.1875rem;left:12.875rem;height:2.25rem;width:8.1875rem;z-index:68;color:#37465A;font-size:1.6398rem;line-height:2.3172rem;text-align:left;}#element-9 .x_46b8788f{text-align:left;line-height:2.25rem;font-size:1.6398rem;}#element-9 .x_7b2817bf{color:#000000;}#element-9 strong{font-weight:700;}#element-10{top:43.6875rem;left:12.6875rem;height:1.375rem;width:8.125rem;z-index:69;}#element-10 .shape{border-bottom:2px dotted #000000;}#element-247{top:45.5625rem;left:5.25rem;height:5.8125rem;width:16.75rem;z-index:71;color:#37465A;font-size:3.6601rem;line-height:5.9111rem;text-align:right;}#element-247 .x_2520e6bb{text-align:right;line-height:5.875rem;font-size:3.6601rem;}#element-247 .x_0e1fbe45{color:#f15a24;}#page_block_below_fold{height:269.6875rem;max-width:100%;}#page_block_below_fold .section-holder-border{border:0;}#page_block_below_fold .section-block{background:none;height:269.6875rem;}#page_block_below_fold .section-holder-overlay{display:none;}#element-18{top:-21.75rem;left:0.125rem;height:8.3781rem;width:24.875rem;z-index:6;}#element-22{top:-3.3125rem;left:0;height:87.3125rem;width:24.9375rem;z-index:7;}#element-22 .shape{border:0;background:rgb(0,0,0);}#element-24{top:-4.6875rem;left:4.875rem;height:2.25rem;width:7.125rem;z-index:8;}#element-24 .shape{border:0.0625rem solid #A3BAC6;background:rgb(240,243,245);}#element-23{top:-4.0625rem;left:5.875rem;height:1rem;width:5.1875rem;z-index:9;color:#37465A;font-size:0.6192rem;line-height:1rem;text-align:right;}#element-23 .x_418c4ad8{text-align:right;line-height:1rem;font-size:0.6192rem;}#element-23 .x_7b2817bf{color:#000000;}#element-23 strong{font-weight:700;}#element-26{top:0.4375rem;left:0;height:13.1875rem;width:24.875rem;z-index:10;}.video-holder{height:100%;overflow:hidden;position:relative;}.video-holder-animoto{background-color:#000;}.video-animoto{position:absolute;top:0;bottom:0;width:100%;height:0;padding-bottom:56.25%;margin:auto;}.video-iframe{position:absolute;}.video-overlay:hover{opacity:1;}.video-holder-helpers{transition:opacity .15s ease-in-out;position:absolute;top:0;left:0;right:0;bottom:0;font-size:14px;text-align:center;display:flex;flex-direction:column;justify-content:center;align-items:center;}.video-overlay{background-color:rgba(31,59,82,0.8);color:#ffffff;opacity:0;z-index:1;}.warning-text{margin-top:10px;font-size:13px;}.warning-img{width:25px;}.fake-video{background:#ffffff;}.fake-play{opacity:.8;}.video-overlay:hover ~ .fake-play{opacity:0;}element-26 iframe{width:398px;height:211px;}#element-28{top:17.125rem;left:2.0625rem;height:0.75rem;width:7.25rem;z-index:11;color:#37465A;font-size:0.55rem;line-height:0.8882rem;text-align:left;}#element-28 .x_c6814124{text-align:left;line-height:0.8125rem;font-size:0.55rem;}#element-28 .x_c3570890{text-align:left;line-height:0.8125rem;font-size:0.55rem;}#element-28 .x_f2074b6c{color:#ffffff;}#element-29{top:15.375rem;left:2.0625rem;height:1.6875rem;width:7.25rem;z-index:12;color:#37465A;font-size:1.0999rem;line-height:1.7764rem;text-align:left;}#element-29 .x_21d8ef23{text-align:left;line-height:1.6875rem;font-size:1.0999rem;}#element-29 .x_57f24412{text-align:left;line-height:1.6875rem;font-size:1.0999rem;}#element-29 .x_80c53a0c{color:#fbb03b;}#element-29 strong{font-weight:900;}#element-33{top:17.125rem;left:19.5rem;height:0.75rem;width:2.9375rem;z-index:14;color:#37465A;font-size:0.55rem;line-height:0.8882rem;text-align:left;}#element-33 .x_c6814124{text-align:left;line-height:0.8125rem;font-size:0.55rem;}#element-33 .x_c3570890{text-align:left;line-height:0.8125rem;font-size:0.55rem;}#element-33 .x_f2074b6c{color:#ffffff;}#element-35{top:15.375rem;left:19.5rem;height:1.6875rem;width:2.9375rem;z-index:15;color:#37465A;font-size:1.0999rem;line-height:1.7764rem;text-align:left;}#element-35 .x_57f24412{text-align:left;line-height:1.6875rem;font-size:1.0999rem;}#element-35 .x_80c53a0c{color:#fbb03b;}#element-35 strong{font-weight:900;}#element-39{top:17.125rem;left:11rem;height:1.5625rem;width:4.375rem;z-index:17;color:#37465A;font-size:0.55rem;line-height:0.8882rem;text-align:left;}#element-39 .x_c6814124{text-align:left;line-height:0.8125rem;font-size:0.55rem;}#element-39 .x_c3570890{text-align:left;line-height:0.8125rem;font-size:0.55rem;}#element-39 .x_f2074b6c{color:#ffffff;}#element-41{top:15.375rem;left:11rem;height:1.6875rem;width:4.375rem;z-index:18;color:#37465A;font-size:1.0999rem;line-height:1.7764rem;text-align:left;}#element-41 .x_21d8ef23{text-align:left;line-height:1.6875rem;font-size:1.0999rem;}#element-41 .x_57f24412{text-align:left;line-height:1.6875rem;font-size:1.0999rem;}#element-41 .x_80c53a0c{color:#fbb03b;}#element-41 strong{font-weight:900;}#element-249{top:-18.25rem;left:0;height:14rem;width:12rem;z-index:72;color:#37465A;font-size:1.9814rem;line-height:2.4rem;text-align:right;}#element-249 .x_78f40bb3{text-align:right;line-height:2.375rem;font-size:1.9814rem;}#element-249 .x_7b2817bf{color:#000000;}#element-249 .x_0e1fbe45{color:#f15a24;}#element-217{top:21.3125rem;left:18.25rem;height:3.3027rem;width:3.0625rem;z-index:73;}#element-218{top:21.3125rem;left:2.1875rem;height:3.3266rem;width:3.75rem;z-index:74;}#element-219{top:26.9375rem;left:10.1875rem;height:3.375rem;width:4.5625rem;z-index:75;}#element-220{top:32.3125rem;left:2.75rem;height:3.4375rem;width:4.1875rem;z-index:76;}#element-221{top:32.25rem;left:18rem;height:3.5rem;width:3.5625rem;z-index:77;}#element-223{top:25.625rem;left:16.625rem;height:2.1875rem;width:6.3125rem;z-index:78;color:#37465A;font-size:0.6192rem;line-height:0.75rem;text-align:center;}#element-223 .x_7ca85f40{text-align:center;line-height:0.75rem;font-size:0.6192rem;}#element-223 .x_f2074b6c{color:#ffffff;}#element-224{top:25.625rem;left:0;height:1.4375rem;width:8.875rem;z-index:79;color:#37465A;font-size:0.6192rem;line-height:0.75rem;text-align:center;}#element-224 .x_f79d9295{text-align:center;line-height:0.75rem;font-size:0.6192rem;}#element-224 .x_7ca85f40{text-align:center;line-height:0.75rem;font-size:0.6192rem;}#element-224 .x_f2074b6c{color:#ffffff;}#element-225{top:36.4375rem;left:0.4375rem;height:2.1875rem;width:8.875rem;z-index:80;color:#37465A;font-size:0.6192rem;line-height:0.75rem;text-align:center;}#element-225 .x_f79d9295{text-align:center;line-height:0.75rem;font-size:0.6192rem;}#element-225 .x_7ca85f40{text-align:center;line-height:0.75rem;font-size:0.6192rem;}#element-225 .x_f2074b6c{color:#ffffff;}#element-227{top:36.4375rem;left:15.375rem;height:1.4375rem;width:8.875rem;z-index:81;color:#37465A;font-size:0.6192rem;line-height:0.75rem;text-align:center;}#element-227 .x_f79d9295{text-align:center;line-height:0.75rem;font-size:0.6192rem;}#element-227 .x_7ca85f40{text-align:center;line-height:0.75rem;font-size:0.6192rem;}#element-227 .x_f2074b6c{color:#ffffff;}#element-251{top:30.75rem;left:7.5rem;height:2rem;width:9.9375rem;z-index:82;color:#37465A;font-size:0.805rem;line-height:0.975rem;text-align:center;}#element-251 .x_95f1888a{text-align:center;line-height:1rem;font-size:0.805rem;}#element-251 .x_72fe6b53{text-align:center;line-height:1rem;font-size:0.805rem;}#element-251 .x_f2074b6c{color:#ffffff;}#element-48{top:44.25rem;left:0;height:34.75rem;width:25.0625rem;z-index:84;}#element-48 .shape{border:0;background:rgb(240,243,245);width:100%;height:100%;}#element-46{top:44.25rem;left:0;height:15.1143rem;width:14.5625rem;z-index:85;}#element-46 .cropped{background:url(../../<?php echo $info->s4_image ?>) -0.75rem 0 / 24.125rem 15.0625rem;}#element-57{top:76rem;left:14.8125rem;height:1rem;width:8.5625rem;z-index:87;color:#37465A;font-size:0.6192rem;line-height:1rem;text-align:right;}#element-57 .x_adee42e9{text-align:right;line-height:1rem;font-size:0.6192rem;}#element-57 .x_c24cab30{color:#6f6f6f;}#element-59{top:74.3125rem;left:15.75rem;height:1.6875rem;width:7.625rem;z-index:88;color:#37465A;font-size:1.1106rem;line-height:1.7936rem;text-align:left;}#element-59 .x_32ef35e0{text-align:left;line-height:1.6875rem;font-size:1.1106rem;}#element-59 .x_8bff3c96{text-align:left;line-height:1.6875rem;font-size:1.1106rem;}#element-59 .x_7b2817bf{color:#000000;}#element-59 strong{font-weight:900;}#element-62{top:69.75rem;left:0.25rem;height:0.8125rem;width:9.25rem;z-index:90;color:#37465A;font-size:0.6192rem;line-height:0.875rem;text-align:right;}#element-62 .x_4ae4389d{text-align:right;line-height:0.875rem;font-size:0.6192rem;}#element-62 .x_32c6c151{text-align:right;line-height:0.875rem;font-size:0.6192rem;}#element-62 .x_c24cab30{color:#6f6f6f;}#element-64{top:67.9375rem;left:0.6875rem;height:1.75rem;width:8.75rem;z-index:91;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:right;}#element-64 .x_e0a8da1e{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-64 .x_695a2def{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-64 .x_7b2817bf{color:#000000;}#element-64 strong{font-weight:900;}#element-68{top:66.5rem;left:0.4375rem;height:0.8125rem;width:8.8125rem;z-index:93;color:#37465A;font-size:0.6192rem;line-height:0.875rem;text-align:right;}#element-68 .x_4ae4389d{text-align:right;line-height:0.875rem;font-size:0.6192rem;}#element-68 .x_32c6c151{text-align:right;line-height:0.875rem;font-size:0.6192rem;}#element-68 .x_c24cab30{color:#6f6f6f;}#element-70{top:64.6875rem;left:0.4375rem;height:1.75rem;width:8.8125rem;z-index:94;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:right;}#element-70 .x_e0a8da1e{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-70 .x_695a2def{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-70 .x_7b2817bf{color:#000000;}#element-70 strong{font-weight:900;}#element-76{top:71.125rem;left:4.4375rem;height:1.75rem;width:5.0625rem;z-index:97;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:right;}#element-76 .x_e0a8da1e{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-76 .x_695a2def{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-76 .x_7b2817bf{color:#000000;}#element-76 strong{font-weight:900;}#element-165{top:63.1875rem;left:3.75rem;height:1rem;width:5.5rem;z-index:111;color:#37465A;font-size:0.6192rem;line-height:1rem;text-align:right;}#element-165 .x_418c4ad8{text-align:right;line-height:1rem;font-size:0.6192rem;}#element-165 .x_adee42e9{text-align:right;line-height:1rem;font-size:0.6192rem;}#element-165 .x_c24cab30{color:#6f6f6f;}#element-167{top:51.3125rem;left:3.75rem;height:1.75rem;width:5.5rem;z-index:112;color:#37465A;font-size:0.52rem;line-height:1.8rem;text-align:right;}#element-167 .x_695a2def{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-167 .x_7b2817bf{color:#000000;}#element-167 strong{font-weight:900;}#element-170{top:66.4375rem;left:13.625rem;height:1rem;width:9.375rem;z-index:114;color:#37465A;font-size:0.6192rem;line-height:1rem;text-align:right;}#element-170 .x_adee42e9{text-align:right;line-height:1rem;font-size:0.6192rem;}#element-170 .x_c24cab30{color:#6f6f6f;}#element-172{top:64.625rem;left:17.5rem;height:1.75rem;width:5.5rem;z-index:115;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:right;}#element-172 .x_695a2def{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-172 .x_7b2817bf{color:#000000;}#element-172 strong{font-weight:900;}#element-252{top:46.25rem;left:10.5625rem;height:12.8125rem;width:12.8125rem;z-index:117;color:#37465A;font-size:1.548rem;line-height:1.875rem;text-align:right;}#element-252 .x_36024141{text-align:right;line-height:1.875rem;font-size:1.548rem;}#element-252 .x_80c53a0c{color:#fbb03b;}#element-252 .x_df78330b{color:#2d2d2d;}#page_block_footer{height:87.9375rem;max-width:100%;}#page_block_footer .section-holder-border{border:0;}#page_block_footer .section-block{background:none;height:87.9375rem;}#page_block_footer .section-holder-overlay{display:none;}#element-93{top:-192.1875rem;left:0;height:17.25rem;width:24.9375rem;z-index:19;}#element-93 .shape{border:0;background:rgb(255,255,255);}#element-98{top:-176.1875rem;left:0;height:139.0625rem;width:24.9375rem;z-index:20;}#element-98 .shape{border:0;background:rgb(0,0,0);width:100%;height:100%;}#element-151{top:81.25rem;left:2.5rem;height:2.4375rem;width:20rem;z-index:31;color:#37465A;font-size:1.2384rem;line-height:1.25rem;text-align:left;}#element-151 .x_d0b58f86{text-align:left;line-height:1.25rem;font-size:1.2384rem;}#element-151 .x_f2074b6c{color:#ffffff;}#element-151 strong{font-weight:900;}#element-153{top:-47.125rem;left:2.5rem;height:2.3125rem;width:20rem;z-index:32;color:#37465A;font-size:1.1765rem;line-height:1.1875rem;text-align:center;}#element-153 .x_ce9a991a{text-align:center;line-height:1.1875rem;font-size:1.1765rem;}#element-153 .x_80c53a0c{color:#fbb03b;}#element-153 strong{font-weight:700;}#element-173{top:-188.125rem;left:1.3125rem;height:4.25rem;width:3.625rem;z-index:35;}#element-104{top:-102.3125rem;left:4.5625rem;height:11.5rem;width:15.8125rem;z-index:36;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:center;}#element-104 .x_70ee4658{text-align:center;line-height:1.3125rem;font-size:0.805rem;}#element-104 .x_199030dd{color:#dddddd;}#element-106{top:-104.875rem;left:7.625rem;height:1.5625rem;width:9.75rem;z-index:37;color:#37465A;font-size:0.805rem;line-height:0.8125rem;text-align:center;}#element-106 .x_c2a5648c{text-align:center;line-height:0.8125rem;font-size:0.805rem;}#element-106 .x_9f7a47db{text-align:center;line-height:0.8125rem;font-size:0.805rem;}#element-106 .x_65831597{color:#fbfbfb;}#element-106 strong{font-weight:700;}#element-146{top:-89.125rem;left:9.5625rem;height:1.0625rem;width:5.8125rem;z-index:38;}#element-175{top:-124.75rem;left:3.125rem;height:18.75rem;width:18.75rem;z-index:39;}#element-103{top:-143.3125rem;left:4.9375rem;height:14.0625rem;width:15.9375rem;z-index:40;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:center;}#element-103 .x_077c8203{text-align:center;line-height:1.3125rem;font-size:0.805rem;}#element-103 .x_70ee4658{text-align:center;line-height:1.3125rem;font-size:0.805rem;}#element-103 .x_199030dd{color:#dddddd;}#element-107{top:-145.8125rem;left:8.0625rem;height:1.5625rem;width:9.75rem;z-index:41;color:#37465A;font-size:0.805rem;line-height:0.8125rem;text-align:center;}#element-107 .x_c2a5648c{text-align:center;line-height:0.8125rem;font-size:0.805rem;}#element-107 .x_9f7a47db{text-align:center;line-height:0.8125rem;font-size:0.805rem;}#element-107 .x_65831597{color:#fbfbfb;}#element-107 strong{font-weight:700;}#element-147{top:-127.875rem;left:10.0625rem;height:1rem;width:5.75rem;z-index:42;}#element-176{top:-165.25rem;left:3.125rem;height:18.6875rem;width:18.6875rem;z-index:44;}#element-102{top:-61.6875rem;left:3.8125rem;height:11.5rem;width:17.375rem;z-index:45;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:center;}#element-102 .x_077c8203{text-align:center;line-height:1.3125rem;font-size:0.805rem;}#element-102 .x_70ee4658{text-align:center;line-height:1.3125rem;font-size:0.805rem;}#element-102 .x_199030dd{color:#dddddd;}#element-105{top:-64.5625rem;left:7.625rem;height:2.3125rem;width:9.75rem;z-index:46;color:#37465A;font-size:0.805rem;line-height:0.8125rem;text-align:center;}#element-105 .x_c2a5648c{text-align:center;line-height:0.8125rem;font-size:0.805rem;}#element-105 .x_9f7a47db{text-align:center;line-height:0.8125rem;font-size:0.805rem;}#element-105 .x_65831597{color:#fbfbfb;}#element-105 strong{font-weight:700;}#element-148{top:-49.9375rem;left:10.0625rem;height:1.0625rem;width:5.8125rem;z-index:47;}#element-177{top:-84.3125rem;left:3.125rem;height:18.75rem;width:18.75rem;z-index:48;}#element-228{top:-172.875rem;left:3.75rem;height:4.5rem;width:12.0625rem;z-index:55;color:#37465A;font-size:1.4861rem;line-height:1.5rem;text-align:right;}#element-228 .x_3abf7fa6{text-align:right;line-height:1.5rem;font-size:1.4861rem;}#element-228 .x_f2074b6c{color:#ffffff;}#element-228 strong{font-weight:900;}#element-229{top:-172.875rem;left:17.625rem;height:4.3966rem;width:3.75rem;z-index:65;}#element-193{top:-185.1875rem;left:0;height:8.2561rem;width:24.9375rem;z-index:83;}#element-74{top:-197.5625rem;left:4.4375rem;height:1rem;width:5.0625rem;z-index:96;color:#37465A;font-size:0.6192rem;line-height:1rem;text-align:right;}#element-74 .x_418c4ad8{text-align:right;line-height:1rem;font-size:0.6192rem;}#element-74 .x_adee42e9{text-align:right;line-height:1rem;font-size:0.6192rem;}#element-74 .x_c24cab30{color:#6f6f6f;}#element-79{top:-197.625rem;left:14.5625rem;height:1rem;width:8.4375rem;z-index:99;color:#37465A;font-size:0.6192rem;line-height:1rem;text-align:right;}#element-79 .x_418c4ad8{text-align:right;line-height:1rem;font-size:0.6192rem;}#element-79 .x_adee42e9{text-align:right;line-height:1rem;font-size:0.6192rem;}#element-79 .x_c24cab30{color:#6f6f6f;}#element-81{top:-199.3125rem;left:18.75rem;height:1.75rem;width:4.25rem;z-index:100;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:right;}#element-81 .x_e0a8da1e{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-81 .x_695a2def{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-81 .x_7b2817bf{color:#000000;}#element-81 strong{font-weight:900;}#element-84{top:-200.8125rem;left:11.875rem;height:1rem;width:11.1875rem;z-index:102;color:#37465A;font-size:0.6192rem;line-height:1rem;text-align:right;}#element-84 .x_418c4ad8{text-align:right;line-height:1rem;font-size:0.6192rem;}#element-84 .x_adee42e9{text-align:right;line-height:1rem;font-size:0.6192rem;}#element-84 .x_c24cab30{color:#6f6f6f;}#element-86{top:-202.5rem;left:14.3125rem;height:1.75rem;width:8.75rem;z-index:103;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:right;}#element-86 .x_e0a8da1e{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-86 .x_695a2def{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-86 .x_7b2817bf{color:#000000;}#element-86 strong{font-weight:900;}#element-89{top:-194.3125rem;left:0.0625rem;height:1rem;width:9.5625rem;z-index:105;color:#37465A;font-size:0.6192rem;line-height:1rem;text-align:right;}#element-89 .x_418c4ad8{text-align:right;line-height:1rem;font-size:0.6192rem;}#element-89 .x_adee42e9{text-align:right;line-height:1rem;font-size:0.6192rem;}#element-89 .x_c24cab30{color:#6f6f6f;}#element-91{top:-196rem;left:0.875rem;height:1.75rem;width:8.75rem;z-index:106;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:right;}#element-91 .x_e0a8da1e{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-91 .x_695a2def{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-91 .x_7b2817bf{color:#000000;}#element-91 strong{font-weight:900;}#element-160{top:-207.25rem;left:11.5625rem;height:1rem;width:11.4375rem;z-index:108;color:#37465A;font-size:0.6192rem;line-height:1rem;text-align:right;}#element-160 .x_418c4ad8{text-align:right;line-height:1rem;font-size:0.6192rem;}#element-160 .x_adee42e9{text-align:right;line-height:1rem;font-size:0.6192rem;}#element-160 .x_c24cab30{color:#6f6f6f;}#element-162{top:-209.0625rem;left:14.1875rem;height:1.75rem;width:8.75rem;z-index:109;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:right;}#element-162 .x_e0a8da1e{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-162 .x_695a2def{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-162 .x_7b2817bf{color:#000000;}#element-162 strong{font-weight:900;}#element-263{top:-188.1875rem;left:0.8125rem;height:1.8125rem;width:22.5rem;z-index:119;color:#37465A;font-size:1.548rem;line-height:1.875rem;text-align:center;}#element-263 .x_ef6d09e5{text-align:center;line-height:1.875rem;font-size:1.548rem;}#element-263 .x_80c53a0c{color:#fbb03b;}#page-block-9wkstdyrfi5{height:54.875rem;max-width:100%;}#page-block-9wkstdyrfi5 .section-holder-border{border:0;}#page-block-9wkstdyrfi5 .section-block{background:none;height:54.875rem;}#page-block-9wkstdyrfi5 .section-holder-overlay{display:none;}#element-395{top:-127.25rem;left:0.125rem;height:72.25rem;width:24.9375rem;z-index:155;}#element-395 .shape{border:0;background:rgb(251,176,59);width:100%;height:100%;}#element-394{top:-130rem;left:1rem;height:15.243rem;width:22.5rem;z-index:156;}#element-396{top:-113.375rem;left:0.125rem;height:23.718rem;width:24.875rem;z-index:157;}#element-397{top:-89.625rem;left:0;height:36.75rem;width:25.0625rem;z-index:158;}#element-397 .shape{border:0;background:rgb(246,225,222);width:100%;height:100%;}#element-399{top:-85.625rem;left:4.5rem;height:10.5rem;width:16.75rem;z-index:160;color:#37465A;font-size:2.1672rem;line-height:3.5rem;text-align:right;font-weight:800;}#element-399 .x_d7cd368f{text-align:right;line-height:3.5rem;font-size:2.1672rem;}#element-399 .x_7b2817bf{color:#000000;}#element-399 strong{font-weight:800;}#element-399.headline{font-weight:800;}#element-400{top:-76.3125rem;left:3.75rem;height:7.5rem;width:17.5rem;z-index:162;color:#37465A;font-size:1.0526rem;line-height:1.4875rem;text-align:right;}#element-400 .x_7c7c78aa{text-align:right;line-height:1.5rem;font-size:1.0526rem;}#element-400 strong{font-weight:700;}#element-401{top:-60.0625rem;left:3.8125rem;height:2.5rem;width:16.75rem;z-index:163;}#element-401 .btn.btn-effect3d:active{box-shadow:none;}#element-401 .btn:hover{background:#BA3B03;color:#FFFFFF;}#element-401 .btn{background:linear-gradient(#FF791E,#F65B00 50%);color:#FFFFFF;font-size:0.9907rem;font-family:Almarai;font-weight:900;height:2.5rem;width:16.75rem;border-radius:14px;}#page-block-ynbtqvrscze{height:105.75rem;max-width:100%;}#page-block-ynbtqvrscze .section-holder-border{border:0;}#page-block-ynbtqvrscze .section-block{background:none;height:105.75rem;}#page-block-ynbtqvrscze .section-holder-overlay{display:none;}#element-388{top:-33.1875rem;left:0;height:57.75rem;width:24.9375rem;z-index:33;}#element-388 .shape{border:0;background:rgb(0,0,0);width:100%;height:100%;}#element-382{top:-103.1875rem;left:0.0625rem;height:69.8125rem;width:24.9375rem;z-index:50;}#element-382 .shape{border:0;background:rgb(251,176,59);width:100%;height:100%;}#element-381{top:-29.25rem;left:15.375rem;height:2.4844rem;width:6.625rem;z-index:51;}#element-149{top:-19.5625rem;left:3.25rem;height:12.25rem;width:18.75rem;z-index:52;color:#37465A;font-size:0.805rem;line-height:1.1375rem;text-align:right;}#element-149 .x_5e8aaa39{text-align:right;line-height:1.125rem;font-size:0.805rem;}#element-149 .x_f2074b6c{color:#ffffff;}#element-149 strong{font-weight:700;}#element-232{top:-25rem;left:4.5rem;height:3.5rem;width:17.5rem;z-index:53;color:#37465A;font-size:1.1765rem;line-height:1.1875rem;text-align:right;}#element-232 .x_71eb4817{text-align:right;line-height:1.1875rem;font-size:1.1765rem;}#element-232 .x_f2074b6c{color:#ffffff;}#element-232 strong{font-weight:900;}#element-117{top:-66.5625rem;left:3rem;height:10.2545rem;width:7.375rem;z-index:56;}#element-117 .cropped{background:url(../../<?php echo $info->s9_image ?>) 0 0 / 8.375rem 10.25rem;}#element-115{top:-75.8125rem;left:0.3125rem;height:1.375rem;width:24.75rem;z-index:57;}#element-115 .shape{border-bottom:2px dotted #FBFBFB;}#element-113{top:-79.1875rem;left:9.25rem;height:7.75rem;width:12.25rem;z-index:58;}#element-113 .shape{border:0;background:rgb(241,90,36);}#element-114{top:-77.75rem;left:9.9375rem;height:5.5625rem;width:11rem;z-index:59;color:#37465A;font-size:0.9686rem;line-height:1.1733rem;text-align:right;}#element-114 .x_584e132f{text-align:right;line-height:1.125rem;font-size:0.9686rem;}#element-114 .x_f2074b6c{color:#ffffff;}#element-114 strong{font-weight:700;}#element-118{top:-61.5625rem;left:2.0625rem;height:23.25rem;width:20.25rem;z-index:61;color:#37465A;font-size:0.787rem;line-height:1.1121rem;text-align:right;}#element-118 .x_6b4d17c3{text-align:right;line-height:1.0625rem;font-size:0.787rem;}#element-118 .x_d66531b9{text-align:right;line-height:1.0625rem;font-size:0.787rem;}#element-118 .x_7b2817bf{color:#000000;}#element-118 .x_e1c17884{color:#000001;}#element-118 strong{font-weight:700;}#element-215{top:-68.625rem;left:2.375rem;height:6.6875rem;width:19.625rem;z-index:62;color:#37465A;font-size:1.6951rem;line-height:1.711rem;text-align:right;}#element-215 .x_ef0a430a{text-align:right;line-height:1.6875rem;font-size:1.6951rem;}#element-215 .x_f2074b6c{color:#ffffff;}#element-215 strong{font-weight:900;}#element-364{top:-107.8125rem;left:0;height:12.9375rem;width:25rem;z-index:63;}#element-364 .shape{border:0;background:rgb(240,243,245);width:100%;height:100%;}#element-389{top:-34.4375rem;left:9.5rem;height:2.5rem;width:13.8125rem;z-index:64;}#element-389 .btn.btn-effect3d:active{box-shadow:none;}#element-389 .btn:hover{background:#BA3B03;color:#FFFFFF;}#element-389 .btn{background:linear-gradient(#FF791E,#F65B00 50%);color:#FFFFFF;font-size:0.9907rem;font-family:Almarai;font-weight:900;height:2.5rem;width:13.8125rem;border-radius:14px;}#element-111{top:-92.6875rem;left:2.9375rem;height:8.875rem;width:19rem;z-index:120;color:#37465A;font-size:0.805rem;line-height:1.1375rem;text-align:right;}#element-111 .x_5e8aaa39{text-align:right;line-height:1.125rem;font-size:0.805rem;}#element-111 .x_7b2817bf{color:#000000;}#element-267{top:-104.125rem;left:4.4375rem;height:6.25rem;width:17.5rem;z-index:121;color:#37465A;font-size:1.548rem;line-height:1.5625rem;text-align:right;}#element-267 .x_14116fc1{text-align:right;line-height:1.5625rem;font-size:1.548rem;}#element-267 .x_7b2817bf{color:#000000;}#element-376{top:-5rem;left:4.375rem;height:6.5rem;width:5.875rem;z-index:125;}#element-377{top:11.1875rem;left:9.6875rem;height:6.6875rem;width:5.5625rem;z-index:126;}#element-378{top:-2.6875rem;left:16rem;height:2.6875rem;width:3.75rem;z-index:127;}#element-379{top:3.75rem;left:4.375rem;height:5.75rem;width:4.25rem;z-index:128;}#element-380{top:5.5625rem;left:16.0625rem;height:2.7331rem;width:3.75rem;z-index:136;}#page-block-mg6u024zjmk{height:59.0625rem;max-width:100%;}#page-block-mg6u024zjmk .section-holder-border{border:0;}#page-block-mg6u024zjmk .section-block{background:none;height:59.0625rem;}#page-block-mg6u024zjmk .section-holder-overlay{display:none;}#element-350{top:-430.875rem;left:0.8125rem;height:3.5625rem;width:22.5rem;z-index:21;}#element-350 .shape{border:0;background:rgb(0,0,0);}#element-328{top:-81.1875rem;left:0.0625rem;height:135.3125rem;width:24.9375rem;z-index:34;}#element-328 .shape{border:0;background:rgb(255,255,255);width:100%;height:100%;}#element-337{top:29.1875rem;left:0;height:29.875rem;width:25.0625rem;z-index:122;}#element-337 .shape{border:0;background:rgb(251,176,59);}#element-348{top:-58rem;left:6.625rem;height:5.2987rem;width:12rem;z-index:123;}#element-345{top:-76.375rem;left:2.6875rem;height:19.6487rem;width:20.75rem;z-index:124;}#element-340{top:37.3125rem;left:16.0625rem;height:5.9375rem;width:6.25rem;z-index:129;}#element-339{top:39.375rem;left:11.3125rem;height:1.75rem;width:2.375rem;z-index:130;}#element-338{top:45.6875rem;left:3.3125rem;height:5.8676rem;width:5.25rem;z-index:131;}#element-341{top:52.375rem;left:11.125rem;height:4.0625rem;width:3rem;z-index:132;}#element-342{top:45.6875rem;left:17.0625rem;height:5.6667rem;width:5rem;z-index:133;}#element-343{top:47.875rem;left:11.625rem;height:1.6364rem;width:2.25rem;z-index:134;}#element-344{top:36.8125rem;left:2.6875rem;height:6.7184rem;width:5.75rem;z-index:135;}#element-349{top:28.5rem;left:3.8125rem;height:3.1875rem;width:16.625rem;z-index:137;font-size:3.1875rem;}#element-349 .timer-box{color:#e55211;background-color:#f9f9f9;}#element-349 .timer-labels{color:#f65b00;}#element-275{top:-41.5rem;left:13.4375rem;height:3rem;width:8.875rem;z-index:138;color:#37465A;font-size:1.8576rem;line-height:3rem;text-align:left;}#element-275 .x_edd31370{text-align:left;line-height:3rem;font-size:1.8576rem;}#element-275 .x_7b2817bf{color:#000000;}#element-275 strong{font-weight:700;}#element-277{top:-40.6875rem;left:13rem;height:1.3125rem;width:9.3125rem;z-index:139;}#element-277 .shape{border-bottom:2px dotted #000000;}#element-279{top:-38.5rem;left:4.8125rem;height:3.75rem;width:17.5rem;z-index:141;color:#37465A;font-size:2.6625rem;line-height:3.7625rem;text-align:right;}#element-279 .x_a7106f7d{text-align:right;line-height:3.75rem;font-size:2.6625rem;}#element-279 .x_0e1fbe45{color:#f15a24;}#element-346{top:-34.75rem;left:10.125rem;height:1.625rem;width:11.875rem;z-index:143;color:#37465A;font-size:0.9907rem;line-height:1.6rem;text-align:right;}#element-346 .x_bb1de03d{text-align:right;line-height:1.625rem;font-size:0.9907rem;}#element-346 .x_7b2817bf{color:#000000;}#element-269{top:-48.1875rem;left:2.5625rem;height:4.125rem;width:19.75rem;z-index:145;color:#37465A;font-size:2.0457rem;line-height:2.0649rem;text-align:right;}#element-269 .x_2a184a51{text-align:right;line-height:2.0625rem;font-size:2.0457rem;}#element-269 .x_e1c17884{color:#000001;}#element-347{top:-51.5rem;left:15.6875rem;height:2.472rem;width:6.625rem;z-index:146;}#element-329{top:-84.5625rem;left:1.8125rem;height:7.9375rem;width:21.25rem;z-index:147;}#element-329 .shape{border:0;background:rgb(255,255,255);width:100%;height:100%;}#element-268{top:-83rem;left:5.0625rem;height:4.8125rem;width:15.75rem;z-index:148;color:#37465A;font-size:1.6099rem;line-height:1.625rem;text-align:right;}#element-268 .x_ebca226a{text-align:right;line-height:1.625rem;font-size:1.6099rem;}#element-268 .x_0e1fbe45{color:#f15a24;}#element-268 .x_7b2817bf{color:#000000;}#element-282{top:17.8125rem;left:2.3125rem;height:1.5625rem;width:12.375rem;z-index:149;color:#37465A;font-size:1.1146rem;line-height:1.575rem;text-align:center;}#element-282 .x_bcbce646{text-align:center;line-height:1.5625rem;font-size:1.1146rem;}#element-282 .x_7b2817bf{color:#000000;}#element-282 strong{font-weight:800;}#element-284{top:17.375rem;left:19.125rem;height:2.375rem;width:3.4375rem;z-index:150;}#element-14{top:-32.5rem;left:2.3125rem;height:0.25rem;width:0.125rem;z-index:152;}#element-14 .shape{border:0.0625rem solid #A3BAC6;border-radius:0.5rem 0.5rem 0.5rem 0.5rem;background:rgb(255,255,255);}#element-11{top:-29.375rem;left:2.5625rem;height:36.875rem;width:20.875rem;z-index:153;}.lightbox{display:none;position:fixed;width:100%;height:100%;top:0;}.lightbox-dim{background:rgba(0,0,0,0.85);height:100%;animation:fade-in .5s ease-in-out;overflow-x:hidden;display:flex;align-items:center;padding:30px 0;}.lightbox-content{background-color:#fefefe;border-radius:3px;position:relative;margin:auto;animation:slide-down .5s ease-in-out;}.lightbox-opened{display:block;}.lightbox-close{width:26px;right:0;top:-10px;cursor:pointer;}.lightbox-close-btn{padding:0;border:none;background:none;}.lightbox-btn-svg{display:block;}.lightbox-close-icon{fill:#fff;}.notification-text{font-size:1.5rem;color:#fff;text-align:center;width:100%;}.modal-on{overflow:hidden;}.form{font-size:1.25rem;}.form-input{color:transparent;background-color:transparent;border:1px solid transparent;border-radius:3px;font-family:inherit;width:100%;height:3.5rem;margin:0.5rem 0;padding:0.5rem 0.625rem 0.5625rem;}.form-input::placeholder{opacity:1;color:transparent;}.form-textarea{display:inline-block;vertical-align:top;}.form-select{background:url("//v.fastcdn.co/a/img/builder2/select-arrow-drop-down.png") no-repeat right;-webkit-appearance:none;-moz-appearance:none;color:transparent;}.form-label{display:inline-block;color:transparent;}.form-label-title{display:block;line-height:1.1;width:100%;padding:0.75rem 0 0.5625rem;margin:0.5rem 0 0.125rem;}.form-multiple-label:empty{display:block;height:0.8rem;margin-top:.375rem;}.form-label-outside{margin:0.3125rem 0 0;}.form-multiple-input{position:absolute;opacity:0;}.form-multiple-label{position:relative;padding-top:0.75rem;line-height:1.05;margin-left:1.5625rem;}.form-multiple-label:before{content:"";display:inline-block;box-sizing:inherit;width:1rem;height:1rem;background-color:#fff;border-radius:0.25rem;border:1px solid #8195a8;margin-right:0.5rem;vertical-align:-2px;position:absolute;left:-1.5625rem;}.form-checkbox-label:after{content:"";width:0.25rem;height:0.5rem;position:absolute;top:0.8rem;left:-1.25rem;transform:rotate(45deg);border-right:0.1875rem solid;border-bottom:0.1875rem solid;color:#fff;}.form-radio-label:before{border-radius:50%;}.form-multiple-input:focus + .form-multiple-label:before{border:2px solid #308dfc;}.form-multiple-input:checked + .form-radio-label:before{border:0.3125rem solid #308dfc;}.form-multiple-input:checked + .form-checkbox-label:before{background-color:#308dfc;border:0;}.form-btn{-webkit-appearance:none;-moz-appearance:none;background-color:transparent;border:0;cursor:pointer;min-height:100%;}.form-input-inner-shadow{box-shadow:inset 0 1px 3px rgba(0,0,0,0.28);}body#landing-page .user-invalid-label{color:#e85f54;}body#landing-page .user-invalid{border-color:#e85f54;}.form-messagebox{transform:translate(0.4375rem,-0.4375rem);}.form-messagebox:before{content:"";position:absolute;display:block;width:0.375rem;height:0.375rem;transform:rotate(45deg);background-color:#e85f54;top:-0.1875rem;left:25%;}.form-messagebox-contents{font-size:0.875rem;font-weight:500;color:#fff;background-color:#e85f54;padding:0.4375rem 0.9375rem;max-width:250px;word-wrap:break-word;margin:auto;}.form-messagebox-top{transform:translate(0,-1rem);}.form-messagebox-top:before{bottom:-0.1875rem;top:auto;}#element-11 .btn-product-cart.btn.btn-effect3d:active{box-shadow:none;}#element-11 .btn.btn-product-cart:hover{background:#C34B21;color:#FFFFFF;}#element-11 .btn.btn-product-cart{background:linear-gradient(#FF7842,#F15A24 50%);color:#FFFFFF;font-size:1.1146rem;font-family:Almarai;font-weight:800;height:3.25rem;width:21.1875rem;border-radius:15px;}#element-11 .form-label{color:#B4B4B4;}#element-11 ::placeholder{color:#B4B4B4;}#element-11 .form-input{color:#000000;background-color:#FFFFFF;border-color:#FBB03B;}#element-11 .user-invalid{border-color:#E12627;}#element-11 input::placeholder,#element-11 .form-label-inside{color:#B4B4B4;}#element-11 select.valid{color:#000000;}#element-11 .form-btn-geometry{top:42.3125rem;left:-0.1875rem;height:3.25rem;width:21.1875rem;z-index:153;}#element-285{top:23rem;left:1.0625rem;height:4.1875rem;width:20rem;z-index:154;color:#37465A;font-size:1.4241rem;line-height:1.4375rem;text-align:right;}#element-285 .x_09500265{text-align:right;line-height:1.4375rem;font-size:1.4241rem;}#element-285 .x_0e1fbe45{color:#f15a24;}#element-285 .x_e1c17884{color:#000001;}#element-409{top:-34.5625rem;left:21.5rem;height:1.625rem;width:1.625rem;z-index:164;color:#37465A;font-size:0.9907rem;line-height:1.6rem;text-align:right;}#element-409 .x_bb1de03d{text-align:right;line-height:1.625rem;font-size:0.9907rem;}#element-409 .x_7b2817bf{color:#000000;}#page-block-j8wabyhcyyb{height:6rem;max-width:100%;}#page-block-j8wabyhcyyb .section-holder-border{border:0;}#page-block-j8wabyhcyyb .section-block{background:none;height:6rem;}#page-block-j8wabyhcyyb .section-holder-overlay{display:none;}#element-137{top:0;left:0;height:6rem;width:24.9375rem;z-index:29;}#element-137 .shape{border:0;background:rgb(0,0,0);}#element-138{top:1.3125rem;left:2.25rem;height:3.3125rem;width:20rem;z-index:30;color:#37465A;font-size:0.805rem;line-height:1.1375rem;text-align:center;}#element-138 .x_bc7e314d{text-align:center;line-height:1.125rem;font-size:0.805rem;}#element-138 .x_dc6c6e10{text-align:center;line-height:1.125rem;font-size:0.805rem;}#element-138 .x_80c53a0c{color:#fbb03b;}@media screen and (max-width:400px){:root{font-size:4vw;}}@media screen and (min-width:401px) and (max-width:767px){:root{font-size:16px;}}@media screen and (min-width:768px) and (max-width:1200px){:root{font-size:1.33vw;}}@media screen and (max-width:767px){.hidden-mobile{display:none;}}@media screen and (min-width:768px){.section-fit{max-width:60rem;}#page-block-iyknujnh3rr{height:50.5625rem;max-width:100%;}#page-block-iyknujnh3rr .section-holder-border{border:0;}#page-block-iyknujnh3rr .section-block{background:none;height:50.5625rem;}#page-block-iyknujnh3rr .section-holder-overlay{display:none;}#element-298{top:3.25rem;left:0;height:50.625rem;width:59.9375rem;z-index:3;}#element-298 .shape{border:0;background:rgb(251,176,59);width:100%;height:100%;}#element-310{top:33.75rem;left:4.5625rem;height:4.125rem;width:16.75rem;z-index:4;font-size:4.125rem;}.timer-box{font-size:.6em;}.timer-date{height:auto;}#element-310 .timer-box{color:#e55211;background-color:#f9f9f9;}#element-310 .timer-labels{color:#f65b00;}#element-299{top:0;left:-1.6875rem;height:30.3125rem;width:35.125rem;z-index:5;}#element-299 .cropped{background:url(../../<?php echo $info->s1_product_image ?>) 0 -1.625rem / 35.875rem 33.75rem;}#element-302{top:42.9375rem;left:4.0625rem;height:5.125rem;width:5.4375rem;z-index:22;}#element-303{top:44.6875rem;left:12.5rem;height:1.5rem;width:2.0625rem;z-index:23;}#element-304{top:42.9375rem;left:17.375rem;height:5.125rem;width:4.4375rem;z-index:24;}#element-305{top:43.6875rem;left:25.5rem;height:3.75rem;width:2.75rem;z-index:25;}#element-306{top:43rem;left:33.0625rem;height:4.625rem;width:4.25rem;z-index:26;}#element-307{top:44.75rem;left:41.9375rem;height:1.25rem;width:1.8125rem;z-index:27;}#element-308{top:42.4375rem;left:48.625rem;height:6rem;width:5.25rem;z-index:28;}#element-309{top:0.9375rem;left:49.6875rem;height:1.875rem;width:5rem;z-index:49;}#element-311{top:37rem;left:32.4375rem;height:2.5rem;width:23rem;z-index:54;}#element-311 .btn.btn-effect3d:active{box-shadow:none;}#element-311 .btn:hover{background:#BA3B03;color:#FFFFFF;}#element-311 .btn{background:linear-gradient(#FF791E,#F65B00 50%);color:#FFFFFF;font-size:0.9907rem;font-family:Almarai;font-weight:900;height:2.5rem;width:23rem;border-radius:14px;}#element-244{top:5.1875rem;left:32.1875rem;height:15.5625rem;width:23.25rem;z-index:66;color:#37465A;font-size:4.2724rem;line-height:5.175rem;text-align:right;}#element-244 .x_69f8cf12{text-align:right;line-height:5.1875rem;font-size:4.2724rem;}#element-244 .x_df78330b{color:#2d2d2d;}#element-245{top:20.75rem;left:33.6875rem;height:5.4375rem;width:21.75rem;z-index:67;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:right;}#element-245 .x_695a2def{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-245 .x_df78330b{color:#2d2d2d;}#element-245 strong{font-weight:700;}#element-9{top:29.5rem;left:48.9375rem;height:2.125rem;width:5.875rem;z-index:68;color:#37465A;font-size:1.3113rem;line-height:2.1177rem;text-align:left;}#element-9 .x_4269f585{text-align:left;line-height:2.125rem;font-size:1.3113rem;}#element-9 .x_7b2817bf{color:#000000;}#element-9 strong{font-weight:700;}#element-10{top:30.125rem;left:48.625rem;height:1.3125rem;width:6.25rem;z-index:69;}#element-10 .shape{border-bottom:1px dotted #000000;}#element-247{top:30.5625rem;left:40.8125rem;height:5.125rem;width:14.625rem;z-index:71;color:#37465A;font-size:3.1907rem;line-height:5.1531rem;text-align:left;}#element-247 .x_5205e956{text-align:left;line-height:5.125rem;font-size:3.1907rem;}#element-247 .x_0e1fbe45{color:#f15a24;}#page_block_below_fold{height:79.625rem;max-width:100%;}#page_block_below_fold .section-holder-border{border:0;}#page_block_below_fold .section-block{background:none;height:79.625rem;}#page_block_below_fold .section-holder-overlay{display:none;}#element-18{top:-1.625rem;left:0;height:20.125rem;width:59.9375rem;z-index:6;}#element-22{top:18.4375rem;left:-0.0625rem;height:38.9375rem;width:60rem;z-index:7;}#element-22 .shape{border:0;background:rgb(0,0,0);width:100%;height:100%;}#element-24{top:17.5rem;left:5.5625rem;height:2.625rem;width:9.5rem;z-index:8;}#element-24 .shape{border:0.0625rem solid #A3BAC6;background:rgb(240,243,245);}#element-23{top:18rem;left:9rem;height:1.625rem;width:5.5rem;z-index:9;color:#37465A;font-size:0.9907rem;line-height:1.6rem;text-align:left;}#element-23 .x_3579aa00{text-align:left;line-height:1.625rem;font-size:0.9907rem;}#element-23 .x_7b2817bf{color:#000000;}#element-23 strong{font-weight:700;}#element-26{top:23.25rem;left:22.3125rem;height:19.5rem;width:32.875rem;z-index:10;}element-26 iframe{width:526px;height:312px;}#element-28{top:27.875rem;left:4.5625rem;height:1.3125rem;width:10.5rem;z-index:11;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:right;}#element-28 .x_0d4b6e73{text-align:right;line-height:1.3125rem;font-size:0.805rem;}#element-28 .x_207b1059{text-align:right;line-height:1.3125rem;font-size:0.805rem;}#element-28 .x_f2074b6c{color:#ffffff;}#element-29{top:25.875rem;left:4.5625rem;height:2.625rem;width:10.5rem;z-index:12;color:#37465A;font-size:1.6099rem;line-height:2.6rem;text-align:right;}#element-29 .x_82224667{text-align:right;line-height:2.625rem;font-size:1.6099rem;}#element-29 .x_9fc4e10c{text-align:right;line-height:2.625rem;font-size:1.6099rem;}#element-29 .x_80c53a0c{color:#fbb03b;}#element-29 strong{font-weight:900;}#element-33{top:32.875rem;left:4.5625rem;height:1.3125rem;width:10.5rem;z-index:14;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:right;}#element-33 .x_0d4b6e73{text-align:right;line-height:1.3125rem;font-size:0.805rem;}#element-33 .x_207b1059{text-align:right;line-height:1.3125rem;font-size:0.805rem;}#element-33 .x_f2074b6c{color:#ffffff;}#element-35{top:30.875rem;left:4.5625rem;height:2.625rem;width:10.5rem;z-index:15;color:#37465A;font-size:1.6099rem;line-height:2.6rem;text-align:right;}#element-35 .x_9fc4e10c{text-align:right;line-height:2.625rem;font-size:1.6099rem;}#element-35 .x_80c53a0c{color:#fbb03b;}#element-35 strong{font-weight:900;}#element-39{top:37.9375rem;left:4.5625rem;height:2.625rem;width:10.5rem;z-index:17;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:right;}#element-39 .x_0d4b6e73{text-align:right;line-height:1.3125rem;font-size:0.805rem;}#element-39 .x_207b1059{text-align:right;line-height:1.3125rem;font-size:0.805rem;}#element-39 .x_f2074b6c{color:#ffffff;}#element-41{top:35.9375rem;left:4.5625rem;height:2.625rem;width:10.5rem;z-index:18;color:#37465A;font-size:1.6099rem;line-height:2.6rem;text-align:right;}#element-41 .x_82224667{text-align:right;line-height:2.625rem;font-size:1.6099rem;}#element-41 .x_9fc4e10c{text-align:right;line-height:2.625rem;font-size:1.6099rem;}#element-41 .x_80c53a0c{color:#fbb03b;}#element-41 strong{font-weight:900;}#element-249{top:5.1875rem;left:3.375rem;height:9.5rem;width:21.6875rem;z-index:72;color:#37465A;font-size:1.9814rem;line-height:2.4rem;text-align:right;}#element-249 .x_78f40bb3{text-align:right;line-height:2.375rem;font-size:1.9814rem;}#element-249 .x_7b2817bf{color:#000000;}#element-249 .x_0e1fbe45{color:#f15a24;}#element-217{top:45.375rem;left:7.6875rem;height:3.375rem;width:3.1875rem;z-index:73;}#element-218{top:45.6875rem;left:17.375rem;height:3.4375rem;width:3.875rem;z-index:74;}#element-219{top:45.8125rem;left:28.1875rem;height:3.25rem;width:4.5625rem;z-index:75;}#element-220{top:45.8125rem;left:41.25rem;height:3.4375rem;width:4.1875rem;z-index:76;}#element-221{top:45.8125rem;left:50.9375rem;height:3.5rem;width:3.5625rem;z-index:77;}#element-223{top:49.9375rem;left:4.5625rem;height:3rem;width:6.3125rem;z-index:78;color:#37465A;font-size:0.805rem;line-height:0.975rem;text-align:right;}#element-223 .x_b00b029a{text-align:right;line-height:1rem;font-size:0.805rem;}#element-223 .x_f2074b6c{color:#ffffff;}#element-224{top:50.25rem;left:15.625rem;height:2rem;width:5.75rem;z-index:79;color:#37465A;font-size:0.805rem;line-height:0.975rem;text-align:right;}#element-224 .x_b218f0a4{text-align:right;line-height:1rem;font-size:0.805rem;}#element-224 .x_b00b029a{text-align:right;line-height:1rem;font-size:0.805rem;}#element-224 .x_f2074b6c{color:#ffffff;}#element-225{top:50.3125rem;left:35.875rem;height:3rem;width:9.9375rem;z-index:80;color:#37465A;font-size:0.805rem;line-height:0.975rem;text-align:right;}#element-225 .x_b218f0a4{text-align:right;line-height:1rem;font-size:0.805rem;}#element-225 .x_b00b029a{text-align:right;line-height:1rem;font-size:0.805rem;}#element-225 .x_f2074b6c{color:#ffffff;}#element-227{top:50.375rem;left:49.6875rem;height:2rem;width:4.5rem;z-index:81;color:#37465A;font-size:0.805rem;line-height:0.975rem;text-align:right;}#element-227 .x_b218f0a4{text-align:right;line-height:1rem;font-size:0.805rem;}#element-227 .x_b00b029a{text-align:right;line-height:1rem;font-size:0.805rem;}#element-227 .x_f2074b6c{color:#ffffff;}#element-251{top:50.375rem;left:23.25rem;height:2rem;width:9.9375rem;z-index:82;color:#37465A;font-size:0.805rem;line-height:0.975rem;text-align:right;}#element-251 .x_b218f0a4{text-align:right;line-height:1rem;font-size:0.805rem;}#element-251 .x_b00b029a{text-align:right;line-height:1rem;font-size:0.805rem;}#element-251 .x_f2074b6c{color:#ffffff;}#element-48{top:57.375rem;left:24.0625rem;height:39.375rem;width:35.875rem;z-index:84;}#element-48 .shape{border:0;background:rgb(240,243,245);width:100%;height:100%;}#element-46{top:57.375rem;left:0;height:39.375rem;width:37.9375rem;z-index:85;}#element-46 .cropped{background:url(../../<?php echo $info->s4_image ?>) -1.9375rem 0 / 62.875rem 39.375rem;}#element-57{top:70.8125rem;left:45.375rem;height:1.3125rem;width:8.75rem;z-index:87;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:right;}#element-57 .x_0a10a2df{text-align:right;line-height:1.3125rem;font-size:0.8064rem;}#element-57 .x_c24cab30{color:#6f6f6f;}#element-59{top:69rem;left:46.75rem;height:1.8125rem;width:7.4375rem;z-index:88;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:right;}#element-59 .x_a0393e10{text-align:right;line-height:1.8125rem;font-size:1.1165rem;}#element-59 .x_9d8c476b{text-align:right;line-height:1.8125rem;font-size:1.1165rem;}#element-59 .x_7b2817bf{color:#000000;}#element-59 strong{font-weight:900;}#element-62{top:73.9375rem;left:47.5625rem;height:1.3125rem;width:6.75rem;z-index:90;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:right;}#element-62 .x_0d4b6e73{text-align:right;line-height:1.3125rem;font-size:0.805rem;}#element-62 .x_207b1059{text-align:right;line-height:1.3125rem;font-size:0.805rem;}#element-62 .x_c24cab30{color:#6f6f6f;}#element-64{top:72.125rem;left:45.375rem;height:1.8125rem;width:8.8125rem;z-index:91;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:right;}#element-64 .x_e0a8da1e{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-64 .x_695a2def{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-64 .x_7b2817bf{color:#000000;}#element-64 strong{font-weight:900;}#element-68{top:77.0625rem;left:48.1875rem;height:1.3125rem;width:5.75rem;z-index:93;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:right;}#element-68 .x_0d4b6e73{text-align:right;line-height:1.3125rem;font-size:0.805rem;}#element-68 .x_207b1059{text-align:right;line-height:1.3125rem;font-size:0.805rem;}#element-68 .x_c24cab30{color:#6f6f6f;}#element-70{top:75.25rem;left:45.375rem;height:1.8125rem;width:8.8125rem;z-index:94;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:right;}#element-70 .x_e0a8da1e{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-70 .x_695a2def{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-70 .x_7b2817bf{color:#000000;}#element-70 strong{font-weight:900;}#element-76{top:78.375rem;left:45.375rem;height:1.8125rem;width:8.8125rem;z-index:97;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:right;}#element-76 .x_e0a8da1e{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-76 .x_695a2def{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-76 .x_7b2817bf{color:#000000;}#element-76 strong{font-weight:900;}#element-165{top:64.5625rem;left:46.3125rem;height:1.3125rem;width:7.875rem;z-index:111;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:right;}#element-165 .x_0d4b6e73{text-align:right;line-height:1.3125rem;font-size:0.805rem;}#element-165 .x_207b1059{text-align:right;line-height:1.3125rem;font-size:0.805rem;}#element-165 .x_c24cab30{color:#6f6f6f;}#element-167{top:62.75rem;left:38.6875rem;height:1.8125rem;width:15.5rem;z-index:112;color:#37465A;font-size:0.8546rem;line-height:1.8rem;text-align:right;}#element-167 .x_695a2def{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-167 .x_7b2817bf{color:#000000;}#element-167 strong{font-weight:900;}#element-170{top:67.6875rem;left:46.3125rem;height:1.3125rem;width:7.875rem;z-index:114;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:right;}#element-170 .x_207b1059{text-align:right;line-height:1.3125rem;font-size:0.805rem;}#element-170 .x_c24cab30{color:#6f6f6f;}#element-172{top:65.875rem;left:48.6875rem;height:1.8125rem;width:5.5rem;z-index:115;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:right;}#element-172 .x_695a2def{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-172 .x_7b2817bf{color:#000000;}#element-172 strong{font-weight:900;}#element-252{top:69.1875rem;left:0.9375rem;height:18.375rem;width:23.125rem;z-index:117;color:#37465A;font-size:2.1672rem;line-height:3.0625rem;text-align:right;}#element-252 .x_8670dee8{text-align:right;line-height:3.0625rem;font-size:2.1672rem;}#element-252 .x_80c53a0c{color:#fbb03b;}#element-252 .x_df78330b{color:#2d2d2d;}#page_block_footer{height:127.75rem;max-width:100%;}#page_block_footer .section-holder-border{border:0;}#page_block_footer .section-block{background:none;height:127.75rem;}#page_block_footer .section-holder-overlay{display:none;}#element-93{top:17.1875rem;left:0;height:27.375rem;width:60rem;z-index:19;}#element-93 .shape{border:0;background:rgb(255,255,255);width:100%;height:100%;}#element-98{top:44.375rem;left:0;height:85.75rem;width:60rem;z-index:20;}#element-98 .shape{border:0;background:rgb(0,0,0);width:100%;height:100%;}#element-151{top:49.75rem;left:34.75rem;height:3rem;width:14rem;z-index:31;color:#37465A;font-size:1.4861rem;line-height:1.5rem;text-align:right;}#element-151 .x_3abf7fa6{text-align:right;line-height:1.5rem;font-size:1.4861rem;}#element-151 .x_f2074b6c{color:#ffffff;}#element-151 strong{font-weight:900;}#element-153{top:119.4375rem;left:12.0625rem;height:4.25rem;width:38rem;z-index:32;color:#37465A;font-size:1.7337rem;line-height:2.1rem;text-align:center;}#element-153 .x_446dab97{text-align:center;line-height:2.125rem;font-size:1.7337rem;}#element-153 .x_80c53a0c{color:#fbb03b;}#element-153 strong{font-weight:700;}#element-173{top:49.125rem;left:18.4375rem;height:4.25rem;width:3.625rem;z-index:35;}#element-104{top:84.8125rem;left:5.75rem;height:4.75rem;width:31.4375rem;z-index:36;color:#37465A;font-size:0.743rem;line-height:1.2rem;text-align:right;}#element-104 .x_e86f1825{text-align:right;line-height:1.1875rem;font-size:0.743rem;}#element-104 .x_199030dd{color:#dddddd;}#element-106{top:82.625rem;left:27.5rem;height:1.625rem;width:9.75rem;z-index:37;color:#37465A;font-size:0.805rem;line-height:0.8125rem;text-align:right;}#element-106 .x_9a417bfe{text-align:right;line-height:0.8125rem;font-size:0.805rem;}#element-106 .x_1952c174{text-align:right;line-height:0.8125rem;font-size:0.805rem;}#element-106 .x_65831597{color:#fbfbfb;text-align:right;}#element-106 strong{font-weight:700;}#element-146{top:91.1875rem;left:30.9375rem;height:1.25rem;width:5.8125rem;z-index:38;}#element-175{top:77.25rem;left:38.0625rem;height:18.6875rem;width:18.75rem;z-index:39;}#element-103{top:64.125rem;left:27.1875rem;height:7.125rem;width:26.25rem;z-index:40;color:#37465A;font-size:0.743rem;line-height:1.2rem;text-align:justify;}#element-103 .x_7b6e8d41{text-align:justify;line-height:1.1875rem;font-size:0.743rem;}#element-103 .x_1a2319a0{text-align:justify;line-height:1.1875rem;font-size:0.743rem;}#element-103 .x_199030dd{color:#dddddd;}#element-107{top:61.8125rem;left:43.875rem;height:1.625rem;width:9.6875rem;z-index:41;color:#37465A;font-size:0.805rem;line-height:0.8125rem;text-align:left;}#element-107 .x_5a0f1527{text-align:left;line-height:0.8125rem;font-size:0.805rem;}#element-107 .x_87ee4901{text-align:left;line-height:0.8125rem;font-size:0.805rem;}#element-107 .x_65831597{color:#fbfbfb;}#element-107 strong{font-weight:700;}#element-147{top:72.1875rem;left:47.875rem;height:1rem;width:5.75rem;z-index:42;}#element-176{top:58.125rem;left:6.6875rem;height:18.75rem;width:18.6875rem;z-index:44;}#element-102{top:104.875rem;left:26.625rem;height:7.125rem;width:29.8125rem;z-index:45;color:#37465A;font-size:0.743rem;line-height:1.2rem;text-align:justify;}#element-102 .x_7b6e8d41{text-align:justify;line-height:1.1875rem;font-size:0.743rem;}#element-102 .x_1a2319a0{text-align:justify;line-height:1.1875rem;font-size:0.743rem;}#element-102 .x_199030dd{color:#dddddd;}#element-105{top:102.4375rem;left:46.75rem;height:2.4375rem;width:9.6875rem;z-index:46;color:#37465A;font-size:0.805rem;line-height:0.8125rem;text-align:right;}#element-105 .x_9a417bfe{text-align:right;line-height:0.8125rem;font-size:0.805rem;}#element-105 .x_1952c174{text-align:right;line-height:0.8125rem;font-size:0.805rem;}#element-105 .x_65831597{color:#fbfbfb;}#element-105 strong{font-weight:700;}#element-148{top:112rem;left:50.625rem;height:1.0625rem;width:5.8125rem;z-index:47;}#element-177{top:95.9375rem;left:5.4375rem;height:18.6875rem;width:18.6875rem;z-index:48;}#element-228{top:49.75rem;left:3.9375rem;height:4.5rem;width:12.0625rem;z-index:55;color:#37465A;font-size:1.4861rem;line-height:1.5rem;text-align:right;}#element-228 .x_3abf7fa6{text-align:right;line-height:1.5rem;font-size:1.4861rem;}#element-228 .x_f2074b6c{color:#ffffff;}#element-228 strong{font-weight:900;}#element-229{top:49.125rem;left:50rem;height:4.25rem;width:3.625rem;z-index:65;}#element-193{top:26.0625rem;left:3.3125rem;height:18.375rem;width:55.25rem;z-index:83;}#element-74{top:0.625rem;left:47.5625rem;height:1.3125rem;width:6.75rem;z-index:96;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:right;}#element-74 .x_0d4b6e73{text-align:right;line-height:1.3125rem;font-size:0.805rem;}#element-74 .x_207b1059{text-align:right;line-height:1.3125rem;font-size:0.805rem;}#element-74 .x_c24cab30{color:#6f6f6f;}#element-79{top:3.75rem;left:45.375rem;height:1.3125rem;width:8.8125rem;z-index:99;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:right;}#element-79 .x_0d4b6e73{text-align:right;line-height:1.3125rem;font-size:0.805rem;}#element-79 .x_207b1059{text-align:right;line-height:1.3125rem;font-size:0.805rem;}#element-79 .x_c24cab30{color:#6f6f6f;}#element-81{top:1.9375rem;left:45.375rem;height:1.8125rem;width:8.8125rem;z-index:100;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:right;}#element-81 .x_e0a8da1e{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-81 .x_695a2def{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-81 .x_7b2817bf{color:#000000;}#element-81 strong{font-weight:900;}#element-84{top:6.875rem;left:45.375rem;height:1.3125rem;width:8.8125rem;z-index:102;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:right;}#element-84 .x_0d4b6e73{text-align:right;line-height:1.3125rem;font-size:0.805rem;}#element-84 .x_207b1059{text-align:right;line-height:1.3125rem;font-size:0.805rem;}#element-84 .x_c24cab30{color:#6f6f6f;}#element-86{top:5.0625rem;left:45.375rem;height:1.8125rem;width:8.8125rem;z-index:103;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:right;}#element-86 .x_e0a8da1e{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-86 .x_695a2def{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-86 .x_7b2817bf{color:#000000;}#element-86 strong{font-weight:900;}#element-89{top:10rem;left:45.375rem;height:1.3125rem;width:8.8125rem;z-index:105;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:right;}#element-89 .x_0d4b6e73{text-align:right;line-height:1.3125rem;font-size:0.805rem;}#element-89 .x_207b1059{text-align:right;line-height:1.3125rem;font-size:0.805rem;}#element-89 .x_c24cab30{color:#6f6f6f;}#element-91{top:8.1875rem;left:45.375rem;height:1.8125rem;width:8.8125rem;z-index:106;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:right;}#element-91 .x_e0a8da1e{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-91 .x_695a2def{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-91 .x_7b2817bf{color:#000000;}#element-91 strong{font-weight:900;}#element-160{top:13.125rem;left:42.25rem;height:1.3125rem;width:11.9375rem;z-index:108;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:right;}#element-160 .x_0d4b6e73{text-align:right;line-height:1.3125rem;font-size:0.805rem;}#element-160 .x_207b1059{text-align:right;line-height:1.3125rem;font-size:0.805rem;}#element-160 .x_c24cab30{color:#6f6f6f;}#element-162{top:11.3125rem;left:45.375rem;height:1.8125rem;width:8.8125rem;z-index:109;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:right;}#element-162 .x_e0a8da1e{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-162 .x_695a2def{text-align:right;line-height:1.8125rem;font-size:1.1146rem;}#element-162 .x_7b2817bf{color:#000000;}#element-162 strong{font-weight:900;}#element-263{top:19.6875rem;left:2.1875rem;height:5.6875rem;width:55.5625rem;z-index:119;color:#37465A;font-size:4.0248rem;line-height:5.6875rem;text-align:center;}#element-263 .x_5741eebd{text-align:center;line-height:5.6875rem;font-size:2.0248rem;}#element-263 .x_80c53a0c{color:#fbb03b;}#page-block-9wkstdyrfi5{height:50.875rem;max-width:100%;}#page-block-9wkstdyrfi5 .section-holder-border{border:0;}#page-block-9wkstdyrfi5 .section-block{background:none;height:50.875rem;}#page-block-9wkstdyrfi5 .section-holder-overlay{display:none;}#element-395{top:2.25rem;left:0;height:48.625rem;width:59.9375rem;z-index:155;}#element-395 .shape{border:0;background:rgb(251,176,59);width:100%;height:100%;}#element-394{top:-3.75rem;left:9rem;height:30.0625rem;width:44.375rem;z-index:156;}#element-396{top:25.25rem;left:0;height:25.625rem;width:26.875rem;z-index:157;}#element-397{top:25.25rem;left:26.875rem;height:25.625rem;width:33.0625rem;z-index:158;}#element-397 .shape{border:0;background:rgb(246,225,222);width:100%;height:100%;}#element-399{top:28.3125rem;left:33.875rem;height:6.125rem;width:20.125rem;z-index:160;color:#37465A;font-size:2.1672rem;line-height:3.0625rem;text-align:right;font-weight:800;}#element-399 .x_8670dee8{text-align:right;line-height:3.0625rem;font-size:2.1672rem;}#element-399 .x_7b2817bf{color:#000000;}#element-399 strong{font-weight:800;}#element-399.headline{font-weight:800;}#element-400{top:35.9375rem;left:28.625rem;height:5.5rem;width:25.375rem;z-index:162;color:#37465A;font-size:0.8669rem;line-height:1.4rem;text-align:right;}#element-400 .x_effd9815{text-align:right;line-height:1.375rem;font-size:0.8669rem;}#element-400 strong{font-weight:700;}#element-401{top:44.0625rem;left:41.3125rem;height:2.5rem;width:12.1875rem;z-index:163;}#element-401 .btn.btn-effect3d:active{box-shadow:none;}#element-401 .btn:hover{background:#BA3B03;color:#FFFFFF;}#element-401 .btn{background:linear-gradient(#FF791E,#F65B00 50%);color:#FFFFFF;font-size:0.9907rem;font-family:Almarai;font-weight:900;height:2.5rem;width:12.1875rem;border-radius:14px;}#page-block-ynbtqvrscze{height:97.125rem;max-width:100%;}#page-block-ynbtqvrscze .section-holder-border{border:0;}#page-block-ynbtqvrscze .section-block{background:none;height:97.125rem;}#page-block-ynbtqvrscze .section-holder-overlay{display:none;}#element-388{top:69.3125rem;left:0;height:27.75rem;width:59.9375rem;z-index:33;}#element-388 .shape{border:0;background:rgb(0,0,0);width:100%;height:100%;}#element-382{top:12.625rem;left:0;height:56.875rem;width:59.9375rem;z-index:50;}ol, ul{direction: rtl;}#element-382 .shape{border:0;background:rgb(251,176,59);width:100%;height:100%;}#element-381{top:71.5625rem;left:50rem;height:2.25rem;width:6rem;z-index:51;}#element-149{top:80.6875rem;left:34.875rem;height:14.4375rem;width:21.6875rem;z-index:52;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:right;}#element-149 .x_207b1059{text-align:right;line-height:1.3125rem;font-size:0.805rem;}#element-149 .x_f2074b6c{color:#ffffff;}#element-149 strong{font-weight:700;}#element-232{top:75.3125rem;left:34.8125rem;height:4.5rem;width:21.375rem;z-index:53;color:#37465A;font-size:1.2384rem;line-height:1.5rem;text-align:right;}#element-232 .x_8fd3af70{text-align:right;line-height:1.5rem;font-size:1.2384rem;}#element-232 .x_f2074b6c{color:#ffffff;}#element-232 strong{font-weight:900;}#element-117{top:25.6875rem;left:28.6875rem;height:43.75rem;width:31.25rem;z-index:56;}#element-117 .cropped{background:url(../../<?php echo $info->s9_image ?>) 0 0 / 35.375rem 43.625rem;}#element-115{top:28.4375rem;left:0;height:1.375rem;width:60.125rem;z-index:57;}#element-115 .shape{border-bottom:2px dotted #FBFBFB;}#element-113{top:25.6875rem;left:12.8125rem;height:6.875rem;width:16.75rem;z-index:58;}#element-113 .shape{border:0;background:rgb(241,90,36);}#element-114{top:26.625rem;left:13.5625rem;height:4.75rem;width:15.0625rem;z-index:59;color:#37465A;font-size:0.9936rem;line-height:1.2034rem;text-align:right;}#element-114 .x_8ebbc2ec{text-align:right;line-height:1.1875rem;font-size:0.9936rem;}#element-114 .x_f2074b6c{color:#ffffff;}#element-114 strong{font-weight:700;}#element-118{top:41.8125rem;left:2.8125rem;height:24.75rem;width:25.75rem;z-index:61;color:#37465A;font-size:0.8694rem;line-height:1.404rem;text-align:right;}#element-118 .x_3a9656a6{text-align:right;line-height:1.375rem;font-size:0.8694rem;}#element-118 .x_db92dcc1{text-align:right;line-height:1.375rem;font-size:0.8694rem;}#element-118 .x_7b2817bf{color:#000000;}#element-118 .x_e1c17884{color:#000001;}#element-118 strong{font-weight:700;}#element-215{top:33.1875rem;left:4.625rem;height:8rem;width:24.8125rem;z-index:62;color:#37465A;font-size:1.9871rem;line-height:2.0057rem;text-align:right;}#element-215 .x_dcba9f5f{text-align:right;line-height:2rem;font-size:1.9871rem;}#element-215 .x_f2074b6c{color:#ffffff;}#element-215 strong{font-weight:900;}#element-364{top:0;left:0;height:12.625rem;width:59.9375rem;z-index:63;}#element-364 .shape{border:0;background:rgb(240,243,245);width:100%;height:100%;}#element-389{top:68.0625rem;left:15.5625rem;height:2.5rem;width:13.75rem;z-index:64;}#element-389 .btn.btn-effect3d:active{box-shadow:none;}#element-389 .btn:hover{background:#BA3B03;color:#FFFFFF;}#element-389 .btn{background:linear-gradient(#FF791E,#F65B00 50%);color:#FFFFFF;font-size:0.9907rem;font-family:Almarai;font-weight:900;height:2.5rem;width:13.75rem;border-radius:14px;}#element-111{top:18.0625rem;left:5.75rem;height:4.125rem;width:48.75rem;z-index:120;color:#37465A;font-size:0.8669rem;line-height:1.4rem;text-align:right;}#element-111 .x_effd9815{text-align:right;line-height:1.375rem;font-size:0.8669rem;}#element-111 .x_7b2817bf{color:#000000;}#element-267{top:2.125rem;left:-1rem;height:7.875rem;width:55.5625rem;z-index:121;color:#37465A;font-size:2.1672rem;line-height:2.625rem;text-align:right;}#element-267 .x_0def92d0{text-align:right;line-height:2.625rem;font-size:2.1672rem;}#element-267 .x_7b2817bf{color:#000000;}#element-376{top:73.375rem;left:9.25rem;height:6.5rem;width:5.75rem;z-index:125;}#element-377{top:73.375rem;left:22.5rem;height:6.6875rem;width:5.5625rem;z-index:126;}#element-378{top:83.3125rem;left:7rem;height:2.6875rem;width:3.75rem;z-index:127;}#element-379{top:81.8125rem;left:16.25rem;height:5.75rem;width:4.25rem;z-index:128;}#element-380{top:83.3125rem;left:26.25rem;height:2.6875rem;width:3.6875rem;z-index:136;}#page-block-mg6u024zjmk{height:70.3125rem;max-width:100%;}#page-block-mg6u024zjmk .section-holder-border{border:0;}#page-block-mg6u024zjmk .section-block{background:none;height:70.3125rem;}#page-block-mg6u024zjmk .section-holder-overlay{display:none;}#element-350{top:50.8125rem;left:0;height:5.75rem;width:59.9375rem;z-index:21;}#element-350 .shape{border:0;background:rgb(0,0,0);width:100%;height:100%;}#element-328{top:0.125rem;left:0;height:50.875rem;width:59.9375rem;z-index:34;}#element-328 .shape{border:0;background:rgb(255,255,255);width:100%;height:100%;}#element-337{top:56.4375rem;left:0;height:13.9375rem;width:59.9375rem;z-index:122;}#element-337 .shape{border:0;background:rgb(251,176,59);width:100%;height:100%;}#element-348{top:13.75rem;left:39.1875rem;height:8.5rem;width:19.25rem;z-index:123;}#element-345{top:4.375rem;left:28rem;height:21.1875rem;width:22.375rem;z-index:124;}#element-340{top:58.9375rem;left:5.5625rem;height:5.9375rem;width:6.25rem;z-index:129;}#element-339{top:61.5625rem;left:15.0625rem;height:1.75rem;width:2.375rem;z-index:130;}#element-338{top:59.5rem;left:21.0625rem;height:5.9375rem;width:5.3125rem;z-index:131;}#element-341{top:60.3125rem;left:30.25rem;height:4.0625rem;width:3rem;z-index:132;}#element-342{top:59.6875rem;left:37.125rem;height:5.25rem;width:4.75rem;z-index:133;}#element-343{top:61.625rem;left:44.9375rem;height:1.5rem;width:2.0625rem;z-index:134;}#element-344{top:58.9375rem;left:50.25rem;height:6.9375rem;width:5.9375rem;z-index:135;}#element-349{top:49.4375rem;left:5.0625rem;height:4.5625rem;width:18.375rem;z-index:137;font-size:4.5625rem;}#element-349 .timer-box{color:#e55211;background-color:#f9f9f9;}#element-349 .timer-labels{color:#f65b00;}#element-275{top:36.1875rem;left:47.375rem;height:3rem;width:8.25rem;z-index:138;color:#37465A;font-size:1.8576rem;line-height:3rem;text-align:left;}#element-275 .x_8470ce88{text-align:left;line-height:3rem;font-size:1.8576rem;}#element-275 .x_7b2817bf{color:#000000;}#element-275 strong{font-weight:700;}#element-277{top:37rem;left:47.0625rem;height:1.375rem;width:8.75rem;z-index:139;}#element-277 .shape{border-bottom:2px dotted #000000;}#element-279{top:37.75rem;left:35.6875rem;height:7.3125rem;width:20.6875rem;z-index:141;color:#37465A;font-size:4.5201rem;line-height:7.3rem;text-align:left;}#element-279 .x_4b9c7db4{text-align:left;line-height:7.3125rem;font-size:4.5201rem;}#element-279 .x_0e1fbe45{color:#f15a24;}#element-346{top:43.4375rem;left:40.75rem;height:1.625rem;width:14.25rem;z-index:143;color:#37465A;font-size:0.9907rem;line-height:1.6rem;text-align:right;}#element-346 .x_bb1de03d{text-align:right;line-height:1.625rem;font-size:0.9907rem;}#element-346 .x_7b2817bf{color:#000000;}#element-269{top:28.4375rem;left:37.25rem;height:6.625rem;width:19.1875rem;z-index:145;color:#37465A;font-size:2.7245rem;line-height:3.3rem;text-align:right;}#element-269 .x_6f2685b9{text-align:right;line-height:3.3125rem;font-size:2.7245rem;}#element-269 .x_e1c17884{color:#000001;}#element-347{top:26.375rem;left:51.9375rem;height:1.5625rem;width:4.1875rem;z-index:146;}#element-329{top:-5.8125rem;left:4.5625rem;height:11.875rem;width:27.875rem;z-index:147;}#element-329 .shape{border:0;background:rgb(255,255,255);width:100%;height:100%;}#element-268{top:-4.6875rem;left:6.1875rem;height:9.9375rem;width:24rem;z-index:148;color:#37465A;font-size:2.7245rem;line-height:3.3rem;text-align:right;}#element-268 .x_6f2685b9{text-align:right;line-height:3.3125rem;font-size:2.7245rem;}#element-268 .x_0e1fbe45{color:#f15a24;}#element-268 .x_7b2817bf{color:#000000;}#element-282{top:45.4375rem;left:5.0625rem;height:1.5625rem;width:12.375rem;z-index:149;color:#37465A;font-size:1.1146rem;line-height:1.575rem;text-align:center;}#element-282 .x_bcbce646{text-align:center;line-height:1.5625rem;font-size:1.1146rem;}#element-282 .x_7b2817bf{color:#000000;}#element-282 strong{font-weight:800;}#element-284{top:45rem;left:23.8125rem;height:2.375rem;width:3.25rem;z-index:150;}#element-14{top:4.625rem;left:5.25rem;height:36.375rem;width:21.75rem;z-index:152;}#element-14 .shape{width:100%;height:100%;border:0.0625rem solid #A3BAC6;border-radius:0.5rem 0.5rem 0.5rem 0.5rem;background:rgb(255,255,255);}#element-11{top:5.875rem;left:7.125rem;height:33.1875rem;width:18.25rem;z-index:153;}.notification-text{font-size:3.125rem;}.form{font-size:0.8125rem;}.form-input{font-size:0.9375rem;height:2.6875rem;}.form-textarea{height:6.25rem;}.form-label-title{margin:0.3125rem 0 0.5rem;font-size:0.89375rem;padding:0;line-height:1.1875rem;}.form-multiple-label{margin-bottom:0.625rem;font-size:0.9375rem;line-height:1.1875rem;padding:0;}.form-multiple-label:empty{display:inline;}.form-checkbox-label:after{top:0.1rem;}.form-label-outside{margin-bottom:0;}.form-multiple-label:before{transition:background-color 0.1s,border 0.1s;}.form-radio-label:hover:before{border:0.3125rem solid #9bc7fd;}.form-messagebox{transform:translate(0);display:flex;}.form-messagebox-left{transform:translateX(-100%);left:-0.625rem;}.form-messagebox-right{transform:translateX(100%);right:-0.625rem;}.form-messagebox:before{top:calc(50% - 0.1875rem);left:auto;}.form-messagebox-left:before{right:-0.1875rem;}.form-messagebox-right:before{left:-0.1875rem;}#element-11 .btn.btn-product-cart.btn-effect3d:active{box-shadow:none;}#element-11 .btn.btn-product-cart:hover{background:#C34B21;color:#FFFFFF;}#element-11 .btn.btn-product-cart{background:linear-gradient(#FF7842,#F15A24 50%);color:#FFFFFF;font-size:1.1146rem;font-family:Almarai;font-weight:800;height:3.25rem;width:17.75rem;border-radius:15px;}#element-11 .form-label{color:#B4B4B4;}#element-11 ::placeholder{color:#B4B4B4;}#element-11 .form-input{color:#000000;background-color:#FFFFFF;border-color:#FBB03B;}#element-11 .user-invalid{border-color:#E12627;}#element-11 input::placeholder,#element-11 .form-label-inside{color:#B4B4B4;}#element-11 select.valid{color:#000000;}#element-11 .form-btn-geometry{top:34.0625rem;left:0;height:3.25rem;width:17.75rem;z-index:153;}#element-285{top:51.8125rem;left:27.875rem;height:4.875rem;width:24rem;z-index:154;color:#37465A;font-size:1.3622rem;line-height:1.65rem;text-align:right;}#element-285 .x_28214ad7{text-align:right;line-height:1.625rem;font-size:1.3622rem;}#element-285 .x_0e1fbe45{color:#f15a24;}#element-285 .x_e1c17884{color:#000001;}#element-409{top:43.5rem;left:54.5rem;height:1.625rem;width:1.625rem;z-index:164;color:#37465A;font-size:0.9907rem;line-height:1.6rem;text-align:right;}#element-409 .x_bb1de03d{text-align:right;line-height:1.625rem;font-size:0.9907rem;}#element-409 .x_7b2817bf{color:#000000;}#page-block-j8wabyhcyyb{height:6.25rem;max-width:100%;}#page-block-j8wabyhcyyb .section-holder-border{border:0;}#page-block-j8wabyhcyyb .section-block{background:none;height:6.25rem;}#page-block-j8wabyhcyyb .section-holder-overlay{display:none;}#element-137{top:0;left:0;height:6.125rem;width:60rem;z-index:29;}#element-137 .shape{border:0;background:rgb(0,0,0);width:100%;height:100%;}#element-138{top:2.375rem;left:5.3125rem;height:1.3125rem;width:51.125rem;z-index:30;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:center;}#element-138 .x_077c8203{text-align:center;line-height:1.3125rem;font-size:0.805rem;}#element-138 .x_70ee4658{text-align:center;line-height:1.3125rem;font-size:0.805rem;}#element-138 .x_80c53a0c{color:#fbb03b;}}@media all and (-ms-high-contrast:none),(-ms-high-contrast:active){.form-messagebox{height:auto !important;}} 
	html*{
	  direction:rtl !important; 
	}
	.form-input{
	  direction:rtl !important; 
	}
	.form-select{
	  background:none !important;
	}
	#element-11 .form-input{ 
	direction:rtl !important;
	}
  </style>
<?php }?>  
<script>
var countDownDate = new Date().getTime()+ (13 * 60 * 1000);
var x = setInterval(function() {
  var now = new Date().getTime();
  var distance = countDownDate - now;
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
  if (distance <= 0) {
    countDownDate = new Date().getTime()+ (13 * 60 * 1000);
  }
  else{
    $('.timer-number[data-at="timer-number-days"]').html(("0" + days).slice(-2));
    $('.timer-number[data-at="timer-number-hours"]').html(("0" + hours).slice(-2));
    $('.timer-number[data-at="timer-number-minutes"]').html(("0" + minutes).slice(-2));
    $('.timer-number[data-at="timer-number-seconds"]').html(("0" + seconds).slice(-2));
  }
}, 1000);
</script>
</head>
<body id="landing-page">
<main>
<?php if($this->selected_lang->id !=2) {?>
    <section class="section section-relative " id="page-block-l3qivrhmtw" data-at="section">
   
  <div class="section-holder-border item-block item-absolute" data-at="section-border"></div>
  <div class="section-holder-overlay item-block item-absolute" data-at="section-overlay"></div>
  <div class="section-block">
    <div class="section-inner section-fit section-relative">
        <div class="widget item-absolute " id="element-290">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute  " id="element-291">
  <div class="contents cropped item-block" data-at="image-cropp">
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-292" data-at="paragraph">
  <div class="contents">
    <p class="x_ee409d31 x_78798708"><span class="x_7b2817bf">THE AFFORDABLE</span></p><p class="x_ee409d31 x_78798708"><span class="x_7b2817bf"><?php echo $info->s1_device_name ?></span></p><p class="x_ee409d31 x_78798708"><span class="x_7b2817bf"><strong>JUST GOT MORE AFFORDABLE.</strong></span></p>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-293" data-at="paragraph">
  <div class="contents">
    <p class="x_d4149e5e x_a7dced57"><span class="x_7b2817bf"><?php echo $info->s1_heading ?></span></p>
  </div>
</div>

        <div class="widget item-absolute  " id="element-294">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image " data-at="image" alt="" src="../uploads/promotions/51205648-0-German.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-295">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image " data-at="image" alt="" src="../uploads/promotions/51205643-0-CE.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-296">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image " data-at="image" alt="" src="../uploads/promotions/51205638-0-Money-Back.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-297">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image " data-at="image" alt="" src="../uploads/promotions/51205633-0-RoHS.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-299">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image " data-at="image" alt="" src="../uploads/promotions/51205623-0-FC.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-300">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image " data-at="image" alt="" src="../uploads/promotions/51205618-0-Warranty.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-301">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image " data-at="image" alt="" src="../<?php echo $info->image_brand ?>">
  </div>
</div>

        <div class="widget item-absolute item-block  " id="element-302">    
        <p style="font-size:1.5rem">This offer will expire in</p>
    <div class="timer timer-text-bottom item-block" data-date="2020-10-10T00:00:00.181Z" data-timezone="4">
        <div class="timer-labels timer-labels-top hidden-mobile" data-at="timer-top-labels">
            <div class="timer-column timer-label timer-days" data-at="timer-days">
                days
            </div>
            <div class="timer-column timer-label timer-hours" data-at="timer-hours">
                hours
            </div>
            <div class="timer-column timer-label timer-minutes" data-at="timer-minutes">
                minutes
            </div>
            <div class="timer-column timer-label timer-seconds" data-at="timer-seconds">
                seconds
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="timer-date item-block">
            <div class="timer-column timer-box timer-box-days">
                <div class="timer-number js-timer-days" data-at="timer-number-days">00</div>
            </div>
            <div class="timer-column timer-box timer-box-hours">
                <div class="timer-number js-timer-hours" data-at="timer-number-hours">00</div>
            </div>
            <div class="timer-column timer-box timer-box-minutes">
                <div class="timer-number js-timer-minutes" data-at="timer-number-minutes">00</div>
            </div>
            <div class="timer-column timer-box timer-box-seconds">
                <div class="timer-number js-timer-seconds" data-at="timer-number-seconds">00</div>
            </div>
        </div>
        <div class="timer-labels timer-labels-bottom hidden-mobile" data-at="timer-bottom-labels">
            <div class="timer-column timer-label timer-days" data-at="timer-days">
                days
            </div>
            <div class="timer-column timer-label timer-hours" data-at="timer-hours">
                hours
            </div>
            <div class="timer-column timer-label timer-minutes" data-at="timer-minutes">
                minutes
            </div>
            <div class="timer-column timer-label timer-seconds" data-at="timer-seconds">
                seconds
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
        <div class="widget item-absolute  " id="element-303">
  <a href="#page-block-ceqi3wwonu8" id="link-d4u0zltplek" class="onpage-link btn btn-shadow   item-block" data-at="button" data-link-d4u0zltplek="">
      BUY NOW
  </a>
</div>

        <div class="widget item-absolute paragraph  " id="element-124" data-at="paragraph">
  <div class="contents">
    <p class="x_68437d79 x_460c3378"><span class="x_0e1fbe45"><?php echo price_formatted(calculate_product_price($product->price, $product->discount_rate), $product->currency); ?>
</span></p><p class="x_68437d79 x_460c3378"><span class="x_0e1fbe45">
</span></p>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-132" data-at="paragraph">
  <div class="contents">
    <p class="x_30e7fb47 x_2d956c7b"><span class="x_7b2817bf"> <?php echo price_formatted($product->price, $product->currency); ?>&nbsp;</span></p>
  </div>
</div>

        <div class="widget item-absolute " id="element-134">
  <div class="contents shape  line-horizontal line " data-at="shape"></div>
</div>

        <div class="widget item-absolute paragraph  " id="element-284" data-at="paragraph">
  <div class="contents">
    <p class="x_3579aa00 x_c9994eb2"><span class="x_7b2817bf">Final price will include VAT</span></p>
  </div>
</div>

    </div>
  </div>
</section>

    <section class="section section-relative " id="page_block_below_fold" data-at="section">
   
  <div class="section-holder-border item-block item-absolute" data-at="section-border"></div>
  <div class="section-holder-overlay item-block item-absolute" data-at="section-overlay"></div>
  <div class="section-block">
    <div class="section-inner section-fit section-relative">
        <div class="widget item-absolute  " id="element-18">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image " data-at="image" style="min-height: 250px;width: auto;max-width: 100%;" alt="" src="../<?php echo $info->s2_image ?>">
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-19" data-at="paragraph">
  <div class="contents">
    <p class="x_e985c108 x_415503c6"><span class="x_7b2817bf"><?php echo $info->s2_heading ?></span></p>
  </div>
</div>

        <div class="widget item-absolute " id="element-22">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute  " id="element-26">
  <div class="contents item-block">
    <iframe class="item-block video" type="text/html" data-src="<?php echo $info->s3_video_url ?>" allow="autoplay" allowfullscreen="" data-at="video-youtube" frameborder="0" src="<?php echo $info->s3_video_url ?>">
    </iframe>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-28" data-at="paragraph">
  <div class="contents">
    <p class="x_26743634 x_c6814124"><span class="x_f2074b6c"><?php echo $info->s3_sub_text_1 ?></span></p>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-29" data-at="paragraph">
  <div class="contents">
    <p class="x_f4b5a1e3 x_21d8ef23"><span class="x_80c53a0c"><?php echo $info->s3_sub_number_1 ?></span></p>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-33" data-at="paragraph">
  <div class="contents">
    <p class="x_26743634 x_c6814124"><span class="x_f2074b6c"><?php echo $info->s3_sub_text_2 ?></span></p>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-35" data-at="paragraph">
  <div class="contents">
    <p class="x_f4b5a1e3 x_21d8ef23"><span class="x_80c53a0c"><?php echo $info->s3_sub_number_2 ?></span></p>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-39" data-at="paragraph">
  <div class="contents">
    <p class="x_26743634 x_c6814124"><span class="x_f2074b6c"><?php echo $info->s3_sub_text_3 ?></span></p>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-41" data-at="paragraph">
  <div class="contents">
    <p class="x_f4b5a1e3 x_21d8ef23"><span class="x_80c53a0c"><?php echo $info->s3_sub_number_3 ?></span></p>
  </div>
</div>

        <div class="widget item-absolute " id="element-48">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute  " id="element-46">
  <div class="contents cropped item-block" data-at="image-cropp">
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-47" data-at="paragraph">
  <div class="contents">
    <p class="x_a33937de x_415503c6"><span class="x_80c53a0c"><?php echo $info->s4_heading ?></span></p>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-165" data-at="paragraph">
  <div class="contents">
    <p class="x_26743634 x_d93e4d4c"><?php echo $info->s4_details ?></p>
  </div>
</div>

        <div class="widget item-absolute  " id="element-217">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../<?php echo $info->s3_main_image_1 ?>" data-src="../<?php echo $info->s3_main_image_1 ?>"  data-retina-src="../<?php echo $info->s3_main_image_1 ?>">
  </div>
</div>

        <div class="widget item-absolute  " id="element-218">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../<?php echo $info->s3_main_image_2 ?>" data-src="../<?php echo $info->s3_main_image_2 ?>" data-retina-src="../<?php echo $info->s3_main_image_2 ?>">
  </div>
</div>

        <div class="widget item-absolute  " id="element-219">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../<?php echo $info->s3_main_image_3 ?>" data-src="../<?php echo $info->s3_main_image_3 ?>" data-retina-src="../<?php echo $info->s3_main_image_3 ?>">
  </div>
</div>

        <div class="widget item-absolute  " id="element-220">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../<?php echo $info->s3_main_image_4 ?>" data-src="../<?php echo $info->s3_main_image_4 ?>" data-retina-src="../<?php echo $info->s3_main_image_4 ?>">
  </div>
</div>

        <div class="widget item-absolute  " id="element-221">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../<?php echo $info->s3_main_image_5 ?>" data-src="../<?php echo $info->s3_main_image_5 ?>" data-retina-src="../<?php echo $info->s3_main_image_5 ?>">
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-223" data-at="paragraph">
  <div class="contents">
    <p class="x_70b443d1 x_7ca85f40"><span class="x_f2074b6c"><?php echo $info->s3_main_text_1 ?></span></p>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-224" data-at="paragraph">
  <div class="contents">
    <p class="x_70b443d1 x_7ca85f40"><span class="x_f2074b6c"><?php echo $info->s3_main_text_2 ?></span></p>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-225" data-at="paragraph">
  <div class="contents">
    <p class="x_70b443d1 x_7ca85f40"><span class="x_f2074b6c"><?php echo $info->s3_main_text_3 ?></span></p>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-226" data-at="paragraph">
  <div class="contents">
    <p class="x_70b443d1 x_7ca85f40"><span class="x_f2074b6c"><?php echo $info->s3_main_text_4 ?></span></p>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-227" data-at="paragraph">
  <div class="contents">
    <p class="x_70b443d1 x_7ca85f40"><span class="x_f2074b6c"><?php echo $info->s3_main_text_5 ?></span></p>
  </div>
</div>

    </div>
  </div>
</section>

    <section class="section section-relative " id="page_block_footer" data-at="section">
   
  <div class="section-holder-border item-block item-absolute" data-at="section-border"></div>
  <div class="section-holder-overlay item-block item-absolute" data-at="section-overlay"></div>
  <div class="section-block">
    <div class="section-inner section-fit section-relative">
        <div class="widget item-absolute " id="element-93">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute headline  " id="element-95" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_49caa87c x_178516c5"><span class="x_80c53a0c"><?php echo $info->s5_heading ?></span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute " id="element-98">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute headline hidden-mobile " id="element-151" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_275d245b x_9e69c46b"><span class="x_f2074b6c">CUSTOMER SATISFACTION IS OUR </span><span class="x_80c53a0c">No. 1</span><span class="x_f2074b6c"> PRIORITY.&nbsp;</span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute headline  " id="element-153" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_bdb4a4e4 x_ce9a991a"><span class="x_80c53a0c">WE HAVE <strong>OVER 10,000+ HAPPY CUSTOMERS</strong> AROUND THE WORLD USING OUR PRODUCT!</span></p>
    </h1>
  </div>
</div>


        <div class="widget item-absolute hidden-mobile " id="element-173">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../uploads/promotions/51190728-0-Trophy.png" data-retina-src="../uploads/promotions/51190728-0-Trophy.png">
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-104" data-at="paragraph">
  <div class="contents">
    <p class="x_4cb1d84e x_077c8203"></p><p class="x_1a2319a0 x_70ee4658"></p><p class="x_1a2319a0 x_70ee4658"></p><p class="x_1a2319a0 x_70ee4658"></p><p class="x_1a2319a0 x_70ee4658"><span class="x_199030dd"><?php echo $info->s6_review_comment_2 ?></span></p>
  </div>
</div>

        <div class="widget item-absolute headline  " id="element-106" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_c9387aab x_c2a5648c"></p><p class="x_1952c174 x_9f7a47db"></p><p class="x_1952c174 x_9f7a47db"><span class="x_65831597"><strong><?php echo $info->s6_review_name_2 ?></strong></span></p><p class="x_1952c174 x_9f7a47db"><span class="x_65831597"><?php echo $info->s6_review_location_2 ?></span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute  " id="element-146">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../uploads/promotions/51163123-0-4star.png" data-src="../uploads/promotions/51163123-0-4star.png" data-retina-src="../uploads/promotions/51163123-0-4star.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-175">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../<?php echo $info->s6_review_image_2 ?>" data-src="../<?php echo $info->s6_review_image_2 ?>" data-retina-src="../<?php echo $info->s6_review_image_2 ?>">
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-103" data-at="paragraph">
  <div class="contents">
    <p class="x_4cb1d84e x_077c8203"></p><p class="x_1a2319a0 x_70ee4658"></p><p class="x_1a2319a0 x_70ee4658"><span class="x_199030dd"><?php echo $info->s6_review_comment_1 ?></span></p><p class="x_1a2319a0 x_70ee4658"></p>
  </div>
</div>

        <div class="widget item-absolute headline  " id="element-107" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_c9387aab x_c2a5648c"></p><p class="x_87ee4901 x_9f7a47db"></p><p class="x_87ee4901 x_9f7a47db"><span class="x_65831597"><strong><?php echo $info->s6_review_name_1 ?></strong></span></p><p class="x_87ee4901 x_9f7a47db"><span class="x_65831597"><?php echo $info->s6_review_location_1 ?></span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute  " id="element-147">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../uploads/promotions/51163118-0-5star.png" data-src="../uploads/promotions/51163118-0-5star.png" data-retina-src="../uploads/promotions/51163118-0-5star.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-176">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../<?php echo $info->s6_review_image_1 ?>" data-src="../<?php echo $info->s6_review_image_1 ?>" data-retina-src="../<?php echo $info->s6_review_image_1 ?>">
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-102" data-at="paragraph">
  <div class="contents">
    <p class="x_4cb1d84e x_077c8203"></p><p class="x_1a2319a0 x_70ee4658"></p><p class="x_1a2319a0 x_70ee4658"></p><p class="x_1a2319a0 x_70ee4658"><span class="x_199030dd"><?php echo $info->s6_review_comment_3 ?></span></p>
  </div>
</div>

        <div class="widget item-absolute headline  " id="element-105" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_c9387aab x_c2a5648c"></p><p class="x_87ee4901 x_9f7a47db"><span class="x_65831597"><strong><?php echo $info->s6_review_name_3 ?></strong></span></p><p class="x_87ee4901 x_9f7a47db"><span class="x_65831597"><?php echo $info->s6_review_location_3 ?></span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute  " id="element-148">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../uploads/promotions/51163128-0-45star.png" data-src="../uploads/promotions/51163128-0-45star.png" data-retina-src="../uploads/promotions/51163128-0-45star.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-177">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../<?php echo $info->s6_review_image_3 ?>" data-src="../<?php echo $info->s6_review_image_3 ?>" data-retina-src="../<?php echo $info->s6_review_image_3 ?>">
  </div>
</div>

        <div class="widget item-absolute  " id="element-193">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../<?php echo $info->s5_image ?>" data-src="../<?php echo $info->s5_image ?>" data-retina-src="../<?php echo $info->s5_image ?>">
  </div>
</div>

        <div class="widget item-absolute headline  " id="element-228" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_275d245b x_24e44f2f"><span class="x_f2074b6c">PEOPLE'S&nbsp;</span></p><p class="x_275d245b x_24e44f2f"><span class="x_80c53a0c">No. 1</span><span class="x_f2074b6c"> CHOICE.&nbsp;</span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute  " id="element-229">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../uploads/promotions/51190728-0-Trophy.png" data-src="../uploads/promotions/51190728-0-Trophy.png" data-retina-src="../uploads/promotions/51190728-0-Trophy.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-420">
  <a href="#page-block-ceqi3wwonu8" id="link-jud6fhf4kzl" class="onpage-link btn btn-shadow   item-block" data-at="button" data-link-jud6fhf4kzl="">
      BUY NOW
  </a>
</div>

    </div>
  </div>
</section>

    <section class="section section-relative " id="page-block-i82xvkz7ji" data-at="section">
   
  <div class="section-holder-border item-block item-absolute" data-at="section-border"></div>
  <div class="section-holder-overlay item-block item-absolute" data-at="section-overlay"></div>
  <div class="section-block">
    <div class="section-inner section-fit section-relative">
        <div class="widget item-absolute " id="element-395">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute  " id="element-394">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../<?php echo $info->s6_review_image ?>" data-src="../<?php echo $info->s6_review_image ?>" data-retina-src="../<?php echo $info->s6_review_image ?>">
  </div>
</div>

        <div class="widget item-absolute  " id="element-396">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../<?php echo $info->s7_image ?>" data-src="../<?php echo $info->s7_image ?>" data-retina-src="../<?php echo $info->s7_image ?>">
  </div>
</div>

        <div class="widget item-absolute " id="element-397">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute headline  " id="element-398" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_9b7a1e0d x_a3e05b5f"><span class="x_7b2817bf">GET YOUR&nbsp;</span></p><p class="x_9b7a1e0d x_a3e05b5f"><span class="x_7b2817bf"><?php echo $info->s7_heading ?></span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute headline  " id="element-399" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_8ae9aa76 x_b6c3675a"><span class="x_7b2817bf">DON'T FORGET TO</span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-400" data-at="paragraph">
  <div class="contents">
    <p class="x_48aa50a2 x_67538361"><span class="x_7b2817bf"><?php echo $info->s7_details ?></span></p>
  </div>
</div>

        <div class="widget item-absolute  " id="element-401">
  <a href="#page-block-ceqi3wwonu8" id="link-18lk432jad7" class="onpage-link btn btn-shadow   item-block" data-at="button" data-link-18lk432jad7="">
      BUY NOW
  </a>
</div>


    </div>
  </div>
</section>

    <section class="section section-relative " id="page-block-5643epclur5" data-at="section">
   
  <div class="section-holder-border item-block item-absolute" data-at="section-border"></div>
  <div class="section-holder-overlay item-block item-absolute" data-at="section-overlay"></div>
  <div class="section-block">
    <div class="section-inner section-fit section-relative">
        <div class="widget item-absolute " id="element-380">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute " id="element-361">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute paragraph  " id="element-363" data-at="paragraph">
  <div class="contents">
    <p class="x_48aa50a2 x_2830259f"><span class="x_7b2817bf"><?php echo $info->s9_details ?> </span></p>
  </div>
</div>

        <div class="widget item-absolute headline  " id="element-362" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_e985c108 x_0a56100c"><span class="x_7b2817bf"><?php echo $info->s8_heading ?></span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute hidden-mobile " id="element-367">
  <div class="contents cropped item-block" data-at="image-cropp">
  </div>
</div>

        <div class="widget item-absolute " id="element-366">
  <div class="contents shape  line-horizontal line " data-at="shape"></div>
</div>

        <div class="widget item-absolute " id="element-364">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute paragraph  " id="element-365" data-at="paragraph">
  <div class="contents">
    <p class="x_178925bc x_8d839f14"><span class="x_f2074b6c">STILL NOT SURE</span></p><p class="x_178925bc x_8d839f14"><span class="x_f2074b6c">IF THIS IS FOR YOU?</span></p><p class="x_178925bc x_8d839f14"><span class="x_f2074b6c"><br></span></p><p class="x_178925bc x_8d839f14"><span class="x_f2074b6c">KEEP READING.</span></p>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-368" data-at="paragraph">
  <div class="contents">
    <?php echo $info->s9_description ?>
  </div>
</div>

        <div class="widget item-absolute headline  " id="element-371" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_df21e2f7 x_03299323"><span class="x_f2074b6c"><?php echo $info->s9_heading ?></span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute  " id="element-381">
  <a href="#page-block-ceqi3wwonu8" id="link-c5b3bfiqqeb" class="onpage-link btn btn-shadow   item-block" data-at="button" data-link-c5b3bfiqqeb="">
      BUY NOW
  </a>
</div>

        <div class="widget item-absolute " id="element-370">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute paragraph  " id="element-369" data-at="paragraph">
  <div class="contents">
    <p class="x_26743634 x_838c6f97"><span class="x_f2074b6c"><?php echo $info->s10_description ?><br></p><ul class="x_26743634 x_838c6f97"><li><span class="x_6ab41614">&nbsp;<?php echo $info->s10_point_1 ?>&nbsp;</span></li></ul><ul class="x_26743634 x_838c6f97"><li><span class="x_6ab41614"><?php echo $info->s10_point_2 ?></span></li></ul>
  </div>
</div>

        <div class="widget item-absolute  " id="element-373">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../uploads/promotions/51209298-0-Asset-8.png" data-src="../uploads/promotions/51209298-0-Asset-8.png" data-retina-src="../uploads/promotions/51209298-0-Asset-8.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-375">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../uploads/promotions/51209288-0-Asset-10.png" data-src="../uploads/promotions/51209288-0-Asset-10.png" data-retina-src="../uploads/promotions/51209288-0-Asset-10.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-376">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../uploads/promotions/51209283-0-Asset-11.png" data-src="../uploads/promotions/51209283-0-Asset-11.png" data-retina-src="../uploads/promotions/51209283-0-Asset-11.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-377">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../uploads/promotions/51209278-0-Asset-12.png" data-src="../uploads/promotions/51209278-0-Asset-12.png" data-retina-src="../uploads/promotions/51209278-0-Asset-12.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-378">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../uploads/promotions/51209273-0-Asset-13.png" data-src="../uploads/promotions/51209273-0-Asset-13.png" data-retina-src="../uploads/promotions/51209273-0-Asset-13.png">
  </div>
</div>

        <div class="widget item-absolute headline  " id="element-372" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_7be91d29 x_6c8b1a85"><span class="x_f2074b6c">NOT COMPLETELY SATISFIED?&nbsp;</span></p><p class="x_7be91d29 x_6c8b1a85"><span class="x_f2074b6c">NOT A PROBLEM!</span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute  " id="element-379">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../<?php echo $info->image_brand ?>" data-src="../<?php echo $info->image_brand ?>" data-retina-src="../<?php echo $info->image_brand ?>">
  </div>
</div>

    </div>
  </div>
</section>

    <section class="section section-relative " id="page-block-ceqi3wwonu8" data-at="section">
   
  <div class="section-holder-border item-block item-absolute" data-at="section-border"></div>
  <div class="section-holder-overlay item-block item-absolute" data-at="section-overlay"></div>
  <div class="section-block">
    <div class="section-inner section-fit section-relative">
        <div class="widget item-absolute hidden-mobile" id="element-343">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute " id="element-321">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute " id="element-330">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute  " id="element-341">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../<?php echo $info->s11_cross_sale_image ?>" data-src="../<?php echo $info->s11_cross_sale_image ?>" data-retina-src="../<?php echo $info->s11_cross_sale_image ?>">
  </div>
</div>

        <div class="widget item-absolute  " id="element-338">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../<?php echo $info->s1_product_image ?>" data-src="../<?php echo $info->s1_product_image ?>" data-retina-src="../<?php echo $info->s1_product_image ?>">
  </div>
</div>

        <div class="widget item-absolute headline  " id="element-328" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_4a9c0ff4 x_1b51740c"><span class="x_0e1fbe45">HURRY! LIMITED OFFER ONLY!</span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute  " id="element-333">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../uploads/promotions/51205648-0-German.png" data-src="../uploads/promotions/51205648-0-German.png" data-retina-src="../uploads/promotions/51205648-0-German.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-332">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../uploads/promotions/51205643-0-CE.png" data-src="../uploads/promotions/51205643-0-CE.png" data-retina-src="../uploads/promotions/51205643-0-CE.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-331">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../uploads/promotions/51205638-0-Money-Back.png" data-src="../uploads/promotions/51205638-0-Money-Back.png" data-retina-src="../uploads/promotions/51205638-0-Money-Back.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-334">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../uploads/promotions/51205633-0-RoHS.png" data-src="../uploads/promotions/51205633-0-RoHS.png" data-retina-src="../uploads/promotions/51205633-0-RoHS.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-336">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../uploads/promotions/51205623-0-FC.png" data-src="../uploads/promotions/51205623-0-FC.png" data-retina-src="../uploads/promotions/51205623-0-FC.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-337">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../uploads/promotions/51205618-0-Warranty.png" data-src="../uploads/promotions/51205618-0-Warranty.png" data-retina-src="../uploads/promotions/51205618-0-Warranty.png">
  </div>
</div>

        <div class="widget item-absolute item-block  " id="element-342">    
    <div class="timer timer-text-bottom item-block" data-date="2020-10-10T00:00:00.181Z" data-timezone="4">
        <div class="timer-labels timer-labels-top hidden-mobile" data-at="timer-top-labels">
            <div class="timer-column timer-label timer-days" data-at="timer-days">
                days
            </div>
            <div class="timer-column timer-label timer-hours" data-at="timer-hours">
                hours
            </div>
            <div class="timer-column timer-label timer-minutes" data-at="timer-minutes">
                minutes
            </div>
            <div class="timer-column timer-label timer-seconds" data-at="timer-seconds">
                seconds
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="timer-date item-block">
            <div class="timer-column timer-box timer-box-days">
                <div class="timer-number js-timer-days" data-at="timer-number-days">00</div>
            </div>
            <div class="timer-column timer-box timer-box-hours">
                <div class="timer-number js-timer-hours" data-at="timer-number-hours">00</div>
            </div>
            <div class="timer-column timer-box timer-box-minutes">
                <div class="timer-number js-timer-minutes" data-at="timer-number-minutes">00</div>
            </div>
            <div class="timer-column timer-box timer-box-seconds">
                <div class="timer-number js-timer-seconds" data-at="timer-number-seconds">00</div>
            </div>
        </div>
        <div class="timer-labels timer-labels-bottom hidden-mobile" data-at="timer-bottom-labels">
            <div class="timer-column timer-label timer-days" data-at="timer-days">
                days
            </div>
            <div class="timer-column timer-label timer-hours" data-at="timer-hours">
                hours
            </div>
            <div class="timer-column timer-label timer-minutes" data-at="timer-minutes">
                minutes
            </div>
            <div class="timer-column timer-label timer-seconds" data-at="timer-seconds">
                seconds
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
        <div class="widget item-absolute hidden-mobile" id="element-319">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute  " id="element-317">
            <h1 class="product-title"><?php echo html_escape($product->title); ?></h1>
            <div class="item-details">
                    <div id="text_product_stock_status" class="right">
                        <?php if (check_product_stock($product)): ?>
                            <span><?php echo trans("status"); ?>: </span> <span class="status-in-stock text-success"><?php echo trans("in_stock") ?></span>
                        <?php else: ?>
                            <span><?php echo trans("status"); ?>: </span> <span class="status-in-stock text-danger"><?php echo trans("out_of_stock") ?></span>
                        <?php endif; ?>
                    </div>
                </div>
  <?php echo form_open(get_product_form_data($product)->add_to_cart_url, ['id' => 'form_add_cart']); ?>
<input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
<div class="row">
    <div class="col-12">
        <div class="row-custom product-variations">
            <div class="row row-product-variation item-variation">
                <?php if (!empty($full_width_product_variations)):
                    foreach ($full_width_product_variations as $variation):
                        $this->load->view('product/details/_product_variations', ['variation' => $variation]);
                    endforeach;
                endif;
                if (!empty($half_width_product_variations)):
                    foreach ($half_width_product_variations as $variation):
                        $this->load->view('product/details/_product_variations', ['variation' => $variation]);
                    endforeach;
                endif; ?>
            </div>
        </div>
    </div>
</div>
<?php // print_r($product); ?> 
<div class="row">
    <div class="col-12"><?php $this->load->view('product/details/_messages'); ?></div>
</div>
<div class="row">
    <div class="col-12 product-add-to-cart-container">
        <?php if ($product->listing_type != 'ordinary_listing' && $product->product_type != 'digital'): ?>
            <div class="number-spinner">
                <div class="input-group">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-spinner-minus" data-dir="dwn">-</button>
                        </span>
                    <input type="text" class="form-control text-center" name="product_quantity" value="1">
                    <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-spinner-plus" data-dir="up">+</button>
                        </span>
                </div>
            </div>
        <?php endif; ?>
        <?php $buttton = get_product_form_data($product)->button;
        if (!empty($buttton)):?>
            <div class="button-container">
                <?php echo $buttton; ?>
            </div>
        <?php endif; ?>
        
    </div>

    <?php if (!empty($product->demo_url)): ?>
        <div class="col-12 product-add-to-cart-container">
            <div class="button-container">
                <a href="<?php echo $product->demo_url; ?>" target="_blank" class="btn btn-md btn-live-preview"><i class="icon-preview"></i><?php echo trans("live_preview") ?></a>
            </div>
        </div>
    <?php endif; ?>

</div>
<?php echo form_close(); ?>

  <div id="form-validation-error-box-element-317" class="item-cover item-absolute form-messagebox" data-at="form-validation-box" style="display:none;">
    <div class="form-messagebox-contents" data-at="form-validation-box-message"></div>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-320" data-at="paragraph">
  <div class="contents">
    <p class="x_0d0d8539 x_b3792fa3"><span class="x_7b2817bf">-CASH ON DELIVERY-</span></p>
  </div>
</div>

        <div class="widget item-absolute  " id="element-329">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../uploads/promotions/51151028-0-COD.png" data-src="../uploads/promotions/51151028-0-COD.png" data-retina-src="../uploads/promotions/51151028-0-COD.png">
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-327" data-at="paragraph">
  <div class="contents">
    <p class="x_bebc2881 x_bbae5241"><span class="x_7b2817bf"><?php echo $info->s11_product_title ?></span></p>
  </div>
</div>

        <div class="widget item-absolute  " id="element-340">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy bg-dark" data-at="image" alt="" src="../<?php echo $info->image_brand ?>" data-src="../<?php echo $info->image_brand ?>" data-retina-src="../<?php echo $info->image_brand ?>">
  </div>
</div>

        <div class="widget item-absolute " id="element-322">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute headline  " id="element-323" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_38bba600 x_413e62cc"><span class="x_0e1fbe45">GET YOUR HANDS</span></p><p class="x_38bba600 x_413e62cc"><span class="x_0e1fbe45">ON THIS&nbsp;</span></p><p class="x_38bba600 x_413e62cc"><span class="x_0e1fbe45">OPPORTUNITY</span></p><p class="x_38bba600 x_413e62cc"><span class="x_0e1fbe45">NOW!</span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-348" data-at="paragraph">
  <div class="contents">
    <p class="x_7575f895 x_3d96d8be"><span class="x_0e1fbe45"><?php echo price_formatted(calculate_product_price($product->price, $product->discount_rate), $product->currency); ?>
</span></p><p class="x_7575f895 x_3d96d8be"><span class="x_0e1fbe45">
</span></p>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-350" data-at="paragraph">
  <div class="contents">
    <p class="x_30e7fb47 x_b43521ac"><span class="x_7b2817bf"><?php echo price_formatted($product->price, $product->currency); ?>&nbsp;</span></p>
  </div>
</div>

        <div class="widget item-absolute " id="element-352">
  <div class="contents shape  line-horizontal line " data-at="shape"></div>
</div>

        <div class="widget item-absolute paragraph  " id="element-354" data-at="paragraph">
  <div class="contents">
    <p class="x_3579aa00"><span class="x_7b2817bf">Final price will include VAT</span></p>
  </div>
</div>

    </div>
  </div>
</section>

    <section class="section section-relative " id="page-block-j8wabyhcyyb" data-at="section">
   
  <div class="section-holder-border item-block item-absolute" data-at="section-border"></div>
  <div class="section-holder-overlay item-block item-absolute" data-at="section-overlay"></div>
  <div class="section-block">
    <div class="section-inner section-fit section-relative">
        <div class="widget item-absolute " id="element-137">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute paragraph  " id="element-138" data-at="paragraph">
  <div class="contents">
    <p class="x_26743634 x_bc7e314d"></p><p class="x_70ee4658 x_dc6c6e10"><span class="x_80c53a0c"><a href="#" data-toggle="modal" data-target="#terms_condition" class="url-link"><?php echo $info->terms_condition_heading ?></a></span></p>
  </div>
</div>

    </div>
  </div>
</section>
<?php } else{ ?>
	
    <section class="section section-relative " id="page-block-iyknujnh3rr" data-at="section">
   
  <div class="section-holder-border item-block item-absolute" data-at="section-border"></div>
  <div class="section-holder-overlay item-block item-absolute" data-at="section-overlay"></div>
  <div class="section-block">
    <div class="section-inner section-fit section-relative">
        <div class="widget item-absolute " id="element-298">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute item-block  " id="element-310">  
        <p class="timer-msg" style="font-size:1.8rem">سينتهي هذا العرض خلال</p>
    <div class="timer timer-text-bottom item-block" data-date="2020-10-12T20:00:00.181Z" data-timezone="4">
        <div class="timer-labels timer-labels-top hidden-mobile" data-at="timer-top-labels">
            <div class="timer-column timer-label timer-days" data-at="timer-days">
                days
            </div>
            <div class="timer-column timer-label timer-hours" data-at="timer-hours">
                hours
            </div>
            <div class="timer-column timer-label timer-minutes" data-at="timer-minutes">
                minutes
            </div>
            <div class="timer-column timer-label timer-seconds" data-at="timer-seconds">
                seconds
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="timer-date item-block">
            <div class="timer-column timer-box timer-box-days">
                <div class="timer-number js-timer-days" data-at="timer-number-days">00</div>
            </div>
            <div class="timer-column timer-box timer-box-hours">
                <div class="timer-number js-timer-hours" data-at="timer-number-hours">00</div>
            </div>
            <div class="timer-column timer-box timer-box-minutes">
                <div class="timer-number js-timer-minutes" data-at="timer-number-minutes">00</div>
            </div>
            <div class="timer-column timer-box timer-box-seconds">
                <div class="timer-number js-timer-seconds" data-at="timer-number-seconds">00</div>
            </div>
        </div>
        <div class="timer-labels timer-labels-bottom hidden-mobile" data-at="timer-bottom-labels">
            <div class="timer-column timer-label timer-days" data-at="timer-days">
                days
            </div>
            <div class="timer-column timer-label timer-hours" data-at="timer-hours">
                hours
            </div>
            <div class="timer-column timer-label timer-minutes" data-at="timer-minutes">
                minutes
            </div>
            <div class="timer-column timer-label timer-seconds" data-at="timer-seconds">
                seconds
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
        <div class="widget item-absolute  " id="element-299">
  <div class="contents cropped item-block" data-at="image-cropp">
  </div>
</div>

        
        <div class="widget item-absolute  " id="element-302">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image " data-at="image" alt="" src="../../uploads/promotions/51205648-0-German.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-303">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image " data-at="image" alt="" src="../../uploads/promotions/51205643-0-CE.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-304">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image " data-at="image" alt="" src="../../uploads/promotions/51205638-0-Money-Back.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-305">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image " data-at="image" alt="" src="../../uploads/promotions/51205633-0-RoHS.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-306">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image " data-at="image" alt="" src="../../uploads/promotions/51205628-0-Shipping.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-307">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image " data-at="image" alt=""  src="../../uploads/promotions/51205623-0-FC.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-308">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image " data-at="image" alt="" src="../../uploads/promotions/51205618-0-Warranty.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-309">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image " data-at="image" alt="" src="../../<?php echo $info->image_brand ?>" srcset="../../<?php echo $info->image_brand ?> 2x">
  </div>
</div>

        <div class="widget item-absolute  " id="element-311">
  <a href="#page-block-mg6u024zjmk" id="link-qn878p40ppi" class="onpage-link btn btn-shadow   item-block" data-at="button" data-link-qn878p40ppi="">
      اطلبوا الجهاز الآن
  </a>
</div>

        <div class="widget item-absolute headline  " id="element-244" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_69f8cf12 x_ddc196a5"><span class="x_df78330b"><?php echo $info->s1_heading_ar ?></span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-245" data-at="paragraph">
  <div class="contents">
    <p class="x_695a2def"><span class="x_df78330b"><?php echo $info->s1_device_name_ar ?></span></p>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-9" data-at="paragraph">
  <div class="contents">
    <p class="x_4269f585 x_46b8788f"><span class="x_7b2817bf"><?php echo price_formatted($product->price, $product->currency); ?></span></p>
  </div>
</div>

        <div class="widget item-absolute " id="element-10">
  <div class="contents shape  line-horizontal line " data-at="shape"></div>
</div>

        <div class="widget item-absolute headline  " id="element-247" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_5205e956 x_2520e6bb"><span class="x_0e1fbe45"><?php echo price_formatted(calculate_product_price($product->price, $product->discount_rate), $product->currency); ?></span></p>
    </h1>
  </div>
</div>

    </div>
  </div>
</section>

    <section class="section section-relative " id="page_block_below_fold" data-at="section">
   
  <div class="section-holder-border item-block item-absolute" data-at="section-border"></div>
  <div class="section-holder-overlay item-block item-absolute" data-at="section-overlay"></div>
  <div class="section-block">
    <div class="section-inner section-fit section-relative">
        <div class="widget item-absolute  " id="element-18">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image " style="min-height: 250px;width: auto;max-width: 100%;" data-at="image" alt="" src="../../<?php echo $info->s2_image ?>">
  </div>
</div>

        <div class="widget item-absolute " id="element-22">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute  " id="element-26">
  <div class="contents item-block">
    <iframe class="item-block video" type="text/html" data-src="<?php echo $info->s3_video_url ?>" allow="autoplay" allowfullscreen="" data-at="video-youtube" frameborder="0" src="<?php echo $info->s3_video_url ?>">
    </iframe>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-28" data-at="paragraph">
  <div class="contents">
    <p class="x_0d4b6e73 x_c6814124"></p><p class="x_207b1059 x_c3570890"><span class="x_f2074b6c"><?php echo $info->s3_sub_text_1_ar ?></span></p>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-29" data-at="paragraph">
  <div class="contents">
    <p class="x_82224667 x_21d8ef23"></p><p class="x_9fc4e10c x_57f24412"><span class="x_80c53a0c"><?php echo $info->s3_sub_number_1 ?></span></p>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-33" data-at="paragraph">
  <div class="contents">
    <p class="x_0d4b6e73 x_c6814124"></p><p class="x_207b1059 x_c3570890"><span class="x_f2074b6c"><?php echo $info->s3_sub_text_2_ar ?></span></p>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-35" data-at="paragraph">
  <div class="contents">
    <p class="x_9fc4e10c x_57f24412"><span class="x_80c53a0c"><?php echo $info->s3_sub_number_2 ?></span></p>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-39" data-at="paragraph">
  <div class="contents">
    <p class="x_0d4b6e73 x_c6814124"></p><p class="x_207b1059 x_c3570890"><span class="x_f2074b6c"><?php echo $info->s3_sub_text_3_ar ?></span></p>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-41" data-at="paragraph">
  <div class="contents">
    <p class="x_82224667 x_21d8ef23"></p><p class="x_9fc4e10c x_57f24412"><span class="x_80c53a0c"><?php echo $info->s3_sub_number_3 ?></span></p>
  </div>
</div>

        <div class="widget item-absolute headline  " id="element-249" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_78f40bb3"><span class="x_7b2817bf"><?php echo $info->s2_heading_ar ?></span></p><p class="x_78f40bb3"><span class="x_0e1fbe45"><br></span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute  " id="element-217">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image" data-at="image" alt="" src="../../<?php echo $info->s3_main_image_1 ?>" data-src="../../<?php echo $info->s3_main_image_1 ?>"  data-retina-src="../../<?php echo $info->s3_main_image_1 ?>">
  </div>
</div>

        <div class="widget item-absolute  " id="element-218">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image" data-at="image" alt="" src="../../<?php echo $info->s3_main_image_2 ?>" data-src="../../<?php echo $info->s3_main_image_2 ?>"  data-retina-src="../../<?php echo $info->s3_main_image_2 ?>">
  </div>
</div>

        <div class="widget item-absolute  " id="element-219">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image" data-at="image" alt="" src="../../<?php echo $info->s3_main_image_3 ?>" data-src="../../<?php echo $info->s3_main_image_3 ?>"  data-retina-src="../../<?php echo $info->s3_main_image_3 ?>">
  </div>
</div>

        <div class="widget item-absolute  " id="element-220">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image" data-at="image" alt="" src="../../<?php echo $info->s3_main_image_4 ?>" data-src="../../<?php echo $info->s3_main_image_4 ?>"  data-retina-src="../../<?php echo $info->s3_main_image_4 ?>">
  </div>
</div>

        <div class="widget item-absolute  " id="element-221">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image" data-at="image" alt="" src="../../<?php echo $info->s3_main_image_5 ?>" data-src="../../<?php echo $info->s3_main_image_5 ?>"  data-retina-src="../../<?php echo $info->s3_main_image_5 ?>">
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-223" data-at="paragraph">
  <div class="contents">
    <p class="x_b00b029a x_7ca85f40"><span class="x_f2074b6c"><?php echo $info->s3_main_text_1_ar ?></span></p><p class="x_b00b029a x_7ca85f40"><span class="x_f2074b6c"><br></span></p>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-224" data-at="paragraph">
  <div class="contents">
    <p class="x_b218f0a4 x_f79d9295"></p><p class="x_b00b029a x_7ca85f40"><span class="x_f2074b6c"><?php echo $info->s3_main_text_2_ar ?></span></p>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-225" data-at="paragraph">
  <div class="contents">
    <p class="x_b218f0a4 x_f79d9295"></p><p class="x_b00b029a x_7ca85f40"><span class="x_f2074b6c"><?php echo $info->s3_main_text_4_ar ?></span></p><p class="x_b00b029a x_7ca85f40"><span class="x_f2074b6c"><br></span></p>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-227" data-at="paragraph">
  <div class="contents">
    <p class="x_b218f0a4 x_f79d9295"></p><p class="x_b00b029a x_7ca85f40"><span class="x_f2074b6c"><?php echo $info->s3_main_text_5_ar ?></span></p>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-251" data-at="paragraph">
  <div class="contents">
    <p class="x_b218f0a4 x_95f1888a"></p><p class="x_b00b029a x_72fe6b53"><span class="x_f2074b6c"><?php echo $info->s3_main_text_3_ar ?></span></p>
  </div>
</div>

        <div class="widget item-absolute " id="element-48">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute  " id="element-46">
  <div class="contents cropped item-block" data-at="image-cropp">
  </div>
</div>
        <div class="widget item-absolute headline  " id="element-167" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_695a2def"><?php echo $info->s4_details_ar ?></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute headline  " id="element-252" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_8670dee8 x_36024141"><span class="x_80c53a0c"><?php echo $info->s4_heading_ar ?></span></p><p class="x_8670dee8 x_36024141"><span class="x_df78330b"><br></span></p>
    </h1>
  </div>
</div>

    </div>
  </div>
</section>

    <section class="section section-relative " id="page_block_footer" data-at="section">
   
  <div class="section-holder-border item-block item-absolute" data-at="section-border"></div>
  <div class="section-holder-overlay item-block item-absolute" data-at="section-overlay"></div>
  <div class="section-block">
    <div class="section-inner section-fit section-relative">
        <div class="widget item-absolute " id="element-93">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute " id="element-98">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute headline hidden-mobile " id="element-151" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_3abf7fa6 x_d0b58f86"><span class="x_f2074b6c">رضا العملاء&nbsp;</span></p><p class="x_3abf7fa6 x_d0b58f86"><span class="x_f2074b6c">.في مقدمة أولويتن</span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute headline  " id="element-153" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_446dab97 x_ce9a991a"><span class="x_80c53a0c">لدينا أكثر من ١٠٠٠٠ زبون سعيد حول العالم يستخدم منتجنا!</span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute hidden-mobile " id="element-173">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../../uploads/promotions/51190728-0-Trophy.png" data-retina-src="../../uploads/promotions/51190728-0-Trophy.png">
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-104" data-at="paragraph">
  <div class="contents">
    <p class="x_e86f1825 x_70ee4658"></p><p class="x_e86f1825 x_70ee4658"></p><p class="x_e86f1825 x_70ee4658"></p><p class="x_e86f1825 x_70ee4658"></p><p class="x_e86f1825 x_70ee4658"><span class="x_199030dd"><?php echo $info->s6_review_comment_2_ar ?></span></p>
  </div>
</div>

        <div class="widget item-absolute headline  " id="element-106" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_9a417bfe x_c2a5648c"></p><p class="x_1952c174 x_9f7a47db"></p><p class="x_1952c174 x_9f7a47db"><span class="x_65831597"><?php echo $info->s6_review_name_2 ?></span></p><p class="x_1952c174 x_9f7a47db"><span class="x_65831597">&nbsp;<?php echo $info->s6_review_location_2 ?></span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute  " id="element-146">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../../uploads/promotions/51163123-0-4star.png" data-src="../../uploads/promotions/51163123-0-4star.png" data-retina-src="../../uploads/promotions/51163123-0-4star.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-175">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../../<?php echo $info->s6_review_image_2 ?>" data-src="../../<?php echo $info->s6_review_image_2 ?>" data-retina-src="../../<?php echo $info->s6_review_image_2 ?>">
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-103" data-at="paragraph">
  <div class="contents">
    <p class="x_7b6e8d41 x_077c8203"></p><p class="x_1a2319a0 x_70ee4658"></p><p class="x_1a2319a0 x_70ee4658 text-right"><span class="x_199030dd"><?php echo $info->s6_review_comment_1_ar ?></span></p><p class="x_1a2319a0 x_70ee4658"></p>
  </div>
</div>

        <div class="widget item-absolute headline  " id="element-107" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_5a0f1527 x_c2a5648c"></p><p class="x_87ee4901 x_9f7a47db"></p><p class="x_87ee4901 x_9f7a47db text-right"><span class="x_65831597"><strong><?php echo $info->s6_review_name_1 ?></strong></span></p><p class="x_87ee4901 x_9f7a47db text-right"><span class="x_65831597">&nbsp;<?php echo $info->s6_review_location_1 ?></span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute  " id="element-147">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../../uploads/promotions/51163118-0-5star.png" data-src="../../uploads/promotions/51163118-0-5star.png" data-retina-src="../../uploads/promotions/51163118-0-5star.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-176">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../../<?php echo $info->s6_review_image_1 ?>" data-src="../../<?php echo $info->s6_review_image_1 ?>" data-retina-src="../../<?php echo $info->s6_review_image_1 ?>">
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-102" data-at="paragraph">
  <div class="contents">
    <p class="x_7b6e8d41 x_077c8203"></p><p class="x_1a2319a0 x_70ee4658"></p><p class="x_1a2319a0 x_70ee4658"></p><p class="x_1a2319a0 x_70ee4658 text-right"><span class="x_199030dd"><?php echo $info->s6_review_comment_3_ar ?>&nbsp;</span></p><p class="x_1a2319a0 x_70ee4658"><span class="x_199030dd"><br></span></p>
  </div>
</div>

        <div class="widget item-absolute headline  " id="element-105" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_9a417bfe x_c2a5648c"></p><p class="x_1952c174 x_9f7a47db"></p><p class="x_1952c174 x_9f7a47db"><span class="x_65831597"><?php echo $info->s6_review_name_3 ?></span></p><p class="x_1952c174 x_9f7a47db"><span class="x_65831597"><?php echo $info->s6_review_location_3 ?></span></p><p class="x_1952c174 x_9f7a47db"><span class="x_65831597"><br></span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute  " id="element-148">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../../uploads/promotions/51163128-0-45star.png" data-src="../../uploads/promotions/51163128-0-45star.png" data-retina-src="../../uploads/promotions/51163128-0-45star.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-177">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../../<?php echo $info->s6_review_image_3 ?>" data-src="../../<?php echo $info->s6_review_image_3 ?>" data-retina-src="../../<?php echo $info->s6_review_image_3 ?>">
  </div>
</div>

        <div class="widget item-absolute headline  " id="element-228" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_3abf7fa6"><span class="x_f2074b6c">الاختيار الأول&nbsp;</span></p><p class="x_3abf7fa6"><span class="x_f2074b6c">.للناس</span></p><p class="x_3abf7fa6"><span class="x_f2074b6c"><br></span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute  " id="element-229">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../../uploads/promotions/51190728-0-Trophy.png" data-src="../../uploads/promotions/51190728-0-Trophy.png" data-retina-src="../../uploads/promotions/51190728-0-Trophy.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-193">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../../<?php echo $info->s5_image ?>" data-src="../../<?php echo $info->s5_image ?>" data-retina-src="../../<?php echo $info->s5_image ?>">
  </div>
</div>

        <div class="widget item-absolute headline  " id="element-263" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_5741eebd x_ef6d09e5"><span class="x_80c53a0c"><?php echo $info->s5_heading_ar ?></span></p>
    </h1>
  </div>
</div>

    </div>
  </div>
</section>

    <section class="section section-relative " id="page-block-9wkstdyrfi5" data-at="section">
   
  <div class="section-holder-border item-block item-absolute" data-at="section-border"></div>
  <div class="section-holder-overlay item-block item-absolute" data-at="section-overlay"></div>
  <div class="section-block">
    <div class="section-inner section-fit section-relative">
        <div class="widget item-absolute " id="element-395">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute  " id="element-394">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../../<?php echo $info->s6_review_image ?>" data-src="../../<?php echo $info->s6_review_image ?>" data-retina-src="../../<?php echo $info->s6_review_image ?>">
  </div>
</div>

        <div class="widget item-absolute  " id="element-396">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../../<?php echo $info->s7_image ?>" data-src="../../<?php echo $info->s7_image ?>" data-retina-src="../../<?php echo $info->s7_image ?>">
  </div>
</div>

        <div class="widget item-absolute " id="element-397">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute headline  " id="element-399" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_8670dee8 x_d7cd368f"><span class="x_7b2817bf"><?php echo $info->s7_heading_ar ?></span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-400" data-at="paragraph">
  <div class="contents">
    <p class="x_effd9815 x_7c7c78aa"><?php echo $info->s7_details_ar ?></p>
  </div>
</div>

        <div class="widget item-absolute  " id="element-401">
  <a href="#page-block-mg6u024zjmk" id="link-1xmfxtdn2kv" class="onpage-link btn btn-shadow   item-block" data-at="button" data-link-1xmfxtdn2kv="">
      اشتريها الآن
  </a>
</div>

    </div>
  </div>
</section>

    <section class="section section-relative " id="page-block-ynbtqvrscze" data-at="section">
   
  <div class="section-holder-border item-block item-absolute" data-at="section-border"></div>
  <div class="section-holder-overlay item-block item-absolute" data-at="section-overlay"></div>
  <div class="section-block">
    <div class="section-inner section-fit section-relative">
        <div class="widget item-absolute " id="element-388">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute " id="element-382">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute  " id="element-381">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../../<?php echo $info->image_brand ?>" data-src="../../<?php echo $info->image_brand ?>" data-retina-src="../../<?php echo $info->image_brand ?>">
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-149" data-at="paragraph">
  <div class="contents">
    <p class="x_207b1059 x_5e8aaa39"><span class="x_f2074b6c"><?php echo $info->s10_description_ar ?></span></p><p class="x_207b1059 x_5e8aaa39"><span class="x_f2074b6c"><br></span></p><p class="x_207b1059 x_5e8aaa39"><span class="x_f2074b6c">&nbsp;<?php echo $info->s10_point_1_ar ?></span></p><p class="x_207b1059 x_5e8aaa39"><span class="x_f2074b6c"><br></span></p><p class="x_207b1059 x_5e8aaa39"><span class="x_f2074b6c">&nbsp;<?php echo $info->s10_point_2_ar ?></span></p><p class="x_207b1059 x_5e8aaa39"><span class="x_f2074b6c"><br></span></p>
  </div>
</div>

        <div class="widget item-absolute headline  " id="element-232" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_8fd3af70 x_71eb4817"><span class="x_f2074b6c">هل أنت غير راضية تماماً؟</span></p><p class="x_8fd3af70 x_71eb4817"><span class="x_f2074b6c">ليس بالمشكلة</span></p><p class="x_8fd3af70 x_71eb4817"><span class="x_f2074b6c"><br></span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute hidden-mobile " id="element-117">
  <div class="contents cropped item-block" data-at="image-cropp">
  </div>
</div>

        <div class="widget item-absolute " id="element-115">
  <div class="contents shape  line-horizontal line " data-at="shape"></div>
</div>

        <div class="widget item-absolute " id="element-113">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute paragraph  " id="element-114" data-at="paragraph">
  <div class="contents">
    <p class="x_8ebbc2ec x_584e132f"><span class="x_f2074b6c">هل ما زلت غير متأكدة إذا كان هذا الجهاز المطور مخصص لك؟</span></p><p class="x_8ebbc2ec x_584e132f"><br></p><p class="x_8ebbc2ec x_584e132f"><span class="x_f2074b6c">إذاً تابعي القراءة.</span></p>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-118" data-at="paragraph">
  <div class="contents">
    <p class="x_3a9656a6 x_6b4d17c3"></p><p class="x_db92dcc1 x_d66531b9"><span class="x_7b2817bf">
    <?php echo $info->s9_description_ar ?></span></p><p class="x_db92dcc1 x_d66531b9"></p><p class="x_db92dcc1 x_d66531b9"><span class="x_e1c17884"><br></span></p>
  </div>
</div>

        <div class="widget item-absolute headline  " id="element-215" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_dcba9f5f x_ef0a430a"><span class="x_f2074b6c">&nbsp;<?php echo $info->s9_heading_ar ?></span></p><p class="x_dcba9f5f x_ef0a430a"><span class="x_f2074b6c"><br></span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute " id="element-364">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute  " id="element-389">
  <a href="#page-block-mg6u024zjmk" id="link-ixm5i3jxu8o" class="onpage-link btn btn-shadow   item-block" data-at="button" data-link-ixm5i3jxu8o="">
      اطلبوا الجهاز الآن
  </a>
</div>

        <div class="widget item-absolute paragraph  " id="element-111" data-at="paragraph">
  <div class="contents">
    <p class="x_effd9815 x_5e8aaa39"><span class="x_7b2817bf"><?php echo $info->s9_details_ar ?> </span></p>
  </div>
</div>

        <div class="widget item-absolute headline  " id="element-267" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_0def92d0 x_14116fc1"><span class="x_7b2817bf"><?php echo $info->s8_heading_ar ?></span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute  " id="element-376">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../../uploads/promotions/51209298-0-Asset-8.png" data-src="../../uploads/promotions/51209298-0-Asset-8.png" data-retina-src="../../uploads/promotions/51209298-0-Asset-8.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-377">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../../uploads/promotions/51209288-0-Asset-10.png" data-src="../../uploads/promotions/51209288-0-Asset-10.png" data-retina-src="../../uploads/promotions/51209288-0-Asset-10.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-378">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../../uploads/promotions/51209283-0-Asset-11.png" data-src="../../uploads/promotions/51209283-0-Asset-11.png" data-retina-src="../../uploads/promotions/51209283-0-Asset-11.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-379">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../../uploads/promotions/51209278-0-Asset-12.png" data-src="../../uploads/promotions/51209278-0-Asset-12.png" data-retina-src="../../uploads/promotions/51209278-0-Asset-12.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-380">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../../uploads/promotions/51209273-0-Asset-13.png" data-src="../../uploads/promotions/51209273-0-Asset-13.png" data-retina-src="../../uploads/promotions/51209273-0-Asset-13.png">
  </div>
</div>

    </div>
  </div>
</section>

    <section class="section section-relative " id="page-block-mg6u024zjmk" data-at="section">
   
  <div class="section-holder-border item-block item-absolute" data-at="section-border"></div>
  <div class="section-holder-overlay item-block item-absolute" data-at="section-overlay"></div>
  <div class="section-block">
    <div class="section-inner section-fit section-relative">
        <div class="widget item-absolute hidden-mobile" id="element-350">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute " id="element-328">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute " id="element-337">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute  " id="element-348">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../../<?php echo $info->s11_cross_sale_image ?>" data-src="../../<?php echo $info->s11_cross_sale_image ?>" data-retina-src="../../<?php echo $info->s11_cross_sale_image ?>">
  </div>
</div>

        <div class="widget item-absolute  " id="element-345">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../../<?php echo $info->s1_product_image ?>" data-src="../../<?php echo $info->s1_product_image ?>" data-retina-src="../../<?php echo $info->s1_product_image ?>">
  </div>
</div>

        <div class="widget item-absolute  " id="element-340">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../../uploads/promotions/51205648-0-German.png" data-src="../../uploads/promotions/51205648-0-German.png" data-retina-src="../../uploads/promotions/51205648-0-German.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-339">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../../uploads/promotions/51205643-0-CE.png" data-src="../../uploads/promotions/51205643-0-CE.png" data-retina-src="../../uploads/promotions/51205643-0-CE.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-338">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../../uploads/promotions/51205638-0-Money-Back.png" data-src="../../uploads/promotions/51205638-0-Money-Back.png" data-retina-src="../../uploads/promotions/51205638-0-Money-Back.png">
  </div>
</div>

        

        <div class="widget item-absolute  " id="element-342">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../../uploads/promotions/51205628-0-Shipping.png" data-src="../../uploads/promotions/51205628-0-Shipping.png" data-retina-src="../../uploads/promotions/51205628-0-Shipping.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-343">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../../uploads/promotions/51205623-0-FC.png" data-src="../../uploads/promotions/51205623-0-FC.png" data-retina-src="../../uploads/promotions/51205623-0-FC.png">
  </div>
</div>

        <div class="widget item-absolute  " id="element-344">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../../uploads/promotions/51205618-0-Warranty.png" data-src="../../uploads/promotions/51205618-0-Warranty.png" data-retina-src="../../uploads/promotions/51205618-0-Warranty.png">
  </div>
</div>

        <div class="widget item-absolute item-block  " id="element-349">    
    <div class="timer timer-text-bottom item-block" data-date="2020-10-10T00:00:00.181Z" data-timezone="4">
        <div class="timer-labels timer-labels-top hidden-mobile" data-at="timer-top-labels">
            <div class="timer-column timer-label timer-days" data-at="timer-days">
                days
            </div>
            <div class="timer-column timer-label timer-hours" data-at="timer-hours">
                hours
            </div>
            <div class="timer-column timer-label timer-minutes" data-at="timer-minutes">
                minutes
            </div>
            <div class="timer-column timer-label timer-seconds" data-at="timer-seconds">
                seconds
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="timer-date item-block">
            <div class="timer-column timer-box timer-box-days">
                <div class="timer-number js-timer-days" data-at="timer-number-days">00</div>
            </div>
            <div class="timer-column timer-box timer-box-hours">
                <div class="timer-number js-timer-hours" data-at="timer-number-hours">00</div>
            </div>
            <div class="timer-column timer-box timer-box-minutes">
                <div class="timer-number js-timer-minutes" data-at="timer-number-minutes">00</div>
            </div>
            <div class="timer-column timer-box timer-box-seconds">
                <div class="timer-number js-timer-seconds" data-at="timer-number-seconds">00</div>
            </div>
        </div>
        <div class="timer-labels timer-labels-bottom hidden-mobile" data-at="timer-bottom-labels">
            <div class="timer-column timer-label timer-days" data-at="timer-days">
                days
            </div>
            <div class="timer-column timer-label timer-hours" data-at="timer-hours">
                hours
            </div>
            <div class="timer-column timer-label timer-minutes" data-at="timer-minutes">
                minutes
            </div>
            <div class="timer-column timer-label timer-seconds" data-at="timer-seconds">
                seconds
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
        <div class="widget item-absolute paragraph  " id="element-275" data-at="paragraph">
  <div class="contents">
    <p class="x_8470ce88 x_edd31370"><span class="x_7b2817bf"><?php echo price_formatted($product->price, $product->currency); ?></span></p>
  </div>
</div>

        <div class="widget item-absolute " id="element-277">
  <div class="contents shape  line-horizontal line " data-at="shape"></div>
</div>

        <div class="widget item-absolute headline  " id="element-279" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_4b9c7db4 x_a7106f7d"><span class="x_0e1fbe45"><?php echo price_formatted(calculate_product_price($product->price, $product->discount_rate), $product->currency); ?></span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-346" data-at="paragraph">
  <div class="contents">
    <p class="x_bb1de03d"><span class="x_7b2817bf">ضريبة القيمة المضافة</span></p>
  </div>
</div>

        <div class="widget item-absolute headline  " id="element-269" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_6f2685b9 x_2a184a51"><span class="x_e1c17884"><?php echo $info->s11_product_title ?></span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute  " id="element-347">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy bg-dark" data-at="image" alt="" src="../../<?php echo $info->image_brand ?>" data-src="../../<?php echo $info->image_brand ?>" data-retina-src="../../<?php echo $info->image_brand ?>">
  </div>
</div>

        <div class="widget item-absolute " id="element-329">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute headline  " id="element-268" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_6f2685b9 x_ebca226a"><span class="x_0e1fbe45">استفيدي من هذه&nbsp;</span></p><p class="x_6f2685b9 x_ebca226a"><span class="x_0e1fbe45">!الفرصة الآن</span></p><p class="x_6f2685b9 x_ebca226a"><span class="x_7b2817bf"><br></span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-282" data-at="paragraph">
  <div class="contents">
    <p class="x_bcbce646"><span class="x_7b2817bf">الدفع نقداً عند التسليم</span></p>
  </div>
</div>

        <div class="widget item-absolute  " id="element-284">
  <div class="contents cropped item-block" data-at="image-cropp">
      <img class="item-content-box item-block image img-lazy" data-at="image" alt="" src="../../uploads/promotions/51151028-0-COD.png" data-src="../../uploads/promotions/51151028-0-COD.png" data-retina-src="../../uploads/promotions/51151028-0-COD.png">
  </div>
</div>

        <div class="widget item-absolute hidden-mobile" id="element-14">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute  " id="element-11">
			<h1 class="product-title text-right"><?php echo html_escape($product->title); ?></h1>
            <div class="item-details text-right">
                    <div id="text_product_stock_status" class="right">
                        <?php if (check_product_stock($product)): ?>
                            <span><?php echo trans("status"); ?>: </span> <span class="status-in-stock text-success"><?php echo trans("in_stock") ?></span>
                        <?php else: ?>
                            <span><?php echo trans("status"); ?>: </span> <span class="status-in-stock text-danger"><?php echo trans("out_of_stock") ?></span>
                        <?php endif; ?>
                    </div>
                </div>
  <?php echo form_open(get_product_form_data($product)->add_to_cart_url, ['id' => 'form_add_cart']); ?>
<input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
<div class="row">
    <div class="col-12">
        <div class="row-custom product-variations">
            <div class="row row-product-variation item-variation">
                <?php if (!empty($full_width_product_variations)):
                    foreach ($full_width_product_variations as $variation):
                        $this->load->view('product/details/_product_variations', ['variation' => $variation]);
                    endforeach;
                endif;
                if (!empty($half_width_product_variations)):
                    foreach ($half_width_product_variations as $variation):
                        $this->load->view('product/details/_product_variations', ['variation' => $variation]);
                    endforeach;
                endif; ?>
            </div>
        </div>
    </div>
</div>
<?php // print_r($product); ?> 
<div class="row">
    <div class="col-12"><?php $this->load->view('product/details/_messages'); ?></div>
</div>
<div class="row">
    <div class="col-12 product-add-to-cart-container">
        <?php if ($product->listing_type != 'ordinary_listing' && $product->product_type != 'digital'): ?>
            <div class="number-spinner">
                <div class="input-group">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-spinner-minus" data-dir="dwn">-</button>
                        </span>
                    <input type="text" class="form-control text-center" name="product_quantity" value="1">
                    <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-spinner-plus" data-dir="up">+</button>
                        </span>
                </div>
            </div>
        <?php endif; ?>
        <?php $buttton = get_product_form_data($product)->button;
        if (!empty($buttton)):?>
            <div class="button-container">
                <?php echo $buttton; ?>
            </div>
        <?php endif; ?>
        
    </div>

    <?php if (!empty($product->demo_url)): ?>
        <div class="col-12 product-add-to-cart-container">
            <div class="button-container">
                <a href="<?php echo $product->demo_url; ?>" target="_blank" class="btn btn-md btn-live-preview"><i class="icon-preview"></i><?php echo trans("live_preview") ?></a>
            </div>
        </div>
    <?php endif; ?>

</div>
<?php echo form_close(); ?>

  <div id="form-validation-error-box-element-11" class="item-cover item-absolute form-messagebox" data-at="form-validation-box" style="display:none;">
    <div class="form-messagebox-contents" data-at="form-validation-box-message"></div>
  </div>
</div>

        <div class="widget item-absolute headline  " id="element-285" data-at="headline">
  <div class="contents">
    <h1>
      <p class="x_28214ad7 x_09500265"><span class="x_0e1fbe45">أسرعوا ! يسري العرض&nbsp;</span></p><p class="x_28214ad7 x_09500265"><span class="x_0e1fbe45">حتى نفاد الكمية</span></p><p class="x_28214ad7 x_09500265"><span class="x_e1c17884"><br></span></p>
    </h1>
  </div>
</div>

        <div class="widget item-absolute paragraph  " id="element-409" data-at="paragraph">
  <div class="contents">
    <p class="x_bb1de03d"><span class="x_7b2817bf">+</span></p>
  </div>
</div>

    </div>
  </div>
</section>

    <section class="section section-relative " id="page-block-j8wabyhcyyb" data-at="section">
   
  <div class="section-holder-border item-block item-absolute" data-at="section-border"></div>
  <div class="section-holder-overlay item-block item-absolute" data-at="section-overlay"></div>
  <div class="section-block">
    <div class="section-inner section-fit section-relative">
        <div class="widget item-absolute " id="element-137">
  <div class="contents shape  box figure " data-at="shape"></div>
</div>

        <div class="widget item-absolute paragraph  " id="element-138" data-at="paragraph">
  <div class="contents">
    <p class="x_077c8203 x_bc7e314d"></p><p class="x_70ee4658 x_dc6c6e10"><span class="x_80c53a0c"><a href="#" data-toggle="modal" data-target="#terms_condition" class="url-link"><?php echo $info->terms_condition_heading_ar ?></a></span></p>
  </div>
</div>

    </div>
  </div>
</section>

<?php }?>
<div class="modal fade" id="terms_condition" tabindex="-1" aria-labelledby="terms_condition" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<?php if($this->selected_lang->id !=2) {
			echo $info->terms_conditions;
		}else{
			echo $info->terms_conditions_ar;
		}?>
      </div>
    </div>
  </div>
</div>
</main>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

<div class="nav-bottom">
            <div class="popup-whatsapp fadeIn">
                <div class="content-whatsapp -top"><button type="button" class="closePopup">
                      <i class="material-icons icon-font-color">close</i>
                    </button>
                    <p>Hi there 👋 <br/>Welcome to Planet Of The Goods.<br/>How can I help you?</p>
                </div>
                <div class="content-whatsapp -bottom">
                  <input class="whats-input" id="whats-in" type="text" Placeholder="Send message..." />
                    <button class="send-msPopup" id="send-btn" type="button">
                        <i class="material-icons icon-font-color--black">send</i>
                    </button>

                </div>
            </div>
            <button type="button" id="whats-openPopup" class="whatsapp-button">
                <img class="icon-whatsapp" src="../assets/img/whatsapp.svg">
            </button>
            <div class="circle-anime"></div>
        </div>
<script>
<?php if( $product->country_id == '165' || $product->country_id == '189' ){
	$ccNumber = '+971505414735';
}else{
	$ccNumber = '+971502189305';
}
?>
$(document).ready(function() {
	$( "#whats-openPopup" ).on( "click", function() {
		$(".popup-whatsapp").toggleClass("is-active-whatsapp-popup");
	});
	$( ".content-whatsapp .closePopup" ).on( "click", function() {
		$(".popup-whatsapp").removeClass("is-active-whatsapp-popup");
	});
	$( ".content-whatsapp #send-btn" ).on( "click", function() {
		let msg = $('#whats-in').val();
		let relmsg = msg.replace(/ /g,"%20");
		window.open('https://api.whatsapp.com/send?phone=<?php echo("$ccNumber");?>&text=<?php echo str_replace("&", "", $product->title); ?> - <?php echo generate_product_url($product); ?>  %0D%0A'+relmsg, '_blank');
	});
	setTimeout(function() {
		$(".popup-whatsapp").addClass("is-active-whatsapp-popup");
		$( "#whats-in" ).focus();
	}, 23000);
});
</script>
</body></html>