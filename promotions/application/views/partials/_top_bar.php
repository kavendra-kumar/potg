<?php defined('BASEPATH') or exit('No direct script access allowed'); 
if (empty($this->session->userdata('mds_default_location_id'))){
	$this->session->set_userdata('mds_default_location_id', 228);
?>
<script>
	$( document ).ready(function() {
	 //$('[data-target="#locationModal"]').click();
		var a = {
    sys_lang_id: sys_lang_id
};
a[csfr_token_name] = $.cookie(csfr_cookie_name);
$.ajax({
    type: "POST",
    url: base_url + "ajax_controller/get_countries",
    data: a,
    success: function(c) {
        var b = JSON.parse(c);
        if (b.result == 1) {
            document.getElementById("dropdown_location").innerHTML = b.content;
            $('#dropdown_location option[value=""],#dropdown_location option:not([value])').remove();
			setMyCountry();
        }
    }
});

		});
	function setMyCountry(){
		var code = 228,country = geoplugin_countryName();
		if(country.indexOf("Bahrain") >= 0){code = 17;}else if(country.indexOf("Kuwait") >= 0){code = 116;}else if(country.indexOf("Oman") >= 0){code = 165;}else if(country.indexOf("Saudi") >= 0){code = 189;}
		$("#dropdown_location").val(code);
		debugger;
		if(localStorage.getItem('setLocation') != 0){
			localStorage.setItem('setLocation', 0);
			$("#country-selector").submit();
		}
	}	
</script>
<?php }
else{
   ?>
<script>
		localStorage.setItem('setLocation', 0);
</script>
<?php 
}
?>

<div class="top-bar">
    <div class="container">
        <div class="row">
            <div class="col-6 col-left">
                <?php if (!empty($this->menu_links)): ?>
                    <ul class="navbar-nav">
                        <?php foreach ($this->menu_links as $menu_link):
                            if ($menu_link->location == 'top_menu'):?>
                                <li class="nav-item"><a href="<?php echo generate_menu_item_url($menu_link); ?>" class="nav-link"><?php echo html_escape($menu_link->title); ?></a></li>
                            <?php endif;
                        endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <div class="col-6 col-right">
                <ul class="navbar-nav">
                    <?php if (item_count($this->countries) > 1):
                        $selected_location = trans("location");
                        if (!empty($this->session->userdata('mds_default_location_id'))):
                            $country = get_country($this->session->userdata('mds_default_location_id'));
                            if (!empty($country)) {
                                $selected_location = $country->name;
                            }
                        endif; ?>
                        <li class="nav-item">
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#locationModal" class="nav-link btn-modal-location">
                                <i class="icon-map-marker" aria-hidden="true"></i>&nbsp;<?php echo $selected_location; ?>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($this->general_settings->multilingual_system == 1 && count($this->languages) > 1): ?>
                        <li class="nav-item dropdown language-dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                                <img src="<?php echo base_url($this->selected_lang->flag_path); ?>" class="flag"><?php echo html_escape($this->selected_lang->name); ?><i class="icon-arrow-down"></i>
                            </a>
                            <div class="dropdown-menu">
                                <?php foreach ($this->languages as $language):
                                    $lang_url = base_url() . $language->short_form . "/";
                                    if ($language->id == $this->general_settings->site_lang) {
                                        $lang_url = base_url();
                                    } ?>
                                    <a href="<?php echo $lang_url; ?>" class="<?php echo ($language->id == $this->selected_lang->id) ? 'selected' : ''; ?> " class="dropdown-item">
                                        <img src="<?php echo base_url($language->flag_path); ?>" class="flag"><?php echo $language->name; ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </li>
                    <?php endif; ?>

                    <?php if ($this->auth_check): ?>
                        <li class="nav-item dropdown profile-dropdown p-r-0">
                            <a class="nav-link dropdown-toggle a-profile" data-toggle="dropdown" href="javascript:void(0)" aria-expanded="false">
                                <img src="<?php echo get_user_avatar($this->auth_user); ?>" alt="<?php echo get_shop_name($this->auth_user); ?>">
                                <?php if ($unread_message_count > 0): ?>
                                    <span class="notification"><?php echo $unread_message_count; ?></span>
                                <?php endif; ?>
                                <?php echo character_limiter(get_shop_name($this->auth_user), 15, '..'); ?>
                                <i class="icon-arrow-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if ($this->auth_user->role == "admin"): ?>
                                    <li>
                                        <a href="<?php echo admin_url(); ?>">
                                            <i class="icon-dashboard"></i>
                                            <?php echo trans("admin_panel"); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <a href="<?php echo generate_profile_url($this->auth_user->slug); ?>">
                                        <i class="icon-user"></i>
                                        <?php echo trans("view_profile"); ?>
                                    </a>
                                </li>
                                <?php if (is_sale_active()): ?>
                                    <li>
                                        <a href="<?php echo generate_url("orders"); ?>">
                                            <i class="icon-shopping-basket"></i>
                                            <?php echo trans("orders"); ?>
                                        </a>
                                    </li>
                                    <?php if (is_user_vendor()): ?>
                                        <li>
                                            <a href="<?php echo generate_url("sales"); ?>">
                                                <i class="icon-shopping-bag"></i>
                                                <?php echo trans("sales"); ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo generate_url("earnings"); ?>">
                                                <i class="icon-wallet"></i>
                                                <?php echo trans("earnings"); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (is_bidding_system_active()): ?>
                                        <li>
                                            <a href="<?php echo generate_url("quote_requests"); ?>">
                                                <i class="icon-price-tag-o"></i>
                                                <?php echo trans("quote_requests"); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($this->general_settings->digital_products_system == 1): ?>
                                        <li>
                                            <a href="<?php echo generate_url("downloads"); ?>">
                                                <i class="icon-download"></i>
                                                <?php echo trans("downloads"); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <li>
                                    <a href="<?php echo generate_url("messages"); ?>">
                                        <i class="icon-mail"></i>
                                        <?php echo trans("messages"); ?>&nbsp;<?php if ($unread_message_count > 0): ?>
                                            <span class="span-message-count"><?php echo $unread_message_count; ?></span>
                                        <?php endif; ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo generate_url("settings", "update_profile"); ?>">
                                        <i class="icon-settings"></i>
                                        <?php echo trans("settings"); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>logout" class="logout">
                                        <i class="icon-logout"></i>
                                        <?php echo trans("logout"); ?>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#loginModal" class="nav-link"><?php echo trans("login"); ?></a>
                            <span class="auth-sep">/</span>
                            <a href="<?php echo generate_url("register"); ?>" class="nav-link"><?php echo trans("register"); ?></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
