<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * ORDER STATUS
 *
 * 1. awaiting_payment
 * 2. payment_received
 * 3. order_processing
 * 4. shipped
 * 5. completed
 * 6. cancelled
 */

class Order_admin_model extends CI_Model
{
    //update order payment as received
    public function update_order_payment_received($order_id)
    {
        $order_id = clean_number($order_id);
        $order = $this->get_order($order_id);
        if (!empty($order)) {
            //update product payment status
            $data_order = array(
                'payment_status' => "payment_received",
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $this->db->where('id', $order_id);
            $this->db->update('orders', $data_order);

            //update order products payment status
            $order_products = $this->get_order_products($order_id);
            if (!empty($order_products)) {
                foreach ($order_products as $order_product) {
                    $data = array(
                        'order_status' => "payment_received",
                        'updated_at' => date('Y-m-d H:i:s'),
                    );
                    if ($order_product->product_type == 'digital') {
                        $data['order_status'] = 'completed';
                        //add digital sale
                        $this->order_model->add_digital_sale($order_product->product_id, $order_id);
                        //add seller earnings
                        $this->earnings_model->add_seller_earnings($order_product);
                    }
                    $this->db->where('id', $order_product->id);
                    $this->db->update('order_products', $data);
                }
            }
        }
    }

    //update order product status
    public function update_order_product_status($order_product_id)
    {
        $order_product_id = clean_number($order_product_id);
        $order_product = $this->get_order_product($order_product_id);
        if (!empty($order_product)) {
            $data = array(
                'order_status' => $this->input->post('order_status', true),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            if ($data["order_status"] == "completed" || $data["order_status"] == "cancelled") {
                $data['is_approved'] = 1;
            } else {
                $data['is_approved'] = 0;
            }

            $this->db->where('id', $order_product_id);
            return $this->db->update('order_products', $data);
        }
        return false;
    }

    //check order products status / update if all suborders completed
    public function update_order_status_if_completed($order_id)
    {
        $order_id = clean_number($order_id);
       // $all_complated = true;
        $order_products = $this->get_order_products($order_id);
       
        if (!empty($order_products)) {
            $statuscancelledcount=0;
            $statusconfirmedcount=0;
            $statuscompletedcount=0;
            $statusshippedcount=0;
            $statusprocessingcount=0;
            $statuspaymentreceivedcount=0;
            $statusawaitedpaymentcount=0;
            $statuscount=0;
            foreach ($order_products as $order_product) {
               
                    if($order_product->order_status=='cancelled')
                    {
                        $statuscancelledcount+=1;
                    }
                    if($order_product->order_status=='confirmed')
                    {
                        $statusconfirmedcount+=1;
                    }
                    if($order_product->order_status=='completed')
                    {
                        $statuscompletedcount+=1;
                    }
                    if($order_product->order_status=='shipped')
                    {
                        $statusshippedcount+=1;
                    }
                    if($order_product->order_status=='order_processing')
                    {
                        $statusprocessingcount+=1;
                    }
                    if($order_product->order_status=='payment_received')
                    {
                        $statuspaymentreceivedcount+=1;
                    }
                    if($order_product->order_status=='awaiting_payment')
                    {
                        $statusawaitedpaymentcount+=1;
                    }
                    if($order_product->order_status!='confirmed' && $order_product->order_status!='cancelled')
                    {
                        $statuscount=1;
                    }
                    
                }
                $productcount=count($order_products);
           //echo $statusprocessingcount;die();
            /********Start Of processing ***/        
			if($statusprocessingcount==$productcount)
			{ 
				$updateStatus['status']=0;//processing
            }
            elseif($statusprocessingcount>$statuscancelledcount && ($statuscancelledcount+$statusprocessingcount==$productcount))
			{
				$updateStatus['status']=0;//processing
			}
			elseif($statusprocessingcount==$statuscancelledcount && ($statuscancelledcount+$statusprocessingcount==$productcount))
			{
				$updateStatus['status']=0;//processing
			}
			elseif($statusprocessingcount<$statuscancelledcount && $statusprocessingcount!=0 && ($statuscancelledcount+$statusprocessingcount==$productcount))
			{
				$updateStatus['status']=0;//processing
            }
            /********End Of processing ***/
            /********Start Of completed ***/
            elseif($statuscompletedcount==$productcount)
			{
				$updateStatus['status']=1;//completed
            }
            elseif($statuscompletedcount>$statuscancelledcount && ($statuscancelledcount+$statuscompletedcount==$productcount))
			{
				$updateStatus['status']=1;//completed
			}
			elseif($statuscompletedcount==$statuscancelledcount && ($statuscancelledcount+$statuscompletedcount==$productcount))
			{
				$updateStatus['status']=1;//completed
			}
			elseif($statuscompletedcount<$statuscancelledcount  && $statuscompletedcount!=0  && ($statuscancelledcount+$statuscompletedcount==$productcount))
			{
				$updateStatus['status']=1;//completed
            }
            /********End Of completed ***/
            /********Start Of Confirmed ***/
            elseif($statusconfirmedcount==$productcount)
			{
				$updateStatus['status']=2;//confirmed
            }
            elseif($statusconfirmedcount>$statuscancelledcount && ($statuscancelledcount+$statusconfirmedcount==$productcount))
			{
				$updateStatus['status']=2;//confirmed
			}
			elseif($statusconfirmedcount==$statuscancelledcount && ($statuscancelledcount+$statusconfirmedcount==$productcount))
			{
				$updateStatus['status']=2;//confirmed
			}
			elseif($statusconfirmedcount<$statuscancelledcount && $statusconfirmedcount!=0  && ($statuscancelledcount+$statusconfirmedcount==$productcount))
			{
				$updateStatus['status']=2;//confirmed
            }
            /****End Of Confirmed ***/
            /****Start Of Cancelled ***/
			elseif($statuscancelledcount==$productcount)
			{
               $updateStatus['status']=3;//cancelled
            }
            /****End Of Cancelled ***/
             /****Start Of shipped ***/
             elseif($statusshippedcount==$productcount)
			{
				$updateStatus['status']=4;//shipped
            }
            elseif($statusshippedcount>$statuscancelledcount && ($statuscancelledcount+$statusshippedcount==$productcount))
			{
				$updateStatus['status']=4;//shipped
			}
			elseif($statusshippedcount==$statuscancelledcount && ($statuscancelledcount+$statusshippedcount==$productcount))
			{
				$updateStatus['status']=4;//shipped
			}
			elseif($statusshippedcount<$statuscancelledcount && $statusshippedcount!=0  && ($statuscancelledcount+$statusshippedcount==$productcount))
			{
				$updateStatus['status']=4;//shipped
            }

             /****End Of shipped ***/
              /****Start Of payment received ***/
            elseif($statuspaymentreceivedcount==$productcount)
			{
				$updateStatus['status']=5; //payment received
            }
            elseif($statuspaymentreceivedcount>$statuscancelledcount && ($statuscancelledcount+$statuspaymentreceivedcount==$productcount))
			{
				$updateStatus['status']=5; //payment received
			}
			elseif($statuspaymentreceivedcount==$statuscancelledcount && ($statuscancelledcount+$statuspaymentreceivedcount==$productcount))
			{
				$updateStatus['status']=5; //payment received
			}
			elseif($statuspaymentreceivedcount<$statuscancelledcount && $statuspaymentreceivedcount!=0  && ($statuscancelledcount+$statuspaymentreceivedcount==$productcount))
			{
				$updateStatus['status']=5; //payment received
            }
             /****End Of payment received ***/
              /****Start Of awaited Payment ***/
            elseif($statusawaitedpaymentcount==$productcount)
			{
				$updateStatus['status']=6;//awaited Payment
            }
            elseif($statusawaitedpaymentcount>$statuscancelledcount && ($statuscancelledcount+$statusawaitedpaymentcount==$productcount))
			{
				$updateStatus['status']=6;//awaited Payment
			}
			elseif($statusawaitedpaymentcount==$statuscancelledcount && ($statuscancelledcount+$statusawaitedpaymentcount==$productcount))
			{
				$updateStatus['status']=6;//awaited Payment
			}
			elseif($statusawaitedpaymentcount<$statuscancelledcount && $statusawaitedpaymentcount!=0  && ($statuscancelledcount+$statusawaitedpaymentcount==$productcount))
			{
				$updateStatus['status']=6;//awaited Payment
            }
            else{
                if($statuscount!=0)
                { 
                    $updateStatus['status']=0;//processing
                }
            }
             /****End Of awaited Payment ***/

            // if ($order_product->order_status != "completed" && $order_product->order_status != "cancelled") {
            //     $all_complated = false;
            // }
              //  print_R($updateStatus['status']);die();
            $data = array(
                'status' => $updateStatus['status'],
                'updated_at' => date('Y-m-d H:i:s'),
            );
           
            // if ($all_complated == true) {
            //     $data["status"] = 1;
            // }
            $this->db->where('id', $order_id);
            $this->db->update('orders', $data);
        }
    }

    //check order payment status / update if all payments received
    public function update_payment_status_if_all_received($order_id)
    {
        $order_id = clean_number($order_id);
        $all_received = true;
        $order_products = $this->get_order_products($order_id);
        if (!empty($order_products)) {
            foreach ($order_products as $order_product) {
                if ($order_product->order_status == "awaiting_payment" || $order_product->order_status == "cancelled") {
                    $all_received = false;
                }
            }
            $data = array(
                'payment_status' => 'awaiting_payment',
                'updated_at' => date('Y-m-d H:i:s'),
            );
            if ($all_received == true) {
                $data["payment_status"] = 'payment_received';
            }
            $this->db->where('id', $order_id);
            $this->db->update('orders', $data);
        }
    }
	
    //Change shipping address of an order
    public function update_shipping_address($id)
    {
		if (!empty($id)) {
			$this->db->select('shipping_country');
			$this->db->from('order_shipping');
			$this->db->where('order_id', $id);
			$country = $this->db->get()->row()->shipping_country;
			//'client_address' => $order_shipment->shipping_address_1.", ".$order_shipment->shipping_address_2.", ".$order_shipment->shipping_zip_code.", ".$order_shipment->shipping_city.", ".$order_shipment->shipping_state.", ".$order_shipment->shipping_country,
            $data1 = array(
                'client_address' => $this->input->post('shipping_address_1', true).", ".$this->input->post('shipping_address_2', true).", ".$this->input->post('shipping_city', true) .", ".$country
            );
            $this->db->where('order_id', $id);
            $this->db->update('invoices', $data1);
            
            $data = array(
                'shipping_first_name' => $this->input->post('shipping_first_name', true),
                'shipping_phone_number' => $this->input->post('shipping_phone_number', true),
                'shipping_address_1' => $this->input->post('shipping_address_1', true),
                'shipping_address_2' => $this->input->post('shipping_address_2', true),
                'shipping_city' => $this->input->post('shipping_city', true)
            );
            $this->db->where('order_id', $id);
            return $this->db->update('order_shipping', $data);
        }
        return false;
    }

    //approve guest order product
    public function approve_guest_order_product($order_product_id)
    {
        $order_product_id = clean_number($order_product_id);
        $order_product = $this->get_order_product($order_product_id);
        if (!empty($order_product)) {
            $data = array(
                'is_approved' => 1,
                'order_status' => "completed",
                'updated_at' => date('Y-m-d H:i:s')
            );
            $this->db->where('id', $order_product_id);
            return $this->db->update('order_products', $data);
        }
        return false;
    }

    //delete order product
    public function delete_order_product($order_product_id)
    {
        $order_product_id = clean_number($order_product_id);
        $order_product = $this->get_order_product($order_product_id);
        if (!empty($order_product)) {
            $this->db->where('id', $order_product_id);
            return $this->db->delete('order_products');
        }
        return false;
    }

    //filter by values
    public function filter_orders()
    {
        $data = array(
            'status' => $this->input->get('status', true),
            'payment_status' => $this->input->get('payment_status', true),
            'q' => $this->input->get('q', true),
        );
        if (!empty($data['status'])) {
            if ($data['status'] == 'completed') {
                $this->db->where('orders.status', 1);
            }elseif ($data['status'] == 'confirmed') {
                $this->db->where('orders.status', 2);
            }elseif ($data['status'] == 'cancelled') {
                $this->db->where('orders.status', 3);
            }
            elseif ($data['status'] == 'processing') {
                $this->db->where('orders.status', 0);
            }
        }
        if (!empty($data['payment_status'])) {
            $this->db->where('orders.payment_status', $data['payment_status']);
        }
        $data['q'] = trim($data['q']);
        if (!empty($data['q'])) {
            $data['q'] = str_replace("#", "", $data['q']);
            $this->db->where('orders.order_number', $data['q']);
        }
    }

    //get orders count
    public function get_orders_count()
    {
        $this->filter_orders();
        $query = $this->db->get('orders');
        return $query->num_rows();
    }

    //get all orders count
    public function get_all_orders_count()
    {
        $query = $this->db->get('orders');
        return $query->num_rows();
    }

    //get orders limited
    public function get_orders_limited($limit)
    {
        $limit = clean_number($limit);
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('orders');
        return $query->result();
    }

    //get paginated orders
    public function get_paginated_orders($per_page, $offset)
    {
        $this->filter_orders();
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
        $query = $this->db->get('order_products');
        return $query->result();
    }
	//get order products
    public function get_order_productsvalid($order_id)
    {
        $order_id = clean_number($order_id);
        $this->db->where('order_id', $order_id);
		$this->db->where('order_status!=','cancelled');
        $query = $this->db->get('order_products');
        return $query->result();
    }

    //get order products
    public function get_order_productswithproduct($order_id,$product_id)
    {
        $order_id = clean_number($order_id);
        $this->db->where('order_id', $order_id);
        $this->db->where('product_id', $product_id);
		$this->db->where('order_status!=','cancelled');
        $query = $this->db->get('order_products');
        return $query->result();
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
        $order_number = clean_number($order_number);
        $this->db->where('order_number', $order_number);
        $query = $this->db->get('orders');
        return $query->row();
    }

    //get order product
    public function get_order_product($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('order_products');
        return $query->row();
    }

    //delete order
    public function delete_order($id)
    {
        $id = clean_number($id);
        $order = $this->get_order($id);
        if (!empty($order)) {
            //delete order products
            $order_products = $this->get_order_products($id);
            if (!empty($order_products)) {
                foreach ($order_products as $order_product) {
                    $this->db->where('id', $order_product->id);
                    $this->db->delete('order_products');
                }
            }
            //delete order
            $this->db->where('id', $id);
            return $this->db->delete('orders');
        }
        return false;
    }

    //get digital sale
    public function get_digital_sale($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('digital_sales');
        return $query->row();
    }

    //get digital sales
    public function get_digital_sales($per_page, $offset)
    {
        $q = remove_special_characters(trim($this->input->get('q', true)));
        if (!empty($q)) {
            $this->db->where('purchase_code', $q);
        }

        $this->db->order_by('purchase_date', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('digital_sales');
        return $query->result();
    }

    //get digital sales count
    public function get_digital_sales_count()
    {
        $query = $this->db->get('digital_sales');
        return $query->num_rows();
    }

    //delete digital sale
    public function delete_digital_sale($id)
    {
        $id = clean_number($id);
        $sale = $this->get_digital_sale($id);
        if (!empty($sale)) {
            $this->db->where('id', $id);
            return $this->db->delete('digital_sales');
        }
        return false;
    }

    //filter bank transfers
    public function filter_bank_transfers()
    {
        $data = array(
            'status' => $this->input->get('status', true),
            'q' => $this->input->get('q', true)
        );
        if (!empty($data['status'])) {
            $this->db->where('status', $data['status']);
        }
        $q = trim($data['q']);
        if (!empty($q)) {
            $q = urldecode($q);
            $q = str_replace("#", "", $q);
            $this->db->where('order_number', $q);
        }
    }

    //get bank transfer notifications
    public function get_bank_transfers_count()
    {
        $this->filter_bank_transfers();
        $query = $this->db->get('bank_transfers');
        return $query->num_rows();
    }

    //get paginated bank transfer notifications
    public function get_paginated_bank_transfers($per_page, $offset)
    {
        $this->filter_bank_transfers();
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('bank_transfers');
        return $query->result();
    }

    //get bank transfer
    public function get_bank_transfer($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('bank_transfers');
        return $query->row();
    }

    //get bank transfer by order number
    public function get_bank_transfer_by_order_number($order_number)
    {
        $order_number = clean_number($order_number);
        $this->db->order_by('created_at', 'DESC');
        $this->db->where('order_number', $order_number);
        $query = $this->db->get('bank_transfers');
        return $query->row();
    }

    //update bank transfer status
    public function update_bank_transfer_status($id, $option)
    {
        $id = clean_number($id);
        $transfer = $this->get_bank_transfer($id);
        if (!empty($transfer)) {
            $data = array(
                'status' => $option
            );
            $this->db->where('id', $id);
            return $this->db->update('bank_transfers', $data);
        }
        return false;
    }

    //delete bank transfer
    public function delete_bank_transfer($id)
    {
        $id = clean_number($id);
        $transfer = $this->get_bank_transfer($id);
        if (!empty($transfer)) {
            delete_file_from_server($transfer->receipt_path);
            $this->db->where('id', $id);
            return $this->db->delete('bank_transfers');
        }
        return false;
    }

    //filter by values
    public function filter_invoices()
    {
        $order_number = $this->input->get('order_number', true);
        if (!empty($order_number)) {
            $this->db->like('order_number', $order_number);
        }
    }

    //get invoices count
    public function get_invoices_count()
    {
        $this->filter_invoices();
        $query = $this->db->get('invoices');
        return $query->num_rows();
    }

    //get paginated invoices
    public function get_paginated_invoices($per_page, $offset)
    {
        $this->filter_invoices();
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('invoices');
        return $query->result();
    }
	
	public function add_order_products_to_existing_order($order_id,$countofsameproducts,$quantity,$details=array(),$appended_items)
	{
        
        $discounted_price=$details->price-(($details->discount_rate/100)*$details->price);
        $product_vat=($details->vat_rate/100)*$discounted_price;  
        if($countofsameproducts>=1)
        {
            $shipping_cost=$details->shipping_cost_additional;
        }
        else{
            $shipping_cost=$details->shipping_cost;
        }  
		$data = array(
                        'order_id' => $order_id,
                        'seller_id' => $details->user_id,
                        'buyer_id' => 0,
                        'buyer_type' => "admin",
                        'product_id' => $details->id,
                        'product_type' => $details->product_type,
                        'product_title' => $details->title.$appended_items,
                        'product_slug' => $details->slug,
                        'product_unit_price' =>$discounted_price,
                        'product_quantity' => $quantity,
                        'product_currency' => $details->currency,
                        'product_vat_rate' => $details->vat_rate,
                        'product_vat' => $product_vat,
                        'product_shipping_cost' => $shipping_cost,
                        'product_total_price' => $quantity*$discounted_price+$shipping_cost+$product_vat,
                        'variation_option_ids' => '',
                        'commission_rate' => $this->general_settings->commission_rate,
                        'order_status' => 'payment_received',
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
                    if ($details->product_type == 'digital') {
                        $data["is_approved"] = 1;
                        if ($order_status == 'payment_received') {
                            $data["order_status"] = 'completed';
                        } else {
                            $data["order_status"] = $order_status;
                        }
                    }
                    $data["product_total_price"] = $quantity*$discounted_price  +$product_vat+ $shipping_cost;

                    $this->db->insert('order_products', $data);
	}
	
}
