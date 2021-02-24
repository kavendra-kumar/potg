<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $title; ?></h3>
    </div><!-- /.box-header -->

    <div class="box-body">
        <div class="row">
            <!-- include message block -->
            <div class="col-sm-12">
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>
        </div>
        <?php echo form_open_multipart('product_admin_controller/save_addon_products'); ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <?php //$this->load->view('admin/product/_filter_products'); ?>
                        <thead>
                        <tr role="row">
                            <th width="20"><input type="checkbox" class="checkbox-table" id="checkAll"></th>
                            <th width="20"><?php echo trans('id'); ?></th>
                            <th><?php echo trans('product'); ?></th>
                            <th><?php echo trans('sku'); ?></th>
                            <th><?php echo trans('product_type'); ?></th>
                            <th><?php echo trans('category'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($products as $item): ?>
                            
                            <tr>
                                <td><input type="checkbox" name="product_id[]" class="checkbox-table" value="<?php echo $item->id; ?>" <?php if( in_array($item->id, $addon) ) echo "checked"; ?> ></td>
                                <td><?php echo html_escape($item->id); ?></td>
                                <td class="td-product">
                                    <?php if ($item->is_promoted == 1): ?>
                                        <label class="label label-success"><?php echo trans("featured"); ?></label>
                                    <?php endif; ?>
                                    <div class="img-table" style="height: 100px;">
                                        <a href="<?php echo generate_product_url($item); ?>" target="_blank">
                                            <img src="<?php echo get_product_image($item->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image"/>
                                        </a>
                                    </div>
                                    <a href="<?php echo generate_product_url($item); ?>" target="_blank" class="table-product-title">
                                        <?php echo html_escape($item->title); ?>
                                    </a>
                                </td>
                                <td><?php echo $item->sku; ?></td>
                                <td><?php echo trans($item->product_type); ?></td>
                                <td>
                                    <?php $categories_array = get_parent_categories_array($item->category_id);
                                    if (!empty($categories_array)) {
                                        foreach ($categories_array as $item_array) {
                                            $item_category = get_category_by_id($item_array->id);
                                            if (!empty($item_category)) {
                                                echo @html_escape($item_category->name) . "<br>";
                                            }
                                        }
                                    } ?>
                                </td>
                                
                            </tr>
                            
                        <?php endforeach; ?>

                        </tbody>
                    </table>

                    <?php if (empty($products)): ?>
                        <p class="text-center">
                            <?php echo trans("no_records_found"); ?>
                        </p>
                    <?php endif; ?>
                    <div class="col-sm-12 table-ft">
                        <div class="row">

                            <div class="pull-right">
                                <?php echo $this->pagination->create_links(); ?>
                            </div>
                            <?php if (count($products) > 0): ?>
                                <div class="pull-left">
                                    <input type="submit" class="btn btn-sm btn-info" value="<?php echo trans('submit'); ?>" name="submit" />
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        </form>
    </div><!-- /.box-body -->
</div>
