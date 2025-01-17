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
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css"/>
</head>
<body>

<div class="container">
    <div class="container-invoice py-4">
                <div id="content" class="card">
                    <div class="card-body invoice" style="padding: 30px">
                        <div class="row pb-4">
                            <div class="col-md-6">
                                <div class="logo">
                                    <img src="<?php echo get_logo($this->general_settings); ?>" alt="logo">
                                </div>
                            </div>

                            <?php
                            if($order->status == 3){
                                $status = "Cancelled";
                            }elseif($order->status == 9){
                                $status = "Returned";
                            }elseif($order->status < 10 and $order->payment_status =='payment_received') {
                                $status = "Paid";
                            } elseif($order->status < 10 and $order->payment_status =='awaiting_payment') {
                                $status = "UnPaid";
                            } elseif($order->status >= 10 and $order->status <= 14) {
                                $status = "Refunded";
                            }
                            ?>

                            <div class="col-md-6">
                                <div class="float-right">
                                    <?php $show_all_products = true;
                                    $prefix = "";
                                    if ($this->auth_user->role != "admin" && $order->buyer_id != $this->auth_user->id) {
                                        $show_all_products = false;
                                        $prefix = "VN";
                                    } ?>
                                    <p class="font-weight-bold mb-1"><span style="display: inline-block;width: 100px;"><?php echo trans("invoice"); ?>:</span>#<?php echo $prefix . $order->order_number; ?></p>
                                    <p class="font-weight-bold"><span style="display: inline-block;width: 100px;"><?php echo trans("date"); ?>:</span><?php echo helper_date_format($order->created_at); ?></p>
                                    <p class="font-weight-bold"><span style="display: inline-block;width: 100px;"><?php echo trans("status"); ?>:</span><?php echo $status; ?></p>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p class="font-weight-bold mb-3"><?php echo trans("client_information"); ?></p>
                                <?php if (!empty($invoice->client_username)): ?>
                                    <p class="mb-1"><?php echo html_escape($invoice->client_username); ?></p>
                                <?php endif; ?>
                                <?php if (!empty($invoice->client_first_name) || !empty($invoice->client_last_name)): ?>
                                    <p class="mb-1"><?php echo html_escape($invoice->client_first_name); ?>&nbsp;<?php echo html_escape($invoice->client_last_name); ?></p>
                                <?php endif; ?>
                                <?php if (!empty($invoice->client_address)): ?>
                                    <p class="mb-1"><?php echo html_escape($invoice->client_address); ?></p>
                                <?php endif; ?>
                                <?php if (!empty($shippingDetails->shipping_phone_number)): ?>
                                    <p class="mb-1">Contact No : <?php echo html_escape($shippingDetails->shipping_phone_number); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="col-6">
                                <div class="float-right">
                                    <p class="font-weight-bold mb-3"><?php echo trans("payment_details"); ?></p>
                                    <p class="mb-1"><span style="display: inline-block;min-width: 158px;"><?php echo trans("payment_method"); ?>:</span><?php echo $order->payment_method; ?></p>
                                    <p class="mb-1"><span style="display: inline-block;min-width: 158px;"><?php echo trans("currency"); ?>:</span><?php echo $order->price_currency; ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="row pt-3">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th class="border-0 font-weight-bold"><?php echo trans("seller"); ?></th>
                                            <th class="border-0 font-weight-bold"><?php echo trans("description"); ?></th>
                                            <th class="border-0 font-weight-bold"><?php echo trans("quantity"); ?></th>
                                            <th class="border-0 font-weight-bold"><?php echo trans("unit_price"); ?></th>
                                            <?php if ($this->general_settings->vat_status): ?>
                                                <th class="border-0 font-weight-bold"><?php echo trans("vat"); ?></th>
                                            <?php endif; ?>
                                            <th class="border-0 font-weight-bold"><?php echo trans("shipping"); ?></th>
                                            <th class="border-0 font-weight-bold"><?php echo trans("total"); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if ($show_all_products) {
                                            $sale_subtotal = $order->price_subtotal;
                                            $sale_vat = $order->price_vat;
                                            $sale_shipping = $order->price_shipping;
                                            $sale_total = $order->price_total;
                                        } else {
                                            $sale_subtotal = 0;
                                            $sale_vat = 0;
                                            $sale_shipping = 0;
                                            $sale_total = 0;
                                        }

                                        $is_order_has_physical_product = false;
                                        if (!empty($invoice_items) && is_array($invoice_items)):
                                            foreach ($invoice_items as $item):
                                                
                                                $order_product_id = @$item['id'];
                                                $seller = @$item['seller'];
                                                if (!empty($order_product_id)):
                                                    $order_product = $this->order_model->get_order_product($order_product_id);
                                                    if (!empty($order_product)):
                                                        if ($order_product->product_type == 'physical') {
                                                            $is_order_has_physical_product = true;
                                                        }
                                                        if ($order_product->buyer_id == $this->auth_user->id || $order_product->seller_id == $this->auth_user->id || $this->auth_user->role == "admin"):
                                                            if ($show_all_products == false):
                                                                $sale_subtotal += $order_product->product_unit_price * $order_product->product_quantity;
                                                                $sale_vat += $order_product->product_vat;
                                                                $sale_shipping += $order_product->product_shipping_cost;
                                                                $sale_total += $order_product->product_total_price;
                                                            endif; ?>
                                                            <tr style="font-size: 15px;">
                                                                <td><?php echo html_escape($seller); ?></td>
                                                                <td><?php echo $order_product->product_title; ?><br>(<?php echo trans("product_id").": ". $order_product->product_id; ?>)</td>
                                                                <td><?php echo $order_product->product_quantity; ?></td>
                                                                <td><?php echo price_formatted($order_product->product_unit_price, $order_product->product_currency); ?></td>
                                                                <?php if ($this->general_settings->vat_status): ?>
                                                                    <td>
                                                                        <?php if (!empty($order_product->product_vat)): ?>
                                                                            <?php echo price_formatted($order_product->product_vat, $order_product->product_currency); ?>&nbsp;(<?php echo $order_product->product_vat_rate; ?>%)
                                                                        <?php endif; ?>
                                                                    </td>
                                                                <?php endif; ?>
                                                                <td><?php echo price_formatted($order_product->product_shipping_cost, $order_product->product_currency); ?></td>
                                                                <td><?php echo price_formatted($order_product->product_total_price, $order_product->product_currency); ?></td>
                                                            </tr>
                                                        <?php endif;
                                                    endif;
                                                endif;
                                            endforeach;
                                        endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <?php if($order->status >= 10 and $order->status <= 14) { ?>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="order-total float-right">
                                    <div class="row mb-2">
                                        <div class="col-6 col-left">
                                            <?php echo trans("paid"); ?>
                                        </div>
                                        <div class="col-6 col-right">
                                            <strong class="font-600"><?php echo price_formatted($sale_total, $order->price_currency); ?></strong>
                                        </div>
                                    </div>
                                    <?php if ($order->vat_deduction == 1){
                                        $vat_deduction = $sale_vat;
                                    ?>
                                        <div class="row mb-2">
                                            <div class="col-6 col-left">
                                                <?php echo trans("vat"); ?>
                                            </div>
                                            <div class="col-6 col-right">
                                                <strong class="font-600">-<?php echo price_formatted($sale_vat, $order->price_currency); ?></strong>
                                            </div>
                                        </div>
                                        <?php } else {
                                                $vat_deduction = 0;
                                            }
                                        ?>
                                    
                                    <?php if ($is_order_has_physical_product): ?>
                                        <div class="row mb-2">
                                            <div class="col-6 col-left">
                                                <?php echo trans("sent_shipping_cost"); ?>
                                            </div>
                                            <div class="col-6 col-right">
                                                <strong class="font-600">-<?php echo price_formatted($order->sent_shipping_cost, $order->price_currency); ?></strong>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-6 col-left">
                                                <?php echo trans("return_shipping_cost"); ?>
                                            </div>
                                            <div class="col-6 col-right">
                                                <strong class="font-600">-<?php echo price_formatted($order->return_shipping_cost, $order->price_currency); ?></strong>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="row mb-2">
                                            <div class="col-6 col-left">
                                                <?php echo trans("additional_cost"); ?>
                                            </div>
                                            <div class="col-6 col-right">
                                                <strong class="font-600">-<?php echo price_formatted($order->additional_cost, $order->price_currency); ?></strong>
                                            </div>
                                        </div>
                                    
                                    <?php
                                        $total_refund = $order->price_total - ($vat_deduction + $order->sent_shipping_cost + $order->return_shipping_cost + $order->additional_cost);
                                    ?>

                                    <div class="row mb-2">
                                        <div class="col-6 col-left">
                                            <?php echo trans("order_refund_total"); ?>
                                        </div>
                                        <div class="col-6 col-right">
                                            <strong class="font-600"><?php echo price_formatted($total_refund, $order->price_currency); ?></strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php } else { ?>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="order-total float-right">
                                    <div class="row mb-2">
                                        <div class="col-6 col-left">
                                            <?php echo trans("subtotal"); ?>
                                        </div>
                                        <div class="col-6 col-right">
                                            <strong class="font-600"><?php echo price_formatted($sale_subtotal, $order->price_currency); ?></strong>
                                        </div>
                                    </div>
                                    <?php if (!empty($sale_vat)): ?>
                                        <div class="row mb-2">
                                            <div class="col-6 col-left">
                                                <?php echo trans("vat"); ?>
                                            </div>
                                            <div class="col-6 col-right">
                                                <strong class="font-600"><?php echo price_formatted($sale_vat, $order->price_currency); ?></strong>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($is_order_has_physical_product): ?>
                                        <div class="row mb-2">
                                            <div class="col-6 col-left">
                                                <?php echo trans("shipping"); ?>
                                            </div>
                                            <div class="col-6 col-right">
                                                <strong class="font-600"><?php echo price_formatted($sale_shipping, $order->price_currency); ?></strong>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                        <?php  if ($getDiscount['discount_type']!=""): ?>
                                            <!-- <div class="row mb-2">
                                            <div class="col-6 col-left">
                                                Discount type
                                            </div>
                                            <div class="col-6 col-right">
                                                <strong class="font-600">
                                                    <?php if($getDiscount['discount_type']=="fix-amount"){ ?>
                                                     Fix amount
                                                    <?php } elseif($getDiscount['discount_type']=="percentage"){ ?>
                                                        Percentage
                                                    <?php } ?>
                                                </strong>
                                            </div>
                                            </div> -->
                                        <?php endif; ?>

                                     <?php if ($getDiscount['total_discount']):
                                    
                                    if($getDiscount['discount_type']=="fix-amount") {
                                        $total_discount = $getDiscount['total_discount'];
                                        $msg = '';
                                    } else {
                                        $total_discount = ($sale_subtotal / 100) * $getDiscount['total_discount']/100;
                                        $msg = ' ('.$getDiscount['total_discount'].'%)';
                                    }
                                        
                                    ?>
                                        <div class="row mb-2">
                                            <div class="col-6 col-left">
                                                Total Discount
                                            </div>
                                            <div class="col-6 col-right">
                                                <strong class="font-600">
                                                    <?php echo $msg; ?>
                                                    <?php echo price_formatted($total_discount*100, $order->price_currency); ?>
                                                    

                                                </strong>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="row mb-2">
                                        <div class="col-6 col-left">
                                            <?php echo trans("total"); ?>
                                        </div>
                                        <div class="col-6 col-right">
                                            <strong class="font-600">
                                                <?php echo price_formatted($sale_total, $order->price_currency); ?>
                                            </strong>
                                        </div>
                                    </div>
                                    <?php if($order->status < 10 and ($order->status != 3 or $order->status != 9)) { ?>
                                    <div class="row mb-2">
                                        <div class="col-6 col-left">
                                            Due Amount
                                        </div>
                                        <div class="col-6 col-right">
                                            <strong class="font-600">
                                            <?php
                                            if($order->payment_status =='payment_received') {
                                                $due_amnt = 0;
                                            } elseif($order->payment_status =='awaiting_payment') {
                                                $due_amnt = $sale_total;
                                            }
                                            ?>
                                                <?php echo price_formatted($due_amnt, $order->price_currency); ?>
                                            </strong>
                                        </div>
                                    </div>
                                    <?php } ?>
                                 
                                </div>
                            </div>
                        </div>

                        <?php } ?>



                        <div class="row">
                            <div class="col-12 pb-3">
                                Thank you for Shopping
                            </div>
                            <div class="col-auto" style="font-size: 13px;">
                                Email Us: Info@planetofthegoods.com<br>
                                Twitter: www.twitter.com/planetofgoods
                            </div>
                            <div class="col-auto" style="font-size: 13px;">
                                Follow Us: www.instagram.com/planetofthegoods<br>
                                LinkedIn: www.linkedin.com/in/planetofthegoods
                            </div>
                            <div class="col-auto" style="font-size: 13px;">
                                Facebook: www.facebook.com/planetofthegoods
                            </div>
                            <div class="col-12 py-3">
                                Terms & Conditions
                            </div>
                            <div class="col-auto" style="font-size: 13px;">
                                This item has been received and in good condition and the client indemnifies the supplier of any damages whatsoever. In case of any dissatisfaction for any reason, return the item unused / unopened and we will gladly exchange for same or another equivalent value product for a period of one year from purchase, return courier charges are on the client.
                            </div>
                            <div class="col-4 pt-4">
                                <p style="padding-bottom: 40px;border-bottom: 1px solid #000000;">Customer Signature</p>
                            </div>
                            <div class="col-4 pt-4">
                                <p style="padding-bottom: 40px;border-bottom: 1px solid #000000;">Delivered By</p>
                            </div>
                        </div>
                    </div>
                    <style>
                        body {
                            font-size: 16px !important;
                        }

                        .container-invoice {
                            max-width: 900px;
                            margin: 0 auto;
                        }

                        table {
                            border-bottom: 1px solid #dee2e6;
                        }

                        table th {
                            font-size: 14px;
                            white-space: nowrap;
                        }

                        .order-total {
                            width: 400px;
                            max-width: 100%;
                            float: right;
                            padding: 20px;
                        }

                        .order-total .col-left {
                            font-weight: 600;
                        }

                        .order-total .col-right {
                            text-align: right;
                        }

                        #btn_print {
                            min-width: 180px;
                        }

                        @media print {
                            .hidden-print {
                                display: none !important;
                            }
                        }
                    </style>
                </div>
            </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12 text-center mt-3">
            <button id="btn_print" class="btn btn-secondary btn-md hidden-print">
                <svg id="i-print" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="16" height="16" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" style="margin-top: -4px;">
                    <path d="M7 25 L2 25 2 9 30 9 30 25 25 25 M7 19 L7 30 25 30 25 19 Z M25 9 L25 2 7 2 7 9 M22 14 L25 14"/>
                </svg>
                &nbsp;&nbsp;<?php echo trans("print"); ?></button>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
<script>
    $(document).on('click', '#btn_print', function () {
        window.print();
    });
</script>
</body>
</html>