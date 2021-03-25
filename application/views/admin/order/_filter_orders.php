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
            <label><?php echo trans("status"); ?></label>
            <select name="status" class="form-control">
                <option value="" selected><?php echo trans("all"); ?></option>
            <?php if($this->uri->segment(2) == orders){ ?>
                
                <option value="confirmed" <?php echo ($this->input->get('status', true) == 'confirmed') ? 'selected' : ''; ?>><?php echo trans("confirmed"); ?></option>
                <option value="completed" <?php echo ($this->input->get('status', true) == 'completed') ? 'selected' : ''; ?>><?php echo trans("completed"); ?></option>
                <option value="cancelled" <?php echo ($this->input->get('status', true) == 'cancelled') ? 'selected' : ''; ?>><?php echo trans("cancelled"); ?></option>
                <option value="processing" <?php echo ($this->input->get('status', true) == 'processing') ? 'selected' : ''; ?>><?php echo trans("order_processing"); ?></option>
                <option value="scheduled" <?php echo ($this->input->get('status', true) == 'scheduled') ? 'selected' : ''; ?>><?php echo trans("scheduled"); ?></option>
                <option value="new" <?php echo ($this->input->get('status', true) == 'new') ? 'selected' : ''; ?>><?php echo trans("new"); ?></option>
                <option value="returned" <?php echo ($this->input->get('status', true) == 'returned') ? 'selected' : ''; ?>><?php echo trans("returned"); ?></option>
            <?php } ?>
                <option value="return_and_refund_request" <?php echo ($this->input->get('status', true) == 'return_and_refund_request') ? 'selected' : ''; ?>><?php echo trans("return_and_refund_request"); ?></option>
                <option value="in_return_process" <?php echo ($this->input->get('status', true) == 'in_return_process') ? 'selected' : ''; ?>><?php echo trans("in_return_process"); ?></option>
                <option value="return_process_done" <?php echo ($this->input->get('status', true) == 'return_process_done') ? 'selected' : ''; ?>><?php echo trans("return_process_done"); ?></option>
                <option value="refund_quested" <?php echo ($this->input->get('status', true) == 'refund_quested') ? 'selected' : ''; ?>><?php echo trans("refund_quested"); ?></option>
                <option value="refunded" <?php echo ($this->input->get('status', true) == 'refunded') ? 'selected' : ''; ?>><?php echo trans("refunded"); ?></option>
            </select>
        </div>

        <div class="item-table-filter">
            <label><?php echo trans("payment_status"); ?></label>
            <select name="payment_status" class="form-control">
                <option value="" selected><?php echo trans("all"); ?></option>
                <option value="payment_received" <?php echo ($this->input->get('payment_status', true) == 'payment_received') ? 'selected' : ''; ?>><?php echo trans("payment_received"); ?></option>
                <option value="awaiting_payment" <?php echo ($this->input->get('payment_status', true) == 'awaiting_payment') ? 'selected' : ''; ?>><?php echo trans("awaiting_payment"); ?></option>
            </select>
        </div>

        <div class="item-table-filter">
            <label><?php echo trans("search"); ?></label>
            <input name="q" class="form-control" placeholder="<?php echo trans("order_id"); ?>" type="search" value="<?php echo html_escape($this->input->get('q', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
        </div>

        <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
            <label style="display: block">&nbsp;</label>
            <button type="submit" class="btn bg-purple"><?php echo trans("filter"); ?></button>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>