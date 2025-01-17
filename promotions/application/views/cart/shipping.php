<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="shopping-cart shopping-cart-shipping">
                    <div class="row">
                        <div class="col-sm-12 col-lg-7">
                            <div class="left">
                                <h1 class="cart-section-title"><?php echo trans("checkout"); ?></h1>

                                <?php if (!$this->auth_check): ?>
                                    <div class="row m-b-15">
                                        <div class="col-12 col-md-6">
                                            <p><?php echo trans("checking_out_as_guest"); ?></p>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <p class="text-right1 "><?php echo trans("have_account"); ?>&nbsp;<a href="javascript:void(0)" class="link-underlined" data-toggle="modal" data-target="#loginModal"><?php echo trans("login"); ?></a></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
								<?php /* start comment 
                                <div class="tab-checkout tab-checkout-open m-t-0">
                                    <h2 class="title">1.&nbsp;&nbsp;<?php echo trans("shipping_information"); ?></h2>
                                    <?php echo form_open("shipping-post", ['id' => 'form_validate']); ?>
                                    <div class="row">
                                        <div class="col-12 cart-form-shipping-address">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 m-b-sm-15">
                                                        <label><?php echo trans("first_name"); ?>*</label>
                                                        <input type="text" name="shipping_first_name" class="form-control form-input" value="<?php echo $shipping_address->shipping_first_name; ?>" required>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label><?php echo trans("last_name"); ?>*</label>
                                                        <input type="text" name="shipping_last_name" class="form-control form-input" value="<?php echo $shipping_address->shipping_last_name; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo trans("address"); ?> 1*</label>
                                                <input type="text" name="shipping_address_1" class="form-control form-input" value="<?php echo $shipping_address->shipping_address_1; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo trans("address"); ?> 2 (<?php echo trans("optional"); ?>)</label>
                                                <input type="text" name="shipping_address_2" class="form-control form-input" value="<?php echo $shipping_address->shipping_address_2; ?>">
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 m-b-sm-15">
                                                        <label><?php echo trans("country"); ?>*</label>
                                                        <div class="selectdiv">
                                                            <select id="countries" name="shipping_country_id" class="form-control" required>
                                                                <option value="" selected><?php echo trans("select_country"); ?></option>
                                                                <?php foreach ($this->countries as $item): ?>
                                                                    <option data-code="<?php echo $item->code; ?>" data-length="<?php echo $item->phone_length; ?>" value="<?php echo $item->id; ?>" <?php echo ($shipping_address->shipping_country_id == $item->id) ? 'selected' : ''; ?>><?php echo html_escape($item->name); ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label><?php echo trans("state"); ?>*</label>
                                                        <input type="text" name="shipping_state" class="form-control form-input" value="<?php echo $shipping_address->shipping_state; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 m-b-sm-15">
                                                        <label><?php echo trans("city"); ?>*</label>
                                                        <input type="text" name="shipping_city" class="form-control form-input" value="<?php echo $shipping_address->shipping_city; ?>" required>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label><?php echo trans("zip_code"); ?>*</label>
                                                        <input type="text" name="shipping_zip_code" class="form-control form-input" value="<?php echo $shipping_address->shipping_zip_code; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-6 m-b-sm-15">
                                                        <div class="form-group">
                                                            <label><?php echo trans("email"); ?>*</label>
                                                            <input type="email" name="shipping_email" class="form-control form-input" value="<?php echo $shipping_address->shipping_email; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">

                                                        <label><?php echo trans("phone_number"); ?>*</label>
                                                        <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="shipping-phone-number-code"></span>
                                                        </div>

                                                        <input class="d-none" name="shipping_phone_code" hidden>
                                                        <input type="text" name="shipping_phone_number" class="form-control form-input numbers-only" value="<?php echo $shipping_address->shipping_phone_number; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 cart-form-billing-address" <?php echo ($shipping_address->use_same_address_for_billing == 0) ? 'style="display: block;"' : ''; ?>>
                                            <h3 class="title-billing-address"><?php echo trans("billing_address") ?></h3>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 m-b-sm-15">
                                                        <label><?php echo trans("first_name"); ?>*</label>
                                                        <input type="text" name="billing_first_name" class="form-control form-input" value="<?php echo $shipping_address->billing_first_name; ?>" required>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label><?php echo trans("last_name"); ?>*</label>
                                                        <input type="text" name="billing_last_name" class="form-control form-input" value="<?php echo $shipping_address->billing_last_name; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo trans("address"); ?> 1*</label>
                                                <input type="text" name="billing_address_1" class="form-control form-input" value="<?php echo $shipping_address->billing_address_1; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo trans("address"); ?> 2 (<?php echo trans("optional"); ?>)</label>
                                                <input type="text" name="billing_address_2" class="form-control form-input" value="<?php echo $shipping_address->billing_address_2; ?>">
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 m-b-sm-15">
                                                        <label><?php echo trans("country"); ?>*</label>
                                                        <div class="selectdiv">
                                                            <select id="countries" name="billing_country_id" class="form-control" required>
                                                                <option value="" selected><?php echo trans("select_country"); ?></option>
                                                                <?php foreach ($this->countries as $item): ?>
                                                                    <option data-code="<?php echo $item->code; ?>" data-length="<?php echo $item->phone_length; ?>" value="<?php echo $item->id; ?>" <?php echo ($shipping_address->billing_country_id == $item->id) ? 'selected' : ''; ?>><?php echo html_escape($item->name); ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label><?php echo trans("state"); ?>*</label>
                                                        <input type="text" name="billing_state" class="form-control form-input" value="<?php echo $shipping_address->billing_state; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 m-b-sm-15">
                                                        <label><?php echo trans("city"); ?>*</label>
                                                        <input type="text" name="billing_city" class="form-control form-input" value="<?php echo $shipping_address->billing_city; ?>" required>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label><?php echo trans("zip_code"); ?>*</label>
                                                        <input type="text" name="billing_zip_code" class="form-control form-input" value="<?php echo $shipping_address->billing_zip_code; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-6 m-b-sm-15">

                                                        <div class="form-group">
                                                            <label><?php echo trans("email"); ?>*</label>
                                                            <input type="email" name="billing_email" class="form-control form-input" value="<?php echo $shipping_address->billing_email; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label><?php echo trans("phone_number"); ?>*</label>
                                                        <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="billing-phone-number-code"></span>
                                                        </div>
                                                        <input class="d-none" name="billing_phone_code" hidden>
                                                        <input type="text" name="billing_phone_number" class="form-control form-input numbers-only" value="<?php echo $shipping_address->billing_phone_number; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="use_same_address_for_billing" value="1" id="use_same_address_for_billing" <?php echo ($shipping_address->use_same_address_for_billing == 1) ? 'checked' : ''; ?>>
                                                    <label for="use_same_address_for_billing" class="custom-control-label"><?php echo trans("use_same_address_for_billing"); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group m-t-15">
                                        <a href="<?php echo generate_url("cart"); ?>" class="link-underlined link-return-cart"><&nbsp;<?php echo trans("return_to_cart"); ?></a>
                                        <button type="submit" name="submit" value="update" class="btn btn-lg btn-custom float-right"><?php echo trans("continue_to_payment_method") ?></button>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>

                                <div class="tab-checkout tab-checkout-closed-bordered">
                                    <h2 class="title">2.&nbsp;&nbsp;<?php echo trans("payment_method"); ?></h2>
                                </div>

                                <div class="tab-checkout tab-checkout-closed-bordered border-top-0">
                                    <h2 class="title">3.&nbsp;&nbsp;<?php echo trans("payment"); ?></h2>
                                </div>
						 end of comment */?>
								<div class="tab-checkout tab-checkout-open m-t-0 p-0 Mobile_bottom">
                                    <h2 class="title"><?php echo trans("shipping_information"); ?></h2>
                                    <?php echo form_open_multipart("cod-direct-post", ['id' => 'form_validate']); ?>
                                    <div class="row">
                                        <div class="col-12 cart-form-shipping-address">
                                            <div class="form-group">

                                                <div class="row">
                                                    <div class="col-12 col-md-12 m-b-sm-15">
                                                        <label><?php echo trans("full_name"); ?>*</label>
                                                    <input type="text" name="shipping_first_name" class="form-control form-input" value="<?php echo $shipping_address->shipping_first_name; ?>" placeholder="<?php echo trans("placeholder_name"); ?>" required>
                                                    </div>

                                                    <div class="col-12 col-md-6 d-none">
                                                        <label><?php echo trans("last_name"); ?>*</label>
                                                        <input type="text" name="shipping_last_name" class="form-control form-input" value="<?php echo $shipping_address->shipping_last_name; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 m-b-sm-15">
                                                        <div class="form-group">
                                                            <label><?php echo trans("email"); ?>*</label>
                                                            <input type="email" name="shipping_email" class="form-control form-input" value="<?php echo $shipping_address->shipping_email; ?>" placeholder="<?php echo trans("placeholder_email"); ?>" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-6 m-b-sm-15">
                                                        <label><?php echo trans("country"); ?>*</label>
                                                        <div class="selectdiv">
                                                            <select id="countries" name="shipping_country_id" class="form-control" required>
                                                                <option value="" selected><?php echo trans("select_country"); ?></option>
                                                                <?php foreach ($this->countries as $item): ?>
                                                                    <option data-code="<?php echo $item->code; ?>" data-length="<?php echo $item->phone_length; ?>" value="<?php echo $item->id; ?>" <?php echo ($shipping_address->shipping_country_id == $item->id) ? 'selected' : ($country->id == $item->id)?'selected':''; ?>><?php echo html_escape($item->name); ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    <div class="col-12 col-md-6 d-none">
                                                        <label><?php echo trans("state"); ?>*</label>
                                                        <input type="text" name="shipping_state" class="form-control form-input" value="<?php echo $shipping_address->shipping_state; ?>">
                                                    </div>
                                                    
                                                    <div class="col-12 col-md-6 d-none">
                                                        <label><?php echo trans("zip_code"); ?>*</label>
                                                        <input type="text" name="shipping_zip_code" class="form-control form-input" value="<?php echo $shipping_address->shipping_zip_code; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        <div class="form-group">
                                            <div class="row">
												<div class="col-12 col-md-6">
                                                    <label><?php echo trans("phone_number"); ?>*</label>
                                                    <div class="input-group input-group-sm mb-3">
														<div class="input-group-prepend">
															<span class="input-group-text shipping-phone-number-code"><?= ($country)?$country->code:''; ?></span>
														</div>
														<input class="d-none" name="shipping_phone_code" value="<?= ($country)?$country->code:''; ?>" type="hidden" />
														<input type="text" name="shipping_phone_number" class="form-control form-input numbers-only" value="<?php echo $shipping_address->shipping_phone_number; ?>" placeholder="58 234 4567" required>
													</div>
												</div>
												<div class="col-12 col-md-6">
                                                    <label><?php echo trans("confirm_phone_number"); ?>*</label>
                                                    <div class="input-group input-group-sm mb-3">
														<div class="input-group-prepend">
															<span class="input-group-text shipping-phone-number-code"></span>
														</div>
														<input type="text" name="shipping_phone_number_confirm" class="form-control form-input numbers-only" value=""  placeholder="58 234 4567" required>
														
														<input type="text" name="confirm_validation" class="border-0 h-0 w-0 p-0" >

                                                        <label id="confirm_validation-error" class="error" for="confirm_validation" style="display: none;"></label>
													</div>
												</div>

                                                
											</div>
                                            </div>
<!-- --------------------Adreess box----------------- -->
<div class="form-group address_text_box">
    <div class="row">
        <div class="col-md-6 col-6">
            <h6><?php echo trans("address_type"); ?></h6>
        </div>
        <div class="col-md-6 col-6">
            <div class="form-group d-flex">
                <div class="custom-control custom-checkbox">
                    <input checked type="radio" name="address_type" value="home" id="home"> <?php echo trans("home"); ?>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="radio" name="address_type" value="office" id="office"> <?php echo trans("office"); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="addressBox  py-2" style="border:1px solid gray; margin-top:-14px;">
        <div class="container ">                                                
            <!-- -------Row 1=== -->
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label id="building_label"> House No. / Flat No.*</label>
                        <input type="text" name="building_no" class="form-control form-input" value="<?php echo $shipping_address->building_no; ?>" placeholder="<?php echo trans("placeholder_officeno"); ?>" >
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label> <?php echo trans("street_building_name"); ?></label>
                        <input type="text" name="street_building_name" class="form-control form-input" value="<?php echo $shipping_address->street_building_name; ?>" placeholder="<?php echo trans("placeholder_building_name"); ?>" >
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label> <?php echo trans("street"); ?></label>
                        <input type="text" name="street" class="form-control form-input" value="<?php echo $shipping_address->street; ?>" placeholder="<?php echo trans("placeholder_street"); ?>" >
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label> <?php echo trans("landmark"); ?></label>
                        <input type="text" name="landmark" class="form-control form-input" value="<?php echo $shipping_address->landmark; ?>" placeholder="<?php echo trans("placeholder_landmark"); ?>" >
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label> <?php echo trans("area"); ?>*</label>
                        <input type="text" name="area" class="form-control form-input" value="<?php echo $shipping_address->area; ?>" placeholder="<?php echo trans("placeholder_area"); ?>" required>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label><?php echo trans("city"); ?>*</label>
                        <input type="text" name="shipping_city" class="form-control form-input" value="<?php echo $shipping_address->shipping_city; ?>" placeholder="<?php echo trans("placeholder_city"); ?>" required>
                    </div>
                </div>
            </div> <!--------- row ----- -->  
        </div> <!--------- container ----- -->     
    </div>
</div>
<!-- ==========================Address box.========= -->

                                            <div class="form-group d-none">
                                                <label><?php echo trans("address"); ?> 1*</label>
                                                <input type="text" name="shipping_address_1" class="form-control form-input" value="<?php echo $shipping_address->shipping_address_1; ?>" >
                                            </div>
                                            <div class="form-group d-none">
                                                <label><?php echo trans("address"); ?> 2 (<?php echo trans("optional"); ?>)</label>
                                                <input type="text" name="shipping_address_2" class="form-control form-input" value="<?php echo $shipping_address->shipping_address_2; ?>">
                                            </div>

                                        </div>

                                        <div class="col-12 col-md-12 py-2" id="id_picture" style="<?php echo ($shipping_address->shipping_country_id == 178) ? 'display:block' : ($country->id == 178)?'display:block':'display:none'; ?>">
                                            <label class="font-weight-bold"><?php echo trans("id_picture"); ?></label>
                                                <input type="file" name="id_picture" class="form-control form-input" value="" required>
                                        </div>

                                        
                                        <div class="col-12 cart-form-billing-address d-none" <?php echo ($shipping_address->use_same_address_for_billing == 0) ? 'style="display: block;"' : ''; ?>>
                                            <h3 class="title-billing-address"><?php echo trans("billing_address") ?></h3>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 m-b-sm-15">
                                                        <label><?php echo trans("first_name"); ?>*</label>
                                                        <input type="text" name="billing_first_name" class="form-control form-input" value="<?php echo $shipping_address->billing_first_name; ?>" required>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label><?php echo trans("last_name"); ?>*</label>
                                                        <input type="text" name="billing_last_name" class="form-control form-input" value="<?php echo $shipping_address->billing_last_name; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo trans("address"); ?> 1*</label>
                                                <input type="text" name="billing_address_1" class="form-control form-input" value="<?php echo $shipping_address->billing_address_1; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo trans("address"); ?> 2 (<?php echo trans("optional"); ?>)</label>
                                                <input type="text" name="billing_address_2" class="form-control form-input" value="<?php echo $shipping_address->billing_address_2; ?>">
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 m-b-sm-15">
                                                        <label><?php echo trans("country"); ?>*</label>
                                                        <div class="selectdiv">
                                                            <select id="countries" name="billing_country_id" class="form-control" required>
                                                                <option value="" selected><?php echo trans("select_country"); ?></option>
                                                                <?php foreach ($this->countries as $item): ?>
                                                                    <option data-code="<?php echo $item->code; ?>" data-length="<?php echo $item->phone_length; ?>" value="<?php echo $item->id; ?>" <?php echo ($shipping_address->billing_country_id == $item->id) ? 'selected' : ''; ?>><?php echo html_escape($item->name); ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label><?php echo trans("state"); ?>*</label>
                                                        <input type="text" name="billing_state" class="form-control form-input" value="<?php echo $shipping_address->billing_state; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 m-b-sm-15">
                                                        <label><?php echo trans("city"); ?>*</label>
                                                        <input type="text" name="billing_city" class="form-control form-input" value="<?php echo $shipping_address->billing_city; ?>" required>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label><?php echo trans("zip_code"); ?>*</label>
                                                        <input type="text" name="billing_zip_code" class="form-control form-input" value="<?php echo $shipping_address->billing_zip_code; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-6 m-b-sm-15">

                                                        <div class="form-group">
                                                            <label><?php echo trans("email"); ?>*</label>
                                                            <input type="email" name="billing_email" class="form-control form-input" value="<?php echo $shipping_address->billing_email; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label><?php echo trans("phone_number"); ?>*</label>
                                                        <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="billing-phone-number-code"></span>
                                                        </div>
                                                        <input class="d-none" name="billing_phone_code" hidden>
                                                        <input type="text" name="billing_phone_number" class="form-control form-input numbers-only" value="<?php echo $shipping_address->billing_phone_number; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="row  h-300" style="height:500px;" >
                                                    <div class="col-12 col-md-12 m-b-sm-15">
                                                        <label><?php echo trans("gps_location"); ?></label>
                                                        <input type="hidden" name="gps_location" id="gps_location" />
                                                        <div id="map_canvas" style="height:90%;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                        -->


                                        <div class="col-12 d-none">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="use_same_address_for_billing" value="1" id="use_same_address_for_billing" <?php echo ($shipping_address->use_same_address_for_billing == 1) ? 'checked' : ''; ?>>
                                                    <label for="use_same_address_for_billing" class="custom-control-label"><?php echo trans("use_same_address_for_billing"); ?></label>
                                                </div>
                                            </div>
                                        </div>

										<div class="col-12">
											<h2 class="title mb-3">
												<?php echo trans("payment_method"); ?>
											</h2>
                                            
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
                                            
											<div class="form-group">
												<ul class="payment-options-list">
													<?php if ($this->payment_settings->cash_on_delivery_enabled && empty($cart_has_digital_product) && ($mds_payment_type != 'promote') && ($country->id != 80)): ?>
														<li id="cod">
															<div class="option-payment">
																<div class="custom-control custom-radio">
																	<input type="radio" class="custom-control-input payment_method" id="option_cash_on_delivery" name="payment_option" value="cash_on_delivery" required>
																	<label class="custom-control-label label-payment-option" for="option_cash_on_delivery"><?php echo trans("cash_on_delivery"); ?><br><small><?php echo trans("cash_on_delivery_exp"); ?></small></label>
																</div>
															</div>
														</li>
													<?php endif; ?>
                                                    <?php if ( $this->payment_settings->point_checkout_enabled && empty($cart_has_digital_product)): ?>
                                                        <li id="pcheckout">
															<div class="option-payment">
                                                                <div class="row">
                                                                    <div class="col-md-5">
                                                                    <div class="custom-control custom-radio">
																	<input type="radio" class="custom-control-input payment_method" id="option_point_checkout" name="payment_option" value="point_checkout" required>
																	<label class="custom-control-label label-payment-option" for="option_point_checkout"><?php echo trans("point_checkout"); ?><br><small><?php echo trans("point_checkout"); ?></small></label>
																</div>
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                    <div class="card_box">
                                                            <img src="<?php echo base_url('assets/img/card/master-card.png'); ?>" alt="" srcset="" class="img-fluid">
                                                            <img src="<?php echo base_url('assets/img/card/visa.png'); ?>" alt="" srcset="" class="img-fluid">
                                                            <img src="<?php echo base_url('assets/img/card/discover.png'); ?>" alt="" srcset="" class="img-fluid">
                                                            <img src="<?php echo base_url('assets/img/card/american-ex.png'); ?>" alt="" srcset="" class="img-fluid">
                                                            </div>
                                                                    </div>

                                                                </div>
															
                                                           
															</div>
                                                           

														</li>
                                                    <?php endif; ?>
												</ul>
											</div>

											<div class="cod_msg" style="display:none;">
												<p class="m-b-30">
													<?php echo trans("cash_on_delivery_warning"); ?>
												</p>
											</div>


											<div class="form-group">
												<div class="custom-control custom-checkbox custom-control-validate-input">
													<input type="checkbox" class="custom-control-input" name="terms" id="checkbox_terms" required>
													<?php $page_terms_condition = get_page_by_default_name("terms_conditions", $this->selected_lang->id); ?>
													<label for="checkbox_terms" class="custom-control-label"><?php echo trans("terms_conditions_exp"); ?>&nbsp;<a href="<?php echo lang_base_url() . $page_terms_condition->slug; ?>" class="link-terms" target="_blank"><strong><?php echo html_escape($page_terms_condition->title); ?></strong></a></label>
												</div>
											</div>
										</div>
										
                                    </div>
                                    <div class="form-group m-t-15">
                                        <a href="<?php echo generate_url("cart"); ?>" class="link-underlined link-return-cart"><&nbsp;<?php echo trans("return_to_cart"); ?></a>
                                        <button type="submit" name="submit" id="place_order" value="update" class="btn btn-lg btn-custom float-right"><?php echo trans("place_order") ?></button>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>

								
						<?php if ($mds_payment_type == 'promote') {
							$this->load->view("cart/_order_summary_promote");
						} else {
							$this->load->view("cart/_order_summary");
						} ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->


<!-- Harry Code Start -->
<?php if (!empty($cart_items)):
        $cart_product_ids = array();
        foreach($cart_items as $cart):
            $cart_product_ids[] = $cart->product_id;
        endforeach;
        $prod = get_available_product($cart_items[0]->product_id);
        $upselling_title = ($prod->upselling_title) ? $prod->upselling_title : null;
        $upselling_products = ($prod->upselling_products) ? explode(",", $prod->upselling_products) : null;
        // $addon_products = ($prod->addon_products) ? explode(",", $prod->addon_products) : null;
        if($upselling_products): ?>
       
<!-- Modal -->
<div class="modal fade" id="addonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" <?php if($this->selected_lang->short_form == 'ar') { ?> dir="rtl" lang="ar" <?php } ?>>
        <h5 class="modal-title" id="exampleModalLongTitle"><?= $upselling_title ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#f86923!important; padding:0px 1rem!important;">
          <span aria-hidden="true" style="font-size:70px; color:#f86923!important; margin-top:-10px; font-weight:bolder; ">&times;</span>
        </button>
      </div>

        <div class="modal-body">

            <?php
                foreach($upselling_products as $pid):
                    if( !in_array($pid, $cart_product_ids) ):
                    $product = get_available_product($pid);
            ?>
            <div class="item row bg-light p-3 p-3 m-1 mb-3">
                

                <div class="col-md-2 p-0">
                    <div class="cart-item-image" bis_skin_checked="1">
                        <div class="img-cart-product" bis_skin_checked="1">
                            <a href="<?php echo generate_product_url($product); ?>">
                                <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_product_image($product->id, 'image_small'); ?>" alt="<?php echo html_escape($product->title); ?>" class="lazyload img-fluid img-product" onerror="this.src='<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>'">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 pt-4">
                    <div class="cart-item-details" bis_skin_checked="1">
                        <div class="list-item" bis_skin_checked="1">
                            <a href="<?php echo generate_product_url($product); ?>">
                                <?php echo html_escape($product->title); ?>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 pr-0 pt-4">
                <?php $buttton = get_product_form_data($product)->button;
                        if (!empty($buttton)):?>
                            <?php echo form_open(get_product_form_data($product)->add_to_cart_url, ['id' => 'form_add_cart']); ?>
                            <input type="hidden" class="form-control text-center" name="product_quantity" value="1">
                            <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                            <div class="button-container addons-btn">
                                <?php echo $buttton; ?>
                            </div>
                            <?php echo form_close(); ?>
                        <?php endif; ?>
                </div>
                
                
            </div>
            <?php
                    endif;
                endforeach;
            ?>
        <button class="close_btn" data-dismiss="modal" aria-label="Close" style="border:none; background:#f86923; padding:10px 10px; color:white; float:right" dir='rtl'><?php echo trans("close"); ?></button>
        </div>

    </div>

    
  </div>
</div>

<?php
    foreach($upselling_products as $pid):
        if( !in_array($pid, $cart_product_ids) ):
?>
<script type="text/javascript">
    $(window).on('load', function() {
        $('#addonModal').modal('show');
    });
</script>
<?php break;
        endif;
    endforeach;
?>

<!-- Harry Code End -->
<?php endif; endif; ?>



<script>
$( 'select[name="shipping_country_id"]' ).change(function () {
   var a = $(this).children("option:selected"),val = $('input[name="shipping_phone_number"]').val();
   console.log(a);
   var mob = val.substr(val.length - a.attr("data-length"));
   $(".shipping-phone-number-code").html(a.attr('data-code'));
   $('input[name="shipping_phone_code"]').val(a.attr('data-code'));
   $('input[name="shipping_phone_number"]').val(mob);
   $('input[name="shipping_phone_number"],input[name="shipping_phone_number_confirm"]').attr({"minlength": a.attr("data-length"),"maxlength":parseInt(a.attr("data-length")) + 1});
  }).change();

  $('#countries').on('change', function() {
    var country_id = this.value;
    if(country_id == 178) {
        $('#id_picture').show();
        // alert('show');
    } else {
        $('#id_picture').hide();
        // alert('hide');
    }

    if(country_id == 80) {
        $('#cod').hide();
    } else {
        $('#cod').show();
    }
  });

$( 'select[name="billing_country_id"]' ).change(function () {
   var a = $(this).children("option:selected"),val = $('input[name="billing_phone_number"]').val();
   console.log(val);
   var mob = val.substr(val.length - a.attr("data-length"));
   $("#billing-phone-number-code").html(a.attr('data-code'));
   $('input[name="billing_phone_code"]').val(a.attr('data-code'));
   $('input[name="billing_phone_number"]').val(mob);
   $('input[name="billing_phone_number"]').attr({"minlength": a.attr("data-length"),"maxlength":a.attr("data-length")});
  }).change();
  $('.numbers-only').keyup(function () { 
    this.value = this.value.replace(/[^0-9]/g,'');
});


/* *********Kave function********* */
$( 'input[name="shipping_phone_number"]' ).keyup(function() {
	var a = $( 'input[name="shipping_phone_number"]' ).val();
    var digit = a.toString()[0];
	if(digit == '0') {
        a = a.slice(1);
        $( 'input[name="shipping_phone_number"]' ).val(a);
    }
});

$( 'input[name="shipping_phone_number_confirm"]' ).keyup(function() {
	var k = $( 'input[name="shipping_phone_number_confirm"]' ).val();
    var digit = k.toString()[0];
	if(digit == '0') {
        k = k.slice(1);
        $( 'input[name="shipping_phone_number_confirm"]' ).val(k);
    }

    var a = $( 'input[name="shipping_phone_number"]' ).val(), b = $( 'input[name="shipping_phone_number_confirm"]' ).val();
    console.log('ab', a,b);
    if(a == b){
		$( 'input[name="confirm_validation"]').val("1");
        $('#confirm_validation-error').hide();
	}
	else{
        $('#confirm_validation-error').show();
	$( 'input[name="confirm_validation"]').val("");
	$('#confirm_validation-error').html('<?php echo trans("phone_mismatch"); ?>'); 
	}

});


$( 'input[name="shipping_phone_number_confirm"]' ).keyup(function() {
	var a = $( 'input[name="shipping_phone_number"]' ).val(), b = $( 'input[name="shipping_phone_number_confirm"]' ).val();
   // console.log(a);
	//console.log(b);
	//debugger;
	if(a == b){
		//console.log("true");
		$( 'input[name="confirm_validation"]').val("1");
        $('#confirm_validation-error').hide();
	}
	else{
		//console.log("false");
	$( 'input[name="confirm_validation"]').val("");
	$('#confirm_validation-error').html('<?php echo trans("phone_mismatch"); ?>'); 
	}
});

$( '#place_order' ).click(function() {
	var a = $( 'input[name="shipping_phone_number"]' ).val(), b = $( 'input[name="shipping_phone_number_confirm"]' ).val();
   // console.log(a);
	//console.log(b);
	//debugger;
	if(a == b){
		//console.log("true");
		$( 'input[name="confirm_validation"]').val("1");
        $('#confirm_validation-error').hide();
	}
	else{
		//console.log("false");
    $('#confirm_validation-error').show();
	$( 'input[name="confirm_validation"]').val("");
	$('#confirm_validation-error').html('<?php echo trans("phone_mismatch"); ?>'); 
    return false;
	}
});
// setInterval(function(){ if ( $( "#confirm_validation-error" ).length ) {
//     $('#confirm_validation-error').html('<?php echo trans("phone_mismatch"); ?>');
// } }, 100);

$('.payment_method').on('click', function() {
   if( $('input[name=payment_option]:checked').val() == 'cash_on_delivery') {
       $('.cod_msg').show();
       $('.cod_discount').show();
       $('.pointcheckout_discount').hide();
   } else {
    $('.cod_msg').hide();
    $('.cod_discount').hide();
    $('.pointcheckout_discount').show();
   }
});


$('input[type=radio][name=address_type]').change(function() {
    if (this.value == 'home') {
        $('#building_label').text('House No. / Flat No. *');
    }
    else if (this.value == 'office') {
        $('#building_label').text('Office No. *');
    }
});
</script>




<!-- GPS location map -->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyDokZ9yr2DNr6W_Gpq39VJKMg1C-ob9ya4" ></script>

<script>
var geocoder;
var map;
var marker;
var address;
var infowindow = new google.maps.InfoWindow({
  size: new google.maps.Size(150, 50)
});

function initialize() {
  geocoder = new google.maps.Geocoder();

if (navigator.geolocation) {
navigator.geolocation.getCurrentPosition(function (p) {
	var latlng = new google.maps.LatLng(p.coords.latitude, p.coords.longitude);
   geocoder.geocode({ 'latLng': latlng },  (results, status) =>{
        if (status !== google.maps.GeocoderStatus.OK) {
            alert(status);
        }
        // This is checking to see if the Geoeode Status is OK before proceeding
        if (status == google.maps.GeocoderStatus.OK) {
            console.log(results);
            address = (results[0].formatted_address);
			document.getElementById("gps_location").value = address;
			codeAddress(address);
        }
    });
  var mapOptions = {
    zoom: 18,
    center: latlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
  google.maps.event.addListener(map, 'click', function() {
    infowindow.close();
  });
  });
}
}

function geocodePosition(pos) {
  geocoder.geocode({
    latLng: pos
  }, function(responses) {
    if (responses && responses.length > 0) {
      marker.formatted_address = responses[0].formatted_address;
      document.getElementById("gps_location").value = responses[0].formatted_address;
    } else {
      marker.formatted_address = 'Cannot determine address at this location.';
    }
    infowindow.setContent(marker.formatted_address + "<br>coordinates: " + marker.getPosition().toUrlValue(6));
    infowindow.open(map, marker);
  });
}

function codeAddress(address) {
  geocoder.geocode({
    'address': address
  }, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      if (marker) {
        marker.setMap(null);
        if (infowindow) infowindow.close();
      }
      marker = new google.maps.Marker({
        map: map,
        draggable: true,
        position: results[0].geometry.location
      });
      google.maps.event.addListener(marker, 'dragend', function() {
        geocodePosition(marker.getPosition());
      });
      google.maps.event.addListener(marker, 'click', function() {
        if (marker.formatted_address) {
          infowindow.setContent(marker.formatted_address + "<br>coordinates: " + marker.getPosition().toUrlValue(6));
        } else {
          infowindow.setContent(address + "<br>coordinates: " + marker.getPosition().toUrlValue(6));
        }
        infowindow.open(map, marker);
      });
      google.maps.event.trigger(marker, 'click');
      
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}
// google.maps.event.addDomListener(window, "load", initialize);
</script>


<style>
p.text-right1{
    text-align:right;
}
@media (max-width:767px){

.Mobile_bottom .m-b-sm-15{
    margin-bottom: 0px;
}
@media (max-width:576px){
    .address_text_box h6{
            font-size:15px!important;
}
.address_text_box .custom-control{
    padding-left: 0.5rem;
}
.Mobile_bottom .m-b-sm-15{
    margin-bottom: 0px;
}
 p{
    text-align:center!important;  
}
.card_box {
    margin-top:10px;
}
.card_box img{
    width:50px;
    margin-left:10px;
}

}
@media (max-width:360px){
    .address_text_box h6{
            font-size:15px!important;
    }
    .address_text_box .custom-control{
        <?php if($this->selected_lang->short_form == 'ar'){ ?> padding-right: 0rem !important; <?php } else { ?> padding-left: 0.5rem; <?php } ?>
    }
}
@media (max-width: 321px){
.address_text_box h6 {
    font-size: 13px!important;
}
@media (max-width: 281px){
.address_text_box .d-flex {
    display:block!important;
}
.Mobile_bottom .m-b-sm-15{
    margin-bottom: 0px;
}
 p{
    text-align:center!important;  
}
.card_box {
    margin-top:10px;
}
.card_box img{
    width:50px;
   
}
}



</style>