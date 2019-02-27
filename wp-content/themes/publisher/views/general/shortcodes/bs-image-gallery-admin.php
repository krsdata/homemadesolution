<?php
/**
 * Admin fields of image gallery popup
 *
 * [bs-image-gallery-1] & [gallery] shortcode admin fields.
 *
 * @author     BetterStudio
 * @package    Publisher
 * @version    1.8.4
 */

?>
<script type="text/html" id="tmpl-bgs-gallery-setting">
	<hr style="margin: 20px 0 16px;">

	<label class="setting">
		<span><?php esc_html_e( 'Gallery Type', 'publisher' ); ?></span>
		<select data-setting="bgs_gallery_type">
			<option value=""><?php esc_html_e( 'Default', 'publisher' ); ?></option>
			<option value="slider"><?php esc_html_e( 'Publisher Gallery Slider', 'publisher' ); ?></option>
		</select>
	</label>

	<label class="setting">
		<span><?php esc_html_e( 'Gallery Title', 'publisher' ); ?></span>
		<input type="text" value="" data-setting="bgs_gallery_title"/>
	</label>

	<label class="setting">
		<span><?php esc_html_e( 'Image Size', 'publisher' ); ?></span>
		<select data-setting="bgs_gallery_image_size">
			<option value=""><?php esc_html_e( 'Publisher - Large', 'publisher' ); ?></option>
			<option value="small"><?php esc_html_e( 'Publisher - Small', 'publisher' ); ?></option>
			<option value="full"><?php esc_html_e( 'Image Full size - No crop', 'publisher' ); ?></option>
		</select>
	</label>

	<style>
		.media-sidebar .collection-settings .setting {
			float: none;
			clear: left;
		}
	</style>
</script>

<script>
	jQuery(document).ready(function () {

		_.extend(wp.media.gallery.defaults, {
			bgs_gallery_type: '',
			bgs_gallery_skin: '',
			bgs_gallery_image_size: '',
			bgs_gallery_title: ''
		});

		if (!wp.media.gallery.templates) {
			wp.media.gallery.templates = ['gallery-settings'];
		}

		wp.media.gallery.templates.push('bgs-gallery-setting');

		wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
			template: function (view) {
				var output = '';
				for (var i in wp.media.gallery.templates) {
					output += wp.media.template(wp.media.gallery.templates[i])(view);
				}
				return output;
			}
		});

	});
</script>
