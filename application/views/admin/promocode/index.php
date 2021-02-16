<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
.input-group .input-group-addon {
    border-radius: 0;
    border-color: #605ca8;
    background-color: #605ca8;
}

    </style>
<div class="row">

    <div class="col-lg-12 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Promo Code</h3>
				<button  data-toggle="modal" class="pull-right btn btn-xs btn-primary m-t-5" data-target="#AddPromocodeModal">+Add New Promo Code</button>
            
            </div><!-- /.box-header -->

            <!-- include message block -->
            <div class="col-sm-12">
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dataTable" id="cs_datatable_lang" role="grid"
                                   aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?php echo trans('id'); ?></th>
                                    <th><?php echo trans('promocode'); ?></th>
                                    <th><?php echo trans('promocode_type'); ?></th>
                                    <th><?php echo trans('discount'); ?></th>
                                    <th><?php echo trans('expiry_date'); ?></th>
                                    <th class="th-options"><?php echo trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($promocodes as $code): ?>
                                    <tr>
                                        <td><?php echo html_escape($code->id); ?></td>
                                        <td><?php echo html_escape($code->promocode); ?></td>
                                        <td><?php echo html_escape($code->promocodetype); ?></td>
                                        <td><?php echo html_escape($code->flat_discount); ?></td>
                                        <td><?php echo html_escape($code->last_date); ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                        type="button"
                                                        data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu options-dropdown">
                                                    <!-- <li>
                                                        <a href="<?php echo admin_url(); ?>update-slider-item/<?php echo html_escape($code->id); ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                                    </li> -->
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="delete_item('admin_controller/delete_promocode','<?php echo $code->id; ?>','<?php echo trans("confirm_promocode"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>
<div id="AddPromocodeModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php echo form_open('admin_controller/add_promocode'); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Promo Code</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php echo trans('country'); ?></label>
                                <select id="country" name="country" class="form-control" required>
                                <option value="" selected><?php echo trans("select_country"); ?></option>
                                <?php foreach ($this->countries as $item): ?>
                                    <option data-code="<?php echo $item->code; ?>" data-length="<?php echo $item->phone_length; ?>" value="<?php echo $item->id; ?>"><?php echo html_escape($item->name); ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label"><?php echo trans('category'); ?></label>
                                <select id="category" name="category" class="form-control" required>
                                <option value="" selected><?php echo trans("select_category"); ?></option>
                                <?php foreach ($this->countries as $item): ?>
                                    <option data-code="<?php echo $item->code; ?>" data-length="<?php echo $item->phone_length; ?>" value="<?php echo $item->id; ?>"><?php echo html_escape($item->name); ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                        <div class="form-group">
                        <label class="control-label"><?php echo trans('promocode'); ?></label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        
                                        <input type="text" style="text-transform:uppercase;" name="promocode" id="promocode" class="form-control" aria-describedby="basic-addon1" required="">
                                        <span class="input-group-addon btn btn-success" id="basic-addon1">Validate</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <span id="promocodestatus"></span>
                            
                        </div>
						<div class="form-group">
							<div class="row">
								<div class="col-sm-3 col-xs-12">
									<label><?php echo trans('promocode_type'); ?></label>
								</div>
								<div class="col-md-3 col-sm-12 col-xs-12 col-option">
									<input type="radio" name="promocodetype" value="0" id="flat_discount" class="square-purple" checked>
									<label for="flat_discount" class="option-label">Flat Discount</label>
								</div>
								<div class="col-md-3 col-sm-12 col-xs-12 col-option">
									<input type="radio" name="promocodetype" value="1" id="percetage_basis" class="square-purple">
									<label for="percetage_basis" class="option-label">% Basis</label>
								</div>
							</div>
						</div>						
						<div class="form-group">
                            <label class="control-label"><?php echo trans('discount'); ?></label>
                            <input type="text" name="discount" id="discount" class="form-control" required >
                        </div>
						<div class="form-group">
                            <label class="control-label">No of Use per User</label>
                            <input type="text" name="noofuse" id="noofuse" class="form-control" required >
                        </div>
						<div class="form-group">
                            <label class="control-label">Who can use?</label>
                           <select name="foruser" class="form-control">
						   <option value="0">All User</option>
						   </select>
                        </div>
						<div class="form-group">
                            <label class="control-label"><?php echo trans('expiry_date'); ?></label>
							<input type="date" name="enddate" id="enddate" class="form-control" required >
                          
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><?php echo trans("submit"); ?></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo trans("close"); ?></button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>

