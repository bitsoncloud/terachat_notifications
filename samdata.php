<?php

function tera_api($postvars, $tiempoEspera = 30){
    if(!isset($postvars["tera_token"]))$postvars["tera_token"] = get_option("tera_notif_token");
    $postdata = http_build_query($postvars);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://tera.chat/api/");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $tiempoEspera);
    curl_setopt($curl, CURLOPT_POST, true); 
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
    $answer = curl_exec($curl);
    return $answer;
}

function tera_notif_text_message($contacto, $mensaje){
    if(get_option("tera_notif_instance") != "" && get_option("tera_notif_instance") != "0"){
        $postvar = [
            "function" => "instance",
            "path" => base64_encode("envio/enviaTexto"),
            "vars" => base64_encode(json_encode([
                "mensaje" => base64_encode($mensaje),
                "contacto" => $contacto,
                "dormir" => 0
            ])),
            "params" => base64_encode(json_encode([])),
            "instance_id" => get_option("tera_notif_instance"),
            "method" => CURLOPT_POST,
            "time" => 0
        ];
        // var_dump($postvar);exit;
        return tera_api($postvar);
    } return false;
}

function test_number($tel){
    $tel = str_replace([" ", "-", "_", "(", ")"], "", $tel);
    if($tel[0].$tel[1] == "00" ) $tel = "+".substr($tel, 2);
    return fix_number(str_split($tel), $tel);
}

function fix_number($arrn, $numero){
    $codemex = "+52";
    $codenmx = $arrn[0].$arrn[1].$arrn[2];
    // var_dump($arrn, $numero, $codenmx);exit;
    if($codemex == $codenmx){
        $yaArreglado = $arrn[0].$arrn[1].$arrn[2].$arrn[3];
        if($yaArreglado == '+521'){
            return substr($numero, 1);
        }else{
            unset($arrn[0]);
            unset($arrn[1]);
            unset($arrn[2]);
            return "521".implode("",$arrn);
        }
    }else{

        return $arrn[0] == '+' ? substr($numero, 1) : $numero;
    }
}

add_action( 'woocommerce_order_status_completed', 'tera_notif_order_completed', 99, 1);
add_action( 'woocommerce_order_status_processing', 'tera_notif_order_processing', 10, 1);
add_action( 'woocommerce_order_status_on-hold', 'tera_notif_order_hold', 10, 1);
add_action( 'woocommerce_order_status_pending', 'tera_notif_order_pending', 10, 1);
add_action( 'woocommerce_order_status_cancelled', 'tera_notif_order_cancelled', 10, 1);
add_action( 'woocommerce_order_status_failed', 'tera_notif_order_failed', 10, 1);
add_action( 'woocommerce_order_status_refunded', 'tera_notif_order_refunded', 10, 1);

function tera_notif_order_completed($order_id){
    $orden = new WC_Order($order_id);
    //$phone = $orden->get_billing_phone();
    $phone = $orden->get_billing_phone();
    // var_dump($phone); exit;
    $phoneFormatted = test_number($phone);
    $msg = get_option("tera_notif_order_completed");
    $msg = parseMSG($msg, $order_id);
    if($msg != "") {
        // $orden->add_order_note($msg);
        tera_notif_text_message($phoneFormatted, $msg);
    }
}

function tera_notif_order_processing($order_id){
    $orden = new WC_Order($order_id);
    //$phone = $orden->get_billing_phone();
    $phone = $orden->get_billing_phone();
    $phoneFormatted = test_number($phone);

    $msg = get_option("tera_notif_order_processing");
    $msg = parseMSG($msg, $order_id);
    //if($msg != "") {
        //if(get_post_meta($order_id, "billing_lat", true) == "") tera_notif_text_message($phoneFormatted, $msg);
        tera_notif_text_message($phoneFormatted, $msg);
        //else enviaMSGLocacionWH($phoneFormatted, parseMSG("[order-billing-lat]", $order_id), parseMSG("[order-billing-long]", $order_id), $msg);
    //}
}

function tera_notif_order_hold($order_id){
    $orden = new WC_Order($order_id);
    //$phone = $orden->get_billing_phone();
    $phone = $orden->get_billing_phone();
    $phoneFormatted = test_number($phone);
  	//var_dump($phone, $phoneFormatted);exit;
    $msg = get_option("tera_notif_order_on-hold");
    $msg = parseMSG($msg, $order_id);
    if($msg != "") tera_notif_text_message($phoneFormatted, $msg);
}

function tera_notif_order_pending($order_id){
    $orden = new WC_Order($order_id);
    //$phone = $orden->get_billing_phone();
    $phone = $orden->get_billing_phone();
    $phoneFormatted = test_number($phone);

    $msg = get_option("tera_notif_order_pending");
    $msg = parseMSG($msg, $order_id);
    if($msg != "") tera_notif_text_message($phoneFormatted, $msg);
}

function tera_notif_order_cancelled($order_id){
    $orden = new WC_Order($order_id);
    //$phone = $orden->get_billing_phone();
    $phone = $orden->get_billing_phone();
    $phoneFormatted = test_number($phone);

    $msg = get_option("tera_notif_order_cancelled");
    $msg = parseMSG($msg, $order_id);
    if($msg != "") tera_notif_text_message($phoneFormatted, $msg);
}

function tera_notif_order_failed($order_id){
    $orden = new WC_Order($order_id);
    //$phone = $orden->get_billing_phone();
    $phone = $orden->get_billing_phone();
    $phoneFormatted = test_number($phone);

    $msg = get_option("tera_notif_order_failed");
    $msg = parseMSG($msg, $order_id);
    if($msg != "") tera_notif_text_message($phoneFormatted, $msg);
}

function tera_notif_order_refunded($order_id){
    $orden = new WC_Order($order_id);
    //$phone = $orden->get_billing_phone();
    $phone = $orden->get_billing_phone();
    $phoneFormatted = test_number($phone);

    $msg = get_option("tera_notif_order_refunded");
    $msg = parseMSG($msg, $order_id);
    if($msg != "") tera_notif_text_message($phoneFormatted, $msg);
}

function tera_notif_update_template($id, $data){

    update_option("tera_notif_order_$id",$data);
}


function parseMSG($msg, $order_id, $user_id = ''){

    $orden = new WC_Order($order_id);

    //Detalles generales
    $msg = str_replace("[site-name]", get_bloginfo( 'name' ), $msg);
    $msg = str_replace("[site-url]", get_home_url(), $msg);
    $msg = str_replace("[privacy-policy]", get_privacy_policy_url(), $msg);

    //Detalles de Usuario
    if($user_id != ""){
        $usuario = new WP_User($user_id);
        $msg = str_replace("[first-name]", $usuario->first_name, $msg);
        $msg = str_replace("[last-name]", $usuario->last_name, $msg);
        $msg = str_replace("[user-name]", $usuario->user_login, $msg);
        $msg = str_replace("[nick-name]", $usuario->nickname, $msg);
        $msg = str_replace("[display-name]", $usuario->display_name, $msg);
        $msg = str_replace("[user-email]", $usuario->user_email, $msg);
        $msg = str_replace("[user-website]", $usuario->user_url, $msg);
    }
    $estados = [
        "completed" => "Completado",
        "processing" => "Procesando",
        "on-hold" => "En Espera",
        "pending" => "Pendiente de pago",
        "cancelled" => "Cancelado",
        "refunded" => "Reembolsado",
        "failed" => "Fallido"
    ];
    $estados = apply_filters("tera_notif_change_order_statuses_name", $estados);

    $msg = str_replace("[order-id]", $order_id, $msg);
    $msg = str_replace("[order-number]", $orden->get_order_number(), $msg);
    $msg = str_replace("[order-status]", $estados[$orden->get_status()], $msg);
    $msg = str_replace("[order-date]", date("d/m/Y", strtotime($orden->get_date_created())), $msg);
    $msg = str_replace("[order-key]", $orden->get_order_key(), $msg);
    $msg = str_replace("[order-subtotal]", $orden->get_subtotal(), $msg);
    $msg = str_replace("[order-discount]", $orden->get_discount_total(), $msg);
    $msg = str_replace("[order-tax]", $orden->get_total_tax(), $msg);
    $msg = str_replace("[order-total]", get_woocommerce_currency()." ".number_format(floatval($orden->get_total()),0), $msg);
    $msg = str_replace("[order-total-1]", get_woocommerce_currency()." ".number_format(floatval($orden->get_total()),1), $msg);
    $msg = str_replace("[order-total-2]", get_woocommerce_currency()." ".number_format(floatval($orden->get_total()),2), $msg);
    $msg = str_replace("[order-total-3]", get_woocommerce_currency()." ".number_format(floatval($orden->get_total()),3), $msg);
    $msg = str_replace("[order-total-4]", get_woocommerce_currency()." ".number_format(floatval($orden->get_total()),4), $msg);
    $msg = str_replace("[order-payment-method]", $orden->get_payment_method_title(), $msg);
    $msg = str_replace("[order-shipping-method]", $orden->get_shipping_method(), $msg);
    $msg = str_replace("[order-shipping-cost]", $orden->get_shipping_total(), $msg);
    $msg = str_replace("[order-total-refund]", get_woocommerce_currency()." ".number_format($orden->get_total_refunded(),2), $msg);
    $msg = str_replace("[order-customer-note]", $orden->get_customer_note(), $msg);
    $msg = str_replace("[order-view-url]", $orden->get_view_order_url(), $msg);
    $msg = str_replace("[order-view-public-url]", $orden->get_checkout_order_received_url(), $msg);
    $msg = str_replace("[order-pay-url]", $orden->get_checkout_payment_url(), $msg);
    
    $checkout_url = wc_get_endpoint_url('order-pay', $order_id, get_permalink(wc_get_page_id('checkout')));
    $complete_checkout_url = add_query_arg(array('key' => $orden->get_order_key()), $checkout_url);

    echo $complete_checkout_url;
    $prodsArr = array();
    $prods = "";
    $contador = 1;
    $countp = 0;
    foreach($orden->get_items() as $key => $item) {
        $countp += $item->get_quantity();
        $prodsArr[] = $contador.". ".$item->get_name()." - ".$item->get_quantity() ;
        $contador ++;
    }
    $prods = implode("\n", $prodsArr);
    $msg = str_replace("[order-products-names]", $prods, $msg);
    $msg = str_replace("[order-total-products]", $countp, $msg);
    $msg = str_replace("[order-billing-first-name]", $orden->get_billing_first_name(), $msg);
    $msg = str_replace("[order-billing-last-name]", $orden->get_billing_last_name(), $msg);
    $msg = str_replace("[order-billing-company]", $orden->get_billing_company(), $msg);
    $msg = str_replace("[order-billing-address-1]", $orden->get_billing_address_1(), $msg);
    $msg = str_replace("[order-billing-address-2]", $orden->get_billing_address_2(), $msg);
    $msg = str_replace("[order-billing-city]", $orden->get_billing_city(), $msg);
    $msg = str_replace("[order-billing-post-code]", $orden->get_billing_postcode(), $msg);
    $msg = str_replace("[order-billing-state]", $orden->get_billing_state(), $msg);
    $msg = str_replace("[order-billing-country]", $orden->get_billing_country(), $msg);
    $msg = str_replace("[order-billing-email]", $orden->get_billing_email(), $msg);
    $msg = str_replace("[order-billing-phone]", $orden->get_billing_phone(), $msg);
    $msg = str_replace("[order-billing-lat]", get_post_meta($order_id, "billing_lat", true), $msg);
    $msg = str_replace("[order-billing-long]", get_post_meta($order_id, "billing_long", true), $msg);
    $msg = str_replace("[order-shipping-first-name]", $orden->get_shipping_first_name(), $msg);
    $msg = str_replace("[order-shipping-last-name]", $orden->get_shipping_last_name(), $msg);
    $msg = str_replace("[order-shipping-company]", $orden->get_shipping_company(), $msg);
    $msg = str_replace("[order-shipping-address-1]", $orden->get_shipping_address_1(), $msg);
    $msg = str_replace("[order-shipping-address-2]", $orden->get_shipping_address_2(), $msg);
    $msg = str_replace("[order-shipping-city]", $orden->get_shipping_city(), $msg);
    $msg = str_replace("[order-shipping-post-code]", $orden->get_shipping_postcode(), $msg);
    $msg = str_replace("[order-shipping-state]", $orden->get_shipping_state(), $msg);
    $msg = str_replace("[order-shipping-country]", $orden->get_shipping_country(), $msg);
    $msg = str_replace("[order-shipping-lat]", get_post_meta($order_id, "shipping_lat", true), $msg);
    $msg = str_replace("[order-shipping-long]", get_post_meta($order_id, "shipping_long", true), $msg);
    $msg = str_replace("[order-shipping-phone]", get_post_meta($order_id, "shipping_phone", true), $msg);
    $msg = str_replace("[site-url]", get_site_url(), $msg);

    $msg = apply_filters("tera_notif_add_variables", $msg, $orden);
    return $msg;
}

function tera_notif_stats(){
    $stats = [
        "completed" => "Pedido Completado",
        "processing" => "Pedido Procesando",
        "on-hold" => "Pedido En Espera",
        "pending" => "Pedido Pendiente de pago",
        "cancelled" => "Pedido Cancelado",
        "refunded" => "Pedido Reembolsado",
        "failed" => "Pedido Fallido",
    ];

    if ( has_filter( 'tera_notif_order_statuses' ) ) {
        $stats = apply_filters( 'tera_notif_order_statuses', $stats );
    }

    return $stats;
}
