<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row-custom product-share">
    <label><?php echo trans("share"); ?>:</label>
    <ul>
        <li>
            <a href="javascript:void(0)" onclick='window.open("https://www.facebook.com/sharer/sharer.php?u=<?php echo generate_product_url($product); ?>", "Share This Post", "width=640,height=450");return false'>
                <i class="icon-facebook"></i>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" onclick='window.open("https://twitter.com/share?url=<?php echo generate_product_url($product); ?>&amp;text=<?php echo html_escape($product->title); ?>", "Share This Post", "width=640,height=450");return false'>
                <i class="icon-twitter"></i>
            </a>
        </li>
        <li>
            <a href="https://api.whatsapp.com/send?text=<?php echo str_replace("&", "", $product->title); ?> - <?php echo generate_product_url($product); ?>" target="_blank">
                <i class="icon-whatsapp"></i>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" onclick='window.open("http://pinterest.com/pin/create/button/?url=<?php echo generate_product_url($product); ?>&amp;media=<?php echo get_product_image($product->id, 'image_default'); ?>", "Share This Post", "width=640,height=450");return false'>
                <i class="icon-pinterest"></i>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" onclick='window.open("http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo generate_product_url($product); ?>", "Share This Post", "width=640,height=450");return false'>
                <i class="icon-linkedin"></i>
            </a>
        </li>
    </ul>
</div>


<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
        <img class="icon-whatsapp" src="./assets/img/whatsapp.svg">
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
	}, 8000);
});
</script>



