<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model
{
    //add order
    public function add_order($data_transaction)
    {
		$buyer_id=$this->auth_model->get_user_data();
		$buyer_type='registered';		
			
	    $cart_total = $this->cart_model->get_sess_cart_total();
        if (!empty($cart_total)) {
            $data = array(
                'order_number' => uniqid(),
                'buyer_id' => $buyer_id,
                'buyer_type' => $buyer_type,
                'price_subtotal' => $cart_total->subtotal,
                'price_vat' => $cart_total->vat,
                'price_shipping' => $cart_total->shipping_cost,
                'price_total' => $cart_total->total,
                'price_currency' => $cart_total->currency,
                'status' => 0,
                'payment_method' => $data_transaction["payment_method"],
                'payment_status' => "payment_received",
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            );

            //if cart does not have physical product
            if ($this->cart_model->check_cart_has_physical_product() != true) {
                $data["status"] = 1;
            }

            if ($this->auth_check) {
                $data["buyer_type"] = "registered";
                $data["buyer_id"] = $this->auth_user->id;
            }
            if ($this->db->insert('orders', $data)) {
                $order_id = $this->db->insert_id();

                //update order number
                $this->update_order_number($order_id);

                //add order shipping
                $this->add_order_shipping($order_id);

                //add order products
                $this->add_order_products($order_id, 'payment_received');

                //add digital sales
                $this->add_digital_sales($order_id);

                //add seller earnings
                $this->add_digital_sales_seller_earnings($order_id);

                //add payment transaction
                $this->add_payment_transaction($data_transaction, $order_id);

                //set bidding quotes as completed
                $this->load->model('bidding_model');
                $this->bidding_model->set_bidding_quotes_as_completed_after_purchase();

                //clear cart
                $this->cart_model->clear_cart();

                return $order_id;
            }
            return false;
        }
        return false;
    }

    //add order offline payment
    public function add_order_offline_payment($payment_option)
    {
        if($payment_option == 'cash_on_delivery') {
            $payment_method = 'Cash On Delivery';
        } else {
            $payment_method = 'Point Checkout';
        }
		$buyer_id=$this->auth_model->get_user_data();
		$buyer_type='registered';		
		
        $order_status = "awaiting_payment";
        $payment_status = "awaiting_payment";

        if ($payment_method == 'Cash On Delivery') {
            $order_status = "order_processing";
        }

        $cart_total = $this->cart_model->get_sess_cart_total();

        if($this->payment_settings->point_checkout_discount_enabled == 1) {
            $discount_percentage = $this->payment_settings->point_checkout_discount_percentage;
            $subtotal = $cart_total->subtotal/100;
            $pointcheckout_discount = $subtotal * $discount_percentage / 100; 
        } else {
            $pointcheckout_discount = 0;
        }

        $total_amnt_float = ($cart_total->total/100) - $pointcheckout_discount;
        $total_amnt_int = $total_amnt_float * 100;

        if (!empty($cart_total)) {
            $data = array(
                'order_number' => uniqid(),
                'buyer_id' => $buyer_id,
                'buyer_type' => $buyer_type,
                'price_subtotal' => $cart_total->subtotal,
                'price_vat' => $cart_total->vat,
                'price_shipping' => $cart_total->shipping_cost,
                'price_total' => $total_amnt_int,
                'price_currency' => $cart_total->currency,
                'status' => 0,
                'payment_method' => $payment_method,
                'payment_status' => $payment_status,
                'type' => 'wp'.date('YmdHis'),
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            );

            if ($this->auth_check) {
                $data["buyer_type"] = "registered";
                $data["buyer_id"] = $this->auth_user->id;
            }
			if ($cart_total->total > 0 && $cart_total->subtotal > 0){
				if ($this->db->insert('orders', $data)) {
					$order_id = $this->db->insert_id();

					//update order number
					$this->update_order_number($order_id);

					//add order shipping
					$this->add_order_shipping($order_id);

					//add order products
					$this->add_order_products($order_id, $order_status);

					//set bidding quotes as completed
					$this->load->model('bidding_model');
					$this->bidding_model->set_bidding_quotes_as_completed_after_purchase();

					//add invoice
					$this->add_invoice($order_id);

					//clear cart
					// $this->cart_model->clear_cart();

					return $order_id;
				}
			}
            
            return false;
        }
        return false;
    }

    //update order number
    public function update_order_number($order_id)
    {
        $order_id = clean_number($order_id);
        $data = array(
            'order_number' => $order_id + 10000
        );
        $this->db->where('id', $order_id);
        $this->db->update('orders', $data);
    }

    //update order number
    public function update_order_status($order_id, $status)
    {
        if($status == 'PAID') {
            $final_status = 'payment_received';
        } else {
            $final_status = 'awaiting_payment';
        }
        $order_id = clean_number($order_id);
        $data = array(
            'payment_status' => $final_status
        );
        $this->db->where('id', $order_id);
        $this->db->update('orders', $data);

        $data2 = array(
            'order_status' => $final_status
        );
        $this->db->where('order_id', $order_id);
        $this->db->update('order_products', $data2);
    }

    //add order shipping
    public function add_order_shipping($order_id)
    {
        $order_id = clean_number($order_id);
        if ($this->cart_model->check_cart_has_physical_product() == true && $this->form_settings->shipping == 1) {
            $shipping_address = $this->cart_model->get_sess_cart_shipping_address();

            if($this->input->post('shipping_country_id', true) == 178){
                $this->load->model('upload_model');
                $response = $this->upload_model->landing_page_upload('id_picture');
                if(!empty($response)){
                    $id_picture = $response;
                } else {
                    $id_picture = null;
                }
            } else {
                $id_picture = null;
            }
            // die;


            $data = array(
                'order_id' => $order_id,
                'id_picture' => $id_picture,
                'shipping_first_name' => $shipping_address->shipping_first_name,
                'shipping_last_name' => $shipping_address->shipping_last_name,
                'shipping_email' => $shipping_address->shipping_email,
                'shipping_phone_number' => $shipping_address->shipping_phone_number,
                'gps_location' => $shipping_address->gps_location,
                'address_type' => $shipping_address->address_type,
                'building_no' => $shipping_address->building_no,
                'street' => $shipping_address->street,
                'street_building_name' => $shipping_address->street_building_name,
                'landmark' => $shipping_address->landmark,
                'area' => $shipping_address->area,
                'shipping_address_1' => $shipping_address->shipping_address_1,
                'shipping_address_2' => $shipping_address->shipping_address_2,
                'shipping_country' => $shipping_address->shipping_country_id,
                'shipping_state' => $shipping_address->shipping_state,
                'shipping_city' => $shipping_address->shipping_city,
                'bk_shipping_full_name' => $shipping_address->shipping_first_name.' '.$shipping_address->shipping_last_name,
                'bk_shipping_email' => $shipping_address->shipping_email,
                'bk_shipping_phone_number' => $shipping_address->shipping_phone_number,
                'bk_shipping_address_1' => $shipping_address->shipping_address_1,
                'bk_shipping_address_2' => $shipping_address->shipping_address_2,
                'bk_shipping_country' => $shipping_address->shipping_country_id,
                'bk_shipping_state' => $shipping_address->shipping_state,
                'bk_shipping_city' => $shipping_address->shipping_city,
                'shipping_zip_code' => $shipping_address->shipping_zip_code,
                'billing_first_name' => $shipping_address->billing_first_name,
                'billing_last_name' => $shipping_address->billing_last_name,
                'billing_email' => $shipping_address->billing_email,
                'billing_phone_number' => $shipping_address->billing_phone_number,
                'billing_address_1' => $shipping_address->billing_address_1,
                'billing_address_2' => $shipping_address->billing_address_2,
                'billing_country' => $shipping_address->billing_country_id,
                'billing_state' => $shipping_address->billing_state,
                'billing_city' => $shipping_address->billing_city,
                'billing_zip_code' => $shipping_address->billing_zip_code
            );

            $country = get_country($shipping_address->shipping_country_id);
            if (!empty($country)) {
                $data["shipping_country"] = $country->name;
            }
            $country = get_country($shipping_address->billing_country_id);
            if (!empty($country)) {
                $data["billing_country"] = $country->name;
            }
            $this->db->insert('order_shipping', $data);
        }
    }

    //add order products
    public function add_order_products($order_id, $order_status)
    {
        $order_id = clean_number($order_id);
        $cart_items = $this->cart_model->get_sess_cart_items();
		
		$buyer_id=$this->auth_model->get_user_data();
		$buyer_type='registered';
			
        if (!empty($cart_items)) {
            foreach ($cart_items as $cart_item) {
                $product = get_available_product($cart_item->product_id);
                $variation_option_ids = @serialize($cart_item->options_array);
                if (!empty($product)) {
                    $data = array(
                        'order_id' => $order_id,
                        'seller_id' => $product->user_id,
                        'buyer_id' => $buyer_id,
                        'buyer_type' => $buyer_type,
                        'product_id' => $product->id,
                        'product_type' => $product->product_type,
                        'product_title' => $cart_item->product_title,
                        'product_slug' => $product->slug,
                        'product_unit_price' => $cart_item->unit_price,
                        'product_quantity' => $cart_item->quantity,
                        'product_currency' => $cart_item->currency,
                        'product_vat_rate' => $product->vat_rate,
                        'product_vat' => $cart_item->product_vat,
                        'product_shipping_cost' => $cart_item->shipping_cost,
                        'product_total_price' => $cart_item->total_price,
                        'variation_option_ids' => $variation_option_ids,
                        'commission_rate' => $this->general_settings->commission_rate,
                        'order_status' => $order_status,
                        'is_approved' => 0,
                        'shipping_tracking_number' => "",
                        'shipping_tracking_url' => "",
                        'updated_at' => date('Y-m-d H:i:s'),
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    if ($this->auth_check) {
                        $data["buyer_id"] = $this->auth_user->id;
                        $data["buyer_type"] = "registered";
                    }
                    //approve if digital product
                    if ($product->product_type == 'digital') {
                        $data["is_approved"] = 1;
                        if ($order_status == 'payment_received') {
                            $data["order_status"] = 'completed';
                        } else {
                            $data["order_status"] = $order_status;
                        }
                    }
                    $data["product_total_price"] = $cart_item->total_price + $cart_item->product_vat + $cart_item->shipping_cost;

                    $this->db->insert('order_products', $data);
                }
            }
        }
    }

    //add digital sales
    public function add_digital_sales($order_id)
    {
        $order_id = clean_number($order_id);
        $cart_items = $this->cart_model->get_sess_cart_items();
        $order = $this->get_order($order_id);
        if (!empty($cart_items) && $this->auth_check && !empty($order)) {
            foreach ($cart_items as $cart_item) {
                $product = get_available_product($cart_item->product_id);
                if (!empty($product) && $product->product_type == 'digital') {
                    $data_digital = array(
                        'order_id' => $order_id,
                        'product_id' => $product->id,
                        'product_title' => $product->title,
                        'seller_id' => $product->user_id,
                        'buyer_id' => $order->buyer_id,
                        'license_key' => '',
                        'purchase_code' => generate_purchase_code(),
                        'currency' => $product->currency,
                        'price' => $product->price,
                        'purchase_date' => date('Y-m-d H:i:s')
                    );

                    $license_key = $this->product_model->get_unused_license_key($product->id);
                    if (!empty($license_key)) {
                        $data_digital['license_key'] = $license_key->license_key;
                    }

                    $this->db->insert('digital_sales', $data_digital);

                    //set license key as used
                    if (!empty($license_key)) {
                        $this->product_model->set_license_key_used($license_key->id);
                    }
                }
            }
        }
    }

    //add digital sale
    public function add_digital_sale($product_id, $order_id)
    {
        $product_id = clean_number($product_id);
        $order_id = clean_number($order_id);
        $product = get_available_product($product_id);
        $order = $this->get_order($order_id);
        if (!empty($product) && $product->product_type == 'digital' && !empty($order)) {
            $data_digital = array(
                'order_id' => $order_id,
                'product_id' => $product->id,
                'product_title' => $product->title,
                'seller_id' => $product->user_id,
                'buyer_id' => $order->buyer_id,
                'license_key' => '',
                'purchase_code' => generate_purchase_code(),
                'currency' => $product->currency,
                'price' => $product->price,
                'purchase_date' => date('Y-m-d H:i:s')
            );

            $license_key = $this->product_model->get_unused_license_key($product->id);
            if (!empty($license_key)) {
                $data_digital['license_key'] = $license_key->license_key;
            }

            $this->db->insert('digital_sales', $data_digital);

            //set license key as used
            if (!empty($license_key)) {
                $this->product_model->set_license_key_used($license_key->id);
            }
        }
    }

    //add digital sales seller earnings
    public function add_digital_sales_seller_earnings($order_id)
    {
        $order_id = clean_number($order_id);
        $order_products = $this->get_order_products($order_id);
        if (!empty($order_products)) {
            foreach ($order_products as $order_product) {
                if ($order_product->product_type == 'digital') {
                    $this->earnings_model->add_seller_earnings($order_product);
                }
            }
        }
    }

    //add payment transaction
    public function add_payment_transaction($data_transaction, $order_id)
    {
        $order_id = clean_number($order_id);
        $data = array(
            'payment_method' => $data_transaction["payment_method"],
            'payment_id' => $data_transaction["payment_id"],
            'order_id' => $order_id,
            'user_id' => 0,
            'user_type' => "guest",
            'currency' => $data_transaction["currency"],
            'payment_amount' => $data_transaction["payment_amount"],
            'payment_status' => $data_transaction["payment_status"],
            'ip_address' => 0,
            'created_at' => date('Y-m-d H:i:s')
        );
        if ($this->auth_check) {
            $data["user_id"] = $this->auth_user->id;
            $data["user_type"] = "registered";
        }
        $ip = $this->input->ip_address();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }
        if ($this->db->insert('transactions', $data)) {
            //add invoice
            $this->add_invoice($order_id);
        }
    }

    //update order payment as received
    public function update_order_payment_received($order)
    {
        if (!empty($order)) {
            //update product payment status
            $data_order = array(
                'payment_status' => "payment_received",
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $this->db->where('id', $order_id);
            if ($this->db->update('orders', $data_order)) {
                //update order products payment status
                $order_products = $this->get_order_products($order_id);
                if (!empty($order_products)) {
                    foreach ($order_products as $order_product) {
                        $data = array(
                            'order_status' => "payment_received",
                            'updated_at' => date('Y-m-d H:i:s'),
                        );
                        $this->db->where('id', $order_product->id);
                        $this->db->update('order_products', $data);
                    }
                }

                //add invoice
                $this->add_invoice($order_id);
            }
        }
    }

    //get orders count
    public function get_orders_count($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->where('buyer_id', $user_id);
        $this->db->where('status', 0);
        $query = $this->db->get('orders');
        return $query->num_rows();
    }

    //get paginated orders
    public function get_paginated_orders($user_id, $per_page, $offset)
    {
        $user_id = clean_number($user_id);
        $this->db->where('buyer_id', $user_id);
        $this->db->where('status', 0);
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('orders');
        return $query->result();
    }

    //get completed orders count
    public function get_completed_orders_count($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->where('buyer_id', $user_id);
        $this->db->where('status', 1);
        $query = $this->db->get('orders');
        return $query->num_rows();
    }

    //get paginated completed orders
    public function get_paginated_completed_orders($user_id, $per_page, $offset)
    {
        $user_id = clean_number($user_id);
        $this->db->where('buyer_id', $user_id);
        $this->db->where('status', 1);
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('orders');
        return $query->result();
    }

    //get order products
    public function get_order_products($order_id)
    {
        $order_id = clean_number($order_id);
        $this->db->where('order_id', $order_id);
		$this->db->where('order_status!=','cancelled');
        $query = $this->db->get('order_products');
        return $query->result();
    }

    //get seller order products
    public function get_seller_order_products($order_id, $seller_id)
    {
        $order_id = clean_number($order_id);
        $seller_id = clean_number($seller_id);
        $this->db->where('order_id', $order_id);
        $this->db->where('seller_id', $seller_id);
        $query = $this->db->get('order_products');
        return $query->result();
    }

    //get order product
    public function get_order_product($order_product_id)
    {
        $order_product_id = clean_number($order_product_id);
        $this->db->where('id', $order_product_id);
        $this->db->where('order_status!=','cancelled');
        $query = $this->db->get('order_products');
        return $query->row();
    }

    //get order
    public function get_order($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('orders');
        return $query->row();
    }

    //get order by order number
    public function get_order_by_order_number($order_number)
    {
        $this->db->where('order_number', clean_number($order_number));
        $query = $this->db->get('orders');
        return $query->row();
    }

    //update order product status
    public function update_order_product_status($order_product_id)
    {
        $order_product_id = clean_number($order_product_id);
        $order_product = $this->get_order_product($order_product_id);
        if (!empty($order_product)) {
            if ($order_product->seller_id == $this->auth_user->id) {
                $data = array(
                    'order_status' => $this->input->post('order_status', true),
                    'is_approved' => 0,
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                if ($order_product->product_type == 'digital' && $data["order_status"] == 'payment_received') {
                    $data['order_status'] = 'completed';
                }

                if ($data["order_status"] == 'shipped') {
                    //send email
                    if ($this->general_settings->send_email_order_shipped == 1) {
                        $email_data = array(
                            'email_type' => 'order_shipped',
                            'order_product_id' => $order_product->id
                        );
                        $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
                    }
                }

                $this->db->where('id', $order_product_id);
                return $this->db->update('order_products', $data);
            }
        }
        return false;
    }

    //add shipping tracking number
    public function add_shipping_tracking_number($order_product_id)
    {
        $order_product_id = clean_number($order_product_id);
        $order_product = $this->get_order_product($order_product_id);
        if (!empty($order_product)) {
            if ($order_product->seller_id == $this->auth_user->id) {
                $data = array(
                    'shipping_tracking_number' => $this->input->post('shipping_tracking_number', true),
                    'shipping_tracking_url' => $this->input->post('shipping_tracking_url', true),
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                $this->db->where('id', $order_product_id);
                return $this->db->update('order_products', $data);
            }
        }
        return false;
    }

    //add bank transfer payment report
    public function add_bank_transfer_payment_report()
    {
        $data = array(
            'order_number' => $this->input->post('order_number', true),
            'payment_note' => $this->input->post('payment_note', true),
            'receipt_path' => "",
            'user_id' => 0,
            'user_type' => "guest",
            'status' => "pending",
            'ip_address' => 0,
            'created_at' => date('Y-m-d H:i:s')
        );
        if ($this->auth_check) {
            $data["user_id"] = $this->auth_user->id;
            $data["user_type"] = "registered";
        }
        $ip = $this->input->ip_address();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }

        $this->load->model('upload_model');
        $file_path = $this->upload_model->receipt_upload('file');
        if (!empty($file_path)) {
            $data["receipt_path"] = $file_path;
        }

        return $this->db->insert('bank_transfers', $data);
    }

    //get sales count
    public function get_sales_count($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.id');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', $user_id);
        $this->db->where('order_products.order_status !=', 'completed');
        $query = $this->db->get('orders');
        return $query->num_rows();
    }

    //get paginated sales
    public function get_paginated_sales($user_id, $per_page, $offset)
    {
        $user_id = clean_number($user_id);
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.id');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', $user_id);
        $this->db->where('order_products.order_status !=', 'completed');
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('orders');
        return $query->result();
    }

    //get completed sales count
    public function get_completed_sales_count($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.id');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', $user_id);
        $this->db->where('order_products.order_status', 'completed');
        $query = $this->db->get('orders');
        return $query->num_rows();
    }

    //get paginated completed sales
    public function get_paginated_completed_sales($user_id, $per_page, $offset)
    {
        $user_id = clean_number($user_id);
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.id');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', $user_id);
        $this->db->where('order_products.order_status', 'completed');
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('orders');
        return $query->result();
    }

    //get order shipping
    public function get_order_shipping($order_id)
    {
        $order_id = clean_number($order_id);
        $this->db->where('order_id', $order_id);
        $query = $this->db->get('order_shipping');
        return $query->row();
    }

    //check order seller
    public function check_order_seller($order_id)
    {
        $order_id = clean_number($order_id);
        $order_products = $this->get_order_products($order_id);
        $result = false;
        if (!empty($order_products)) {
            foreach ($order_products as $product) {
                if ($product->seller_id == $this->auth_user->id) {
                    $result = true;
                }
            }
        }
        return $result;
    }

    //get seller total price
    public function get_seller_total_price($order_id)
    {
        $order_id = clean_number($order_id);
        $order_products = $this->get_order_products($order_id);
        $total = 0;
        if (!empty($order_products)) {
            foreach ($order_products as $product) {
                if ($product->seller_id == $this->auth_user->id) {
                    $total += $product->product_total_price;
                }
            }
        }
        return $total;
    }

    //approve order product
    public function approve_order_product($order_product_id)
    {
        $order_product_id = clean_number($order_product_id);
        $order_product = $this->get_order_product($order_product_id);

        if (!empty($order_product)) {
            if ($this->auth_user->id == $order_product->buyer_id) {
                $data = array(
                    'is_approved' => 1,
                    'order_status' => "completed",
                    'updated_at' => date('Y-m-d H:i:s')
                );
                $this->db->where('id', $order_product_id);
                return $this->db->update('order_products', $data);
            }
        }

        return false;
    }

    //decrease product stock after sale
    public function decrease_product_stock_after_sale($order_id)
    {
        $order_products = $this->get_order_products($order_id);
        if (!empty($order_products)) {
            foreach ($order_products as $order_product) {
                $option_ids = @unserialize($order_product->variation_option_ids);
                if (!empty($option_ids)) {
                    foreach ($option_ids as $option_id) {
                        $option = $this->variation_model->get_variation_option($option_id);
                        if (!empty($option)) {
                            if ($option->is_default == 1) {
                                $product = $this->product_model->get_product_by_id($order_product->product_id);
                                if (!empty($product)) {
                                    $stock = $product->stock - $order_product->product_quantity;
                                    if ($stock < 0) {
                                        $stock = 0;
                                    }
                                    $data = array(
                                        'stock' => $stock
                                    );
                                    $this->db->where('id', $product->id);
                                    $this->db->update('products', $data);
                                }
                            } else {
                                $stock = $option->stock - $order_product->product_quantity;
                                if ($stock < 0) {
                                    $stock = 0;
                                }
                                $data = array(
                                    'stock' => $stock
                                );
                                $this->db->where('id', $option->id);
                                $this->db->update('variation_options', $data);
                            }
                        }
                    }
                } else {
                    $product = $this->product_model->get_product_by_id($order_product->product_id);
                    if (!empty($product)) {
                        $stock = $product->stock - $order_product->product_quantity;
                        if ($stock < 0) {
                            $stock = 0;
                        }
                        $data = array(
                            'stock' => $stock
                        );
                        $this->db->where('id', $product->id);
                        $this->db->update('products', $data);
                    }
                }
            }
        }
    }

    //add invoice
    public function add_invoice($order_id)
    {
        $order = $this->get_order($order_id);
        if (!empty($order)) {
            $invoice = $this->get_invoice_by_order_number($order->order_number);
            if (empty($invoice)) {
                $client = get_user($order->buyer_id);
                /* if (!empty($client)) {
                    $invoice_items = array();
                    $order_products = $this->order_model->get_order_products($order_id);
                    if (!empty($order_products)) {
                        foreach ($order_products as $order_product) {
                            $seller = get_user($order_product->seller_id);
                            $item = array(
                                'id' => $order_product->id,
                                'seller' => (!empty($seller)) ? $seller->username : ""
                            );
                            array_push($invoice_items, $item);
                        }
                    }
                    $data = array(
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                        'client_username' => $client->username,
                        'client_first_name' => $client->first_name,
                        'client_last_name' => $client->last_name,
                        'client_address' => get_location($client),
                        'invoice_items' => @serialize($invoice_items),
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    return $this->db->insert('invoices', $data);
                }
                else{ */
                    $order_shipment = get_order_shipping($order_id);
                    if (!empty($order_shipment)) {
                    $invoice_items = array();
                    $order_products = $this->order_model->get_order_products($order_id);
                    if (!empty($order_products)) {
                        foreach ($order_products as $order_product) {
                            $seller = get_user($order_product->seller_id);
                            $item = array(
                                'id' => $order_product->id,
                                'seller' => (!empty($seller)) ? $seller->username : ""
                            );
                            array_push($invoice_items, $item);
                        }
                    }
                    $client_address = $order_shipment->address_type.": ".$order_shipment->building_no.", ".$order_shipment->street_building_name.", ".$order_shipment->street.", ".$order_shipment->landmark.", ".$order_shipment->area.", ".$order_shipment->shipping_zip_code.", ".$order_shipment->shipping_city.", ".$order_shipment->shipping_state.", ".$order_shipment->shipping_country;

                    $data = array(
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                        'client_username' => $order_shipment->shipping_first_name,
                        'client_first_name' => $order_shipment->shipping_first_name,
                        'client_last_name' => $order_shipment->shipping_last_name,
                        'client_address' => $client_address,
                        'invoice_items' => @serialize($invoice_items),
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    return $this->db->insert('invoices', $data);
                    }
                /* } */
            }
			else{
                //$invoice
                $client = get_user($order->buyer_id);
                if (!empty($client)) {
                    $invoice_items = array();
                    $order_products = $this->order_model->get_order_products($order_id);
                    if (!empty($order_products)) {
                        foreach ($order_products as $order_product) {
                            $seller = get_user($order_product->seller_id);
                            $item = array(
                                'id' => $order_product->id,
                                'seller' => (!empty($seller)) ? $seller->username : ""
                            );
                            array_push($invoice_items, $item);
                        }
                    }
                    $data = array(
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                        'client_username' => $client->username,
                        'client_first_name' => $client->first_name,
                        'client_last_name' => $client->last_name,
                        'client_address' => get_location($client),
                        'invoice_items' => @serialize($invoice_items),
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    $this->db->where('id',$invoice->id);
                    return $this->db->update('invoices', $data);
                }
			}
        }
        return false;
    }

    //get invoice
    public function get_invoice($id)
    {
        $this->db->where('id', clean_number($id));
        $query = $this->db->get('invoices');
        return $query->row();
    }

    //get invoice by order number
    public function get_invoice_by_order_number($order_number)
    {
        $this->db->where('order_number', clean_number($order_number));
        $query = $this->db->get('invoices');
        return $query->row();
    }
	public function update_order($order=array(),$order_id)
    {
		$this->db->where('id', $order_id);
        $this->db->update('orders', $order);
    }
}
