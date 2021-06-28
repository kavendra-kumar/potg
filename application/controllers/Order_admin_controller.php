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
		$data['form_action_export'] = admin_url() . "order_admin_controller/orders_export";
		$data['start'] = "";
		$data['to'] = "";
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
		//echo "<pre>"; print_r($data['orders']); die;
		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/order/orders', $data);
		$this->load->view('admin/includes/_footer');
	}


	/**
	 * selected Orders export
	 */
	public function orders_export()
	{
		$order_ids = $this->input->post('order_ids', true);
		
		if($order_ids) {

			$orders = $this->order_admin_model->get_orders_export($order_ids);

			if($orders) {
				$data = array();
				$i = 0;
				$data[] = array(
					'order_number' => 'Order Number',
					'name' => 'Name',
					'shipping_phone_number' => 'Phone Number',
					'shipping_email' => 'Email',
					'shipping_address_1' => 'Address',
					'shipping_city' => 'City',
					'shipping_country' => 'Country',
					'gps_location' => 'GPS Location',
					'product_title' => 'products title',
					'sku' => 'SKU',
					'product_quantity' => 'Qty',
					'price_vat' => 'Vat',
					'price_shipping' => 'shipping cost',
					'price_total' => 'Total Amount',
					'custom_value' => 'Custom Value',
					'payment_status' => 'Payment Status',
					'price_currency' => 'Currency',
					'assign_to' => 'Assign To',
					'created_at' => 'Created At',
					'recent_order_number' => 'Recent Order Number',
					'recent_order_status' => 'Recent Order Status',
					
				);
				foreach($orders as $obj) {
					//echo "<pre>";  print_r($obj); die;
					$minus_per = $obj->price_total * 30 / 100;
					$custom_value = ($obj->price_total - $minus_per)/100;

					// get ordered product info..
					$products = $this->order_admin_model->get_order_products_by_order_id($obj->id);
					//echo "<pre>"; print_r($products); exit;
					$product_title = '';
					$product_quantity = '';
					$sku = '';

					$product_title_arr = array();
					$product_quantity_arr = array();
					$sku_arr = array();
					if($products){
						foreach($products as $prod){
							$product_title_arr[] = $prod->short_title;
							$product_quantity_arr[] = $prod->product_quantity;
							$sku_arr[] = $prod->sku;
						}
						$product_title = implode(' | ', $product_title_arr);
						$product_quantity = implode(' | ', $product_quantity_arr);
						$sku = implode(' | ', $sku_arr);
					}


					// get recent orders
					$recent_orders = $this->order_admin_model->get_order_by_userid($obj->buyer_id, $obj->id);
					$rec_order_number = '';
					$rec_status = '';

					$order_number_arr = array();
					$status_arr = array();
					if($recent_orders){
						foreach($recent_orders as $recent){
														
							if ($recent->status == 1):
								$recent_status = trans("completed");
							elseif ($recent->status == 2):
								$recent_status = trans("confirmed");
							elseif ($recent->status == 3):
								$recent_status = trans("cancelled");
							elseif ($recent->status == 4):
								$recent_status = trans("shipped");
							elseif ($recent->status == 5):
								$recent_status = trans("payment_received");
							elseif ($recent->status == 6):
								$recent_status = trans("awaiting_payment");
							elseif ($recent->status == 7):
								$recent_status = trans("recent_processing");
							elseif ($recent->status == 8):
								$recent_status = $recent_status = trans("scheduled");
							elseif ($recent->status == 9):
								$recent_status = trans("returned");
							elseif ($recent->status == 10):
								$recent_status = trans("return_and_refund_request");
							else:
								$recent_status = trans("new");
							endif;

							$order_number_arr[] = $recent->order_number;
							$status_arr[] = $recent_status;
						}
						$rec_order_number = implode(' | ', $order_number_arr);
						$rec_status = implode(' | ', $status_arr);
					}

					$Number  = ($obj->shipping_phone_number) ? $obj->shipping_phone_number:'';

					if($obj->assign_to) {
						$inf = get_user($obj->assign_to);
                        $contact_person = $inf->first_name.' '.$inf->last_name;
					} else {
						$contact_person = '';
					}

					$data[] = array(
						'order_number' => ($obj->order_number)?$obj->order_number:'',
						'name' => ($obj->shipping_first_name ? $obj->shipping_first_name:'').' '.($obj->shipping_last_name ?$obj->shipping_last_name:''),
						'shipping_phone_number' => '="' . $Number . '"',
						'shipping_email' => ($obj->shipping_email)?$obj->shipping_email:'',
						'shipping_address_1' => ($obj->shipping_address_1 ? $obj->shipping_address_1:'') . ($obj->shipping_address_2 ? ' | '.$obj->shipping_address_2:''),
						'shipping_city' => ($obj->shipping_city)?$obj->shipping_city:'',
						'shipping_country' => ($obj->shipping_country)?$obj->shipping_country:'',
						'gps_location' => ($obj->gps_location)?$obj->gps_location:'',
						'product_title' => $product_title,
						'sku' => $sku,
						'product_quantity' => $product_quantity,
						'price_vat' => ($obj->price_vat)?$obj->price_vat/100:'0',
						'price_shipping' => ($obj->price_shipping)?$obj->price_shipping/100:'0',
						'price_total' => ($obj->price_total)?$obj->price_total/100:'0',
						'custom_value' => number_format($custom_value, 2),
						'payment_status' => trans($obj->payment_status),
						'price_currency' => ($obj->price_currency)?$obj->price_currency:'',
						'assign_to' => $contact_person,
						'created_at' => ($obj->created_at)?$obj->created_at:'',
						'recent_order_number' => $rec_order_number,
						'recent_order_status' => $rec_status
					);
					$i++;
				}
				// echo "<pre>";  print_r($data); die;
				
				// header("Content-type: application/csv");
				// header("Content-Disposition: attachment; filename=\"orders_export".".csv\"");
				// header("Pragma: no-cache");
				// header("Expires: 0");
				
				header('Content-Encoding: UTF-8');
				header('Content-type: text/csv; charset=UTF-8');
				header('Content-Disposition: attachment; filename=orders_export.csv');
				echo "\xEF\xBB\xBF"; // UTF-8 BOM
				

				$handle = fopen('php://output', 'w');

				foreach ($data as $data_array) {
					fputcsv($handle, $data_array);
				}
					fclose($handle);
				
				exit;
				
			}
			
		}
		
		redirect($this->agent->referrer(),'refresh');
	}


	/**
	 * all Orders export
	 */
	public function all_orders_export()
	{
		$orders = $this->order_admin_model->get_all_orders_export();

		if($orders) {
			$data = array();
			$i = 0;
			$data[] = array(
				'order_number' => 'Order Number',
				'name' => 'Name',
				'shipping_phone_number' => 'Phone Number',
				'shipping_email' => 'Email',
				'shipping_address_1' => 'Address',
				'shipping_city' => 'City',
				'shipping_country' => 'Country',
				'gps_location' => 'GPS Location',
				'product_title' => 'products title',
				'sku' => 'SKU',
				'product_quantity' => 'Qty',
				'price_vat' => 'Vat',
				'price_shipping' => 'shipping cost',
				'price_total' => 'Total Amount',
				'custom_value' => 'Custom Value',
				'payment_status' => 'Payment Status',
				'price_currency' => 'Currency',
				'assign_to' => 'Assign To',
				'created_at' => 'Created At',
				'recent_order_number' => 'Recent Order Number',
				'recent_order_status' => 'Recent Order Status',
			);

			foreach($orders as $obj) {
				//echo "<pre>";  print_r($obj); die;
				$minus_per = $obj->price_total * 30 / 100;
				$custom_value = ($obj->price_total - $minus_per)/100;

				// get ordered products info..
				$products = $this->order_admin_model->get_order_products_by_order_id($obj->id);
				$product_title = '';
				$product_quantity = '';
				$sku = '';

				$product_title_arr = array();
				$product_quantity_arr = array();
				$sku_arr = array();
				if($products){
					foreach($products as $prod){
						$product_title_arr[] = $prod->short_title;
						$product_quantity_arr[] = $prod->product_quantity;
						$sku_arr[] = $prod->sku;
					}
					$product_title = implode(' | ', $product_title_arr);
					$product_quantity = implode(' | ', $product_quantity_arr);
					$sku = implode(' | ', $sku_arr);
				}
			

				// get recent orders
				$recent_orders = $this->order_admin_model->get_order_by_userid($obj->buyer_id, $obj->id);
				$rec_order_number = '';
				$rec_status = '';

				$order_number_arr = array();
				$status_arr = array();
				if($recent_orders){
					foreach($recent_orders as $recent){
													
						if ($recent->status == 1):
							$recent_status = trans("completed");
						elseif ($recent->status == 2):
							$recent_status = trans("confirmed");
						elseif ($recent->status == 3):
							$recent_status = trans("cancelled");
						elseif ($recent->status == 4):
							$recent_status = trans("shipped");
						elseif ($recent->status == 5):
							$recent_status = trans("payment_received");
						elseif ($recent->status == 6):
							$recent_status = trans("awaiting_payment");
						elseif ($recent->status == 7):
							$recent_status = trans("recent_processing");
						elseif ($recent->status == 8):
							$recent_status = $recent_status = trans("scheduled");
						elseif ($recent->status == 9):
							$recent_status = trans("returned");
						elseif ($recent->status == 10):
							$recent_status = trans("return_and_refund_request");
						else:
							$recent_status = trans("new");
						endif;

						$order_number_arr[] = $recent->order_number;
						$status_arr[] = $recent_status;
					}
					$rec_order_number = implode(' | ', $order_number_arr);
					$rec_status = implode(' | ', $status_arr);
				}

				$Number  = ($obj->shipping_phone_number) ? $obj->shipping_phone_number:'';
				if($obj->assign_to) {
					$inf = get_user($obj->assign_to);
					$contact_person = $inf->first_name.' '.$inf->last_name;
				} else {
					$contact_person = '';
				}

				$data[] = array(
					'order_number' => ($obj->order_number)?$obj->order_number:'',
					'name' => ($obj->shipping_first_name ? $obj->shipping_first_name:'').' '.($obj->shipping_last_name ?$obj->shipping_last_name:''),
					'shipping_phone_number' => '="' . $Number . '"',
					'shipping_email' => ($obj->shipping_email)?$obj->shipping_email:'',
					'shipping_address_1' => ($obj->shipping_address_1 ? $obj->shipping_address_1:'') . ($obj->shipping_address_2 ? ' | '.$obj->shipping_address_2:''),
					'shipping_city' => ($obj->shipping_city)?$obj->shipping_city:'',
					'shipping_country' => ($obj->shipping_country)?$obj->shipping_country:'',
					'gps_location' => ($obj->gps_location)?$obj->gps_location:'',
					'product_title' => $product_title,
					'sku' => $sku,
					'product_quantity' => $product_quantity,
					'price_vat' => ($obj->price_vat)?$obj->price_vat/100:'0',
					'price_shipping' => ($obj->price_shipping)?$obj->price_shipping/100:'0',
					'price_total' => ($obj->price_total)?$obj->price_total/100:'0',
					'custom_value' => number_format($custom_value, 2),
					'payment_status' => trans($obj->payment_status),
					'price_currency' => ($obj->price_currency)?$obj->price_currency:'',
					'assign_to' => $contact_person,
					'created_at' => ($obj->created_at)?$obj->created_at:'',
					'recent_order_number' => $rec_order_number,
					'recent_order_status' => $rec_status
				);
				$i++;
			}
			//echo "<pre>";  print_r($data); die;
			
			// header("Content-type: application/csv");
			// header("Content-Disposition: attachment; filename=\"orders_export".".csv\"");
			// header("Pragma: no-cache");
			// header("Expires: 0");
			
			header('Content-Encoding: UTF-8');
			header('Content-type: text/csv; charset=UTF-8');
			header('Content-Disposition: attachment; filename=all_orders_export.csv');
			echo "\xEF\xBB\xBF"; // UTF-8 BOM
			

			$handle = fopen('php://output', 'w');

			foreach ($data as $data_array) {
				fputcsv($handle, $data_array);
			}
				fclose($handle);
			
			exit;
			
		}
		
		redirect($this->agent->referrer(),'refresh');
	}

	/**
	 * Order Details
	 */
	public function order_details($id)
	{
		$data['title'] = trans("order");

		$data['order'] = $this->order_admin_model->get_order($id);
		//echo "<pre>"; print_r($data['order']); exit;
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
			$discount = $this->order_admin_model->get_order_discount($id);
			if($discount) {
				if($discount['discount_type'] == 'fix-amount') {
					
					$datas['price_total'] = (($datas['price_total']/100) - $discount['total_discount'])*100;
					//echo $datas['price_total']; die;
				} else {
					$disc_per = ($datas['price_subtotal']/100) * $discount['total_discount'] / 100;
					$datas['price_total'] = (($datas['price_total']/100) - $disc_per)*100;
				}
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

        $data['ShipmentCustomDetail'] = $this->order_admin_model->get_custom_order_details($id);
        $data['getDiscount'] = $this->order_admin_model->get_order_discount($id);
        $data['getCustomDiscount'] = $this->order_admin_model->get_custom_code_amount($id);
		
		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/order/order_details', $data);
		$this->load->view('admin/includes/_footer');
	}



	/**
	 * shipping servise smsa (generate awb)
	 */
	public function generate_awb($Number)
	{
		

		$order = $this->order_admin_model->get_order_by_order_number($Number);
		//echo "<pre>"; print_r($order); exit;

		if($order->awb_number!=""){
			$Number = $Number.'-'.rand(10,99);
		}
		$shipping = get_order_shipping($order->id);
		$productss = $this->order_admin_model->get_order_products($order->id);
		$pcs = 0;
		$product_name = array();

		if($productss){
			foreach($productss as $products)
			{
				if($products->order_status != 'cancelled'){
					$product_name[] = $products->product_title;
					$pcs = $pcs + $products->product_quantity;
				}
			}
		}

		// print_r($product_name); die;

		$total = $order->price_total;

		if($order->payment_method == 'Point Checkout' && $order->payment_status == "payment_received") {
			$total = 0;
		}

		$minus_per = $order->price_total * 30 / 100;
		$custom_value = ($order->price_total - $minus_per)/100;

		$currency = $order->price_currency;

		$country = $shipping->shipping_country;

		$passkey="";

		// if($country == "Oman"){
		// 	$passkey = 'pMt@3423';
		// }

		//echo $country."--".$passkey; exit;
		$getCustomCodAmount = array();
		//		echo $country;
		if($country == "United Arab Emirates") {

			
			$passkey = 'PmG@5125';

		} elseif ($country == "Saudi Arabia") {

			$passkey = 'pMt@3423';

		} elseif ($country == "Oman") {
		
			$getCustomCodAmount = $this->order_admin_model->get_custom_code_amount($order->id);
			if(!empty($getCustomCodAmount)){
				$custom_value = $getCustomCodAmount['customAmount'];
				$currency = 'USD';
			}
			
			$passkey = 'PmG@3717';

		} elseif ($country == "Kuwait") {

			$passkey = 'pGt@3424';

		} elseif ($country == "Bahrain") {

			$passkey = 'Pmg@3425';

		} 

		

		//$customsCost = ($total/30)*100; 
		$arguments = array('passKey' => $passkey);
		$arguments['refNo'] = $Number;
		$arguments['sentDate'] = date("Y-m-d H:i:s");
		$arguments['idNo'] = '0';
		$arguments['cName'] = ($shipping->shipping_first_name ? $shipping->shipping_first_name.' ':'') . ($shipping->shipping_last_name ? $shipping->shipping_last_name.' ':'');
		$arguments['cntry'] = $country;
		$arguments['cCity'] = $shipping->shipping_city ? $shipping->shipping_city : '';
		$arguments['cZip'] = $shipping->shipping_zip_code ? $shipping->shipping_zip_code : '';
		$arguments['cPOBox'] = '';
		$arguments['cMobile'] = $shipping->shipping_phone_number ? $shipping->shipping_phone_number : '';
		$arguments['cTel1'] = '';
		$arguments['cTel2'] = '';
		$arguments['cAddr1'] = $shipping->shipping_address_1 ? $shipping->shipping_address_1 : '';
		$arguments['cAddr2'] = $shipping->shipping_address_2 ? $shipping->shipping_address_2 : '';
		$arguments['shipType'] = 'DLV';
		$arguments['PCs'] = $pcs;
		$arguments['cEmail'] = '';
		$arguments['carrValue'] = '0';
		$arguments['carrCurr'] = $currency;
		$arguments['codAmt'] = $total/100;
		$arguments['weight'] = '1';
		$arguments['custVal'] = $custom_value;
		$arguments['custCurr'] = $currency;
		$arguments['insrAmt'] = '0';
		$arguments['insrCurr'] = $currency;
		$arguments['itemDesc'] = implode(' | ', $product_name);

		//echo "<pre>"; print_r($arguments); 

		$output =    makeSoapCall('addShipment', $arguments);
		//echo "<pre>"; print_r($output); exit;
		echo $awb_number = $output->addShipmentResult;

		if($order->awb_number==""){

			$this->db->set('awb_number', $awb_number);
			$this->db->where('id', $order->id);
			$this->db->update('orders');

		} else {
			
			$updated_awb_number = $order->awb_number.','.$awb_number;
			$this->db->set('awb_number',$updated_awb_number);
			$this->db->where('id', $order->id);
			$this->db->update('orders');
		}
		
		//echo $awb_number; exit;

		$this->session->set_flashdata('success', trans("msg_updated"));
		redirect($this->agent->referrer(),'location', 301);
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

				$this->order_admin_model->update_order_product_status_track($order_product->id, $order_product->order_id);

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

			if($order_status == 'awaiting_payment' or $order_status == 'payment_received') {
				$this->order_admin_model->update_payment_status_if_all_received($order_product->order_id);
			}
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


	public function create_custom_shipment(){

		$this->order_admin_model->addCustomShipmentDetails($this->input->post());
		$this->session->set_flashdata('success', trans("msg_updated"));
		redirect($this->agent->referrer());
		//echo "<pre>"; print_r($this->input->post()); exit;
	}



	/** Create Order*/
	public function createOrder(){
		$data['products'] = $this->product_admin_model->get_products();
		//echo "<pre>"; print_r($data['products']); exit;
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/order/create_order');
		$this->load->view('admin/includes/_footer');
	}

	/*Update smsa old order*/

	public function UpdateOrderId() {
		//echo "test"; exit;
     $query = $this->db->select("*")->from("overall_orders_list_with_status")->get()->result_array();

     foreach ($query as $key => $value) {
     	//echo "<pre>"; print_r($value);  exit;

     	$resultTest = $this->db->select("*")->from("orders")->where("order_number",$value['Orders_Numbers'])->get()->row_array();

     	if(!empty($resultTest) && $resultTest['awb_number']=="") {

     		$data=  array('awb_number' => $value['AWB'],
     					  'smsa_order_status'=>$value['Final_Status'],
     					  'order_smsa_type'=>$value['Courier'] 
     				);

     		//echo "<pre>"; print_r($data); exit;
     		$this->db->where('order_number',$value['Orders_Numbers']);
			$this->db->update('orders', $data);
     	}

     	//echo "<pre>"; print_r($resultTest); exit;

     }
		//$query = $this->db->get('overall_orders_list_with_status');
		
	}


	#For manage discount
	public function createDiscount(){

		$this->order_admin_model->create_order_discount($this->input->post());
		$this->session->set_flashdata('success', trans("msg_updated"));
		redirect('admin/orders');
		// redirect($this->agent->referrer());
	}



	public function addCustomCodAmount() {
		
		$this->order_admin_model->addCustomCodAmount($this->input->post());
		$this->session->set_flashdata('success', trans("msg_updated"));
		redirect($this->agent->referrer());

		
	}

	/**
	 * Assign contact person Post
	 */
	public function assign_contact_person()
	{
		if ($this->order_admin_model->assign_contact_person()) {
			
			$this->session->set_flashdata('success', trans("msg_updated"));
		} else {
			$this->session->set_flashdata('error', trans("msg_error"));
		}
		redirect($this->agent->referrer(),'refresh');
	}
	
}