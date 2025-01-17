<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart_controller extends Home_Core_Controller
{
    /*
     * Payment Types
     *
     * 1. sale: Product purchases
     * 2. promote: Promote purchases
     *
     */

    public function __construct()
    {
        parent::__construct();

        $this->session_cart_items = $this->cart_model->get_sess_cart_items();
        $this->cart_model->calculate_cart_total();
    }

    /**
     * Cart
     */
    public function cart()
    {
        $data['title'] = trans("shopping_cart");
        $data['description'] = trans("shopping_cart") . " - " . $this->app_name;
        $data['keywords'] = trans("shopping_cart") . "," . $this->app_name;

        $data['cart_items'] = $this->session_cart_items;
        $data['cart_total'] = $this->cart_model->get_sess_cart_total();
        $data['cart_has_physical_product'] = $this->cart_model->check_cart_has_physical_product();
        $data['cart_current_user'] = get_current_user_session();

        // $data['addon_products'] = $this->product_admin_model->addon_products();
        $data['addon_products'] = get_addon_products(8);
        
        // echo "<pre>"; print_r($data['addon_products']); die;
        $this->load->view('partials/_header', $data);
        $this->load->view('cart/cart', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Add to Cart
     */
    public function add_to_cart()
    {
        $product_id = $this->input->post('product_id', true);
        $product = $this->product_model->get_product_by_id($product_id);
        if (!empty($product)) {
            if ($product->status != 1) {
                $this->session->set_flashdata('product_details_error', trans("msg_error_cart_unapproved_products"));
            } else {
                $this->cart_model->add_to_cart($product);
                redirect(generate_url("cart/shipping"));
            }
        }
        redirect($this->agent->referrer());
    }

    /**
     * Add to Cart qQuote
     */
    public function add_to_cart_quote()
    {
        $quote_request_id = $this->input->post('id', true);
        if (!empty($this->cart_model->add_to_cart_quote($quote_request_id))) {
            redirect(generate_url("cart"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Remove from Cart
     */
    public function remove_from_cart()
    {
        $cart_item_id = $this->input->post('cart_item_id', true);
        $this->cart_model->remove_from_cart($cart_item_id);
    }

    /**
     * Update Cart Product Quantity
     */
    public function update_cart_product_quantity()
    {
        $product_id = $this->input->post('product_id', true);
        $cart_item_id = $this->input->post('cart_item_id', true);
        $quantity = $this->input->post('quantity', true);
        $this->cart_model->update_cart_product_quantity($product_id, $cart_item_id, $quantity);
    }

    /**
     * Shipping
     */
    public function shipping()
    {
        $data['title'] = trans("shopping_cart");
        $data['description'] = trans("shopping_cart") . " - " . $this->app_name;
        $data['keywords'] = trans("shopping_cart") . "," . $this->app_name;
        $data['cart_items'] = $this->cart_model->get_sess_cart_items();
        $data['mds_payment_type'] = 'sale';
        $data['cart_current_user'] = get_current_user_session();

        if ($data['cart_items'] == null) {
            redirect(generate_url("cart"));
        }
        //check shipping status
        if ($this->form_settings->shipping != 1) {
            redirect(generate_url("cart"));
            exit();
        }
        //check guest checkout
        if (empty($this->auth_check) && $this->general_settings->guest_checkout != 1) {
            redirect(generate_url("cart"));
            exit();
        }
        //check physical products
        if ($this->cart_model->check_cart_has_physical_product() == false) {
            redirect(generate_url("cart"));
            exit();
        }

        if (!empty($this->session->userdata('mds_default_location_id'))){
            $data['country'] = get_country($this->session->userdata('mds_default_location_id'));
        } else {
            $data['country'] = array();
        }

        $data['cart_total'] = $this->cart_model->get_sess_cart_total();
        $data["shipping_address"] = $this->cart_model->get_sess_cart_shipping_address();
    
        $this->load->view('partials/_header', $data);
        $this->load->view('cart/shipping', $data);
        $this->load->view('partials/_footer');

    }

    /**
     * Direct cash on delivery Post
     */
    public function cod_direct_post()
    {
        
        // echo "<pre>"; print_r($this->input->post()); exit;
        
        $this->cart_model->set_sess_cart_shipping_address();
		$this->cart_model->set_sess_cart_payment_method();
        $mds_payment_type = $this->input->post('mds_payment_type', true);

        $payment_option = $this->input->post('payment_option', true);

		$location_id = $this->input->post('shipping_country_id', true);
        if (!empty($location_id)) {
            $this->session->set_userdata('mds_default_location_id', $location_id);
        } else {
            @$this->session->unset_userdata('mds_default_location_id');
        }
        //add order

        // echo "<pre>"; print_r($payment_option);
        $order_id = $this->order_model->add_order_offline_payment($payment_option);
        $order = $this->order_model->get_order($order_id);
        if (!empty($order)) {
            //decrease product quantity after sale
            $this->order_model->decrease_product_stock_after_sale($order->id);
            //send email
            if ($this->general_settings->send_email_buyer_purchase == 1) {
                $email_data = array(
                    'email_type' => 'new_order',
                    'order_id' => $order_id
                );
                $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
            }
            

            /* redirect to point_checkout payment gateway code start */
            if($payment_option == 'point_checkout') {
                $response = get_point_checkout_payment_url($order_id, $order->order_number);

                // echo "<pre>"; print_r($response); die;
                if($response->success == true){

                    if($this->payment_settings->point_checkout_discount_enabled == 1) {
                        $discount_percentage = $this->payment_settings->point_checkout_discount_percentage;
                        $data = array(
                            'order_id' => $order_id,
                            'discount_type' => 'percentage',
                            'total_discount' => $discount_percentage,
                            'status' => 1,
                            'created_at' => date('Y-m-d H:i:s'),
                            );
    
                        $this->db->insert('order_discount',$data);
                    }
                    
                    $transaction_id = $response->result->id;
                    $data_order = array(
                        'transaction_id' => $transaction_id,
                    );
                    $this->db->where('id', $order_id);
                    $this->db->update('orders', $data_order);
                    
                    $this->session->set_userdata('mds_show_order_completed_page', 1);
                    $transcation_id = $response->result->id;
                    $redirectUrl = $response->result->redirectUrl;
                    
                    return redirect($redirectUrl);
                }
            }
            /* redirect to point_checkout payment gateway code end */


            $this->session->set_userdata('mds_show_order_completed_page', 1);
            redirect(generate_url("order_completed") . "/" . $order->order_number);
            


            /*if ($order->buyer_id == 0) {
                $this->session->set_userdata('mds_show_order_completed_page', 1);
                redirect(generate_url("order_completed") . "/" . $order->order_number);
            } else {
                $this->session->set_flashdata('success', trans("msg_order_completed"));
                redirect(generate_url("order_details") . "/" . $order->order_number);
            }*/
        }
        $this->session->set_flashdata('error', trans("msg_error"));
        redirect(generate_url("cart", "payment"));
    }
	
    /**
     * Shipping Post
     */
    public function shipping_post()
    {
        $this->cart_model->set_sess_cart_shipping_address();
        redirect(generate_url("cart", "payment_method") . "?payment_type=sale");
    }

    /**
     * Payment Method
     */
    public function payment_method()
    {
        $data['title'] = trans("shopping_cart");
        $data['description'] = trans("shopping_cart") . " - " . $this->app_name;
        $data['keywords'] = trans("shopping_cart") . "," . $this->app_name;
        $data['mds_payment_type'] = 'sale';
        $data['cart_current_user'] = get_current_user_session();

        $payment_type = $this->input->get('payment_type', true);

        if (!empty($payment_type) && $payment_type == 'promote') {
            if ($this->general_settings->promoted_products != 1) {
                redirect(lang_base_url());
            }
            $data['mds_payment_type'] = 'promote';
            $data['promoted_plan'] = $this->session->userdata('modesy_selected_promoted_plan');
            if (empty($data['promoted_plan'])) {
                redirect(lang_base_url());
            }
        } else {
            $data['cart_items'] = $this->cart_model->get_sess_cart_items();
            if ($data['cart_items'] == null) {
                redirect(generate_url("cart"));
            }

            //check auth for digital products
            if (!$this->auth_check && $this->cart_model->check_cart_has_digital_product() == true) {
                $this->session->set_flashdata('error', trans("msg_digital_product_register_error"));
                redirect(generate_url("register"));
                exit();
            }

            $data['cart_total'] = $this->cart_model->get_sess_cart_total();
            $user_id = null;
            if ($this->auth_check) {
                $user_id = $this->auth_user->id;
            }

            $data['cart_has_physical_product'] = $this->cart_model->check_cart_has_physical_product();
            $data['cart_has_digital_product'] = $this->cart_model->check_cart_has_digital_product();
            $this->cart_model->unset_sess_cart_payment_method();
        }

        $this->load->view('partials/_header', $data);
        $this->load->view('cart/payment_method', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Payment Method Post
     */
    public function payment_method_post()
    {
        $this->cart_model->set_sess_cart_payment_method();

        $mds_payment_type = $this->input->post('mds_payment_type', true);
        if (!empty($mds_payment_type) && $mds_payment_type == 'promote') {
            $transaction_number = 'bank-' . generate_transaction_number();
            $this->session->set_userdata('mds_promote_bank_transaction_number', $transaction_number);
            redirect(generate_url("cart", "payment") . "?payment_type=promote");
        } else {
            redirect(generate_url("cart", "payment"));
        }
    }

    /**
     * Payment
     */
    public function payment()
    {
        $data['title'] = trans("shopping_cart");
        $data['description'] = trans("shopping_cart") . " - " . $this->app_name;
        $data['keywords'] = trans("shopping_cart") . "," . $this->app_name;
        $data['mds_payment_type'] = 'sale';
        $data['cart_current_user'] = get_current_user_session();

        //check guest checkout
        if (empty($this->auth_check) && $this->general_settings->guest_checkout != 1) {
            redirect(generate_url("cart"));
            exit();
        }

        //check is set cart payment method
        $data['cart_payment_method'] = $this->cart_model->get_sess_cart_payment_method();
        if (empty($data['cart_payment_method'])) {
            redirect(generate_url("cart", "payment_method"));
        }

        $payment_type = $this->input->get('payment_type', true);
        if (!empty($payment_type) && $payment_type == 'promote') {
            if ($this->general_settings->promoted_products != 1) {
                redirect(lang_base_url());
            }
            $data['mds_payment_type'] = 'promote';
            $data['promoted_plan'] = $this->session->userdata('modesy_selected_promoted_plan');
            if (empty($data['promoted_plan'])) {
                redirect(lang_base_url());
            }
            //total amount
            $data['total_amount'] = $data['promoted_plan']->total_amount;
            $data['currency'] = $this->payment_settings->default_product_currency;
            $data['transaction_number'] = $this->session->userdata('mds_promote_bank_transaction_number');
            $data['cart_total'] = null;
        } else {
            $data['cart_items'] = $this->cart_model->get_sess_cart_items();
            if ($data['cart_items'] == null) {
                redirect(generate_url("cart"));
            }
            $data['cart_total'] = $this->cart_model->get_sess_cart_total();
            $data["shipping_address"] = $this->cart_model->get_sess_cart_shipping_address();
            $data['cart_has_physical_product'] = $this->cart_model->check_cart_has_physical_product();
            //total amount
            $data['total_amount'] = $data['cart_total']->total;
            $data['currency'] = $this->payment_settings->default_product_currency;
        }

        //check pagseguro
        if ($data['cart_payment_method']->payment_option == 'pagseguro') {
            $this->load->library('pagseguro');
            $data['session_code'] = $this->pagseguro->get_session_code();
        }

        $this->load->view('partials/_header', $data);
        $this->load->view('cart/payment', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Payment with Paypal
     */
    public function paypal_payment_post()
    {
        $payment_id = $this->input->post('payment_id', true);
        $this->load->library('paypal');

        //validate the order
        if ($this->paypal->get_order($payment_id)) {
            $data_transaction = array(
                'payment_method' => "PayPal",
                'payment_id' => $payment_id,
                'currency' => $this->input->post('currency', true),
                'payment_amount' => $this->input->post('payment_amount', true),
                'payment_status' => $this->input->post('payment_status', true),
            );

            $mds_payment_type = $this->input->post('mds_payment_type', true);
            if ($mds_payment_type == 'sale') {
                //execute sale payment
                $this->execute_sale_payment($data_transaction, 'json_encode');
            } elseif ($mds_payment_type == 'promote') {
                //execute promote payment
                $this->execute_promote_payment($data_transaction, 'json_encode');
            }
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $data = array(
                'status' => 0,
                'redirect' => generate_url("cart", "payment")
            );
            echo json_encode($data);
        }
    }

    /**
     * Payment with Stripe
     */
    public function stripe_payment_post()
    {
        require_once(APPPATH . 'third_party/stripe/vendor/autoload.php');
        try {
            $token = $this->input->post('payment_id', true);
            $email = $this->input->post('email', true);
            $payment_amount = $this->input->post('payment_amount', true);
            $currency = $this->input->post('currency', true);
            //Init stripe
            $stripe = array(
                "secret_key" => $this->payment_settings->stripe_secret_key,
                "publishable_key" => $this->payment_settings->stripe_publishable_key,
            );
            \Stripe\Stripe::setApiKey($stripe['secret_key']);
            //customer
            $customer = \Stripe\Customer::create(array(
                'email' => $email,
                'source' => $token
            ));
            $charge = \Stripe\Charge::create(array(
                'customer' => $customer->id,
                'amount' => $payment_amount,
                'currency' => $currency,
                'description' => trans("stripe_checkout")
            ));

            //add to database
            $data_transaction = array(
                'payment_method' => "Stripe",
                'payment_id' => $token,
                'currency' => $currency,
                'payment_amount' => get_price($payment_amount, 'decimal'),
                'payment_status' => $this->input->post('payment_status', true),
            );

            $mds_payment_type = $this->input->post('mds_payment_type', true);
            if ($mds_payment_type == 'sale') {
                //execute sale payment
                $this->execute_sale_payment($data_transaction, 'json_encode');
            } elseif ($mds_payment_type == 'promote') {
                //execute promote payment
                $this->execute_promote_payment($data_transaction, 'json_encode');
            }

        } catch (\Stripe\Error\Base $e) {
            $this->session->set_flashdata('error', $e->getMessage());
            $data = array(
                'status' => 0,
                'redirect' => generate_url("cart", "payment")
            );
            echo json_encode($data);
        } catch (Exception $e) {
            $this->session->set_flashdata('error', $e->getMessage());
            $data = array(
                'status' => 0,
                'redirect' => generate_url("cart", "payment")
            );
            echo json_encode($data);
        }
    }

    /**
     * Payment with PayStack
     */
    public function paystack_payment_post()
    {
        $this->load->library('paystack');

        $data_transaction = array(
            'payment_method' => "PayStack",
            'payment_id' => $this->input->post('payment_id', true),
            'currency' => $this->input->post('currency', true),
            'payment_amount' => get_price($this->input->post('payment_amount', true), 'decimal'),
            'payment_status' => $this->input->post('payment_status', true),
        );

        if (empty($this->paystack->verify_transaction($data_transaction['payment_id']))) {
            $this->session->set_flashdata('error', 'Invalid transaction code!');
            $data = array(
                'status' => 0,
                'redirect' => generate_url("cart", "payment")
            );
            echo json_encode($data);
            exit();
        }

        $mds_payment_type = $this->input->post('mds_payment_type', true);
        if ($mds_payment_type == 'sale') {
            //execute sale payment
            $this->execute_sale_payment($data_transaction, 'json_encode');
        } elseif ($mds_payment_type == 'promote') {
            //execute promote payment
            $this->execute_promote_payment($data_transaction, 'json_encode');
        }
    }

    /**
     * Payment with Razorpay
     */
    public function razorpay_payment_post()
    {
        $this->load->library('razorpay');

        $data_transaction = array(
            'payment_method' => "Razorpay",
            'payment_id' => $this->input->post('payment_id', true),
            'razorpay_order_id' => $this->input->post('razorpay_order_id', true),
            'razorpay_signature' => $this->input->post('razorpay_signature', true),
            'currency' => $this->input->post('currency', true),
            'payment_amount' => get_price($this->input->post('payment_amount', true), 'decimal'),
            'payment_status' => 'succeeded',
        );

        if (empty($this->razorpay->verify_payment_signature($data_transaction))) {
            $this->session->set_flashdata('error', 'Invalid signature passed!');
            $data = array(
                'status' => 0,
                'redirect' => generate_url("cart", "payment")
            );
            echo json_encode($data);
            exit();
        }

        $mds_payment_type = $this->input->post('mds_payment_type', true);
        if ($mds_payment_type == 'sale') {
            //execute sale payment
            $this->execute_sale_payment($data_transaction, 'json_encode');
        } elseif ($mds_payment_type == 'promote') {
            //execute promote payment
            $this->execute_promote_payment($data_transaction, 'json_encode');
        }
    }

    /**
     * Payment with Iyzico
     */
    public function iyzico_payment_post()
    {
        $token = $this->input->post('token', true);
        $conversation_id = $this->input->get('conversation_id', true);
        $lang = $this->input->get('lang', true);
        $lang_base_url = lang_base_url();
        if ($lang != $this->general_settings->site_lang) {
            $lang_base_url = base_url() . $lang . "/";
        }

        $options = initialize_iyzico();
        $request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId($conversation_id);
        $request->setToken($token);

        $checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, $options);

        if ($checkoutForm->getPaymentStatus() == "SUCCESS") {
            $data_transaction = array(
                'payment_method' => "Iyzico",
                'payment_id' => $checkoutForm->getPaymentId(),
                'currency' => $checkoutForm->getCurrency(),
                'payment_amount' => $checkoutForm->getPrice(),
                'payment_status' => "succeeded",
            );

            $mds_payment_type = $this->input->get('payment_type', true);
            if ($mds_payment_type == 'sale') {
                //execute sale payment
                $this->execute_sale_payment($data_transaction, 'direct');
            } elseif ($mds_payment_type == 'promote') {
                //execute promote payment
                $this->execute_promote_payment($data_transaction, 'direct');
            }

        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($lang_base_url . get_route("cart", true) . get_route("payment"));
        }
    }

    /**
     * Payment with PagSeguro
     */
    public function pagseguro_payment_post()
    {
        $this->load->library('pagseguro');
        $inputs = array(
            'payment_type' => $this->input->post('payment_type', true),
            'token' => htmlspecialchars($this->input->post('token', true)),
            'senderHash' => htmlspecialchars($this->input->post('senderHash', true)),
            'cardNumber' => $this->input->post('cardNumber', true),
            'cardExpiry' => $this->input->post('cardExpiry', true),
            'cardCVC' => $this->input->post('cardCVC', true),
            'total_amount' => $this->input->post('total_amount', true),
            'full_name' => $this->input->post('full_name', true),
            'cpf' => $this->input->post('cpf', true),
            'phone' => $this->input->post('phone', true),
            'email' => $this->input->post('email', true),
            'date_of_birth' => $this->input->post('date_of_birth', true),
            'postal_code' => $this->input->post('postal_code', true),
            'city' => $this->input->post('city', true),
        );

        $result = null;
        $payment_method = 'PagSeguro - Credit Card';
        if ($this->input->post('payment_type', true) == 'credit_card') {
            $result = $this->pagseguro->pay_with_credit_card($inputs);
            if (empty($result)) {
                $this->session->set_flashdata('form_data', $inputs);
                redirect($this->agent->referrer());
            }
        } else {
            $payment_method = 'PagSeguro - Boleto';
            $result = $this->pagseguro->pay_with_boleto($inputs);
            if (empty($result)) {
                $this->session->set_flashdata('form_data', $inputs);
                redirect($this->agent->referrer());
            }
        }

        if (!empty($result->code)) {
            $data_transaction = array(
                'payment_method' => $payment_method,
                'payment_id' => $result->code,
                'currency' => 'BRL',
                'payment_amount' => $inputs['total_amount'],
                'payment_status' => "succeeded",
            );

            $mds_payment_type = $this->input->post('mds_payment_type', true);
            if ($mds_payment_type == 'sale') {
                //execute sale payment
                $this->execute_sale_payment($data_transaction, 'direct');
            } elseif ($mds_payment_type == 'promote') {
                //execute promote payment
                $this->execute_promote_payment($data_transaction, 'direct');
            }
        }
    }

    /**
     * Payment with Bank Transfer
     */
    public function bank_transfer_payment_post()
    {
        $mds_payment_type = $this->input->post('mds_payment_type', true);

        if ($mds_payment_type == 'promote') {
            $promoted_plan = $this->session->userdata('modesy_selected_promoted_plan');
            if (!empty($promoted_plan)) {
                //execute payment
                $this->promote_model->execute_promote_payment_bank($promoted_plan);

                $type = $this->session->userdata('mds_promote_product_type');

                if (empty($type)) {
                    $type = "new";
                }
                $transaction_number = $this->session->userdata('mds_promote_bank_transaction_number');
                redirect(generate_url("promote_payment_completed") . "?method=bank_transfer&transaction_number=" . $transaction_number . "&product_id=" . $promoted_plan->product_id);
            }
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect(generate_url("cart", "payment"));
        } else {
            //add order
            $order_id = $this->order_model->add_order_offline_payment("Bank Transfer");
            $order = $this->order_model->get_order($order_id);
            if (!empty($order)) {
                //decrease product quantity after sale
                $this->order_model->decrease_product_stock_after_sale($order->id);
                //send email
                if ($this->general_settings->send_email_buyer_purchase == 1) {
                    $email_data = array(
                        'email_type' => 'new_order',
                        'order_id' => $order_id
                    );
                    $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
                }

                if ($order->buyer_id == 0) {
                    $this->session->set_userdata('mds_show_order_completed_page', 1);
                    redirect(generate_url("order_completed") . "/" . $order->order_number);
                } else {
                    $this->session->set_flashdata('success', trans("msg_order_completed"));
                    redirect(generate_url("order_details") . "/" . $order->order_number);
                }
            }

            $this->session->set_flashdata('error', trans("msg_error"));
            redirect(generate_url("cart", "payment"));
        }
    }

    /**
     * Cash on Delivery
     */
    public function cash_on_delivery_payment_post()
    {
        //add order
        $order_id = $this->order_model->add_order_offline_payment("Cash On Delivery");
        $order = $this->order_model->get_order($order_id);
        if (!empty($order)) {
            //decrease product quantity after sale
            $this->order_model->decrease_product_stock_after_sale($order->id);
            //send email
            if ($this->general_settings->send_email_buyer_purchase == 1) {
                $email_data = array(
                    'email_type' => 'new_order',
                    'order_id' => $order_id
                );
                $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
            }

            if ($order->buyer_id == 0) {
                $this->session->set_userdata('mds_show_order_completed_page', 1);
                redirect(generate_url("order_completed") . "/" . $order->order_number);
            } else {
                $this->session->set_flashdata('success', trans("msg_order_completed"));
                redirect(generate_url("order_details") . "/" . $order->order_number);
            }
        }

        $this->session->set_flashdata('error', trans("msg_error"));
        redirect(generate_url("cart", "payment"));
    }

    /**
     * Execute Sale Payment
     */
    public function execute_sale_payment($data_transaction, $redirect_type = 'json_encode')
    {
        //add order
        $order_id = $this->order_model->add_order($data_transaction);
        $order = $this->order_model->get_order($order_id);
        if (!empty($order)) {
            //decrease product quantity after sale
            $this->order_model->decrease_product_stock_after_sale($order->id);
            //send email
            if ($this->general_settings->send_email_buyer_purchase == 1) {
                $email_data = array(
                    'email_type' => 'new_order',
                    'order_id' => $order_id
                );
                $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
            }
            //return json encode response
            if ($redirect_type == 'json_encode') {
                $data = array(
                    'result' => 1,
                    'redirect' => generate_url("order_details") . "/" . $order->order_number
                );
                if ($order->buyer_id == 0) {
                    $this->session->set_userdata('mds_show_order_completed_page', 1);
                    $data["redirect"] = generate_url("order_completed") . "/" . $order->order_number;
                } else {
                    $this->session->set_flashdata('success', trans("msg_order_completed"));
                }
                echo json_encode($data);
            } else {
                //return direct
                if ($order->buyer_id == 0) {
                    $this->session->set_userdata('mds_show_order_completed_page', 1);
                    redirect($lang_base_url . get_route("order_completed", true) . $order->order_number);
                } else {
                    $this->session->set_flashdata('success', trans("msg_order_completed"));
                    redirect($lang_base_url . get_route("order_details", true) . $order->order_number);
                }
            }
        } else {
            $this->session->set_flashdata('error', trans("msg_payment_database_error"));
            //return json encode response
            if ($redirect_type == 'json_encode') {
                $data = array(
                    'status' => 0,
                    'redirect' => generate_url("cart", "payment")
                );
                echo json_encode($data);
            } else {
                //return direct
                redirect($lang_base_url . get_route("cart", true) . get_route("payment"));
            }
        }
    }

    /**
     * Execute Promote Payment
     */
    public function execute_promote_payment($data_transaction, $redirect_type = 'json_encode')
    {
        $promoted_plan = $this->session->userdata('modesy_selected_promoted_plan');
        if (!empty($promoted_plan)) {
            //execute payment
            $this->promote_model->execute_promote_payment($data_transaction);
            //add to promoted products
            $this->promote_model->add_to_promoted_products($promoted_plan);

            //reset cache
            reset_cache_data_on_change();
            reset_user_cache_data($this->auth_user->id);

            //return json encode response
            if ($redirect_type == 'json_encode') {
                $data = array(
                    'result' => 1,
                    'redirect' => generate_url("promote_payment_completed") . "?method=gtw&product_id=" . $promoted_plan->product_id
                );
                echo json_encode($data);
            } else {
                redirect($lang_base_url . get_route("promote_payment_completed") . "?method=gtw&product_id=" . $promoted_plan->product_id);
            }
        } else {
            $this->session->set_flashdata('error', trans("msg_payment_database_error"));
            //return json encode response
            if ($redirect_type == 'json_encode') {
                $data = array(
                    'status' => 0,
                    'redirect' => generate_url("cart", "payment") . "?payment_type=promote"
                );
                echo json_encode($data);
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($lang_base_url . get_route("cart", true) . get_route("payment") . "?payment_type=promote");
            }
        }
    }

    /**
     * Order Completed
     */
    public function order_completed($order_number)
    {
        $order_id = $this->input->get('reference');
        $transaction_id = $this->input->get('checkout');
        
        if($transaction_id){
            $response = get_point_checkout_payment_status($transaction_id);
            // echo "<pre>"; print_r($response); die;
            if($response->success == true) {
                $status = $response->result->status;
                $this->order_model->update_order_status($order_id, $status);
            }
        }
        
        $this->session->unset_userdata('mds_cart_shipping_address');
        $this->cart_model->clear_cart();

        if (!empty($this->session->userdata('mds_default_location_id'))) {
            $data['country_id'] = $this->session->userdata('mds_default_location_id');
        } else {
            $data['country_id'] = 228;
        }

        
        // echo get_point_checkout_payment_url($order_number); die;
        $data['title'] = trans("msg_order_completed");
        $data['description'] = trans("msg_order_completed") . " - " . $this->app_name;
        $data['keywords'] = trans("msg_order_completed") . "," . $this->app_name;

        $data['order'] = $this->order_model->get_order_by_order_number($order_number);

        if (empty($data['order'])) {
            redirect(lang_base_url());
        }
        
        if (empty($this->session->userdata('mds_show_order_completed_page'))) {
            redirect(lang_base_url());
        }
        //die('ppppppkkkkkkk');
        $this->load->view('partials/_header', $data);
        $this->load->view('cart/order_completed', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Promote Payment Completed
     */
    public function promote_payment_completed()
    {
        $data['title'] = trans("msg_payment_completed");
        $data['description'] = trans("msg_payment_completed") . " - " . $this->app_name;
        $data['keywords'] = trans("payment") . "," . $this->app_name;
        $data['promoted_plan'] = $this->session->userdata('modesy_selected_promoted_plan');
        if (empty($data['promoted_plan'])) {
            redirect(lang_base_url());
        }

        $data["method"] = $this->input->get('method');
        $data["transaction_number"] = $this->input->get('transaction_number');

        $this->load->view('partials/_header', $data);
        $this->load->view('cart/promote_payment_completed', $data);
        $this->load->view('partials/_footer');
    }

}
