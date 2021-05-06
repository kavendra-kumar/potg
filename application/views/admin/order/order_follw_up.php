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
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <div class="row table-filter-container">
                            <div class="col-sm-12">
                                <?php echo form_open($form_action, ['method' => 'GET']); ?>

                                <div class="item-table-filter" style="width: 80px; min-width: 80px;">
                                    <label><?php echo trans("show"); ?></label>
                                    <select name="show" class="form-control">
                                        <option value="15" <?php echo ($this->input->get('show', true) == '15') ? 'selected' : ''; ?>>15</option>
                                        <option value="30" <?php echo ($this->input->get('show', true) == '30') ? 'selected' : ''; ?>>30</option>
                                        <option value="60" <?php echo ($this->input->get('show', true) == '60') ? 'selected' : ''; ?>>60</option>
                                        <option value="100" <?php echo ($this->input->get('show', true) == '100') ? 'selected' : ''; ?>>100</option>
                                    </select>
                                </div>

                                <div class="item-table-filter">
                                    <label><?php echo trans("search"); ?></label>
                                    <input name="order_number" class="form-control" placeholder="<?php echo trans("order_id"); ?>" type="search" value="<?php echo html_escape($this->input->get('order_number', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                                </div>

                                <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                                    <label style="display: block">&nbsp;</label>
                                    <button type="submit" class="btn bg-purple"><?php echo trans("filter"); ?></button>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        <thead>
                        <tr role="row">
                            <th><?php echo trans('id'); ?></th>
                            <th><?php echo trans('order_id'); ?></th>
                            <th><?php echo trans('task'); ?></th>
                            <th><?php echo trans('comment'); ?></th>
                            <th><?php echo trans('status'); ?></th>
                            <th><?php echo trans('created_by'); ?></th>
                            <th><?php echo trans('assign_to'); ?></th>
                            <th><?php echo trans('reminder_date'); ?></th>
                            <th><?php echo trans('reminder_time'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($order_follw_up as $item): ?>
                            <tr>
                                <td><?php echo $item->id; ?></td>
                                <td><a href="<?php echo base_url(); ?>admin/order-details/<?php echo $item->order_id; ?>"  target="_blank"><?php echo $item->order_id; ?></a></td>
                                <td><?php echo $item->task; ?></td>
                                <td><?php echo $item->comment; ?></td>
                                <td>
                                    <?php echo ($item->status == 0)?"Open":"Closed"; ?>
                                </td>
                                <td>
                                    <?php
                                    if($item->created_by){
                                    $inf = get_user($item->created_by);
                                    echo $inf->first_name.' '.$inf->last_name; } ?>
                                </td>
                                <td>
                                    <?php
                                    if($item->assign_to){
                                        $assign_to = explode(',', $item->assign_to);
                                        $name_arr = array();
                                        foreach($assign_to as $uid){
                                            $inf = get_user($uid);
                                            //echo "<pre>"; print_r($inf); 
                                            if(count((array)$inf)) {

                                                echo "<p>".$inf->first_name.' '.$inf->last_name."</p>";

                                            } 

                                        }
                                    } else {}
                                    ?>
                                </td>
                                <td><?php echo $item->reminder_date; ?><?php if( strtotime($item->reminder_date) < strtotime(date('Y-m-d')) ) { ?><p><small class="btn bg-danger" style="color:#ffff">Overdue</small></p> <?php } ?></td>
                                <td><?php echo $item->reminder_time; ?></td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>

                    <?php if (empty($order_follw_up)): ?>
                        <p class="text-center">
                            <?php echo trans("no_records_found"); ?>
                        </p>
                    <?php endif; ?>
                    <div class="col-sm-12 table-ft">
                        <div class="row">
                            <div class="pull-right">
                                <?php echo $this->pagination->create_links(); ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>
