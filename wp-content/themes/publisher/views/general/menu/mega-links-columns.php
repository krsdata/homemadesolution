<?php
/**
 * Multi column links mega menu template
 *
 * @author     BetterStudio
 * @package    Publisher
 * @version    1.8.4
 */

$args = publisher_get_prop( 'mega-menu-args', '' );

publisher_set_prop( 'mega-menu-columns', $args['current-item']->mega_menu );

?>
<div class="mega-menu mega-type-link">
	<div class="content-wrap">
		<ul class="mega-links <?php echo esc_attr( $args['current-item']->mega_menu ); ?>">
			<?php echo $args['sub-menu']; // escaped before ?>
		</ul>
	</div>
</div>
<?php publisher_clear_props(); ?>

