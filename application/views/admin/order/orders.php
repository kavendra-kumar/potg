<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
input.checkbox {
    width: 20px;
    height: 20px;
}
</style>

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
						<?php $this->load->view('admin/order/_filter_orders'); ?>
						<thead>
						<tr role="row">
							<th><input type="checkbox" name="all" value="1" id="all" class="checkbox all" />All</th>
							<th><?php echo trans('order'); ?></th>
							<th><?php echo trans('buyer'); ?></th>
							<th><?php echo trans('total'); ?></th>
							<th><?php echo trans('currency'); ?></th>
							<th><?php echo trans('status'); ?></th>
							<th><?php echo trans('payment_status'); ?></th>
							<th>Shipping Status</th>
							<th><?php echo trans('updated'); ?></th>
							<th><?php echo trans('date'); ?></th>
							<th class="max-width-120"><?php echo trans('options'); ?></th>
						</tr>
						</thead>
						<tbody>
						<?php echo form_open('order_admin_controller/orders_export'); ?>
						<?php foreach ($orders as $item): ?>

							<?php //echo "<pre>"; print_r($item); exit; ?>
							<tr>
								<td>
									<input type="checkbox" name="order_ids[]" value="<?php echo html_escape($item->id); ?>" class="checkbox orders_export" />
								</td>

								<td class="order-number-table">
									<a href="<?php echo admin_url(); ?>order-details/<?php echo html_escape($item->id); ?>" class="table-link">
										#<?php echo html_escape($item->order_number); ?>
									</a>
								</td>
								<td>
									<?php if ($item->buyer_id == 0): ?>
										<div class="table-orders-user">
											<img src="<?php echo get_user_avatar(null); ?>" alt="buyer" class="img-responsive" style="height: 50px;">
											<?php $shipping = get_order_shipping($item->id);
											if (!empty($shipping)): ?>
												<span><?php echo $shipping->shipping_first_name . " " . $shipping->shipping_last_name; ?></span>
											<?php endif; ?>
											<label class="label bg-olive" style="position: absolute;top: 0; left: 0;"><?php echo trans("guest"); ?></label>
										</div>
									<?php else:
										$buyer = get_user($item->buyer_id);
										if (!empty($buyer)):?>
											<div class="table-orders-user">
												<a href="<?php echo generate_profile_url($buyer->slug); ?>" target="_blank">
													<img src="<?php echo get_user_avatar($buyer); ?>" alt="buyer" class="img-responsive" style="height: 50px;">
													<?php echo html_escape($buyer->username); ?>
												</a>
											</div>
										<?php endif;
									endif;
									?>
								</td>
								<td><strong><?php echo price_formatted($item->price_total, $item->price_currency); ?></strong></td>
								<td><?php echo $item->price_currency; ?></td>

								<td>
								<?php if ($item->status == 1): ?>
                                    <label class="label label-success"><?php echo trans("completed"); ?></label>
                                <?php elseif ($item->status == 2): ?>
                                    <label class="label label-warning"><?php echo trans("confirmed"); ?></label>
                                <?php elseif ($item->status == 3): ?>
                                    <label class="label label-danger"><?php echo trans("cancelled"); ?></label>
                                <?php elseif ($item->status == 4): ?>
                                    <label class="label label-primary"><?php echo trans("shipped"); ?></label>
                                <?php elseif ($item->status == 5): ?>
                                    <label class="label label-success"><?php echo trans("payment_received"); ?></label>
                                <?php elseif ($item->status == 6): ?>
                                    <label class="label label-danger"><?php echo trans("awaiting_payment"); ?></label>
								<?php elseif ($item->status == 7): ?>
                                    <label class="label label-info"><?php echo trans("order_processing"); ?></label>
								<?php elseif ($item->status == 8): ?>
                                    <label class="label label-info"><?php echo trans("scheduled"); ?></label>
								<?php elseif ($item->status == 9): ?>
                                	<label class="label label-danger"><?php echo trans("returned"); ?></label>
								<?php elseif ($item->status == 10): ?>
                                	<label class="label label-danger"><?php echo trans("return_and_refund_request"); ?></label>
								<?php elseif ($item->status == 11): ?>
                                	<label class="label label-danger"><?php echo trans("in_return_process"); ?></label>
								<?php elseif ($item->status == 12): ?>
                                	<label class="label label-danger"><?php echo trans("return_process_done"); ?></label>
								<?php elseif ($item->status == 13): ?>
                                	<label class="label label-danger"><?php echo trans("refund_quested"); ?></label>
								<?php elseif ($item->status == 14): ?>
                                	<label class="label label-danger"><?php echo trans("refunded"); ?></label>
								
								<?php else: ?>
									<label class="label label-default"><?php echo trans("new"); ?></label>
                                <?php endif; ?>
								</td>

								<td>
									<?php echo trans($item->payment_status); ?>
								</td>
								<td>
									<?php echo $item->smsa_status; ?>
								</td>
								<td><?php echo time_ago($item->updated_at); ?></td>
								<td> <?php echo formatted_date($item->created_at); ?></td>
								<td>
									<?php echo form_open_multipart('order_admin_controller/order_options_post'); ?>
									<input type="hidden" name="id" value="<?php echo $item->id; ?>">
									<div class="dropdown">
										<button class="btn bg-purple dropdown-toggle btn-select-option"
												type="button"
												data-toggle="dropdown"><?php echo trans('select_option'); ?>
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu options-dropdown" style="min-width: 190px;">
											<li>
												<a href="<?php echo admin_url(); ?>order-details/<?php echo html_escape($item->id); ?>"><i class="fa fa-info option-icon"></i><?php echo trans('view_details'); ?></a>
											</li>
											<?php /* 
											<li>
												<?php if ($item->payment_status != 'payment_received'): ?>
													<button type="submit" name="option" value="payment_received" class="btn-list-button">
														<i class="fa fa-check option-icon"></i><?php echo trans('payment_received'); ?>
													</button>
												<?php endif; ?>
											</li>
											<li>
												<a href="javascript:void(0)" onclick="delete_item('order_admin_controller/delete_order_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
											</li>
											*/ ?>
										</ul>
									</div>
									<?php //echo form_close(); ?><!-- form end -->
								</td>
							</tr>

						<?php endforeach; ?>

						</tbody>
					</table>

					<?php if (empty($orders)): ?>
						<p class="text-center">
							<?php echo trans("no_records_found"); ?>
						</p>
					<?php endif; ?>
					<div class="col-sm-12 table-ft">
						<div class="row">
							<?php if($this->session->userdata['modesy_sess_user_id'] == 1 || $this->session->userdata['modesy_sess_user_id'] == 1739 || $this->session->userdata['modesy_sess_user_id'] == 806) { ?>
							<div class="pull-left">
								<button type="submit" class="btn bg-purple export"><?php echo trans("export"); ?></button>
								<?php echo form_close(); ?>
							</div>

							<div class="pull-left" style="margin-left: 10px;">
								<?php echo form_open('order_admin_controller/all_orders_export'); ?>
									<button type="submit" class="btn bg-purple export"><?php echo trans("export"); ?> All Orders</button>
								<?php echo form_close(); ?>
							</div>
							<?php } ?>

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

<script>
$('#all').click(function(event) {   
    if(this.checked) {
        // Iterate each checkbox
        $(':checkbox').each(function() {
            this.checked = true;                        
        });
    } else {
        $(':checkbox').each(function() {
            this.checked = false;                       
        });
    }
});
</script>