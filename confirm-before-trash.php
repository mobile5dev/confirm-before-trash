<?php
/*
Plugin Name: Confirm Before Trash
Plugin URI: http://example.com
Description: Adds a confirmation box before deleting a post.
Version: 1.0
Author: Panagiotis Vagenas <pan.vagenas@gmail.com>
Author URI: http://example.com
License: A "Slug" license name e.g. GPL2
*/
add_action('admin_footer', 'cbd_wp_loaded');
function cbd_wp_loaded(){
	$screen = get_current_screen();
	if($screen->base == "edit" || $screen->parent_base == "edit"){
		?>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$('a.submitdelete').click(function(e){
					e.preventDefault();
					var href = $(this).attr('href');
          if ($(this).text() === "Trash" || $(this).text() === "Move to Trash") {
            var r = confirm('Are you sure you want to delete this item? If confirmed, removed items will be moved into trash.');
          } else {
            var r = confirm('Are you sure you want to delete this item? This will delete it permanently from the system.');
          }
					if(r){
						window.location = href;
					}
				});
				$('a.delete-tag').click(function(e){
					e.preventDefault();
					var r = confirm('Are you sure you want to delete this item? This will delete it permanently from the system and will be removed from any posts that have this category.');
					if(r){
						window.location = href;
					}
				});
				$('#doaction').click(function(e){
					if($('#bulk-action-selector-top').val() == 'trash'){
						if($('input[name="post[]"]:checked').length > 0){
							var r = confirm('Are you sure you want to delete these items? If confirmed, removed items will be moved into trash.');
							if(!r){
								e.preventDefault();
							}
						}
					}
				});
				$('#doaction').click(function(e){
					if($('#bulk-action-selector-top').val() == 'delete'){
						if($('input[name="delete_tags[]"]:checked').length > 0 || $('input[name="post[]"]:checked').length > 0){
							var r = confirm('Are you sure you want to delete these items? These will be permanently deleted from the system and will be removed from any posts that have this category.');
							if(!r){
								e.preventDefault();
							}
						}
					}
				});
			});
		</script>
		<?php
	} else if($screen->base == "user-edit"){
		?>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				var originalRole = $('select[name="role"]').val();
				$('select[name="role"]').on('change', function(e){
					if($(e.target).val() == ''){
						e.preventDefault();
						var r = confirm('Are you sure you want to remove access rights for this user? They cannot login to view Media rights or request for a new password.');
						if(!r){
							e.preventDefault();
							$(e.target).val(originalRole);
						} else {
							originalRole = $(e.target).val();
						}
					} else {
						originalRole = $(e.target).val();
					}
				});
			});
		</script>
		<?php
	}

	return true;
}
