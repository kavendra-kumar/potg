<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-confirm w-100">
                    <div class="circle-loader">
                        <div class="checkmark draw"></div>
                    </div>
					<h2 class="font-weight-bold"><?php echo trans("thank_you"); ?></h2>
                    <h1 class="title"><?php echo trans("msg_order_completed"); ?></h1>
                    <p class="p-order-number"><?php echo trans("order"); ?>:&nbsp;#<?php echo $order->order_number; ?></p>
                    <?php if($order->payment_method=="Bank Transfer"): ?>
                        <p class="p-complete-payment"><?php echo trans("msg_bank_transfer_text_order_completed"); ?></p>
                        <div class="bank-account-container">
                            <?php echo $this->payment_settings->bank_transfer_accounts; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
			<div class="col-4 mail-icon">
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 345.834 345.834" style="enable-background:new 0 0 345.834 345.834;" xml:space="preserve">
					<g>
						<path d="M339.798,260.429c0.13-0.026,0.257-0.061,0.385-0.094c0.109-0.028,0.219-0.051,0.326-0.084   c0.125-0.038,0.247-0.085,0.369-0.129c0.108-0.039,0.217-0.074,0.324-0.119c0.115-0.048,0.226-0.104,0.338-0.157   c0.109-0.052,0.22-0.1,0.327-0.158c0.107-0.057,0.208-0.122,0.312-0.184c0.107-0.064,0.215-0.124,0.319-0.194   c0.111-0.074,0.214-0.156,0.321-0.236c0.09-0.067,0.182-0.13,0.27-0.202c0.162-0.133,0.316-0.275,0.466-0.421   c0.027-0.026,0.056-0.048,0.083-0.075c0.028-0.028,0.052-0.059,0.079-0.088c0.144-0.148,0.284-0.3,0.416-0.46   c0.077-0.094,0.144-0.192,0.216-0.289c0.074-0.1,0.152-0.197,0.221-0.301c0.074-0.111,0.139-0.226,0.207-0.34   c0.057-0.096,0.118-0.19,0.171-0.289c0.062-0.115,0.114-0.234,0.169-0.351c0.049-0.104,0.101-0.207,0.146-0.314   c0.048-0.115,0.086-0.232,0.128-0.349c0.041-0.114,0.085-0.227,0.12-0.343c0.036-0.118,0.062-0.238,0.092-0.358   c0.029-0.118,0.063-0.234,0.086-0.353c0.028-0.141,0.045-0.283,0.065-0.425c0.014-0.1,0.033-0.199,0.043-0.3   c0.025-0.249,0.038-0.498,0.038-0.748V92.76c0-4.143-3.357-7.5-7.5-7.5h-236.25c-0.066,0-0.13,0.008-0.196,0.01   c-0.143,0.004-0.285,0.01-0.427,0.022c-0.113,0.009-0.225,0.022-0.337,0.037c-0.128,0.016-0.255,0.035-0.382,0.058   c-0.119,0.021-0.237,0.046-0.354,0.073c-0.119,0.028-0.238,0.058-0.356,0.092c-0.117,0.033-0.232,0.069-0.346,0.107   c-0.117,0.04-0.234,0.082-0.349,0.128c-0.109,0.043-0.216,0.087-0.322,0.135c-0.118,0.053-0.235,0.11-0.351,0.169   c-0.099,0.051-0.196,0.103-0.292,0.158c-0.116,0.066-0.23,0.136-0.343,0.208c-0.093,0.06-0.184,0.122-0.274,0.185   c-0.106,0.075-0.211,0.153-0.314,0.235c-0.094,0.075-0.186,0.152-0.277,0.231c-0.09,0.079-0.179,0.158-0.266,0.242   c-0.099,0.095-0.194,0.194-0.288,0.294c-0.047,0.05-0.097,0.094-0.142,0.145c-0.027,0.03-0.048,0.063-0.074,0.093   c-0.094,0.109-0.182,0.223-0.27,0.338c-0.064,0.084-0.13,0.168-0.19,0.254c-0.078,0.112-0.15,0.227-0.222,0.343   c-0.059,0.095-0.12,0.189-0.174,0.286c-0.063,0.112-0.118,0.227-0.175,0.342c-0.052,0.105-0.106,0.21-0.153,0.317   c-0.049,0.113-0.092,0.23-0.135,0.345c-0.043,0.113-0.087,0.225-0.124,0.339c-0.037,0.115-0.067,0.232-0.099,0.349   c-0.032,0.12-0.066,0.239-0.093,0.36c-0.025,0.113-0.042,0.228-0.062,0.342c-0.022,0.13-0.044,0.26-0.06,0.39   c-0.013,0.108-0.019,0.218-0.027,0.328c-0.01,0.14-0.019,0.28-0.021,0.421c-0.001,0.041-0.006,0.081-0.006,0.122v46.252   c0,4.143,3.357,7.5,7.5,7.5s7.5-3.357,7.5-7.5v-29.595l66.681,59.037c-0.348,0.245-0.683,0.516-0.995,0.827l-65.687,65.687v-49.288   c0-4.143-3.357-7.5-7.5-7.5s-7.5,3.357-7.5,7.5v9.164h-38.75c-4.143,0-7.5,3.357-7.5,7.5s3.357,7.5,7.5,7.5h38.75v43.231   c0,4.143,3.357,7.5,7.5,7.5h236.25c0.247,0,0.494-0.013,0.74-0.037c0.115-0.011,0.226-0.033,0.339-0.049   C339.542,260.469,339.67,260.454,339.798,260.429z M330.834,234.967l-65.688-65.687c-0.042-0.042-0.087-0.077-0.13-0.117   l49.383-41.897c3.158-2.68,3.546-7.412,0.866-10.571c-2.678-3.157-7.41-3.547-10.571-0.866l-84.381,71.59l-98.444-87.158h208.965   V234.967z M185.878,179.888c0.535-0.535,0.969-1.131,1.308-1.765l28.051,24.835c1.418,1.255,3.194,1.885,4.972,1.885   c1.726,0,3.451-0.593,4.853-1.781l28.587-24.254c0.26,0.38,0.553,0.743,0.89,1.08l65.687,65.687H120.191L185.878,179.888z"/>
						<path d="M7.5,170.676h126.667c4.143,0,7.5-3.357,7.5-7.5s-3.357-7.5-7.5-7.5H7.5c-4.143,0-7.5,3.357-7.5,7.5   S3.357,170.676,7.5,170.676z"/>
						<path d="M20.625,129.345H77.5c4.143,0,7.5-3.357,7.5-7.5s-3.357-7.5-7.5-7.5H20.625c-4.143,0-7.5,3.357-7.5,7.5   S16.482,129.345,20.625,129.345z"/>
						<path d="M62.5,226.51h-55c-4.143,0-7.5,3.357-7.5,7.5s3.357,7.5,7.5,7.5h55c4.143,0,7.5-3.357,7.5-7.5S66.643,226.51,62.5,226.51z"/>
					</g>
				</svg>
			</div>
			<div class="col-5">
				<p><?php echo trans("order_email_msg"); ?></p>
			</div>
			<div class="col-12 text-center pt-4">
				<p><?php echo trans("order_check_msg"); ?></p>
				<a href="<?php echo lang_base_url(); ?>" class="btn btn-lg btn-custom"><?php echo trans("goto_home");?></a>
			</div>
			
			
        </div>
    </div>
</div>
<!-- Wrapper End-->

<style>
    .mail-icon{text-align:right;}.mail-icon svg{max-width: 4rem;position: relative;top: -10px;}.circle-loader{margin-bottom:1.5em;border:1px solid rgba(0,0,0,0.2);border-left-color:#5cb85c;animation:loader-spin 1.2s infinite linear;position:relative;display:inline-block;vertical-align:top;border-radius:50%;width:7em;height:7em}.load-complete{-webkit-animation:none;animation:none;border-color:#5cb85c;transition:border 500ms ease-out}.checkmark{display:none}.checkmark.draw:after{animation-duration:800ms;animation-timing-function:ease;animation-name:checkmark;transform:scaleX(-1) rotate(135deg)}.checkmark:after{opacity:1;height:3.5em;width:1.75em;transform-origin:left top;border-right:3px solid #5cb85c;border-top:3px solid #5cb85c;content:'';left:1.75em;top:3.5em;position:absolute}@keyframes loader-spin{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}@keyframes checkmark{0%{height:0;width:0;opacity:1}20%{height:0;width:1.75em;opacity:1}40%{height:3.5em;width:1.75em;opacity:1}100%{height:3.5em;width:1.75em;opacity:1}}.page-confirm .title{font-size:22px;}.error-circle{margin-bottom:3.5em;border:1px solid #dc3545;position:relative;display:inline-block;vertical-align:top;border-radius:50%;width:7em;height:7em;line-height:7em;color:#dc3545}.error-circle i{font-size:30px}
</style>
<script>
    $(document).ready(function () {
        $('.circle-loader').toggleClass('load-complete');
        $('.checkmark').toggle();
    });
</script>
<?php if (!empty($this->session->userdata('mds_send_email_data'))): ?>
    <script>
		// $('button[name="submit"]').click(function() {
			fbq('track', 'Purchase', {currency: "<?php echo $order->price_currency ?>", value: <?php echo $order->price_total/100 ?>});
		// });
	</script>
	<script>
        $(document).ready(function () {
            var data = JSON.parse(<?php echo json_encode($this->session->userdata("mds_send_email_data"));?>);
            if (data) {
                data[csfr_token_name] = $.cookie(csfr_cookie_name);
                data["sys_lang_id"] = sys_lang_id;
                $.ajax({
                    type: "POST",
                    url: base_url + "send-email-post",
                    data: data,
                    success: function (response) {
                    }
                });
            }
        });
	</script>
<?php endif;
$this->session->unset_userdata('mds_send_email_data'); ?>


