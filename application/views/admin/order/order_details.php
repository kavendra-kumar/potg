<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title" style="width:100%;"><?php echo trans("order_details"); ?>

                <?php if(count($recent_orders) > 0) { ?>
                <div class="btn btn-sm btn-info m-l-5 recent-orders1"> Recent Orders: 
                    <?php foreach($recent_orders as $val) { ?>
                        <a class="recent-links" target="_blank" href="<?php echo base_url(); ?>admin/order-details/<?php echo $val->id; ?>">#<?php echo $val->id; ?></a>
                    <?php } ?>
                </div>
                
                <?php } ?>

                 <?php if ($order->status != 3): ?> <a href="<?php echo base_url(); ?>invoice/<?php echo $order->order_number; ?>" class="btn btn-sm btn-success" target="_blank" style="float:right;"><i class="fa fa-file-text"></i>&nbsp;&nbsp;<?php echo trans("view_invoice"); ?></a> <?php endif; ?> </h3>
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="row" style="margin-bottom: 30px;">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <?php
                            if($order->assign_to) {
                                $inf = get_user($order->assign_to);
                                $contact_person = $inf->first_name.' '.$inf->last_name;
                            } else {
                                $contact_person = '';
                            }
                        ?>
                        <h4 class="sec-title">
                            <?php echo trans("order"); ?>#<?php echo $order->order_number; ?>    
                            <button  data-toggle="modal" style="" class="btn btn-sm btn-info m-l-5" data-target="#assignContactPerson">Contact Person: <?php echo $contact_person; ?> </button>                         
                        </h4>
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
                            <?php elseif ($order->status == 9): ?>
                                <label class="label label-danger"><?php echo trans("returned"); ?></label>
                            <?php elseif ($order->status == 10): ?>
                                <label class="label label-danger"><?php echo trans("return_and_refund_request"); ?></label>
                            
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

                        <?php
                        $payurl = '';
                        if($order->payment_method == 'Point Checkout' && $order->transaction_id != null) {
                            $response = get_point_checkout_payment_status($order->transaction_id);
                            // echo "<pre>"; print_r($response);
                            if($response){
                                if($response->success == true) {
                                    $payurl = $response->result->redirectUrlShort;
                                }
                            }
                        ?>
                        <div class="row row-details">
                            <div class="col-xs-12 col-sm-4 col-right">
                                <strong> Payment URL</strong>
                            </div>
                            <div class="col-sm-8">
                                <strong class="font-right">
                                <input disabled type="text" value="<?php echo $payurl; ?>" id="myInput">
                                <button onclick="myFunction()">Copy URL</button>
                                </strong>
                            </div>
                        </div>
                        <?php
                        }
                        ?>


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
											<label for="building_no">Building No.</label>
											<input type="text" class="form-control" id="building_no" name="building_no" value="<?php echo $shipping->building_no; ?>">
										</div>
									</div>
									<div class="col-xs-12 col-sm-6">
										<div class="form-group">
											<label for="street_building_name"><?php echo trans("street_building_name"); ?> </label>
											<input type="text" class="form-control" id="street_building_name" name="street_building_name" value="<?php echo $shipping->street_building_name; ?>">
										</div>
									</div>
                                    <div class="col-xs-12 col-sm-6">
										<div class="form-group">
											<label for="street"><?php echo trans("street"); ?> </label>
											<input type="text" class="form-control" id="street" name="street" value="<?php echo $shipping->street; ?>">
										</div>
									</div>
                                    <div class="col-xs-12 col-sm-6">
										<div class="form-group">
											<label for="landmark"><?php echo trans("landmark"); ?> </label>
											<input type="text" class="form-control" id="landmark" name="landmark" value="<?php echo $shipping->landmark; ?>">
										</div>
									</div>
                                    <div class="col-xs-12 col-sm-6">
										<div class="form-group">
											<label for="area"><?php echo trans("area"); ?> </label>
											<input type="text" class="form-control" id="area" name="area" value="<?php echo $shipping->area; ?>">
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
                                    <strong> Address Type</strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->address_type; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo ($shipping->address_type == 'home') ? 'House No. / Flat No.' : 'Office No.' ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->building_no; ?></strong>
                                </div>
                            </div>

                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("street_building_name"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->street_building_name; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("street"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->street; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("landmark"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->landmark; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("area"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->area; ?></strong>
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

                            <?php if($shipping->gps_location) { ?>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("gps_location"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->gps_location; ?></strong>
                                </div>
                            </div>
                            <?php } ?>

                            <?php if($shipping->shipping_country == 'Qatar') { ?>
                                <?php if($shipping->id_picture) { ?>
                                    <div class="row row-details">
                                        <div class="col-xs-12 col-sm-4 col-right">
                                            <strong> ID Picture</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <a class="btn btn-primary" download href="../../<?php echo $shipping->id_picture; ?>">Download</a>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <?php echo form_open_multipart('order_admin_controller/update_picture_id'); ?>
                                    <div class="row row-details">
                                        <div class="col-xs-12 col-sm-4 col-right">
                                            <strong> ID Picture</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <input type="hidden" name="order_id" value="<?php echo $order->id ?>">
                                            <input type="file" name="id_picture" class="form-control form-input" value="" required>
                                            <button type="submit" class="btn btn-success"><?php echo trans("upload"); ?></button>
                                        </div>
                                    </div>
                                    <?php echo form_close(); ?>
                                <?php } ?>
                            <?php } ?>
                            


                            <?php /*if($order->awb_number) { ?>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> SMSA Tracking Number</strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right">
                                        <a target="_blank" style="color:red" href="https://smsaexpress.com/trackingdetails?tracknumbers%5B0%5D=<?php echo $order->awb_number; ?>"><?php echo $order->awb_number; ?></a>
                                    </strong>
                                </div>
                            </div>
                            <?php } */?>



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

                <br>
              
                <?php /* if($order->awb_number == null) { ?>
                    <!-- Button trigger modal -->
                    
                <?php } */?>
                <br>
                
            </div><!-- /.box-body -->
        </div>
    </div>


    <!-- shipping details -->
    <div class="col-sm-12">
   <div class="box">
      <div class="box-header with-border">
         <h3 class="box-title"><b>Shipping Details</b></h3>
        
      </div>
      <!-- /.box-header -->
      <div class="box-body">
         <div class="row">
            <!-- include message block -->
            <div class="col-sm-12">
               <!--print error messages-->
               <!--print custom error message-->
               <!--print custom success message-->
            </div>
         </div>
         <div class="row">
            <div class="col-sm-12">
               <div class="table-responsive" id="">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                    Ship Through SMSA
                    </button>

                    <button  data-toggle="modal" style="" class="btn btn-sm btn-info m-l-5" data-target="#createCustomShipmentModal"><i class="fa fa-plus"></i> Create Custom Shipment detail</button>
                    
                    <?php if($shipping->billing_country=='Oman'){ ?>
                        <button  data-toggle="modal" style="" class="btn btn-sm btn-info m-l-5" data-target="#CreateCustomAmount"><i class="fa fa-plus"></i><?php echo empty($getCustomDiscount)?"Add Csutom COD":"Edit Custom COD"; ?></button>
                    <?php } ?>

                     <div class="col-sm-12">
                        <?php $this->load->view('admin/includes/_messages'); ?>
                    </div>
                  <table class="table table-bordered table-striped" role="grid">
                     <thead>
                        <tr role="row">
                           <th>Order Number</th>
                           <th>ID</th>
                           <th>AWB</th>
                           <th>Final Status</th>
                           <th>Courier</th>
                           
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
                            $awb_number = explode(',', $order->awb_number); 
                            // echo "<pre>";  print_r($awb_number); exit;
                            if($awb_number) {
                                foreach($awb_number as $awb) {
                        ?>
                        <tr>
                           <td style="width: 80px;">
                              <?php echo ($order->order_number!="") ? $order->order_number :"--" ; ?>                                       
                           </td>
                           <td>
                            <?php 
                                 echo ($order->order_number != "") ?$order->order_number:"--" ;?>
                           </td>
                           <td>  
                                <a target="_blank" style="color:red" href="https://smsaexpress.com/trackingdetails?tracknumbers%5B0%5D=<?php echo $awb; ?>"><?php echo ($awb != "") ? $awb:"--" ;?> </a> <br>
                            </td>

                           <td>


                           <?php
            $shipping = get_order_shipping($order->id);
           // print_r($shipping); exit;

            $country = $shipping->shipping_country;
            $passkey="";
            if($country == "United Arab Emirates") {
                $passkey = 'PmG@5125';
            } elseif ($country == "Saudi Arabia") {
                $passkey = 'pMt@3423';
            } elseif ($country == "Oman") {
                $passkey == 'PmG@3717';
            } elseif ($country == "Kuwait") {
                $passkey = 'pGt@3424';
            } elseif ($country == "Bahrain") {
                $passkey = 'Pmg@3425';
            }

            $arguments = array('awbNo' =>$awb);
            $arguments['passkey'] = $passkey;

        $url    = "http://track.smsaexpress.com/SECOM/SMSAwebService.asmx?wsdl";
        $client     = new SoapClient($url, array("trace" => 1, "exception" => 0));
        // echo "<pre>"; print_r($client); exit;
        try {

             $data= $client->{'getStatus'}($arguments);
             $response = count((array)$data)? $data->getStatusResult:'--';
             if($response) {
                update_smsa_status($order->id, $response);
             }
             echo isset($response) ? $response:"--" ;
            // echo "<pre>"; print_r($data); exit;
        }
        catch(Exception $e) {
            
        }
?>
                          </td>


                           <td>
                              <?php echo ($order->order_smsa_type != "") ? "SMSA":"--" ;?>
                           </td>
                           
                        </tr>
                         <?php } } ?>

             <?php if($ShipmentCustomDetail){ foreach($ShipmentCustomDetail as $shipment) { ?>
                <tr>
                    <td style="width: 80px;">
                        <?php echo $shipment['order_id']; ?>                                   
                    </td>
                    <td>
                        <?php echo $shipment['ref']; ?>                             
                    </td>
                    <td>  
                        <a target="_blank" style="color:red" href="<?php echo $shipment['custom_link']; ?> "> <?php echo $shipment['awb']; ?>  
                    </td>

                    <td>
                        <?php
                        echo $shipment['final_status']; 
                        update_smsa_status($order->id, $shipment['final_status']);
                        ?>
                        &nbsp; 
                        <button  data-toggle="modal" style="" class="btn btn-sm btn-info m-l-5" data-target="#UpdateCustomSMSA_Status_<?php echo $shipment['id']; ?>"><i class="fa fa-edit"></i></button>
                    </td>

                    <td>
                        <?php echo $shipment['courier']; ?>                           
                    </td>
                </tr>

            <?php } } ?> 
                     </tbody>
                  </table>
                  <div class="col-sm-12 table-ft">
                     <div class="row">
                        <div class="pull-right">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- /.box-body -->
   </div>
</div>

    <!-- End Shipping Details -->



<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Confirmation Alert</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure ? you want to generate AWB Number...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a class="btn btn-primary" href="<?php echo base_url(); ?>admin/generate_awb/<?php echo $order->order_number; ?>">Continue</a>
      </div>
    </div>
  </div>
</div>


    <!-- Order Task List Start -->
    <div class="col-sm-12">
        <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo trans("order_follw_up"); ?></h3> 
                    <button  data-toggle="modal" style="" class="btn btn-sm btn-info m-l-5" data-target="#CreateTaskModal"><i class="fa fa-plus"></i> Create Task</button>
                </div><!-- /.box-header -->

                <div class="box-body">
                    <div class="row">
                        <!-- include message block -->
                        <?php
                        if($order_tasks) {
                            
                        ?>
                        <div class="col-md-12">
                            <div class="table-responsive" id="t_product">
                                <table class="table table-bordered table-striped" role="grid">
                                    <thead>
                                    <tr role="row">
                                        <th><?php echo trans('task'); ?></th>
                                        <th><?php echo trans('reminder_date'); ?></th>
                                        <th><?php echo trans('reminder_time'); ?></th>
                                        <th width="500"><?php echo trans('comment'); ?></th>
                                        <th><?php echo trans('status'); ?></th>
                                        <th><?php echo trans('created_by'); ?></th>
                                        <th><?php echo trans('assign_to'); ?></th>
                                        <th><?php echo trans('updated_by'); ?></th>
                                        <th class="max-width-120"><?php echo trans('options'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $is_order_has_physical_product = false; ?>
                                    <?php foreach($order_tasks as $order_task) : ?>
                                        
                                        <tr>
                                        <td>
                                                <?php echo html_escape($order_task->task); ?>
                                            </td>
                                            <td>
                                                <?php echo html_escape($order_task->reminder_date); ?>
                                                <?php if($order_task->status == 0 && strtotime($order_task->reminder_date) < strtotime(date('Y-m-d')) ) { ?><p><small class="btn bg-danger" style="color:#ffff">Overdue</small></p> <?php } ?>
                                            </td>
                                            <td>
                                                <?php echo html_escape($order_task->reminder_time); ?>
                                            </td>
                                            <td>
                                                <?php echo html_escape($order_task->comment); ?>
                                            </td>
                                            <td>
                                                <?php echo ($order_task->status == 0)?"Open":"Closed"; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $inf = get_user($order_task->created_by);
                                                if($inf){ echo $inf->first_name.' '.$inf->last_name; } else { echo "N/A"; }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if($order_task->assign_to){
                                                    $assign_to = explode(',', $order_task->assign_to);
                                                    $name_arr = array();
                                                    foreach($assign_to as $uid){
                                                        $inf = get_user($uid);
                                                        if($inf){
                                                            echo "<p>".$inf->first_name.' '.$inf->last_name."</p>";
                                                        } else {
                                                            echo "N/A";
                                                        }
                                                        
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if($order_task->updated_by){
                                                $inf = get_user($order_task->updated_by);
                                                if($inf){
                                                    echo $inf->first_name.' '.$inf->last_name;
                                                } else {
                                                    echo "N/A";
                                                }
                                                } else {
                                                    echo "N/A";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" alt="<?php echo $order_task->id; ?>" id="" class="btn btn-sm btn-info m-l-5 update_task" ><i class="fa fa-edit"></i></a>
                                            </td>
                                            
                                        </tr>

                                    <?php endforeach; ?>

                                    </tbody>
                                </table>

                                <?php if (empty($order_tasks)): ?>
                                    <p class="text-center">
                                        <?php echo trans("no_records_found"); ?>
                                    </p>
                                <?php endif; ?>

                            </div>
                        </div>

                        <?php
                            }
                        ?>
                    </div>
                </div>    
        </div>   
    </div>
    <!-- Order Task List End -->


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
                    <?php 

                    //echo $getDiscount['discount_type'].'-----'.$getDiscount['total_discount']; exit;
                    //echo "<pre>"; print_r($getDiscount); exit; ?>
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
           


              <?php if ($getDiscount['discount_type']): ?>
                <!-- <div class="row row-details">
                    <div class="col-xs-12 col-sm-6 col-right">
                        <strong> Discount type </strong>
                    </div>
                    <div class="col-sm-6">
                        <strong class="font-right">
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
                    $total_discount = ($order->price_subtotal / 100) * $getDiscount['total_discount']/100;
                    $msg = ' ('.$getDiscount['total_discount'].'%)';
                }
            ?>
                <div class="row row-details">
                    <div class="col-xs-12 col-sm-6 col-right">
                        <strong> Total Discount </strong>
                    </div>
                    <div class="col-sm-6">
                        <strong class="font-right">
                            <?php echo $msg; ?>
                            <?php echo price_formatted($total_discount*100, $order->price_currency); ?>
                        </strong>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($is_order_has_physical_product): ?>
                <div class="row row-details">
                    <div class="col-xs-12 col-sm-6 col-right">
                        <strong> <?php echo trans("shipping"); ?> </strong>
                    </div>
                    <div class="col-sm-6">
                        <strong class="font-right"><?php echo price_formatted($order->price_shipping, $order->price_currency); ?></strong>
                    </div>
                </div>
            <?php endif; ?>
             
                    <div class="row row-details">
                    <div class="col-xs-12 col-sm-6 col-right">
                        <strong>

                            <button  data-toggle="modal" style="" class="btn btn-sm btn-info m-l-5" data-target="#CreateDiscount"><i class="fa fa-plus"></i><?php echo isset($getDiscount)?'Edit Discount':'Add Discount'; ?></button> 
                        </strong>
                    </div>
                    <div class="col-sm-6">
                        <strong class="font-right"></strong>
                    </div>
                </div>
                
            <hr>
            <div class="row row-details">
                <div class="col-xs-12 col-sm-6 col-right">
                    <strong> <?php echo trans("total"); ?></strong>
                </div>
                <div class="col-sm-6">
                    <strong class="font-right">
                    <?php echo price_formatted($order->price_total, $order->price_currency); ?>
                    <?php // echo price_formatted_again($order->price_subtotal, $order->price_currency,$getDiscount['discount_type'],$getDiscount['total_discount'],$order->price_shipping,$order->price_vat); ?></strong>
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
                
                <!-- =============Table====== -->
                <?php $user_track = order_product_status_track($item->id, $item->order_id); ?>
                <div class="modelTable">
                <table class="table table-responsive table-striped table-bordered">
                    <thead class="bg-light text-dark">
                        <tr>
                            <th>Status</th>
                            <th>Updated By</th>
                            <th>Updated at</th>
                        </tr>
                    </thead>   
                    <tbody>
                        <?php 
                        if($user_track){
                            foreach($user_track as $obj){ 
                        ?>
                        <tr>
                            <td><?php echo trans($obj->order_status); ?></td>
                            <td>
                                <?php
                                $inf = get_user($obj->user_id);
                                if($inf){ echo $inf->first_name.' '.$inf->last_name; } else { echo "N/A"; }
                                ?>
                            </td>
                            <td><?php echo $obj->created_at; ?></td>
                        </tr>
                        <?php } } ?>
                    </tbody> 

                </table>
                 </div>
                 <!-- =============Table====== -->
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
                                
                                <option value="returned" <?php echo ($item->order_status == 'returned') ? 'selected' : ''; ?>><?php echo trans("returned"); ?></option>
                                <option value="return_and_refund_request" <?php echo ($item->order_status == 'return_and_refund_request') ? 'selected' : ''; ?>><?php echo trans("return_and_refund_request"); ?></option>

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

    

    <!--Assign Contact Person Modal -->
    <div id="assignContactPerson" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php echo form_open('order_admin_controller/assign_contact_person'); ?>
                <input type="hidden" name="id" value="<?php echo $order->id; ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Assign Contact Person</h4>
                </div>
                <div class="modal-body">
                    <div class="table-order-status">
                        
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('assign_to'); ?></label>
                            
                            <select name="assign_to" class="form-control" required>
                                <?php
                                $login_id = $this->session->userdata['modesy_sess_user_id'];
                                if($admin_users) {
                                    if($login_id == 1) {
                                    foreach($admin_users as $obj){
                                        
                                ?>
                                    <option <?php echo ($obj->id == $order->assign_to) ? 'selected' : '' ?> value="<?php echo $obj->id; ?>"><?php echo $obj->first_name.' '.$obj->last_name; ?></option>

                                <?php } } else {
                                    foreach($admin_users as $obj){
                                        if($login_id == $obj->id){ ?>
                                    <option <?php echo ($obj->id == $order->assign_to) ? 'selected' : '' ?> value="<?php echo $obj->id; ?>"><?php echo $obj->first_name.' '.$obj->last_name; ?></option>
                                <?php } } } } ?>
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


    <!--create task Modal -->
    <div id="CreateTaskModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php echo form_open('order_admin_controller/create_task_post'); ?>
                <input type="hidden" name="id" value="<?php echo $order->id; ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo trans("order_follw_up"); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="table-order-status">

                        <div class="form-group">
                            <label class="control-label"><?php echo trans('task'); ?></label>
                            <input type="text" name="task" class="form-control" value="" required />
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('comment'); ?></label>
                            <textarea name="comment" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('reminder_date'); ?></label>
                            <input type="text" name="reminder_date"id="datepicker" class="form-control datepicker" value="" required />
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('reminder_time'); ?></label>
                            <input placeholder="Select time" type="text" name="reminder_time" id="reminder_time" class="form-control timepicker">
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('assign_to'); ?></label>
                            
                            <select id="assign_to" name="assign_to[]" class="form-control mySelect for" multiple="multiple" style="width: 100%" required>
                                <?php
                                if($admin_users) {
                                    foreach($admin_users as $obj){
                                ?>
                                <option value="<?php echo $obj->id; ?>"><?php echo $obj->first_name.' '.$obj->last_name; ?></option>
                                <?php } } ?>
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

    <!--update task Modal -->
    <div id="UpdateTaskModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php echo form_open('order_admin_controller/update_task_post'); ?>
                <input type="hidden" name="task_id" id="task_id" value="">
                <input type="hidden" name="order_id" value="<?php echo $order->id; ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo trans("order_follw_up"); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="table-order-status">

                        <div class="form-group">
                            <label class="control-label"><?php echo trans('task'); ?></label>
                            <input type="text" name="task" id="task" class="form-control" value="" required />
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('comment'); ?></label>
                            <textarea name="comment" id="comment" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('reminder_date'); ?></label>
                            <input type="text" name="reminder_date" id="datepicker2" class="form-control reminder_date datepicker" value="" required />
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans('status'); ?></label>
                            <select class="form-control" name="status" id="task_status" required>
                                <option value="">Select Status</option>
                                <option value="1">Close</option>
                                <option value="0">Open</option>
                            </select>
                        </div>

                        
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('assign_to'); ?></label>
                            
                            <select id="task_assign_to" name="assign_to[]" class="form-control mySelect for" multiple="multiple" style="width: 100%" required>
                                <?php
                                if($admin_users) {
                                    foreach($admin_users as $obj){
                                ?>
                                <option value="<?php echo $obj->id; ?>"><?php echo $obj->first_name.' '.$obj->last_name; ?></option>
                                <?php } } ?>
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


     <!--create custom shipment Modal -->
     <div id="createCustomShipmentModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php echo form_open('order_admin_controller/create_custom_shipment'); ?>
                <input type="hidden" name="id" value="<?php echo $order->id; ?>">
                <input type="hidden" name="type" value="manual">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Shipment Details</h4>
                </div>
                <div class="modal-body">
                    <div class="table-order-status">

                        <div class="form-group">
                            <label class="control-label"> Reference </label>
                            <input type="text" name="ref" class="form-control" value="" required />
                        </div>
                        <div class="form-group">
                            <label class="control-label"> AWB </label>
                            <input type="text" name="task" class="form-control" value="" required />
                        </div>
                         <div class="form-group">
                            <label class="control-label"> Custom Links </label>
                          
                            <input type="text" name="custom_link" class="form-control" value="" required />
                        </div>
                        <div class="form-group">
                            <label class="control-label">Final Status</label>
                            <input type="text" name="final_status" class="form-control" value="" required />
                        </div>
                        <div class="form-group">
                            <label class="control-label">Courier</label>
                            <input type="text" name="courier" id="" class="form-control datepicker" value="" required />
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

    <!-- Create Discount -->
      <div id="CreateDiscount" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php echo form_open('admin/create-discount'); ?>
                <input type="hidden" name="order_id" value="<?php echo $order->id; ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo $getDiscount['discount_type']=="Create Discount"?"":"Edit Discount";?></h4>
                </div>
                <div class="modal-body">
                    <div class="table-order-status">

                    <input type="hidden" name="price_subtotal" value="<?php echo $order->price_subtotal; ?>" />
                    <input type="hidden" name="price_vat" value="<?php echo $order->price_vat; ?>" />
                    <input type="hidden" name="price_shipping" value="<?php echo $order->price_shipping; ?>" />

                     <input type="hidden" name="type" value= "<?php echo ($getDiscount['total_discount'])?'edit':'add'; ?>" id="discount" class="form-control">
                        <div class="form-group">
                            <label class="control-label">Discount Type</label>
                             <select class="form-control" name="discount_type" id="" required>
                                <option value="">Select Status</option>
                                <option <?php echo ($getDiscount['discount_type']=="fix-amount")?"selected":""; ?>  value="fix-amount">Fix amount</option>
                                <option <?php echo ($getDiscount['discount_type']=="percentage")?"selected":""; ?> value="percentage">Percentage</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label class="control-label">Fill Discount</label>
                            <input type="text" name="discount" value= "<?php echo isset($getDiscount)?$getDiscount['total_discount']:''; ?>" id="discount" class="form-control">
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
    <!-- End -->
    

    

    <div id="CreateCustomAmount" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php echo form_open('admin/custom-amount'); ?>
                <input type="hidden" name="order_id" value="<?php echo $order->id; ?>">
                <input type="hidden" name="type" value="<?php echo empty($getCustomDiscount)?"add":"update"; ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="table-order-status">

                        <div class="form-group">
                            <label class="control-label"><?php echo empty($getCustomDiscount)?"Add Csutom COD":"Edit Custom COD"; ?></label>
                            <input type="text" name="custom_amount" class="form-control" value="<?php echo empty($getCustomDiscount)?"":$getCustomDiscount['customAmount']; ?>" required />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success addCustomAmount"><?php echo trans("save_changes"); ?></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo trans("close"); ?></button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>


     <div id="UpdateTaskModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php echo form_open('order_admin_controller/update_task_post'); ?>
                <input type="hidden" name="task_id" id="task_id" value="">
                <input type="hidden" name="order_id" value="<?php echo $order->id; ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo trans("order_follw_up"); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="table-order-status">

                        <div class="form-group">
                            <label class="control-label"><?php echo trans('task'); ?></label>
                            <input type="text" name="task" id="task" class="form-control" value="" required />
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('comment'); ?></label>
                            <textarea name="comment" id="comment" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('reminder_date'); ?></label>
                            <input type="text" name="reminder_date" id="datepicker2" class="form-control reminder_date datepicker" value="" required />
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans('status'); ?></label>
                            <select class="form-control" name="status" id="task_status" required>
                                <option value="">Select Status</option>
                                <option value="1">Close</option>
                                <option value="0">Open</option>
                            </select>
                        </div>

                        
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('assign_to'); ?></label>
                            
                            <select id="task_assign_to" name="assign_to[]" class="form-control mySelect for" multiple="multiple" style="width: 100%" required>
                                <?php
                                if($admin_users) {
                                    foreach($admin_users as $obj){
                                ?>
                                <option value="<?php echo $obj->id; ?>"><?php echo $obj->first_name.' '.$obj->last_name; ?></option>
                                <?php } } ?>
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

    <?php if($ShipmentCustomDetail){ foreach($ShipmentCustomDetail as $shipment) { ?>
        <!-- Update custom smsa status modal. -->
        <div id="UpdateCustomSMSA_Status_<?php echo $shipment['id']; ?>" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <?php echo form_open('order_admin_controller/UpdateCustomSMSA_Status'); ?>
                    <input type="hidden" name="id" value="<?php echo $shipment['id']; ?>">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="table-order-status">

                            <div class="form-group">
                                <label class="control-label">Shipment Status</label>
                                <input type="text" name="final_status" class="form-control" value="<?php echo $shipment['final_status']; ?>" required />
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
    <?php } } ?>

    <?php if($recent_orders) { ?>
    <!--Recent Orders Modal -->
    <!-- <div id="RecentOrdersModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <input type="hidden" name="id" value="<?php echo $order->id; ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Recent Orders</h4>
                </div>
                <div class="modal-body" style="min-height:200px;">
                    <div class="table-order-status">

                        <div class="col-md-12">
                            <?php foreach($recent_orders as $val) { ?>
                            <div class="col-md-3">
                                <a target="_blank" href="<?php echo base_url(); ?>admin/order-details/<?php echo $val->id; ?>">#<?php echo $val->id; ?></a>
                            </div>
                            <?php } ?>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo trans("close"); ?></button>
                </div>
            </div>
        </div>
    </div> -->
    <?php } ?>

    
<style>
    .select2-container.select2-container--default,
    .ui-timepicker-standard {
        z-index:999999999999 !important;
    }
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

    .recent-links{
        color: #fff;
        text-decoration: underline;
        padding: 0px 10px;
        font-size: 18px;
        white-space: pre-wrap;
    }
    .recent-orders1, .recent-orders1:hover{
        background-color: #ff9800a6 !important;
        border-color: #ff9800 !important;
        cursor: initial;
        
    }
    .recent-orders1{
        padding: 5px 15px;
        font-size:24px;
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
});
</script>
<script>
    




$(document).ready(function(){
    $( ".update_task" ).on( "click", function() {
        var task_id = $(this).attr('alt');
        
        $.ajax({
            url:"<?=base_url('order_admin_controller/get_task_by_id')?>/"+task_id,
            success:function(obj){
                var result = JSON.parse(obj);
                console.log(result);

                $('#task_id').val(result.id);
                $('#comment').val(result.comment);
                if(result.status == 0 || result.status == '0'){
                    $('#task_status option').eq(2).prop('selected', true);
                } else {
                    $('#task_status option').eq(1).prop('selected', true);
                }

                var ids = result.assign_to;
                if(ids){
                    var numbersArray = ids.split(',');
                    $('#task_assign_to').select2().val(numbersArray).trigger('change');
                }

                var date= result.reminder_date;
                var d=new Date(date);
                var dd=d.getDate();
                var mm=d.getMonth()+1;
                var yy=d.getFullYear();
                var newdate=mm+"/"+dd+"/"+yy;
                $('.reminder_date').val(newdate);

                $('#task').val(result.task);

                $('#UpdateTaskModal').modal('show'); 
            }
        });
    });
});
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css">

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
<script>
    $('form').attr('autocomplete', 'off');

    $( function() {
        $( "#datepicker" ).datepicker();
    });
    $( function() {
        $( "#datepicker2" ).datepicker();
    });

    $(document).ready(function(){
        $('input.timepicker').timepicker({});
    });

    
    $('#assign_to').select2();
    $('#assign_to').on('select2:opening select2:closing', function( event ) {
        var $searchfield = $(this).parent().find('.select2-search__field');
        $searchfield.prop('disabled', true);
    });

    $('#task_assign_to').select2();
    $('#task_assign_to').on('select2:opening select2:closing', function( event ) {
        var $searchfield = $(this).parent().find('.select2-search__field');
        $searchfield.prop('disabled', true);
    });
  </script>

<script>
function myFunction() {
  var copyText = document.getElementById("myInput");
  copyText.select();
  copyText.setSelectionRange(0, 99999)
  document.execCommand("copy");
  alert("Copied the URL: " + copyText.value);
}
</script>
