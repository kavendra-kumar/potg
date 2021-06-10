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


<!-- include send message modal -->
<?php $this->load->view("partials/_modal_send_message", ["subject" => $product->title]); ?>

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
<style>
body{
	-moz-osx-font-smoothing:grayscale;
	-webkit-font-smoothing:antialiased;
	margin:0;
	width:100%;
	font-family: sans-serif;
	font-weight:400;
	background:url(../<?php echo $info->image_background ?>) repeat-y rgb(36,36,36) 48% 0 / auto;
}
:root {
	--space: 40px;
}

.landing-page-wrapper .container{
	max-width:980px;
}
.top-brand-img{
	max-height: 30px;
	margin: var(--space);
	margin-bottom: 10px;
}
.section-1,.section-5-1,.section-7,.section-11 {
	background-color:rgb(251,176,59);
	position: relative;
}

.add-space-padding,.main-sub-title{
	padding: var(--space);
}
.main-title{
    font-size: 4.9536rem;
    letter-spacing: -5px;
	font-weight: 900;
	line-height: 5rem;
	padding:var(--space);
}
.main-sub-title{
    font-size: 1.2384rem;
	line-height: 1.75rem;
    letter-spacing: 0px;
	padding-top:0px;
}
.main-image{
	<?php if($this->selected_lang->id !=2) { ?>
	background:url(../<?php echo $info->s1_product_image ?>);
	<?php } else{ ?>
	background:url(../../<?php echo $info->s1_product_image; ?>); <?php } ?>
	background-repeat: no-repeat;
    height: 100%;
    background-size: cover;
    background-position: center;
    position: relative;
    top: -60px;
	min-height: 345px;
}
.onpage-link,.btn-product-cart{
	background: linear-gradient(#FF791E,#F65B00 50%);
    color: #FFFFFF;
    font-size: 0.9907rem;
    font-weight: 900;
    line-height: 2.5rem !important;
    max-width: 100% !important;
    border-radius: 14px;
	display: block !important;
	
}
.onpage-link:hover{
	background: #BA3B03;
    color: #FFFFFF;
}
#element-302{
	top: -50px !important;
    left: 0px !important;
    margin: auto;
    position: relative;
}
#element-302 p{
	font-size: 1.5rem;
	margin-bottom: 10px;
}
.certified-img {
    max-width: 90%;
	margin: 10px;
}
.certified-img.small{
    max-height: 35px;
}
.main-last-title{
	line-height: 2.1875rem;
    font-size: 2.4768rem;
    font-weight: 900;
    padding: 60px 0px 0px;	
    text-shadow: 2px 2px 2px #FFFF;
}
.section-2,.section-5,.section-8,.section-10{
	background: rgb(0,0,0);
}
.video {
    width: 100%;
    min-height: 300px;
	margin-bottom: var(--space);
}
.section-2-number{
	color: #fbb03b;
    font-size: 1.6099rem;
    font-weight: 900;
	padding-top: 20px;
}
.section-2-number-text{
	color: #ffffff;
}
.section-2-img{
	width: auto;
	height:50px;
	margin: 10px 0px;
}
.section-2-msg{
	color: #ffffff;
}
.section-3{
	<?php if($this->selected_lang->id !=2) { ?>
	background:url(../<?php echo $info->s4_image ?>);
	<?php } else{ ?>
	background:url(../../<?php echo $info->s4_image; ?>); <?php } ?>
	min-height: 500px;
    background-position: left;
    background-size: cover;
    background-repeat: no-repeat;
    background-color: #f0f3f5;
}
.section-3-title {
    color: #fbb03b;
    line-height: 2.47rem;
    font-size: 2.4768rem;
    font-weight: 900;
    padding-left: 0px;
    padding: var(--space);
}
.section-3 .onpage-link{
	position: relative;
    top: 20px;
}
.section-4{
	background:#FFFFFF;
	text-align: center;
	color: #fbb03b;
}
.section-4 h2{
	line-height: 4rem;
    font-size: 2.4768rem;
    letter-spacing: -2px;
	font-weight: 900;
	padding-top: 20px;
}
.results-img {
    max-width: 100%;
}
.trophy{
	max-height:68px;
}
.section-5 .title{
	color: #FFFFFF;
	line-height: 1.5rem;
    font-size: 1.4861rem;
	font-weight: 900;
}
.section-5 .title-yellow{
	color: #fbb03b;
}
.reviewer {
    max-width: 100%;
    margin-top: var(--space);
    width:100%;
    height:auto;
}
.review-name,.review-city,.review-msg,.section-8{
	color:#FFFFFF;
}
.rating {
    max-height: 25px;
    padding-top: 10px;
}
.review-bottom-msg{
	color: #fbb03b;
	text-align: center;
    line-height: 1.5rem;
    font-size: 1.2384rem;
}
.results-img {
    max-width: 100%;
}
.section-5-1:before {
    content: " ";
    height: 20%;
    background: #000;
    position: absolute;
    width: 100%;
}
.section-6{
	background: rgb(246,225,222);
}
img{
	max-width:100%;
}
.section-6 p {
	line-height: 1.5rem;
    font-size: 1rem;
	font-weight: 600;
}
.section-6 .cross-prod-name{
	line-height: 2.25rem;
    font-size: 2.2291rem;
}
.cross-prod-details{
	margin-top:10px;
}
.section-6-1{
	background: #f0f3f5;
}
.section-6-1 h2{
	line-height: 2.5rem;
    font-size: 2.4768rem;
    letter-spacing: -1px;
    font-weight: 900;
}
.orange-box{
	background: rgb(241,90,36);
	padding: 20px;
	color: #FFFFFF;
	font-weight: bold;
    width: fit-content;
	margin-bottom: 20px;
}
.section-7 h2{
	color: #FFFFFF;
	font-weight:900;
	line-height: 2rem;
    font-size: 1.9814rem;
}
ol, ul{
	padding-left: 1.5rem;
}
.section-8 .certified-img{
	max-width: 100px;
	margin: 10px 0px;
}
.section-8 .certified-img.small{
	max-width: 60px;
}
.section-8 .brand-img{
	max-height: 25px;
}
.section-9{
	background: #FFFFFF;
}
.section-9 .title{
	color: #f15a24;
	line-height: 2.4rem;
    font-size: 2.4768rem;
    letter-spacing: -1px;
	font-weight: 900;
}
.img-wrapper{
	position: relative;
}
.section-9 .product-img {
    max-width: 80%;
	z-index: 2;
    position: relative;
}
.cross-product-img{
	position: absolute;
    max-width: 70%;
    bottom: 30px;
    right: -45px;
    z-index: 1;
}
.cod-img{
	max-width:55px;
}
.section-9 .product-title {
    margin-top: 0;
    margin-bottom: 10px;
    font-size: 24px;
    line-height: 32px;
    font-weight: 600;
}
.product-name{
	line-height: 3.125rem;
    font-size: 3.096rem;
    letter-spacing: -3px;
	font-weight: 900;
}
.product-price{
	line-height: 2.75rem;
    font-size: 1.712rem;
}
.product-final-price{
	color: #f15a24;
	font-weight: 900;
	line-height: 2.1875rem;
    font-size: 2.6rem;
    letter-spacing: -2px;
}
.section-10 p{
	color: #f15a24;
	letter-spacing: -1px;
    line-height: 1.25rem;
    font-size: 1.2384rem;
	font-weight:900;
	margin: 10px 0px;
}
.section-10  #element-302{
	top:0px !important;
}
.section-10 a{
	color: #f15a24;
}
@media only screen and (max-width: 767px){

:root {
	--space: 20px;
}
	.top-brand-img{
		margin: 20px;
	}
	.main-image{
		top:-40px;
		min-height: 345px;
	}
	.main-title{
		font-size: 2rem;
		line-height: 2rem;
		letter-spacing: 0px;
		padding-top: 0px;
	}
	#element-302{
		top:0px !important;
	}
	#element-302 p{
		font-size: 1rem;
	}
	.section-1 #element-302{
		
	}
	.section-2-number{
		font-size: 1rem;
	}
	.section-2-number-text{
		font-size: 0.6rem;
		margin-bottom: 10px;
	}
	.video{
		min-height: 150px;
	}
	.section-3-title{
		font-size: 1.5rem;
		line-height: 1.5rem;
		padding: 0px;
	}
	.section-4 h2{
		font-size: 1.4768rem;
		line-height: 2rem;
		letter-spacing: 0px;
	}
	.trophy{
		padding: 10px 0px;
	}
	.review-name{
		margin-top: 10px;
	}
	.section-6 p{
		padding: 0px 20px;	
	}
	.section-6-1 h2,.section-7 h2,.section-9 .title{
		font-size: 1.5rem;
		line-height: 2rem;
	}
	.cross-product-img{
		    right: -35px;
	}
	.section-9 {
		
	}
	.product-name{
		font-size: 2rem;
		line-height: 2rem;
	}
}
html[lang="ar"] .landing-page-wrapper{
	direction: rtl;
}
html[lang="ar"] .section-3 h2{
	font-weight:900;
}
html[lang="ar"] .rating{
	float: none;
}
html[lang="ar"] .cross-product-img{
	left: -45px;
    right: initial;
}
html[lang="ar"] .main-title{
	letter-spacing:0px;
}
html[lang="ar"] .custom-control-variation .custom-control-label-image .img-variation-option{
	max-width: 100%;
    max-height: 100%;
    transform: none;
}
</style>
<div class="landing-page-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-12">
				<img class="top-brand-img" data-at="image" alt="" src="<?php if($this->selected_lang->id !=2) { echo '../';} else{echo '../../';} echo $info->image_brand ?>">
			</div>
		</div>
		<div class="section-1">
			<div class="row">
				<div class="col-12 col-md-6 order-1 order-md-0">
					<h1 class="main-title"><?php if($this->selected_lang->id !=2) { echo $info->s1_heading; } else{ echo $info->s1_heading_ar; } ?></h1>
					<p class="main-sub-title">
					<?php if($this->selected_lang->id !=2) { ?>
						THE AFFORDABLE<br>
						<?php echo $info->s1_device_name ?><br>
						<strong>JUST GOT MORE AFFORDABLE.</strong>
					<?php } else {
					echo $info->s1_device_name_ar; } ?>
					</p>
  
				</div>
				<div class="col-12 col-md-6 order-0 order-md-1">
					<div class="main-image"></div>
				</div>
				<div class="col-12 col-md-6 order-2">
					<div class="add-space-padding">
						<a href="#add_to_cart" class="onpage-link btn btn-shadow" data-at="button">
							<?php echo trans("get_the_product_now") ?>
						</a>
					</div>
				</div>
				<script>
				$(document).ready( function () {
					$(".onpage-link").click( function () {
						setTimeout(function(){  
							fbq('track', 'ViewContent');
						}, 3000);
					});
				});
				</script>
				<div class="col-12 col-md-6 order-3">
					<div id="element-302">
						<p><?php if($this->selected_lang->id !=2) { echo "This offer will expire in:"; } else { echo "سينتهي هذا العرض خلال";} ?></p>
						<div class="timer timer-text-bottom item-block">
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
				</div>
			</div>	
			<div class="add-space-padding py-md-0">
				<div class="row align-items-center text-center">
					<div class="col-6 col-md-2">
						<img class="certified-img" alt="certified" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../uploads/promotions/51205648-0-German.png">
					</div>
					<div class="col-6 col-md-2">
						<img class="certified-img small" alt="certified" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../uploads/promotions/51205643-0-CE.png">
					</div>
					<div class="col-6 col-md-2">
						<img class="certified-img" alt="certified" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../uploads/promotions/51205638-0-Money-Back.png">
					</div>
					<div class="col-6 col-md-2">
						<img class="certified-img small" alt="certified" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../uploads/promotions/51205633-0-RoHS.png">
					</div>
					<div class="col-6 col-md-2">
						<img class="certified-img small" alt="certified" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../uploads/promotions/51205623-0-FC.png">
					</div>
					<div class="col-6 col-md-2">
						<img class="certified-img" alt="certified" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../uploads/promotions/51205618-0-Warranty.png">
					</div>
				</div>
			</div>
			<div class="add-space-padding" style="background-image:url(<?php if($this->selected_lang->id !=1) { echo "../"; }?>../<?php echo $info->s2_image ?>);background-repeat: no-repeat;background-size: cover;">
				<div class="row">
					<div class="col-12 col-md-6">
						<h2 class="main-last-title"><?php if($this->selected_lang->id !=2){ echo $info->s2_heading; } else {echo $info->s2_heading_ar;} ?></h2>
					</div>
				</div>
			</div>
		</div>
		<div class="section-2 add-space-padding">
			<div class="row">
				<div class="col-12 col-md-8">
					<iframe class="item-block video" type="text/html" data-src="<?php echo $info->s3_video_url ?>" allow="autoplay" allowfullscreen="" frameborder="0" src="<?php echo $info->s3_video_url ?>"></iframe>
				</div>
				<div class="col-12 col-md-4">
					<div class="row">
						<div class="col-4 col-md-6 col-lg-12">
							<p class="section-2-number"><?php echo $info->s3_sub_number_1 ?></p>
							<p class="section-2-number-text"><?php if($this->selected_lang->id !=2){echo $info->s3_sub_text_1;} else{$info->s3_sub_text_1_ar;} ?></p>
						</div>
						<div class="col-4 col-md-6 col-lg-12">
							<p class="section-2-number"><?php echo $info->s3_sub_number_2 ?></p>
							<p class="section-2-number-text"><?php if($this->selected_lang->id !=2){echo $info->s3_sub_text_2;} else{$info->s3_sub_text_2_ar;} ?></p>
						</div>
						<div class="col-4 col-md-12 col-lg-12">
							<p class="section-2-number"><?php echo $info->s3_sub_number_3 ?></p>
							<p class="section-2-number-text"><?php if($this->selected_lang->id !=2){echo $info->s3_sub_text_3;} else{$info->s3_sub_text_3_ar;} ?></p>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6 col-lg text-center text-lg-left">
					<img class="section-2-img" alt="details" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../<?php echo $info->s3_main_image_1 ?>">
					<p class="section-2-msg"><?php if($this->selected_lang->id !=2){echo $info->s3_main_text_1;} else{echo $info->s3_main_text_1_ar;} ?></p>
				</div>
				<div class="col-6 col-lg text-center text-lg-left">
					<img class="section-2-img" alt="details" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../<?php echo $info->s3_main_image_2 ?>">
					<p class="section-2-msg"><?php if($this->selected_lang->id !=2){echo $info->s3_main_text_2;} else{echo $info->s3_main_text_2_ar;} ?></p>
				</div>
				<div class="col-12 col-lg text-center text-lg-left">
					<img class="section-2-img" alt="details" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../<?php echo $info->s3_main_image_3 ?>">
					<p class="section-2-msg"><?php if($this->selected_lang->id !=2){echo $info->s3_main_text_3;} else{echo $info->s3_main_text_3_ar;} ?></p>
				</div>
				<div class="col-6 col-lg text-center text-lg-left">
					<img class="section-2-img" alt="details" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../<?php echo $info->s3_main_image_4 ?>">
					<p class="section-2-msg"><?php if($this->selected_lang->id !=2){echo $info->s3_main_text_4;} else{echo $info->s3_main_text_4_ar;} ?></p>
				</div>
				<div class="col-6 col-lg text-center text-lg-left">
					<img class="section-2-img" alt="details" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../<?php echo $info->s3_main_image_5 ?>">
					<p class="section-2-msg"><?php if($this->selected_lang->id !=2){echo $info->s3_main_text_5;} else{echo $info->s3_main_text_5_ar;} ?></p>
				</div>
			</div>
		</div>
		<div class="section-3">
			<div class="row align-items-center">
				<div class="col-12 col-md-7">
					<div class="add-space-padding">
						<h2 class="section-3-title"><?php if($this->selected_lang->id !=2){echo $info->s4_heading;} else{echo $info->s4_heading_ar;} ?></h2>
					</div>
				</div>
				<div class="col-12 col-md-5">
					<div class="add-space-padding">
						<?php if($this->selected_lang->id !=2){echo $info->s4_details;}else{echo $info->s4_details_ar;} ?>
					</div>
					<div class="add-space-padding py-0">
						<a href="#add_to_cart" class="onpage-link btn btn-shadow" data-at="button">
							<?php echo trans("get_the_product_now") ?>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="section-4 add-space-padding pb-3">
			<h2><?php if($this->selected_lang->id !=2){echo $info->s5_heading;}else{echo $info->s5_heading_ar;} ?></h2>
			<img class="results-img" alt="results" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../<?php echo $info->s5_image ?>" />
		</div>
		<div class="section-5 add-space-padding">
			<div class="row">
				<div class="col-12 col-md-4 order-0 order-md-0">
					<div class="row">
						<div class="col-auto">
							<img class="trophy" alt="trophy" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../uploads/promotions/51190728-0-Trophy.png"/>
						</div>
						<div class="col">
							<?php if($this->selected_lang->id !=2){ ?>
							<p class="title">PEOPLE'S&nbsp;</p>
							<p class="title"><span class="title-yellow">No. 1</span><span > CHOICE.&nbsp;</span></p>
							<?php } else { ?>
							<p class="title">الاختيار الأول &nbsp;</p>
							<p class="title">.للناس&nbsp;</p>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-7 order-0 order-md-0">
					<div class="row">
						<div class="col-auto">
							<img class="trophy" alt="trophy" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../uploads/promotions/51190728-0-Trophy.png"/>
						</div>
						<div class="col">
						<?php if($this->selected_lang->id !=2){ ?>
							<p class="title"><span>CUSTOMER SATISFACTION IS OUR </span><span class="title-yellow">No. 1</span><span> PRIORITY.&nbsp;</span></p>
						<?php } else { ?>
							<p class="title">رضا العملاء &nbsp;</p>
							<p class="title">.في مقدمة أولويتن</p>
						<?php } ?>
						</div>
					</div>
				</div>
				</div>
				<div class="row">
				<div class="col-12 col-md-4 order-0 order-md-0">
					<img class="reviewer" alt="reviewer 1" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../<?php echo $info->s6_review_image_1 ?>"/>
				</div>
				<div class="col-12 col-md-8 align-self-center order-1 order-md-1">
					<p class="review-name"><?php echo $info->s6_review_name_1 ?></p>
					<p class="review-city"><?php echo $info->s6_review_location_1 ?></p>
					<p class="review-msg mt-3"><?php if($this->selected_lang->id !=2){echo $info->s6_review_comment_1;}else{echo $info->s6_review_comment_1_ar;} ?></p>
					<img class="rating" alt="rating" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../uploads/promotions/51163118-0-5star.png"/>
				</div>
				<div class="col-12 col-md-8 align-self-center text-right order-3 order-md-2">
					<p class="review-name"><?php echo $info->s6_review_name_2 ?></p>
					<p class="review-city"><?php echo $info->s6_review_location_2 ?></p>
					<p class="review-msg mt-3"><?php if($this->selected_lang->id !=2){echo $info->s6_review_comment_2;}else{echo $info->s6_review_comment_2_ar;} ?></p>
					<img class="rating float-none" alt="rating" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../uploads/promotions/51163123-0-4star.png"/>
				</div>
				<div class="col-12 col-md-4 order-2 order-md-3">
					<img class="reviewer" alt="reviewer 2" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../<?php echo $info->s6_review_image_2 ?>"/>
				</div>
				<div class="col-12 col-md-4 order-4 order-md-4">
					<img class="reviewer" alt="reviewer 3" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../<?php echo $info->s6_review_image_3 ?>"/>
				</div>
				<div class="col-12 col-md-8 align-self-center order-5 order-md-5">
					<p class="review-name"><?php echo $info->s6_review_name_3 ?></p>
					<p class="review-city"><?php echo $info->s6_review_location_3 ?></p>
					<p class="review-msg mt-3"><?php if($this->selected_lang->id !=2){echo $info->s6_review_comment_3;}else{echo $info->s6_review_comment_3_ar;} ?></p>
					<img class="rating" alt="rating" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../uploads/promotions/51163128-0-45star.png"/>
				</div>
				<div class="col-12 col-md-12 order-6 order-md-6">
					<?php if($this->selected_lang->id !=2){ ?>
					<p class="review-bottom-msg add-space-padding pb-0">WE HAVE <strong>OVER 10,000+ HAPPY CUSTOMERS</strong> AROUND THE WORLD USING OUR PRODUCT!</p>
					<?php } else{ ?>
					<p class="review-bottom-msg add-space-padding pb-0">لدينا أكثر من ١٠٠٠٠ زبون سعيد حول العالم يستخدم منتجنا!</p>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="section-5-1">
			<div class="row justify-content-center">
				<div class="col-12 col-lg-10">
					<img class="results-img" alt="results-img" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../<?php echo $info->s6_review_image ?>"/>
				</div>
			</div>
		</div>
		<div class="section-6">
			<div class="row">
				<div class="col-12 col-md-7">
					<img class="cross-prod-big" alt="cross sale product" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../<?php echo $info->s7_image ?>"/>
				</div>
				<div class="col-12 col-md-5">
					<?php if($this->selected_lang->id !=2) { ?>
					<p class="pt-4"></p>
					<p class="cross-prod-name"><?php echo $info->s7_heading ?></p>
					<?php } else { ?>
					<p class="cross-prod-name"><?php echo $info->s7_heading_ar ?></p>
					<?php } ?>
					<p class="cross-prod-details"><?php if($this->selected_lang->id !=2){echo $info->s7_details;}else{echo $info->s7_details_ar;} ?></p>
					<div class="add-space-padding py-3">
						<a href="#add_to_cart" class="onpage-link btn btn-shadow" data-at="button">
							<?php echo trans("get_the_product_now") ?>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="section-6-1 add-space-padding">
			<h2><?php if($this->selected_lang->id !=2){echo $info->s8_heading;}else{echo $info->s8_heading_ar;} ?></h2>
		</div>
		<div class="section-7">
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="add-space-padding pb-0">
						<p><?php if($this->selected_lang->id !=2){echo $info->s9_details;}else{echo $info->s9_details_ar;} ?></p>
					</div>
				</div>
				<div class="col-12 col-md-7">
					<div class="add-space-padding">
					<?php if($this->selected_lang->id !=2){ ?>
						<div class="orange-box">
							<p>STILL NOT SURE</p>
							<p>IF THIS IS FOR YOU?</p>
							<p class="pt-3">KEEP READING.</p>
						</div>
					<?php }?>
						<h2><?php if($this->selected_lang->id !=2){echo $info->s9_heading;}else{echo $info->s9_heading_ar;} ?></h2>
						<div class="contents">
							<?php if($this->selected_lang->id !=2){echo $info->s9_description;}else{echo $info->s9_description_ar;} ?>
						</div>
						<div class="w-50 mt-2 mx-auto">
							<a href="#add_to_cart" class="onpage-link btn btn-shadow" data-at="button">
								<?php echo trans("get_the_product_now") ?>
							</a>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-5">
					<div class="" style="background:url(<?php if($this->selected_lang->id !=1) { echo "../"; }?>../<?php echo $info->s9_image ?>);height: 100%;background-repeat: no-repeat;background-size: cover;"></div>
				</div>
			</div>
		</div>
		<div class="section-8 add-space-padding">
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="row align-items-center text-center">
						<div class="col-6 col-md col-lg-6">
							<img class="certified-img" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../uploads/promotions/51209298-0-Asset-8.png"/>
						</div>
						<div class="col-6 col-md col-lg-6">
							<img class="certified-img" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../uploads/promotions/51209288-0-Asset-10.png"/>
						</div>
						<div class="col-6 col-md col-lg-4">
							<img class="certified-img small" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../uploads/promotions/51209283-0-Asset-11.png"/>
						</div>
						<div class="col-6 col-md col-lg-4">
							<img class="certified-img small" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../uploads/promotions/51209278-0-Asset-12.png"/>
						</div>
						<div class="col-12 col-md col-lg-4">
							<img class="certified-img small" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../uploads/promotions/51209273-0-Asset-13.png"/>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<img class="brand-img" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../<?php echo $info->image_brand ?>"/>
					<?php if($this->selected_lang->id !=2) { ?>
					<p class="pt-2">NOT COMPLETELY SATISFIED?&nbsp;</p>
					<p>NOT A PROBLEM!</p>
					<?php } else{ ?>
					<p class="pt-2">هل أنت غير راضية تماماً؟&nbsp;</p>
					<p>ليس بالمشكلة</p>
					<?php } ?>
					<p><?php if($this->selected_lang->id !=2){echo $info->s10_description;}else{echo $info->s10_description_ar;} ?></p>
					<ul>
						<li><?php if($this->selected_lang->id !=2){echo $info->s10_point_1;}else{echo $info->s10_point_1_ar;} ?></li>
						<li><?php if($this->selected_lang->id !=2){echo $info->s10_point_2;}else{echo $info->s10_point_2_ar;} ?></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="section-9 add-space-padding">
			<div class="row">
				<div class="col-12 col-md-6">
					<?php if($this->selected_lang->id !=2){ ?>
					<h2 class="title">GET YOUR HANDS<br>ON THIS <br>OPPORTUNITY<br>NOW!</h2>
					<?php } else{ ?>
					<h2 class="title">استفيدي من هذه <br>!الفرصة الآن</h2>
					<?php } ?>
					<div class="img-wrapper">
						<img class="product-img" alt="product image" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../<?php echo $info->s1_product_image ?>"/>
						
						<?php if($info->s11_cross_sale_image){ ?>
						<img class="cross-product-img" alt="Cross product image" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../<?php echo $info->s11_cross_sale_image ?>"/>
						<?php } ?>
					</div>
					<h2 class="product-name"><?php if($this->selected_lang->id !=2){echo $info->s11_product_title;}else{echo $info->s11_product_title_ar;} ?></h2>
					<h2 class="product-price"><strike><?php echo price_formatted($product->price, $product->currency); ?></strike></h2>
					<h2 class="product-final-price"><?php echo price_formatted(calculate_product_price($product->price, $product->discount_rate), $product->currency); ?></h2>
					<?php if($this->selected_lang->id !=2){ ?>
					<p class="my-2">Final price will include VAT</p>
					<?php } else{ ?>
					<p class="my-2">ضريبة القيمة المضافة</p>
					<?php } ?>
				</div>
				<div class="col-12 col-md-6">
					<div class="card card-body h-100" id="add_to_cart" >
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
						
						    <?php
							// $current_country = $this->session->userdata('mds_default_location_id');
							// $product_country = $product->country_id;
							// $number = "+971503053129";
							// $currentURL = current_url();
							// if($current_country != $product_country){
							?>
								<!-- <p class="wrong_location_msg">
									<?php echo trans("this_product_is_not_available_in_your_region") ?>
									<a target="_blank" href="https://wa.me/<?php echo $number; ?>/?text=<?php echo $currentURL; ?>">
										<img src="<?php echo base_url(); ?>assets/img/social-icons/whatsapp.png" alt="WhatsApp" class="img-whatsapp" style="height: 55px; width: 55px; margin-left:-10px;">
									</a>
								</p> -->
							<?php // } ?>


						<?php echo form_close(); ?>
						<div class="row pt-4">
							<div class="col">
								<?php if($this->selected_lang->id !=2){echo "-CASH ON DELIVERY-";}else{echo "الدفع نقداً عند التسليم";} ?>
								<p>
								<?php 
									if ($this->payment_settings->point_checkout_enabled && $this->payment_settings->point_checkout_discount_enabled && empty($cart_has_digital_product)): 
										
										if($this->selected_lang->short_form == 'ar') {
											echo "<h6 class='point_disc'>استعمل بطاقتك الائتمانية وأحصل على ".$this->payment_settings->point_checkout_discount_percentage." ٪؜  خصم.</h6>";
										} else {
											echo "<h6 class='point_disc'>Use your credit card and get ".$this->payment_settings->point_checkout_discount_percentage."% discount.</h6>";
										}
										echo "<br>";
									endif; 
								?>
								</p>
							</div>
							<div class="col">
								<div class="text-right">
									<img class="cod-img" alt="COD" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../uploads/promotions/51151028-0-COD.png">
								</div>
							</div>
						</div>
					</div>
					
  

				</div>
			</div>
		</div>
		<div class="section-10 add-space-padding py-3">
			<div class="row align-items-center text-center">
				<div class="col-12 col-md-6 text-center">
					<p><?php if($this->selected_lang->id !=2){echo "HURRY! LIMITED OFFER ONLY!";}else{echo "أسرعوا ! يسري العرض <br>حتى نفاد الكمية";} ?></p>
				</div>
				<div class="col-12 col-md-6">
				<div id="element-302">
					<div class="timer timer-text-bottom item-block">
							<div class="timer-date item-block">
								<div class="timer-column timer-box timer-box-days">
									<div class="timer-number js-timer-days" data-at="timer-number-days">00</div>
								</div>
								<div class="timer-column timer-box timer-box-hours">
									<div class="timer-number js-timer-hours" data-at="timer-number-hours">00</div>
								</div>
								<div class="timer-column timer-box timer-box-minutes">
									<div class="timer-number js-timer-minutes" data-at="timer-number-minutes">12</div>
								</div>
								<div class="timer-column timer-box timer-box-seconds">
									<div class="timer-number js-timer-seconds" data-at="timer-number-seconds">39</div>
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
				</div>
			</div>
		</div>
		<div class="section-11 add-space-padding">
			<div class="add-space-padding py-0">
				<div class="row align-items-center text-center">
					<div class="col-6 col-md col-lg-2">
						<img class="certified-img" alt="certified" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../uploads/promotions/51205648-0-German.png">
					</div>
					<div class="col-6 col-md col-lg-2">
						<img class="certified-img small" alt="certified" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../uploads/promotions/51205643-0-CE.png">
					</div>
					<div class="col-6 col-md col-lg-2">
						<img class="certified-img" alt="certified" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../uploads/promotions/51205638-0-Money-Back.png">
					</div>
					<div class="col-6 col-md col-lg-2">
						<img class="certified-img small" alt="certified" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../uploads/promotions/51205633-0-RoHS.png">
					</div>
					<div class="col-6 col-md col-lg-2">
						<img class="certified-img small" alt="certified" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../uploads/promotions/51205623-0-FC.png">
					</div>
					<div class="col-6 col-md col-lg-2">
						<img class="certified-img" alt="certified" src="<?php if($this->selected_lang->id !=1) { echo "../"; }?>../uploads/promotions/51205618-0-Warranty.png">
					</div>
				</div>
			</div>
		</div>
		<div class="section-10 add-space-padding text-center py-md-3">
			<a href="#" data-toggle="modal" data-target="#faq_modal" class="url-link"><?php if($this->selected_lang->id !=2){ echo $info->faq_heading; }else{ echo $info->faq_heading_ar; } ?></a>
		</div>
		<div class="section-10 add-space-padding text-center py-md-3">
			<a href="#" data-toggle="modal" data-target="#terms_condition" class="url-link"><?php if($this->selected_lang->id !=2){ echo $info->terms_condition_heading; }else{ echo $info->terms_condition_heading_ar; } ?></a>
		</div>
	</div>
</div>



<html><head>
  <style type="text/css" media="screen">
  .col-product-variation .custom-control-validate-input .error{right: -210px;}
    a{text-decoration:none;color:inherit;cursor:pointer;}a:not(.btn):hover{text-decoration:underline;}input,select,textarea,p,h1,h2,h3,h4,h5,h6{margin:0;font-size:inherit;font-weight:inherit;}main{overflow:hidden;}u > span{text-decoration:inherit;}ol,ul{padding-left:2.5rem;margin:.625rem 0;}p{word-wrap:break-word;}iframe{border:0;}*{box-sizing:border-box;}.item-absolute{position:absolute;}.item-relative{position:relative;}.item-block{display:block;height:100%;width:100%;}.item-cover{z-index:1000001;}.item-breakword{word-wrap:break-word;}.item-content-box{box-sizing:content-box;}.hidden{display:none;}.clearfix{clear:both;}@keyframes slide-down{from{opacity:0;transform:translateY(-50px);}}@keyframes fade-in{from{opacity:0;}}@supports (-webkit-overflow-scrolling:touch){@media (-webkit-min-device-pixel-ratio:2), (min-resolution:192dpi){.image[src$=".svg"]{width:calc(100% + 1px);}}}.headline{font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif;font-weight:700;}.section-fit{max-width:400px;}.section-relative{position:relative;margin:0 auto;}.section-inner{height:100%;}#page-block-l3qivrhmtw{height:175.375rem;max-width:100%;}#page-block-l3qivrhmtw .section-holder-border{border:0;}#page-block-l3qivrhmtw .section-block{background:none;height:175.375rem;}#page-block-l3qivrhmtw .section-holder-overlay{display:none;}#element-290{top:4.125rem;left:0;height:149.3125rem;width:24.9375rem;z-index:3;}.circle{border-radius:50%;}.shape{height:inherit;display:block;}.line-horizontal{height:.625rem;}.line-vertical{height:100%;margin-right:.625rem;}[class*='line-']{box-sizing:content-box;}#element-290 .shape{border:0;background:rgb(251,176,59);}#element-291{top:2.375rem;left:0.125rem;height:21.4669rem;width:24.875rem;z-index:4;}#element-291 .cropped{background:url(../<?php echo $info->s1_product_image ?>) 0 -1.125rem / 25.3125rem 23.875rem;}#element-292{top:33.5625rem;left:2.25rem;height:4.1875rem;width:20.4375rem;z-index:5;color:#37465A;font-size:1.1765rem;line-height:1.425rem;text-align:left;}#element-292 .x_78798708{text-align:left;letter-spacing:0px;line-height:1.4375rem;font-size:1.1765rem;}#element-292 .x_7b2817bf{color:#000000;}#element-292 .contents{color:rgb(55,70,90)!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:400!important;}#element-292 .contents p{letter-spacing:0px!important;}#element-292 strong{font-weight:700;}#element-293{top:24.1875rem;left:2.25rem;height:8.5rem;width:20rem;z-index:6;color:#37465A;font-size:2.8483rem;line-height:2.875rem;text-align:left;font-weight:900;}#element-293 .x_a7dced57{text-align:left;line-height:2.875rem;font-size:2.8483rem;}#element-293 .x_7b2817bf{color:#000000;}#element-293 .contents{color:rgb(55,70,90)!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;}#element-293 .contents p{letter-spacing:-5px!important;}#element-293 strong{font-weight:900;}#element-293.paragraph{font-weight:900;}#element-294{top:69.75rem;left:13.875rem;height:7.7759rem;width:8.25rem;z-index:26;}#element-295{top:90.25rem;left:16.25rem;height:2.5455rem;width:3.5rem;z-index:27;}#element-296{top:79.875rem;left:3.4375rem;height:7.5792rem;width:6.5625rem;z-index:28;}#element-297{top:88.5625rem;left:4.5rem;height:5.8823rem;width:4.4375rem;z-index:29;}#element-299{top:83.625rem;left:16.25rem;height:2.1121rem;width:3.0625rem;z-index:30;}#element-300{top:69.75rem;left:3.4375rem;height:7.5904rem;width:6.5625rem;z-index:31;}#element-301{top:1rem;left:1.8125rem;height:1.875rem;width:5rem;z-index:66;}#element-302{top:59.3125rem;left:2.3125rem;height:3.75rem;width:19.75rem;z-index:67;font-size:3.75rem;}@font-face{font-family:BebasNeue;font-style:normal;font-weight:400;src:url(https:https://v.fastcdn.co/a/font/bebasneue-webfont.eot);src:url(https:https://v.fastcdn.co/a/font/bebasneue-webfont.eot) format("embedded-opentype"),url(https:https://v.fastcdn.co/a/font/bebasneue-webfont.woff2) format("woff2"),url(https:https://v.fastcdn.co/a/font/bebasneue-webfont.woff) format("woff"),url(https:https://v.fastcdn.co/a/font/bebasneue-webfont.ttf) format("truetype");}.timer-column{width:20%;float:left;text-align:center;margin-left:5%;}.timer-column:first-child{width:25%;margin-left:0;}.timer-box{position:relative;font-size:.78em;margin-bottom:.12em;border-radius:5px;font-family:BebasNeue,sans-serif;height:100%;line-height:1.28em;}.timer-box:after,.timer-box:before{content:'';display:block;border-radius:50%;background-color:inherit;position:absolute;left:-.215em;width:.1em;height:.1em;}.timer-box:after{bottom:35%;}.timer-box:before{top:35%;}.timer-box:first-child:before,.timer-box:first-child:after{display:none;}.timer-number-zero{visibility:hidden;}.timer-text-none .timer-box{font-size:.78em;}.timer-text-bottom .timer-labels-top,.timer-text-top .timer-labels-bottom,.timer-text-none .timer-labels{display:none;}.timer-labels{text-transform:uppercase;margin-bottom:.18em;font-size:.13333em;position:relative;}.timer-label{padding-bottom:.1875rem;}#element-302 .timer-box{color:#e55211;background-color:#f9f9f9;}#element-302 .timer-labels{color:#f65b00;}#element-303{top:49.625rem;left:2.0625rem;height:4.25rem;width:20rem;z-index:72;}.btn{cursor:pointer;text-align:center;transition:border .5s;width:100%;border:0;white-space:normal;display:table-cell;vertical-align:middle;padding:0;line-height:120%;}.btn-shadow{box-shadow:0 1px 3px rgba(1,1,1,0.5);}#element-303 .btn.btn-effect3d:active{box-shadow:none;}#element-303 .btn:hover{background:#BA3B03;color:#FFFFFF;}#element-303 .btn{background:linear-gradient(#FF791E,#F65B00 50%);color:#FFFFFF;font-size:0.9907rem;font-family:"objektiv-mk3-1","objektiv-mk3-2",sans-serif;font-weight:900;height:4.25rem;width:20rem;border-radius:14px;}#element-124{top:42.5rem;left:2.625rem;height:4rem;width:13.3125rem;z-index:114;color:#37465A;font-size:2.8605rem;line-height:4.0423rem;text-align:left;font-weight:900;}#element-124 .x_460c3378{text-align:left;letter-spacing:-2px;line-height:4rem;font-size:2.8605rem;}#element-124 .x_0e1fbe45{color:#f15a24;}#element-124 .contents{color:rgb(55,70,90)!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;}#element-124 .contents p{letter-spacing:-2px!important;}#element-124 strong{font-weight:900;}#element-124.paragraph{font-weight:900;}#element-132{top:40.0625rem;left:2.625rem;height:2.8125rem;width:13.3125rem;z-index:115;color:#37465A;font-size:1.8326rem;line-height:2.9596rem;text-align:left;font-weight:400;}#element-132 .x_2d956c7b{text-align:left;line-height:2.875rem;font-size:1.8326rem;}#element-132 .x_7b2817bf{color:#000000;}#element-132 strong{font-weight:700;}#element-132.paragraph{font-weight:400;}#element-134{top:40.875rem;left:2.625rem;height:1.375rem;width:9.875rem;z-index:117;}#element-134 .shape{border-bottom:2px dotted #000000;}#element-284{top:46.5625rem;left:2.25rem;height:1.6875rem;width:17rem;z-index:119;color:#37465A;font-size:1.0681rem;line-height:1.725rem;text-align:left;}#element-284 .x_c9994eb2{text-align:left;line-height:1.6875rem;font-size:1.0681rem;}#element-284 .x_7b2817bf{color:#000000;}#page_block_below_fold{height:227rem;max-width:100%;}#page_block_below_fold .section-holder-border{border:0;}#page_block_below_fold .section-block{background:none;height:227rem;}#page_block_below_fold .section-holder-overlay{display:none;}#element-18{top:-79.125rem;left:0;height:8.3781rem;width:24.875rem;z-index:7;}#element-19{top:-74.125rem;left:1.6875rem;height:8.3125rem;width:20.25rem;z-index:8;color:#37465A;font-size:1.6718rem;line-height:1.6875rem;text-align:left;font-weight:800;}#element-19 .x_415503c6{text-align:left;line-height:1.6875rem;font-size:1.6718rem;}#element-19 .x_7b2817bf{color:#000000;}#element-19 .contents{color:rgb(55,70,90)!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:800!important;}#element-19 strong{font-weight:800;}#element-19.paragraph{font-weight:800;}#element-22{top:-63.875rem;left:0;height:49.875rem;width:24.9375rem;z-index:9;}#element-22 .shape{border:0;background:rgb(0,0,0);}#element-24{top:-65.0625rem;left:1.6875rem;height:2.375rem;width:7.125rem;z-index:10;}#element-24 .shape{border:0.0625rem solid #A3BAC6;background:rgb(240,243,245);}#element-23{top:-64.4375rem;left:2.6875rem;height:1rem;width:5.1875rem;z-index:11;color:#37465A;font-size:0.6451rem;line-height:1.0419rem;text-align:left;font-weight:700;}#element-23 .x_c7d6746d{text-align:left;line-height:1rem;font-size:0.6451rem;}#element-23 .x_7b2817bf{color:#000000;}#element-23 strong{font-weight:700;}#element-23.paragraph{font-weight:700;}#element-26{top:-60.4375rem;left:0.125rem;height:13.25rem;width:24.875rem;z-index:12;}.video-holder{height:100%;overflow:hidden;position:relative;}.video-holder-animoto{background-color:#000;}.video-animoto{position:absolute;top:0;bottom:0;width:100%;height:0;padding-bottom:56.25%;margin:auto;}.video-iframe{position:absolute;}.video-overlay:hover{opacity:1;}.video-holder-helpers{transition:opacity .15s ease-in-out;position:absolute;top:0;left:0;right:0;bottom:0;font-size:14px;text-align:center;display:flex;flex-direction:column;justify-content:center;align-items:center;}.video-overlay{background-color:rgba(31,59,82,0.8);color:#ffffff;opacity:0;z-index:1;}.warning-text{margin-top:10px;font-size:13px;}.warning-img{width:25px;}.fake-video{background:#ffffff;}.fake-play{opacity:.8;}.video-overlay:hover ~ .fake-play{opacity:0;}element-26 iframe{width:398px;height:212px;}#element-28{top:-43rem;left:2.1875rem;height:0.75rem;width:7.1875rem;z-index:13;color:#37465A;font-size:0.55rem;line-height:0.8882rem;text-align:left;}#element-28 .x_c6814124{text-align:left;line-height:0.8125rem;font-size:0.55rem;}#element-28 .x_f2074b6c{color:#ffffff;}#element-29{top:-44.75rem;left:2.1875rem;height:1.6875rem;width:7.1875rem;z-index:14;color:#37465A;font-size:1.0999rem;line-height:1.7764rem;text-align:left;font-weight:900;}#element-29 .x_21d8ef23{text-align:left;line-height:1.6875rem;font-size:1.0999rem;}#element-29 .x_80c53a0c{color:#fbb03b;}#element-29 strong{font-weight:900;}#element-29.paragraph{font-weight:900;}#element-33{top:-43rem;left:16.6875rem;height:0.75rem;width:7.1875rem;z-index:15;color:#37465A;font-size:0.55rem;line-height:0.8882rem;text-align:left;}#element-33 .x_c6814124{text-align:left;line-height:0.8125rem;font-size:0.55rem;}#element-33 .x_f2074b6c{color:#ffffff;}#element-35{top:-44.75rem;left:16.6875rem;height:1.6875rem;width:7.1875rem;z-index:16;color:#37465A;font-size:1.0999rem;line-height:1.7764rem;text-align:left;font-weight:900;}#element-35 .x_21d8ef23{text-align:left;line-height:1.6875rem;font-size:1.0999rem;}#element-35 .x_80c53a0c{color:#fbb03b;}#element-35 strong{font-weight:900;}#element-35.paragraph{font-weight:900;}#element-39{top:-43rem;left:8.9375rem;height:1.5625rem;width:7.1875rem;z-index:17;color:#37465A;font-size:0.55rem;line-height:0.8882rem;text-align:left;}#element-39 .x_c6814124{text-align:left;line-height:0.8125rem;font-size:0.55rem;}#element-39 .x_f2074b6c{color:#ffffff;}#element-41{top:-44.75rem;left:8.9375rem;height:1.6875rem;width:7.1875rem;z-index:18;color:#37465A;font-size:1.0999rem;line-height:1.7764rem;text-align:left;font-weight:900;}#element-41 .x_21d8ef23{text-align:left;line-height:1.6875rem;font-size:1.0999rem;}#element-41 .x_80c53a0c{color:#fbb03b;}#element-41 strong{font-weight:900;}#element-41.paragraph{font-weight:900;}#element-48{top:-16.25rem;left:0;height:41.8125rem;width:25.0625rem;z-index:19;}#element-48 .shape{border:0;background:rgb(240,243,245);}#element-46{top:-16.25rem;left:0;height:16.3558rem;width:25.3125rem;z-index:20;}#element-46 .cropped{background:url(../<?php echo $info->s4_image ?>) -0.8125rem 0 / 26.125rem 16.3125rem;}#element-47{top:-13.6875rem;left:2.0625rem;height:11.6875rem;width:13.25rem;z-index:21;color:#37465A;font-size:1.6718rem;line-height:1.6875rem;text-align:left;font-weight:900;}#element-47 .x_415503c6{text-align:left;line-height:1.6875rem;font-size:1.6718rem;}#element-47 .x_80c53a0c{color:#fbb03b;}#element-47 .contents{color:rgb(55,70,90)!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;}#element-47 strong{font-weight:900;}#element-47.paragraph{font-weight:900;}#element-57{top:4.25rem;left:13.75rem;height:1rem;width:8.5625rem;z-index:37;color:#37465A;font-size:0.6192rem;line-height:1rem;text-align:left;}#element-57 .x_d93e4d4c{text-align:left;line-height:1rem;font-size:0.6192rem;}#element-57 .x_c24cab30{color:#6f6f6f;}#element-59{top:2.5625rem;left:13.75rem;height:1.6875rem;width:7.0625rem;z-index:38;color:#37465A;font-size:1.1106rem;line-height:1.7936rem;text-align:left;font-weight:900;}#element-59 .x_32ef35e0{text-align:left;line-height:1.6875rem;font-size:1.1106rem;}#element-59 .x_7b2817bf{color:#000000;}#element-59 strong{font-weight:900;}#element-59.headline{font-weight:900;}#element-62{top:10.875rem;left:1.8125rem;height:0.8125rem;width:9.25rem;z-index:39;color:#37465A;font-size:0.6192rem;line-height:0.875rem;text-align:left;}#element-62 .x_50e3c4eb{text-align:left;line-height:0.875rem;font-size:0.6192rem;}#element-62 .x_c24cab30{color:#6f6f6f;}#element-64{top:9.0625rem;left:1.8125rem;height:1.75rem;width:8.75rem;z-index:40;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:left;font-weight:900;}#element-64 .x_b6c3675a{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-64 .x_7b2817bf{color:#000000;}#element-64 strong{font-weight:900;}#element-64.headline{font-weight:900;}#element-68{top:7.375rem;left:1.8125rem;height:0.8125rem;width:8.75rem;z-index:41;color:#37465A;font-size:0.6192rem;line-height:0.875rem;text-align:left;}#element-68 .x_50e3c4eb{text-align:left;line-height:0.875rem;font-size:0.6192rem;}#element-68 .x_c24cab30{color:#6f6f6f;}#element-70{top:5.5625rem;left:1.8125rem;height:1.75rem;width:8.75rem;z-index:42;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:left;font-weight:900;}#element-70 .x_b6c3675a{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-70 .x_7b2817bf{color:#000000;}#element-70 strong{font-weight:900;}#element-70.headline{font-weight:900;}#element-74{top:14.25rem;left:1.8125rem;height:1rem;width:11.1875rem;z-index:43;color:#37465A;font-size:0.6192rem;line-height:1rem;text-align:left;}#element-74 .x_d93e4d4c{text-align:left;line-height:1rem;font-size:0.6192rem;}#element-74 .x_c24cab30{color:#6f6f6f;}#element-76{top:12.625rem;left:1.8125rem;height:1.6875rem;width:8.75rem;z-index:44;color:#37465A;font-size:1.1106rem;line-height:1.7936rem;text-align:left;font-weight:900;}#element-76 .x_32ef35e0{text-align:left;line-height:1.6875rem;font-size:1.1106rem;}#element-76 .x_7b2817bf{color:#000000;}#element-76 strong{font-weight:900;}#element-76.headline{font-weight:900;}#element-81{top:12.625rem;left:13.75rem;height:1.6875rem;width:4.25rem;z-index:46;color:#37465A;font-size:1.1106rem;line-height:1.7936rem;text-align:left;font-weight:900;}#element-81 .x_32ef35e0{text-align:left;line-height:1.6875rem;font-size:1.1106rem;}#element-81 .x_7b2817bf{color:#000000;}#element-81 strong{font-weight:900;}#element-81.headline{font-weight:900;}#element-165{top:1.375rem;left:1.8125rem;height:1rem;width:10.1875rem;z-index:53;color:#37465A;font-size:0.6192rem;line-height:1rem;text-align:left;}#element-165 .x_d93e4d4c{text-align:left;line-height:1rem;font-size:0.6192rem;}#element-165 .x_c24cab30{color:#6f6f6f;}#element-167{top:2.5625rem;left:1.8125rem;height:1.75rem;width:5.5rem;z-index:54;color:#37465A;font-size:1.1146rem;line-height:1.8rem;font-weight:900;}#element-167 .x_8ae9aa76{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-167 .x_7b2817bf{color:#000000;}#element-167 strong{font-weight:900;}#element-167.headline{font-weight:900;}#element-170{top:7.375rem;left:13.75rem;height:1rem;width:9.25rem;z-index:55;color:#37465A;font-size:0.6192rem;line-height:1rem;text-align:left;}#element-170 .x_d93e4d4c{text-align:left;line-height:1rem;font-size:0.6192rem;}#element-170 .x_c24cab30{color:#6f6f6f;}#element-172{top:5.5625rem;left:13.75rem;height:1.75rem;width:5.5rem;z-index:56;color:#37465A;font-size:1.1146rem;line-height:1.8rem;font-weight:900;}#element-172 .x_8ae9aa76{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-172 .x_7b2817bf{color:#000000;}#element-172 strong{font-weight:900;}#element-172.headline{font-weight:900;}#element-217{top:-38.375rem;left:18.25rem;height:3.3027rem;width:3.0625rem;z-index:74;}#element-218{top:-38.375rem;left:2.1875rem;height:3.3266rem;width:3.75rem;z-index:75;}#element-219{top:-32.75rem;left:10.1875rem;height:3.375rem;width:4.5625rem;z-index:76;}#element-220{top:-27.4375rem;left:2.1875rem;height:3.4375rem;width:4.1875rem;z-index:77;}#element-221{top:-27.4375rem;left:18rem;height:3.5rem;width:3.5625rem;z-index:78;}#element-223{top:-34.0625rem;left:16.625rem;height:1.4375rem;width:6.3125rem;z-index:79;color:#37465A;font-size:0.6192rem;line-height:0.75rem;text-align:center;}#element-223 .x_7ca85f40{text-align:center;line-height:0.75rem;font-size:0.6192rem;}#element-223 .x_f2074b6c{color:#ffffff;}#element-224{top:-34.0625rem;left:0;height:1.4375rem;width:8.875rem;z-index:80;color:#37465A;font-size:0.6192rem;line-height:0.75rem;text-align:center;}#element-224 .x_7ca85f40{text-align:center;line-height:0.75rem;font-size:0.6192rem;}#element-224 .x_f2074b6c{color:#ffffff;}#element-225{top:-28.625rem;left:8.125rem;height:1.4375rem;width:8.875rem;z-index:81;color:#37465A;font-size:0.6192rem;line-height:0.75rem;text-align:center;}#element-225 .x_7ca85f40{text-align:center;line-height:0.75rem;font-size:0.6192rem;}#element-225 .x_f2074b6c{color:#ffffff;}#element-226{top:-23.125rem;left:0.0625rem;height:1.4375rem;width:8.875rem;z-index:82;color:#37465A;font-size:0.6192rem;line-height:0.75rem;text-align:center;}#element-226 .x_7ca85f40{text-align:center;line-height:0.75rem;font-size:0.6192rem;}#element-226 .x_f2074b6c{color:#ffffff;}#element-227{top:-23.125rem;left:15.3125rem;height:1.4375rem;width:8.875rem;z-index:83;color:#37465A;font-size:0.6192rem;line-height:0.75rem;text-align:center;}#element-227 .x_7ca85f40{text-align:center;line-height:0.75rem;font-size:0.6192rem;}#element-227 .x_f2074b6c{color:#ffffff;}#page_block_footer{height:108.0625rem;max-width:100%;}#page_block_footer .section-holder-border{border:0;}#page_block_footer .section-block{background:none;height:108.0625rem;}#page_block_footer .section-holder-overlay{display:none;}#element-93{top:-201.625rem;left:0;height:24.75rem;width:24.9375rem;z-index:22;}#element-93 .shape{border:0;background:rgb(255,255,255);}#element-95{top:-195.625rem;left:3.625rem;height:4.6875rem;width:17.75rem;z-index:23;color:#37465A;font-size:1.6718rem;line-height:2.3625rem;text-align:left;font-weight:900;}#element-95 .x_178516c5{text-align:left;line-height:2.375rem;font-size:1.6718rem;}#element-95 .x_80c53a0c{color:#fbb03b;}#element-95 .contents{color:rgb(55,70,90)!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;}#element-95 .contents p{letter-spacing:-2px!important;}#element-95 strong{font-weight:900;}#element-95.headline{font-weight:900;}#element-98{top:-176.8125rem;left:0;height:133rem;width:24.9375rem;z-index:25;}#element-98 .shape{border:0;background:rgb(0,0,0);}#element-151{top:81.25rem;left:2.5rem;height:2.4375rem;width:20rem;z-index:34;color:#37465A;font-size:1.2384rem;line-height:1.25rem;text-align:left;font-weight:900;}#element-151 .x_9e69c46b{text-align:left;line-height:1.25rem;font-size:1.2384rem;}#element-151 .x_f2074b6c{color:#ffffff;}#element-151 .x_80c53a0c{color:#fbb03b;}#element-151 strong{font-weight:900;}#element-151.headline{font-weight:900;}#element-153{top:-55.5rem;left:2.5rem;height:3.5rem;width:20rem;z-index:35;color:#37465A;font-size:1.1765rem;line-height:1.1875rem;text-align:center;font-weight:400;}#element-153 .x_ce9a991a{text-align:center;line-height:1.1875rem;font-size:1.1765rem;}#element-153 .x_80c53a0c{color:#fbb03b;}#element-153 strong{font-weight:700;}#element-153.headline{font-weight:400;}#element-79{top:-212.6875rem;left:13.75rem;height:1rem;width:8.4375rem;z-index:45;color:#37465A;font-size:0.6192rem;line-height:1rem;text-align:left;}#element-79 .x_d93e4d4c{text-align:left;line-height:1rem;font-size:0.6192rem;}#element-79 .x_c24cab30{color:#6f6f6f;}#element-84{top:-216.25rem;left:13.75rem;height:1rem;width:11.1875rem;z-index:47;color:#37465A;font-size:0.6192rem;line-height:1rem;text-align:left;}#element-84 .x_d93e4d4c{text-align:left;line-height:1rem;font-size:0.6192rem;}#element-84 .x_c24cab30{color:#6f6f6f;}#element-86{top:-217.9375rem;left:13.75rem;height:1.6875rem;width:8.75rem;z-index:48;color:#37465A;font-size:1.1106rem;line-height:1.7936rem;text-align:left;font-weight:900;}#element-86 .x_32ef35e0{text-align:left;line-height:1.6875rem;font-size:1.1106rem;}#element-86 .x_7b2817bf{color:#000000;}#element-86 strong{font-weight:900;}#element-86.headline{font-weight:900;}#element-89{top:-208.625rem;left:1.8125rem;height:1rem;width:9.5625rem;z-index:49;color:#37465A;font-size:0.6192rem;line-height:1rem;text-align:left;}#element-89 .x_d93e4d4c{text-align:left;line-height:1rem;font-size:0.6192rem;}#element-89 .x_c24cab30{color:#6f6f6f;}#element-91{top:-210.375rem;left:1.8125rem;height:1.6875rem;width:8.75rem;z-index:50;color:#37465A;font-size:1.1106rem;line-height:1.7936rem;text-align:left;font-weight:900;}#element-91 .x_32ef35e0{text-align:left;line-height:1.6875rem;font-size:1.1106rem;}#element-91 .x_7b2817bf{color:#000000;}#element-91 strong{font-weight:900;}#element-91.headline{font-weight:900;}#element-160{top:-208.625rem;left:13.625rem;height:1rem;width:11.4375rem;z-index:51;color:#37465A;font-size:0.6192rem;line-height:1rem;text-align:left;}#element-160 .x_d93e4d4c{text-align:left;line-height:1rem;font-size:0.6192rem;}#element-160 .x_c24cab30{color:#6f6f6f;}#element-162{top:-210.4375rem;left:13.625rem;height:1.75rem;width:8.8125rem;z-index:52;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:left;font-weight:900;}#element-162 .x_b6c3675a{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-162 .x_7b2817bf{color:#000000;}#element-162 strong{font-weight:900;}#element-162.headline{font-weight:900;}#element-173{top:-188.125rem;left:1.3125rem;height:4.25rem;width:3.625rem;z-index:57;}#element-104{top:-107.4375rem;left:4.6875rem;height:8.9375rem;width:15.75rem;z-index:58;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:center;}#element-104 .x_077c8203{text-align:center;line-height:1.3125rem;font-size:0.805rem;}#element-104 .x_70ee4658{text-align:center;line-height:1.3125rem;font-size:0.805rem;}#element-104 .x_199030dd{color:#dddddd;}#element-106{top:-110.4375rem;left:7.75rem;height:1.5625rem;width:9.6875rem;z-index:59;color:#37465A;font-size:0.805rem;line-height:0.8125rem;text-align:center;font-weight:400;}#element-106 .x_c2a5648c{text-align:center;line-height:0.8125rem;font-size:0.805rem;}#element-106 .x_9f7a47db{text-align:center;line-height:0.8125rem;font-size:0.805rem;}#element-106 .x_65831597{color:#fbfbfb;}#element-106 strong{font-weight:700;}#element-106.headline{font-weight:400;}#element-146{top:-97.1875rem;left:9.6875rem;height:1.0511rem;width:5.75rem;z-index:60;}#element-175{top:-130.375rem;left:3.125rem;height:18.75rem;width:18.75rem;z-index:61;}#element-103{top:-147.9375rem;left:4.5rem;height:12.75rem;width:15.9375rem;z-index:62;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:center;}#element-103 .x_077c8203{text-align:center;line-height:1.3125rem;font-size:0.805rem;}#element-103 .x_70ee4658{text-align:center;line-height:1.3125rem;font-size:0.805rem;}#element-103 .x_199030dd{color:#dddddd;}#element-107{top:-150.4375rem;left:7.625rem;height:1.5625rem;width:9.75rem;z-index:63;color:#37465A;font-size:0.805rem;line-height:0.8125rem;text-align:center;font-weight:400;}#element-107 .x_c2a5648c{text-align:center;line-height:0.8125rem;font-size:0.805rem;}#element-107 .x_9f7a47db{text-align:center;line-height:0.8125rem;font-size:0.805rem;}#element-107 .x_65831597{color:#fbfbfb;}#element-107 strong{font-weight:700;}#element-107.headline{font-weight:400;}#element-147{top:-133.6875rem;left:9.625rem;height:1rem;width:5.75rem;z-index:64;}#element-176{top:-169.875rem;left:2.6875rem;height:18.6875rem;width:18.6875rem;z-index:65;}#element-102{top:-71.375rem;left:3.8125rem;height:10.25rem;width:17.375rem;z-index:68;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:center;}#element-102 .x_077c8203{text-align:center;line-height:1.3125rem;font-size:0.805rem;}#element-102 .x_70ee4658{text-align:center;line-height:1.3125rem;font-size:0.805rem;}#element-102 .x_199030dd{color:#dddddd;}#element-105{top:-74.25rem;left:7.625rem;height:1.5625rem;width:9.75rem;z-index:69;color:#37465A;font-size:0.805rem;line-height:0.8125rem;text-align:center;font-weight:400;}#element-105 .x_c2a5648c{text-align:center;line-height:0.8125rem;font-size:0.805rem;}#element-105 .x_9f7a47db{text-align:center;line-height:0.8125rem;font-size:0.805rem;}#element-105 .x_65831597{color:#fbfbfb;}#element-105 strong{font-weight:700;}#element-105.headline{font-weight:400;}#element-148{top:-59.625rem;left:10.0625rem;height:1.0625rem;width:5.8125rem;z-index:70;}#element-177{top:-94rem;left:3.125rem;height:18.6875rem;width:18.6875rem;z-index:71;}#element-193{top:-186.875rem;left:0.0625rem;height:8.2561rem;width:24.9375rem;z-index:73;}#element-228{top:-175.3125rem;left:7.6875rem;height:3rem;width:12.0625rem;z-index:84;color:#37465A;font-size:1.4861rem;line-height:1.5rem;text-align:left;font-weight:900;}#element-228 .x_24e44f2f{text-align:left;line-height:1.5rem;font-size:1.4861rem;}#element-228 .x_f2074b6c{color:#ffffff;}#element-228 .x_80c53a0c{color:#fbb03b;}#element-228 strong{font-weight:900;}#element-228.headline{font-weight:900;}#element-229{top:-175.9375rem;left:1.75rem;height:4.25rem;width:3.625rem;z-index:85;}#element-420{top:-203.625rem;left:3.4375rem;height:3.9375rem;width:17.0625rem;z-index:166;}#element-420 .btn.btn-effect3d:active{box-shadow:none;}#element-420 .btn:hover{background:#BA3B03;color:#FFFFFF;}#element-420 .btn{background:linear-gradient(#FF791E,#F65B00 50%);color:#FFFFFF;font-size:0.9907rem;font-family:"objektiv-mk3-1","objektiv-mk3-2",sans-serif;font-weight:900;height:3.9375rem;width:17.0625rem;border-radius:14px;}#page-block-i82xvkz7ji{height:54.875rem;max-width:100%;}#page-block-i82xvkz7ji .section-holder-border{border:0;}#page-block-i82xvkz7ji .section-block{background:none;height:54.875rem;}#page-block-i82xvkz7ji .section-holder-overlay{display:none;}#element-395{top:-152.25rem;left:0.125rem;height:72.25rem;width:24.9375rem;z-index:150;}#element-395 .shape{border:0;background:rgb(251,176,59);}#element-394{top:-155rem;left:1rem;height:15.243rem;width:22.5rem;z-index:151;}#element-396{top:-138.375rem;left:0.125rem;height:23.718rem;width:24.875rem;z-index:152;}#element-397{top:-114.625rem;left:0;height:36.75rem;width:25.0625rem;z-index:153;}#element-397 .shape{border:0;background:rgb(246,225,222);}#element-398{top:-110.75rem;left:3.8125rem;height:6.6875rem;width:16.6875rem;z-index:154;color:#37465A;font-size:2.2291rem;line-height:2.25rem;text-align:left;font-weight:900;}#element-398 .x_a3e05b5f{text-align:left;line-height:2.25rem;font-size:2.2291rem;}#element-398 .x_7b2817bf{color:#000000;}#element-398 strong{font-weight:900;}#element-398.headline{font-weight:900;}#element-399{top:-112.5625rem;left:3.8125rem;height:1.75rem;width:12.125rem;z-index:155;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:left;font-weight:800;}#element-399 .x_b6c3675a{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-399 .x_7b2817bf{color:#000000;}#element-399 strong{font-weight:800;}#element-399.headline{font-weight:800;}#element-400{top:-100.5rem;left:3.8125rem;height:6.125rem;width:17.5rem;z-index:157;color:#37465A;font-size:0.8669rem;line-height:1.225rem;text-align:left;}#element-400 .x_67538361{text-align:left;line-height:1.25rem;font-size:0.8669rem;}#element-400 .x_7b2817bf{color:#000000;}#element-400 strong{font-weight:700;}#element-401{top:-85.0625rem;left:3.8125rem;height:2.5rem;width:16.75rem;z-index:158;}#element-401 .btn.btn-effect3d:active{box-shadow:none;}#element-401 .btn:hover{background:#BA3B03;color:#FFFFFF;}#element-401 .btn{background:linear-gradient(#FF791E,#F65B00 50%);color:#FFFFFF;font-size:0.9907rem;font-family:"objektiv-mk3-1","objektiv-mk3-2",sans-serif;font-weight:900;height:2.5rem;width:16.75rem;border-radius:14px;}#element-402{top:-92.375rem;left:3.875rem;height:2.4375rem;width:17.5rem;z-index:159;color:#37465A;font-size:0.8669rem;line-height:1.225rem;text-align:left;}#element-402 .x_67538361{text-align:left;line-height:1.25rem;font-size:0.8669rem;}#element-402 .x_7b2817bf{color:#000000;}#page-block-5643epclur5{height:97.625rem;max-width:100%;}#page-block-5643epclur5 .section-holder-border{border:0;}#page-block-5643epclur5 .section-block{background:none;height:97.625rem;}#page-block-5643epclur5 .section-holder-overlay{display:none;}#element-380{top:-127.625rem;left:0.0625rem;height:72.5rem;width:24.9375rem;z-index:86;}#element-380 .shape{border:0;background:rgb(251,176,59);}#element-361{top:-132.8125rem;left:0.0625rem;height:12.9375rem;width:25rem;z-index:87;}#element-361 .shape{border:0;background:rgb(240,243,245);}#element-363{top:-114.8125rem;left:2.75rem;height:10rem;width:19.625rem;z-index:88;color:#37465A;font-size:0.807rem;line-height:1.1404rem;text-align:left;}#element-363 .x_2830259f{text-align:left;line-height:1.125rem;font-size:0.807rem;}#element-363 .x_7b2817bf{color:#000000;}#element-362{top:-129.5625rem;left:2.75rem;height:6.6875rem;width:19.75rem;z-index:89;color:#37465A;font-size:1.676rem;line-height:1.6917rem;text-align:left;font-weight:900;}#element-362 .x_0a56100c{text-align:left;line-height:1.6875rem;font-size:1.676rem;}#element-362 .x_7b2817bf{color:#000000;}#element-362 .contents{color:rgb(55,70,90)!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;}#element-362 .contents p{letter-spacing:-1px!important;}#element-362 strong{font-weight:900;}#element-362.headline{font-weight:900;}#element-367{top:-27.375rem;left:2.5rem;height:31.2575rem;width:22.5rem;z-index:92;}#element-367 .cropped{background:url(../<?php echo $info->s9_image ?>) 0 0 / 25.3125rem 31.25rem;}#element-366{top:-96.8125rem;left:0.1875rem;height:1.3125rem;width:24.75rem;z-index:93;}#element-366 .shape{border-bottom:1px dotted #FBFBFB;}#element-364{top:-99.75rem;left:2.375rem;height:7.25rem;width:12.8125rem;z-index:94;}#element-364 .shape{border:0;background:rgb(241,90,36);}#element-365{top:-98.5rem;left:3.0625rem;height:4.4375rem;width:11.4375rem;z-index:95;color:#37465A;font-size:0.9892rem;line-height:1.1982rem;text-align:left;font-weight:700;}#element-365 .x_8d839f14{text-align:left;line-height:1.125rem;font-size:0.9892rem;}#element-365 .x_f2074b6c{color:#ffffff;}#element-365 strong{font-weight:700;}#element-365.paragraph{font-weight:700;}#element-368{top:-80.5rem;left:0.9375rem;height:17.125rem;width:22.4375rem;z-index:98;color:#37465A;font-size:0.8037rem;line-height:1.1358rem;text-align:left;}#element-368 .x_63f4f890{text-align:left;line-height:1.0625rem;font-size:0.8037rem;}#element-368 li{color:#000001;}#element-368 strong{font-weight:700;}#element-371{top:-89.3125rem;left:2.1875rem;height:6.6875rem;width:20rem;z-index:99;color:#37465A;font-size:1.7311rem;line-height:1.7473rem;text-align:left;font-weight:900;}#element-371 .x_03299323{text-align:left;line-height:1.6875rem;font-size:1.7311rem;}#element-371 .x_f2074b6c{color:#ffffff;}#element-371 strong{font-weight:900;}#element-371.headline{font-weight:900;}#element-381{top:-60.625rem;left:4.4375rem;height:2.5rem;width:16.25rem;z-index:102;}#element-381 .btn.btn-effect3d:active{box-shadow:none;}#element-381 .btn:hover{background:#BA3B03;color:#FFFFFF;}#element-381 .btn{background:linear-gradient(#FF791E,#F65B00 50%);color:#FFFFFF;font-size:0.9907rem;font-family:"objektiv-mk3-1","objektiv-mk3-2",sans-serif;font-weight:900;height:2.5rem;width:16.25rem;border-radius:14px;}#element-370{top:-55.25rem;left:0.0625rem;height:55.75rem;width:25rem;z-index:103;}#element-370 .shape{border:0;background:rgb(0,0,0);}#element-369{top:-41.0625rem;left:3.0625rem;height:11.875rem;width:20.25rem;z-index:104;color:#37465A;font-size:0.8078rem;line-height:1.1415rem;text-align:left;}#element-369 .x_838c6f97{text-align:left;line-height:1.125rem;font-size:0.8078rem;}#element-369 .x_f2074b6c{color:#ffffff;}#element-369 .x_6ab41614{text-align:left;color:rgb(255,255,255);}#element-369 strong{font-weight:700;}#element-373{top:-25.5625rem;left:4.375rem;height:6.5rem;width:5.875rem;z-index:105;}#element-375{top:-10.4375rem;left:9.6875rem;height:6.6875rem;width:5.5625rem;z-index:107;}#element-376{top:-23.625rem;left:16.0625rem;height:2.6875rem;width:3.75rem;z-index:108;}#element-377{top:-17.6875rem;left:4.875rem;height:5.75rem;width:4.25rem;z-index:109;}#element-378{top:-16.125rem;left:16.0625rem;height:2.7331rem;width:3.75rem;z-index:110;}#element-372{top:-46.5625rem;left:3.1875rem;height:3.5rem;width:17.625rem;z-index:111;color:#37465A;font-size:1.1806rem;line-height:1.1916rem;text-align:left;font-weight:900;}#element-372 .x_6c8b1a85{text-align:left;line-height:1.1875rem;font-size:1.1806rem;}#element-372 .x_f2074b6c{color:#ffffff;}#element-372 strong{font-weight:900;}#element-372.headline{font-weight:900;}#element-379{top:-49.75rem;left:3.1875rem;height:1.875rem;width:5rem;z-index:113;}#page-block-ceqi3wwonu8{height:46.375rem;max-width:100%;}#page-block-ceqi3wwonu8 .section-holder-border{border:0;}#page-block-ceqi3wwonu8 .section-block{background:none;height:46.375rem;}#page-block-ceqi3wwonu8 .section-holder-overlay{display:none;}#element-343{top:-430.875rem;left:0.8125rem;height:3.5625rem;width:22.5rem;z-index:24;}#element-343 .shape{border:0;background:rgb(0,0,0);}#element-321{top:-81.1875rem;left:0.0625rem;height:127.0625rem;width:24.9375rem;z-index:36;}#element-321 .shape{border:0;background:rgb(255,255,255);}#element-330{top:19.8125rem;left:0;height:26.5625rem;width:25rem;z-index:120;}#element-330 .shape{border:0;background:rgb(251,176,59);}#element-341{top:-73.6875rem;left:6.625rem;height:5.2987rem;width:12rem;z-index:121;}#element-338{top:-92rem;left:2.6875rem;height:19.5896rem;width:20.6875rem;z-index:122;}#element-328{top:14.6875rem;left:3.5625rem;height:1.125rem;width:18.9375rem;z-index:123;color:#37465A;font-size:1.1735rem;line-height:1.1845rem;text-align:left;font-weight:900;}#element-328 .x_1b51740c{text-align:left;letter-spacing:-1px;line-height:1.125rem;font-size:1.1735rem;}#element-328 .x_0e1fbe45{color:#f15a24;}#element-328 .contents{color:rgb(55,70,90)!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;}#element-328 .contents p{letter-spacing:-1px!important;}#element-328 strong{font-weight:900;}#element-328.headline{font-weight:900;}#element-333{top:28.3125rem;left:15.9375rem;height:5.9375rem;width:6.25rem;z-index:124;}#element-332{top:30.375rem;left:11.25rem;height:1.6579rem;width:2.25rem;z-index:125;}#element-331{top:36.625rem;left:3.25rem;height:5.8676rem;width:5.25rem;z-index:126;}#element-334{top:37.5625rem;left:17.5625rem;height:4.0625rem;width:3rem;z-index:127;}#element-336{top:38.8125rem;left:11.5625rem;height:1.6364rem;width:2.25rem;z-index:129;}#element-337{top:27.8125rem;left:2.625rem;height:6.8645rem;width:5.875rem;z-index:130;}#element-342{top:18.5625rem;left:4.125rem;height:3.25rem;width:16.6875rem;z-index:132;font-size:3.25rem;}#element-342 .timer-box{color:#e55211;background-color:#f9f9f9;}#element-342 .timer-labels{color:#f65b00;}#element-319{top:-73.3125rem;left:1.0625rem;height:40.1875rem;width:23.0625rem;z-index:133;}#element-319 .shape{border:0.0625rem solid #A3BAC6;border-radius:0.5rem 0.5rem 0.5rem 0.5rem;background:rgb(255,255,255);}#element-317 .product-title{margin-top: 0;margin-bottom: 10px;font-size: 24px;line-height: 32px;font-weight: 600;}#element-317{top:-43.9375rem;left:2.0625rem;height:41.375rem;width:20.8125rem;z-index:134;}.lightbox{display:none;position:fixed;width:100%;height:100%;top:0;}.lightbox-dim{background:rgba(0,0,0,0.85);height:100%;animation:fade-in .5s ease-in-out;overflow-x:hidden;display:flex;align-items:center;padding:30px 0;}.lightbox-content{background-color:#fefefe;border-radius:3px;position:relative;margin:auto;animation:slide-down .5s ease-in-out;}.lightbox-opened{display:block;}.lightbox-close{width:25px;right:0;top:-10px;cursor:pointer;}.lightbox-close-icon{fill:#fff;}.notification-text{font-size:1.5rem;color:#fff;text-align:center;width:100%;}.modal-on{overflow:hidden;}.form{font-size:1.25rem;}.form-input{color:transparent;background-color:transparent;border:1px solid transparent;border-radius:3px;font-family:inherit;width:100%;height:3.5rem;margin:0.5rem 0;padding:0.5rem 0.625rem 0.5625rem;}.form-input::placeholder{opacity:1;color:transparent;}.form-textarea{display:inline-block;vertical-align:top;}.form-select{background:url("https://v.fastcdn.co/a/img/builder2/select-arrow-drop-down.png") no-repeat right;-webkit-appearance:none;-moz-appearance:none;color:transparent;}.form-label{display:inline-block;color:transparent;}.form-label-title{display:block;line-height:1.1;width:100%;padding:0.75rem 0 0.5625rem;margin:0.5rem 0 0.125rem;}.form-multiple-label:empty{display:block;height:0.8rem;margin-top:.375rem;}.form-label-outside{margin:0.3125rem 0 0;}.form-multiple-input{position:absolute;opacity:0;}.form-multiple-label{position:relative;padding-top:0.75rem;line-height:1.05;margin-left:1.5625rem;}.form-multiple-label:before{content:"";display:inline-block;box-sizing:inherit;width:1rem;height:1rem;background-color:#fff;border-radius:0.25rem;border:1px solid #8195a8;margin-right:0.5rem;vertical-align:-2px;position:absolute;left:-1.5625rem;}.form-checkbox-label:after{content:"";width:0.25rem;height:0.5rem;position:absolute;top:0.8rem;left:-1.25rem;transform:rotate(45deg);border-right:0.1875rem solid;border-bottom:0.1875rem solid;color:#fff;}.form-radio-label:before{border-radius:50%;}.form-multiple-input:focus + .form-multiple-label:before{border:2px solid #308dfc;}.form-multiple-input:checked + .form-radio-label:before{border:0.3125rem solid #308dfc;}.form-multiple-input:checked + .form-checkbox-label:before{background-color:#308dfc;border:0;}.form-btn{-webkit-appearance:none;-moz-appearance:none;background-color:transparent;border:0;cursor:pointer;min-height:100%;}.form-input-inner-shadow{box-shadow:inset 0 1px 3px rgba(0,0,0,0.28);}body#landing-page .user-invalid-label{color:#e85f54;}body#landing-page .user-invalid{border-color:#e85f54;}.form-messagebox{transform:translate(0.4375rem,-0.4375rem);}.form-messagebox:before{content:"";position:absolute;display:block;width:0.375rem;height:0.375rem;transform:rotate(45deg);background-color:#e85f54;top:-0.1875rem;left:25%;}.form-messagebox-contents{font-size:0.875rem;font-weight:500;color:#fff;background-color:#e85f54;padding:0.4375rem 0.9375rem;max-width:250px;word-wrap:break-word;margin:auto;}.form-messagebox-top{transform:translate(0,-1rem);}.form-messagebox-top:before{bottom:-0.1875rem;top:auto;}#element-317 .btn.btn-effect3d:active{box-shadow:none;}#element-317 .btn:hover{background:#C34B21;color:#FFFFFF;}#element-317 .btn-product-cart{background:linear-gradient(#FF7842,#F15A24 50%);color:#FFFFFF;font-size:1.1146rem;font-family:"objektiv-mk3-1","objektiv-mk3-2",sans-serif;font-weight:900;height:3.25rem;width:21.0625rem;border-radius:15px;}#element-317 .form-label{color:#B4B4B4;}#element-317 ::placeholder{color:#B4B4B4;}#element-317 .form-input{color:#000000;background-color:#FFFFFF;border-color:#FBB03B;}#element-317 .user-invalid{border-color:#E12627;}#element-317 input::placeholder,#element-317 .form-label-inside{color:#B4B4B4;}#element-317 select.valid{color:#000000;}#element-317 .form-btn-geometry{top:42.9375rem;left:-0.1875rem;height:3.25rem;width:21.0625rem;z-index:134;}#element-320{top:6.5rem;left:1.8125rem;height:1.0625rem;width:13.5625rem;z-index:135;color:#37465A;font-size:0.8895rem;line-height:1.0774rem;text-align:center;font-weight:800;}#element-320 .x_b3792fa3{text-align:center;line-height:1.0625rem;font-size:0.8895rem;}#element-320 .x_7b2817bf{color:#000000;}#element-320 strong{font-weight:800;}#element-320.paragraph{font-weight:800;}#element-329{top:5.4375rem;left:18.3125rem;height:3.2818rem;width:4.75rem;z-index:136;}#element-327{top:-62.3125rem;left:2.6875rem;height:4.5625rem;width:19.75rem;z-index:145;color:#37465A;font-size:2.303rem;line-height:2.3245rem;text-align:left;font-weight:900;}#element-327 .x_bbae5241{text-align:left;letter-spacing:-3px;line-height:2.3125rem;font-size:2.303rem;}#element-327 .x_7b2817bf{color:#000000;}#element-327 .contents{color:rgb(55,70,90)!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;}#element-327 .contents p{letter-spacing:-3px!important;}#element-327 strong{font-weight:900;}#element-327.paragraph{font-weight:900;}#element-340{top:-65.125rem;left:2.75rem;height:2.1455rem;width:5.75rem;z-index:146;}#element-322{top:-99.5rem;left:2.0625rem;height:7.9375rem;width:21.375rem;z-index:148;}#element-322 .shape{border:0;background:rgb(255,255,255);}#element-323{top:-98.875rem;left:2.6875rem;height:6.4375rem;width:19.6875rem;z-index:149;color:#37465A;font-size:1.6677rem;line-height:1.6833rem;text-align:left;font-weight:900;}#element-323 .x_413e62cc{text-align:left;letter-spacing:-3px;line-height:1.625rem;font-size:1.6677rem;}#element-323 .x_0e1fbe45{color:#f15a24;}#element-323 .contents{color:rgb(55,70,90)!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;}#element-323 .contents p{letter-spacing:-1px!important;}#element-323 strong{font-weight:900;}#element-323.headline{font-weight:900;}#element-348{top:-53.625rem;left:2.375rem;height:5.3125rem;width:15.3125rem;z-index:160;color:#37465A;font-size:3.3563rem;line-height:5.4204rem;font-weight:900;}#element-348 .x_3d96d8be{text-align:left;line-height:5.375rem;font-size:3.3563rem;letter-spacing:-2px;}#element-348 .x_0e1fbe45{color:#f15a24;}#element-348 .contents{color:rgb(55,70,90)!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;}#element-348 .contents p{letter-spacing:-2px!important;}#element-348 strong{font-weight:900;}#element-348.paragraph{font-weight:900;}#element-350{top:-55.1875rem;left:2.375rem;height:3rem;width:10.75rem;z-index:161;color:#37465A;font-size:1.8795rem;line-height:3.0354rem;font-weight:400;}#element-350 .x_b43521ac{text-align:left;line-height:3rem;font-size:1.8795rem;}#element-350 .x_7b2817bf{color:#000000;}#element-350 strong{font-weight:700;}#element-350.paragraph{font-weight:400;}#element-352{top:-54.25rem;left:2.6875rem;height:1.3125rem;width:8.6875rem;z-index:163;}#element-352 .shape{border-bottom:1px dotted #000000;}#element-354{top:-49.125rem;left:2.5625rem;height:1.625rem;width:14.3125rem;z-index:165;color:#37465A;font-size:0.9907rem;line-height:1.6rem;}#element-354 .x_3579aa00{text-align:left;line-height:1.625rem;font-size:0.9907rem;}#element-354 .x_7b2817bf{color:#000000;}#page-block-j8wabyhcyyb{height:6rem;max-width:100%;}#page-block-j8wabyhcyyb .section-holder-border{border:0;}#page-block-j8wabyhcyyb .section-block{background:none;height:6rem;}#page-block-j8wabyhcyyb .section-holder-overlay{display:none;}#element-137{top:0;left:0;height:6rem;width:24.9375rem;z-index:32;}#element-137 .shape{border:0;background:rgb(0,0,0);}#element-138{top:1.3125rem;left:2.4375rem;height:3.3125rem;width:20rem;z-index:33;color:#37465A;font-size:0.805rem;line-height:1.1375rem;text-align:center;}#element-138 .x_bc7e314d{text-align:center;line-height:1.125rem;font-size:0.805rem;}#element-138 .x_dc6c6e10{text-align:center;line-height:1.125rem;font-size:0.805rem;}#element-138 .x_80c53a0c{color:#fbb03b;}@media screen and (max-width:400px){:root{font-size:4vw;}}@media screen and (min-width:401px) and (max-width:767px){:root{font-size:16px;}}@media screen and (min-width:768px) and (max-width:1200px){:root{font-size:1.33vw;}}@media screen and (max-width:767px){.hidden-mobile{display:none;}}@media screen and (min-width:768px){.section-fit{max-width:60rem;}#page-block-l3qivrhmtw{height:50.5625rem;max-width:100%;}#page-block-l3qivrhmtw .section-holder-border{border:0;}#page-block-l3qivrhmtw .section-block{background:none;height:50.5625rem;}#page-block-l3qivrhmtw .section-holder-overlay{display:none;}#element-290{top:3.25rem;left:0;height:64.75rem;width:59.9375rem;z-index:3;}#element-290 .shape{border:0;background:rgb(251,176,59);}#element-291{top:0.5625rem;left:27.5625rem;height:30.3125rem;width:35.25rem;z-index:4;}#element-291 .cropped{background:url(../<?php echo $info->s1_product_image ?>) 0 -1.625rem / 35.875rem 33.75rem;}#element-292{top:20.1875rem;left:3rem;height:5.1875rem;width:23.125rem;z-index:5;color:#37465A;font-size:1.2384rem;line-height:1.75rem;text-align:left;}#element-292 .x_ee409d31{text-align:left;letter-spacing:0px;line-height:1.75rem;font-size:1.2384rem;}#element-292 .x_7b2817bf{color:#000000;}#element-292 .contents{font-size:1.2384rem!important;line-height:1.75rem!important;color:rgb(55,70,90)!important;width:23.125rem!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:400!important;height:auto;}#element-292 .contents p{line-height:1.75rem!important;font-size:1.2384rem!important;letter-spacing:0px!important;}#element-292 strong{font-weight:700;}#element-293{top:6.25rem;left:3rem;height:13rem;width:31.4375rem;z-index:6;color:#37465A;font-size:4.9536rem;line-height:5rem;text-align:left;font-weight:900;}#element-293 .x_d4149e5e{text-align:left;line-height:5rem;font-size:4.9536rem;}#element-293 .x_7b2817bf{color:#000000;}#element-293 .contents{font-size:4.9536rem!important;line-height:5rem!important;color:rgb(55,70,90)!important;width:31.4375rem!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;height:auto;}#element-293 .contents p{line-height:4.375rem!important;font-size:4.9536rem!important;letter-spacing:-5px!important;}#element-293 strong{font-weight:900;}#element-293.paragraph{font-weight:900;}#element-294{top:42.9375rem;left:4.0625rem;height:5.125rem;width:5.4375rem;z-index:26;}#element-295{top:44.625rem;left:14rem;height:1.5rem;width:2.0625rem;z-index:27;}#element-296{top:42.9375rem;left:21.5625rem;height:5.125rem;width:4.4375rem;z-index:28;}#element-297{top:43.5625rem;left:32.25rem;height:3.5625rem;width:2.6875rem;z-index:29;}#element-299{top:44.75rem;left:41.9375rem;height:1.25rem;width:1.8125rem;z-index:30;}#element-300{top:42.4375rem;left:48.625rem;height:6rem;width:5.25rem;z-index:31;}#element-301{top:0.9375rem;left:3rem;height:1.875rem;width:5rem;z-index:66;}#element-302{top:35.1875rem;left:37.1875rem;height:4.25rem;width:16.625rem;z-index:67;font-size:4.25rem;}.timer-box{font-size:.6em;}.timer-date{height:auto;}#element-302 .timer-box{color:#e55211;background-color:#f9f9f9;}#element-302 .timer-labels{color:#f65b00;}#element-303{top:36.3125rem;left:3rem;height:2.5rem;width:23rem;z-index:72;}#element-303 .btn.btn-effect3d:active{box-shadow:none;}#element-303 .btn:hover{background:#BA3B03;color:#FFFFFF;}#element-303 .btn{background:linear-gradient(#FF791E,#F65B00 50%);color:#FFFFFF;font-size:0.9907rem;font-family:"objektiv-mk3-1","objektiv-mk3-2",sans-serif;font-weight:900;height:2.5rem;width:23rem;border-radius:14px;}#element-124{top:29.5625rem;left:3rem;height:2.25rem;width:14.125rem;z-index:114;color:#37465A;font-size:3.096rem;line-height:5rem;text-align:left;font-weight:900;}#element-124 .x_68437d79{text-align:left;letter-spacing:-2px;line-height:2.1875rem;font-size:3.096rem;}#element-124 .x_0e1fbe45{color:#f15a24;}#element-124 .contents{font-size:4.9536rem!important;line-height:8rem!important;color:rgb(55,70,90)!important;width:14.125rem!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;height:2.1875rem!important;}#element-124 .contents p{line-height:2.1875rem!important;font-size:2.5rem!important;letter-spacing:-2px!important;}#element-124 strong{font-weight:900;}#element-124.paragraph{font-weight:900;}#element-132{top:26.5625rem;left:3rem;height:2.75rem;width:8.75rem;z-index:115;color:#37465A;font-size:1.7337rem;line-height:2.8rem;text-align:left;font-weight:400;}#element-132 .x_30e7fb47{text-align:left;line-height:2.75rem;font-size:1.712rem;}#element-132 .x_7b2817bf{color:#000000;}#element-132 strong{font-weight:700;}#element-132.paragraph{font-weight:400;}#element-134{top:27.3125rem;left:3.125rem;height:1.25rem;width:8.25rem;z-index:117;}#element-134 .shape{border-bottom:1px dotted #000000;}#element-284{top:32.5rem;left:3.1875rem;height:1.625rem;width:14.25rem;z-index:119;color:#37465A;font-size:0.9907rem;line-height:1.6rem;text-align:left;}#element-284 .x_3579aa00{text-align:left;line-height:1.625rem;font-size:0.9907rem;}#element-284 .x_7b2817bf{color:#000000;}#page_block_below_fold{height:81.25rem;max-width:100%;}#page_block_below_fold .section-holder-border{border:0;}#page_block_below_fold .section-block{background:none;height:81.25rem;}#page_block_below_fold .section-holder-overlay{display:none;}#element-18{top:-1.625rem;left:0;height:20.1875rem;width:59.9375rem;z-index:7;}#element-19{top:4.625rem;left:4.0625rem;height:10.8125rem;width:26.75rem;z-index:8;color:#37465A;font-size:2.4768rem;line-height:2.5rem;text-align:left;font-weight:800;}#element-19 .x_e985c108{text-align:left;line-height:2.5rem;font-size:2.4768rem;}#element-19 .x_7b2817bf{color:#000000;}#element-19 .contents{font-size:2.4768rem!important;line-height:2.5rem!important;color:rgb(55,70,90)!important;width:26.6875rem!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:800!important;height:auto;}#element-19 .contents p{line-height:2.1875rem!important;font-size:2.4768rem!important;}#element-19 strong{font-weight:800;}#element-19.paragraph{font-weight:800;}#element-22{top:18.4375rem;left:-0.0625rem;height:38.9375rem;width:60rem;z-index:9;}#element-22 .shape{border:0;background:rgb(0,0,0);}#element-24{top:17.25rem;left:4.0625rem;height:2.25rem;width:9.5rem;z-index:10;}#element-24 .shape{border:0.0625rem solid #A3BAC6;background:rgb(240,243,245);}#element-23{top:17.75rem;left:5rem;height:1.625rem;width:8rem;z-index:11;color:#37465A;font-size:0.9907rem;line-height:1.6rem;text-align:left;font-weight:700;}#element-23 .x_3579aa00{text-align:left;line-height:1.625rem;font-size:0.9907rem;}#element-23 .x_7b2817bf{color:#000000;}#element-23 strong{font-weight:700;}#element-23.paragraph{font-weight:700;}#element-26{top:23.0625rem;left:4.0625rem;height:19.5rem;width:32.875rem;z-index:12;}element-26 iframe{width:526px;height:312px;}#element-28{top:27.4375rem;left:42.375rem;height:1.25rem;width:10.5rem;z-index:13;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-28 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-28 .x_f2074b6c{color:#ffffff;}#element-29{top:25.4375rem;left:42.375rem;height:2.625rem;width:10.5rem;z-index:14;color:#37465A;font-size:1.6099rem;line-height:2.6rem;text-align:left;font-weight:900;}#element-29 .x_f4b5a1e3{text-align:left;line-height:2.625rem;font-size:1.6099rem;}#element-29 .x_80c53a0c{color:#fbb03b;}#element-29 strong{font-weight:900;}#element-29.paragraph{font-weight:900;}#element-33{top:32.4375rem;left:42.375rem;height:1.25rem;width:10.5rem;z-index:15;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-33 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-33 .x_f2074b6c{color:#ffffff;}#element-35{top:30.4375rem;left:42.375rem;height:2.625rem;width:10.5rem;z-index:16;color:#37465A;font-size:1.6099rem;line-height:2.6rem;text-align:left;font-weight:900;}#element-35 .x_f4b5a1e3{text-align:left;line-height:2.625rem;font-size:1.6099rem;}#element-35 .x_80c53a0c{color:#fbb03b;}#element-35 strong{font-weight:900;}#element-35.paragraph{font-weight:900;}#element-39{top:37.5rem;left:42.375rem;height:2.5625rem;width:10.5rem;z-index:17;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-39 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-39 .x_f2074b6c{color:#ffffff;}#element-41{top:35.5rem;left:42.375rem;height:2.625rem;width:10.5rem;z-index:18;color:#37465A;font-size:1.6099rem;line-height:2.6rem;text-align:left;font-weight:900;}#element-41 .x_f4b5a1e3{text-align:left;line-height:2.625rem;font-size:1.6099rem;}#element-41 .x_80c53a0c{color:#fbb03b;}#element-41 strong{font-weight:900;}#element-41.paragraph{font-weight:900;}#element-48{top:57.375rem;left:24.0625rem;height:39.375rem;width:35.9375rem;z-index:19;}#element-48 .shape{border:0;background:rgb(240,243,245);}#element-46{top:57.375rem;left:0;height:39.375rem;width:60.9375rem;z-index:20;}#element-46 .cropped{background:url(../<?php echo $info->s4_image ?>) -1.9375rem 0 / 62.875rem 39.375rem;}#element-47{top:68.125rem;left:5.3125rem;height:13rem;width:23.125rem;z-index:21;color:#37465A;font-size:2.4768rem;line-height:2.5rem;text-align:left;font-weight:900;}#element-47 .x_a33937de{text-align:left;line-height:2.1875rem;font-size:2.4768rem;}#element-47 .x_80c53a0c{color:#fbb03b;}#element-47 .contents{font-size:2.4768rem!important;line-height:2.5rem!important;color:rgb(55,70,90)!important;width:23.125rem!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;height:auto;}#element-47 .contents p{line-height:2.1875rem!important;font-size:2.4768rem!important;}#element-47 strong{font-weight:900;}#element-47.paragraph{font-weight:900;}#element-57{top:68.125rem;left:40.125rem;height:1.25rem;width:17.75rem;z-index:37;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-57 .x_2c6a6bea{text-align:left;line-height:1.3125rem;font-size:0.8064rem;}#element-57 .x_c24cab30{color:#6f6f6f;}#element-59{top:66.3125rem;left:40.125rem;height:1.75rem;width:7.4375rem;z-index:38;color:#37465A;font-size:1.1165rem;line-height:1.8032rem;text-align:left;font-weight:900;}#element-59 .x_60c047dd{text-align:left;line-height:1.8125rem;font-size:1.1165rem;}#element-59 .x_7b2817bf{color:#000000;}#element-59 strong{font-weight:900;}#element-59.headline{font-weight:900;}#element-62{top:71.25rem;left:40.125rem;height:1.25rem;width:17.75rem;z-index:39;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-62 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-62 .x_c24cab30{color:#6f6f6f;}#element-64{top:69.4375rem;left:40.125rem;height:1.75rem;width:8.8125rem;z-index:40;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:left;font-weight:900;}#element-64 .x_8ae9aa76{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-64 .x_7b2817bf{color:#000000;}#element-64 strong{font-weight:900;}#element-64.headline{font-weight:900;}#element-68{top:74.375rem;left:40.125rem;height:1.25rem;width:17.75rem;z-index:41;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-68 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-68 .x_c24cab30{color:#6f6f6f;}#element-70{top:72.5625rem;left:40.125rem;height:1.75rem;width:8.8125rem;z-index:42;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:left;font-weight:900;}#element-70 .x_8ae9aa76{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-70 .x_7b2817bf{color:#000000;}#element-70 strong{font-weight:900;}#element-70.headline{font-weight:900;}#element-74{top:77.8125rem;left:40.125rem;height:1.25rem;width:17.75rem;z-index:43;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-74 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-74 .x_c24cab30{color:#6f6f6f;}#element-76{top:75.6875rem;left:40.125rem;height:1.75rem;width:8.8125rem;z-index:44;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:left;font-weight:900;}#element-76 .x_8ae9aa76{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-76 .x_7b2817bf{color:#000000;}#element-76 strong{font-weight:900;}#element-76.headline{font-weight:900;}#element-81{top:79.5625rem;left:40.125rem;height:1.75rem;width:8.8125rem;z-index:46;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:left;font-weight:900;}#element-81 .x_8ae9aa76{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-81 .x_7b2817bf{color:#000000;}#element-81 strong{font-weight:900;}#element-81.headline{font-weight:900;}#element-165{top:61.875rem;left:40.125rem;height:1.25rem;width:17.75rem;z-index:53;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-165 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-165 .x_c24cab30{color:#6f6f6f;}#element-167{top:60.0625rem;left:40.125rem;height:1.75rem;width:5.5rem;z-index:54;color:#37465A;font-size:1.1146rem;line-height:1.8rem;font-weight:900;}#element-167 .x_8ae9aa76{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-167 .x_7b2817bf{color:#000000;}#element-167 strong{font-weight:900;}#element-167.headline{font-weight:900;}#element-170{top:65rem;left:40.125rem;height:1.25rem;width:17.75rem;z-index:55;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-170 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-170 .x_c24cab30{color:#6f6f6f;}#element-172{top:63.1875rem;left:40.125rem;height:1.75rem;width:5.5rem;z-index:56;color:#37465A;font-size:1.1146rem;line-height:1.8rem;font-weight:900;}#element-172 .x_8ae9aa76{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-172 .x_7b2817bf{color:#000000;}#element-172 strong{font-weight:900;}#element-172.headline{font-weight:900;}#element-217{top:45.6875rem;left:4.0625rem;height:3.4375rem;width:3.25rem;z-index:74;}#element-218{top:45.6875rem;left:14.625rem;height:3.4375rem;width:3.875rem;z-index:75;}#element-219{top:45.75rem;left:26.3125rem;height:3.25rem;width:4.5625rem;z-index:76;}#element-220{top:45.75rem;left:38.6875rem;height:3.25rem;width:4.1875rem;z-index:77;}#element-221{top:45.75rem;left:51.125rem;height:3.5rem;width:3.75rem;z-index:78;}#element-223{top:50.75rem;left:4.0625rem;height:2rem;width:6.3125rem;z-index:79;color:#37465A;font-size:0.805rem;line-height:0.975rem;text-align:left;}#element-223 .x_70b443d1{text-align:left;line-height:1rem;font-size:0.805rem;}#element-223 .x_f2074b6c{color:#ffffff;}#element-224{top:50.75rem;left:15.1875rem;height:3rem;width:8.75rem;z-index:80;color:#37465A;font-size:0.805rem;line-height:0.975rem;text-align:left;}#element-224 .x_70b443d1{text-align:left;line-height:1rem;font-size:0.805rem;}#element-224 .x_f2074b6c{color:#ffffff;}#element-225{top:50.75rem;left:26.3125rem;height:2rem;width:8.875rem;z-index:81;color:#37465A;font-size:0.805rem;line-height:0.975rem;text-align:left;}#element-225 .x_70b443d1{text-align:left;line-height:1rem;font-size:0.805rem;}#element-225 .x_f2074b6c{color:#ffffff;}#element-226{top:50.75rem;left:38.75rem;height:2rem;width:8.75rem;z-index:82;color:#37465A;font-size:0.805rem;line-height:0.975rem;text-align:left;}#element-226 .x_70b443d1{text-align:left;line-height:1rem;font-size:0.805rem;}#element-226 .x_f2074b6c{color:#ffffff;}#element-227{top:50.75rem;left:51.125rem;height:2rem;width:8.875rem;z-index:83;color:#37465A;font-size:0.805rem;line-height:0.975rem;text-align:left;}#element-227 .x_70b443d1{text-align:left;line-height:1rem;font-size:0.805rem;}#element-227 .x_f2074b6c{color:#ffffff;}#page_block_footer{height:128.4375rem;max-width:100%;}#page_block_footer .section-holder-border{border:0;}#page_block_footer .section-block{background:none;height:128.4375rem;}#page_block_footer .section-holder-overlay{display:none;}#element-93{top:15.4375rem;left:0;height:29.125rem;width:59.9375rem;z-index:22;}#element-93 .shape{border:0;background:rgb(255,255,255);}#element-95{top:21rem;left:5.4375rem;height:4rem;width:55.375rem;z-index:23;color:#37465A;font-size:2.4768rem;line-height:4rem;text-align:left;font-weight:900;}#element-95 .x_49caa87c{text-align:left;line-height:4rem;font-size:2.4768rem;}#element-95 .x_80c53a0c{color:#fbb03b;}#element-95 .contents{font-size:2.4768rem!important;line-height:4rem!important;color:rgb(55,70,90)!important;width:55.375rem!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;height:auto;}#element-95 .contents p{line-height:4rem!important;font-size:2.4768rem!important;letter-spacing:-2px!important;}#element-95 strong{font-weight:900;}#element-95.headline{font-weight:900;}#element-98{top:44.375rem;left:0;height:86.25rem;width:59.9375rem;z-index:25;}#element-98 .shape{border:0;background:rgb(0,0,0);}#element-151{top:49.75rem;left:32.125rem;height:3rem;width:23.25rem;z-index:34;color:#37465A;font-size:1.4861rem;line-height:1.5rem;text-align:left;font-weight:900;}#element-151 .x_275d245b{text-align:left;line-height:1.5rem;font-size:1.4861rem;}#element-151 .x_f2074b6c{color:#ffffff;}#element-151 .x_80c53a0c{color:#fbb03b;}#element-151 strong{font-weight:900;}#element-151.headline{font-weight:900;}#element-153{top:119.25rem;left:7.1875rem;height:3rem;width:45.5625rem;z-index:35;color:#37465A;font-size:1.2384rem;line-height:1.5rem;text-align:center;font-weight:400;}#element-153 .x_bdb4a4e4{text-align:center;line-height:1.5rem;font-size:1.2384rem;}#element-153 .x_80c53a0c{color:#fbb03b;}#element-153 strong{font-weight:700;}#element-153.headline{font-weight:400;}#element-79{top:0.125rem;left:40.125rem;height:1.25rem;width:17.75rem;z-index:45;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-79 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-79 .x_c24cab30{color:#6f6f6f;}#element-84{top:3.75rem;left:40.125rem;height:1.25rem;width:17.75rem;z-index:47;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-84 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-84 .x_c24cab30{color:#6f6f6f;}#element-86{top:1.9375rem;left:40.125rem;height:1.75rem;width:8.8125rem;z-index:48;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:left;font-weight:900;}#element-86 .x_8ae9aa76{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-86 .x_7b2817bf{color:#000000;}#element-86 strong{font-weight:900;}#element-86.headline{font-weight:900;}#element-89{top:6.875rem;left:40.125rem;height:1.25rem;width:17.75rem;z-index:49;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-89 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-89 .x_c24cab30{color:#6f6f6f;}#element-91{top:5.0625rem;left:40.125rem;height:1.75rem;width:8.8125rem;z-index:50;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:left;font-weight:900;}#element-91 .x_8ae9aa76{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-91 .x_7b2817bf{color:#000000;}#element-91 strong{font-weight:900;}#element-91.headline{font-weight:900;}#element-160{top:10.375rem;left:40.125rem;height:1.25rem;width:17.75rem;z-index:51;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-160 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-160 .x_c24cab30{color:#6f6f6f;}#element-162{top:8.5625rem;left:40.125rem;height:1.75rem;width:8.8125rem;z-index:52;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:left;font-weight:900;}#element-162 .x_8ae9aa76{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-162 .x_7b2817bf{color:#000000;}#element-162 strong{font-weight:900;}#element-162.headline{font-weight:900;}#element-173{top:49.125rem;left:6.6875rem;height:4.25rem;width:3.625rem;z-index:57;}#element-104{top:84.8125rem;left:5.75rem;height:3.5rem;width:31.4375rem;z-index:58;color:#37465A;font-size:0.743rem;line-height:1.2rem;text-align:left;}#element-104 .x_4cb1d84e{text-align:left;line-height:1.1875rem;font-size:0.743rem;}#element-104 .x_1a2319a0{text-align:justify;line-height:1.1875rem;font-size:0.743rem;}#element-104 .x_199030dd{color:#dddddd;}#element-106{top:82.625rem;left:27.5rem;height:1.5625rem;width:9.75rem;z-index:59;color:#37465A;font-size:0.805rem;line-height:0.8125rem;text-align:left;font-weight:400;}#element-106 .x_c9387aab{text-align:left;line-height:0.8125rem;font-size:0.805rem;}#element-106 .x_1952c174{text-align:right;line-height:0.8125rem;font-size:0.805rem;}#element-106 .x_65831597{color:#fbfbfb;}#element-106 strong{font-weight:700;}#element-106.headline{font-weight:400;}#element-146{top:89.0625rem;left:31.1875rem;height:1.0625rem;width:5.75rem;z-index:60;}#element-175{top:77.25rem;left:38.0625rem;height:18.6875rem;width:18.75rem;z-index:61;}#element-103{top:64.125rem;left:27.1875rem;height:7rem;width:26.25rem;z-index:62;color:#37465A;font-size:0.743rem;line-height:1.2rem;text-align:left;}#element-103 .x_4cb1d84e{text-align:left;line-height:1.1875rem;font-size:0.743rem;}#element-103 .x_1a2319a0{text-align:justify;line-height:1.1875rem;font-size:0.743rem;}#element-103 .x_199030dd{color:#dddddd;}#element-107{top:61.75rem;left:27.375rem;height:1.5625rem;width:9.6875rem;z-index:63;color:#37465A;font-size:0.805rem;line-height:0.8125rem;text-align:left;font-weight:400;}#element-107 .x_c9387aab{text-align:left;line-height:0.8125rem;font-size:0.805rem;}#element-107 .x_87ee4901{text-align:left;line-height:0.8125rem;font-size:0.805rem;}#element-107 .x_65831597{color:#fbfbfb;}#element-107 strong{font-weight:700;}#element-107.headline{font-weight:400;}#element-147{top:71.75rem;left:27.1875rem;height:1rem;width:5.75rem;z-index:64;}#element-176{top:58.125rem;left:6.6875rem;height:18.75rem;width:18.6875rem;z-index:65;}#element-102{top:104.875rem;left:26.625rem;height:5.8125rem;width:29.8125rem;z-index:68;color:#37465A;font-size:0.743rem;line-height:1.2rem;text-align:left;}#element-102 .x_4cb1d84e{text-align:left;line-height:1.1875rem;font-size:0.743rem;}#element-102 .x_1a2319a0{text-align:justify;line-height:1.1875rem;font-size:0.743rem;}#element-102 .x_199030dd{color:#dddddd;}#element-105{top:102.375rem;left:26.4375rem;height:1.5625rem;width:9.6875rem;z-index:69;color:#37465A;font-size:0.805rem;line-height:0.8125rem;text-align:left;font-weight:400;}#element-105 .x_c9387aab{text-align:left;line-height:0.8125rem;font-size:0.805rem;}#element-105 .x_87ee4901{text-align:left;line-height:0.8125rem;font-size:0.805rem;}#element-105 .x_65831597{color:#fbfbfb;}#element-105 strong{font-weight:700;}#element-105.headline{font-weight:400;}#element-148{top:112.25rem;left:26.625rem;height:1.0625rem;width:5.8125rem;z-index:70;}#element-177{top:95.9375rem;left:5.4375rem;height:18.6875rem;width:18.6875rem;z-index:71;}#element-193{top:26.0625rem;left:3.3125rem;height:18.3125rem;width:55.25rem;z-index:73;}#element-228{top:49.75rem;left:11.9375rem;height:3rem;width:12.0625rem;z-index:84;color:#37465A;font-size:1.4861rem;line-height:1.5rem;text-align:left;font-weight:900;}#element-228 .x_275d245b{text-align:left;line-height:1.5rem;font-size:1.4861rem;}#element-228 .x_f2074b6c{color:#ffffff;}#element-228 .x_80c53a0c{color:#fbb03b;}#element-228 strong{font-weight:900;}#element-228.headline{font-weight:900;}#element-229{top:49.125rem;left:27.3125rem;height:4.25rem;width:3.625rem;z-index:85;}#element-420{top:14.1875rem;left:39.75rem;height:2.5rem;width:14.5rem;z-index:166;}#element-420 .btn.btn-effect3d:active{box-shadow:none;}#element-420 .btn:hover{background:#BA3B03;color:#FFFFFF;}#element-420 .btn{background:linear-gradient(#FF791E,#F65B00 50%);color:#FFFFFF;font-size:0.9907rem;font-family:"objektiv-mk3-1","objektiv-mk3-2",sans-serif;font-weight:900;height:2.5rem;width:14.5rem;border-radius:14px;}#page-block-i82xvkz7ji{height:50.75rem;max-width:100%;}#page-block-i82xvkz7ji .section-holder-border{border:0;}#page-block-i82xvkz7ji .section-block{background:none;height:50.75rem;}#page-block-i82xvkz7ji .section-holder-overlay{display:none;}#element-395{top:2.25rem;left:0;height:48.625rem;width:59.9375rem;z-index:150;}#element-395 .shape{border:0;background:rgb(251,176,59);}#element-394{top:-3.75rem;left:9rem;height:30.0625rem;width:44.375rem;z-index:151;}#element-396{top:25.25rem;left:0;height:25.625rem;width:26.875rem;z-index:152;}#element-397{top:25.25rem;left:26.875rem;height:25.625rem;width:33.0625rem;z-index:153;}#element-397 .shape{border:0;background:rgb(246,225,222);}#element-398{top:28.5rem;left:30.75rem;height:6.6875rem;width:16.6875rem;z-index:154;color:#37465A;font-size:2.2291rem;line-height:2.25rem;text-align:left;font-weight:900;}#element-398 .x_9b7a1e0d{text-align:left;line-height:2.25rem;font-size:2.2291rem;}#element-398 .x_7b2817bf{color:#000000;}#element-398 strong{font-weight:900;}#element-398.headline{font-weight:900;}#element-399{top:26.6875rem;left:31.0625rem;height:1.75rem;width:12.25rem;z-index:155;color:#37465A;font-size:1.1146rem;line-height:1.8rem;text-align:left;font-weight:800;}#element-399 .x_8ae9aa76{text-align:left;line-height:1.8125rem;font-size:1.1146rem;}#element-399 .x_7b2817bf{color:#000000;}#element-399 strong{font-weight:800;}#element-399.headline{font-weight:800;}#element-400{top:36.5rem;left:30.6875rem;height:5.3125rem;width:25.25rem;z-index:157;color:#37465A;font-size:0.8669rem;line-height:1.4rem;text-align:left;}#element-400 .x_48aa50a2{text-align:left;line-height:1.375rem;font-size:0.8669rem;}#element-400 .x_7b2817bf{color:#000000;}#element-400 strong{font-weight:700;}#element-401{top:46.8125rem;left:30.6875rem;height:2.5rem;width:12.1875rem;z-index:158;}#element-401 .btn.btn-effect3d:active{box-shadow:none;}#element-401 .btn:hover{background:#BA3B03;color:#FFFFFF;}#element-401 .btn{background:linear-gradient(#FF791E,#F65B00 50%);color:#FFFFFF;font-size:0.9907rem;font-family:"objektiv-mk3-1","objektiv-mk3-2",sans-serif;font-weight:900;height:2.5rem;width:12.1875rem;border-radius:14px;}#element-402{top:43.9375rem;left:30.75rem;height:1.3125rem;width:25.25rem;z-index:159;color:#37465A;font-size:0.8669rem;line-height:1.4rem;text-align:left;}#element-402 .x_48aa50a2{text-align:left;line-height:1.375rem;font-size:0.8669rem;}#element-402 .x_7b2817bf{color:#000000;}#page-block-5643epclur5{height:97.25rem;max-width:100%;}#page-block-5643epclur5 .section-holder-border{border:0;}#page-block-5643epclur5 .section-block{background:none;height:97.25rem;}#page-block-5643epclur5 .section-holder-overlay{display:none;}#element-380{top:12.625rem;left:0;height:61.375rem;width:59.9375rem;z-index:86;}#element-380 .shape{border:0;background:rgb(251,176,59);}#element-361{top:0;left:0;height:12.625rem;width:59.9375rem;z-index:87;}#element-361 .shape{border:0;background:rgb(240,243,245);}#element-363{top:15.0625rem;left:5.3125rem;height:5.3125rem;width:48.25rem;z-index:88;color:#37465A;font-size:0.8669rem;line-height:1.4rem;text-align:left;}#element-363 .x_48aa50a2{text-align:left;line-height:1.375rem;font-size:0.8669rem;}#element-363 .x_7b2817bf{color:#000000;}#element-362{top:2.5625rem;left:5.0625rem;height:7.5rem;width:52.75rem;z-index:89;color:#37465A;font-size:2.4768rem;line-height:2.5rem;text-align:left;font-weight:900;}#element-362 .x_e985c108{text-align:left;line-height:2.5rem;font-size:2.4768rem;}#element-362 .x_7b2817bf{color:#000000;}#element-362 .contents{font-size:2.4768rem!important;line-height:2.5rem!important;color:rgb(55,70,90)!important;width:52.75rem!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;height:auto;}#element-362 .contents p{line-height:2.5rem!important;font-size:2.4768rem!important;letter-spacing:-1px!important;}#element-362 strong{font-weight:900;}#element-362.headline{font-weight:900;}#element-367{top:25.75rem;left:28.625rem;height:43.5rem;width:31.3125rem;z-index:92;}#element-367 .cropped{background:url(../<?php echo $info->s9_image ?>) 0 0 / 35.25rem 43.5rem;}#element-366{top:28.5rem;left:0;height:1.375rem;width:59.9375rem;z-index:93;}#element-366 .shape{border-bottom:2px dotted #FBFBFB;}#element-364{top:25.75rem;left:4.875rem;height:6.625rem;width:13.25rem;z-index:94;}#element-364 .shape{border:0;background:rgb(241,90,36);}#element-365{top:26.8125rem;left:6rem;height:4.6875rem;width:11.4375rem;z-index:95;color:#37465A;font-size:0.9907rem;line-height:1.2rem;text-align:left;font-weight:700;}#element-365 .x_178925bc{text-align:left;line-height:1.1875rem;font-size:0.9907rem;}#element-365 .x_f2074b6c{color:#ffffff;}#element-365 strong{font-weight:700;}#element-365.paragraph{font-weight:700;}#element-368{top:41.875rem;left:3.5rem;height:21.25rem;width:25.125rem;z-index:98;color:#37465A;font-size:0.8669rem;line-height:1.4rem;text-align:left;}#element-368 .x_48aa50a2{text-align:left;line-height:1.375rem;font-size:0.8669rem;}#element-368 .x_e1c17884{color:#000001;}#element-368 strong{font-weight:700;}#element-371{top:33.25rem;left:4.875rem;height:8rem;width:24.5625rem;z-index:99;color:#37465A;font-size:1.9814rem;line-height:2rem;text-align:left;font-weight:900;}#element-371 .x_df21e2f7{text-align:left;line-height:2rem;font-size:1.9814rem;}#element-371 .x_f2074b6c{color:#ffffff;}#element-371 strong{font-weight:900;}#element-371.headline{font-weight:900;}#element-381{top:64.6875rem;left:5.6875rem;height:2.5rem;width:16.25rem;z-index:102;}#element-381 .btn.btn-effect3d:active{box-shadow:none;}#element-381 .btn:hover{background:#BA3B03;color:#FFFFFF;}#element-381 .btn{background:linear-gradient(#FF791E,#F65B00 50%);color:#FFFFFF;font-size:0.9907rem;font-family:"objektiv-mk3-1","objektiv-mk3-2",sans-serif;font-weight:900;height:2.5rem;width:16.25rem;border-radius:14px;}#element-370{top:69.3125rem;left:0;height:28.0625rem;width:59.9375rem;z-index:103;}#element-370 .shape{border:0;background:rgb(0,0,0);}#element-369{top:79.25rem;left:34.875rem;height:12.0625rem;width:21.6875rem;z-index:104;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-369 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-369 .x_f2074b6c{color:#ffffff;}#element-369 .x_6ab41614{text-align:left;color:rgb(255,255,255);}#element-369 strong{font-weight:700;}#element-373{top:73.375rem;left:9.25rem;height:6.5rem;width:5.75rem;z-index:105;}#element-375{top:73.375rem;left:22.5rem;height:6.6875rem;width:5.5625rem;z-index:107;}#element-376{top:83.3125rem;left:7rem;height:2.6875rem;width:3.75rem;z-index:108;}#element-377{top:81.8125rem;left:16.25rem;height:5.75rem;width:4.25rem;z-index:109;}#element-378{top:83.3125rem;left:26.25rem;height:2.6875rem;width:3.6875rem;z-index:110;}#element-372{top:73.875rem;left:34.8125rem;height:3rem;width:21.375rem;z-index:111;color:#37465A;font-size:1.2384rem;line-height:1.5rem;text-align:left;font-weight:900;}#element-372 .x_7be91d29{text-align:left;line-height:1.5rem;font-size:1.2384rem;}#element-372 .x_f2074b6c{color:#ffffff;}#element-372 strong{font-weight:900;}#element-372.headline{font-weight:900;}#element-379{top:71.3125rem;left:34.8125rem;height:1.75rem;width:5rem;z-index:113;}#page-block-ceqi3wwonu8{height:70.25rem;max-width:100%;}#page-block-ceqi3wwonu8 .section-holder-border{border:0;}#page-block-ceqi3wwonu8 .section-block{background:none;height:70.25rem;}#page-block-ceqi3wwonu8 .section-holder-overlay{display:none;}#element-343{top:50.8125rem;left:0;height:3.5625rem;width:59.9375rem;z-index:24;}#element-343 .shape{border:0;background:rgb(0,0,0);}#element-321{top:0.125rem;left:0;height:50.875rem;width:59.9375rem;z-index:36;}#element-321 .shape{border:0;background:rgb(255,255,255);}#element-330{top:54.375rem;left:0;height:15.875rem;width:59.875rem;z-index:120;}#element-330 .shape{border:0;background:rgb(251,176,59);}#element-341{top:16.625rem;left:15.5rem;height:8.5rem;width:19.25rem;z-index:121;}#element-338{top:6.8125rem;left:2.75rem;height:21.1875rem;width:22.25rem;z-index:122;}#element-328{top:51.875rem;left:5.3125rem;height:2.5rem;width:20.625rem;z-index:123;color:#37465A;font-size:1.2384rem;line-height:1.25rem;text-align:left;font-weight:900;}#element-328 .x_4a9c0ff4{text-align:left;letter-spacing:-1px;line-height:1.25rem;font-size:1.2384rem;}#element-328 .x_0e1fbe45{color:#f15a24;}#element-328 .contents{font-size:1.2384rem!important;line-height:1.25rem!important;color:rgb(55,70,90)!important;width:20.625rem!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;height:2.5rem!important;}#element-328 .contents p{letter-spacing:-1px!important;line-height:1.25rem!important;font-size:1.2384rem!important;}#element-328 strong{font-weight:900;}#element-328.headline{font-weight:900;}#element-333{top:58.875rem;left:5.5625rem;height:5.9375rem;width:6.25rem;z-index:124;}#element-332{top:61.4375rem;left:16.4375rem;height:1.75rem;width:2.375rem;z-index:125;}#element-331{top:59.375rem;left:23.75rem;height:5.9375rem;width:5.25rem;z-index:126;}#element-334{top:60.25rem;left:35.5625rem;height:4.0625rem;width:3rem;z-index:127;}#element-336{top:61.5625rem;left:44.9375rem;height:1.5rem;width:2.125rem;z-index:129;}#element-337{top:58.875rem;left:50.25rem;height:6.9375rem;width:5.9375rem;z-index:130;}#element-342{top:49.4375rem;left:36.625rem;height:4.125rem;width:16.75rem;z-index:132;font-size:4.125rem;}#element-342 .timer-box{color:#e55211;background-color:#f9f9f9;}#element-342 .timer-labels{color:#f65b00;}#element-319{top:2.4375rem;left:34.1875rem;height:40.375rem;width:21.75rem;z-index:133;}#element-319 .shape{border:0.0625rem solid #A3BAC6;border-radius:0.5rem 0.5rem 0.5rem 0.5rem;background:rgb(255,255,255);}#element-317{top:3.4375rem;left:36.0625rem;height:36.8125rem;width:18.25rem;z-index:134;}.notification-text{font-size:3.125rem;}.form{font-size:0.8125rem;}.form-input{font-size:0.9375rem;height:2.6875rem;}.form-textarea{height:6.25rem;}.form-label-title{margin:0.3125rem 0 0.5rem;font-size:0.89375rem;padding:0;line-height:1.1875rem;}.form-multiple-label{margin-bottom:0.625rem;font-size:0.9375rem;line-height:1.1875rem;padding:0;}.form-multiple-label:empty{display:inline;}.form-checkbox-label:after{top:0.1rem;}.form-label-outside{margin-bottom:0;}.form-multiple-label:before{transition:background-color 0.1s,border 0.1s;}.form-radio-label:hover:before{border:0.3125rem solid #9bc7fd;}.form-messagebox{transform:translate(0);display:flex;}.form-messagebox-left{transform:translateX(-100%);left:-0.625rem;}.form-messagebox-right{transform:translateX(100%);right:-0.625rem;}.form-messagebox:before{top:calc(50% - 0.1875rem);left:auto;}.form-messagebox-left:before{right:-0.1875rem;}.form-messagebox-right:before{left:-0.1875rem;}#element-317 .btn.btn-effect3d:active{box-shadow:none;}#element-317 .btn-product-cart:hover{background:#C34B21;color:#FFFFFF;}#element-317 .btn-product-cart{background:linear-gradient(#FF7842,#F15A24 50%);color:#FFFFFF;font-size:1.1146rem;font-family:"objektiv-mk3-1","objektiv-mk3-2",sans-serif;font-weight:900;height:3.25rem;width:17.75rem;border-radius:15px;}#element-317 .form-label{color:#B4B4B4;}#element-317 ::placeholder{color:#B4B4B4;}#element-317 .form-input{color:#000000;background-color:#FFFFFF;border-color:#FBB03B;}#element-317 .user-invalid{border-color:#E12627;}#element-317 input::placeholder,#element-317 .form-label-inside{color:#B4B4B4;}#element-317 select.valid{color:#000000;}#element-317 .form-btn-geometry{top:37.5rem;left:0.375rem;height:3.25rem;width:17.75rem;z-index:134;}#element-320{top:46.1875rem;left:34.1875rem;height:1.25rem;width:12.25rem;z-index:135;color:#37465A;font-size:0.9288rem;line-height:1.3125rem;text-align:center;font-weight:800;}#element-320 .x_0d0d8539{text-align:center;line-height:1.3125rem;font-size:0.9288rem;}#element-320 .x_7b2817bf{color:#000000;}#element-320 strong{font-weight:800;}#element-320.paragraph{font-weight:800;}#element-329{top:45.25rem;left:52.75rem;height:2.25rem;width:3.4375rem;z-index:136;}#element-327{top:30.5rem;left:5.8125rem;height:6.25rem;width:20.9375rem;z-index:145;color:#37465A;font-size:3.096rem;line-height:3.125rem;text-align:left;font-weight:900;}#element-327 .x_bebc2881{text-align:left;letter-spacing:-3px;line-height:3.125rem;font-size:3.7152rem;}#element-327 .x_7b2817bf{color:#000000;}#element-327 .contents{font-size:2.4768rem!important;line-height:6.25rem!important;color:rgb(55,70,90)!important;width:20.9375rem!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;height:6.25rem!important;}#element-327 .contents p{line-height:3.125rem!important;font-size:3.096rem!important;letter-spacing:-3px!important;}#element-327 strong{font-weight:900;}#element-327.paragraph{font-weight:900;}#element-340{top:28.9375rem;left:5.8125rem;height:1.5625rem;width:4.25rem;z-index:146;}#element-322{top:-3.1875rem;left:5.125rem;height:11.625rem;width:27.875rem;z-index:148;}#element-322 .shape{border:0;background:rgb(255,255,255);}#element-323{top:-1.9375rem;left:6.5625rem;height:8.6875rem;width:26.375rem;z-index:149;color:#37465A;font-size:2.4768rem;line-height:2.5rem;text-align:left;font-weight:900;}#element-323 .x_38bba600{text-align:left;letter-spacing:-3px;line-height:2.1875rem;font-size:2.4768rem;}#element-323 .x_0e1fbe45{color:#f15a24;}#element-323 .contents{font-size:2.4768rem!important;line-height:2.5rem!important;color:rgb(55,70,90)!important;width:26.375rem!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;height:auto;}#element-323 .contents p{line-height:2.1875rem!important;font-size:2.4768rem!important;letter-spacing:-1px!important;}#element-323 strong{font-weight:900;}#element-323.headline{font-weight:900;}#element-348{top:42.1875rem;left:6rem;height:2.25rem;width:14.125rem;z-index:160;color:#37465A;font-size:3.096rem;line-height:5rem;font-weight:900;}#element-348 .x_7575f895{text-align:left;line-height:2.1875rem;font-size:3.096rem;letter-spacing:-2px;}#element-348 .x_0e1fbe45{color:#f15a24;}#element-348 .contents{font-size:4.9536rem!important;line-height:8rem!important;color:rgb(55,70,90)!important;width:14.125rem!important;font-family:objektiv-mk3-1,objektiv-mk3-2,sans-serif!important;font-weight:900!important;height:2.1875rem!important;}#element-348 .contents p{line-height:2.1875rem!important;font-size:2.6rem!important;letter-spacing:-2px!important;}#element-348 strong{font-weight:900;}#element-348.paragraph{font-weight:900;}#element-350{top:39.1875rem;left:6rem;height:2.75rem;width:8.75rem;z-index:161;color:#37465A;font-size:1.7337rem;line-height:2.8rem;font-weight:400;}#element-350 .x_30e7fb47{text-align:left;line-height:2.75rem;font-size:1.712rem;}#element-350 .x_7b2817bf{color:#000000;}#element-350 strong{font-weight:700;}#element-350.paragraph{font-weight:400;}#element-352{top:39.9375rem;left:6rem;height:1.3125rem;width:8.125rem;z-index:163;}#element-352 .shape{border-bottom:1px dotted #000000;}#element-354{top:45.125rem;left:6.1875rem;height:1.625rem;width:14.25rem;z-index:165;color:#37465A;font-size:0.9907rem;line-height:1.6rem;}#element-354 .x_3579aa00{text-align:left;line-height:1.625rem;font-size:0.9907rem;}#element-354 .x_7b2817bf{color:#000000;}#page-block-j8wabyhcyyb{height:6.125rem;max-width:100%;}#page-block-j8wabyhcyyb .section-holder-border{border:0;}#page-block-j8wabyhcyyb .section-block{background:none;height:6.125rem;}#page-block-j8wabyhcyyb .section-holder-overlay{display:none;}#element-137{top:0;left:0;height:6.0625rem;width:59.9375rem;z-index:32;}#element-137 .shape{border:0;background:rgb(0,0,0);}#element-138{top:2.375rem;left:5.3125rem;height:1.25rem;width:51.1875rem;z-index:33;color:#37465A;font-size:0.805rem;line-height:1.3rem;text-align:left;}#element-138 .x_26743634{text-align:left;line-height:1.3125rem;font-size:0.805rem;}#element-138 .x_70ee4658{text-align:center;line-height:1.3125rem;font-size:0.805rem;}#element-138 .x_80c53a0c{color:#fbb03b;}}@media all and (-ms-high-contrast:none),(-ms-high-contrast:active){.form-messagebox{height:auto !important;}} 
  </style>
<?php if($this->selected_lang->id ==2) {  ?>
  <style type="text/css" media="screen">
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
<div class="modal fade" id="faq_modal" tabindex="-1" aria-labelledby="terms_condition" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<?php if($this->selected_lang->id !=2) {
			echo $info->faq_details;
		}else{
			echo $info->faq_details_ar;
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
                <div class="content-whatsapp -top">
                    <div class="container-fluid m-0 py-2" style="background-color: #ededed;">
						<div class="row align-items-center">
							<div class="col-3">
								<img src="http://planetofthegoods.com/assets/img/popup-img.jpg" class="chat-icon" style="max-width: 60px;height: auto;border-radius: 50%;">
							</div>
							<div class="col-7">
								<strong>Planet Of The Goods</strong><br>
								<small>Natalie Wood</small>
							</div>
							<div class="col-2">
								<button type="button" class="closePopup m-0">
									<i class="material-icons icon-font-color">close</i>
								</button>
							</div>
						</div>
					</div>
					<div class="container-fluid m-0 py-2">
						<div class="row">
							<div class="col-12">
								<p class="popup-msg">Hi there 👋 <br>Welcome to Planet Of The Goods.<br>How can I help you?</p>
							</div>
						</div>
					</div>
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
        <style>
.is-active-whatsapp-popup{
	padding: 0px;
    overflow: hidden;
}
.popup-whatsapp > .content-whatsapp.-top {
    margin: 0px;
}
.popup-msg{
	background: #dcf8c6;
    padding: 10px;
    position: relative;
    border-radius: 10px;
}
.popup-msg:before {
    width: 0px;
    height: 0px;
    border-top: 10px solid transparent;
    border-bottom: 10px solid transparent;
    border-right: 10px solid #dcf8c6;
    content: " ";
    position: absolute;
    left: -9px;
    top: 6px;
}
</style>
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