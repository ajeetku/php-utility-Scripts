<?php
/*
Plugin Name: Show specific Post type Widget
Plugin URI: 
Description: Show Post Widget grabs a post type and the associated thumbnail to display on your sidebar
Author: Ajeet kumar
Version: 1
Author URI: 
*/


class RandomPostWidget extends WP_Widget
{
  function RandomPostWidget()
  {
    $widget_ops = array('classname' => 'RandomPostWidget', 'description' => 'Displays a post type with thumbnail' );
    $this->WP_Widget('RandomPostWidget', 'Specific Post and Thumbnail', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'posttypes' => '') );
    $title = $instance['title'];
    $posttypes = $instance['posttypes'];
	$allPosts = get_post_types();
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
  <p>
	<label for="<?php echo $this->get_field_id('posttypes'); ?>">All post types</label>
	<select id="<?php echo $this->get_field_id('posttypes'); ?>" name="<?php echo $this->get_field_name('posttypes'); ?>" class="widefat">
		<option value="">Select Post type</option>
		<?php foreach($allPosts as $key=>$post){
			$sel="";
			if($key==attribute_escape($posttypes)){
				$sel = "selected";
			}
			echo "<option value='$key' $sel>$post</option>";
		} ?>
	</select>
  </p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['posttypes'] = $new_instance['posttypes'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    $posttypes = empty($instance['posttypes']) ? ' ' :  $instance['posttypes'];
 
    if (!empty($title))
      echo $before_title .'<h2 style="border-bottom: 1px solid #ccc">'.$title.'</h2>'. $after_title;;
 
    // WIDGET CODE GOES HERE
    query_posts('post_type='.$posttypes.'&orderby=data&order=ASC');
		if (have_posts()) : 
			echo "<ul>";
			while (have_posts()) : the_post(); 
				echo "<li><a href='".get_permalink()."'>".get_the_title()."</a></li>";
				//echo the_post_thumbnail(array(220,200));
				//echo "";	
					
			endwhile;
			echo "</ul>";
		endif; 
		wp_reset_query();
	
 
    echo $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("RandomPostWidget");') );?>