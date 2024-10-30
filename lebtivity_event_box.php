<?php
	/*
	Plugin Name: Lebtivity Event Box
	Plugin URI: http://lebtivity.com/
	Description: Lebtivity's Event Box
	Author: Lebtivity
	Version: 1.0
	Author URI: http://lebtivity.com/
	*/


	class LebtivityWidget extends WP_Widget {
		
		function __construct() {
			parent::__construct(
				'lebtivity-widget', //ID name
				'Lebtivity Event Box',//Widget name
				array(//extra args
					'classname' => 'lebtivity', 
					'description' => 'Display Lebtivity\'s events on your website.' 
				)
			);
		}

		function form($instance) {

			$defaults = array( 
				'title' => 'Events in Lebanon',
				'width' => '',
				'auto_width' => 'on',
				'height' => '350',
				'theme' => '',
				'category' => '',
				'default_date' => '',
				'disable_date' => false,
				'remove_signature' => false,
				'remove_border' => false
			);
			
			
			$categories = array(
				'' => 'All Categories',
				'3' => 'Arts &amp; Culture',
				'8' => 'Conferences &amp; Workshops',
				'1' => 'Exhibitions',
				'5' => 'Family &amp; Kids',
				'6' => 'Food &amp; Drinks',
				'4' => 'Music',
				'7' => 'Nightlife',
				'2' => 'Sports &amp; Outdoor',
				'9' => 'Other'
			);
				
			$instance = wp_parse_args((array) $instance, $defaults);
			?>
			
			<!-- Title -->
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
				<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%; box-sizing: border-box;" />
			</p>

			<!-- Auto width: Checkbox -->
			<p>
				<input type="hidden" name="<?php echo $this->get_field_name('auto_width'); ?>" value="" /> 
				<input class="checkbox" type="checkbox" <?php checked($instance['auto_width'], 'on'); ?> id="<?php echo $this->get_field_id('auto_width'); ?>" name="<?php echo $this->get_field_name('auto_width'); ?>" /> 
				<label for="<?php echo $this->get_field_id('auto_width'); ?>">Auto width</label>
			</p>
			
			<!-- Width -->
			<p>
				<label for="<?php echo $this->get_field_id('width'); ?>">Width:</label>
				<input id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo $instance['width']; ?>" style="width:100%; box-sizing: border-box;" />
			</p>
			
			<!-- Height -->
			<p>
				<label for="<?php echo $this->get_field_id('height'); ?>">Height:</label>
				<input id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" value="<?php echo $instance['height']; ?>" style="width:100%; box-sizing: border-box;" />
			</p>

			<!-- Theme: Select Box -->
			<p>
				<label for="<?php echo $this->get_field_id('theme'); ?>">Theme:</label> 
				<select id="<?php echo $this->get_field_id('theme'); ?>" name="<?php echo $this->get_field_name('theme'); ?>" class="widefat" style="width:100%;">
					<option <?php if ($instance['theme'] == '') echo 'selected="selected"'; ?> value="">Default</option>
					<option <?php if ($instance['theme'] == 'grey') echo 'selected="selected"'; ?> value="grey">Grey</option>
				</select>
			</p>

			<!-- Category: Select Box -->
			<p>
				<label for="<?php echo $this->get_field_id('category'); ?>">Category:</label> 
				<select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" class="widefat" style="width:100%;">
					<?php foreach ($categories as $key => $category):?>
						<option <?php if ($instance['category'] == $key) echo 'selected="selected"'; ?> value="<?php echo $key; ?>"><?php echo $category; ?></option>
					<?php endforeach;?>
				</select>
			</p>
			
			<!-- Default Date: Select Box -->
			<p>
				<label for="<?php echo $this->get_field_id('default_date'); ?>">Default Date:</label> 
				<select id="<?php echo $this->get_field_id('default_date'); ?>" name="<?php echo $this->get_field_name('default_date'); ?>" class="widefat" style="width:100%;">
					<option <?php if ($instance['default_date'] == '') echo 'selected="selected"'; ?> value="">Current Month</option>
					<option <?php if ($instance['default_date'] == 'day') echo 'selected="selected"'; ?> value="day">Current Day</option>
				</select>
			</p>

			<!-- Disable date change: Checkbox -->
			<p>
				<input type="hidden" name="<?php echo $this->get_field_name('disable_date'); ?>" value="" /> 
				<input class="checkbox" type="checkbox" <?php checked($instance['disable_date'], 'on'); ?> id="<?php echo $this->get_field_id('disable_date'); ?>" name="<?php echo $this->get_field_name('disable_date'); ?>" /> 
				<label for="<?php echo $this->get_field_id('disable_date'); ?>">Disable date change</label>
			</p>
			
			<!-- Remove border: Checkbox -->
			<p>
				<input type="hidden" name="<?php echo $this->get_field_name('remove_border'); ?>" value="" /> 
				<input class="checkbox" type="checkbox" <?php checked($instance['remove_border'], 'on'); ?> id="<?php echo $this->get_field_id('remove_border'); ?>" name="<?php echo $this->get_field_name('remove_border'); ?>" /> 
				<label for="<?php echo $this->get_field_id('remove_border'); ?>">Remove widget border</label>
			</p>
			
			<!-- Remove signature: Checkbox -->
			<p>
				<input type="hidden" name="<?php echo $this->get_field_name('remove_signature'); ?>" value="" /> 
				<input class="checkbox" type="checkbox" <?php checked($instance['remove_signature'], 'on'); ?> id="<?php echo $this->get_field_id('remove_signature'); ?>" name="<?php echo $this->get_field_name('remove_signature'); ?>" /> 
				<label for="<?php echo $this->get_field_id('remove_signature'); ?>">Remove Lebtivity Logo (We'd appreciate if you keep it)</label>
			</p>
			
			<script>
				(function(){
					var checkbox = document.getElementById('<?php echo $this->get_field_id('auto_width'); ?>'),
						width = document.getElementById('<?php echo $this->get_field_id('width'); ?>');
					if (checkbox) {
						checkbox.addEventListener('change', toggleWidth);
					}
					function toggleWidth () {
						if (checkbox.checked) {
							width.disabled = 'disabled';
						} else {
							width.disabled = '';
						}
					}
					toggleWidth();
				}());
			</script>
				
		<?php
		}

		function update($new_instance, $old_instance) {
			$instance = wp_parse_args((array) $new_instance, (array) $old_instance);
			foreach ($instance as $key => $val) {
				$instance[$key] = htmlentities($val);
			}
			
			if (!is_numeric($instance['width'])) {
				$instance['width'] = '';
				$instance['auto_width'] = 'on';
			} else {
				$instance['width'] = min(400, $instance['width']);
				$instance['width'] = max(150, $instance['width']);
			}
			if (!is_numeric($instance['height'])) {
				$instance['height'] = $old_instance['height'];
			} else {
				$instance['height'] = min(600, $instance['height']);
				$instance['height'] = max(200, $instance['height']);
			}
			return $instance;
		}

		function widget($args, $instance) {
			extract($args);

			echo $before_widget;
			
			$width = $instance['width'];
			if ($instance['auto_width'] == 'on') {
				$width = 'auto';
			}
			$height = $instance['height'];
			
			$title = $instance['title'];
			
			$category = $instance['category'];
			
			$theme = '';
			if ($instance['theme'] == 'grey') {
				$theme = $instance['theme'];
			}
			
			$default_date = 'month';
			if ($instance['default_date'] == 'day') {
				$default_date = $instance['default_date'];
			}
			
			$disable_date = '0';
			if ($instance['disable_date'] == 'on') {
				$disable_date = '1';
			}
			
			$remove_signature = '0';
			if ($instance['remove_signature'] == 'on') {
				$remove_signature = '1';
			}
			
			$remove_border = '0';
			if ($instance['remove_border'] == 'on') {
				$remove_border = '1';
			}
			
			echo '<div class="lebtivity-wgt" data-wp="1" data-width="' . $width . '" data-height="' . $height . '" data-theme="' . $theme . '" data-category="' . $category . '" data-default_date="' . $default_date . '" data-remove_signature="' . $remove_signature . '" data-disable_date="' . $disable_date . '" data-title="' . $title . '" data-remove_border="' . $remove_border . '"></div>';
			echo '<script>(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//www.lebtivity.com/js/widget/ext/wgt.min.js";js.async=true;fjs.parentNode.insertBefore(js,fjs);}}(document,"script","lebtivity-wgts"));</script>';
			echo $after_widget;
		}

	}
	add_action( 'widgets_init', create_function('', 'return register_widget("LebtivityWidget");') );
?>
