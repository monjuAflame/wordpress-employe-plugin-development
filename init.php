<?php 
/*
Plugin Name: Employee List Slider
Plugin URI: 
Author: Ismail Hossain
Author URI: http://ismailhossaindev.com
Version: 1.0
Description: More Easiest to Use Employe List plugin
*/

class Employee {

    public function __construct()
    {
        add_action( 'init', array($this, 'employee_default_setup') );
    }

    public function employee_default_setup()
    {
        $labels = array(
            'name'                  => _x( 'Employee', 'Employee Menu Name', 'employee' ),
            'singular_name'         => _x( 'Employee', 'Employee Menu Singular name', 'employee' ),
            'menu_name'             => _x( 'Employee', 'Admin Menu text', 'employee' ),
            'name_admin_bar'        => _x( 'Employee', 'Add New on Toolbar', 'employee' ),
            'add_new'               => __( 'Add New', 'Employee' ),
            'add_new_item'          => __( 'Add New Employee', 'employee' ),
            'new_item'              => __( 'New Employee', 'employee' ),
            'edit_item'             => __( 'Edit Employee', 'employee' ),
            'view_item'             => __( 'View Employee', 'employee' ),
            'all_items'             => __( 'All Employee', 'employee' ),
            'search_items'          => __( 'Search Employee', 'employee' ),
            'parent_item_colon'     => __( 'Parent Employee:', 'employee' ),
            'not_found'             => __( 'No Employee found.', 'employee' ),
            'not_found_in_trash'    => __( 'No Employee found in Trash.', 'employee' ),
            'featured_image'        => _x( 'Employee Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'employee' ),
            'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'employee' ),
            'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'employee' ),
            'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'employee' ),
            'archives'              => _x( 'Employee archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'employee' ),
            'insert_into_item'      => _x( 'Insert into Employee', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'employee' ),
            'uploaded_to_this_item' => _x( 'Uploaded to this Employee', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'employee' ),
            'filter_items_list'     => _x( 'Filter Employee list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'employee' ),
            'items_list_navigation' => _x( 'Employee list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'employee' ),
            'items_list'            => _x( 'Employee list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'employee' ),
        );     
        $args = array(
            'labels'             => $labels,
            'description'        => 'Employee List custom post type.',
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'employee' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 20,
            'menu_icon'               => 'dashicons-groups',
            'supports'           => array( 'title', 'editor', 'thumbnail' ),
            'show_in_rest'       => true
        );
        
        register_post_type( 'employee_list', $args );
    }

}

$employee = new Employee();