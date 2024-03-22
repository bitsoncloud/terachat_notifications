<?php
function start_tera_notif_config(){
    $completed = get_option("tera_notif_order_completed");
    $processing = get_option("tera_notif_order_processing");
    $pending = get_option("tera_notif_order_pending");
    $cancelled = get_option("tera_notif_order_cancelled");
    $refunded = get_option("tera_notif_order_refunded");
    $failed = get_option("tera_notif_order_failed");
    $on_hold = get_option("tera_notif_order_on-hold");

    if($completed == ""){
        $msg = "👋 Hola [order-billing-first-name] [order-billing-last-name]! 

        🔔 *Notificación de Pedido*
        _Pedido Completado_
        
        📅 Fecha: [order-date]
        🛍️ Artículos: [order-total-products]
        🚦 Estado: *[order-status]*
        
        🏢 Empresa: [order-billing-company]
        📞 Teléfono: [order-billing-phone]
        📧 Correo: [order-billing-email]
        
        🛍️ _Resumen del Pedido_
        [order-products-names]
        
        💵 Subtotal: [order-subtotal]
        🎁 Cupón: [order-discount]
        
        🚛 Envío: [order-shipping-method] 
        Costo Envío: [order-shipping-cost]
        
        🎫 Impuestos: [order-tax]
        💵 Total: *[order-total]* 
        
        
        🗺️ País: [order-billing-country] 📍 Estado: [order-billing-state] 🏙️ Ciudad: [order-billing-country]
        🏠 Dirección: [order-shipping-address-1] [order-shipping-address-2]
        📫 Código Postal: [order-billing-post-code]
        
        📝 Notas del cliente: [order-customer-note]
        
        ✅ Detalles del pedido: [order-view-url]";
        update_option("tera_notif_order_completed", $msg);
    }

    if($processing == ""){
        $msg = "👋 Hola [order-billing-first-name] [order-billing-last-name]! 

        🔔 *Notificación de Pedido*
        _Pedido Procesando_
        
        📅 Fecha: [order-date]
        🛍️ Artículos: [order-total-products]
        🚦 Estado: *[order-status]*
        
        🏢 Empresa: [order-billing-company]
        📞 Teléfono: [order-billing-phone]
        📧 Correo: [order-billing-email]
        
        🛍️ _Resumen del Pedido_
        [order-products-names]
        
        💵 Subtotal: [order-subtotal]
        🎁 Cupón: [order-discount]
        
        🚛 Envío: [order-shipping-method] 
        Costo Envío: [order-shipping-cost]
        
        🎫 Impuestos: [order-tax]
        💵 Total: *[order-total]* 
        
        
        🗺️ País: [order-billing-country] 📍 Estado: [order-billing-state] 🏙️ Ciudad: [order-billing-country]
        🏠 Dirección: [order-shipping-address-1] [order-shipping-address-2]
        📫 Código Postal: [order-billing-post-code]
        
        📝 Notas del cliente: [order-customer-note]
        
        ✅ Detalles del pedido: [order-view-url]";
        update_option("tera_notif_order_processing", $msg);
    }

    if($pending == ""){
        $msg = "👋 Hola [order-billing-first-name] [order-billing-last-name]! 

        🔔 *Notificación de Pedido*
        _Pedido Pendiente de pago_
        
        📅 Fecha: [order-date]
        🛍️ Artículos: [order-total-products]
        🚦 Estado: [order-status]
        
        🏢 Empresa: [order-billing-company]
        📞 Teléfono: [order-billing-phone]
        📧 Correo: [order-billing-email]
        
        🛍️ _Resumen del Pedido_
        [order-products-names]
        
        💵 Subtotal: [order-subtotal]
        🎁 Cupón: [order-discount]
        
        🚛 Envío: [order-shipping-method] 
        Costo Envío: [order-shipping-cost]
        
        🎫 Impuestos: [order-tax]
        💵 Total: *[order-total]* 
        
        
        🗺️ País: [order-billing-country] 📍 Estado: [order-billing-state] 🏙️ Ciudad: [order-billing-country]
        🏠 Dirección: [order-shipping-address-1] [order-shipping-address-2]
        📫 Código Postal: [order-billing-post-code]
        
        📝 Notas del cliente: [order-customer-note]
        
        ❎ Detalles del pedido: [order-view-url]";
        update_option("tera_notif_order_pending", $msg);
    }

    if($cancelled == ""){
        $msg = "👋 Hola [order-billing-first-name] [order-billing-last-name]! 

        🔔 *Notificación de Pedido*
        _Pedido Cancelado_
        
        📅 Fecha: [order-date]
        🛍️ Artículos: [order-total-products]
        🚦 Estado: *[order-status]*
        
        🏢 Empresa: [order-billing-company]
        📞 Teléfono: [order-billing-phone]
        📧 Correo: [order-billing-email]
        
        🛍️ _Resumen del Pedido_
        [order-products-names]
        
        💵 Subtotal: [order-subtotal]
        🎁 Cupón: [order-discount]
        
        🚛 Envío: [order-shipping-method] 
        Costo Envío: [order-shipping-cost]
        
        🎫 Impuestos: [order-tax]
        💵 Total: *[order-total]* 
        
        
        🗺️ País: [order-billing-country] 📍 Estado: [order-billing-state] 🏙️ Ciudad: [order-billing-country]
        🏠 Dirección: [order-shipping-address-1] [order-shipping-address-2]
        📫 Código Postal: [order-billing-post-code]
        
        📝 Notas del cliente: [order-customer-note]
        
        ❌ Detalles del pedido: [order-view-url]";
        update_option("tera_notif_order_cancelled", $msg);
    }

    if($refunded == ""){
        $msg = "👋 Hola [order-billing-first-name] [order-billing-last-name]! 

        🔔 *Notificación de Pedido*
        _Pedido Reembolsado_
        
        📅 Fecha: [order-date]
        🛍️ Artículos: [order-total-products]
        🚦 Estado: *[order-status]*
        
        🏢 Empresa: [order-billing-company]
        📞 Teléfono: [order-billing-phone]
        📧 Correo: [order-billing-email]
        
        🛍️ _Resumen del Pedido_
        [order-products-names]
        
        💵 Subtotal: [order-subtotal]
        🎁 Cupón: [order-discount]
        
        🚛 Envío: [order-shipping-method] 
        Costo Envío: [order-shipping-cost]
        
        🎫 Impuestos: [order-tax]
        💵 Total: *[order-total]* 
        
        
        🗺️ País: [order-billing-country] 📍 Estado: [order-billing-state] 🏙️ Ciudad: [order-billing-country]
        🏠 Dirección: [order-shipping-address-1] [order-shipping-address-2]
        📫 Código Postal: [order-billing-post-code]
        
        📝 Notas del cliente: [order-customer-note]
        
        ⭕ Detalles del pedido: [order-view-url]";
        update_option("tera_notif_order_refunded", $msg);
    }

    if($failed == ""){
        $msg = "👋 Hola [order-billing-first-name] [order-billing-last-name]! 

        🔔 *Notificación de Pedido*
        _Pedido Fallido_
        
        📅 Fecha: [order-date]
        🛍️ Artículos: [order-total-products]
        🚦 Estado: *[order-status]*
        
        🏢 Empresa: [order-billing-company]
        📞 Teléfono: [order-billing-phone]
        📧 Correo: [order-billing-email]
        
        🛍️ _Resumen del Pedido_
        [order-products-names]
        
        💵 Subtotal: [order-subtotal]
        🎁 Cupón: [order-discount]
        
        🚛 Envío: [order-shipping-method] 
        Costo Envío: [order-shipping-cost]
        
        🎫 Impuestos: [order-tax]
        💵 Total: *[order-total]* 
        
        
        🗺️ País: [order-billing-country] 📍 Estado: [order-billing-state] 🏙️ Ciudad: [order-billing-country]
        🏠 Dirección: [order-shipping-address-1] [order-shipping-address-2]
        📫 Código Postal: [order-billing-post-code]
        
        📝 Notas del cliente: [order-customer-note]
        
        ‼️ Detalles del pedido: [order-view-url] ";
        update_option("tera_notif_order_failed", $msg);
    }

    if($on_hold == ""){
        $msg = "👋 Hola [order-billing-first-name] [order-billing-last-name]! 

        🔔 *Notificación de Pedido*
        _Pedido En Espera_
        
        📅 Fecha: [order-date]
        🛍️ Artículos: [order-total-products]
        🚦 Estado: *[order-status]*
        
        🏢 Empresa: [order-billing-company]
        📞 Teléfono: [order-billing-phone]
        📧 Correo: [order-billing-email]
        
        🛍️ _Resumen del Pedido_
        [order-products-names]
        
        💵 Subtotal: [order-subtotal]
        🎁 Cupón: [order-discount]
        
        🚛 Envío: [order-shipping-method] 
        Costo Envío: [order-shipping-cost]
        
        🎫 Impuestos: [order-tax]
        💵 Total: *[order-total]* 
        
        
        🗺️ País: [order-billing-country] 📍 Estado: [order-billing-state] 🏙️ Ciudad: [order-billing-country]
        🏠 Dirección: [order-shipping-address-1] [order-shipping-address-2]
        📫 Código Postal: [order-billing-post-code]
        
        📝 Notas del cliente: [order-customer-note]
        
        ‼️ Detalles del pedido: [order-view-url] ";
        update_option("tera_notif_order_on-hold", $msg);
    }
}

function save_tera_token(){
    if(isset($_POST["tera_token"])){
        update_option("tera_notif_token", $_POST["tera_token"]);
        $resp = tera_api("");
        if($resp->code == 200) echo "ok";
        else{
            echo "no";
            delete_option("tera_notif_token");
        }
    }else{
        echo "no";
        delete_option("tera_notif_token");
    }
    die();
}
add_action("wp_ajax_save_tera_token", "save_tera_token");

function getNotifInstance(){
    return tera_api("");
}