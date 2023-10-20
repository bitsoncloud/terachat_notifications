<?php
/*
Plugin Name: Tera chat Notificaciones
Plugin URI: https://tera.chat
Description: Notificaciones de pedido de Tera Chat
Version: 1.0.1
Author: Bits On Cloud LLC
Author URI: https://bitsoncloud.com
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

defined('ABSPATH') or die("Bye bye");
define('TERA_NOTIF_RUTA',plugin_dir_path(__FILE__));
define('TERA_NOTIF_URL',plugins_url('terachat_notifications'));
define('TERA_NOTIF_NOMBRE','Tera chat Notificaciones');

add_filter('plugin_action_links_' . plugin_basename(__FILE__), "tera_notif_config_link", 10, 1);
add_action('admin_init', 'check_required_plugins');
function tera_notif_config_link($links){
    $plugin_links = array(
    	'<a href="' . admin_url('admin.php?page=teranotif-config&tab=conf') . '">Ajustes</a>',
	);
	// Fusionar nuestro nuevo enlace con los predeterminados
	return array_merge($plugin_links, $links);
}
include_once TERA_NOTIF_RUTA."/samdata.php";
include_once TERA_NOTIF_RUTA."/funciones.php";

add_action('admin_menu', 'tera_notif_menu');
function tera_notif_menu(){
    //include PV_RUTA."/img.php";
    add_menu_page(
        TERA_NOTIF_NOMBRE,
        TERA_NOTIF_NOMBRE,
        'read',
        'teranotif-config',
        'teranotif_config'
    );
}

function teranotif_config(){
    $default_tab = "default";
    $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab; 
    $tabs = [
        "default" => [
            "path" => TERA_NOTIF_RUTA."/html/templates.phtml",
            "name" => "Plantillas"
        ],
        "conf" => [
            "path" => TERA_NOTIF_RUTA."/html/conf.phtml",
            "name" => "Configuración"
        ]
    ];

    $str_tabs = "<div class='wrap'>
        <h1>".esc_html( get_admin_page_title())."</h1>
    <nav class='nav-tab-wrapper'>";
    foreach($tabs as $t => $data) $str_tabs .= "<a href='?page=teranotif-config".($t != "default" ? "&tab=$t" : "")."' class='nav-tab ".(($tab===$t) ? 'nav-tab-active' : "")."'>".$data["name"]."</a>";
    $str_tabs .= "</nav>
    <div class='tab-content'>";
    echo $str_tabs;

    foreach($tabs as $t => $data) if($tab == $t) include_once $data["path"];
    $str_tabs = "</div>
    </div>";

    echo $str_tabs;
}

register_activation_hook( __FILE__, 'start_tera_notif_config' );

function check_required_plugins() {
    $required_plugins = array(
        'woocommerce/woocommerce.php', 
        'woo-phone-validator/wc-pv.php', 
    );

    foreach ($required_plugins as $plugin) {
        if (!is_plugin_active($plugin)) {
            deactivate_plugins(plugin_basename(__FILE__));
            wp_die('Para activar este plugin, necesitas tener activo el Plugin Requerido: ' . $plugin);
        }
    }
}


//eval




