<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="col-sm-12 col-lg-5 order-summary-container">
    <h2 class="cart-section-title"><?php echo trans("order_summary"); ?> (<?php echo get_cart_product_count(); ?>)</h2>
    <div class="right">
        <?php $is_physical = false; ?>
        <div class="cart-order-details">
            <?php if (!empty($cart_items)):
			$product_ids = array();
                foreach ($cart_items as $cart_item):
					array_push($product_ids,$cart_item->product_id);
                    $product = get_available_product($cart_item->product_id);
                    if (!empty($product)):
                        if ($product->product_type == 'physical') {
                            $is_physical = true;
                        } ?>
                        <div class="item">
                            <div class="item-left">
                                <div class="img-cart-product <?php if($this->selected_lang->short_form == 'ar'){ ?> img-ar-checkout-div<?php } ?>">
                                    <a href="<?php echo generate_product_url($product); ?>">
                                        <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_product_image($cart_item->product_id, 'image_small'); ?>" alt="<?php echo html_escape($product->title); ?>" class="lazyload img-fluid img-product <?php if($this->selected_lang->short_form == 'ar'){ ?> img-ar-checkout<?php } ?>" onerror="this.src='<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>'">
                                    </a>
                                </div>
                            </div>
                            <div class="item-right <?php if($this->selected_lang->short_form == 'ar'){ ?> item-right-ar<?php } ?>">
                                <?php if ($product->product_type == 'digital'): ?>
                                    <div class="list-item">
                                        <label class="label-instant-download label-instant-download-sm"><i class="icon-download-solid"></i><?php echo trans("instant_download"); ?></label>
                                    </div>
                                <?php endif; ?>
                                <div class="list-item">
                                    <a href="<?php echo generate_product_url($product); ?>">
                                        <?php echo html_escape($cart_item->product_title); ?>
                                    </a>
                                </div>
                                <div class="list-item seller">
                                    <?php echo trans("by"); ?>&nbsp;<a href="<?php echo generate_profile_url($product->user_slug); ?>"><?php echo get_shop_name_product($product); ?></a>
                                </div>
                                <div class="list-item m-t-15">
                                    <label><?php echo trans("quantity"); ?>:</label>
                                    <strong class="lbl-price"><?php echo $cart_item->quantity; ?></strong>
                                </div>
                                <div class="list-item">
                                    <label><?php echo trans("price"); ?>:</label>
                                    <strong class="lbl-price"><?php echo price_formatted($cart_item->total_price, $cart_item->currency); ?></strong>
                                </div>
                                <?php if (!empty($cart_item->product_vat)): ?>
                                    <div class="list-item">
                                        <label><?php echo trans("vat"); ?>:</label>
                                        <strong><?php echo price_formatted($cart_item->product_vat, $cart_item->currency); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if ($product->product_type != 'digital' && $this->form_settings->shipping == 1): ?>
                                    <div class="list-item">
                                        <label><?php echo trans("shipping"); ?>:</label>
                                        <strong><?php echo price_formatted($cart_item->shipping_cost, $cart_item->currency); $myCurrency = $cart_item->currency; ?></strong>
                                    </div>
                                <?php endif; ?>

                                <div class="list-item">
                                    <a href="javascript:void(0)" class="btn btn-md btn-outline-gray btn-cart-remove" onclick="remove_from_cart('<?php echo $cart_item->cart_item_id; ?>');"><i class="icon-close"></i> <?php echo trans("remove"); ?></a>
                                </div>

                            </div>
                        </div>
                    <?php endif;
                endforeach;
			//print_r(json_encode($product_ids));
			?>
			
			<?php
            endif; /*
            <div class="form-group">
				<div class="row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            
                            <input type="text" style="text-transform:uppercase;" placeholder="Apply Promo Code" name="promocode" id="promocode" class="form-control" aria-describedby="basic-addon1" required="">
                            <span class="input-group-addon btn btn-success" id="basic-addon1">Apply</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <span id="promocodestatus"></span>
            </div> */ ?>
        </div>
        <p class="m-t-30">
            <strong><?php echo trans("subtotal"); ?><span class="float-right"><?php echo price_formatted($cart_total->subtotal, $this->payment_settings->default_product_currency  = $myCurrency); ?></span></strong>
        </p>
        <?php if (!empty($cart_total->vat)): ?>
            <p>
                <?php echo trans("vat"); ?><span class="float-right"><?php echo price_formatted($cart_total->vat, $cart_total->currency); ?></span>
            </p>
        <?php endif; ?>
        <?php if ($is_physical && $this->form_settings->shipping == 1): ?>
            <p>
                <?php echo trans("shipping"); ?><span class="float-right"><?php echo price_formatted($cart_total->shipping_cost, $this->payment_settings->default_product_currency = $myCurrency); ?></span>
            </p>
        <?php endif; ?>

        <?php 
        $pointcheckout_discount = 0;
        if ($is_physical && $this->payment_settings->point_checkout_discount_enabled == 1): ?>
        <div class="pointcheckout_discount" style="display:none;">
            <p>
            <?php
                $pointcheckout_discount = $cart_total->subtotal * $this->payment_settings->point_checkout_discount_percentage / 100; 
            ?>
                <?php echo trans("discount"); ?><span class="float-right"><?php echo price_formatted($pointcheckout_discount, $this->payment_settings->default_product_currency = $myCurrency); ?></span>
            </p>

            <p class="line-seperator"></p>
            <p>
                <strong><?php echo trans("total"); ?><span class="float-right"><?php echo price_formatted(($cart_total->total - $pointcheckout_discount), $this->payment_settings->default_product_currency); ?></span></strong>
            </p>
        </div>
        <?php endif; ?> 
        <div class="cod_discount">
            <p class="line-seperator"></p>
            <p>
                <strong><?php echo trans("total"); ?><span class="float-right"><?php echo price_formatted($cart_total->total, $this->payment_settings->default_product_currency); ?></span></strong>
            </p>
        </div>
        

    </div>
</div>
<div class="modal fade" id="crossSaleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="cross_sale_product_list">
			<div class="row">
				<div class="col-4">
					<img class="img-thumbnail" src="http://planetofthegoods.com/uploads/images/202010/img_x300_5f7f0dbe253bd0-16306928-62409133.jpg" />
				</div>
				<div class="col-8">
					<p class="cross_name">Product Name</p>
					<p class="cross_price">15.00 AED</p>
					<button class="btn btn-custom add_cart_btn" data-id="22">Buy Now</button>
				</div>
			</div>
		</div>
      </div>
    </div>
  </div>
</div>
<!-- <script>
	$( document ).ready(function() {
		var a = {
			ids: <?php  print_r(json_encode($product_ids)); ?>
		};
		$.ajax({
			type: "POST",
			url: base_url + "ajax_controller/get_cross_sale",
			data: a,
			success: function(c) {
				var c = '[{"id":"22","title":"IPL Laser Eye Protection Goggles, Strong Laser Eyes Protection FDA Recommended.","slug":"ipl-laser-eye-protection-goggles-strong-laser-eyes-protection-fda-recommended-22","price":"1500","currency":"OMR","country_id":"165","image_small":"202010\/img_x300_5f84169a4a1ba0-03371181-52467272.jpg","is_main":"1"}]';
				var data = JSON.parse(c);
				if(data.length > 0){
					
				}
			debugger;
			}
		});
	});
</script> -->
<script>
    $("#basic-addon1").click(function(){
        var co=$("#promocode").val();
        if(co=='')
        {
            $("#promocodestatus").html("Please Enter Promo Code");
        }
        else 
        {
            //Here we eed to check from database that entered code is already exist or ot
            //For that we require ajax or if you dont 
            $.ajax({
                url:"<?=base_url('admin/validatepromocode')?>/"+co,
                success:function(result){
                    $("#promocodestatus").html(result);
                }

            });
        }
    });
    </script>

