<?php 
/*
Plugin Name: Standard Employee List 
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
        add_action( 'admin_enqueue_scripts', array($this, 'employee_backend_scripts') );
        add_action( 'admin_enqueue_scripts', array($this, 'employee_backend_styles') );
        add_action( 'wp_enqueue_scripts', array($this, 'employee_front_styles') );
        add_action( 'wp_enqueue_scripts', array($this, 'employee_front_scripts') );
        add_action( 'add_meta_boxes', array($this, 'employee_custom_meta_boxes') );
        add_action( 'save_post', array($this, 'employee_metabox_data_save') );
        add_shortcode( 'employee-list', array($this, 'employee_list_retrive') );
		add_action( 'vc_before_init', array($this, 'visual_composer_support') );
    }

    public function employee_backend_scripts()
    {
        wp_enqueue_script( 'jquery-ui-tabs');
        wp_enqueue_script('employee_backend_script', PLUGINS_URL('js/backend.js', __FILE__), array('jquery', 'jquery-ui-tabs'));
    }

    public function employee_backend_styles()
    {
        wp_enqueue_style('employee_backend_css', PLUGINS_URL('css/backend.css', __FILE__), array(), '1.0', 'all');
    }

    public function employee_front_styles()
    {
        wp_enqueue_style('employee_front_css', PLUGINS_URL('css/front.css', __FILE__), array(), '1.0', 'all');
    }
    public function employee_front_scripts()
    {
        wp_enqueue_script('employee_front_js', PLUGINS_URL('js/front.js', __FILE__), array('jquery'), '1.0', false);
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
        $father = get_post_meta(get_the_ID(), 'emploee_father', true );
        $mother = get_post_meta(get_the_ID(), 'emploee_mother', true);
        $gender = get_post_meta(get_the_ID(), 'emploee_gender', true);
        $dob = get_post_meta(get_the_ID(), 'emploee_dob', true);
        $phone = get_post_meta(get_the_ID(), 'emploee_phone', true);
        $designation = get_post_meta(get_the_ID(), 'emploee_designation', true);
        $join_date = get_post_meta(get_the_ID(), 'emploee_join_date', true);
        $passing_year_one = get_post_meta(get_the_ID(), 'emploee_passing_year_one', true);
        $exam_name_one = get_post_meta(get_the_ID(), 'emploee_exam_name_one', true);
        $passing_year_two = get_post_meta(get_the_ID(), 'emploee_passing_year_two', true);
        $exam_name_two = get_post_meta(get_the_ID(), 'emploee_exam_name_two', true);
        $skills = get_post_meta(get_the_ID(), 'emploee_skills', true);
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
                        <p><input type="text" value="<?php echo $father; ?>" name="father_name" id="father_name" class="widefat"></p>

                        <!-- mother name -->
                        <p><label for="mother_name">Mother's Name</label></p>
                        <p><input type="text" value="<?php echo $mother; ?>" name="mother_name" id="mother_name" class="widefat"></p>
                        
                        <!-- gender -->
                        <p>
                            <input type="radio" name="gender" id="male" value="male" <?php if($gender == 'male') { echo "checked";  } ?>>
                            <label for="male">Male</label> <br>
                            
                            <input type="radio" name="gender" id="female" value="female" <?php if($gender == 'female') { echo "checked";  } ?>>
                            <label for="female">Female</label>
                        </p>

                        <!-- age -->
                        <p><label for="dob">Date of Birth</label></p>
                        <p><input type="date" value="<?php echo $dob; ?>" name="dob" id="dob"></p>

                        <!-- phone -->
                        <p><label for="phone">Phone Number</label></p>
                        <p><input type="text" value="<?php echo $phone; ?>" name="phone" id="phone"></p>

                    </div>
                    <div id="official-info">
                        <!-- designation -->
                        <p><label for="designation">Designation</label></p>
                        <p><input type="text" value="<?php echo $designation; ?>" name="designation" id="designation"></p>
                        <!-- join date -->
                        <p><label for="join_date">Joining Date</label></p>
                        <p><input type="date" value="<?php echo $join_date; ?>" name="join_date" id="join_date"></p>
                    </div>
                    <div id="academic-info">
                        <!-- one exam -->
                        <span>Exam One</span>
                        <p><label for="passing_year_one">Passing Year</label></p>
                        <p><input type="text" value="<?php echo $passing_year_one; ?>" name="passing_year_one" id="passing_year_one"></p>
                        
                        <p><label for="exam_name_one">Exam Name</label></p>
                        <p><input type="text" value="<?php echo $exam_name_one; ?>" name="exam_name_one" id="exam_name_one" class="widefat"></p>
                        
                        <hr>

                        <!-- two exam -->
                        <span>Exam Two</span>
                        <p><label for="passing_year_two">Passing Year</label></p>
                        <p><input type="text" value="<?php echo $passing_year_two; ?>" name="passing_year_two" id="passing_year_two"></p>
                        
                        <p><label for="exam_name_two">Exam Name</label></p>
                        <p><input type="text" value="<?php echo $exam_name_two; ?>" name="exam_name_two" id="exam_name_two" class="widefat"></p>

                    </div>
                    <div id="experiance-info">
                        <!-- skills -->
                        <p><label for="skills">Skills</label></p>
                        <p><input type="text" value="<?php echo $skills; ?>" name="skills" id="skills"></p>
                    </div>
                </div>


            <?php
    }

    public function employee_metabox_data_save()
    {
        $father = $_POST['father_name'] ?? null;
        $mother = $_POST['mother_name'] ?? null;
        $gender = $_POST['gender'] ?? null;
        $dob = $_POST['dob'] ?? null;
        $phone = $_POST['phone'] ?? null;
        $designation = $_POST['designation'] ?? null;
        $join_date = $_POST['join_date'] ?? null;
        $passing_year_one = $_POST['passing_year_one'] ?? null;
        $exam_name_one = $_POST['exam_name_one'] ?? null;
        $passing_year_two = $_POST['passing_year_two'] ?? null;
        $exam_name_two = $_POST['exam_name_two'] ?? null;
        $skills = $_POST['skills'] ?? null;

        update_post_meta(get_the_ID(), 'emploee_father', $father);
        update_post_meta(get_the_ID(), 'emploee_mother', $mother);
        update_post_meta(get_the_ID(), 'emploee_gender', $gender);
        update_post_meta(get_the_ID(), 'emploee_dob', $dob);
        update_post_meta(get_the_ID(), 'emploee_phone', $phone);
        update_post_meta(get_the_ID(), 'emploee_designation', $designation);
        update_post_meta(get_the_ID(), 'emploee_join_date', $join_date);
        update_post_meta(get_the_ID(), 'emploee_passing_year_one', $passing_year_one);
        update_post_meta(get_the_ID(), 'emploee_exam_name_one', $exam_name_one);
        update_post_meta(get_the_ID(), 'emploee_passing_year_two', $passing_year_two);
        update_post_meta(get_the_ID(), 'emploee_exam_name_two', $exam_name_two);
        update_post_meta(get_the_ID(), 'emploee_skills', $skills);

    }

    public function employee_list_retrive($attr, $content)
    {

        $atts = shortcode_atts( array(
            'count' => -1
        ), $attr);

        extract($atts);
        
        ob_start();
        ?>
        <div class="alignfull">
            <div class="employee_list">
                <?php
                    $employee = new WP_Query(array(
                        'post_type'     => 'employee_list',
                        'posts_per_page' =>  $count,
                        'paged' => max( 1, get_query_var('paged') )
                    ));
                    while($employee->have_posts()) : $employee->the_post();
                ?>
                <div class="card-container">           
                    <span class="pro">
                        <?php  
                            $terms = get_the_terms( get_the_id(), 'employee_type' );
                            $count = count($terms);
                            foreach ($terms as $key => $type) {
                                echo  $type->name;
                                echo  $count == 2 && $key == 0 ? ' | ' : ' ' ;
                            }
                        ?>
                    </span>
                    <div class="profile-image">
                        <?php the_post_thumbnail(); ?>
                    </div>
                    <h3><?php the_title(); ?></h3>
                    <h6><?php echo get_post_meta( get_the_ID(), 'emploee_designation', true ) ?></h6>
                    
                    <div class="skills">
                        <ul>
                            <?php 
                            $skills = get_post_meta( get_the_ID(), 'emploee_skills', true );
                            $slillsArg = explode(',', $skills); 
                            foreach ($slillsArg as $skill) :?>
                                <li><?php echo $skill; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <p><?php the_content(); ?></p>
                    <div class="info" id="info-<?php echo get_the_ID(); ?>" >
                        <button class="toggle-button" data-id="<?php echo get_the_ID(); ?>">
                            &#11167;
                        </button>
                        
                        <table border="1">
                            <tr>
                                <td>Father's Name:</td>
                                <td><?php echo get_post_meta( get_the_ID(), 'emploee_father', true ) ?></td>
                            </tr>
                            <tr>
                                <td>Mother's Name:</td>
                                <td><?php echo get_post_meta( get_the_ID(), 'emploee_mother', true ) ?></td>
                            </tr>
                            <tr>
                                <td>Date of Birth:</td>
                                <td><?php echo get_post_meta( get_the_ID(), 'emploee_dob', true ) ?></td>
                            </tr>
                            <tr>
                                <td>Gender:</td>
                                <td><?php echo get_post_meta( get_the_ID(), 'emploee_gender', true ) ?></td>
                            </tr>
                            <tr>
                                <td>Contact:</td>
                                <td><?php echo get_post_meta( get_the_ID(), 'emploee_phone', true ) ?></td>
                            </tr>
                            <tr>
                                <td>Join:</td>
                                <td>
                                    <?php 
                                    $date = get_post_meta( get_the_ID(), 'emploee_join_date', true );
                                    echo $date; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php endwhile; ?>


            </div>
            <div class="pagination">
                <div class="item">
                    <?php
                        
                        echo paginate_links( array(
                            'current' => max( 1, get_query_var('paged') ),
                            'total' => $employee->max_num_pages,
                            'prev_text' => 'Previous',
                            'next_text' => 'Next',
                            'show_all' => true,
                            'prev_next ' => true,
                        ) );
                    
                    ?>
                </div>
            </div>
        </div>

        <?php return ob_get_clean();
    }

    public function visual_composer_support(){
		if(function_exists('vc_map')){
			vc_map(array(
				'name' => 'Employee List',
				'base' => 'employee-list',
				'id' => 'employee-list',
                'category' => 'Content',
                'description' => 'Easy Employee manage',
                'icon' => PLUGINS_URL('icon/list.png', __FILE__),
				'params' => array(
					array(
						'heading' => 'How Many Employee to show',
						'param_name' => 'count',
						'type' => 'textfield',
					)
				)
			));
		}
	}

}

$employee = new Employee();
$employee->visual_composer_support();