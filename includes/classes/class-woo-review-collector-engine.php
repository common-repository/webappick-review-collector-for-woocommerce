<?php

/**
 * This class control sending email
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Woo_Review_Collector
 * @subpackage Woo_Review_Collector/includes
 * @author     Md. Ohidul Islam <wahid0003@gmail.com>
 */
class Woo_Review_Collector_Engine
{


    /**
     * Make Email template according to user settings
     * @param $wrcInfo
     * @param $ShortURL
     * @return mixed
     */
    public function make_email_template($wrcInfo,$ShortURL)
    {


        # Replace new line holder with BR
        $wrc_email_body = preg_replace("/-\\|-/", "<br/>", esc_attr(stripslashes(get_option('wrc_email_body'))));
        $wrc_email_signature = preg_replace("/-\\|-/", "<br/>", esc_attr(stripslashes(get_option('wrc_email_signature'))));
        # Get Review form action URL
        $action = get_admin_url() . "admin-post.php";
        # Get Order Info
        $orderInfo = wc_get_order($wrcInfo->order_id);
        $product = wc_get_product($wrcInfo->product_id);
        if (!is_object($product)) {
            return FALSE;
        }

        # Short codes to replace
        $search = array("{customer}", "{Customer}", "{product}", "{description}", "{order_id}", "{order_date}", "{store_name}");
        # Replace Short codes with
        $fName= get_post_meta($wrcInfo->order_id,"_billing_first_name",true);
        $lName= get_post_meta($wrcInfo->order_id,"_billing_last_name",true);
        $nonce = get_option('WRC_NONCE');
        $toName=ucwords($fName." ".$lName);
        $replace = array($toName,$toName,"<b>".$product->get_title()."</b>", $product->get_description(), $wrcInfo->order_id, $orderInfo->get_date_completed(), get_bloginfo("title"));
        $unSubscribeURL = site_url() . "?wrc_order_id=$wrcInfo->order_id&wrc_nonce=$nonce&wrc_action=wrc-review-collector-unsubscribe";

        $message=<<<EOD
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width"/>

    <link rel="stylesheet" href="ink.css"> <!-- For testing only -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,300i,400,400i,500" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i" rel="stylesheet">

    <style type="text/css">

    </style>
</head>
<body style="background-color: #f7f7f7;color:#676a6c;
            font-family: 'Raleway', sans-serif;">

 <form action="$action" method='post'>
        <input type="hidden" name="wrc_order_id" value="$wrcInfo->order_id"/>
        <input type="hidden" name="action" value="woo-review-collector"/>
        <input type="hidden" name="wrc_nonce" value="$nonce"/>
        <input type="hidden" name="wrc_product_id" value="$wrcInfo->product_id" />

    <table cellspacing="0" class="main-table email_table_view"
           style=" background-color: #ffffff; width: 100%; max-width: 600px; margin: 30px auto 5px auto; border-radius: 5px; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-collapse: collapse;box-sizing: content-box;">
        <tbody>
        <tr>
            <td style="height:30px;background-color: #f2f2f2;color:#676a6c;text-align: center;font-size: small;  padding: 20px 5px 10px 5px;">
                If this email is not displaying correctly, please  <a href="$ShortURL/5"> click here </a> to review.
            </td>
        </tr>

        <td class="main-td" style="font-family: Arial; font-family: inherit; color: #676a6c; padding: 0;display: block;">
            <table width="100%" style="border: 2px solid #cbcbcb;">
                <tbody style="margin-top: 20px;">
                <tr>
                    <td width="5%" style="font-family: Arial; font-family: inherit; color: #676a6c"></td>
                    <td style="background-color: white;font-size: 10px;    margin-top: 20px;display: block;"
                        id="emailBodyShow">
                        <span style="font-family: Arial; color: #676a6c; font-size: 14px"><p>$wrc_email_body</p></span></td>
                    <td width="5%" style="font-family: Arial; font-family: inherit; color: #676a6c"></td>
                </tr>

                <tr>
                    <td width="5%" style="font-family: Arial; font-family: inherit; color: #676a6c"></td>
                    <td style="text-align: center;font-size: 20px;color: #393939;padding-top: 10px;">Click below to Rate (1-5) </td>
                    <td width="5%" style="font-family: Arial; font-family: inherit; color: #676a6c"></td>
                </tr>

                <tr>
                    <td width="5%" style="font-family: Arial; font-family: inherit; color: #676a6c"></td>
                    <td width="90%"
                        style="font-family: Arial; font-family: inherit; color: #676a6c; color: #FDC705; direction: ltr; text-align: center">
                        <a href="$ShortURL/1" style="color:#FDC705;display: inline-block; font-size: 60px; text-decoration: none; margin-right: 5px;">&#9734; <span style="display: block;font-size: 12px;color: #000;"> 1</span> </a>
                        <a href="$ShortURL/2" style="color:#FDC705;display: inline-block; font-size: 60px; text-decoration: none; margin-right: 5px;">&#9734; <span style="display: block;font-size: 12px;color: #000;"> 2</span> </a>
                        <a href="$ShortURL/3" style="color:#FDC705;display: inline-block; font-size:60px; text-decoration: none; margin-right: 5px;">&#9734; <span style="display: block;font-size: 12px;color: #000;"> 3</span> </a>
                        <a href="$ShortURL/4" style="color:#FDC705;display: inline-block; font-size: 60px; text-decoration: none; margin-right: 5px;">&#9734; <span style="display: block;font-size: 12px;color: #000;"> 4</span> </a>
                        <a href="$ShortURL/5" style="color:#FDC705;display: inline-block; font-size: 60px; text-decoration: none; margin-right: 5px;">&#9734; <span style="display: block;font-size: 12px;color: #000;"> 5</span> </a>
                    </td>
                    <td width="5%" style="font-family: Arial; font-family: inherit; color: #676a6c"></td>
                </tr>


                <tr>
                    <td style="height: 30px;"></td>
                </tr>
                </tbody>
            </table>
        </td>
        </tr>
        <tr>
            <td id="emailSignatureShow"style="height:30px;background-color: #f8f8f8;text-align: center;font-size: small;line-height: 150%;border: 2px solid #d8d8d8;border-top: none;">
                <p> $wrc_email_signature </p>
            </td>
        </tr>
        </tbody>

        <tfoot style="height:30px;background-color: #f2f2f2;color:#676a6c;text-align: center;font-size: small;  padding: 20px 5px 10px 5px;">
        <tr>
            <td> <p style="text-align: center;font-size: 8px;margin:5px;padding:0;font-weight: bold;">
                <a href="$unSubscribeURL" target="_blank" >Unsubscribe</a>
            </p></td>
        </tr>

        <tr>
            <td>  <p style="margin:5px;padding:0;text-align: center;color:#1cc286!important;font-family: 'Roboto', sans-serif;font-weight:500i;font-size:12">
                <b><a style="text-decoration:none;color: #000000;font-size: 8px;"
                      href="https://webappick.com/plugin/woocommerce-review-collector-pro/" target="_blank">Powered by <br/> <span
                        style="font-size: 8px;color:#1cc286;"> WooCommerce Review Collector Pro </span> <br/> <br/>
                </a></b>
            </p>
            </td>
        </tr>
        </tfoot>
    </table>

    </td>
    </tr>
    </tbody>
    </table>


</body>
</html>
EOD;

        return str_replace($search, $replace, $message);
    }

    /**
     * Make Email template according to user settings
     * @return mixed
     */
    public function make_test_email_template()
    {


        # Replace new line holder with BR
        $wrc_email_body = preg_replace("/-\\|-/", "<br/>", esc_attr(stripslashes(get_option('wrc_email_body'))));
        $wrc_email_signature = preg_replace("/-\\|-/", "<br/>", esc_attr(stripslashes(get_option('wrc_email_signature'))));
        # Get Review form action URL
        $action = get_admin_url() . "admin-post.php";
        # Get Order Info

        # Short codes to replace
        $search = array("{customer}", "{Customer}", "{product}", "{description}", "{order_id}", "{order_date}", "{store_name}");
        # Replace Short codes with
        $replace = array("","","","","","", get_bloginfo("title"));
        $unSubscribeURL = "";


        $message=<<<EOD
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width"/>

    <link rel="stylesheet" href="ink.css"> <!-- For testing only -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,300i,400,400i,500" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i" rel="stylesheet">

    <style type="text/css">

    </style>
</head>
<body style="background-color: #f7f7f7;color:#676a6c;
            font-family: 'Raleway', sans-serif;">

<form action="#" method='post'>
    <input type="hidden" name="review_id" value=""/>
    <input type="hidden" name="action" value="woo-review-collector"/>
    <input type="hidden" name="wrc_nonce" value=""/>
    <input type="hidden" name="wrc_order_id" value="">


    <table cellspacing="0" class="main-table email_table_view"
           style=" background-color: #ffffff; width: 100%; max-width: 600px; margin: 30px auto 5px auto; border-radius: 5px; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-collapse: collapse;box-sizing: content-box;">
        <tbody>
        <tr>
            <td style="height:30px;background-color: #f2f2f2;color:#676a6c;text-align: center;font-size: small;  padding: 20px 5px 10px 5px;">
                If this email is not displaying correctly, please  <a href="http://woo.reviews/r/previewForm"> click here </a> to review.
            </td>
        </tr>

        <td class="main-td" style="font-family: Arial; font-family: inherit; color: #676a6c; padding: 0;display: block;">
            <table width="100%" style="border: 2px solid #cbcbcb;">
                <tbody style="margin-top: 20px;">
                <tr >
                    <td width="5%" style="font-family: Arial; font-family: inherit; color: #676a6c"></td>
                    <td style="background-color: white;font-size: 10px;    margin-top: 20px;display: block;"
                        id="emailBodyShow">
                        <span style="font-family: Arial; color: #676a6c; font-size: 14px"><p>$wrc_email_body</p></span></td>
                    <td width="5%" style="font-family: Arial; font-family: inherit; color: #676a6c"></td>
                </tr>

                <tr>
                    <td width="5%" style="font-family: Arial; font-family: inherit; color: #676a6c"></td>
                    <td style="text-align: center;font-size: 20px;color: #393939;padding-top: 10px;">Click below to Rate (1-5) </td>
                    <td width="5%" style="font-family: Arial; font-family: inherit; color: #676a6c"></td>
                </tr>

                <tr>
                    <td width="5%" style="font-family: Arial; font-family: inherit; color: #676a6c"></td>
                    <td width="90%"
                        style="font-family: Arial; font-family: inherit; color: #676a6c; color: #FDC705; direction: ltr; text-align: center">
                        <a href="http://woo.reviews/r/previewForm/1" style="color:#FDC705;display: inline-block; font-size: 60px; text-decoration: none; margin-right: 5px;">&#9734; <span style="display: block;font-size: 12px;color: #000;"> 1</span> </a>
                        <a href="http://woo.reviews/r/previewForm/2" style="color:#FDC705;display: inline-block; font-size: 60px; text-decoration: none; margin-right: 5px;">&#9734; <span style="display: block;font-size: 12px;color: #000;"> 2</span> </a>
                        <a href="http://woo.reviews/r/previewForm/3" style="color:#FDC705;display: inline-block; font-size:60px; text-decoration: none; margin-right: 5px;">&#9734; <span style="display: block;font-size: 12px;color: #000;"> 3</span> </a>
                        <a href="http://woo.reviews/r/previewForm/4" style="color:#FDC705;display: inline-block; font-size: 60px; text-decoration: none; margin-right: 5px;">&#9734; <span style="display: block;font-size: 12px;color: #000;"> 4</span> </a>
                        <a href="http://woo.reviews/r/previewForm/5" style="color:#FDC705;display: inline-block; font-size: 60px; text-decoration: none; margin-right: 5px;">&#9734; <span style="display: block;font-size: 12px;color: #000;"> 5</span> </a>
                    </td>
                    <td width="5%" style="font-family: Arial; font-family: inherit; color: #676a6c"></td>
                </tr>


                <tr>
                    <td style="height: 30px;"></td>
                </tr>
                </tbody>
            </table>
        </td>
        </tr>




        <tr>
            <td id="emailSignatureShow"style="height:30px;background-color: #f8f8f8;text-align: center;font-size: small;line-height: 150%;border: 2px solid #d8d8d8;border-top: none;">
                <p> $wrc_email_signature </p>
            </td>
        </tr>





        </tbody>

        <tfoot style="height:30px;background-color: #f2f2f2;color:#676a6c;text-align: center;font-size: small;  padding: 20px 5px 10px 5px;">
        <tr>
            <td> <p style="text-align: center;font-size: 8px;margin:5px;padding:0;font-weight: bold;">
                <a href="$unSubscribeURL" target="_blank">Unsubscribe</a>
            </p></td>
        </tr>

        <tr>
            <td>  <p style="margin:5px;padding:0;text-align: center;color:#1cc286!important;font-family: 'Roboto', sans-serif;font-weight:500i;font-size:12">
                <b><a style="text-decoration:none;color: #000000;font-size: 8px;"
                      href="https://webappick.com/plugin/woocommerce-review-collector-pro/" target="_blank">Powered by <br/> <span
                        style="font-size: 8px;color:#1cc286;"> WooCommerce Review Collector Pro </span> <br/> <br/>
                </a></b>
            </p>
            </td>
        </tr>
        </tfoot>
    </table>

    </td>
    </tr>
    </tbody>
    </table>


</body>
</html>
EOD;

        return $message;
    }


    public function getShortUrlBylong_url($url)
    {
        $response = wp_remote_post('http://woo.reviews/r/shortURL', array('body' => array('url' => $url),));

        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();
        } else if (wp_remote_retrieve_response_code($response) == 200) {
            return wp_remote_retrieve_body($response);
        }
        return false;
    }


    /**
     * @param $id
     * @param $totalSent
     * @return bool
     */
    public function send_review_email($id)
    {
    	try{
		    global $wpdb;
		    $wrcInfo = $wpdb->get_row("SELECT * FROM $wpdb->prefix" . "woo_review_collector" . "  WHERE id = $id", OBJECT);

		    if(!$wrcInfo){
			    die("no order");
			    return false;
		    }
		    $siteName    = get_option('blogname');
		    $action      = get_admin_url() . "admin-post.php";
		    $review_id   = $wrcInfo->id;
		    $nonce       = get_option('WRC_NONCE');
		    $action_meta = "woo-review-collector";
		    if(get_option('wrc_product_photo')=='on'){
                $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $wrcInfo->product_id), 'single-post-thumbnail' );
                $image_url = $image_url[0];
            }else{
                $image_url ="";
            }
            $site_url    = site_url() . "?action=$action&wrc_order_id=$wrcInfo->order_id&wrc_product_id=$wrcInfo->product_id&action_meta=$action_meta&nonce=$nonce";

		     $shortURL    = $this->getShortUrlBylong_url($site_url);

		     # Get SMTP Info
		    $wrc_email_smtp_host=get_option('wrc_email_smtp_host');
		    $wrc_email_smtp_port=get_option('wrc_email_smtp_port');
		    $wrc_email_smtp_username=get_option('wrc_email_smtp_username');
		    $wrc_email_smtp_password=get_option('wrc_email_smtp_password');

		    # Set Customer Info
		    $toEmail     = get_post_meta($wrcInfo->order_id,"_billing_email",true);
		    $fName       = get_post_meta($wrcInfo->order_id,"_billing_first_name",true);
		    $lName       = get_post_meta($wrcInfo->order_id,"_billing_last_name",true);
		    $toName      = ucwords($fName." ".$lName);

		    # Set Sender Identity
		    $fromName    = get_option('wrc_email_from_name');
		    $fromEmail   = get_option("wrc_email_from_email");
		    $makeSubject = esc_attr(get_option('wrc_email_subject'));
		    $subject     = str_replace("{store_name}", get_option('blogname'), $makeSubject);

		    # Check Blacklist Email
		    $blacklistEmails = get_option('WRC_review_collection_email_blacklist');
		    if(in_array($toEmail,$blacklistEmails)){
			    return false;
		    }

		    global $phpmailer;
		    if (!($phpmailer instanceof PHPMailer)) {
			    require_once ABSPATH . WPINC . '/class-phpmailer.php';
			    require_once ABSPATH . WPINC . '/class-smtp.php';
			    $phpmailer = new PHPMailer(true);
		    }

		    $phpmailer->clearAllRecipients();
		    $phpmailer->clearAttachments();
		    $phpmailer->clearCustomHeaders();
		    $phpmailer->clearReplyTos();

		    $phpmailer->Username = $wrc_email_smtp_username;
		    $phpmailer->Password = $wrc_email_smtp_password;
		    $phpmailer->Host=$wrc_email_smtp_host;
		    $phpmailer->Port = $wrc_email_smtp_port;
		    $phpmailer->SMTPAuth = true;
		    $phpmailer->SMTPSecure = 'tls';
		    $phpmailer->isSMTP();

            $phpmailer->setFrom($fromEmail,$fromName);
		    $phpmailer->addAddress($toEmail);
		    $phpmailer->Subject = $subject;
		    $phpmailer->Body = $this->make_email_template($wrcInfo, $shortURL);
		    $phpmailer->AltBody = "Hello $toName,\nYou’ve recently bought a {product}, what do you think about it?\n\nWe would like you to write a review on it on: $shortURL \n\nRegards,\n$siteName";
		    if (!$phpmailer->send()) {
			    return false;
		    } else {
			    return true;
		    }
	    }catch (Exception $e){
    		print_r($e->getMessage());
	    }

    }

    public function send_test_email($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
    	try{
		    $siteName = get_option('blogname');
		    $current_user = wp_get_current_user();
		    $firstName=$current_user->display_name;
		    $shortURL = $this->getShortUrlBylong_url(site_url());

		    $message = $this->make_test_email_template();
		    $to = $email;
		    $makeSubject = esc_attr(get_option('wrc_email_subject'));
		    $subject = "[Test]" . str_replace("{store_name}", get_option('blogname'), $makeSubject);

		    # Set Sender Identity
		    $fromName    = get_option('wrc_email_from_name');
		    $fromEmail   = get_option("wrc_email_from_email");

		    # Get SMTP Info
		    $wrc_email_smtp_host=get_option('wrc_email_smtp_host');
		    $wrc_email_smtp_port=get_option('wrc_email_smtp_port');
		    $wrc_email_smtp_username=get_option('wrc_email_smtp_username');
		    $wrc_email_smtp_password=get_option('wrc_email_smtp_password');

		    global $phpmailer;
		    if (!($phpmailer instanceof PHPMailer)) {
			    require_once ABSPATH . WPINC . '/class-phpmailer.php';
			    require_once ABSPATH . WPINC . '/class-smtp.php';
			    $phpmailer = new PHPMailer(true);
		    }

		    // Empty out the values that may be set
		    $phpmailer->clearAllRecipients();
		    $phpmailer->clearAttachments();
		    $phpmailer->clearCustomHeaders();
		    $phpmailer->clearReplyTos();

		    $phpmailer->Username = $wrc_email_smtp_username;
		    $phpmailer->Password = $wrc_email_smtp_password;
		    $phpmailer->Host=$wrc_email_smtp_host;
		    $phpmailer->Port = $wrc_email_smtp_port;
            $phpmailer->SMTPAuth = true;
            $phpmailer->SMTPSecure = 'tls';
            $phpmailer->isSMTP();
			$phpmailer->setFrom( $fromEmail, $fromName);

		    $phpmailer->addAddress($to);
		    $phpmailer->Subject = $subject;
		    $phpmailer->Body = $message;
		    $phpmailer->AltBody = "Hello $firstName,\nYou’ve recently bought a {product}, what do you think about it?\n\nWe would like you to write a review on it on: $shortURL \n\nRegards,\n$siteName";
		      if (!$phpmailer->send()) {
			    return false;
		    } else {
			    return true;
		    }
	    }catch (Exception $e){
    		return $e;
	    }

    }


    # Import old order information from database
    public function import_old_orders()
    {
        global $wpdb;
        # Get WooCommerce Orders
        $month = date("Y-m-d", strtotime('-1 month', time()));

        $sql = $wpdb->prepare("SELECT ID,post_date FROM $wpdb->prefix" . "posts" . " WHERE post_status='wc-completed' AND post_type='shop_order' AND post_date >='%d' ORDER BY 'ASC'",$month);
        $orders = $wpdb->get_results($sql, OBJECT);

        if (!empty($orders)) {
            foreach ($orders as $key => $order) {
                $orderInfo = wc_get_order($order->ID);
                $items = $orderInfo->get_items();
                if (!empty($items)) {
                    foreach ($items as $key => $value) {
                        $productId = $value['product_id'];
                        $check = $wpdb->get_row("SELECT * FROM $wpdb->prefix" . "woo_review_collector" . "  WHERE order_id=$order->ID AND product_id=$productId", OBJECT);
                        if (!$check) {
                           // $ddd = $order->ID . $value['product_id'];
                            $nonce = get_option('WRC_NONCE');
                            $wpdb->insert(
                                $wpdb->prefix . "woo_review_collector",
                                array(
                                    'order_date' => $orderInfo->order_date,
                                    'order_id' => $order->ID,
                                    'product_id' => $value['product_id'],
                                    'nonce' => $nonce
                                ),
                                array(
                                    '%s',
                                    '%d',
                                    '%d',
                                    '%s',
                                )
                            );
                        }
                    }
                }
            }
        }
    }


    /**
     * Save Review
     */
    public function save_review()
    {

        $time = current_time('mysql');
        $order_id = sanitize_text_field($_POST['wrc_order_id']);
        $nonce = sanitize_text_field($_POST['wrc_nonce']);
        $rating = sanitize_text_field($_POST['wrc_rating']);
        $post_id = sanitize_text_field($_POST['wrc_product_id']);
        $reviewTitle = sanitize_text_field($_POST['wrc_reviewTitle']);
        $review = sanitize_text_field($_POST['wrc_review']);

        $review=!empty($review)?$review:$reviewTitle;
        $dbNonce = get_option('WRC_NONCE');
        $orderInfo = wc_get_order($order_id);

        global $wpdb;

        if ($nonce == $dbNonce) {
            $data = array(
                'comment_post_ID' => $post_id,
                'comment_author' => $orderInfo->get_billing_first_name(),
                'comment_author_email' => $orderInfo->get_billing_email(),
                'comment_author_url' => $orderInfo->get_user()->user_url,
                'comment_content' => $review,
                'comment_type' => '',
                'comment_parent' => 0,
                'user_id' => $orderInfo->get_user_id(),
                'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
                'comment_agent' => $_SERVER['HTTP_USER_AGENT'],
                'comment_date' => $time,
                'comment_approved' => 0,
            );

            $comment_id = wp_insert_comment($data);
            add_comment_meta($comment_id, 'wrcReviewTitle', $reviewTitle);

            if (isset($_POST['wrc_rating']) && 'product' === get_post_type($post_id)) {
                if (!$_POST['wrc_rating'] || $_POST['wrc_rating'] > 5 || $_POST['wrc_rating'] < 0) {
                    return;
                }

                add_comment_meta($comment_id, 'rating', (int)esc_attr($rating), true);

            }
            delete_post_meta($post_id, '_wc_average_rating');
            delete_post_meta($post_id, '_wc_rating_count');
            delete_post_meta($post_id, '_wc_review_count');
            WC_Comments::get_average_rating_for_product( wc_get_product( $post_id ) );

	        $wpdb->delete( $wpdb->prefix."woo_review_collector", array( 'order_id' => $order_id ), array( '%d' ) );
        }
    }

    /**
     * Unsubscribe customer to receive email of an order
     * @param $orderInfo
     * @return false|int
     */
    public function unsubscribe($orderInfo)
    {
        global $wpdb;
        $order = sanitize_text_field($orderInfo['wrc_order']);
        if (!empty($order)) {
            return $wpdb->update(
                $wpdb->prefix . "woo_review_collector",
                array('status' => 'Unsubscribed'),
                array('order_id' => $order),
                array('%s'),
                array('%d')
            );
        }
    }


    /**
     * Prepare orders to send email request
     */
    public function prepare_email(){
        global $wpdb;
        $engine = new Woo_Review_Collector_Engine();
        $wrc_enable_email = get_option('wrc_enable_email');
        $currentDate = date("Y-m-d") ;
        # Get Products for Email
        if ($wrc_enable_email == 'on' && $this->wrc_mel()) {//

            if(!(get_option('WOO_REVIEW_'.$currentDate))){

                $sql = $wpdb->prepare("
                          SELECT * FROM $wpdb->prefix" . "woo_review_collector" . " 
                          WHERE sent_date =%s ORDER BY order_id ASC",$currentDate);

                $wrcOrders = $wpdb->get_results($sql, OBJECT);
                $noOfpreparedEmail = count($wrcOrders);
                $system_max_execution_time = ini_get("max_execution_time");
                $sendEmailPerBatch = ceil($noOfpreparedEmail/24);
                if($system_max_execution_time <= 30){
                    echo "Please increase your PHP execution time";
                    $sendEmailPerBatch = 1;
                }

                if(!$sendEmailPerBatch){
                    $sendEmailPerBatch = 1;
                }
                update_option('WOO_REVIEW_'.$currentDate,$sendEmailPerBatch);
                $deleteOption = strtotime("-"."1day", strtotime($currentDate));
                $deleteOption = date("Y-m-d", $deleteOption);
                if(get_option('WOO_REVIEW_'.$deleteOption)){
                    delete_option('WOO_REVIEW_'.$deleteOption);
                }
            }

            $sendEmailPerBatch = get_option('WOO_REVIEW_'.$currentDate);


            $sqlQuery = $wpdb->prepare("
                          SELECT * FROM $wpdb->prefix" . "woo_review_collector" . " 
                          WHERE sent_date =%s ORDER BY order_id ASC LIMIT %d",$currentDate,$sendEmailPerBatch);

            $wrcOrders = $wpdb->get_results($sqlQuery, OBJECT);

            if ($wrcOrders) {
                foreach ($wrcOrders as $key => $wrcOrder) {
                    $sent = $engine->send_review_email($wrcOrder->id);
                    if($sent) {
                        $wpdb->delete($wpdb->prefix."woo_review_collector",array('id'=>$wrcOrder->id),array("%d"));
                    }
                }

            }

        }
    }



    public function wrc_mel(){
        $limitArray=array();
	    $m=get_option('WRC-MEL');
        $month=date('M Y');
        if($m && array_key_exists($month,$m) && $m[$month] < 20){
            $limit=$m[$month] +1;
            $limitArray[$month]=$limit;
            update_option('WRC-MEL',$limitArray);
            return true;
        }else if (!array_key_exists($month,$m)){
	        $limitArray[$month]=0;
	        update_option('WRC-MEL',$limitArray);
	        update_option('WRC-MEL_notice',"0");
        }
        return false;
    }


    public function webappick_review_count(){
        global $wpdb;
        $results = array();
        $res = array();
        $meta_rating='rating';
        $sql = $wpdb->prepare("SELECT COUNT(meta_id) as id, comment_id,meta_key,meta_value From $wpdb->commentmeta WHERE meta_key = %s GROUP BY meta_value",$meta_rating);
        $ratings = $wpdb->get_results($sql, ARRAY_A);
        $ins_array = array(1, 2, 3, 4, 5);
        $rating_meta_array = array();
        foreach ($ratings as $row) {
            array_push($rating_meta_array, $row['meta_value']);
            $res['rate'] = $row['id'];
            $res['rating'] = $row['meta_value'];
            $res['color'] = '#ffcf02';
            array_push($results, $res);
        }
        $insarr = array_diff($ins_array, $rating_meta_array);
        foreach ($insarr as $brr) {
            $rok['rate'] = 0;
            $rok['rating'] = $brr;
            $rok['color'] = '#ffcf02';
            array_push($results, $rok);
        }
        usort($results, function ($a, $b) {
            return $b['rating'] - $a['rating'];
        });
        return $results;
    }


    public function approved_reviewd(){
        global $wpdb;
        $meta_product='product';
        $comment_approved=1;
        $sql =$wpdb->prepare("SELECT COUNT(comment_ID) AS NUMBEROFCOMMENT From $wpdb->comments LEFT JOIN $wpdb->posts  ON $wpdb->comments.comment_post_ID=$wpdb->posts.ID WHERE $wpdb->posts.post_type=%s AND comment_approved =%s",$meta_product,$comment_approved);
        $count = $wpdb->get_var($sql);

        return $count;
    }

    public function unapproved_reviewd(){
        global $wpdb;
        $comments_table = $wpdb->prefix . "comments";
        $posts_table = $wpdb->prefix . "posts";
        $meta_product='product';
        $comment_approved=0;
        $sql =$wpdb->prepare("SELECT COUNT(comment_ID) AS NUMBEROFCOMMENT From $wpdb->comments
        LEFT JOIN $wpdb->posts  ON $wpdb->comments.comment_post_ID=$wpdb->posts.ID WHERE $wpdb->posts.post_type=%s AND comment_approved =%s",$meta_product,$comment_approved);
        $count = $wpdb->get_var($sql);
        return $count;
    }

    public function webappick_reviewed($sent){
        global $wpdb;
        $se="reviewed";
        $review_table=$wpdb->prefix."woo_review_collector";
        $sql =$wpdb->prepare("select count(status) as status From $review_table WHERE status=%s",$se);
        $ratings = $wpdb->get_results($sql, ARRAY_A);
        return $ratings[0]['status'];
    }


    public function rating_average()
    {
        global $wpdb;
        $sql = $wpdb->prepare("SELECT AVG(rating) as rating FROM $wpdb->woo_review_collector  WHERE rating IS NOT NULL ");
        $ratings = $wpdb->get_results($sql, ARRAY_A);
        return $ratings;
    }

    public function toprated_product($sort)
    {
        global $woocommerce;
        global $post;
        global $product;
        $str = '';
        $query_args = array(
            'posts_per_page' => 5,
            'no_found_rows' => 1,
            'post_status' => 'publish',
            'post_type' => 'product',
            'meta_key' => '_wc_average_rating',
            'orderby' => 'meta_value_num',
            'order' => $sort,
            'meta_query' => WC()->query->get_meta_query(),
            'tax_query' => WC()->query->get_tax_query(),
        );
        $r = new WP_Query($query_args);
        if ($r->have_posts()) {
            $str .= '<table class="top_rated_product_list wp-list-table widefat fixed striped posts" cellspacing="0" cellpadding="0">';
            $str .= '<thead> 
                        <tr> 
                            <th> </th>  
                            <th>'. __('Review','woo-review-collector') . '</th>
                            <th>'. __('Rating','woo-review-collector') . '  </th> 
                            <th>'. __('Total Sale','woo-review-collector') . '  </th>  
                            <th>'. __('Name','woo-review-collector') . '  </th> 
                            <th>'. __('Sku','woo-review-collector') . ' </th> 
                            <th>'. __('Price','woo-review-collector') . ' </th> 
                            <th>'. __('Categories','woo-review-collector') . '  </th> 
                        </tr> 
                      </thead>';
            $str .= '<tbody class="the-list">';
            while ($r->have_posts()) {
                $r->the_post();
                $product = new WC_Product(get_the_ID());
                $sku = $product->get_sku();
                $price = $product->get_price();
                $rating = $product->get_average_rating();
                $review = $product->get_review_count();
                $term_list = wp_get_post_terms($post->ID, 'product_cat', array("fields" => "names"));
                $sale = get_post_meta($post->ID, 'total_sales', true);
                $str .= '<tr>';
                if (has_post_thumbnail()) :
                    $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail');
                    $str .= '<td class="column-thumb"> <img src="' . $src[0] . '" width="40" height="40"/> </td>';
                else:
                endif;
                $str .= '<td>' .__($review,'woo-review-collector')  . '</td> ';
                $str .= '<td>' .__($rating,'woo-review-collector')  . '</td> ';
                $str .= '<td>' .__($sale,'woo-review-collector')  . '</td> ';
                $str .= '<td> <a href="' . get_permalink() . '">' .__(get_the_title(),'woo-review-collector')  . '</a> </td> ';
                $str .= '<td>' .__($sku,'woo-review-collector')  . '</td>';
                $str .= '<td>' .__($price,'woo-review-collector')  . '</td>';
                $str .= '<td>' .__(implode(" ,", $term_list),'woo-review-collector')  . '</td>';
                $str .= "</tr>";
            }
            $str .= '</tbody> </table>';
        }
        wp_reset_postdata();
        return $str;
    }

    public function review_performance()
    {
        global $wpdb;
        $meta_product='product';
        $sql =$wpdb->prepare("
            SELECT COUNT(comment_ID) 
                AS NUMBEROFCOMMENT,comment_date,DATE_FORMAT(comment_date,'%b') 
                AS MONTH, DATE_FORMAT(comment_date,'%Y') 
                AS YEAR, DATE_FORMAT(comment_date,'%M %Y') 
                AS monthyear  
            FROM $wpdb->comments
            LEFT JOIN $wpdb->posts ON $wpdb->comments.comment_post_ID =$wpdb->posts.ID 
            WHERE $wpdb->posts.post_type=%s AND $wpdb->comments.comment_date >= DATE_SUB(NOW(),INTERVAL 1 YEAR) GROUP BY MONTH(comment_date)
            ORDER BY YEAR(comment_date), MONTH(comment_date)",$meta_product);
        $reviews = $wpdb->get_results($sql, ARRAY_A);
        return $reviews;
    }

    public function shortURL_delete($id){
        $response = wp_remote_post('http://woo.reviews/r/WRC_delete_shortURL', array('body' => array('wrc_review_id' => $id),));
        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();
        } else if (wp_remote_retrieve_response_code($response) == 200) {
            return wp_remote_retrieve_body($response);
        } else {

        }
    }


}