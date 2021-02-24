<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title" style="width:100%;"><?php echo trans("order_details"); ?> <?php if ($order->status != 3): ?> <a href="<?php echo base_url(); ?>invoice/<?php echo $order->order_number; ?>" class="btn btn-sm btn-success" target="_blank" style="float:right;"><i class="fa fa-file-text"></i>&nbsp;&nbsp;<?php echo trans("view_invoice"); ?></a> <?php endif; ?> </h3>
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="row" style="margin-bottom: 30px;">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <h4 class="sec-title"><?php echo trans("order"); ?>#<?php echo $order->order_number; ?> </h4>
                        <div class="row row-details">
                            <div class="col-xs-12 col-sm-4 col-right">
                                <strong> <?php echo trans("status"); ?></strong>
                            </div>
                            <div class="col-sm-8">
                            <?php if ($order->status == 1): ?>
                                <label class="label label-success"><?php echo trans("completed"); ?></label>
                            <?php elseif ($order->status == 2): ?>
                                <label class="label label-warning"><?php echo trans("confirmed"); ?></label>
                            <?php elseif ($order->status == 3): ?>
                                <label class="label label-danger"><?php echo trans("cancelled"); ?></label>
                            <?php elseif ($order->status == 4): ?>
                                <label class="label label-primary"><?php echo trans("shipped"); ?></label>
                            <?php elseif ($order->status == 5): ?>
                                <label class="label label-success"><?php echo trans("payment_received"); ?></label>
                            <?php elseif ($order->status == 6): ?>
                                <label class="label label-danger"><?php echo trans("awaiting_payment"); ?></label>
                            <?php elseif ($order->status == 7): ?>
                                <label class="label label-info"><?php echo trans("order_processing"); ?></label>
                            <?php elseif ($order->status == 8): ?>
                                <label class="label label-info"><?php echo trans("scheduled"); ?></label>
                            <?php else: ?>
                                <label class="label label-default"><?php echo trans("new"); ?></label>
                            <?php endif; ?>
                            </div>
                        </div>

                        <div class="row row-details">
                            <div class="col-xs-12 col-sm-4 col-right">
                                <strong> <?php echo trans("order_id"); ?></strong>
                            </div>
                            <div class="col-sm-8">
                                <strong class="font-right"><?php echo $order->id; ?></strong>
                            </div>
                        </div>
                        <div class="row row-details">
                            <div class="col-xs-12 col-sm-4 col-right">
                                <strong> <?php echo trans("order_number"); ?></strong>
                            </div>
                            <div class="col-sm-8">
                                <strong class="font-right"><?php echo $order->order_number; ?></strong>
                            </div>
                        </div>

                        <div class="row row-details">
                            <div class="col-xs-12 col-sm-4 col-right">
                                <strong> <?php echo trans("payment_method"); ?></strong>
                            </div>
                            <div class="col-sm-8">
                                <strong class="font-right">
                                    <?php
                                    if ($order->payment_method == "Bank Transfer") {
                                        echo trans("bank_transfer");
                                    } else {
                                        echo $order->payment_method;
                                    } ?>
                                </strong>
                            </div>
                        </div>
                        <div class="row row-details">
                            <div class="col-xs-12 col-sm-4 col-right">
                                <strong> <?php echo trans("currency"); ?></strong>
                            </div>
                            <div class="col-sm-8">
                                <strong class="font-right"><?php echo $order->price_currency; ?></strong>
                            </div>
                        </div>
                        <div class="row row-details">
                            <div class="col-xs-12 col-sm-4 col-right">
                                <strong> <?php echo trans("payment_status"); ?></strong>
                            </div>
                            <div class="col-sm-8">
                                <strong class="font-right"><?php echo trans($order->payment_status); ?></strong>
                            </div>
                        </div>

                        <div class="row row-details">
                            <div class="col-xs-12 col-sm-4 col-right">
                                <strong> <?php echo trans("updated"); ?></strong>
                            </div>
                            <div class="col-sm-8">
                                <strong class="font-right"><?php echo formatted_date($order->updated_at); ?>&nbsp;(<?php echo time_ago($order->updated_at); ?>)</strong>
                            </div>
                        </div>
                        <div class="row row-details">
                            <div class="col-xs-12 col-sm-4 col-right">
                                <strong> <?php echo trans("date"); ?></strong>
                            </div>
                            <div class="col-sm-8">
                                <strong class="font-right"><?php echo formatted_date($order->created_at); ?>&nbsp;(<?php echo time_ago($order->created_at); ?>)</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <h4 class="sec-title"><?php echo trans("buyer"); ?></h4>
                        <?php if ($order->buyer_id == 0): ?>
                            <div class="row row-details">
                                <div class="col-xs-12">
                                    <div class="table-orders-user">
                                        <img src="<?php echo get_user_avatar(null); ?>" alt="" class="img-responsive" style="height: 120px;">
                                    </div>
                                </div>
                            </div>
                            <?php $shipping = get_order_shipping($order->id);
                            if (!empty($shipping)): ?>
                                <div class="row row-details">
                                    <div class="col-xs-12 col-sm-4 col-right">
                                        <strong> <?php echo trans("buyer"); ?></strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong class="font-right"><?php echo $shipping->shipping_first_name . " " . $shipping->shipping_last_name; ?> <label class="label bg-olive"><?php echo trans("guest"); ?></label></strong>
                                    </div>
                                </div>
                                <div class="row row-details">
                                    <div class="col-xs-12 col-sm-4 col-right">
                                        <strong> <?php echo trans("phone_number"); ?></strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong class="font-right"><?php echo $shipping->shipping_phone_number; ?></strong>
                                    </div>
                                </div>
                                <div class="row row-details">
                                    <div class="col-xs-12 col-sm-4 col-right">
                                        <strong> <?php echo trans("email"); ?></strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong class="font-right"><?php echo $shipping->shipping_email; ?></strong>
                                    </div>
                                </div>
                            <?php endif; ?>


                        <?php else: ?>
                            <?php $buyer = get_user($order->buyer_id);
                            if (!empty($buyer)):?>
                                <div class="row row-details">
                                    <div class="col-xs-12">
                                        <div class="table-orders-user">
                                            <a href="<?php echo generate_profile_url($buyer->slug); ?>" target="_blank">
                                                <img src="<?php echo get_user_avatar($buyer); ?>" alt="" class="img-responsive" style="height: 120px;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-details">
                                    <div class="col-xs-12 col-sm-4 col-right">
                                        <strong> <?php echo trans("username"); ?></strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong class="font-right">
                                            <a href="<?php echo generate_profile_url($buyer->slug); ?>" target="_blank">
                                                <?php echo html_escape($buyer->username); ?>
                                            </a>
                                        </strong>
                                    </div>
                                </div>

                                <div class="row row-details">
                                    <div class="col-xs-12 col-sm-4 col-right">
                                        <strong> <?php echo trans("phone_number"); ?></strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong class="font-right"><?php echo $buyer->phone_number; ?></strong>
                                    </div>
                                </div>

                                <div class="row row-details">
                                    <div class="col-xs-12 col-sm-4 col-right">
                                        <strong> <?php echo trans("email"); ?></strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong class="font-right"><?php echo $buyer->email; ?></strong>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <?php $shipping = get_order_shipping($order->id);
                if (!empty($shipping)):?>
					<div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-md" role="document">
						<div class="modal-content">
						<?php echo form_open_multipart('order_admin_controller/edit_shipping_address'); ?>
							<div class="modal-header">
								<h5 class="modal-title"><?php echo trans("shipping_address"); ?></h5>
							</div>
							<div class="modal-body">
								<input type="hidden" name="order_id" value="<?php echo $order->id; ?>">
								<div class="row">
									<div class="col-xs-12 col-sm-6">
										<div class="form-group">
											<label for="name"><?php echo trans("full_name"); ?></label>
											<input type="text" class="form-control" id="name" name="shipping_first_name" value="<?php echo $shipping->shipping_first_name .' '. $shipping->shipping_last_name?>">
										</div>
									</div>
									<div class="col-xs-12 col-sm-6">
										<div class="form-group">
											<label for="phone_number"><?php echo trans("phone_number"); ?></label>
											<input type="text" class="form-control" id="phone_number" name="shipping_phone_number" value="<?php echo $shipping->shipping_phone_number; ?>">
										</div>
									</div>
									<div class="col-xs-12 col-sm-6">
										<div class="form-group">
											<label for="address1"><?php echo trans("address"); ?> 1</label>
											<input type="text" class="form-control" id="address1" name="shipping_address_1" value="<?php echo $shipping->shipping_address_1; ?>">
										</div>
									</div>
									<div class="col-xs-12 col-sm-6">
										<div class="form-group">
											<label for="address2"><?php echo trans("address"); ?> 2</label>
											<input type="text" class="form-control" id="address2" name="shipping_address_2" value="<?php echo $shipping->shipping_address_2; ?>">
										</div>
									</div>
									<div class="col-xs-12 col-sm-6">
										<div class="form-group">
											<label for="country"><?php echo trans("country"); ?></label>
											<input type="text" class="form-control" id="country" disabled value="<?php echo $shipping->shipping_country; ?>">
										</div>
									</div>
									<div class="col-xs-12 col-sm-6">
										<div class="form-group">
											<label for="city"><?php echo trans("city"); ?></label>
											<input type="text" class="form-control" id="city" name="shipping_city" value="<?php echo $shipping->shipping_city; ?>">
										</div>
									</div>
								
								</div>
							</div>
							<div class="modal-footer">
								<button class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary">Save</button>
							</div>
						<?php echo form_close(); ?>
						</div>
					  </div>
					</div>
                    <div class="row">
						<div class="col-sm-12 col-md-12 col-lg-6">
                            <h4 class="sec-title"><?php echo trans("shipping_address"); ?><a class="bg-green-gradient" style="float: right;margin-left:10px;border-radius: 10%;padding: 3px;" href="https://api.whatsapp.com/send?phone=<?php echo $shipping->shipping_phone_number; ?>" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>  <a style="float:right;" href="#" data-toggle="modal" data-target="#addressModal"><?php echo trans("edit"); ?></a></h4>

                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("first_name"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->shipping_first_name; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details hidden">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("last_name"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->shipping_last_name; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("email"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->shipping_email; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("phone_number"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->shipping_phone_number; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("address"); ?> 1</strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->shipping_address_1; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("address"); ?> 2</strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->shipping_address_2; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("country"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->shipping_country; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details hidden">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("state"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->shipping_state; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("city"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->shipping_city; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details hidden">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("zip_code"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->shipping_zip_code; ?></strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6">
                            <h4 class="sec-title"><?php echo trans("billing_address"); ?></h4>

                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("first_name"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->billing_first_name; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details hidden">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("last_name"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->billing_last_name; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("email"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->billing_email; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("phone_number"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->billing_phone_number; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("address"); ?> 1</strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->billing_address_1; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("address"); ?> 2</strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->billing_address_2; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("country"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->billing_country; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details hidden">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("state"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->billing_state; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("city"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->billing_city; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details hidden">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("zip_code"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->billing_zip_code; ?></strong>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                <?php endif; ?>


            </div><!-- /.box-body -->
        </div>
    </div>
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("products"); ?></h3> 
				<button  data-toggle="modal" style="margin-left:10px;" class="btn btn-xs btn-primary m-t-5" data-target="#AddProductModal">+Add Product</button>
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="row">
                    <!-- include message block -->
                    <div class="col-sm-12">
                        <?php $this->load->view('admin/includes/_messages'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive" id="t_product">
                            <table class="table table-bordered table-striped" role="grid">
                                <thead>
                                <tr role="row">
                                    <th><?php echo trans('product_id'); ?></th>
                                    <th><?php echo trans('product'); ?></th>
                                    <th><?php echo trans('unit_price'); ?></th>
                                    <th><?php echo trans('quantity'); ?></th>
                                    <th><?php echo trans('vat'); ?></th>
                                    <th><?php echo trans('shipping_cost'); ?></th>
                                    <th><?php echo trans('total'); ?></th>
                                    <th><?php echo trans('status'); ?></th>
                                    <th><?php echo trans('updated'); ?></th>
                                    <th class="max-width-120"><?php echo trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $is_order_has_physical_product = false; ?>
                                <?php foreach ($order_products as $item):
                                    if ($item->product_type == 'physical') {
                                        $is_order_has_physical_product = true;
                                    } ?>
                                    <tr>
                                        <td style="width: 80px;">
                                            <?php echo html_escape($item->product_id); ?>
                                        </td>
                                        <td>
                                            <div class="img-table" style="height: 67px;">
                                                <a href="<?php echo generate_product_url_by_slug($item->product_slug); ?>" target="_blank">
                                                    <img src="<?php echo get_product_image($item->product_id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image"/>
                                                </a>
                                            </div>
                                            <p>
                                                <?php if ($item->product_type == 'digital'): ?>
                                                    <label class="label bg-black"><i class="icon-cloud-download"></i><?php echo trans("instant_download"); ?></label>
                                                <?php endif; ?>
                                            </p>
                                            <a href="<?php echo generate_product_url_by_slug($item->product_slug); ?>" target="_blank" class="table-product-title">
                                                <?php echo html_escape($item->product_title); ?>
                                            </a>
                                            <p>
                                                <span><?php echo trans("by"); ?></span>
                                                <?php $seller = get_user($item->seller_id); ?>
                                                <?php if (!empty($seller)): ?>
                                                    <a href="<?php echo generate_profile_url($seller->slug); ?>" target="_blank" class="table-product-title">
                                                        <strong><?php echo html_escape($seller->username); ?></strong>
                                                    </a>
                                                <?php endif; ?>
                                            </p>
                                        </td>
                                        <td><?php echo price_formatted($item->product_unit_price, $item->product_currency); ?></td>
                                        <td><?php echo $item->product_quantity; ?></td>
                                        <td>
                                            <?php if ($item->product_vat):
                                                echo price_formatted($item->product_vat, $item->product_currency); ?>&nbsp;(<?php echo $item->product_vat_rate; ?>%)
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($item->product_type == 'physical'):
                                                echo price_formatted($item->product_shipping_cost, $item->product_currency);
                                            endif; ?>
                                        </td>
                                        <td><?php echo price_formatted($item->product_total_price, $item->product_currency); ?></td>
                                        
                                        <td>
                                            <strong><?php echo trans($item->order_status); ?></strong>
                                            <?php if ($item->buyer_id == 0): ?>
                                                <?php if ($item->is_approved == 0): ?>
                                                    <br>
                                                    <?php echo form_open('order_admin_controller/approve_guest_order_product'); ?>
                                                    <input type="hidden" name="order_product_id" value="<?php echo $item->id; ?>">
                                                    <button type="submit" class="btn btn-xs btn-primary m-t-5"><?php echo trans("approve"); ?></button>
                                                    <?php echo form_close(); ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <?php if ($item->product_type == 'physical'):
                                                echo time_ago($item->updated_at);
                                            endif; ?>
                                        </td>
                                        <td>
                                            <?php if (($item->product_type == 'digital' && $item->order_status != 'completed') || $item->product_type == 'physical' && $item->order_status != 'cancelled'): ?>
                                                <div class="dropdown">
                                                    <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                            type="button"
                                                            data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu options-dropdown">
                                                        <li>
                                                            <a href="#" data-toggle="modal" data-target="#updateStatusModal_<?php echo $item->id; ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('update_order_status'); ?></a>
                                                        </li>
                                                       <?php /*
														<li>
                                                            <a href="javascript:void(0)" onclick="delete_item('order_admin_controller/delete_order_product_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');"><i class="fa fa-times option-icon"></i><?php echo trans('delete'); ?></a>
                                                        </li>  
														*/ ?>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                                </tbody>
                            </table>

                            <?php if (empty($order_products)): ?>
                                <p class="text-center">
                                    <?php echo trans("no_records_found"); ?>
                                </p>
                            <?php endif; ?>
                            <div class="col-sm-12 table-ft">
                                <div class="row">
                                    <div class="pull-right">
                                        <?php echo $this->pagination->create_links(); ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
    <div class="col-sm-12">
        <div class="box-payment-total">

            <div class="row row-details">
                <div class="col-xs-12 col-sm-6 col-right">
                    <strong> <?php echo trans("subtotal"); ?></strong>
                </div>
                <div class="col-sm-6">
                    <strong class="font-right"><?php echo price_formatted($order->price_subtotal, $order->price_currency); ?></strong>
                </div>
            </div>
            <?php if (!empty($order->price_vat)): ?>
                <div class="row row-details">
                    <div class="col-xs-12 col-sm-6 col-right">
                        <strong> <?php echo trans("vat"); ?></strong>
                    </div>
                    <div class="col-sm-6">
                        <strong class="font-right"><?php echo price_formatted($order->price_vat, $order->price_currency); ?></strong>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($is_order_has_physical_product): ?>
                <div class="row row-details">
                    <div class="col-xs-12 col-sm-6 col-right">
                        <strong> <?php echo trans("shipping"); ?></strong>
                    </div>
                    <div class="col-sm-6">
                        <strong class="font-right"><?php echo price_formatted($order->price_shipping, $order->price_currency); ?></strong>
                    </div>
                </div>
            <?php endif; ?>
            <hr>
            <div class="row row-details">
                <div class="col-xs-12 col-sm-6 col-right">
                    <strong> <?php echo trans("total"); ?></strong>
                </div>
                <div class="col-sm-6">
                    <strong class="font-right"><?php echo price_formatted($order->price_total, $order->price_currency); ?></strong>
                </div>
            </div>
        </div>
    </div>
</div>

<?php foreach ($order_products as $item): ?>
    <!-- Modal -->
    <div id="updateStatusModal_<?php echo $item->id; ?>" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php echo form_open('order_admin_controller/update_order_product_status_post'); ?>
                <input type="hidden" name="id" value="<?php echo $item->id; ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo trans("update_order_status"); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="table-order-status">
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('status'); ?></label>
                            <select name="order_status" class="form-control">
                                <?php if ($item->product_type == 'physical'): ?>
                                    <option value="awaiting_payment" <?php echo ($item->order_status == 'awaiting_payment') ? 'selected' : ''; ?>><?php echo trans("awaiting_payment"); ?></option>
                                    <option value="payment_received" <?php echo ($item->order_status == 'payment_received') ? 'selected' : ''; ?>><?php echo trans("payment_received"); ?></option>
                                    <option value="order_processing" <?php echo ($item->order_status == 'order_processing') ? 'selected' : ''; ?>><?php echo trans("order_processing"); ?></option>
                                    <option value="shipped" <?php echo ($item->order_status == 'shipped') ? 'selected' : ''; ?>><?php echo trans("shipped"); ?></option>
                                <?php endif; ?>
                                <?php if ($item->buyer_id != 0 && $item->order_status != 'completed'): ?>
                                    <option value="completed" <?php echo ($item->order_status == 'completed') ? 'selected' : ''; ?>><?php echo trans("completed"); ?></option>
                                <?php endif; ?>
								<option value="confirmed" <?php echo ($item->order_status == 'confirmed') ? 'selected' : ''; ?>><?php echo trans("confirmed"); ?></option>
                                <option value="cancelled" <?php echo ($item->order_status == 'cancelled') ? 'selected' : ''; ?>><?php echo trans("cancelled"); ?></option>
                                <option value="scheduled" <?php echo ($item->order_status == 'scheduled') ? 'selected' : ''; ?>><?php echo trans("scheduled"); ?></option>
                                <option value="new" <?php echo ($item->order_status == 'new') ? 'selected' : ''; ?>><?php echo trans("new"); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><?php echo trans("save_changes"); ?></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo trans("close"); ?></button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<div id="AddProductModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php echo form_open('order_admin_controller/add_product_to_existingorder'); ?>
                <input type="hidden" name="order_id" value="<?php echo $order->id; ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo trans("add_product"); ?></h4>
                </div>
                <div class="modal-body">
				
				<div class="table-order-status">
                        <div class="form-group">
                            <label class="control-label">Products</label>
                            <select name="product_id" class="form-control" id="productId" required>
							<option value="">Select Product</option>
							<?php if($listproducts):?>
							<?php foreach($listproducts as $listproduct):?>
                                 <option value="<?php echo $listproduct->id; ?>"><?php echo $listproduct->title; ?></option>
                            <?php endforeach;?>
							<?php else:?>
									<option value=""><?php echo 'No Products'; ?></option>
							<?php endif;?>
							</select>
                        </div>
                    </div>
                    <div class="table-order-status">
                    <div class="form-group">
                        <div id="variations"></div>
                    </div>
                    </div>
                    <div style="clear:both;"></div>
					<div class="table-order-status">
                        <div class="form-group">
                            <label class="control-label"><?php echo 'Quantity' ?></label>
                            <input type="text" name="quantity" class="form-control" required >
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo trans("close"); ?></button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>


<style>
    .sec-title {
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
        font-weight: 600;
    }

    .font-right {
        font-weight: 600;
        margin-left: 5px;
    }

    .font-right a {
        color: #55606e;
    }

    .row-details {
        margin-bottom: 10px;
    }

    .col-right {
        max-width: 240px;
    }

    .label {
        font-size: 12px !important;
    }

    .box-payment-total {
        width: 400px;
        max-width: 100%;
        float: right;
        background-color: #fff;
        padding: 30px;
    }

    @media (max-width: 768px) {
        .col-right {
            width: 100%;
            max-width: none;
        }

        .col-sm-8 strong {
            margin-left: 0;
        }
    }
</style>
<script>
$("#productId").on('change',function(){
    console.log("hi");

    $.ajax({
                url:"<?=base_url('admin/product_variations')?>/"+$("#productId").val(),
                success:function(result){
                    $("#variations").html(result);
                }

            });
})
    </script>