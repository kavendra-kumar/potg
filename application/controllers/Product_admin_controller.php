<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_admin_controller extends Admin_Core_Controller
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
     * Products
     */
    public function products()
    {
        $data['title'] = trans("products");
        $data['form_action'] = admin_url() . "products";
        $data['list_type'] = "products";
        //get paginated products
        $pagination = $this->paginate(admin_url() . 'products', $this->product_admin_model->get_paginated_products_count('products'));
        $data['products'] = $this->product_admin_model->get_paginated_products($pagination['per_page'], $pagination['offset'], 'products');
        $data['panel_settings'] = $this->settings_model->get_panel_settings();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/products', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Pending Products
     */
    public function pending_products()
    {
        $data['title'] = trans("pending_products");
        $data['form_action'] = admin_url() . "pending-products";
        $data['list_type'] = "pending_products";
        //get paginated pending products
        $pagination = $this->paginate(admin_url() . 'pending-products', $this->product_admin_model->get_paginated_pending_products_count('pending_products'));
        $data['products'] = $this->product_admin_model->get_paginated_pending_products($pagination['per_page'], $pagination['offset'], 'pending_products');
        $data['panel_settings'] = $this->settings_model->get_panel_settings();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/pending_products', $data);
        $this->load->view('admin/includes/_footer');
    }

    public function addon_products()
    {
        $data['title'] = trans("addon_products");
        $data['form_action'] = admin_url() . "addon-products";
        $data['list_type'] = "addon_products";        
        
        //get paginated products
        $data['products'] = $this->product_admin_model->get_products_for_addon();
        $data['panel_settings'] = $this->settings_model->get_panel_settings();

        $addon_products = $this->product_admin_model->get_addon_products();
        if($addon_products) {
            $data['addon'] = explode(",", $addon_products->product_ids);
        } else {
            $data['addon'] = array();
        }
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/addon_products', $data);
        $this->load->view('admin/includes/_footer');
    }
    
    public function save_addon_products()
    {
        $product_ids = $this->input->post('product_id', true);
        $products = implode(",", $product_ids);
        if( $this->product_admin_model->save_addon_products($products) ) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
        die($products);
    }

    /**
     * Hidden Products
     */
    public function hidden_products()
    {
        $data['title'] = trans("hidden_products");
        $data['form_action'] = admin_url() . "hidden-products";
        $data['list_type'] = "hidden_products";
        //get paginated products
        $pagination = $this->paginate(admin_url() . 'hidden-products', $this->product_admin_model->get_paginated_hidden_products_count('hidden_products'));
        $data['products'] = $this->product_admin_model->get_paginated_hidden_products($pagination['per_page'], $pagination['offset'], 'hidden_products');
        $data['panel_settings'] = $this->settings_model->get_panel_settings();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/products', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Draft
     */
    public function drafts()
    {
        $data['title'] = trans("drafts");
        $data['form_action'] = admin_url() . "drafts";
        $data['list_type'] = "drafts";
        //get paginated drafts
        $pagination = $this->paginate(admin_url() . 'drafts', $this->product_admin_model->get_paginated_drafts_count('drafts'));
        $data['products'] = $this->product_admin_model->get_paginated_drafts($pagination['per_page'], $pagination['offset'], 'drafts');
        $data['panel_settings'] = $this->settings_model->get_panel_settings();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/drafts', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Deleted Products
     */
    public function deleted_products()
    {
        $data['title'] = trans("deleted_products");
        $data['form_action'] = admin_url() . "deleted-products";
        $data['list_type'] = "deleted_products";
        //get paginated products
        $pagination = $this->paginate(admin_url() . 'deleted-products', $this->product_admin_model->get_paginated_deleted_products_count('deleted_products'));
        $data['products'] = $this->product_admin_model->get_paginated_deleted_products($pagination['per_page'], $pagination['offset'], 'deleted_products');
        $data['panel_settings'] = $this->settings_model->get_panel_settings();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/deleted_products', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Featured Products
     */
    public function featured_products()
    {
        $data['title'] = trans("featured_products");
        $data['form_action'] = admin_url() . "featured-products";
        $data['list_type'] = "featured_products";
        //get paginated featured products
        $pagination = $this->paginate(admin_url() . 'featured-products', $this->product_admin_model->get_paginated_promoted_products_count('promoted_products'));
        $data['products'] = $this->product_admin_model->get_paginated_promoted_products($pagination['per_page'], $pagination['offset'], 'promoted_products');
        $data['panel_settings'] = $this->settings_model->get_panel_settings();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/featured/featured_products', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Featured Products Pricing
     */
    public function featured_products_pricing()
    {
        $data['title'] = trans("pricing");

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/featured/pricing', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Featured Products Pricing Post
     */
    public function featured_products_pricing_post()
    {
        if ($this->settings_model->update_pricing_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    /**
     * Featured Products Transactions
     */
    public function featured_products_transactions()
    {
        $data['title'] = trans("featured_products_transactions");
        $data['form_action'] = admin_url() . "featured-products-transactions";

        $pagination = $this->paginate(admin_url() . 'featured-products-transactions', $this->transaction_model->get_promoted_transactions_count());
        $data['transactions'] = $this->transaction_model->get_paginated_promoted_transactions($pagination['per_page'], $pagination['offset']);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/featured/transactions', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Delete Featured Transaction Post
     */
    public function delete_featured_transaction_post()
    {
        $id = $this->input->post('id', true);
        if ($this->transaction_model->delete_promoted_transaction($id)) {
            $this->session->set_flashdata('success', trans("msg_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /**
     * Product Details
     */
    public function product_details($id)
    {
        $data['title'] = trans("product_details");
        $data['product'] = $this->product_admin_model->get_product($id);
        if (empty($data['product'])) {
            redirect($this->agent->referrer());
        }
        $data['panel_settings'] = $this->settings_model->get_panel_settings();
        $data['review_count'] = $this->review_model->get_review_count($data["product"]->id);
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/product_details', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Approve Product
     */
    public function approve_product()
    {
        $id = $this->input->post('id', true);
        if ($this->product_admin_model->approve_product($id)) {
            $this->session->set_flashdata('success', trans("msg_product_approved"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        //reset cache
        reset_cache_data_on_change();

        $redirect_url = $this->input->post('redirect_url', true);
        if (!empty($redirect_url)) {
            redirect($redirect_url);
        }
    }

    /**
     * Restore Product
     */
    public function restore_product()
    {
        $id = $this->input->post('id', true);
        if ($this->product_admin_model->restore_product($id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        //reset cache
        reset_cache_data_on_change();
    }

    /**
     * Delete Product
     */
    public function delete_product()
    {
        $id = $this->input->post('id', true);
        if ($this->product_admin_model->delete_product($id)) {
            $this->session->set_flashdata('success', trans("msg_product_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        //reset cache
        reset_cache_data_on_change();
    }

    /**
     * Delete Product Permanently
     */
    public function delete_product_permanently()
    {
        $id = $this->input->post('id', true);
        if ($this->product_admin_model->delete_product_permanently($id)) {
            $this->session->set_flashdata('success', trans("msg_product_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        //reset cache
        reset_cache_data_on_change();
    }

    /**
     * Delete Selected Products
     */
    public function delete_selected_products()
    {
        $product_ids = $this->input->post('product_ids', true);
        $this->product_admin_model->delete_multi_products($product_ids);

        //reset cache
        reset_cache_data_on_change();
    }

    /**
     * Delete Selected Products Permanently
     */
    public function delete_selected_products_permanently()
    {
        $product_ids = $this->input->post('product_ids', true);
        $this->product_admin_model->delete_multi_products_permanently($product_ids);

        //reset cache
        reset_cache_data_on_change();
    }

    /**
     * Add Remove Featured Products
     */
    public function add_remove_featured_products()
    {
        $product_id = $this->input->post('product_id', true);
        $day_count = $this->input->post('day_count', true);
        $is_ajax = $this->input->post('is_ajax', true);
        if ($this->product_admin_model->add_remove_promoted_products($product_id, $day_count)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        //reset cache
        reset_cache_data_on_change();

        if ($is_ajax == 0) {
            redirect($this->agent->referrer());
        }
    }


    /**
     * Comments
     */
    public function comments()
    {
        $data['title'] = trans("approved_comments");
        $data['comments'] = $this->comment_model->get_approved_comments();
        $data['top_button_text'] = trans("pending_comments");
        $data['top_button_url'] = admin_url() . "pending-product-comments";
        $data['show_approve_button'] = false;

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/comment/comments', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Pending Comments
     */
    public function pending_comments()
    {
        $data['title'] = trans("pending_comments");
        $data['comments'] = $this->comment_model->get_pending_comments();
        $data['top_button_text'] = trans("approved_comments");
        $data['top_button_url'] = admin_url() . "product-comments";
        $data['show_approve_button'] = true;

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/comment/comments', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Aprrove Comment Post
     */
    public function approve_comment_post()
    {
        $id = $this->input->post('id', true);
        if ($this->comment_model->approve_comment($id)) {
            $this->session->set_flashdata('success', trans("msg_comment_approved"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Approve Selected Comments
     */
    public function approve_selected_comments()
    {
        $comment_ids = $this->input->post('comment_ids', true);
        $this->comment_model->approve_multi_comments($comment_ids);
    }


    /**
     * Delete Comment
     */
    public function delete_comment()
    {
        $id = $this->input->post('id', true);
        if ($this->comment_model->delete_comment($id)) {
            $this->session->set_flashdata('success', trans("msg_comment_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /**
     * Delete Selected Comments
     */
    public function delete_selected_comments()
    {
        $comment_ids = $this->input->post('comment_ids', true);
        $this->comment_model->delete_multi_comments($comment_ids);
    }

    /**
     * Reviews
     */
    public function reviews()
    {
        $data['title'] = trans("reviews");
        $data['reviews'] = $this->review_model->get_all_reviews();
        $data['panel_settings'] = $this->settings_model->get_panel_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/review/reviews', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Delete Review
     */
    public function delete_review()
    {
        $id = $this->input->post('id', true);
        if ($this->review_model->delete_review($id)) {
            $this->session->set_flashdata('success', trans("msg_review_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /**
     * Delete Selected Reviews
     */
    public function delete_selected_reviews()
    {
        $review_ids = $this->input->post('review_ids', true);
        $this->review_model->delete_multi_reviews($review_ids);
    }

}
