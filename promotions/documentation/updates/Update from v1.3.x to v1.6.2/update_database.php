<?php
define('BASEPATH', "/");
define('ENVIRONMENT', 'production');
require_once "application/config/database.php";
$license_code = '';
$purchase_code = '';

if (!function_exists('curl_init')) {
    $error = 'cURL is not available on your server! Please enable cURL to continue the installation. You can read the documentation for more information.';
}

//set database credentials
$database = $db['default'];
$db_host = $database['hostname'];
$db_name = $database['database'];
$db_user = $database['username'];
$db_password = $database['password'];

/* Connect */
$connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);
$connection->query("SET CHARACTER SET utf8");
$connection->query("SET NAMES utf8");
if (!$connection) {
    $error = "Connect failed! Please check your database credentials.";
}

if (isset($_POST["btn_submit"])) {
    $input_code = trim($_POST['license_code']);
    //current URL
    $http = 'http';
    if (isset($_SERVER['HTTPS'])) {
        $http = 'https';
    }
    $host = $_SERVER['HTTP_HOST'];
    $requestUri = $_SERVER['REQUEST_URI'];
    $current_url = $http . '://' . htmlentities($host) . '/' . htmlentities($requestUri);
    //check license
    $url = "http://license.codingest.com/api/check_modesy_license_code?license_code=" . $input_code . "&domain=" . $current_url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    if (empty($response)) {
        $url = "https://license.codingest.com/api/check_modesy_license_code?license_code=" . $input_code . "&domain=" . $current_url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
    }
    $data = json_decode($response);
    if (!empty($data)) {
        if ($data->code == "error") {
            $error = "Invalid License Code!";
        } else {
            $license_code = $input_code;
            $purchase_code = $data->code;
            update_13_to_14($license_code, $purchase_code, $connection);
            sleep(1);
            update_14_to_15($license_code, $purchase_code, $connection);
            sleep(1);
            update_15_to_16($license_code, $purchase_code, $connection);
            sleep(1);
            /* close connection */
            mysqli_close($connection);
            $success = 'The update has been successfully completed! Please delete the "update_database.php" file.';
        }
    } else {
        $error = "Invalid License Code!";
    }
}

function update_13_to_14($license_code, $purchase_code, $connection)
{
    $table_cities = "CREATE TABLE `cities` (
          `id` INT AUTO_INCREMENT PRIMARY KEY,
          `name` varchar(255) NOT NULL,
          `state_id` mediumint(8) NOT NULL,
          `country_id` mediumint(8) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_digital_files = "CREATE TABLE `digital_files` (
          `id` INT AUTO_INCREMENT PRIMARY KEY,
          `product_id` int(11) DEFAULT NULL,
          `user_id` int(11) DEFAULT NULL,
          `file_name` varchar(255) DEFAULT NULL,
          `storage` varchar(20) DEFAULT 'local',
          `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_digital_sales = "CREATE TABLE `digital_sales` (
          `id` INT AUTO_INCREMENT PRIMARY KEY,
          `order_id` int(11) NOT NULL,
          `product_id` int(11) NOT NULL,
          `product_title` varchar(500) DEFAULT NULL,
          `seller_id` int(11) NOT NULL,
          `buyer_id` int(11) NOT NULL,
          `purchase_code` varchar(100) NOT NULL,
          `currency` varchar(20) NOT NULL DEFAULT 'USD',
          `price` bigint(20) NOT NULL,
          `purchase_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_form_settings = "CREATE TABLE `form_settings` (
          `id` INT AUTO_INCREMENT PRIMARY KEY,
          `product_conditions` tinyint(1) DEFAULT '1',
          `product_conditions_required` tinyint(1) DEFAULT '1',
          `quantity` tinyint(1) DEFAULT '1',
          `price` tinyint(1) DEFAULT '1',
          `price_required` tinyint(1) DEFAULT '1',
          `quantity_required` tinyint(1) DEFAULT '1',
          `variations` tinyint(1) DEFAULT '1',
          `shipping` tinyint(1) DEFAULT '1',
          `shipping_required` tinyint(1) DEFAULT '1',
          `product_location` tinyint(1) DEFAULT '1',
          `product_location_required` tinyint(1) DEFAULT '1',
          `physical_demo_url` tinyint(1) DEFAULT '0',
          `physical_video_preview` tinyint(1) DEFAULT '1',
          `physical_audio_preview` tinyint(1) DEFAULT '1',
          `digital_demo_url` tinyint(1) DEFAULT '1',
          `digital_video_preview` tinyint(1) DEFAULT '1',
          `digital_audio_preview` tinyint(1) DEFAULT '1',
          `external_link` tinyint(1) NOT NULL DEFAULT '1'
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_images_file_manager = "CREATE TABLE `images_file_manager` (
          `id` INT AUTO_INCREMENT PRIMARY KEY,
          `image_path` varchar(255) DEFAULT NULL,
          `storage` varchar(20) DEFAULT 'local',
          `user_id` int(11) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_media = "CREATE TABLE `media` (
          `id` INT AUTO_INCREMENT PRIMARY KEY,
          `product_id` int(11) DEFAULT NULL,
          `media_type` varchar(20) DEFAULT NULL,
          `file_name` varchar(255) DEFAULT NULL,
          `storage` varchar(20) DEFAULT 'local'
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_order_shipping = "CREATE TABLE `order_shipping` (
          `id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
          `order_id` bigint(20) NOT NULL,
          `shipping_first_name` varchar(255) DEFAULT NULL,
          `shipping_last_name` varchar(255) DEFAULT NULL,
          `shipping_email` varchar(255) DEFAULT NULL,
          `shipping_phone_number` varchar(255) DEFAULT NULL,
          `shipping_address_1` varchar(255) DEFAULT NULL,
          `shipping_address_2` varchar(255) DEFAULT NULL,
          `shipping_country` varchar(255) DEFAULT NULL,
          `shipping_state` varchar(255) DEFAULT NULL,
          `shipping_city` varchar(255) DEFAULT NULL,
          `shipping_zip_code` varchar(20) DEFAULT NULL,
          `billing_first_name` varchar(255) DEFAULT NULL,
          `billing_last_name` varchar(255) DEFAULT NULL,
          `billing_email` varchar(255) DEFAULT NULL,
          `billing_phone_number` varchar(255) DEFAULT NULL,
          `billing_address_1` varchar(255) DEFAULT NULL,
          `billing_address_2` varchar(255) DEFAULT NULL,
          `billing_country` varchar(255) DEFAULT NULL,
          `billing_state` varchar(255) DEFAULT NULL,
          `billing_city` varchar(255) DEFAULT NULL,
          `billing_zip_code` varchar(255) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_product_options = "CREATE TABLE `product_options` (
          `id` INT AUTO_INCREMENT PRIMARY KEY,
          `common_id` varchar(100) DEFAULT NULL,
          `option_label` varchar(255) DEFAULT NULL,
          `option_key` varchar(255) DEFAULT NULL,
          `lang_id` tinyint(4) DEFAULT NULL,
          `option_type` varchar(20) NOT NULL,
          `shipping_cost` tinyint(1) DEFAULT NULL,
          `is_visible` tinyint(1) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_product_variations = "CREATE TABLE `product_variations` (
          `id` INT AUTO_INCREMENT PRIMARY KEY,
          `common_id` varchar(100) DEFAULT NULL,
          `product_id` int(11) DEFAULT NULL,
          `lang_id` tinyint(4) DEFAULT NULL,
          `user_id` int(11) DEFAULT NULL,
          `label` varchar(255) DEFAULT NULL,
          `variation_type` varchar(50) DEFAULT NULL,
          `insert_type` varchar(10) DEFAULT 'new',
          `visible` tinyint(1) DEFAULT '1'
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_product_variations_options = "CREATE TABLE `product_variations_options` (
          `id` INT AUTO_INCREMENT PRIMARY KEY,
          `variation_common_id` varchar(100) DEFAULT NULL,
          `option_common_id` varchar(100) DEFAULT NULL,
          `option_text` varchar(255) DEFAULT NULL,
          `lang_id` tinyint(4) DEFAULT NULL,
          `available_in_stock` tinyint(1) DEFAULT NULL,
          `option_index` smallint(6) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    mysqli_query($connection, $table_cities);
    mysqli_query($connection, $table_digital_files);
    mysqli_query($connection, $table_digital_sales);
    mysqli_query($connection, $table_form_settings);
    mysqli_query($connection, $table_images_file_manager);
    mysqli_query($connection, $table_media);
    mysqli_query($connection, $table_order_shipping);
    mysqli_query($connection, $table_product_options);
    mysqli_query($connection, $table_product_variations);
    mysqli_query($connection, $table_product_variations_options);

    sleep(1);
    mysqli_query($connection, "ALTER TABLE categories ADD COLUMN `title_meta_tag` VARCHAR(255);");
    mysqli_query($connection, "ALTER TABLE categories ADD COLUMN `show_image_on_navigation` TINYINT(1) NOT NULL DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE conversations DROP COLUMN `last_receiver_id`;");
    mysqli_query($connection, "ALTER TABLE conversations DROP COLUMN `is_replied`;");
    mysqli_query($connection, "ALTER TABLE conversations DROP COLUMN `is_read`;");
    mysqli_query($connection, "ALTER TABLE conversations DROP COLUMN `receiver_deleted`;");
    mysqli_query($connection, "ALTER TABLE conversations DROP COLUMN `sender_deleted`;");
    mysqli_query($connection, "ALTER TABLE conversation_messages ADD COLUMN `is_read` TINYINT(1) NOT NULL DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE conversation_messages ADD COLUMN `deleted_user_id` INT DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE custom_fields ADD COLUMN `is_product_filter` TINYINT(1) NOT NULL DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE custom_fields ADD COLUMN `product_filter_key` VARCHAR(255);");
    mysqli_query($connection, "ALTER TABLE custom_fields_product ADD COLUMN `product_filter_key` VARCHAR(255);");
    mysqli_query($connection, "ALTER TABLE custom_fields_product ADD COLUMN `selected_option_common_id` VARCHAR(50);");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `physical_products_system` TINYINT(1) NOT NULL DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `digital_products_system` TINYINT(1) NOT NULL DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `marketplace_system` TINYINT(1) NOT NULL DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `classified_ads_system` TINYINT(1) NOT NULL DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings DROP COLUMN `selected_system`;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `menu_limit` TINYINT(4) NOT NULL DEFAULT 9;");
    mysqli_query($connection, "ALTER TABLE general_settings DROP COLUMN `twitter_api_key`;");
    mysqli_query($connection, "ALTER TABLE general_settings DROP COLUMN `twitter_secret_key`;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `facebook_app_secret` VARCHAR(500);");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `google_client_id` VARCHAR(500);");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `google_client_secret` VARCHAR(500);");
    mysqli_query($connection, "ALTER TABLE general_settings DROP COLUMN `product_location_system`;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `maintenance_mode_title` VARCHAR(500);");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `maintenance_mode_description` VARCHAR(2000);");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `maintenance_mode_status` TINYINT(1) NOT NULL DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `max_file_size_image` INT DEFAULT 10485760;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `max_file_size_video` INT DEFAULT 31457280;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `max_file_size_audio` INT DEFAULT 10485760;");
    mysqli_query($connection, "ALTER TABLE general_settings DROP COLUMN `created_at`;");
    mysqli_query($connection, "ALTER TABLE images ADD COLUMN `is_main` TINYINT(1) NOT NULL DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE images DROP COLUMN `image_order`;");
    mysqli_query($connection, "ALTER TABLE languages ADD COLUMN `ckeditor_lang` VARCHAR(10) DEFAULT 'en';");

    //move orders shipping rows
    $sql = "SELECT * FROM orders";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_array($result)) {
        if (!empty($row['id'])) {
            $insert = "INSERT INTO `order_shipping`(`order_id`, `shipping_first_name`, `shipping_last_name`, `shipping_email`,
 `shipping_phone_number`, `shipping_address_1`, `shipping_address_2`, `shipping_country`, `shipping_state`, `shipping_city`, 
 `shipping_zip_code`, `billing_first_name`, `billing_last_name`, `billing_email`, `billing_phone_number`, `billing_address_1`,
  `billing_address_2`, `billing_country`, `billing_state`, `billing_city`, `billing_zip_code`) 
VALUES ('" . $row['id'] . "',
'" . $row['shipping_first_name'] . "',
'" . $row['shipping_last_name'] . "',
'" . $row['shipping_email'] . "',
'" . $row['shipping_phone_number'] . "',
'" . $row['shipping_address_1'] . "',
'" . $row['shipping_address_2'] . "',
'" . $row['shipping_country'] . "',
'" . $row['shipping_state'] . "',
'" . $row['shipping_city'] . "',
'" . $row['shipping_zip_code'] . "',
'" . $row['billing_first_name'] . "',
'" . $row['billing_last_name'] . "',
'" . $row['billing_email'] . "',
'" . $row['billing_phone_number'] . "',
'" . $row['billing_address_1'] . "',
'" . $row['billing_address_2'] . "',
'" . $row['billing_country'] . "',
'" . $row['billing_state'] . "',
'" . $row['billing_city'] . "',
'" . $row['billing_zip_code'] . "')";
            mysqli_query($connection, $insert);
        }
    }
    mysqli_query($connection, "ALTER TABLE orders DROP COLUMN `shipping_first_name`;");
    mysqli_query($connection, "ALTER TABLE orders DROP COLUMN `shipping_last_name`;");
    mysqli_query($connection, "ALTER TABLE orders DROP COLUMN `shipping_email`;");
    mysqli_query($connection, "ALTER TABLE orders DROP COLUMN `shipping_phone_number`;");
    mysqli_query($connection, "ALTER TABLE orders DROP COLUMN `shipping_address_1`;");
    mysqli_query($connection, "ALTER TABLE orders DROP COLUMN `shipping_address_2`;");
    mysqli_query($connection, "ALTER TABLE orders DROP COLUMN `shipping_country`;");
    mysqli_query($connection, "ALTER TABLE orders DROP COLUMN `shipping_state`;");
    mysqli_query($connection, "ALTER TABLE orders DROP COLUMN `shipping_city`;");
    mysqli_query($connection, "ALTER TABLE orders DROP COLUMN `shipping_zip_code`;");
    mysqli_query($connection, "ALTER TABLE orders DROP COLUMN `billing_first_name`;");
    mysqli_query($connection, "ALTER TABLE orders DROP COLUMN `billing_last_name`;");
    mysqli_query($connection, "ALTER TABLE orders DROP COLUMN `billing_email`;");
    mysqli_query($connection, "ALTER TABLE orders DROP COLUMN `billing_phone_number`;");
    mysqli_query($connection, "ALTER TABLE orders DROP COLUMN `billing_address_1`;");
    mysqli_query($connection, "ALTER TABLE orders DROP COLUMN `billing_address_2`;");
    mysqli_query($connection, "ALTER TABLE orders DROP COLUMN `billing_country`;");
    mysqli_query($connection, "ALTER TABLE orders DROP COLUMN `billing_state`;");
    mysqli_query($connection, "ALTER TABLE orders DROP COLUMN `billing_city`;");
    mysqli_query($connection, "ALTER TABLE orders DROP COLUMN `billing_zip_code`;");
    mysqli_query($connection, "ALTER TABLE order_products ADD COLUMN `product_type` VARCHAR(20) DEFAULT 'physical';");
    mysqli_query($connection, "ALTER TABLE payment_settings ADD COLUMN `allow_all_currencies_for_classied` TINYINT(1) NOT NULL DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE payment_settings ADD COLUMN `stripe_secret_key` VARCHAR(500);");
    mysqli_query($connection, "ALTER TABLE products ADD COLUMN `product_type` VARCHAR(20) DEFAULT 'physical';");
    mysqli_query($connection, "ALTER TABLE products ADD COLUMN `listing_type` VARCHAR(20) DEFAULT 'sell_on_site';");
    mysqli_query($connection, "ALTER TABLE products ADD COLUMN `city_id` INT");
    mysqli_query($connection, "ALTER TABLE products ADD COLUMN `demo_url` VARCHAR(1000);");
    mysqli_query($connection, "ALTER TABLE products ADD COLUMN `files_included` VARCHAR(255);");
    mysqli_query($connection, "ALTER TABLE products ADD COLUMN `is_draft` TINYINT(1) DEFAULT 0;");
    //add product options
    $insert_options = "INSERT INTO `product_options` (`id`, `common_id`, `option_label`, `option_key`, `lang_id`, `option_type`, `shipping_cost`, `is_visible`) VALUES
        (1, '5d18a5c262c660-27877500-5650333s', 'Free Shipping', 'free_shipping', 1, 'shipping', 0, 1),
        (2, '5d18a66435b360-13657409-3311870s', 'Shipping Included', 'shipping_included', 1, 'shipping', 0, 1),
        (3, '5d18a6939d6926-77793064-9296191s', 'Buyer Pays', 'shipping_buyer_pays', 1, 'shipping', 1, 1),
        (4, '5d18d92a94fdd9-48421309-8629379c', 'New with Tags', 'new_with_tags', 1, 'product_condition', 0, 1),
        (5, '5d18d9e45b3432-30246950-5352384c', 'New', 'new', 1, 'product_condition', 0, 1),
        (6, '5d18d95938c285-41489303-3045988c', 'Very Good', 'very_good', 1, 'product_condition', 0, 1),
        (7, '5d18d967902440-79424298-1563691c', 'Good', 'good', 1, 'product_condition', 0, 1),
        (8, '5d18d975a867c4-28077944-7723098c', 'Satisfactory', 'satisfactory', 1, 'product_condition', 0, 1),
        (9, '5d18d9a6e16c23-46528035-2884541c', 'Used', 'used', 1, 'product_condition', 0, 1)";
    mysqli_query($connection, $insert_options);

    mysqli_query($connection, "ALTER TABLE slider ADD COLUMN `image_small` VARCHAR(255);");
    mysqli_query($connection, "ALTER TABLE slider DROP COLUMN `storage`;");
    mysqli_query($connection, "ALTER TABLE storage_settings ADD COLUMN `aws_base_url` VARCHAR(1000) DEFAULT 'https://s3.amazonaws.com/';");
    mysqli_query($connection, "ALTER TABLE users DROP COLUMN `twitter_id`;");
    mysqli_query($connection, "ALTER TABLE users ADD COLUMN `google_id` VARCHAR(255);");
    mysqli_query($connection, "ALTER TABLE users ADD COLUMN `shop_name` VARCHAR(255);");
    mysqli_query($connection, "ALTER TABLE users ADD COLUMN `city_id` INT;");
    mysqli_query($connection, "ALTER TABLE users ADD COLUMN `is_active_shop_request` TINYINT(1) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE users ADD COLUMN `send_email_when_item_sold` TINYINT(1) DEFAULT 1;");


    //add form settings
    $insert_form_settings = "INSERT INTO `form_settings` (`id`, `product_conditions`, `product_conditions_required`, `quantity`, `price`, `price_required`, `quantity_required`, `variations`, `shipping`, `shipping_required`, `product_location`, `product_location_required`, `physical_demo_url`, `physical_video_preview`, `physical_audio_preview`, `digital_demo_url`, `digital_video_preview`, `digital_audio_preview`, `external_link`) VALUES
        (1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1)";
    mysqli_query($connection, $insert_form_settings);

    //update select_box to radio_button
    $sql = "SELECT * FROM custom_fields";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_array($result)) {
        if (!empty($row['id']) && $row['field_type'] == 'select_box') {
            $update = "UPDATE custom_fields SET field_type='radio_button' WHERE id= '" . $row['id'] . "'";
            mysqli_query($connection, $update);
        }
    }

    mysqli_query($connection, "ALTER TABLE countries DROP COLUMN `sortname`;");
    mysqli_query($connection, "ALTER TABLE countries DROP COLUMN `phonecode`;");
}

function update_14_to_15($license_code, $purchase_code, $connection)
{
    $table_quote_requests = "CREATE TABLE `quote_requests` (
		 `id` INT AUTO_INCREMENT PRIMARY KEY,
		  `product_id` int(11) DEFAULT NULL,
		  `product_title` varchar(500) DEFAULT NULL,
		  `product_quantity` mediumint(9) DEFAULT '1',
		  `seller_id` int(11) DEFAULT NULL,
		  `buyer_id` int(11) DEFAULT NULL,
		  `status` varchar(20) DEFAULT 'pending',
		  `price_offered` bigint(20) DEFAULT NULL,
		  `price_currency` varchar(20) DEFAULT NULL,
		  `shipping_cost` bigint(20) DEFAULT NULL,
		  `is_buyer_deleted` tinyint(1) DEFAULT '0',
		  `is_seller_deleted` tinyint(1) DEFAULT '0',
		  `updated_at` timestamp NULL DEFAULT NULL,
		  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_product_license_keys = "CREATE TABLE `product_license_keys` (
		  `id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
		  `product_id` int(11) DEFAULT NULL,
		  `license_key` varchar(500) DEFAULT NULL,
		  `is_used` tinyint(1) DEFAULT '0'
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    mysqli_query($connection, $table_quote_requests);
    mysqli_query($connection, $table_product_license_keys);
    sleep(1);
    mysqli_query($connection, "ALTER TABLE categories DROP COLUMN `top_parent_id`;");
    mysqli_query($connection, "ALTER TABLE categories DROP COLUMN `category_level`;");
    mysqli_query($connection, "ALTER TABLE categories DROP COLUMN `parent_slug`;");
    mysqli_query($connection, "ALTER TABLE categories DROP COLUMN `top_parent_slug`;");
    mysqli_query($connection, "ALTER TABLE form_settings ADD COLUMN `sitemap_frequency` VARCHAR(30) DEFAULT 'monthly';");
    mysqli_query($connection, "ALTER TABLE form_settings ADD COLUMN `sitemap_last_modification` VARCHAR(30) DEFAULT 'server_response';");
    mysqli_query($connection, "ALTER TABLE form_settings ADD COLUMN `sitemap_priority` VARCHAR(30) DEFAULT 'automatically';");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `bidding_system` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `watermark_image_large` VARCHAR(255);");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `watermark_image_mid` VARCHAR(255);");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `watermark_image_small` VARCHAR(255);");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `watermark_vrt_alignment` VARCHAR(20) DEFAULT 'middle';");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `watermark_hor_alignment` VARCHAR(20) DEFAULT 'center';");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `watermark_product_images` TINYINT(1) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `watermark_blog_images` TINYINT(1) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `watermark_thumbnail_images` TINYINT(1) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `send_email_shop_opening_request` TINYINT(1) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `send_email_bidding_system` TINYINT(1) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `vendor_verification_system` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `guest_checkout` TINYINT(1) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `google_adsense_code` VARCHAR(2000);");
    mysqli_query($connection, "ALTER TABLE general_settings MODIFY `max_file_size_image` BIGINT(20) DEFAULT 10485760;");
    mysqli_query($connection, "ALTER TABLE general_settings MODIFY `max_file_size_video` BIGINT(20) DEFAULT 31457280;");
    mysqli_query($connection, "ALTER TABLE general_settings MODIFY `max_file_size_audio` BIGINT(20) DEFAULT 10485760;");
    mysqli_query($connection, "ALTER TABLE general_settings MODIFY `default_product_location` INT DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE payment_settings ADD COLUMN `paypal_secret_key` VARCHAR(500);");
    mysqli_query($connection, "ALTER TABLE payment_settings ADD COLUMN `paystack_enabled` TINYINT(1) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE payment_settings ADD COLUMN `paystack_secret_key` VARCHAR(500);");
    mysqli_query($connection, "ALTER TABLE payment_settings ADD COLUMN `paystack_public_key` VARCHAR(500);");
    mysqli_query($connection, "ALTER TABLE payment_settings ADD COLUMN `razorpay_enabled` TINYINT(1) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE payment_settings ADD COLUMN `razorpay_key_id` VARCHAR(500);");
    mysqli_query($connection, "ALTER TABLE payment_settings ADD COLUMN `razorpay_key_secret` VARCHAR(500);");
    mysqli_query($connection, "ALTER TABLE payment_settings ADD COLUMN `pagseguro_enabled` TINYINT(1) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE payment_settings ADD COLUMN `pagseguro_mode` VARCHAR(20) DEFAULT 'production';");
    mysqli_query($connection, "ALTER TABLE payment_settings ADD COLUMN `pagseguro_email` VARCHAR(255);");
    mysqli_query($connection, "ALTER TABLE payment_settings ADD COLUMN `pagseguro_token` VARCHAR(500);");
    mysqli_query($connection, "ALTER TABLE payment_settings ADD COLUMN `free_product_promotion` TINYINT(1) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE payment_settings ADD COLUMN `cash_on_delivery_enabled` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE products ADD COLUMN `is_free_product` TINYINT(1) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE digital_sales ADD COLUMN `license_key` VARCHAR(255);");


    //update categories
    $sql = "SELECT * FROM products ORDER BY id";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $cat_id = 0;
        if (!empty($row['third_category_id'])) {
            $cat_id = $row['third_category_id'];
        } elseif (!empty($row['subcategory_id'])) {
            $cat_id = $row['subcategory_id'];
        } elseif (!empty($row['category_id'])) {
            $cat_id = $row['category_id'];
        }
        mysqli_query($connection, "UPDATE products SET `category_id`=" . $cat_id . " WHERE id=" . $row['id']);
    }
    sleep(1);

    mysqli_query($connection, "ALTER TABLE products DROP COLUMN `subcategory_id`;");
    mysqli_query($connection, "ALTER TABLE products DROP COLUMN `third_category_id`;");
}

function update_15_to_16($license_code, $purchase_code, $connection)
{
    $table_sessions = "CREATE TABLE IF NOT EXISTS `ci_sessions` (
    `id` varchar(128) NOT NULL,
    `ip_address` varchar(45) NOT NULL,
    `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
    `data` blob NOT NULL,
    KEY `ci_sessions_timestamp` (`timestamp`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_fonts = "CREATE TABLE `fonts` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `font_name` varchar(255) DEFAULT NULL,
    `font_url` varchar(2000) DEFAULT NULL,
    `font_family` varchar(500) DEFAULT NULL,
    `is_default` tinyint(1) DEFAULT '0'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_images_variation = "CREATE TABLE `images_variation` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `product_id` int(11) DEFAULT NULL,
    `variation_option_id` int(11) DEFAULT '0',
    `image_default` varchar(255) DEFAULT NULL,
    `image_big` varchar(255) DEFAULT NULL,
    `image_small` varchar(255) DEFAULT NULL,
    `is_main` tinyint(1) DEFAULT '0',
    `storage` varchar(20) DEFAULT 'local'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_invoices = "CREATE TABLE `invoices` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_id` bigint(20) DEFAULT NULL,
    `order_number` bigint(20) DEFAULT NULL,
    `client_username` varchar(255) DEFAULT NULL,
    `client_first_name` varchar(100) DEFAULT NULL,
    `client_last_name` varchar(100) DEFAULT NULL,
    `client_address` varchar(500) DEFAULT NULL,
    `invoice_items` text,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_language_translations = "CREATE TABLE `language_translations` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `lang_id` smallint(6) DEFAULT NULL,
    `label` varchar(255) DEFAULT NULL,
    `translation` varchar(500) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_routes = "CREATE TABLE `routes` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `admin` varchar(100) DEFAULT 'admin',
    `blog` varchar(100) DEFAULT 'blog',
    `tag` varchar(100) DEFAULT 'tag',
    `quote_requests` varchar(100) DEFAULT 'quote-requests',
    `sent_quote_requests` varchar(100) DEFAULT 'sent-quote-requests',
    `cart` varchar(100) DEFAULT 'cart',
    `shipping` varchar(100) DEFAULT 'shipping',
    `payment_method` varchar(100) DEFAULT 'payment-method',
    `payment` varchar(100) DEFAULT 'payment',
    `promote_payment_completed` varchar(100) DEFAULT 'promote-payment-completed',
    `orders` varchar(100) DEFAULT 'orders',
    `order_details` varchar(100) DEFAULT 'order',
    `order_completed` varchar(100) DEFAULT 'order-completed',
    `completed_orders` varchar(100) DEFAULT 'completed-orders',
    `messages` varchar(100) DEFAULT 'messages',
    `conversation` varchar(100) DEFAULT 'conversation',
    `profile` varchar(100) DEFAULT 'profile',
    `wishlist` varchar(100) DEFAULT 'wishlist',
    `settings` varchar(100) DEFAULT 'settings',
    `update_profile` varchar(100) DEFAULT 'update-profile',
    `followers` varchar(100) DEFAULT 'followers',
    `following` varchar(100) DEFAULT 'following',
    `sales` varchar(100) DEFAULT 'sales',
    `sale` varchar(100) DEFAULT 'sale',
    `sell_now` varchar(100) DEFAULT 'sell-now',
    `start_selling` varchar(100) DEFAULT 'start-selling',
    `products` varchar(100) DEFAULT 'products',
    `product_details` varchar(100) DEFAULT 'product-details',
    `edit_product` varchar(100) DEFAULT 'edit_product',
    `promote_product` varchar(100) DEFAULT 'promote-product',
    `pending_products` varchar(100) DEFAULT 'pending-products',
    `hidden_products` varchar(100) DEFAULT 'hidden-products',
    `latest_products` varchar(100) DEFAULT 'latest-products',
    `featured_products` varchar(100) DEFAULT 'featured-products',
    `drafts` varchar(100) DEFAULT 'drafts',
    `downloads` varchar(100) DEFAULT 'downloads',
    `seller` varchar(100) DEFAULT 'seller',
    `earnings` varchar(100) DEFAULT 'earnings',
    `payouts` varchar(100) DEFAULT 'payouts',
    `set_payout_account` varchar(100) DEFAULT 'set-payout-account',
    `pricing` varchar(100) DEFAULT 'pricing',
    `reviews` varchar(100) DEFAULT 'reviews',
    `category` varchar(100) DEFAULT 'category',
    `completed_sales` varchar(100) DEFAULT 'completed-sales',
    `shop_settings` varchar(100) DEFAULT 'shop-settings',
    `personal_information` varchar(100) DEFAULT 'personal-information',
    `shipping_address` varchar(100) DEFAULT 'shipping-address',
    `social_media` varchar(100) DEFAULT 'social-media',
    `search` varchar(100) DEFAULT 'search',
    `register` varchar(100) DEFAULT 'register',
    `members` varchar(100) DEFAULT 'members',
    `forgot_password` varchar(100) DEFAULT 'forgot-password',
    `change_password` varchar(100) DEFAULT 'change-password',
    `reset_password` varchar(100) DEFAULT 'reset-password',
    `rss_feeds` varchar(100) DEFAULT 'rss-feeds'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $sql_variations = "CREATE TABLE `variations` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `product_id` int(11) DEFAULT NULL,
    `user_id` int(11) DEFAULT NULL,
    `parent_id` int(11) DEFAULT '0',
    `label_names` text,
    `variation_type` varchar(50) DEFAULT NULL,
    `insert_type` varchar(10) DEFAULT 'new',
    `option_display_type` varchar(30) DEFAULT 'text',
    `show_images_on_slider` tinyint(1) DEFAULT '0',
    `use_different_price` tinyint(1) DEFAULT '0',
    `is_visible` tinyint(1) DEFAULT '1'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $sql_variation_options = "CREATE TABLE `variation_options` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `variation_id` int(11) DEFAULT NULL,
    `parent_id` int(11) DEFAULT '0',
    `option_names` text,
    `stock` int(11) DEFAULT NULL,
    `color` varchar(30) DEFAULT NULL,
    `price` bigint(20) DEFAULT NULL,
    `discount_rate` smallint(3) DEFAULT NULL,
    `is_default` tinyint(1) DEFAULT '0',
    `use_default_price` tinyint(1) NOT NULL DEFAULT '0',
    `no_discount` tinyint(1) NOT NULL DEFAULT '0'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    mysqli_query($connection, $table_sessions);
    mysqli_query($connection, $table_fonts);
    mysqli_query($connection, $table_images_variation);
    mysqli_query($connection, $table_invoices);
    mysqli_query($connection, $table_language_translations);
    mysqli_query($connection, $table_routes);
    mysqli_query($connection, $sql_variations);
    mysqli_query($connection, $sql_variation_options);
    sleep(1);

    mysqli_query($connection, "UPDATE `ad_spaces` SET `ad_space`='product_bottom' WHERE ad_space='product_sidebar';");
    mysqli_query($connection, "ALTER TABLE blog_comments ADD COLUMN `ip_address` VARCHAR(50);");
    mysqli_query($connection, "ALTER TABLE blog_comments ADD COLUMN `status` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE categories CHANGE `image_1` `image` VARCHAR(255);");
    mysqli_query($connection, "ALTER TABLE categories DROP COLUMN `image_2`;");
    mysqli_query($connection, "ALTER TABLE comments ADD COLUMN `ip_address` VARCHAR(50);");
    mysqli_query($connection, "ALTER TABLE comments ADD COLUMN `status` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "RENAME TABLE countries TO location_countries;");
    mysqli_query($connection, "ALTER TABLE location_countries ADD COLUMN `status` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "RENAME TABLE favorites TO wishlist;");
    mysqli_query($connection, "ALTER TABLE form_settings ADD COLUMN `digital_allowed_file_extensions` VARCHAR(500) DEFAULT 'zip';");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `vat_status` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings CHANGE `head_code` `custom_css_codes` MEDIUMTEXT;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `custom_javascript_codes` MEDIUMTEXT;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `vk_app_id` VARCHAR(500);");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `vk_secure_key` VARCHAR(500);");
    mysqli_query($connection, "ALTER TABLE general_settings DROP COLUMN `default_product_location`;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `comment_approval_system` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings CHANGE `product_reviews` `reviews` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings DROP COLUMN `user_reviews`;");
    mysqli_query($connection, "DROP TABLE `user_reviews`;");
    mysqli_query($connection, "ALTER TABLE general_settings CHANGE `index_slider` `slider_status` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `slider_type` VARCHAR(30) DEFAULT 'full_width';");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `slider_effect` VARCHAR(30) DEFAULT 'fade';");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `hide_vendor_contact_information` TINYINT(1) DEFAULT 0;");

    mysqli_query($connection, "RENAME TABLE cities TO location_cities;");
    mysqli_query($connection, "RENAME TABLE states TO location_states;");

    mysqli_query($connection, "ALTER TABLE orders ADD COLUMN `price_vat` BIGINT(20) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE order_products ADD COLUMN `product_vat_rate` SMALLINT(3) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE order_products ADD COLUMN `product_vat` BIGINT(20) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE order_products ADD COLUMN `variation_option_ids` VARCHAR(255);");

    mysqli_query($connection, "ALTER TABLE pages ADD COLUMN `page_default_name` VARCHAR(255);");
    mysqli_query($connection, "ALTER TABLE pages DROP COLUMN `link`;");
    mysqli_query($connection, "ALTER TABLE pages ADD COLUMN `is_custom` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE pages CHANGE `page_content` `page_content` LONGTEXT;");

    mysqli_query($connection, "ALTER TABLE payment_settings ADD COLUMN `space_between_money_currency` TINYINT(1) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE payment_settings ADD COLUMN `iyzico_type` VARCHAR(50) DEFAULT 'checkout_form';");
    mysqli_query($connection, "ALTER TABLE payment_settings ADD COLUMN `iyzico_submerchant_key` VARCHAR(255);");


    mysqli_query($connection, "ALTER TABLE products ADD COLUMN `sku` VARCHAR(100);");
    mysqli_query($connection, "ALTER TABLE products ADD COLUMN `discount_rate` SMALLINT(3) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE products ADD COLUMN `vat_rate` SMALLINT(3) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE products ADD COLUMN `shipping_cost_additional` BIGINT(20) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE products CHANGE `quantity` `stock` INT(11) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE products DROP COLUMN `is_sold`;");
    mysqli_query($connection, "ALTER TABLE products CHANGE `description` `description` LONGTEXT;");

    mysqli_query($connection, "ALTER TABLE reviews ADD COLUMN `ip_address` VARCHAR(50);");
    mysqli_query($connection, "ALTER TABLE settings ADD COLUMN `site_font` SMALLINT(6) DEFAULT 19;");

    mysqli_query($connection, "ALTER TABLE slider ADD COLUMN `title` VARCHAR(255);");
    mysqli_query($connection, "ALTER TABLE slider ADD COLUMN `description` VARCHAR(1000);");
    mysqli_query($connection, "ALTER TABLE slider ADD COLUMN `button_text` VARCHAR(255);");
    mysqli_query($connection, "ALTER TABLE slider ADD COLUMN `animation_title` VARCHAR(50);");
    mysqli_query($connection, "ALTER TABLE slider ADD COLUMN `animation_description` VARCHAR(50);");
    mysqli_query($connection, "ALTER TABLE slider ADD COLUMN `animation_button` VARCHAR(50);");
    mysqli_query($connection, "ALTER TABLE slider ADD COLUMN `text_color` VARCHAR(30) DEFAULT '#ffffff';");
    mysqli_query($connection, "ALTER TABLE slider ADD COLUMN `button_color` VARCHAR(30) DEFAULT '#222222';");
    mysqli_query($connection, "ALTER TABLE slider ADD COLUMN `button_text_color` VARCHAR(30) DEFAULT '#ffffff';");
    mysqli_query($connection, "ALTER TABLE slider DROP COLUMN `image_small`;");

    mysqli_query($connection, "ALTER TABLE users ADD COLUMN `vkontakte_id` VARCHAR(255);");
    mysqli_query($connection, "ALTER TABLE users ADD COLUMN `first_name` VARCHAR(100);");
    mysqli_query($connection, "ALTER TABLE users ADD COLUMN `last_name` VARCHAR(100);");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `version` VARCHAR(30) DEFAULT '1.6.2';");
    mysqli_query($connection, "ALTER TABLE products ADD COLUMN `stock_unlimited` TINYINT(1) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE slider ADD COLUMN `image_mobile` VARCHAR(255);");
    mysqli_query($connection, "ALTER TABLE earnings ADD COLUMN `order_product_id` INT;");
    sleep(1);

    $sql_fonts = "INSERT INTO `fonts` (`id`, `font_name`, `font_url`, `font_family`, `is_default`) VALUES
(1, 'Arial', NULL, 'font-family: Arial, Helvetica, sans-serif', 1),
(2, 'Arvo', '<link href=\"https://fonts.googleapis.com/css?family=Arvo:400,700&display=swap\" rel=\"stylesheet\">\r\n', 'font-family: \"Arvo\", Helvetica, sans-serif', 0),
(3, 'Averia Libre', '<link href=\"https://fonts.googleapis.com/css?family=Averia+Libre:300,400,700&display=swap\" rel=\"stylesheet\">\r\n', 'font-family: \"Averia Libre\", Helvetica, sans-serif', 0),
(4, 'Bitter', '<link href=\"https://fonts.googleapis.com/css?family=Bitter:400,400i,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Bitter\", Helvetica, sans-serif', 0),
(5, 'Cabin', '<link href=\"https://fonts.googleapis.com/css?family=Cabin:400,500,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Cabin\", Helvetica, sans-serif', 0),
(6, 'Cherry Swash', '<link href=\"https://fonts.googleapis.com/css?family=Cherry+Swash:400,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Cherry Swash\", Helvetica, sans-serif', 0),
(7, 'Encode Sans', '<link href=\"https://fonts.googleapis.com/css?family=Encode+Sans:300,400,500,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Encode Sans\", Helvetica, sans-serif', 0),
(8, 'Helvetica', NULL, 'font-family: Helvetica, sans-serif', 1),
(9, 'Hind', '<link href=\"https://fonts.googleapis.com/css?family=Hind:300,400,500,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">', 'font-family: \"Hind\", Helvetica, sans-serif', 0),
(10, 'Josefin Sans', '<link href=\"https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Josefin Sans\", Helvetica, sans-serif', 0),
(11, 'Kalam', '<link href=\"https://fonts.googleapis.com/css?family=Kalam:300,400,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Kalam\", Helvetica, sans-serif', 0),
(12, 'Khula', '<link href=\"https://fonts.googleapis.com/css?family=Khula:300,400,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Khula\", Helvetica, sans-serif', 0),
(13, 'Lato', '<link href=\"https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">', 'font-family: \"Lato\", Helvetica, sans-serif', 0),
(14, 'Lora', '<link href=\"https://fonts.googleapis.com/css?family=Lora:400,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Lora\", Helvetica, sans-serif', 0),
(15, 'Merriweather', '<link href=\"https://fonts.googleapis.com/css?family=Merriweather:300,400,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Merriweather\", Helvetica, sans-serif', 0),
(16, 'Montserrat', '<link href=\"https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Montserrat\", Helvetica, sans-serif', 0),
(17, 'Mukta', '<link href=\"https://fonts.googleapis.com/css?family=Mukta:300,400,500,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Mukta\", Helvetica, sans-serif', 0),
(18, 'Nunito', '<link href=\"https://fonts.googleapis.com/css?family=Nunito:300,400,600,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Nunito\", Helvetica, sans-serif', 0),
(19, 'Open Sans', '<link href=\"https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">', 'font-family: \"Open Sans\", Helvetica, sans-serif', 0),
(20, 'Oswald', '<link href=\"https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">', 'font-family: \"Oswald\", Helvetica, sans-serif', 0),
(21, 'Oxygen', '<link href=\"https://fonts.googleapis.com/css?family=Oxygen:300,400,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Oxygen\", Helvetica, sans-serif', 0),
(22, 'Poppins', '<link href=\"https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Poppins\", Helvetica, sans-serif', 0),
(23, 'PT Sans', '<link href=\"https://fonts.googleapis.com/css?family=PT+Sans:400,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"PT Sans\", Helvetica, sans-serif', 0),
(24, 'Raleway', '<link href=\"https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Raleway\", Helvetica, sans-serif', 0),
(25, 'Roboto', '<link href=\"https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">', 'font-family: \"Roboto\", Helvetica, sans-serif', 0),
(26, 'Roboto Condensed', '<link href=\"https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Roboto Condensed\", Helvetica, sans-serif', 0),
(27, 'Roboto Slab', '<link href=\"https://fonts.googleapis.com/css?family=Roboto+Slab:300,400,500,600,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Roboto Slab\", Helvetica, sans-serif', 0),
(28, 'Rokkitt', '<link href=\"https://fonts.googleapis.com/css?family=Rokkitt:300,400,500,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Rokkitt\", Helvetica, sans-serif', 0),
(29, 'Source Sans Pro', '<link href=\"https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">', 'font-family: \"Source Sans Pro\", Helvetica, sans-serif', 0),
(30, 'Titillium Web', '<link href=\"https://fonts.googleapis.com/css?family=Titillium+Web:300,400,600,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">', 'font-family: \"Titillium Web\", Helvetica, sans-serif', 0),
(31, 'Ubuntu', '<link href=\"https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext\" rel=\"stylesheet\">', 'font-family: \"Ubuntu\", Helvetica, sans-serif', 0),
(32, 'Verdana', NULL, 'font-family: Verdana, Helvetica, sans-serif', 1),
(33, 'Work Sans', '<link href=\"https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\"> ', 'font-family: \"Work Sans\", Helvetica, sans-serif', 0),
(34, 'Libre Baskerville', '<link href=\"https://fonts.googleapis.com/css?family=Libre+Baskerville:400,400i&display=swap&subset=latin-ext\" rel=\"stylesheet\"> ', 'font-family: \"Libre Baskerville\", Helvetica, sans-serif', 0),
(35, 'Signika', '<link href=\"https://fonts.googleapis.com/css2?family=Signika:wght@300;400;600;700&display=swap\" rel=\"stylesheet\">', 'font-family: \'Signika\', sans-serif;', 0);";
    mysqli_query($connection, $sql_fonts);

    $sql_routes = "INSERT INTO `routes` (`id`, `admin`, `blog`, `tag`, `quote_requests`, `sent_quote_requests`, `cart`, `shipping`, `payment_method`, `payment`, `promote_payment_completed`, `orders`, `order_details`, `order_completed`, `completed_orders`, `messages`, `conversation`, `profile`, `wishlist`, `settings`, `update_profile`, `followers`, `following`, `sales`, `sale`, `sell_now`, `start_selling`, `products`, `product_details`, `edit_product`, `promote_product`, `pending_products`, `hidden_products`, `latest_products`, `featured_products`, `drafts`, `downloads`, `seller`, `earnings`, `payouts`, `set_payout_account`, `pricing`, `reviews`, `category`, `completed_sales`, `shop_settings`, `personal_information`, `shipping_address`, `social_media`, `search`, `register`, `members`, `forgot_password`, `change_password`, `reset_password`, `rss_feeds`) VALUES
(1, 'admin', 'blog', 'tag', 'quote-requests', 'sent-quote-requests', 'cart', 'shipping', 'payment-method', 'payment', 'promote-payment-completed', 'orders', 'order-details', 'order-completed', 'completed-orders', 'messages', 'conversation', 'profile', 'wishlist', 'settings', 'update-profile', 'followers', 'following', 'sales', 'sale', 'sell-now', 'start-selling', 'products', 'product-details', 'edit-product', 'promote-product', 'pending-products', 'hidden-products', 'latest-products', 'featured-products', 'drafts', 'downloads', 'seller', 'earnings', 'payouts', 'set-payout-account', 'pricing', 'reviews', 'category', 'completed-sales', 'shop-settings', 'personal-information', 'shipping-address', 'social-media', 'search', 'register', 'members', 'forgot-password', 'change-password', 'reset-password', 'rss-feeds');";
    mysqli_query($connection, $sql_routes);


    //add pages
    $sql = "SELECT * FROM languages ORDER BY id";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $sql_pages = "INSERT INTO `pages` (`lang_id`, `title`, `slug`, `description`, `keywords`, `page_content`, `page_order`, `visibility`, `title_active`, `location`, `is_custom`, `page_default_name`) VALUES
(" . $row['id'] . ", 'Contact', 'contact', 'Contact Page', 'Contact, Page', NULL, 1, 1, 1, 'top_menu', 0, 'contact'),
(" . $row['id'] . ", 'Blog', 'blog', 'Blog Page', 'Blog, Page', NULL, 1, 1, 1, 'quick_links', 0, 'blog');";
        mysqli_query($connection, $sql_pages);
    }
    mysqli_query($connection, "UPDATE `pages` SET `page_default_name`='terms_conditions', `is_custom`=0 WHERE slug='terms-conditions';");

    //add variations
    $sql = "SELECT * FROM product_variations ORDER BY id";
    $result = mysqli_query($connection, $sql);
    $used_common_ids = array();
    while ($row = mysqli_fetch_array($result)) {
        if (!in_array($row['common_id'], $used_common_ids)) {
            array_push($used_common_ids, $row['common_id']);
            $label_names = generate_variation_label_array($connection, $row['common_id']);

            $insert_variation = "INSERT INTO `variations` (`product_id`, `user_id`, `parent_id`, `label_names`, `variation_type`, `insert_type`, `option_display_type`, `show_images_on_slider`, `is_visible`) 
            VALUES (" . $row['product_id'] . ", " . $row['user_id'] . ", 0, '" . $label_names . "', '" . $row['variation_type'] . "', '" . $row['insert_type'] . "', 'text', 0, " . $row['visible'] . ")";
            mysqli_query($connection, $insert_variation);

            $last_variation_id = $connection->insert_id;

            //add variation options
            $sql_option = "SELECT * FROM product_variations_options WHERE variation_common_id = '" . $row['common_id'] . "'  ORDER BY id";
            $result_option = mysqli_query($connection, $sql_option);
            $used_option_common_ids = array();
            while ($row_option = mysqli_fetch_array($result_option)) {

                if (!in_array($row_option['option_common_id'], $used_option_common_ids)) {
                    array_push($used_option_common_ids, $row_option['option_common_id']);
                    $option_names = generate_variation_option_names_array($connection, $row_option['option_common_id']);

                    $insert_variation_option = "INSERT INTO `variation_options` (`variation_id`, `parent_id`, `option_names`, `stock`, `color`, `price`, `discount_rate`, `is_default`, `use_default_price`, `no_discount`) 
                    VALUES (" . $last_variation_id . ", 0, '" . $option_names . "', 10, '', 0, 0, 0, 1, 0)";
                    mysqli_query($connection, $insert_variation_option);
                }
            }
        }
    }
    sleep(1);
    mysqli_query($connection, "DROP TABLE `product_variations`;");
    mysqli_query($connection, "DROP TABLE `product_variations_options`;");

    //add language translations
    $sql = "SELECT * FROM languages ORDER BY id";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $path = "application/language/" . $row["folder_name"] . "/site_lang.php";
        if (file_exists($path)) {
            require_once $path;
            if (!empty($lang)) {
                foreach ($lang as $key => $value) {

                    $insert_translation = "INSERT INTO `language_translations` (`lang_id`, `label`, `translation`) 
                    VALUES (" . $row["id"] . ", '" . $key . "' , '" . $value . "')";
                    mysqli_query($connection, $insert_translation);

                }
            }
        }
    }
    mysqli_query($connection, "ALTER TABLE languages DROP COLUMN `folder_name`;");
    mysqli_query($connection, "ALTER TABLE languages ADD COLUMN `flag_path` VARCHAR(255);");

    //add new phrases
    $sql = "SELECT * FROM languages ORDER BY id";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $phrases = phrases_16();
        if (!empty($phrases)) {
            foreach ($phrases as $key => $value) {

                $insert_new_translation = "INSERT INTO `language_translations` (`lang_id`, `label`, `translation`) 
                    VALUES (" . $row["id"] . ", '" . $key . "' , '" . $value . "')";
                mysqli_query($connection, $insert_new_translation);

            }
        }
    }

    //add indexes
    mysqli_query($connection, "ALTER TABLE blog_categories ADD INDEX idx_lang_id (lang_id);");
    mysqli_query($connection, "ALTER TABLE blog_comments ADD INDEX idx_post_id (post_id);");
    mysqli_query($connection, "ALTER TABLE blog_comments ADD INDEX idx_user_id (user_id);");
    mysqli_query($connection, "ALTER TABLE blog_posts ADD INDEX idx_lang_id (lang_id);");
    mysqli_query($connection, "ALTER TABLE blog_posts ADD INDEX idx_category_id(category_id);");
    mysqli_query($connection, "ALTER TABLE blog_tags ADD INDEX idx_post_id (post_id);");
    mysqli_query($connection, "ALTER TABLE categories ADD INDEX idx_parent_id (parent_id);");
    mysqli_query($connection, "ALTER TABLE categories ADD INDEX idx_visibility (visibility);");
    mysqli_query($connection, "ALTER TABLE categories ADD INDEX idx_show_on_homepage (show_on_homepage);");
    mysqli_query($connection, "ALTER TABLE categories_lang ADD INDEX idx_category_id (category_id);");
    mysqli_query($connection, "ALTER TABLE categories_lang ADD INDEX idx_lang_id (lang_id);");
    mysqli_query($connection, "ALTER TABLE comments ADD INDEX idx_parent_id (parent_id);");
    mysqli_query($connection, "ALTER TABLE comments ADD INDEX idx_product_id (product_id);");
    mysqli_query($connection, "ALTER TABLE comments ADD INDEX idx_user_id (user_id);");
    mysqli_query($connection, "ALTER TABLE conversations ADD INDEX idx_sender_id (sender_id);");
    mysqli_query($connection, "ALTER TABLE conversations ADD INDEX idx_receiver_id (receiver_id);");
    mysqli_query($connection, "ALTER TABLE conversation_messages ADD INDEX idx_conversation_id (conversation_id);");
    mysqli_query($connection, "ALTER TABLE conversation_messages ADD INDEX idx_sender_id (sender_id);");
    mysqli_query($connection, "ALTER TABLE conversation_messages ADD INDEX idx_receiver_id (receiver_id);");
    mysqli_query($connection, "ALTER TABLE custom_fields_category ADD INDEX idx_category_id (category_id);");
    mysqli_query($connection, "ALTER TABLE custom_fields_category ADD INDEX idx_field_id (field_id);");
    mysqli_query($connection, "ALTER TABLE custom_fields_lang ADD INDEX idx_field_id (field_id);");
    mysqli_query($connection, "ALTER TABLE custom_fields_lang ADD INDEX idx_lang_id (lang_id);");
    mysqli_query($connection, "ALTER TABLE custom_fields_options ADD INDEX idx_lang_id (lang_id);");
    mysqli_query($connection, "ALTER TABLE custom_fields_options ADD INDEX idx_field_id (field_id);");
    mysqli_query($connection, "ALTER TABLE custom_fields_product ADD INDEX idx_field_id (field_id);");
    mysqli_query($connection, "ALTER TABLE custom_fields_product ADD INDEX idx_product_id (product_id);");
    mysqli_query($connection, "ALTER TABLE digital_files ADD INDEX idx_product_id (product_id);");
    mysqli_query($connection, "ALTER TABLE digital_files ADD INDEX idx_user_id (user_id);");
    mysqli_query($connection, "ALTER TABLE digital_sales ADD INDEX idx_order_id (order_id);");
    mysqli_query($connection, "ALTER TABLE digital_sales ADD INDEX idx_product_id (product_id);");
    mysqli_query($connection, "ALTER TABLE earnings ADD INDEX idx_user_id (user_id);");
    mysqli_query($connection, "ALTER TABLE followers ADD INDEX idx_following_id (following_id);");
    mysqli_query($connection, "ALTER TABLE followers ADD INDEX idx_follower_id (follower_id);");
    mysqli_query($connection, "ALTER TABLE images ADD INDEX idx_product_id (product_id);");
    mysqli_query($connection, "ALTER TABLE images ADD INDEX idx_is_main (is_main);");
    mysqli_query($connection, "ALTER TABLE images_file_manager ADD INDEX idx_user_id (user_id);");
    mysqli_query($connection, "ALTER TABLE images_variation ADD INDEX idx_product_id (product_id);");
    mysqli_query($connection, "ALTER TABLE images_variation ADD INDEX idx_variation_option_id (variation_option_id);");
    mysqli_query($connection, "ALTER TABLE images_variation ADD INDEX idx_is_main (is_main);");
    mysqli_query($connection, "ALTER TABLE invoices ADD INDEX idx_order_id (order_id);");
    mysqli_query($connection, "ALTER TABLE language_translations ADD INDEX idx_lang_id (lang_id);");
    mysqli_query($connection, "ALTER TABLE location_states ADD INDEX idx_country_id (country_id);");
    mysqli_query($connection, "ALTER TABLE location_cities ADD INDEX idx_country_id (country_id);");
    mysqli_query($connection, "ALTER TABLE location_cities ADD INDEX idx_state_id (state_id);");
    mysqli_query($connection, "ALTER TABLE media ADD INDEX idx_product_id (product_id);");
    mysqli_query($connection, "ALTER TABLE orders ADD INDEX idx_order_number (order_number);");
    mysqli_query($connection, "ALTER TABLE orders ADD INDEX idx_buyer_id (buyer_id);");
    mysqli_query($connection, "ALTER TABLE orders ADD INDEX idx_status (status);");
    mysqli_query($connection, "ALTER TABLE order_products ADD INDEX idx_order_id (order_id);");
    mysqli_query($connection, "ALTER TABLE order_products ADD INDEX idx_seller_id (seller_id);");
    mysqli_query($connection, "ALTER TABLE order_products ADD INDEX idx_buyer_id (buyer_id);");
    mysqli_query($connection, "ALTER TABLE order_products ADD INDEX idx_product_id (product_id);");
    mysqli_query($connection, "ALTER TABLE order_shipping ADD INDEX idx_order_id (order_id);");
    mysqli_query($connection, "ALTER TABLE payments ADD INDEX idx_payment_id (payment_id);");
    mysqli_query($connection, "ALTER TABLE payments ADD INDEX idx_user_id (user_id);");
    mysqli_query($connection, "ALTER TABLE payments ADD INDEX idx_product_id (product_id);");
    mysqli_query($connection, "ALTER TABLE payouts ADD INDEX idx_user_id (user_id);");
    mysqli_query($connection, "ALTER TABLE products ADD INDEX idx_category_id (category_id);");
    mysqli_query($connection, "ALTER TABLE products ADD INDEX idx_country_id (country_id);");
    mysqli_query($connection, "ALTER TABLE products ADD INDEX idx_state_id (state_id);");
    mysqli_query($connection, "ALTER TABLE products ADD INDEX idx_city_id (city_id);");
    mysqli_query($connection, "ALTER TABLE products ADD INDEX idx_user_id (user_id);");
    mysqli_query($connection, "ALTER TABLE products ADD INDEX idx_status (status);");
    mysqli_query($connection, "ALTER TABLE products ADD INDEX idx_is_promoted (is_promoted);");
    mysqli_query($connection, "ALTER TABLE products ADD INDEX idx_visibility (visibility);");
    mysqli_query($connection, "ALTER TABLE products ADD INDEX idx_is_deleted (is_deleted);");
    mysqli_query($connection, "ALTER TABLE products ADD INDEX idx_is_draft (is_draft);");
    mysqli_query($connection, "ALTER TABLE products ADD INDEX idx_created_at (created_at);");
    mysqli_query($connection, "ALTER TABLE product_license_keys ADD INDEX idx_product_id (product_id);");
    mysqli_query($connection, "ALTER TABLE quote_requests ADD INDEX idx_product_id (product_id);");
    mysqli_query($connection, "ALTER TABLE quote_requests ADD INDEX idx_seller_id (seller_id);");
    mysqli_query($connection, "ALTER TABLE quote_requests ADD INDEX idx_buyer_id (buyer_id);");
    mysqli_query($connection, "ALTER TABLE reviews ADD INDEX idx_product_id (product_id);");
    mysqli_query($connection, "ALTER TABLE reviews ADD INDEX idx_user_id (user_id);");
    mysqli_query($connection, "ALTER TABLE transactions ADD INDEX idx_payment_id (payment_id);");
    mysqli_query($connection, "ALTER TABLE transactions ADD INDEX idx_order_id (order_id);");
    mysqli_query($connection, "ALTER TABLE transactions ADD INDEX idx_user_id (user_id);");
    mysqli_query($connection, "ALTER TABLE user_payout_accounts ADD INDEX idx_user_id (user_id);");
    mysqli_query($connection, "ALTER TABLE variations ADD INDEX idx_product_id (product_id);");
    mysqli_query($connection, "ALTER TABLE variations ADD INDEX idx_user_id (user_id);");
    mysqli_query($connection, "ALTER TABLE variations ADD INDEX idx_parent_id (parent_id);");
    mysqli_query($connection, "ALTER TABLE variations ADD INDEX idx_is_visible (is_visible);");
    mysqli_query($connection, "ALTER TABLE variation_options ADD INDEX idx_variation_id (variation_id);");
    mysqli_query($connection, "ALTER TABLE variation_options ADD INDEX idx_parent_id (parent_id);");
    mysqli_query($connection, "ALTER TABLE wishlist ADD INDEX idx_product_id (product_id);");
    mysqli_query($connection, "ALTER TABLE wishlist ADD INDEX idx_user_id (user_id);");

}


/*====================== HELPERS ======================*/
function generate_variation_label_array($connection, $common_id)
{
    $array_names = array();
    $sql = "SELECT * FROM product_variations WHERE common_id='" . $common_id . "' ORDER BY id";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            $item = array(
                'lang_id' => intval(@$row["lang_id"]),
                'label' => @$row["label"]
            );
            array_push($array_names, $item);
        }
    }
    return @serialize($array_names);
}

function generate_variation_option_names_array($connection, $option_common_id)
{
    $array_names = array();
    $sql = "SELECT * FROM product_variations_options WHERE option_common_id='" . $option_common_id . "' ORDER BY id";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            $item = array(
                'lang_id' => intval(@$row["lang_id"]),
                'option_name' => @$row["option_text"]
            );
            array_push($array_names, $item);
        }
    }
    return @serialize($array_names);
}

function phrases()
{
    $p = array();
    //13 to 16
    $p["google_login"] = "Google Login";
    $p["connect_with_facebook"] = "Connect with Facebook";
    $p["connect_with_google"] = "Connect with Google";
    $p["add_to_product_filters"] = "Add to Product Filters";
    $p["remove_from_product_filters"] = "Remove from Product Filters";
    $p["save_and_continue"] = "Save and Continue";
    $p["custom_field"] = "Custom Field";
    $p["custom_field_options"] = "Custom Field Options";
    $p["show_under_these_categories"] = "Custom field will be displayed under these categories";
    $p["edit_options"] = "Edit Options";
    $p["listing_type"] = "Listing Type";
    $p["product_type"] = "Product Type";
    $p["physical"] = "Physical";
    $p["physical_exp"] = "A tangible product that you will ship to buyers";
    $p["digital"] = "Digital";
    $p["digital_exp"] = "A digital file that buyers will download";
    $p["drag_drop_images_here"] = "Drag and drop images here or";
    $p["drag_drop_file_here"] = "Drag and drop file here or";
    $p["product_image_exp"] = "Products with good and clear images are sold faster!";
    $p["browse_files"] = "Browse Files";
    $p["waiting"] = "Waiting...";
    $p["add_product_for_sale"] = "Add a Product for Sale";
    $p["add_product_for_sale_exp"] = "Add a product to sell on the site (a commission can be taken)";
    $p["add_product_services_listing"] = "Add a Product or Service as an Ordinary Listing";
    $p["add_product_services_listing_exp"] = "Add a product or service without buy option";
    $p["sell_my_product_on_site"] = "Sell product on the site";
    $p["edit_product"] = "Edit Product";
    $p["maintenance_mode"] = "Maintenance Mode";
    $p["variations"] = "Variations";
    $p["variations_exp"] = "Add available options, like color or size that buyers can choose during checkout";
    $p["add_variation"] = "Add Variation";
    $p["available_in_stock"] = "Available in Stock ";
    $p["select_existing_variation"] = "Select an Existing Variation";
    $p["created_variations"] = "Created Variations";
    $p["msg_no_created_variations"] = "You have no created variations.";
    $p["edit_variation"] = "Edit Variation";
    $p["label"] = "Label";
    $p["variation_type"] = "Variation Type";
    $p["text"] = "Text";
    $p["textarea"] = "Textarea";
    $p["number"] = "Number";
    $p["checkbox"] = "Checkbox";
    $p["radio_button"] = "Radio Button";
    $p["dropdown"] = "Dropdown";
    $p["confirm_variation"] = "Are you sure you want to delete this variation?";
    $p["aws_base_url"] = "AWS Base URL";
    $p["monday"] = "Monday";
    $p["tuesday"] = "Tuesday";
    $p["wednesday"] = "Wednesday";
    $p["thursday"] = "Thursday";
    $p["friday"] = "Friday";
    $p["saturday"] = "Saturday";
    $p["sunday"] = "Sunday";
    $p["add_image"] = "Add Image";
    $p["add_video"] = "Add Video";
    $p["video"] = "Video";
    $p["audio"] = "Audio";
    $p["add_iframe"] = "Add Iframe";
    $p["upload"] = "Upload";
    $p["uploading"] = "Uploading...";
    $p["text_editor_language"] = "Text Editor Language";
    $p["demo_url"] = "Demo URL";
    $p["demo_url_exp"] = "Add a preview URL (i.e. https://demo.com)";
    $p["external_link_exp"] = "You can add an external product link. (i.e. https://domain.com/product)";
    $p["live_preview"] = "Live Preview";
    $p["video_preview"] = "Video Preview";
    $p["video_preview_exp"] = "MP4 or WEBM preview video";
    $p["audio_preview"] = "Audio Preview";
    $p["audio_preview_exp"] = "MP3 or WAV preview audio";
    $p["add_iframe"] = "Add Iframe";
    $p["confirm_product_video"] = "Are you sure you want to delete this video?";
    $p["confirm_product_audio"] = "Are you sure you want to delete this audio?";
    $p["digital_files"] = "Digital Files";
    $p["digital_files_exp"] = "Upload a ZIP file that containing all buyers files";
    $p["select_file"] = "Select File";
    $p["download"] = "Download";
    $p["downloads"] = "Downloads";
    $p["comments"] = "Comments";
    $p["form_settings"] = "Form Settings";
    $p["shipping_options"] = "Shipping Options";
    $p["product_conditions"] = "Product Conditions";
    $p["add_shipping_option"] = "Add Shipping Option";
    $p["edit_shipping_option"] = "Edit Shipping Option";
    $p["option_label"] = "Option Label";
    $p["msg_option_added"] = "Option successfully added!";
    $p["confirm_option"] = "Are you sure you want to delete this option?";
    $p["product_conditions"] = "Product Conditions";
    $p["add_product_condition"] = "Add Product Condition";
    $p["edit_product_condition"] = "Edit Product Condition";
    $p["physical_products"] = "Physical Products";
    $p["digital_products"] = "Digital Products";
    $p["digital_sales"] = "Digital Sales";
    $p["marketplace_selling_product_on_the_site"] = "Marketplace (Selling Products on the Site)";
    $p["classified_ads_adding_product_as_listing"] = "Classified Ads (Adding a Product or Service as an Ordinary Listing)";
    $p["msg_error_product_type"] = "You must enable at least one product type";
    $p["msg_error_selected_system"] = "You must enable at least one system";
    $p["default_product_currency"] = "Default Product Currency";
    $p["allow_all_currencies_classified_ads"] = "Allow All Currencies for Ordinary Listing";
    $p["only_for_ordinary_listing"] = "Only for Ordinary Listing";
    $p["instant_download"] = "Instant download";
    $p["files_included"] = "Files Included";
    $p["files_included_ext"] = "Enter the extensions of the files that you are going to sell (i.e. JPG, MP4, MP3)";
    $p["no_shipping"] = "No Shipping";
    $p["drafts"] = "Drafts";
    $p["draft"] = "Draft";
    $p["save_as_draft"] = "Save as Draft";
    $p["msg_digital_product_register_error"] = "You must create an account to purchase a digital product.";
    $p["menu_limit"] = "Menu Limit";
    $p["number_of_links_in_menu"] = "The number of links that appear in the menu";
    $p["more"] = "More";
    $p["show_image_on_navigation"] = "Show Category Image on the Navigation";
    $p["purchase_code"] = "Purchase Code";
    $p["ok"] = "OK";
    $p["cancel"] = "Cancel";
    $p["msg_payout_paypal_error"] = "You must enter your PayPal email address to make this payment request";
    $p["msg_accept_bank_transfer"] = "Are you sure you want to set this order as payment received?";
    $p["add_tracking_number"] = "Add Tracking Number";
    $p["send_email_to_buyer"] = "Send Email to Buyer";
    $p["vendors"] = "Vendors";
    $p["shop_settings"] = "Shop Settings";
    $p["shop_name"] = "Shop Name";
    $p["shop_description"] = "Shop Description";
    $p["start_selling"] = "Start Selling";
    $p["start_selling_exp"] = "In order to sell your products, you must be a verified member. Verification is a one-time process. This verification process is necessary because of spammers and fraud.";
    $p["tell_us_about_shop"] = "Tell Us About Your Shop";
    $p["shop_opening_requests"] = "Shop Opening Requests";
    $p["msg_start_selling"] = "We have received your request. Your store will be open when your request is approved.";
    $p["msg_shop_opening_requests"] = "Your request to open a store is under evaluation!";
    $p["msg_shop_name_unique_error"] = "The shop name has already been taken.";
    $p["msg_shop_request_declined"] = "Your shop opening request has been declined. Thank you for your interest.";
    $p["from"] = "From:";
    $p["to"] = "To:";
    $p["open_user_shop"] = "Open User Shop";
    $p["close_user_shop"] = "Close User Shop";
    $p["confirm_close_user_shop"] = "Are you sure you want to close this shop?";
    $p["cities"] = "Cities";
    $p["add_city"] = "Add City";
    $p["update_city"] = "Update City";
    $p["enter_location"] = "Enter Location";
    $p["main"] = "main";
    $p["file_upload"] = "File Upload";
    $p["max_file_size"] = "Max File Size";
    $p["free_listing"] = "Free Listing";
    $p["add_product_to_promoted"] = "Add Product to Promoted";
    $p["backward"] = "Backward";
    $p["play"] = "Play";
    $p["pause"] = "Pause";
    $p["forward"] = "Forward";
    $p["see_order_details"] = "See Order Details";
    $p["send_email_item_sold"] = "Send me an email when one of my item is sold";
    $p["you_have_new_order"] = "You have a new order";
    $p["update_slider_item"] = "Update Slider Item";
    $p["msg_message_sent_error"] = "You cannot send message to yourself!";
    //14 to 16
    $p["bidding_system"] = "Bidding System";
    $p["bidding_system_request_quote"] = "Bidding System (Request Quote)";
    $p["add_product_get_price_requests"] = "Add a Product to Receive Quote (Price) Requests";
    $p["bidding_system_emails"] = "Bidding system emails";
    $p["add_product_get_price_requests_exp"] = "Add a product without adding a price to get price requests from customers";
    $p["quote"] = "Quote";
    $p["request_a_quote"] = "Request a Quote";
    $p["quote_requests"] = "Quote Requests";
    $p["quote_request"] = "Quote Request";
    $p["sent_quote_requests"] = "Sent Quote Requests";
    $p["received_quote_requests"] = "Received Quote Requests";
    $p["msg_quote_request_sent"] = "Your request has been successfully submitted.";
    $p["msg_quote_request_error"] = "You cannot request a quote for your own item!";
    $p["sellers_bid"] = "Seller's Bid";
    $p["awaiting_sellers_bid"] = "Awaiting Seller's Bid";
    $p["accept_quote"] = "Accept Quote";
    $p["reject_quote"] = "Reject Quote";
    $p["delete_quote"] = "Delete Quote";
    $p["confirm_quote_request"] = "Are you sure you want to delete this quote request?";
    $p["submit_a_quote"] = "Submit a Quote";
    $p["submit_a_new_quote"] = "Submit a New Quote";
    $p["update_quote"] = "Update Quote";
    $p["new_quote_request"] = "New Quote Request";
    $p["you_have_new_quote_request"] = "You have a new quote request.";
    $p["your_quote_request_replied"] = "Your quote request has been replied.";
    $p["your_quote_accepted"] = "Your quote has been accepted.";
    $p["your_quote_rejected"] = "Your quote has been rejected.";
    $p["pending_quote"] = "Pending Quote";
    $p["pending_payment"] = "Pending Payment";
    $p["rejected_quote"] = "Rejected Quote";
    $p["closed"] = "Closed";
    $p["msg_error_cart_unapproved_products"] = "Unapproved products cannot be added to the cart!";
    $p["shop_opening_request"] = "Shop Opening Request";
    $p["there_is_shop_opening_request"] = "There is a new shop opening request.";
    $p["send_email_shop_opening_request"] = "Send email when there is a new shop opening request";
    $p["your_shop_opening_request_approved"] = "Your shop opening request has been approved. You can go to our site and start to sell your items!";
    $p["homepage"] = "Homepage";
    $p["general"] = "General";
    $p["pagseguro"] = "PagSeguro";
    $p["token"] = "Token";
    $p["production"] = "Production";
    $p["sandbox"] = "Sandbox";
    $p["credit_card"] = "Credit Card";
    $p["boleto"] = "Boleto";
    $p["name_on_the_card"] = "Name on the Card";
    $p["card_number"] = "Card Number";
    $p["expiration_date"] = "Expiration Date (MM / YY)";
    $p["cvv"] = "CVV";
    $p["cvv_exp"] = "Three-digits code on the back of your card";
    $p["cpf"] = "CPF";
    $p["date_of_birth"] = "Date of Birth";
    $p["cell_phone"] = "Cell Phone";
    $p["confirm_payment"] = "Confirm Payment";
    $p["postal_code"] = "Postal Code";
    $p["paystack"] = "PayStack";
    $p["public_key"] = "Public Key";
    $p["msg_confirmed_required"] = "In order to login to the site, you must confirm your email address.";
    $p["msg_confirmation_email"] = "Please click on the button below to confirm your account.";
    $p["confirm_your_account"] = "Confirm Your Account";
    $p["pay_now"] = "Pay Now";
    $p["free_promotion"] = "Free Promotion";
    $p["free_product"] = "Free Product";
    $p["free"] = "Free";
    $p["pay"] = "Pay";
    $p["edit_details"] = "Edit Details";
    $p["guest_checkout"] = "Guest Checkout";
    $p["google_adsense_code"] = "Google Adsense Code";
    $p["watermark"] = "Watermark";
    $p["watermark_image"] = "Watermark Image";
    $p["add_watermark_product_images"] = "Add Watermark to Product Images";
    $p["add_watermark_blog_images"] = "Add Watermark to Blog Images";
    $p["add_watermark_thumbnail_images"] = "Add Watermark to Thumbnail (Small) Images";
    $p["vertical_alignment"] = "Vertical Alignment";
    $p["horizontal_alignment"] = "Horizontal Alignment";
    $p["top"] = "Top";
    $p["middle"] = "Middle";
    $p["bottom"] = "Bottom";
    $p["center"] = "Center";
    $p["not_enough_quantity"] = "Not enough quantity";
    $p["translation"] = "Translation";
    $p["msg_register_success"] = "Your account has been created successfully!";
    $p["license_keys"] = "License Keys";
    $p["license_key"] = "License Key";
    $p["license_keys_exp"] = "Add your license keys if you want to give an unique license key for each purchase.";
    $p["add_license_keys"] = "Add License Keys";
    $p["view_license_keys"] = "View License Keys";
    $p["add_license_keys_exp"] = "Add all license keys with comma(,) separator. (i.e. License Key, License Key...)";
    $p["msg_add_license_keys"] = "License keys successfully added!";
    $p["allow_duplicate_license_keys"] = "Allow Duplicate License Keys";
    $p["main_files"] = "Main File(s)";
    $p["license_certificate"] = "License Certificate";
    $p["product_url"] = "Product URL";
    $p["cash_on_delivery"] = "Cash On Delivery";
    $p["cash_on_delivery_exp"] = "Pay with cash upon delivery.";
    $p["cash_on_delivery_warning"] = "You have selected 'Cash on Delivery' as your payment method. You must pay the total amount when you receive your package. If you accept this payment method, please click the button below to complete your order.";
    $p["vendor_verification_system"] = "Vendor Verification System";
    $p["vendor_verification_system_exp"] = "Disable if you want to allow all users to add products.";
    $p["bank_transfer_exp"] = "Make your payment directly into our bank account.";
    $p["confirm_order_received"] = "Confirm Order Received";
    $p["confirm_order_received_exp"] = "Confirm if you have received your order.";
    $p["confirm_order_received_warning"] = "When you receive your order, please check the products you have purchased. If there is not any problem, click 'Confirm Order Received' button. After confirming your order, the money will be transferred to the seller.";
    $p["confirm_approve_order"] = "Are you sure you want to confirm this order?";
    $p["confirmed"] = "Confirmed";
    //15 to 16
    $p["button"] = "Button";
    $p["button_text"] = "Button Text";
    $p["animations"] = "Animations";
    $p["slider_settings"] = "Slider Settings";
    $p["effect"] = "Effect";
    $p["boxed"] = "Boxed";
    $p["top_menu"] = "Top Menu";
    $p["warning"] = "Warning";
    $p["route_settings"] = "Route Settings";
    $p["route_settings_warning"] = "You cannot use special characters in routes. If your language contains special characters, please be careful when editing routes. If you enter an invalid route, you will not be able to access the related page.";
    $p["text_color"] = "Text Color";
    $p["button_color"] = "Button Color";
    $p["button_text_color"] = "Button Text Color";
    $p["font_settings"] = "Font Settings";
    $p["site_font"] = "Site Font";
    $p["fonts"] = "Fonts";
    $p["add_font"] = "Add Font";
    $p["font_family"] = "Font Family";
    $p["update_font"] = "Update Font";
    $p["vat"] = "VAT";
    $p["vat_exp"] = "Value-Added Tax";
    $p["add_to_wishlist"] = "Add to wishlist";
    $p["remove_from_wishlist"] = "Remove from wishlist";
    $p["additional_information"] = "Additional Information";
    $p["shipping_location"] = "Shipping & Location";
    $p["you_may_also_like"] = "You may also like";
    $p["wishlist"] = "Wishlist";
    $p["allowed_file_extensions"] = "Allowed File Extensions";
    $p["type_extension"] = "Type an extension and hit enter";
    $p["invalid_file_type"] = "Invalid file type!";
    $p["flag"] = "Flag";
    $p["add_a_comment"] = "Add a comment";
    $p["comment_approval_system"] = "Comment Approval System";
    $p["pending_comments"] = "Pending Comments";
    $p["approved_comments"] = "Approved Comments";
    $p["msg_comment_approved"] = "Comment successfully approved!";
    $p["msg_comment_sent_successfully"] = "Your comment has been sent. It will be published after being reviewed by the site management.";
    $p["no_comments_found"] = "No comments found for this product. Be the first to comment!";
    $p["no_reviews_found"] = "No reviews found.";
    $p["rate_this_product"] = "Rate this product";
    $p["msg_review_added"] = "Your review has been successfully added!";
    $p["vat_included"] = "VAT Included";
    $p["product_price"] = "Product Price";
    $p["discount_rate"] = "Discount Rate";
    $p["no_discount"] = "No Discount";
    $p["calculated_price"] = "Calculated Price";
    $p["add_space_between_money_currency"] = "Add Space Between Money and Currency";
    $p["view_invoice"] = "View Invoice";
    $p["invoice"] = "Invoice";
    $p["personal_information"] = "Personal Information";
    $p["client_information"] = "Client Information";
    $p["invoice_currency_warning"] = "All amounts shown on this invoice are in";
    $p["print"] = "Print";
    $p["invoices"] = "Invoices";
    $p["view_options"] = "View Options";
    $p["option_name"] = "Option Name";
    $p["msg_option_added"] = "Option added successfully!";
    $p["use_default_price"] = "Use default price";
    $p["color"] = "Color";
    $p["stock"] = "Stock";
    $p["add_product"] = "Add Product";
    $p["edit_option"] = "Edit Option";
    $p["msg_option_exists"] = "This option already exists!";
    $p["default_option"] = "Default Option";
    $p["default_option_exp"] = "This option will be selected by default. It will use the default images and price";
    $p["sku"] = "SKU";
    $p["product_code"] = "Product Code";
    $p["option_display_type"] = "Option Display Type";
    $p["show_option_images_on_slider"] = "Show Option Images on Slider When an Option is Selected";
    $p["in_stock"] = "In Stock";
    $p["out_of_stock"] = "Out of Stock";
    $p["parent_variation"] = "Parent Variation";
    $p["parent_option"] = "Parent Option";
    $p["use_different_price_for_options"] = "Use Different Price for Options";
    $p["location_exp"] = "Modesy allows you to shop from anywhere in the world.";
    $p["select_location"] = "Select Location";
    $p["update_location"] = "Update Location";
    $p["show_all"] = "Show All";
    $p["search_products"] = "Search Products";
    $p["activate_all"] = "Activate All";
    $p["inactivate_all"] = "Inactivate All";
    $p["hide_vendor_contact_information"] = "Hide Vendor Contact Information on the Site";
    $p["online"] = "Online";
    $p["checkout_form"] = "Checkout Form";
    $p["marketplace"] = "Marketplace";
    $p["identity_number"] = "Identity Number";
    $p["submerchant"] = "Submerchant";
    $p["tax_office"] = "Tax Office";
    $p["tax_number"] = "Tax Number";
    $p["company_title"] = "Company Title";
    $p["create_key"] = "Create Key";
    $p["submerchant_key"] = "Submerchant Key";
    $p["vk_login"] = "VKontakte Login";
    $p["secure_key"] = "Secure Key";
    $p["connect_with_vk"] = "Connect with VKontakte";
    $p["edit_user"] = "Edit User";
    $p["digital_product_stock_exp"] = "Enter a high stock value for products with unlimited quantity.";
    $p["shipping_cost_per_additional_product"] = "Shipping Cost for Per Additional Product";
    $p["shipping_cost_per_additional_product_exp"] = "The shipping cost for per additional product if a buyer buys more than one of the same product";
    $p["new_arrivals"] = "New Arrivals";
    $p["featured_products"] = "Featured Products";
    $p["featured_products_exp"] = "Last added featured products";
    $p["featured"] = "Featured";
    $p["featured_badge"] = "Featured Badge";
    $p["index_featured_products"] = "Index Featured Products";
    $p["index_featured_products_count"] = "Index Number of Featured Products";
    $p["add_to_featured"] = "Add to Featured";
    $p["remove_from_featured"] = "Remove from Featured";
    $p["featured_products_transactions"] = "Featured Products Transactions";
    $p["featured_products_payment_currency"] = "Featured Products Payment Currency";
    $p["add_review"] = "Add Review";
    $p["more_from"] = "More from";
    $p["product_bottom_ad_space"] = "Product Bottom Ad Space";
    $p["adsense_head_exp"] = "The codes you add here will be added in the <head></head> tags.";
    $p["custom_css_codes"] = "Custom CSS Codes";
    $p["custom_javascript_codes"] = "Custom JavaScript Codes";
    $p["custom_javascript_codes_exp"] = "These codes will be added to the footer of the site.";
    $p["custom_css_codes_exp"] = "These codes will be added to the header of the site.";
    $p["unlimited_stock"] = "Unlimited Stock";
    $p["send_test_email"] = "Send Test Email";
    $p["send_test_email_exp"] = "You can send a test mail to check if your mail server is working.";
    return $p;
}

function add_phrases_if_not_exists($connection)
{
    $p = array();
    $p["msg_message_sent_error"] = "You cannot send message to yourself!";
    $p["invalid_withdrawal_amount"] = "Invalid withdrawal amount!";
    $p["active_payment_request_error"] = "You already have an active payment request! Once this is complete, you can make a new request.";

    //add new phrases
    $sql = "SELECT * FROM languages ORDER BY id";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_array($result)) {
        foreach ($p as $key => $value) {
            $sql_check = "SELECT * FROM language_translations WHERE lang_id = " . $row["id"] . " AND label = '" . $key . "'  ORDER BY id LIMIT 1";
            $result_check = mysqli_query($connection, $sql_check);
            if ($result_check->num_rows < 1) {
                $insert_new_translation = "INSERT INTO `language_translations` (`lang_id`, `label`, `translation`) 
                    VALUES (" . $row["id"] . ", '" . $key . "' , '" . $value . "')";
                mysqli_query($connection, $insert_new_translation);
            }
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modesy - Update Wizard</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700" rel="stylesheet">
    <!-- Font-awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #444 !important;
            font-size: 14px;

            background: #007991; /* fallback for old browsers */
            background: -webkit-linear-gradient(to left, #007991, #6fe7c2); /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to left, #007991, #6fe7c2); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        }

        .logo-cnt {
            text-align: center;
            color: #fff;
            padding: 60px 0 60px 0;
        }

        .logo-cnt .logo {
            font-size: 42px;
            line-height: 42px;
        }

        .logo-cnt p {
            font-size: 22px;
        }

        .install-box {
            width: 100%;
            padding: 30px;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            margin: auto;
            background-color: #fff;
            border-radius: 4px;
            display: block;
            float: left;
            margin-bottom: 100px;
        }

        .form-input {
            box-shadow: none !important;
            border: 1px solid #ddd;
            height: 44px;
            line-height: 44px;
            padding: 0 20px;
        }

        .form-input:focus {
            border-color: #239CA1 !important;
        }

        .btn-custom {
            background-color: #239CA1 !important;
            border-color: #239CA1 !important;
            border: 0 none;
            border-radius: 4px;
            box-shadow: none;
            color: #fff !important;
            font-size: 16px;
            font-weight: 300;
            height: 40px;
            line-height: 40px;
            margin: 0;
            min-width: 105px;
            padding: 0 20px;
            text-shadow: none;
            vertical-align: middle;
        }

        .btn-custom:hover, .btn-custom:active, .btn-custom:focus {
            background-color: #239CA1;
            border-color: #239CA1;
            opacity: .8;
        }

        .tab-content {
            width: 100%;
            float: left;
            display: block;
        }

        .tab-footer {
            width: 100%;
            float: left;
            display: block;
        }

        .buttons {
            display: block;
            float: left;
            width: 100%;
            margin-top: 30px;
        }

        .title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
            margin-top: 0;
            text-align: center;
        }

        .sub-title {
            font-size: 14px;
            font-weight: 400;
            margin-bottom: 30px;
            margin-top: 0;
            text-align: center;
        }

        .alert {
            text-align: center;
        }

        .alert strong {
            font-weight: 500 !important;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-sm-12 col-md-offset-2">

            <div class="row">
                <div class="col-sm-12 logo-cnt">
                    <h1>Modesy</h1>
                    <p>Welcome to the Update Wizard</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="install-box">
                        <h2 class="title">Update from v1.3.x to v1.6.2</h2>
                        <br><br>
                        <div class="messages">
                            <?php if (!empty($error)) { ?>
                                <div class="alert alert-danger">
                                    <strong><?php echo $error; ?></strong>
                                </div>
                            <?php } ?>
                            <?php if (!empty($success)) { ?>
                                <div class="alert alert-success">
                                    <strong><?php echo $success; ?></strong>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="step-contents">
                            <div class="tab-1">
                                <?php if (empty($success)): ?>
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                        <div class="tab-content">
                                            <div class="tab_1">
                                                <div class="form-group">
                                                    <label for="email">License Code</label>
                                                    <textarea name="license_code" class="form-control form-input" style="resize: vertical; min-height: 80px; height: 80px; line-height: 24px;padding: 10px;" placeholder="Enter License Code" required><?php echo $license_code; ?></textarea>
                                                    <small style="margin-top: 10px;display: block">*You need to enter your license code to this field (not your purchase code).</small>
                                                    <small style="margin-top: 10px;display: block">*If you have forgotten your license code, you can get your license code by entering your domain and purchase code from here: <a href="http://license.codingest.com/modesy-license" target="_blank">http://license.codingest.com/modesy-license</a></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-footer">
                                            <button type="submit" name="btn_submit" class="btn-custom pull-right">Update My Database</button>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
