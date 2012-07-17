<?php
/*
Plugin Name: Posts Date Ranges
Plugin URI: http://www.deshpradesh.com/posts-date-ranges
Description: This Plugin Will Add Options in admin posts lists page to pick up start-date and end-date ranges to filter posts in your wordpress admin. It will give you instant filter options without any type of configuration just install it and use it.
Author: Jaytesh Barange
Version: 1.0
Author URI: http://www.deshpradesh.com/jaytesh
*/

function wp_pdr_admin_filters($query) {
	global $pagenow;
	if( $query->is_admin && ( 'edit.php' == $pagenow ) ) { 
		if(isset($_REQUEST['start_date'])||isset($_REQUEST['end_date']))
		{
		$filter=false;
		add_filter( 'posts_where', 'pdr_filter_where_custom' );
		}
	}
	return $query;
}
function pdr_filter_where_custom( $where = '' ) {
	global $wpdb;
	if(isset($_REQUEST['start_date'])&&!empty($_REQUEST['start_date']))
	{
	$start_date=$_REQUEST['start_date'];
	$where .= " AND post_date >='$start_date' ";
	}
	if(isset($_REQUEST['end_date'])&&!empty($_REQUEST['end_date']))
	{
	$end_date=$_REQUEST['end_date'];
	 $where .=" AND post_date <='$end_date' ";
	}
	return $where;
}
// Jaytesh Barange loves to code
function wp_pdr_admin_filters_dropdowns() {
	global $wpdb;
if(isset($_REQUEST['start_date'])&&isset($_REQUEST['end_date']))
		{
		$start_date=$_REQUEST['start_date'];
	$end_date=$_REQUEST['end_date'];
	}
	?>
	<?php _e('Start Date');?>: <input type="text" name="start_date" class="datepick" value="<?php echo $start_date;?>" /> <?php _e('End Date');?>: <input type="text" name="end_date" class="datepick" value="<?php echo $end_date;?>" />
	<link rel="stylesheet" media="screen" type="text/css" href="<?php echo plugins_url('js/css/zebra_datepicker.css',__FILE__ );?>" />
	<script type="text/javascript" src="<?php echo plugins_url('js/zebra_datepicker.js',__FILE__ );?>"></script>
	<script type="text/javascript">
	jQuery(document).ready(function(){
	jQuery('.datepick').Zebra_DatePicker({readonly_element:false});
	});
	</script>
	<?php
	return;
}

// Jaytesh Barange loves to code
add_filter('pre_get_posts', 'wp_pdr_admin_filters');
add_action('restrict_manage_posts', 'wp_pdr_admin_filters_dropdowns',2);

