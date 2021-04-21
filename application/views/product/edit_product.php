<?php defined('BASEPATH') OR exit('No direct script access allowed'); if($product->info){$info = (array)$product->info;} else{$info = $product->info;} ?>

<!-- File Manager -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/file-manager/file-manager.css">
<script src="<?php echo base_url(); ?>assets/vendor/file-manager/file-manager.js"></script>
<!-- Ckeditor js -->
<script src="<?php echo base_url(); ?>assets/vendor/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/ckeditor/lang/<?php echo $this->selected_lang->ckeditor_lang; ?>.js"></script>

<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div id="content" class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb"></ol>
                </nav>
                <?php if ($product->is_draft == 1): ?>
                    <h1 class="page-title page-title-product"><?php echo trans("sell_now"); ?></h1>
                <?php else: ?>
                    <h1 class="page-title page-title-product"><?php echo trans("edit_product"); ?></h1>
                <?php endif; ?>

                <div class="form-add-product">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-12 col-lg-11">
                            <div class="row">
                                <div class="col-12">
                                    <!-- include message block -->
                                    <?php $this->load->view('product/_messages'); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 m-b-30">
                                    <label class="control-label font-600"><?php echo trans("images"); ?></label> <a href="#" class="float-right"  data-toggle="modal" data-target="#updateLandingPage"><?php echo trans("edit_landing_page"); ?></a>
                                    <?php $this->load->view("product/_image_update_box"); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <?php echo form_open('edit-product-post', ['id' => 'form_validate', 'class' => 'validate_price', 'onkeypress' => "return event.keyCode != 13;"]); ?>
                                    <input type="hidden" name="id" value="<?php echo $product->id; ?>">

                                    <?php if ($this->general_settings->physical_products_system == 1 && $this->general_settings->digital_products_system == 0): ?>
                                        <input type="hidden" name="product_type" value="physical">
                                    <?php elseif ($this->general_settings->physical_products_system == 0 && $this->general_settings->digital_products_system == 1): ?>
                                        <input type="hidden" name="product_type" value="digital">
                                    <?php else: ?>
                                        <div class="form-box">
                                            <div class="form-box-head">
                                                <h4 class="title"><?php echo trans('product_type'); ?></h4>
                                            </div>
                                            <div class="form-box-body">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <?php if ($this->general_settings->physical_products_system == 1): ?>
                                                            <div class="col-12 col-sm-6 col-option">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" name="product_type" value="physical" id="product_type_1" class="custom-control-input" <?php echo ($product->product_type == 'physical') ? 'checked' : ''; ?> required>
                                                                    <label for="product_type_1" class="custom-control-label"><?php echo trans('physical'); ?></label>
                                                                    <p class="form-element-exp"><?php echo trans('physical_exp'); ?></p>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if ($this->general_settings->digital_products_system == 1): ?>
                                                            <div class="col-12 col-sm-6 col-option">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" name="product_type" value="digital" id="product_type_2" class="custom-control-input" <?php echo ($product->product_type == 'digital') ? 'checked' : ''; ?> required>
                                                                    <label for="product_type_2" class="custom-control-label"><?php echo trans('digital'); ?></label>
                                                                    <p class="form-element-exp"><?php echo trans('digital_exp'); ?></>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($active_product_system_array['active_system_count'] > 1): ?>
                                        <div class="form-box">
                                            <div class="form-box-head">
                                                <h4 class="title"><?php echo trans('listing_type'); ?></h4>
                                            </div>
                                            <div class="form-box-body">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <?php if ($this->general_settings->marketplace_system == 1): ?>
                                                            <div class="col-12 col-sm-6 col-option listing_sell_on_site">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" name="listing_type" value="sell_on_site" id="listing_type_1" class="custom-control-input" <?php echo ($product->listing_type == 'sell_on_site') ? 'checked' : ''; ?> required>
                                                                    <label for="listing_type_1" class="custom-control-label"><?php echo trans('add_product_for_sale'); ?></label>
                                                                    <p class="form-element-exp"><?php echo trans('add_product_for_sale_exp'); ?></p>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if ($this->general_settings->classified_ads_system == 1): ?>
                                                            <div class="col-12 col-sm-6 col-option listing_ordinary_listing <?php echo ($product->product_type == 'digital') ? 'hidden' : ''; ?>">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" name="listing_type" value="ordinary_listing" id="listing_type_2" class="custom-control-input" <?php echo ($product->listing_type == 'ordinary_listing') ? 'checked' : ''; ?> required>
                                                                    <label for="listing_type_2" class="custom-control-label"><?php echo trans('add_product_services_listing'); ?></label>
                                                                    <p class="form-element-exp"><?php echo trans('add_product_services_listing_exp'); ?></p>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if ($this->general_settings->bidding_system == 1): ?>
                                                            <div class="col-12 col-sm-6 col-option listing_bidding">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" name="listing_type" value="bidding" id="listing_type_3" class="custom-control-input" <?php echo ($product->listing_type == 'bidding') ? 'checked' : ''; ?> required>
                                                                    <label for="listing_type_3" class="custom-control-label"><?php echo trans('add_product_get_price_requests'); ?></label>
                                                                    <p class="form-element-exp"><?php echo trans('add_product_get_price_requests_exp'); ?></p>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <input type="hidden" name="listing_type" value="<?php echo $active_product_system_array['active_system_value']; ?>">
                                    <?php endif; ?>

                                    <div class="form-box">
                                        <div class="form-box-head">
                                            <h4 class="title"><?php echo trans('details'); ?></h4>
                                        </div>
                                        <div class="form-box-body">

                                        <div class="form-group">
                                                <label class="control-label"><?php echo trans("title"); ?></label>
                                                <input type="text" name="title" class="form-control form-input" value="<?php echo html_escape($product->title); ?>" placeholder="<?php echo trans("title"); ?>" required>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label"><?php echo trans("short_title"); ?></label>
                                                <input type="text" name="short_title" class="form-control form-input" value="<?php echo html_escape($product->short_title); ?>" placeholder="<?php echo trans("short_title"); ?>" >
                                            </div>


                                            <div class="form-group">
                                                <label class="control-label"><?php echo trans("sku"); ?>&nbsp;(<?php echo trans("product_code"); ?>)</label>
                                                <input type="text" name="sku" class="form-control form-input" value="<?php echo html_escape($product->sku); ?>" placeholder="<?php echo trans("sku"); ?>&nbsp;(<?php echo trans("optional"); ?>)">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label"><?php echo trans("category"); ?></label>
                                                <div class="selectdiv">
                                                    <select id="categories" name="category_id_0" class="form-control" onchange="get_subcategories(this.value, 0);" required>
                                                        <option value=""><?php echo trans('select_category'); ?></option>
                                                        <?php foreach ($this->parent_categories as $item):
                                                            if (!empty($parent_categories_array[0]) && $item->id == $parent_categories_array[0]->id):?>
                                                                <option value="<?php echo $item->id; ?>" selected><?php echo category_name($item); ?></option>
                                                            <?php else: ?>
                                                                <option value="<?php echo $item->id; ?>"><?php echo category_name($item); ?></option>
                                                            <?php endif;
                                                        endforeach; ?>
                                                    </select>
                                                </div>
                                                <div id="subcategories_container">
                                                    <?php if (!empty($parent_categories_array)):
                                                        for ($i = 1; $i < count($parent_categories_array); $i++):
                                                            if (!empty($parent_categories_array[$i]) && !empty($category)):?>
                                                                <?php $subcategories = get_subcategories($this->categories, $parent_categories_array[$i]->parent_id);
                                                                if (!empty($subcategories)):?>
                                                                    <div class="selectdiv m-t-5">
                                                                        <select id="categories" name="category_id_<?php echo $i; ?>" class="form-control subcategory-select" data-select-id="<?php echo $i; ?>" onchange="get_subcategories(this.value, '<?php echo $i; ?>');" required>
                                                                            <option value=""><?php echo trans('select_category'); ?></option>
                                                                            <?php foreach ($subcategories as $subcategory): ?>
                                                                                <option value="<?php echo $subcategory->id; ?>" <?php echo ($subcategory->id == $parent_categories_array[$i]->id) ? 'selected' : ''; ?>> <?php echo category_name($subcategory); ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                <?php endif;
                                                            endif;
                                                        endfor;
                                                    endif; ?>

                                                    <?php $new_subcategories = get_subcategories($this->categories, $category->id);
                                                    if (!empty($new_subcategories) && !empty($category)):?>
                                                        <div class="selectdiv m-t-5">
                                                            <select id="categories" name="category_id_<?php echo $i + 1; ?>" class="form-control subcategory-select" data-select-id="<?php echo $i; ?>" onchange="get_subcategories(this.value, '<?php echo $i + 1; ?>');" required>
                                                                <option value=""><?php echo trans('select_category'); ?></option>
                                                                <?php foreach ($new_subcategories as $subcategory): ?>
                                                                    <option value="<?php echo $subcategory->id; ?>"><?php echo category_name($subcategory); ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label"><?php echo trans('description'); ?> </label>
                                                <div class="row">
                                                    <div class="col-sm-12 m-b-10">
                                                        <button type="button" class="btn btn-sm btn-secondary color-white btn_ck_add_image"><i class="icon-image"></i><?php echo trans("add_image"); ?></button>
                                                        <button type="button" class="btn btn-sm btn-info color-white btn_ck_add_video"><i class="icon-image"></i><?php echo trans("add_video"); ?></button>
                                                        <button type="button" class="btn btn-sm btn-warning color-white btn_ck_add_iframe"><i class="icon-image"></i><?php echo trans("add_iframe"); ?></button>
                                                    </div>
                                                </div>
                                                <textarea name="description" id="ckEditor" class="text-editor"><?php echo $product->description; ?></textarea>
                                            </div>


                                            <?php 
                                                $addon_products = ($product->addon_products) ? explode(',', $product->addon_products) : array();
                                                $upselling_products = ($product->upselling_products) ? explode(',', $product->upselling_products) : array();
                                            ?>
                                            <div class="form-group">
                                                <label class="control-label"><?php echo trans("addon_products"); ?></label>
                                                <div class="selectdiv">
                                                    <select id="addon_products" name="addon_products[]" class="form-control mySelect for" multiple="multiple" style="width: 100%">
                                                        <?php if($products) { ?>
                                                            <?php foreach($products as $val) { ?>
                                                                <option <?php if( in_array($val->id, $addon_products) ) echo "selected"; ?> value="<?= $val->id; ?>"><?= $val->title.' ('.$val->sku.')'; ?></option>
                                                        <?php }  } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label class="control-label"><?php echo trans("upselling_products"); ?></label>
                                                <div class="selectdiv">
                                                    <select id="upselling_products" name="upselling_products[]" class="form-control mySelect for" multiple="multiple" style="width: 100%">
                                                        <?php if($products) { ?>
                                                            <?php foreach($products as $val) { ?>
                                                                <option <?php if( in_array($val->id, $upselling_products) ) echo "selected"; ?> value="<?= $val->id; ?>"><?= $val->title.' ('.$val->sku.')'; ?></option>
                                                        <?php }  } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="control-label"><?php echo trans("upselling_title"); ?></label>
                                                <input type="text" name="upselling_title" class="form-control form-input"  value="<?php echo html_escape($product->upselling_title); ?>" placeholder="<?php echo trans("upselling_title"); ?>" >
                                            </div>




                                        </div>
                                    </div>
                                    <?php if ($product->is_draft != 1 && is_admin()): ?>
                                        <div class="form-box">
                                            <div class="form-box-head">
                                                <h4 class="title"><?php echo trans('options'); ?></h4>
                                            </div>
                                            <div class="form-box-body">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo trans('visibility'); ?></label>
                                                    <div class="selectdiv">
                                                        <select name="visibility" class="form-control" required>
                                                            <option value="1" <?php echo ($product->visibility == 1) ? 'selected' : ''; ?>><?php echo trans('visible'); ?></option>
                                                            <option value="0" <?php echo ($product->visibility == 0) ? 'selected' : ''; ?>><?php echo trans('hidden'); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <input type="hidden" name="visibility" value="<?php echo $product->visibility; ?>">
                                    <?php endif; ?>

                                    <div class="form-group">
                                        <?php if ($product->is_draft == 1): ?>
                                            <button type="submit" class="btn btn-lg btn-custom float-right"><?php echo trans("save_and_continue"); ?></button>
                                        <?php else: ?>
                                            <a href="<?php echo generate_url("sell_now", "product_details") . "/" . $product->id; ?>" class="btn btn-lg btn-custom float-right"><?php echo trans("edit_details"); ?></a>
                                            <button type="submit" class="btn btn-lg btn-custom float-right m-r-10"><?php echo trans("save_changes"); ?></button>
                                        <?php endif; ?>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>


<script>
    /* Kave code start */
    $('#addon_products').select2();
    $('#addon_products').on('select2:opening select2:closing', function( event ) {
        var $searchfield = $(this).parent().find('.select2-search__field');
        $searchfield.prop('disabled', true);
    });

    $('#upselling_products').select2();
    $('#upselling_products').on('select2:opening select2:closing', function( event ) {
        var $searchfield = $(this).parent().find('.select2-search__field');
        $searchfield.prop('disabled', true);
    });
    /* Kave code end */


    function get_subcategories(category_id, data_select_id) {
        var subcategories = get_subcategories_array(category_id);
        var date = new Date();
        //reset subcategories
        $('.subcategory-select').each(function () {
            if (parseInt($(this).attr('data-select-id')) > parseInt(data_select_id)) {
                $(this).remove();
            }
        });
        if (category_id == 0) {
            return false;
        }
        if (subcategories.length > 0) {
            var new_data_select_id = date.getTime();
            var select_tag = '<div class="selectdiv m-t-5"><select class="form-control subcategory-select" data-select-id="' + new_data_select_id + '" name="category_id_' + new_data_select_id + '" required onchange="get_subcategories(this.value,' + new_data_select_id + ');">' +
                '<option value=""><?php echo trans("select_category"); ?></option>';
            for (i = 0; i < subcategories.length; i++) {
                select_tag += '<option value="' + subcategories[i].id + '">' + subcategories[i].name + '</option>';
            }
            select_tag += '</select></div>';
            $('#subcategories_container').append(select_tag);
        }
        //remove empty selectdivs
        $(".selectdiv").each(function () {
            if ($(this).children('select').length == 0) {
                $(this).remove();
            }
        });
    }

    function get_subcategories_array(category_id) {
        var categories_array = <?php echo get_categories_json($this->selected_lang->id); ?>;
        var subcategories_array = [];
        for (i = 0; i < categories_array.length; i++) {
            if (categories_array[i].parent_id == category_id) {
                subcategories_array.push(categories_array[i]);
            }
        }
        return subcategories_array;
    }
</script>

<?php $this->load->view("product/_file_manager_ckeditor"); ?>

<!-- Ckeditor -->
<script>
    var ckEditor = document.getElementById('ckEditor');
    if (ckEditor != undefined && ckEditor != null) {
        CKEDITOR.replace('ckEditor', {
            language: '<?php echo $this->selected_lang->ckeditor_lang; ?>',
            filebrowserBrowseUrl: 'path',
            removeButtons: 'Save',
            allowedContent: true,
            extraPlugins: 'videoembed,oembed'
        });
    }

    function selectFile(fileUrl) {
        window.opener.CKEDITOR.tools.callFunction(1, fileUrl);
    }

    CKEDITOR.on('dialogDefinition', function (ev) {
        var editor = ev.editor;
        var dialogDefinition = ev.data.definition;

        // This function will be called when the user will pick a file in file manager
        var cleanUpFuncRef = CKEDITOR.tools.addFunction(function (a) {
            $('#ckFileManagerModal').modal('hide');
            CKEDITOR.tools.callFunction(1, a, "");
        });
        var tabCount = dialogDefinition.contents.length;
        for (var i = 0; i < tabCount; i++) {
            var browseButton = dialogDefinition.contents[i].get('browse');
            if (browseButton !== null) {
                browseButton.onClick = function (dialog, i) {
                    editor._.filebrowserSe = this;
                    var iframe = $('#ckFileManagerModal').find('iframe').attr({
                        src: editor.config.filebrowserBrowseUrl + '&CKEditor=body&CKEditorFuncNum=' + cleanUpFuncRef + '&langCode=en'
                    });
                    $('#ckFileManagerModal').appendTo('body').modal('show');
                }
            }
        }
    });

    CKEDITOR.on('instanceReady', function (evt) {
        $(document).on('click', '.btn_ck_add_image', function () {
            if (evt.editor.name != undefined) {
                evt.editor.execCommand('image');
            }
        });
        $(document).on('click', '.btn_ck_add_video', function () {
            if (evt.editor.name != undefined) {
                evt.editor.execCommand('videoembed');
            }
        });
        $(document).on('click', '.btn_ck_add_iframe', function () {
            if (evt.editor.name != undefined) {
                evt.editor.execCommand('iframe');
            }
        });
    });
</script>

<div class="modal fade" id="updateLandingPage" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="updateLandingPage" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Landing Page Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <?php echo form_open_multipart('product_controller/edit_product_promo_info_post'); ?>
        <div class="modal-body">        
            <input type="hidden" name="id" value="<?php echo $product->id; ?>">
            <div class="form-box">
                <div class="form-box-head">
                    <h4 class="title">Section 1</h4>
                </div>
                <div class="form-box-body">    
                    <div class="row">
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="control-label"> <?php echo trans("title"); ?></label>
                                <input type="text" name="s1_heading" class="form-control form-input" value="<?php echo html_escape($info['s1_heading']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="control-label"> Device Name </label>
                                <input type="text" name="s1_device_name" class="form-control form-input" value="<?php echo html_escape($info['s1_device_name']); ?>"  required>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="control-label"> <?php echo trans("title"); ?> (Ar)</label>
                                <input type="text" name="s1_heading_ar" class="form-control form-input" value="<?php echo html_escape($info['s1_heading_ar']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="control-label"> Device Name (Ar)</label>
                                <input type="text" name="s1_device_name_ar" class="form-control form-input" value="<?php echo html_escape($info['s1_device_name_ar']); ?>"  required>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Background Image (1920X9272px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        <?php echo trans('select_image'); ?>
                                        <input type="file" name="image_background" accept=".png, .jpg, .jpeg" onchange="$('#upload-file-info1').html($(this).val());">
                                    </a>
                                    (.png, .jpg, .jpeg)
                                </div>
                                <span class='label label-info' id="upload-file-info1"></span>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Brand Image (80X30px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        <?php echo trans('select_image'); ?>
                                        <input type="file" name="image_brand" accept=".png" onchange="$('#upload-file-info2').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info2"></span>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Product Image (80X30px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        <?php echo trans('select_image'); ?>
                                        <input type="file" name="s1_product_image" accept=".png" onchange="$('#upload-file-info3').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info3"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-box">
                <div class="form-box-head">
                    <h4 class="title">Section 2</h4>
                </div>
                <div class="form-box-body">
                    <div class="row">
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?php echo trans("title"); ?></label>
                                <input type="text" name="s2_heading" class="form-control form-input" value="<?php echo html_escape($info['s2_heading']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?php echo trans("title"); ?> (Ar)</label>
                                <input type="text" name="s2_heading_ar" class="form-control form-input" value="<?php echo html_escape($info['s2_heading_ar']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-12">
                            <div class="form-group">
                                <label class="control-label">Image (959X323px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        <?php echo trans('select_image'); ?>
                                        <input type="file" name="s2_image" accept=".png" onchange="$('#upload-file-info4').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info4"></span>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="form-box">
                <div class="form-box-head">
                    <h4 class="title">Section 3</h4>
                </div>
                <div class="form-box-body">
                    <div class="row">
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Number 1</label>
                                <input type="text" name="s3_sub_number_1" class="form-control form-input" value="<?php echo html_escape($info['s3_sub_number_1']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Details 1</label>
                                <input type="text" name="s3_sub_text_1" class="form-control form-input" value="<?php echo html_escape($info['s3_sub_text_1']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Details 1 (Ar)</label>
                                <input type="text" name="s3_sub_text_1_ar" class="form-control form-input" value="<?php echo html_escape($info['s3_sub_text_1_ar']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Number 2</label>
                                <input type="text" name="s3_sub_number_2" class="form-control form-input" value="<?php echo html_escape($info['s3_sub_number_2']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Details 2</label>
                                <input type="text" name="s3_sub_text_2" class="form-control form-input" value="<?php echo html_escape($info['s3_sub_text_2']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Details 2 (Ar)</label>
                                <input type="text" name="s3_sub_text_2_ar" class="form-control form-input" value="<?php echo html_escape($info['s3_sub_text_2_ar']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Number 3</label>
                                <input type="text" name="s3_sub_number_3" class="form-control form-input" value="<?php echo html_escape($info['s3_sub_number_3']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label"> Details 3</label>
                                <input type="text" name="s3_sub_text_3" class="form-control form-input" value="<?php echo html_escape($info['s3_sub_text_3']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label"> Details 3 (Ar)</label>
                                <input type="text" name="s3_sub_text_3_ar" class="form-control form-input" value="<?php echo html_escape($info['s3_sub_text_3_ar']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-3">
                            <div class="form-group">
                                <label class="control-label">Image 1 (60X56px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        <?php echo trans('select_image'); ?>
                                        <input type="file" name="s3_main_image_1" accept=".png" onchange="$('#upload-file-info5').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info5"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Image 1 Details</label>
                                <input type="text" name="s3_main_text_1" class="form-control form-input" value="<?php echo html_escape($info['s3_main_text_1']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Image 1 Details (Ar)</label>
                                <input type="text" name="s3_main_text_1_ar" class="form-control form-input" value="<?php echo html_escape($info['s3_main_text_1_ar']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-3">
                            <div class="form-group">
                                <label class="control-label">Image 2 (60X56px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        <?php echo trans('select_image'); ?>
                                        <input type="file" name="s3_main_image_2" accept=".png" onchange="$('#upload-file-info6').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info6"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Image 2 Details</label>
                                <input type="text" name="s3_main_text_2" class="form-control form-input" value="<?php echo html_escape($info['s3_main_text_2']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Image 2 Details (Ar)</label>
                                <input type="text" name="s3_main_text_2_ar" class="form-control form-input" value="<?php echo html_escape($info['s3_main_text_2_ar']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-3">
                            <div class="form-group">
                                <label class="control-label">Image 3 (60X56px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        <?php echo trans('select_image'); ?>
                                        <input type="file" name="s3_main_image_3" accept=".png" onchange="$('#upload-file-info7').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info7"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Image 3 Details</label>
                                <input type="text" name="s3_main_text_3" class="form-control form-input" value="<?php echo html_escape($info['s3_main_text_3']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Image 3 Details (Ar)</label>
                                <input type="text" name="s3_main_text_3_ar" class="form-control form-input" value="<?php echo html_escape($info['s3_main_text_3_ar']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-3">
                            <div class="form-group">
                                <label class="control-label">Image 4 (60X56px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        <?php echo trans('select_image'); ?>
                                            <input type="file" name="s3_main_image_4" accept=".png" onchange="$('#upload-file-info8').html($(this).val());">
                                    </a>
                                        (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info8"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Image 4 Details</label>
                                <input type="text" name="s3_main_text_4" class="form-control form-input" value="<?php echo html_escape($info['s3_main_text_4']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Image 4 Details (Ar)</label>
                                <input type="text" name="s3_main_text_4_ar" class="form-control form-input" value="<?php echo html_escape($info['s3_main_text_4_ar']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-3">
                            <div class="form-group">
                                <label class="control-label">Image 5 (60X56px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        <?php echo trans('select_image'); ?>
                                        <input type="file" name="s3_main_image_5" accept=".png" onchange="$('#upload-file-info9').html($(this).val());">
                                        </a>
                                        (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info9"></span>
                            </div>
                        </div>
                        <div class="col col-md-3">    
                            <div class="form-group">
                                <label class="control-label">Image 5 Details</label>
                                <input type="text" name="s3_main_text_5" class="form-control form-input" value="<?php echo html_escape($info['s3_main_text_5']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-3">    
                            <div class="form-group">
                                <label class="control-label">Image 5 Details (Ar)</label>
                                <input type="text" name="s3_main_text_5_ar" class="form-control form-input" value="<?php echo html_escape($info['s3_main_text_5_ar']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-12">
                            <div class="form-group">
                                <label class="control-label"> Video URL</label>
                                <input type="url" name="s3_video_url" class="form-control form-input" value="<?php echo html_escape($info['s3_video_url']); ?>" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-box">
                <div class="form-box-head">
                    <h4 class="title">Section 4</h4>
                </div>
                <div class="form-box-body">
                    <div class="row">
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label"><?php echo trans("title"); ?></label>
                                <input type="text" name="s4_heading" class="form-control form-input" value="<?php echo html_escape($info['s4_heading']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label"><?php echo trans("title"); ?> (Ar)</label>
                                <input type="text" name="s4_heading_ar" class="form-control form-input" value="<?php echo html_escape($info['s4_heading_ar']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Image (975X360px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        <?php echo trans('select_image'); ?>
                                        <input type="file" name="s4_image" accept=".png" onchange="$('#upload-file-info10').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info10"></span>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?php echo trans('description'); ?></label>
                                <textarea name="s4_details" class="text-editor" id="s4_details"><?php echo $info['s4_details']; ?></textarea>
                                <script>CKEDITOR.replace( 's4_details',{width : "100%",height : "200px",}).setData();</script>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?php echo trans('description'); ?> (Ar)</label>
                                <textarea name="s4_details_ar" class="text-editor" id="s4_details_ar"><?php echo $info['s4_details_ar']; ?></textarea>
                                <script>CKEDITOR.replace( 's4_details_ar',{width : "100%",height : "200px",}).setData();</script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-box">
                <div class="form-box-head">
                    <h4 class="title">Section 5/6 (Reviews)</h4>
                </div>
                <div class="form-box-body">
                    <div class="row">
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label"><?php echo trans("title"); ?></label>
                                <input type="text" name="s5_heading" class="form-control form-input" value="<?php echo html_escape($info['s5_heading']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo trans("title"); ?> (Ar)</label>
                                <input type="text" name="s5_heading_ar" class="form-control form-input" value="<?php echo html_escape($info['s5_heading_ar']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-4">                    
                            <div class="form-group">
                                <label class="control-label">Section Top Banner Image (884X293px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        <?php echo trans('select_image'); ?>
                                        <input type="file" name="s5_image" accept=".png" onchange="$('#upload-file-info11').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info11"></span>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Section Bottom Banner Image (710X480px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        <?php echo trans('select_image'); ?>
                                        <input type="file" name="s6_review_image" accept=".png" onchange="$('#upload-file-info15').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info15"></span>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Review 1 Image (300X300px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        <?php echo trans('select_image'); ?>
                                        <input type="file" name="s6_review_image_1" accept=".png" onchange="$('#upload-file-info12').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info12"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Review 1  Name</label>
                                <input type="text" name="s6_review_name_1" class="form-control form-input" value="<?php echo html_escape($info['s6_review_name_1']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Review 1  Age, City</label>
                                <input type="text" name="s6_review_location_1" class="form-control form-input" value="<?php echo html_escape($info['s6_review_location_1']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Review 1  Comment</label>
                                <input type="text" name="s6_review_comment_1" class="form-control form-input" value="<?php echo html_escape($info['s6_review_comment_1']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Review 1  Comment (Ar)</label>
                                <input type="text" name="s6_review_comment_1_ar" class="form-control form-input" value="<?php echo html_escape($info['s6_review_comment_1_ar']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Review 2 Image (300X300px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        <?php echo trans('select_image'); ?>
                                        <input type="file" name="s6_review_image_2" accept=".png" onchange="$('#upload-file-info13').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info13"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Review 2  Name</label>
                                <input type="text" name="s6_review_name_2" class="form-control form-input" value="<?php echo html_escape($info['s6_review_name_2']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Review 2  Age, City</label>
                                <input type="text" name="s6_review_location_2" class="form-control form-input" value="<?php echo html_escape($info['s6_review_location_2']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Review 2  Comment</label>
                                <input type="text" name="s6_review_comment_2" class="form-control form-input" value="<?php echo html_escape($info['s6_review_comment_2']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Review 2  Comment (Ar)</label>
                                <input type="text" name="s6_review_comment_2_ar" class="form-control form-input" value="<?php echo html_escape($info['s6_review_comment_2_ar']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Review 3 Image (300X300px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        <?php echo trans('select_image'); ?>
                                        <input type="file" name="s6_review_image_3" accept=".png" onchange="$('#upload-file-info14').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info14"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Review 3  Name</label>
                                <input type="text" name="s6_review_name_3" class="form-control form-input" value="<?php echo html_escape($info['s6_review_name_3']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Review 3  Age, City</label>
                                <input type="text" name="s6_review_location_3" class="form-control form-input" value="<?php echo html_escape($info['s6_review_location_3']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Review 3  Comment</label>
                                <input type="text" name="s6_review_comment_3" class="form-control form-input" value="<?php echo html_escape($info['s6_review_comment_3']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Review 3  Comment (Ar)</label>
                                <input type="text" name="s6_review_comment_3_ar" class="form-control form-input" value="<?php echo html_escape($info['s6_review_comment_3_ar']); ?>" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-box">
                <div class="form-box-head">
                    <h4 class="title">Section 7 (Suggested Product)</h4>
                </div>
                <div class="form-box-body">
                    <div class="row">
                        <div class="col col-md-2">
                            <div class="form-group">
                                <label class="control-label">Product ID </label>
                                <input type="text" name="s11_cross_sale_id" class="form-control form-input" value="<?php echo html_escape($info['s11_cross_sale_id']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Product Name </label>
                                <input type="text" name="s7_heading" class="form-control form-input" value="<?php echo html_escape($info['s7_heading']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Product Name (Ar)</label>
                                <input type="text" name="s7_heading_ar" class="form-control form-input" value="<?php echo html_escape($info['s7_heading_ar']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-2">
                            <div class="form-group">
                                <label class="control-label">Image (430X410px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        <?php echo trans('select_image'); ?>
                                        <input type="file" name="s7_image" accept=".png" onchange="$('#upload-file-info16').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info16"></span>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="control-label">Suggested Product <?php echo trans('description'); ?></label>
                                <textarea name="s7_details" class="text-editor" id="s7_details"><?php echo $info['s7_details']; ?></textarea>
                                <script>CKEDITOR.replace( 's7_details',{width : "100%",height : "200px",}).setData();</script>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="control-label">Suggested Product <?php echo trans('description'); ?> (Ar)</label>
                                <textarea name="s7_details_ar" class="text-editor" id="s7_details_ar"><?php echo $info['s7_details_ar']; ?></textarea>
                                <script>CKEDITOR.replace( 's7_details_ar',{width : "100%",height : "200px",}).setData();</script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-box form-box-body">
                <div class="row">
                    <div class="col col-md-12">
                        <div class="form-group">
                            <label class="control-label">Section 8 <?php echo trans("title"); ?></label>
                            <input type="text" name="s8_heading" class="form-control form-input" value="<?php echo html_escape($info['s8_heading']); ?>" required>
                        </div>
                    </div>
                    <div class="col col-md-12">
                        <div class="form-group">
                            <label class="control-label">Section 8 <?php echo trans("title"); ?> (Ar)</label>
                            <input type="text" name="s8_heading_ar" class="form-control form-input" value="<?php echo html_escape($info['s8_heading_ar']); ?>" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-box">
                <div class="form-box-head">
                    <h4 class="title">Section 9</h4>
                </div>
                <div class="form-box-body">
                    <div class="row">
                        <div class="col col-md-12">
                            <div class="form-group">
                                <label class="control-label">Avg Cost Description</label>
                                <input type="text" name="s9_details" class="form-control form-input" value="<?php echo html_escape($info['s9_details']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-12">
                            <div class="form-group">
                                <label class="control-label">Avg Cost Description (Ar)</label>
                                <input type="text" name="s9_details_ar" class="form-control form-input" value="<?php echo html_escape($info['s9_details_ar']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-5">
                            <div class="form-group">
                                <label class="control-label"><?php echo trans("title"); ?></label>
                                <input type="text" name="s9_heading" class="form-control form-input" value="<?php echo html_escape($info['s9_heading']); ?>" required>
                            </div>
                        </div> 
                        <div class="col col-md-5">
                            <div class="form-group">
                                <label class="control-label"><?php echo trans("title"); ?> (Ar)</label>
                                <input type="text" name="s9_heading_ar" class="form-control form-input" value="<?php echo html_escape($info['s9_heading_ar']); ?>" required>
                            </div>
                        </div> 
                        <div class="col col-md-2">
                            <div class="form-group">
                                <label class="control-label">Image (500X695px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        <?php echo trans('select_image'); ?>
                                        <input type="file" name="s9_image" accept=".png" onchange="$('#upload-file-info17').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info17"></span>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?php echo trans('description'); ?></label>
                                <textarea name="s9_description" class="text-editor" id="s9_description"><?php echo $info['s9_description']; ?></textarea>
                                <script>CKEDITOR.replace( 's9_description',{width : "100%",height : "200px",}).setData();</script>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?php echo trans('description'); ?> (Ar)</label>
                                <textarea name="s9_description_ar" class="text-editor" id="s9_description_ar"><?php echo $info['s9_description_ar']; ?></textarea>
                                <script>CKEDITOR.replace( 's9_description_ar',{width : "100%",height : "200px",}).setData();</script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-box">
                <div class="form-box-head">
                    <h4 class="title">Section 10 (Guarantee)</h4>
                </div>
                <div class="form-box-body">
                    <div class="row">
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Guarantee <?php echo trans("title"); ?></label>
                                <input type="text" name="s10_description" class="form-control form-input" value="<?php echo html_escape($info['s10_description']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Guarantee <?php echo trans("title"); ?> (Ar)</label>
                                <input type="text" name="s10_description_ar" class="form-control form-input" value="<?php echo html_escape($info['s10_description_ar']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Guarantee Point 1</label>
                                <input type="text" name="s10_point_1" class="form-control form-input" value="<?php echo html_escape($info['s10_point_1']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Guarantee Point 1 (Ar)</label>
                                <input type="text" name="s10_point_1_ar" class="form-control form-input" value="<?php echo html_escape($info['s10_point_1_ar']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label class="control-label">Guarantee Point 2</label>
                                <input type="text" name="s10_point_2" class="form-control form-input" value="<?php echo html_escape($info['s10_point_2']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Guarantee Point 2 (Ar)</label>
                                <input type="text" name="s10_point_2_ar" class="form-control form-input" value="<?php echo html_escape($info['s10_point_2_ar']); ?>" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-box">
                <div class="form-box-head">
                    <h4 class="title">Section 11 (Buy Now)</h4>
                </div>
                <div class="form-box-body">
                    <div class="row">
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="control-label"> Main Product <?php echo trans("title"); ?></label>
                                <input type="text" name="s11_product_title" class="form-control form-input" value="<?php echo html_escape($info['s11_product_title']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="control-label"> Main Product <?php echo trans("title"); ?> (Ar)</label>
                                <input type="text" name="s11_product_title_ar" class="form-control form-input" value="<?php echo html_escape($info['s11_product_title_ar']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="form-group">
                                <label class="control-label">Suggested Product Image (300X136px)</label>
                                <div class="display-block">
                                    <a class='btn btn-success btn-sm btn-file-upload'>
                                        <?php echo trans('select_image'); ?>
                                        <input type="file" name="s11_cross_sale_image" accept=".png" onchange="$('#upload-file-info18').html($(this).val());">
                                    </a>
                                    (.png)
                                </div>
                                <span class='label label-info' id="upload-file-info18"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-box">
                <div class="form-box-head">
                    <h4 class="title">Terms & Conditions</h4>
                </div>
                <div class="form-box-body">
                    <div class="row">
                        <div class="col col-md-12">
                            <div class="form-group">
                                <label class="control-label">Link <?php echo trans("title"); ?></label>
                                <input type="text" name="terms_condition_heading" class="form-control form-input" value="<?php echo html_escape($info['terms_condition_heading']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Link <?php echo trans("title"); ?> (Ar)</label>
                                <input type="text" name="terms_condition_heading_ar" class="form-control form-input" value="<?php echo html_escape($info['terms_condition_heading_ar']); ?>" required>
                            </div>
                        </div>
                        <div class="col col-md-12">
                            <div class="form-group">
                                <label class="control-label"><?php echo trans('description'); ?></label>
                                <textarea name="terms_conditions" class="text-editor" id="s9_description"><?php echo $info['terms_conditions']; ?></textarea>
                                <script>CKEDITOR.replace( 'terms_conditions',{width : "100%",height : "200px",}).setData();</script>
                            </div>
                        </div>
                        <div class="col col-md-12">
                            <div class="form-group">
                                <label class="control-label"><?php echo trans('description'); ?> (Ar)</label>
                                <textarea name="terms_conditions_ar" class="text-editor" id="s9_description_ar"><?php echo $info['terms_conditions_ar']; ?></textarea>
                                <script>CKEDITOR.replace( 'terms_conditions_ar',{width : "100%",height : "200px",}).setData();</script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-box">
                <div class="form-box-head">
                    <h4 class="title">Frequently Asked Questions (FAQ)</h4>
                </div>
                <div class="form-box-body">
                    <div class="row">
                        <div class="col col-md-12">
                            <div class="form-group">
                                <label class="control-label">Link <?php echo trans("title"); ?></label>
                                <input type="text" name="faq_heading" class="form-control form-input" value="<?php echo html_escape($info['faq_heading']); ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Link <?php echo trans("title"); ?> (Ar)</label>
                                <input type="text" name="faq_heading_ar" class="form-control form-input" value="<?php echo html_escape($info['faq_heading_ar']); ?>">
                            </div>
                        </div>
                        <div class="col col-md-12">
                            <div class="form-group">
                                <label class="control-label"><?php echo trans('description'); ?></label>
                                <textarea name="faq_details" class="text-editor" id="faq_details"><?php echo $info['faq_details']; ?></textarea>
                                <script>CKEDITOR.replace( 'faq_details',{width : "100%",height : "200px",}).setData();</script>
                            </div>
                        </div>
                        <div class="col col-md-12">
                            <div class="form-group">
                                <label class="control-label"><?php echo trans('description'); ?> (Ar)</label>
                                <textarea name="faq_details_ar" class="text-editor" id="faq_details_ar"><?php echo $info['faq_details_ar']; ?></textarea>
                                <script>CKEDITOR.replace( 'faq_details_ar',{width : "100%",height : "200px",}).setData();</script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-custom" data-dismiss="modal"><?php echo trans("close");?></button>
            <button type="submit" class="btn btn-primary text-white"><?php echo trans("update_product");?></button>
        </div>
        <?php echo form_close(); ?>
    </div>
  </div>
</div>