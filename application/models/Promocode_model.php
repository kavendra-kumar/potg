<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Promocode_model extends CI_Model
{
    //get all 
    public function getData()
    {
        $this->db->order_by('id');
        $query = $this->db->get('promocode');
        return $query->result();
    }
    //add item
    public function add_promocode($data=array())
    {
        $this->db->insert('promocode', $data);
        return true;
    }

    //update item
    public function update_item($id)
    {
        $data = array(
            'lang_id' => $this->input->post('lang_id', true),
            'title' => $this->input->post('title', true),
            'description' => $this->input->post('description', true),
            'link' => $this->input->post('link', true),
            'item_order' => $this->input->post('item_order', true),
            'button_text' => $this->input->post('button_text', true),
            'text_color' => $this->input->post('text_color', true),
            'button_color' => $this->input->post('button_color', true),
            'button_text_color' => $this->input->post('button_text_color', true),
            'animation_title' => $this->input->post('animation_title', true),
            'animation_description' => $this->input->post('animation_description', true),
            'animation_button' => $this->input->post('animation_button', true)
        );

        $item = $this->get_slider_item($id);
        if (!empty($item)) {
            $this->load->model('upload_model');
            $temp_path = $this->upload_model->upload_temp_image('file');
            if (!empty($temp_path)) {
                delete_file_from_server($item->image);
                $data["image"] = $this->upload_model->slider_image_upload($temp_path);
                $this->upload_model->delete_temp_image($temp_path);
            }
            $temp_path_mobile = $this->upload_model->upload_temp_image('file_mobile');
            if (!empty($temp_path_mobile)) {
                delete_file_from_server($item->image_mobile);
                $data["image_mobile"] = $this->upload_model->slider_image_mobile_upload($temp_path_mobile);
                $this->upload_model->delete_temp_image($temp_path_mobile);
            }

            $this->db->where('id', $id);
            return $this->db->update('slider', $data);
        }
        return false;
    }

    //get slider item
    public function get_slider_item($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('slider');
        return $query->row();
    }

    //get slider items
    public function get_slider_items()
    {
        $this->db->where('slider.lang_id', $this->selected_lang->id);
        $this->db->order_by('item_order');
        $query = $this->db->get('slider');
        return $query->result();
    }

    

    //update slider settings
    public function update_slider_settings()
    {
        $data = array(
            'slider_status' => $this->input->post('slider_status', true),
            'slider_type' => $this->input->post('slider_type', true),
            'slider_effect' => $this->input->post('slider_effect', true)
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //delete slider item
    public function delete_promocode($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        return $this->db->delete('promocode');
    }

}
