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
        add_action( 'admin_enqueue_scripts', array($this, 'employee_scripts') );
        add_action( 'admin_enqueue_scripts', array($this, 'employee_styles') );
        add_action( 'add_meta_boxes', array($this, 'employee_custom_meta_boxes') );
        // add_action( 'save_post', array($this, 'employee_metabox_data_save') );
    }

    public function employee_scripts()
    {
        wp_enqueue_script( 'jquery-ui-tabs');
        wp_enqueue_script('employee_script', PLUGINS_URL('js/custom.js', __FILE__), array('jquery', 'jquery-ui-tabs'));
    }
    public function employee_styles()
    {
        wp_enqueue_style('employee_custom_css', PLUGINS_URL('css/custom.css', __FILE__));
    }

    public function employee_default_setup()
    {
        $employeeListLabels = array(
            'name'                  => _x( 'Employees', 'Employee Menu Name', 'employee' ),
            'singular_name'         => _x( 'Employee', 'Employee Menu Singular name', 'employee' ),
            'menu_name'             => _x( 'Employees', 'Admin Menu text', 'employee' ),
            'name_admin_bar'        => _x( 'Employees', 'Add New on Toolbar', 'employee' ),
            'add_new'               => __( 'Add New', 'Employee' ),
            'add_new_item'          => __( 'Add New Employee', 'employee' ),
            'new_item'              => __( 'New Employee', 'employee' ),
            'edit_item'             => __( 'Edit Employee', 'employee' ),
            'view_item'             => __( 'View Employee', 'employee' ),
            'all_items'             => __( 'All Employee', 'employee' ),
            'search_items'          => __( 'Search Employees', 'employee' ),
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
        $employeeListArgs = array(
            'labels'             => $employeeListLabels,
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

        register_post_type( 'employee_list', $employeeListArgs );


        // register employee list texonomy
        $employeeTypeLabels = array(
            'name'              => _x( 'Employee Types', 'Employee Type Name', 'employee' ),
            'singular_name'     => _x( 'Employee Type', 'Employee Type singular name', 'employee' ),
            'search_items'      => __( 'Search Employee Types', 'employee' ),
            'all_items'         => __( 'All Employee Types', 'employee' ),
            'parent_item'       => __( 'Parent Employee Type', 'employee' ),
            'parent_item_colon' => __( 'Parent Employee Type:', 'employee' ),
            'edit_item'         => __( 'Edit Employee Type', 'employee' ),
            'update_item'       => __( 'Update Employee Type', 'employee' ),
            'add_new_item'      => __( 'Add New Employee Type', 'employee' ),
            'new_item_name'     => __( 'New Employee Type Name', 'employee' ),
            'menu_name'         => __( 'Employee Type', 'employee' ),
        );

        $employeTypeArgs = array(
            'hierarchical'      => true,
            'labels'            => $employeeTypeLabels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'employee_type' ),
        );

        register_taxonomy( 'employee_type', array( 'employee_list' ), $employeTypeArgs );

    }

    public function employee_custom_meta_boxes()
    {
        add_meta_box( 'employee_info', 'Employee Information', array($this, 'employee_information_callback'), 'employee_list', 'normal', 'high');
    }

    public function employee_information_callback()
        {
            ?>
                <div id="employee-info-tabs">
                    <ul>
                        <li><a href="#personal-info">Personal Information</a></li>
                        <li><a href="#official-info">Official Information</a></li>
                        <li><a href="#academic-info">Academic Information</a></li>
                        <li><a href="#experiance-info">Experiances</a></li>
                    </ul>
                    <div id="personal-info">
                        <!-- father name -->
                        <p><label for="father_name">Father's Name</label></p>
                        <p><input type="text" name="father_name" id="father_name" class="widefat"></p>

                        <!-- mother name -->
                        <p><label for="mother_name">Mother's Name</label></p>
                        <p><input type="text" name="mother_name" id="mother_name" class="widefat"></p>
                        
                        <!-- gender -->
                        <p>
                            <input type="radio" name="gender" id="male" value="male">
                            <label for="male">Male</label> <br>
                            
                            <input type="radio" name="gender" id="female" value="female">
                            <label for="female">Female</label>
                        </p>

                        <!-- age -->
                        <p><label for="employee_dob">Date of Birth</label></p>
                        <p><input type="date" name="employee_dob" id="employee_dob"></p>

                    </div>
                    <div id="official-info">
                        <!-- designation -->
                        <p><label for="designation">Designation</label></p>
                        <p><input type="text" name="designation" id="designation"></p>
                        <!-- join date -->
                        <p><label for="join_date">Joining Date</label></p>
                        <p><input type="date" name="join_date" id="join_date"></p>
                    </div>
                    <div id="academic-info">
                        <!-- one exam -->
                        <span>Exam One</span>
                        <p><label for="passing_year_one">Passing Year</label></p>
                        <p><input type="text" name="passing_year_one" id="passing_year_one"></p>
                        
                        <p><label for="exam_name_one">Exam Name</label></p>
                        <p><input type="text" name="exam_name_one" id="exam_name_one" class="widefat"></p>
                        
                        <hr>

                        <!-- two exam -->
                        <span>Exam Two</span>
                        <p><label for="passing_year_two">Passing Year</label></p>
                        <p><input type="text" name="passing_year_two" id="passing_year_two"></p>
                        
                        <p><label for="exam_name_two">Exam Name</label></p>
                        <p><input type="text" name="exam_name_two" id="exam_name_two" class="widefat"></p>

                    </div>
                    <div id="experiance-info">
                        <!-- skill -->
                        <p><label for="skill">Skill</label></p>
                        <p><input type="text" name="skill" id="skill"></p>
                    </div>
                </div>


            <?php
        }


}

$employee = new Employee();