<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_admin_controller extends Admin_Core_Controller
{
	public function __construct()
	{
		parent::__construct();
		//check user
		if (!is_admin()) {
			redirect(admin_url() . 'login');
		}
	}

	/**
	 * return_and_refund_orders
	 */
	public function return_and_refund_orders()
	{
		$data['title'] = trans("return_and_refund_orders");
		$data['form_action'] = admin_url() . "return_and_refund_orders";

		$pagination = $this->paginate(admin_url() . 'return_and_refund_orders', $this->order_admin_model->get_return_orders_count());
		$data['orders'] = $this->order_admin_model->get_paginated_return_orders($pagination['per_page'], $pagination['offset']);
        $data['panel_settings'] = $this->settings_model->get_panel_settings();

		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/order/return_and_refund_orders', $data);
		$this->load->view('admin/includes/_footer');
	}

	/**
	 * Order Details
	 */
	public function return_order_details($id)
	{
		$data['title'] = trans("order");

		$data['order'] = $this->order_admin_model->get_order($id);
		if (empty($data['order'])) {
			redirect(admin_url() . "orders");
		}
		$shipping = get_order_shipping($data['order']->id);
		if(!empty($shipping))
		{
			$locationDetails=$this->location_model->get_country_byname($shipping->shipping_country);
		}
		if($locationDetails){
			$data['listproducts'] = $this->product_admin_model->get_productsbycountryid($locationDetails->id);
		} else {
			$data['listproducts'] = array();
		}
		

		//get_user($order->buyer_id)
		$data['order_products'] = $this->order_admin_model->get_order_products($id);
		$data['order_productss'] = $this->order_admin_model->get_order_productsvalid($id);
		
		if($data["order_productss"])
		{
			$datas['price_subtotal']=0;
			$datas['price_vat']=0;
			$datas['price_shipping']=0;
			$datas['price_total']=0;
			foreach($data["order_productss"] as $products)
			{
				
				$datas['price_subtotal']+= $products->product_unit_price*$products->product_quantity;
                $datas['price_vat']+= $products->product_vat;
                $datas['price_shipping']+= $products->product_shipping_cost;
                $datas['price_total']+=$products->product_total_price;
				
			}
			$this->order_model->update_order($datas,$id);
		
		}
		else
		{
			$datas['price_subtotal']=0;
			$datas['price_vat']=0;
			$datas['price_shipping']=0;
			$datas['price_total']=0;
			$this->order_model->update_order($datas,$id);
		}
        $data['panel_settings'] = $this->settings_model->get_panel_settings();

		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/order/return_order_details', $data);
		$this->load->view('admin/includes/_footer');
	}



	/**
	 * Orders
	 */
	public function orders()
	{
		$data['title'] = trans("orders");
		$data['form_action'] = admin_url() . "orders";

		$date_range = $this->input->get('date_range', true);
		if($date_range){
			$date_range_arr = explode(" - ", $date_range);
			$data['start'] = $date_range_arr[0];
			$data['to'] = $date_range_arr[1];
		}


		$pagination = $this->paginate(admin_url() . 'orders', $this->order_admin_model->get_orders_count());
		$data['orders'] = $this->order_admin_model->get_paginated_orders($pagination['per_page'], $pagination['offset']);
        $data['panel_settings'] = $this->settings_model->get_panel_settings();

		$data['countries'] = $this->order_admin_model->get_countries();
		// echo "<pre>"; print_r($data['countries']); die;
		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/order/orders', $data);
		$this->load->view('admin/includes/_footer');
	}

	/**
	 * Order Details
	 */
	public function order_details($id)
	{
		$data['title'] = trans("order");

		$data['order'] = $this->order_admin_model->get_order($id);
		if (empty($data['order'])) {
			redirect(admin_url() . "orders");
		}
		$shipping = get_order_shipping($data['order']->id);
		if(!empty($shipping))
		{
			$locationDetails=$this->location_model->get_country_byname($shipping->shipping_country);
		}else{
			$locationDetails = array();
		}

		if($locationDetails){
			$data['listproducts'] = $this->product_admin_model->get_productsbycountryid($locationDetails->id);
		} else {
			$data['listproducts'] = array();
		}
		
		//get_user($order->buyer_id)
		$data['order_products'] = $this->order_admin_model->get_order_products($id);
		$data['order_productss'] = $this->order_admin_model->get_order_productsvalid($id);
		
		if($data["order_productss"])
		{
			$datas['price_subtotal']=0;
			$datas['price_vat']=0;
			$datas['price_shipping']=0;
			$datas['price_total']=0;
			foreach($data["order_productss"] as $products)
			{
				
				$datas['price_subtotal']+= $products->product_unit_price*$products->product_quantity;
                $datas['price_vat']+= $products->product_vat;
                $datas['price_shipping']+= $products->product_shipping_cost;
                $datas['price_total']+=$products->product_total_price;
				
			}
			$this->order_model->update_order($datas,$id);
		
		}
		else
		{
			$datas['price_subtotal']=0;
			$datas['price_vat']=0;
			$datas['price_shipping']=0;
			$datas['price_total']=0;
			$this->order_model->update_order($datas,$id);
		}
		
		$data['recent_orders'] = $this->order_admin_model->get_order_by_userid($data['order']->buyer_id, $id);
		$data['order_tasks'] = $this->order_admin_model->get_order_task($id);
		$data['admin_users'] = $this->order_admin_model->get_user_by_role();
		// echo "<pre>"; print_r($data['admin_users']); die;
        $data['panel_settings'] = $this->settings_model->get_panel_settings();

		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/order/order_details', $data);
		$this->load->view('admin/includes/_footer');
	}
	/***
	*
	*Add product to existing order
	*/
	public function add_product_to_existingorder()
	{
		$order_id = $this->input->post('order_id', true);
		$product_id = $this->input->post('product_id', true);
		$quantity = $this->input->post('quantity', true);
		if($product_id)
		{
			$data=$this->product_model->get_product_by_id($product_id);
			$appended_variations = $this->cart_model->get_selected_variations($product_id)->str;
			$options_array = $this->cart_model->get_selected_variations($product_id)->options_array;
			if($options_array){
				$optionData=$this->variation_model->get_variation_option($options_array[0]);
			}
			
			$checkextrashippingcharge=$this->order_admin_model->get_order_productswithproduct($order_id,$product_id);
			$this->order_admin_model->add_order_products_to_existing_order($order_id,count($checkextrashippingcharge),$quantity,$data,$appended_variations);
			$order_productss = $this->order_admin_model->get_order_productsvalid($order_id);
			$this->order_model->add_invoice($order_id);
				if($order_productss)
				{
					$datas['price_subtotal']=0;
					$datas['price_vat']=0;
					$datas['price_shipping']=0;
					$datas['price_total']=0;
					foreach($order_productss as $products)
					{
						
						$datas['price_subtotal']+= $products->product_unit_price*$products->product_quantity;
						$datas['price_vat']+= $products->product_vat;
						$datas['price_shipping']+= $products->product_shipping_cost;
						$datas['price_total']+=$products->product_total_price;
						
					}
					$this->order_model->update_order($datas,$order_id);
				
				}
				else
				{
					$datas['price_subtotal']=0;
					$datas['price_vat']=0;
					$datas['price_shipping']=0;
					$datas['price_total']=0;
					$this->order_model->update_order($datas,$order_id);
				}
				$this->order_admin_model->update_order_status_if_completed($order_id);
			$this->session->set_flashdata('success', trans("msg_updated"));
			redirect($this->agent->referrer(),'location', 301);
		}
		
	
	}
	/**
	 * Order Options Post
	 */
	public function order_options_post()
	{
		$order_id = $this->input->post('id', true);
		$option = $this->input->post('option', true);

		if ($option == "payment_received") {
			$this->order_admin_model->update_order_payment_received($order_id);

			$this->order_admin_model->update_payment_status_if_all_received($order_id);
			$this->order_admin_model->update_order_status_if_completed($order_id);
		}

		$this->session->set_flashdata('success', trans("msg_updated"));
		redirect($this->agent->referrer());
	}

	/**
	 * Delete Order Post
	 */
	public function delete_order_post()
	{
		$id = $this->input->post('id', true);
		if ($this->order_admin_model->delete_order($id)) {
			$this->session->set_flashdata('success', trans("msg_deleted"));
		} else {
			$this->session->set_flashdata('error', trans("msg_error"));
		}
	}

	/**
	 * Update Order Product Status Post
	 */
	public function update_order_product_status_post()
	{
		$id = $this->input->post('id', true);
		//print_r($this->input->post('order_status'));die();
		$order_product = $this->order_admin_model->get_order_product($id);
		//print_r($order_product->order_id);die();
		if (!empty($order_product)) {
			if ($this->order_admin_model->update_order_product_status($order_product->id)) {

				$order_status = $this->input->post('order_status', true);
				if ($order_product->product_type == "digital") {
					if ($order_status == 'completed' || $order_status == 'payment_received') {
						$this->order_model->add_digital_sale($order_product->product_id, $order_product->order_id);
						//add seller earnings
						$this->earnings_model->add_seller_earnings($order_product);
					}
				} else {
					if ($order_status == 'completed') {
						//add seller earnings
						$this->earnings_model->add_seller_earnings($order_product);
					} else {
						//check if earning added before
						$order = $this->order_admin_model->get_order($order_product->order_id);
						if (!empty($order) && !empty($this->earnings_model->get_earning_by_user_id($order_product->seller_id, $order->order_number))) {
							//remove seller earnings
							$this->earnings_model->remove_seller_earnings($order_product);
						}
					}
				}
				$this->session->set_flashdata('success', trans("msg_updated"));
			} else {
				$this->session->set_flashdata('error', trans("msg_error"));
			}

			$this->order_admin_model->update_payment_status_if_all_received($order_product->order_id);
			$this->order_admin_model->update_order_status_if_completed($order_product->order_id);
		}
		redirect($this->agent->referrer(),'refresh');
	}
	

	/**
	 * Update Order refund values Post
	 */
	public function update_order_refund_values_post()
	{
		$id = $this->input->post('id', true);
		
		if ($this->order_admin_model->update_order_refund_values()) {
			
			$this->session->set_flashdata('success', trans("msg_updated"));
		} else {
			$this->session->set_flashdata('error', trans("msg_error"));
		}
		redirect($this->agent->referrer(),'refresh');
	}

	/**
	 * create task Post
	 */
	public function create_task_post()
	{		
		if ($this->order_admin_model->create_order_task()) {
			
			$this->session->set_flashdata('success', trans("msg_updated"));
		} else {
			$this->session->set_flashdata('error', trans("msg_error"));
		}
		redirect($this->agent->referrer(),'refresh');
	}

	/**
	 * update task Post
	 */
	public function update_task_post()
	{		
		if ($this->order_admin_model->update_order_task()) {
			
			$this->session->set_flashdata('success', trans("msg_updated"));
		} else {
			$this->session->set_flashdata('error', trans("msg_error"));
		}
		redirect($this->agent->referrer(),'refresh');
	}

	/**
	 * Delete Order Product Post
	 */
	public function delete_order_product_post()
	{
		$id = $this->input->post('id', true);
		if ($this->order_admin_model->delete_order_product($id)) {
			$this->session->set_flashdata('success', trans("msg_deleted"));
		} else {
			$this->session->set_flashdata('error', trans("msg_error"));
		}
	}

	/**
	 * Transactions
	 */
	public function transactions()
	{
		$data['title'] = trans("transactions");
		$data['form_action'] = admin_url() . "transactions";

		$pagination = $this->paginate(admin_url() . 'transactions', $this->transaction_model->get_transactions_count());
		$data['transactions'] = $this->transaction_model->get_paginated_transactions($pagination['per_page'], $pagination['offset']);
        $data['panel_settings'] = $this->settings_model->get_panel_settings();

		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/order/transactions', $data);
		$this->load->view('admin/includes/_footer');
	}

	/**
	 * Delete Transaction Post
	 */
	public function delete_transaction_post()
	{
		$id = $this->input->post('id', true);
		if ($this->transaction_model->delete_transaction($id)) {
			$this->session->set_flashdata('success', trans("msg_deleted"));
		} else {
			$this->session->set_flashdata('error', trans("msg_error"));
		}
	}

	/**
	 * Bank Transfer Notifications
	 */
	public function order_bank_transfers()
	{
		$data['title'] = trans("bank_transfer_notifications");
		$data['form_action'] = admin_url() . "order-bank-transfers";

		$pagination = $this->paginate(admin_url() . 'order-bank-transfers', $this->order_admin_model->get_bank_transfers_count());
		$data['bank_transfers'] = $this->order_admin_model->get_paginated_bank_transfers($pagination['per_page'], $pagination['offset']);

		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/order/bank_transfers', $data);
		$this->load->view('admin/includes/_footer');
	}

	/**f
	 * Bank Transfer Options Post
	 */
	public function bank_transfer_options_post()
	{
		$id = $this->input->post('id', true);
		$order_id = $this->input->post('order_id', true);
		$option = $this->input->post('option', true);
		if ($this->order_admin_model->update_bank_transfer_status($id, $option)) {
			if ($option == 'approved') {
				$this->order_admin_model->update_order_payment_received($order_id);
			}
			$this->order_admin_model->update_order_status_if_completed($order_id);
			$this->session->set_flashdata('success', trans("msg_updated"));
			redirect($this->agent->referrer());
		} else {
			$this->session->set_flashdata('error', trans("msg_error"));
			redirect($this->agent->referrer());
		}
	}
	
	/**
	 * Update Shipping Address
	 */
	public function edit_shipping_address()
	{	
		$order_id = $this->input->post('order_id', true);
		$this->order_admin_model->update_shipping_address($order_id);
		redirect($this->agent->referrer());
	}
	
	/**
	 * Approve Guest Order Product
	 */
	public function approve_guest_order_product()
	{
		$order_product_id = $this->input->post('order_product_id', true);
		if ($this->order_admin_model->approve_guest_order_product($order_product_id)) {
			//order product
			$order_product = $this->order_admin_model->get_order_product($order_product_id);
			//add seller earnings
			$this->earnings_model->add_seller_earnings($order_product);
			//update order status
			$this->order_admin_model->update_order_status_if_completed($order_product->order_id);
		}
		redirect($this->agent->referrer());
	}

	/**
	 * Delete Bank Transfer Post
	 */
	public function delete_bank_transfer_post()
	{
		$id = $this->input->post('id', true);
		if ($this->order_admin_model->delete_bank_transfer($id)) {
			$this->session->set_flashdata('success', trans("msg_deleted"));
		} else {
			$this->session->set_flashdata('error', trans("msg_error"));
		}
	}

    /**
     * Invoices
     */
    public function invoices()
    {
        $data['title'] = trans("invoices");
        $data['form_action'] = admin_url() . "invoices";

        $pagination = $this->paginate(admin_url() . 'invoices', $this->order_admin_model->get_invoices_count());
        $data['invoices'] = $this->order_admin_model->get_paginated_invoices($pagination['per_page'], $pagination['offset']);
        $data['panel_settings'] = $this->settings_model->get_panel_settings();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/order/invoices', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Order Follow Up
     */
    public function order_follw_up()
    {
        $data['title'] = trans("order_follw_up");
        $data['form_action'] = admin_url() . "order_follw_up";

        $pagination = $this->paginate(admin_url() . 'order-follw-up', $this->order_admin_model->get_today_task_count());
        $data['order_follw_up'] = $this->order_admin_model->get_paginated_today_task($pagination['per_page'], $pagination['offset']);
        $data['panel_settings'] = $this->settings_model->get_panel_settings();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/order/order_follw_up', $data);
        $this->load->view('admin/includes/_footer');
    }
	
    /**
     * My Task List
     */
    public function my_task()
    {
		
        $data['title'] = trans("my_task");
        $data['form_action'] = admin_url() . "my_task";

        $pagination = $this->paginate(admin_url() . 'my_task', $this->order_admin_model->get_today_mytask_count());
        $data['order_follw_up'] = $this->order_admin_model->get_paginated_today_mytask($pagination['per_page'], $pagination['offset']);
        $data['panel_settings'] = $this->settings_model->get_panel_settings();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/order/my_task', $data);
        $this->load->view('admin/includes/_footer');
    }

	/**
     * Task List
     */
    public function get_task_by_id($id=0)
    {
        $result = $this->order_admin_model->get_task_by_id($id);
		echo json_encode($result);
    }

	/**
	 * Digital Sales
	 */
	public function digital_sales()
	{
		$data['title'] = trans("digital_sales");
		$data['form_action'] = admin_url() . "digital-sales";

		$pagination = $this->paginate(admin_url() . 'digital-sales', $this->order_admin_model->get_digital_sales_count());
		$data['digital_sales'] = $this->order_admin_model->get_digital_sales($pagination['per_page'], $pagination['offset']);
        $data['panel_settings'] = $this->settings_model->get_panel_settings();

		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/order/digital_sales', $data);
		$this->load->view('admin/includes/_footer');
	}

	/**
	 * Delete Digital Sales Post
	 */
	public function delete_digital_sales_post()
	{
		$id = $this->input->post('id', true);
		if ($this->order_admin_model->delete_digital_sale($id)) {
			$this->session->set_flashdata('success', trans("msg_deleted"));
		} else {
			$this->session->set_flashdata('error', trans("msg_error"));
		}
	}
	/**
	 * Select Product Variations
	 */
	public function product_variations($id)
	{
		$data["half_width_product_variations"] = $this->variation_model->get_half_width_product_variations($id);
		$data["full_width_product_variations"] = $this->variation_model->get_full_width_product_variations($id);
		$data["product_images"] = $this->file_model->get_product_images($id);
		$data["product"] = $this->product_model->get_product_by_id($id);
		if (!empty($data["full_width_product_variations"] )):
			foreach ($data["full_width_product_variations"]  as $variation):
				$this->load->view('admin/order/product_variations', ['variation' => $variation,'product'=>$data["product"],'product_images'=>$data["product_images"]]);
			endforeach;
		endif;
		if (!empty($data["half_width_product_variations"])):
			foreach ($data["half_width_product_variations"] as $variation):
				$this->load->view('admin/order//product_variations', ['variation' => $variation,'product'=>$data["product"],'product_images'=>$data["product_images"]]);
			endforeach;
		endif; 

	}
	
}