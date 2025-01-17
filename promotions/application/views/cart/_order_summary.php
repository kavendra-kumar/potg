<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="col-sm-12 col-lg-5 order-summary-container">
    <h2 class="cart-section-title"><?php echo trans("order_summary"); ?> (<?php echo get_cart_product_count(); ?>)</h2>
    <div class="right">
        <?php $is_physical = false; ?>
        <div class="cart-order-details">
            <?php if (!empty($cart_items)):
                foreach ($cart_items as $cart_item):
                    $product = get_available_product($cart_item->product_id);
                    if (!empty($product)):
                        if ($product->product_type == 'physical') {
                            $is_physical = true;
                        } ?>
                        <div class="item">
                            <div class="item-left">
                                <div class="img-cart-product">
                                    <a href="<?php echo generate_product_url($product); ?>">
                                        <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_main_product_image(get_product_image($cart_item->product_id, 'image_small')); ?>" alt="<?php echo html_escape($product->title); ?>" class="lazyload img-fluid img-product test" onerror="this.src='<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>'">
                                    </a>
                                </div>
                            </div>
                            <div class="item-right">
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
			?>
			
			<?php
            endif; ?>
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
        if ($is_physical): ?>
        <div class="pointcheckout_discount" style="display:none;">
            <p>
            <?php
                $pointcheckout_discount = $cart_total->subtotal * $this->payment_settings->point_checkout_discount_percentage / 100; 
            ?>
            <?php if($this->payment_settings->point_checkout_discount_enabled == 1){ ?>
                <?php echo trans("discount"); ?><span class="float-right"><?php echo price_formatted($pointcheckout_discount, $this->payment_settings->default_product_currency = $myCurrency); ?></span>
            <?php } ?>
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

