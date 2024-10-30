<?php
/**
 * Plugin Name:     Libre scrolling
 * Description:     Triggers when a anchor of a menu is clicked ; scrolls smoothly to its targeted element.
 * Author:          Romain GUILLAUME
 * Author URI:      www.blgg.fr
 * Text Domain:     libre-scrolling
 * Domain Path:     /languages
 * Version:         0.1.1
 *
 * @package         Libre_Scroll
 */

new plugin_libre_scroll();
class plugin_libre_scroll{	
	/**
	 * __construct enqueues the needed hooks and defines the class variable 'anchors' 
	 *
	 * @return void
	 */
	function __construct(){
		add_filter( 'wp_nav_menu_objects', array( $this, 'wp_nav_menu_objects' ), 10, 2 ); 
		$this->anchors;
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
		add_action( 'wp_footer', array( $this, 'wp_footer' ) );
		add_action( 'wp_head', array( $this, 'wp_head' ) );
	}
	function wp_head(){
		?>
        <style>
           html {
				scroll-padding: 150px;
            }
        </style>
    <?php
	}
	/**
	 * wp_enqueue_scripts
	 *
	 * @return void
	 */
	function wp_enqueue_scripts(){
		wp_register_script( 'libre-scrolling', plugins_url( 'js/libre-scrolling.js', __FILE__ ), array(), null, true );
	}	
	/**
	 * wp_nav_menu_objects hooks into each menu to find items urls starting with '#'
	 *
	 * @param  mixed $sorted_menu_items
	 * @param  mixed $args
	 * @return void
	 */
	function wp_nav_menu_objects( $sorted_menu_items, $args ){
		foreach( $sorted_menu_items as $item ){
			if( false !== strpos( $item->url, '#' ) ){
				$this->anchors []= substr( $item->url, strpos( $item->url, '#' ) + 1 );
				$item->classes []= 'libre-scrolling';
			}
		}
		return $sorted_menu_items; 
	}	
	/**
	 * wp_footer pass some anchors to the script 'libre-scrolling'
	 *
	 * @return void
	 */
	function wp_footer(){
		wp_localize_script( 'libre-scrolling', 'items', $this->anchors );
		wp_enqueue_script( 'libre-scrolling' );
	}
		
}