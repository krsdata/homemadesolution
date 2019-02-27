<?php
/***
 *
 * Special CSS for TinyMCE
 *
 *
 * -> Fonts
 *
 * -> page_layout & default issue
 *
 */

$post_id       = $_GET['publisher-theme-editor-shortcodes'];

$layout_2column = Publisher_Theme_Editor_Shortcodes::get_config( 'layout-2-col' );
$layout_3column = Publisher_Theme_Editor_Shortcodes::get_config( 'layout-3-col' );

$show_layouts = Publisher_Theme_Editor_Shortcodes::get_config( 'layouts', TRUE );

//
// Initialize custom css generator
//
Better_Framework()->factory( 'custom-css' );
$css_generator = new BF_Custom_CSS();

$fonts['heading'] = publisher_get_option( 'typo_heading' );
$fonts['content'] = publisher_get_option( 'typo_entry_content' );

foreach ( $fonts as $_font ) {
	$css_generator->set_fonts( $_font['family'], $_font['variant'], $_font['subset'] );
}

$render = $css_generator->render_fonts();

foreach ( (array) $render as $url ) {
	echo '

@import url("' . $url . '");

';
}

if ( $fonts['content']['variant'] == 'regular' ) {
	$fonts['content']['variant'] = 400;
}

?>

.mceContentBody.mceContentBody{
	font-family: '<?php echo esc_attr( $fonts['content']['family'] ); ?>', sans-serif;
	font-weight: <?php echo esc_attr( $fonts['content']['variant'] ); ?>;
	font-size: <?php echo esc_attr( $fonts['content']['size'] ); ?>px;
	text-transform: <?php echo esc_attr( $fonts['content']['transform'] ); ?>;
	letter-spacing: <?php echo esc_attr( $fonts['content']['letter-spacing']); ?>;
	-webkit-text-size-adjust: 100%;
	text-rendering: optimizeLegibility;
	font-size-adjust: auto;
}


<?php

/***
 *
 * Custom CSS for page layout & default issue
 *
 */
if ( $show_layouts && bf_get_post_meta( 'page_layout', $post_id ) == 'default' ) {

	if ( get_post_type( $post_id ) == 'page' ) {
		$layout = publisher_get_option( 'page_layout' );
	} else {
		$layout = publisher_get_option( 'post_layout' );
	}

	if ( $layout == 'default' ) {
		$layout = publisher_get_option( 'general_layout' );
	}

	switch ( $layout ) {

		/**
		 *
		 * 2 Column -> No Sidebar
		 *
		 */
		case '1-col':
			?>
.mceContentBody.mceContentBody[data-page_layout="default"] {
	max-width: <?php echo esc_attr( $layout_2column['width'] ); ?>px; /* todo make this dynamic */
}
.mceContentBody.mceContentBody[data-page_layout="default"]::after {
	display: none;
}
.mceContentBody.mceContentBody[data-page_layout="default"]{
	border:none;
	padding-left: 15px;
	padding-right: 15px;
}
@media (max-width: <?php echo esc_attr( $layout_2column['content'] ); ?>px) {
	.mceContentBody.mceContentBody[data-page_layout="default"]{
		border:none !important;
		margin-left: 0 !important;
		margin-right: 0 !important ;
		padding-left: 15px !important ;
		padding-right: 15px !important ;
	}
}
			<?php
			break;


		/**
		 *
		 * 2 Column -> Left Sidebar
		 *
		 */
		case '2-col-left':
			?>
.mceContentBody.mceContentBody[data-page_layout="default"] {
	margin-left: 150px !important;
	border-left: 1px solid #eee;
	border-right: none;
}
.rtl.mceContentBody.mceContentBody[data-page_layout="default"] {
	margin-left: auto !important;
	border-left: none !important;
	margin-right: 150px !important;
	border-right: 1px solid #eee;
}
.mceContentBody.mceContentBody[data-page_layout="default"]::after {
	left: -25px;
	right: auto;
}
.rtl.mceContentBody.mceContentBody[data-page_layout="default"]::after {
	right: -25px;
	left: auto;
}
@media (max-width: <?php echo esc_attr( $layout_2column['content'] ); ?>px) {
	.mceContentBody.mceContentBody[data-page_layout="default"] {
		margin-left: 38px !important;
	}
	.rtl.mceContentBody.mceContentBody[data-page_layout="default"] {
		margin-right: 38px !important;
		margin-left: auto !important;
	}
}
@media (max-width: <?php echo esc_attr( $layout_2column['content'] ); ?>px) {
	.mceContentBody.mceContentBody[data-page_layout="default"]{
		border:none !important;
		margin-left: 0 !important;
		margin-right: 0 !important ;
		padding-left: 15px !important ;
		padding-right: 15px !important ;
	}
}
			<?php
			break;



		/**
		 *
		 * 3 Column -> No Sidebar
		 *
		 */
		case '3-col-0':
			?>

.mceContentBody.mceContentBody[data-page_layout="default"]:after {
	content: 'Primary';
	color: #c2cad2;
}
.mceContentBody.mceContentBody[data-page_layout="default"]:before {
	content: 'Secondary';
	color: #d3d4d6;
}
.mceContentBody.mceContentBody[data-page_layout^="default"]{
	max-width: <?php echo esc_attr( $layout_3column['content'] );  // escaped before ?>px;
}

.mceContentBody.mceContentBody[data-page_layout="default"]:before,
.mceContentBody.mceContentBody[data-page_layout="default"]:after {
	display: none;
}
.mceContentBody.mceContentBody[data-page_layout="default"] {
	max-width: <?php echo esc_attr( $layout_3column['width'] ); // escaped before ?>px;
	border-right: none;
}
.rtl.mceContentBody.mceContentBody[data-page_layout="default"] {
	border-left: none;
}
			<?php
			break;

		/**
		 *
		 * 3 Column 1
		 *
		 */
		case '3-col-1':
			?>
.mceContentBody.mceContentBody[data-page_layout="default"]:before,
.mceContentBody.mceContentBody[data-page_layout="default"]:after {
	content: 'Sidebar';
	display: block;
	position: absolute;
	top: 0;
	left: 102%;
	width: 10px;
	-ms-word-break: break-all;
	word-break: break-all;
	font-size: 14px;
	color: #d8d8d8;
	text-align: center;
	height: 100%;
	max-width: 330px;
	z-index: 1;
	text-transform: uppercase;
	font-family: sans-serif;
	font-weight: 600;
	line-height: 26px;
	pointer-events: none;
}
.rtl.mceContentBody.mceContentBody[data-page_layout="default"]:before,
.rtl.mceContentBody.mceContentBody[data-page_layout="default"]:after {
	left: auto;
	right: 102%;
}
.mceContentBody.mceContentBody[data-page_layout="default"]:after {
	content: 'Primary';
	color: #c2cad2;
}
.mceContentBody.mceContentBody[data-page_layout="default"]:before {
	content: 'Secondary';
	color: #d3d4d6;
}
.mceContentBody.mceContentBody[data-page_layout="default"]{
	max-width: <?php echo esc_attr( $layout_3column['content'] );  // escaped before ?>px;
}
@media (max-width: <?php echo esc_attr( $layout_3column['content'] ); // escaped before ?>px) {
	.mceContentBody.mceContentBody[data-page_layout^="default"] {
		border:none !important;
		margin-left: 0 !important;
		margin-right: 0 !important ;
		padding-left: 15px !important ;
		padding-right: 15px !important ;
	}
	.mceContentBody.mceContentBody[data-page_layout^="default"]:before {
		display:none !improtant;
	}
}

.mceContentBody.mceContentBody[data-page_layout="default"]:before{
	left: 106%;
	border-left: 1px solid #eee;
	padding-left: 22px;
	width: 35px;
}
.rtl.mceContentBody.mceContentBody[data-page_layout="default"]:before{
	left: inherit;
	right: 106%;
	border-left: none;
	border-right: 1px solid #eee;
	padding-left: 0;
	padding-right: 22px;
}
			<?php
			break;


		/**
		 *
		 * 3 Column 2
		 *
		 */
		case '3-col-2':
			?>
.mceContentBody.mceContentBody[data-page_layout="default"]:before,
.mceContentBody.mceContentBody[data-page_layout="default"]:after {
	content: 'Sidebar';
	display: block;
	position: absolute;
	top: 0;
	left: 102%;
	width: 10px;
	-ms-word-break: break-all;
	word-break: break-all;
	font-size: 14px;
	color: #d8d8d8;
	text-align: center;
	height: 100%;
	max-width: 330px;
	z-index: 1;
	text-transform: uppercase;
	font-family: sans-serif;
	font-weight: 600;
	line-height: 26px;
	pointer-events: none;
}
.rtl.mceContentBody.mceContentBody[data-page_layout="default"]:before,
.rtl.mceContentBody.mceContentBody[data-page_layout="default"]:after {
	left: auto;
	right: 102%;
}
.mceContentBody.mceContentBody[data-page_layout="default"]:after {
	content: 'Primary';
	color: #c2cad2;
}
.mceContentBody.mceContentBody[data-page_layout="default"]:before {
	content: 'Secondary';
	color: #d3d4d6;
}
.mceContentBody.mceContentBody[data-page_layout="default"]{
	max-width: <?php echo esc_attr( $layout_3column['content'] );  // escaped before ?>px;
}
@media (max-width: <?php echo esc_attr( $layout_3column['content'] ); // escaped before ?>px) {
	.mceContentBody.mceContentBody[data-page_layout^="default"] {
		border:none !important;
		margin-left: 0 !important;
		margin-right: 0 !important ;
		padding-left: 15px !important ;
		padding-right: 15px !important ;
	}
	.mceContentBody.mceContentBody[data-page_layout^="default"]:before {
		display:none !improtant;
	}
}

.mceContentBody.mceContentBody[data-page_layout="default"]:after {
	left: 106%;
	border-left: 1px solid #eee;
	padding-left: 22px;
	width: 35px;
}
.rtl.mceContentBody.mceContentBody[data-page_layout="default"]:after {
	left: inherit;
	right: 106%;
	border-left: none;
	border-right: 1px solid #eee;
	padding-left: 0;
	padding-right: 22px;
}
			<?php
			break;



		/**
		 *
		 * 3 Column 3
		 *
		 */
		case '3-col-3':
			?>
.mceContentBody.mceContentBody[data-page_layout="default"]:before,
.mceContentBody.mceContentBody[data-page_layout="default"]:after {
	content: 'Sidebar';
	display: block;
	position: absolute;
	top: 0;
	left: 102%;
	width: 10px;
	-ms-word-break: break-all;
	word-break: break-all;
	font-size: 14px;
	color: #d8d8d8;
	text-align: center;
	height: 100%;
	max-width: 330px;
	z-index: 1;
	text-transform: uppercase;
	font-family: sans-serif;
	font-weight: 600;
	line-height: 26px;
	pointer-events: none;
}
.rtl.mceContentBody.mceContentBody[data-page_layout="default"]:before,
.rtl.mceContentBody.mceContentBody[data-page_layout="default"]:after {
	left: auto;
	right: 102%;
}
.mceContentBody.mceContentBody[data-page_layout="default"]:after {
	content: 'Primary';
	color: #c2cad2;
}
.mceContentBody.mceContentBody[data-page_layout="default"]:before {
	content: 'Secondary';
	color: #d3d4d6;
}
.mceContentBody.mceContentBody[data-page_layout="default"]{
	max-width: <?php echo esc_attr( $layout_3column['content'] );  // escaped before ?>px;
}
@media (max-width: <?php echo esc_attr( $layout_3column['content'] ); // escaped before ?>px) {
	.mceContentBody.mceContentBody[data-page_layout^="default"] {
		border:none !important;
		margin-left: 0 !important;
		margin-right: 0 !important ;
		padding-left: 15px !important ;
		padding-right: 15px !important ;
	}
	.mceContentBody.mceContentBody[data-page_layout^="default"]:before {
		display:none !improtant;
	}
}

.mceContentBody.mceContentBody[data-page_layout="default"]{
	margin-left: 40px;
}
.rtl.mceContentBody.mceContentBody[data-page_layout="default"]{
	margin-left: 0;
	margin-right: 40px;
}
.mceContentBody.mceContentBody[data-page_layout="default"]:after {
	left: -3%;
	border-right: 1px solid #eee;
	padding-right: 10px;
	width: 21px;
}
.rtl.mceContentBody.mceContentBody[data-page_layout="default"]:after {
	left: inherit;
	right: -3%;
	border-right: none;
	border-left: 1px solid #eee;
	padding-right: 0;
	padding-left: 10px;
}
			<?php
			break;


		/**
		 *
		 * 3 Column 4
		 *
		 */
		case '3-col-4':
			?>
.mceContentBody.mceContentBody[data-page_layout="default"]:before,
.mceContentBody.mceContentBody[data-page_layout="default"]:after {
	content: 'Sidebar';
	display: block;
	position: absolute;
	top: 0;
	left: 102%;
	width: 10px;
	-ms-word-break: break-all;
	word-break: break-all;
	font-size: 14px;
	color: #d8d8d8;
	text-align: center;
	height: 100%;
	max-width: 330px;
	z-index: 1;
	text-transform: uppercase;
	font-family: sans-serif;
	font-weight: 600;
	line-height: 26px;
	pointer-events: none;
}
.rtl.mceContentBody.mceContentBody[data-page_layout="default"]:before,
.rtl.mceContentBody.mceContentBody[data-page_layout="default"]:after {
	left: auto;
	right: 102%;
}
.mceContentBody.mceContentBody[data-page_layout="default"]:after {
	content: 'Primary';
	color: #c2cad2;
}
.mceContentBody.mceContentBody[data-page_layout="default"]:before {
	content: 'Secondary';
	color: #d3d4d6;
}
.mceContentBody.mceContentBody[data-page_layout="default"]{
	max-width: <?php echo esc_attr( $layout_3column['content'] );  // escaped before ?>px;
}
@media (max-width: <?php echo esc_attr( $layout_3column['content'] ); // escaped before ?>px) {
	.mceContentBody.mceContentBody[data-page_layout^="default"] {
		border:none !important;
		margin-left: 0 !important;
		margin-right: 0 !important ;
		padding-left: 15px !important ;
		padding-right: 15px !important ;
	}
	.mceContentBody.mceContentBody[data-page_layout^="default"]:before {
		display:none !improtant;
	}
}

.mceContentBody.mceContentBody[data-page_layout="default"]{
	margin-left: 40px;
}
.rtl.mceContentBody.mceContentBody[data-page_layout="default"]{
	margin-left: 0;
	margin-right: 40px;
}
.mceContentBody.mceContentBody[data-page_layout="default"]:before{
	left: -3%;
	border-right: 1px solid #eee;
	padding-right: 10px;
	width: 21px;
}
.rtl.mceContentBody.mceContentBody[data-page_layout="default"]:before{
	left: inherit;
	right: -3%;
	border-right: none;
	border-left: 1px solid #eee;
	padding-right: 0;
	padding-left: 10px;
}
			<?php
			break;


		/**
		 *
		 * 3 Column 5
		 *
		 */
		case '3-col-5':
			?>
.mceContentBody.mceContentBody[data-page_layout="default"]:before,
.mceContentBody.mceContentBody[data-page_layout="default"]:after {
	content: 'Sidebar';
	display: block;
	position: absolute;
	top: 0;
	left: 102%;
	width: 10px;
	-ms-word-break: break-all;
	word-break: break-all;
	font-size: 14px;
	color: #d8d8d8;
	text-align: center;
	height: 100%;
	max-width: 330px;
	z-index: 1;
	text-transform: uppercase;
	font-family: sans-serif;
	font-weight: 600;
	line-height: 26px;
	pointer-events: none;
}
.rtl.mceContentBody.mceContentBody[data-page_layout="default"]:before,
.rtl.mceContentBody.mceContentBody[data-page_layout="default"]:after {
	left: auto;
	right: 102%;
}
.mceContentBody.mceContentBody[data-page_layout="default"]:after {
	content: 'Primary';
	color: #c2cad2;
}
.mceContentBody.mceContentBody[data-page_layout="default"]:before {
	content: 'Secondary';
	color: #d3d4d6;
}
.mceContentBody.mceContentBody[data-page_layout="default"]{
	max-width: <?php echo esc_attr( $layout_3column['content'] );  // escaped before ?>px;
}
@media (max-width: <?php echo esc_attr( $layout_3column['content'] ); // escaped before ?>px) {
	.mceContentBody.mceContentBody[data-page_layout^="default"] {
		border:none !important;
		margin-left: 0 !important;
		margin-right: 0 !important ;
		padding-left: 15px !important ;
		padding-right: 15px !important ;
	}
	.mceContentBody.mceContentBody[data-page_layout^="default"]:before {
		display:none !improtant;
	}
}

.mceContentBody.mceContentBody[data-page_layout="default"] {
	margin-left: 70px !important;
	border-right: none;
	border-left: 1px solid #eee;
}
.rtl.mceContentBody.mceContentBody[data-page_layout="default"] {
	margin-left: inherit !important;
	margin-right: 70px !important;
	border-left: none;
	border-right: 1px solid #eee;
}
.mceContentBody.mceContentBody[data-page_layout="default"]:after {
	left: -7.5%;
	border-right: 1px solid #eee;
	padding-right: 10px;
	width: 21px;
}
.rtl.mceContentBody.mceContentBody[data-page_layout="default"]:after {
	right: -7.5%;
	border-right: none;
	border-left: 1px solid #eee;
	padding-right: 0;
	padding-left: 10px;
}
.mceContentBody.mceContentBody[data-page_layout="default"]:before {
	left: -3%;
}
.rtl.mceContentBody.mceContentBody[data-page_layout="default"]:before {
	left: inherit;
	right: -3%;
}
			<?php
			break;


		/**
		 *
		 * 3 Column 6
		 *
		 */
		case '3-col-6':
			?>
.mceContentBody.mceContentBody[data-page_layout="default"]:before,
.mceContentBody.mceContentBody[data-page_layout="default"]:after {
	content: 'Sidebar';
	display: block;
	position: absolute;
	top: 0;
	left: 102%;
	width: 10px;
	-ms-word-break: break-all;
	word-break: break-all;
	font-size: 14px;
	color: #d8d8d8;
	text-align: center;
	height: 100%;
	max-width: 330px;
	z-index: 1;
	text-transform: uppercase;
	font-family: sans-serif;
	font-weight: 600;
	line-height: 26px;
	pointer-events: none;
}
.rtl.mceContentBody.mceContentBody[data-page_layout="default"]:before,
.rtl.mceContentBody.mceContentBody[data-page_layout="default"]:after {
	left: auto;
	right: 102%;
}
.mceContentBody.mceContentBody[data-page_layout="default"]:after {
	content: 'Primary';
	color: #c2cad2;
}
.mceContentBody.mceContentBody[data-page_layout="default"]:before {
	content: 'Secondary';
	color: #d3d4d6;
}
.mceContentBody.mceContentBody[data-page_layout="default"]{
	max-width: <?php echo esc_attr( $layout_3column['content'] );  // escaped before ?>px;
}
@media (max-width: <?php echo esc_attr( $layout_3column['content'] ); // escaped before ?>px) {
	.mceContentBody.mceContentBody[data-page_layout^="default"] {
		border:none !important;
		margin-left: 0 !important;
		margin-right: 0 !important ;
		padding-left: 15px !important ;
		padding-right: 15px !important ;
	}
	.mceContentBody.mceContentBody[data-page_layout^="default"]:before {
		display:none !improtant;
	}
}

.mceContentBody.mceContentBody[data-page_layout="default"] {
	margin-left: 70px !important;
	border-right: none;
	border-left: 1px solid #eee;
}
.rtl.mceContentBody.mceContentBody[data-page_layout="default"] {
	margin-left: inherit !important;
	margin-right: 70px !important;
	border-left: none;
	border-right: 1px solid #eee;
}
.mceContentBody.mceContentBody[data-page_layout="default"]:before{
	left: -7.5%;
	border-right: 1px solid #eee;
	padding-right: 10px;
	width: 21px;
}
.rtl.mceContentBody.mceContentBody[data-page_layout="default"]:before{
	right: -7.5%;
	border-right: none;
	border-left: 1px solid #eee;
	padding-right: 0;
	padding-left: 10px;
}
.mceContentBody.mceContentBody[data-page_layout="default"]:after{
	left: -3%;
}
.rtl.mceContentBody.mceContentBody[data-page_layout="default"]:after{
	left: inherit;
	right: -3%;
}
			<?php
			break;



	}

}

?>
.wpview-wrap.wpview-wrap[data-wpview-type="gallery"] .wp-caption-text{
    text-align: center !important;
    padding: 0 10px !important;
}

<?php if( ! empty( publisher_get_option( 'content_a_color' ) ) ){ ?>
.mceContentBody.mceContentBody a{
	color: <?php echo publisher_get_option( 'content_a_color' ); ?>;
}
<?php } ?>

<?php if( ! empty( publisher_get_option( 'content_a_hover_color' ) ) ){ ?>
.mceContentBody.mceContentBody a:hover{
	color: <?php echo publisher_get_option( 'content_a_hover_color' ); ?>;
}
<?php } ?>
