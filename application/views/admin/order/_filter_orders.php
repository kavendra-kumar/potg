<div class="row table-filter-container">
    <div class="col-sm-12">
    
        <?php echo form_open($form_action, ['method' => 'GET']); ?>

        <div class="item-table-filter col-md-1" style="width: 100px; min-width: 100px;">
            <label><?php echo trans("show"); ?></label>
            <select name="show" class="form-control">
                <option value="15" <?php echo ($this->input->get('show', true) == '15') ? 'selected' : ''; ?>>15</option>
                <option value="30" <?php echo ($this->input->get('show', true) == '30') ? 'selected' : ''; ?>>30</option>
                <option value="60" <?php echo ($this->input->get('show', true) == '60') ? 'selected' : ''; ?>>60</option>
                <option value="100" <?php echo ($this->input->get('show', true) == '100') ? 'selected' : ''; ?>>100</option>
                <option value="100000" <?php echo ($this->input->get('show', true) == '100000') ? 'selected' : ''; ?>>All</option>
            </select>
        </div>

        <div class="item-table-filter col-md-2">
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
        <div class="item-table-filter col-md-2">
            <label><?php echo trans("payment_status"); ?></label>
            <select name="payment_status" class="form-control">
                <option value="" selected><?php echo trans("all"); ?></option>
                <option value="payment_received" <?php echo ($this->input->get('payment_status', true) == 'payment_received') ? 'selected' : ''; ?>><?php echo trans("payment_received"); ?></option>
                <option value="awaiting_payment" <?php echo ($this->input->get('payment_status', true) == 'awaiting_payment') ? 'selected' : ''; ?>><?php echo trans("awaiting_payment"); ?></option>
            </select>
        </div>


        <?php if($this->uri->segment(2) == orders){ ?>

        <div class="item-table-filter col-md-2">
            <label><?php echo trans("country"); ?></label>
            <select name="country" class="form-control">
                <option value="">Select Country</option>
                <?php if($countries){
                    foreach($countries as $obj){ ?>
                        <option value="<?php echo $obj->name; ?>" <?php echo ($this->input->get('country', true) == $obj->name) ? 'selected' : ''; ?>><?php echo $obj->name; ?></option>
                <?php } } ?>
            </select>
        </div>

        <div class="item-table-filter col-md-2">
            <label><?php echo trans("date"); ?></label>
            <div class="input-group" bis_skin_checked="1">
                <input name="date_range" class="form-control" id="reportrange">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>
        </div>

        <div class="item-table-filter col-md-2">
            <label><?php echo trans("search").' '.trans("phone"); ?></label>
            <input name="search_phone" class="form-control" placeholder="<?php echo trans("phone"); ?>" type="search" value="<?php echo html_escape($this->input->get('search_phone', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
        </div>
        
        <?php } ?>

        
        <div class="item-table-filter col-md-3">
            <label><?php echo trans("search").' '.trans("order_number"); ?>s</label>
            <input name="q" class="form-control" placeholder="<?php echo trans("order_id"); ?>" type="search" value="<?php echo html_escape($this->input->get('q', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
        </div>


        <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
            <label style="display: block">&nbsp;</label>
            <button type="submit" class="btn bg-purple"><?php echo trans("filter"); ?></button>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>


<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
$(function() {
    <?php if($start){ ?>
	    var start = '<?php echo $start; ?>';
	    var to = '<?php echo $to; ?>';
	<?php } else { ?>
        var start = moment().subtract(29, 'days');
        var to = moment();
    <?php } ?>
	function cb(start, to) {
		$('#reportrange input').val(start + ' - ' + to);
	}

	$('#reportrange').daterangepicker({
        autoUpdateInput: <?php echo ($start) ? 'true' : 'false'; ?>,
		startDate: start,
		endDate: to,
		ranges: {
		   'Today': [moment(), moment()],
		   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
		   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
		   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
		   'This Month': [moment().startOf('month'), moment().endOf('month')],
		   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
		},
		"alwaysShowCalendars": true,
		locale: {
		  format: 'DD/MM/YYYY'
		}
	}, cb);

    $('input[name="date_range"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });
	
	cb(start, to);
	
});
$('form').attr('autocomplete', 'off');
</script>

<style>
.item-table-filter {
    margin-right: 0px;
    padding: 0px 5px;
    min-width: 120px;
}
</style>