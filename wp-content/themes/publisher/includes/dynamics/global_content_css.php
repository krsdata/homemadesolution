<?php
/***
 *
 * Global CSS used for AMP & TinyMCE
 *
 */

$is_amp  = publisher_get_global( 'is-amp-css-request', FALSE );
$is_tiny = ! $is_amp;


$highlight_color = publisher_get_option( 'theme_color' );

$fonts['heading'] = publisher_get_option( 'typo_heading' );
$fonts['content'] = publisher_get_option( 'typo_entry_content' );

if ( $fonts['heading']['variant'] == 'regular' ) {
	$fonts['heading']['variant'] = 400;
}

if ( $fonts['content']['variant'] == 'regular' ) {
	$fonts['content']['variant'] = 400;
}

if ( publisher_get_global( 'is-amp-css-request', FALSE ) ) {
	$fonts['content']['size'] = '1.1em';
}


if ( $is_amp ) {
	$content_parent = '.entry-content';
	$important      = '';
} else {
	$content_parent = '.mceContentBody.mceContentBody';
	$important      = ' !important';
}


?>

/**
* =>Global
**/
<?php echo esc_attr( $content_parent ); ?> .heading-typo,
<?php echo esc_attr( $content_parent ); ?> h1,
<?php echo esc_attr( $content_parent ); ?> h2,
<?php echo esc_attr( $content_parent ); ?> h3,




<?php echo esc_attr( $content_parent ); ?> h4,
<?php echo esc_attr( $content_parent ); ?> h5,
<?php echo esc_attr( $content_parent ); ?> h6{
	color: #2D2D2D;
	margin-top: 10px;
	margin-bottom: 10px;
	line-height: 1.3;
}
<?php echo esc_attr( $content_parent ); ?> h1{
	font-size: 34px;
}
<?php echo esc_attr( $content_parent ); ?> h2{
	font-size: 30px;
}
<?php echo esc_attr( $content_parent ); ?> h3{
	font-size: 25px;
}
<?php echo esc_attr( $content_parent ); ?> h4{
	font-size: 20px;
}
<?php echo esc_attr( $content_parent ); ?> h5{
	font-size: 17px;
}
<?php echo esc_attr( $content_parent ); ?> h6{
	font-size: 15px;
}


<?php echo esc_attr( $content_parent ); ?> h1,
<?php echo esc_attr( $content_parent ); ?> h2,
<?php echo esc_attr( $content_parent ); ?> h3,
<?php echo esc_attr( $content_parent ); ?> h4,
<?php echo esc_attr( $content_parent ); ?> h5,
<?php echo esc_attr( $content_parent ); ?> h6{
	font-family: '<?php echo esc_attr( $fonts['heading']['family'] ); ?>', sans-serif;
	font-weight: <?php echo esc_attr( $fonts['heading']['variant'] ); ?>;
	text-transform: <?php echo esc_attr( $fonts['heading']['transform'] ); ?>;
	letter-spacing: <?php echo esc_attr( $fonts['heading']['letter-spacing'] ); ?>;
}


/**
* =>Entry Content
**/
<?php echo esc_attr( $content_parent ); ?> .bs-intro{
	font-size: 110%;
	font-weight: bolder;
	-webkit-font-smoothing: antialiased;
}
<?php echo esc_attr( $content_parent ); ?> {
	font-family: '<?php echo esc_attr( $fonts['content']['family'] ); ?>', sans-serif;
	font-weight: <?php echo esc_attr( $fonts['content']['variant'] ); ?>;
	font-size: <?php echo esc_attr( $fonts['content']['size'] ); ?>px;
	text-transform: <?php echo esc_attr( $fonts['content']['transform'] ); ?>;
	letter-spacing: <?php echo esc_attr( $fonts['content']['letter-spacing'] ) ?>;
	line-height: 1.6;
	color: #4A4A4A;
}
<?php echo esc_attr( $content_parent ); ?> p{
	padding: 0;
	margin: 0 0 17px;
}
<?php echo esc_attr( $content_parent ); ?> ol,
<?php echo esc_attr( $content_parent ); ?> ul{
	margin-bottom: 17px;
}
<?php echo esc_attr( $content_parent ); ?> table{
	border: 1px solid #ddd;
}
<?php echo esc_attr( $content_parent ); ?> table > thead > tr > th,
<?php echo esc_attr( $content_parent ); ?> table > tbody > tr > th,
<?php echo esc_attr( $content_parent ); ?> table > tfoot > tr > th,
<?php echo esc_attr( $content_parent ); ?> table > thead > tr > td,
<?php echo esc_attr( $content_parent ); ?> table > tbody > tr > td,
<?php echo esc_attr( $content_parent ); ?> table > tfoot > tr > td {
	border: 1px solid #ddd;
	padding: 7px 10px;
}
<?php echo esc_attr( $content_parent ); ?> table > thead > tr > th,
<?php echo esc_attr( $content_parent ); ?> table > thead > tr > td {
	border-bottom-width: 2px;
}
<?php echo esc_attr( $content_parent ); ?> dl dt{
	font-size: 15px;
}
<?php echo esc_attr( $content_parent ); ?> dl dd{
	margin-bottom: 10px;
}
<?php echo esc_attr( $content_parent ); ?> acronym[title] {
	border-bottom: 1px dotted #999;
}
<?php echo esc_attr( $content_parent ); ?> .wp-caption.alignright,
<?php echo esc_attr( $content_parent ); ?> .alignright{
	margin: 5px 0 20px 20px;
	float: right;
}
<?php echo esc_attr( $content_parent ); ?>.rtl .wp-caption.alignright,
<?php echo esc_attr( $content_parent ); ?>.rtl .alignright{
	margin: 5px 20px 20px 0;
	float: left;
}
<?php echo esc_attr( $content_parent ) ; ?> .wp-caption.alignleft,
<?php echo esc_attr( $content_parent ); ?> .alignleft{
	margin: 5px 20px 15px 0;
	float: left;
}
<?php echo esc_attr( $content_parent ) ; ?>.rtl .wp-caption.alignleft,
<?php echo esc_attr( $content_parent ); ?>.rtl .alignleft{
	margin: 5px 0 15px 20px ;
	float: right;
}
<?php if( $is_tiny ) echo esc_attr( $content_parent ) . ' .wp-caption.alignleft .wp-caption-dd,'; ?>
<?php if( $is_amp ) echo esc_attr( $content_parent ) . ' .wp-caption.alignleft .wp-caption-text,'; ?>
<?php echo esc_attr( $content_parent ); ?> figure.alignleft .wp-caption-text{
	text-align: left;
}
<?php if( $is_tiny ) echo esc_attr( $content_parent ) . '.rtl .wp-caption.alignleft .wp-caption-dd,'; ?>
<?php if( $is_amp ) echo esc_attr( $content_parent ) . '.rtl .wp-caption.alignleft .wp-caption-text,'; ?>
<?php echo esc_attr( $content_parent ); ?> figure.alignleft .wp-caption-text{
	text-align: right;
}
<?php if( $is_tiny ) echo esc_attr( $content_parent ) . ' .wp-caption.alignright .wp-caption-dd,'; ?>
<?php if( $is_amp ) echo esc_attr( $content_parent ) . ' .wp-caption.alignright .wp-caption-text,'; ?>
<?php echo esc_attr( $content_parent ); ?> figure.alignright .wp-caption-text{
	text-align: right;
}
<?php if( $is_tiny ) echo esc_attr( $content_parent ) . '.rtl .wp-caption.alignright .wp-caption-dd,'; ?>
<?php if( $is_amp ) echo esc_attr( $content_parent ) . '.rtl .wp-caption.alignright .wp-caption-text,'; ?>
<?php echo esc_attr( $content_parent ); ?> figure.alignright .wp-caption-text{
	text-align: left;
}
<?php echo esc_attr( $content_parent ); ?> figure,
<?php echo esc_attr( $content_parent ); ?> img{
	max-width: 100%;
	height: auto;
}
<?php echo esc_attr( $content_parent ); ?>  .wp-caption,
<?php echo esc_attr( $content_parent ); ?> img.aligncenter{
	display: block;
	margin: 15px auto 25px;
}
<?php echo esc_attr( $content_parent ); ?> .wp-caption.aligncenter,
<?php echo esc_attr( $content_parent ); ?> figure.aligncenter{
	margin: 20px auto;
	text-align: center ;
}
<?php echo esc_attr( $content_parent ); ?>  .wp-caption.aligncenter img,
<?php echo esc_attr( $content_parent ); ?> figure.aligncenter img{
	display: inline-block;
}
<?php if( $is_tiny ) echo esc_attr( $content_parent ) . ' .wp-caption-dd,'; ?>
<?php echo esc_attr( $content_parent ); ?> .wp-caption-text,
<?php echo esc_attr( $content_parent ); ?> .gallery-caption,
<?php echo esc_attr( $content_parent ); ?> figcaption{
	margin: 5px 0 0;
	font-style: italic;
	text-align: left;
	font-size: 13px;
	color: #545454;
	line-height: 15px;
	padding: 0;
}
<?php if( $is_tiny ) echo esc_attr( $content_parent ) . '.rtl .wp-caption-dd,'; ?>
<?php echo esc_attr( $content_parent ); ?>.rtl .wp-caption-text,
<?php echo esc_attr( $content_parent ); ?>.rtl .gallery-caption,
<?php echo esc_attr( $content_parent ); ?>.rtl figcaption{
	text-align: right;
}
<?php echo esc_attr( $content_parent ); ?> .twitter-tweet{
	width: 100% <?php echo esc_attr( $important );?>;
}
<?php echo esc_attr( $content_parent ); ?> .gallery{
	text-align: center;
}
<?php echo esc_attr( $content_parent ); ?> .gallery:after{
	content: "";
	display: table;
	clear: both;
}
<?php echo esc_attr( $content_parent ); ?> .gallery .gallery-item{
	margin-bottom: 10px;
	position: relative;
}
<?php echo esc_attr( $content_parent ); ?> .gallery .gallery-item img{
	max-width: 100% <?php echo esc_attr( $important );?>;
	height: auto <?php echo esc_attr( $important );?>;
}
<?php echo esc_attr( $content_parent ); ?> .gallery.gallery-columns-2{
	clear: both;
}
<?php echo esc_attr( $content_parent ); ?> .gallery.gallery-columns-2 .gallery-item{
	width: 50%;float: left;
}
<?php echo esc_attr( $content_parent ); ?>.rtl .gallery.gallery-columns-2 .gallery-item{
	float: right;
}
<?php echo esc_attr( $content_parent ); ?> .gallery.gallery-columns-3 .gallery-item{
	width: 33.33%;float: left;
}
<?php echo esc_attr( $content_parent ); ?>.rtl .gallery.gallery-columns-3 .gallery-item{
	float: right;
}
<?php echo esc_attr( $content_parent ); ?> .gallery.gallery-columns-4 .gallery-item{
	width: 25%;float: left;
}
<?php echo esc_attr( $content_parent ); ?>.rtl .gallery.gallery-columns-4 .gallery-item{
	float: right;
}
<?php echo esc_attr( $content_parent ); ?> .gallery.gallery-columns-5 .gallery-item{
	width: 20%;float: left;
}
<?php echo esc_attr( $content_parent ); ?>.rtl .gallery.gallery-columns-5 .gallery-item{
	float: right;
}
<?php echo esc_attr( $content_parent ); ?> .gallery.gallery-columns-6 .gallery-item{
	width: 16.666%; float: left;
}
<?php echo esc_attr( $content_parent ); ?>.rtl .gallery.gallery-columns-6 .gallery-item{
	float: right;
}
<?php echo esc_attr( $content_parent ); ?> .gallery.gallery-columns-7 .gallery-item{
	width: 14.28%; float: left;
}
<?php echo esc_attr( $content_parent ); ?>.rtl .gallery.gallery-columns-7 .gallery-item{
	float: right;
}
<?php echo esc_attr( $content_parent ); ?> .gallery.gallery-columns-8 .gallery-item{
	width: 12.5%; float: left;
}
<?php echo esc_attr( $content_parent ); ?>.rtl .gallery.gallery-columns-8 .gallery-item{
	float: right;
}
<?php echo esc_attr( $content_parent ); ?> .gallery.gallery-columns-9 .gallery-item{
	width: 11.111%; float: left;
}
<?php echo esc_attr( $content_parent ); ?>.rtl .gallery.gallery-columns-9 .gallery-item{
	float: right;
}
<?php echo esc_attr( $content_parent ); ?> .terms-list{
	margin-bottom: 10px;
}
<?php echo esc_attr( $content_parent ); ?> .terms-list span.sep{
	margin: 0 5px;
}
<?php echo esc_attr( $content_parent ); ?> a{
	color: <?php echo esc_attr( $highlight_color ); ?>;
}
<?php echo esc_attr( $content_parent ); ?> a:hover{
	text-decoration: underline;
}
<?php echo esc_attr( $content_parent ); ?> a:visited{
	opacity: 0.8;
}
<?php echo esc_attr( $content_parent ); ?> hr {
	margin: 27px 0;
	border-top: 2px solid #F0F0F0;
}
<?php echo esc_attr( $content_parent ); ?> code {
	padding: 4px 6px;
	font-size: 90%;
	color: inherit;
	background-color: #EAEAEA;
	border-radius: 0;
}
<?php echo esc_attr( $content_parent ); ?> pre {
	padding: 15px;
	background-color: #f5f5f5;
	border: 1px solid #DCDCDC;
	border-radius: 0;
}


/**
* =>Shortcodes and tags
**/


/**
* ->Blockquote
**/
<?php echo esc_attr( $content_parent ); ?> blockquote {
	font-size: 110%;
	background-color: #efefef;
	border-left: none;
	padding: 60px 35px 50px;
	margin: 40px 0px 30px;
	position: relative;
	text-align: center;
}
<?php echo esc_attr( $content_parent ); ?> blockquote:before {
	content: '\f10e';
	position: absolute;
	top: 0;
	left: 50%;
	margin-top: -40px;
	margin-left: -40px;
	font-size: 30px;
	font-family: FontAwesome;
	color: #444444;
	display: block;
	width: 80px;
	height: 80px;
	background: #ffffff;
	line-height: 101px;
	border-radius: 50%;
	text-align: center;
}
<?php echo esc_attr( $content_parent ); ?>.rtl blockquote:before {
	right: 50%;
	left: auto;
	margin-right: -40px;
	margin-left: auto;
}
<?php echo esc_attr( $content_parent ); ?> blockquote.bs-pullquote{
	min-width: 250px;
	max-width: 333px;
	display: inline-block;
	padding: 20px;
	margin: 0 0 20px 0;
	background-color: #f3f3f3;
	position: relative;
	z-index: 1;
}
<?php echo esc_attr( $content_parent ); ?> blockquote.bs-pullquote:before{
	display: none;
}
<?php echo esc_attr( $content_parent ); ?> blockquote.bs-pullquote-right {
	text-align: right;
	float: right;
	margin-left: 25px;
	border-right: 4px solid <?php echo esc_attr( $highlight_color ); ?>;
}
<?php echo esc_attr( $content_parent ); ?>.rtl blockquote.bs-pullquote-right {
	text-align: left;
	float: left;
	margin-right: 25px;
	margin-left: auto;
	border-left: 4px solid <?php echo esc_attr( $highlight_color ); ?>;
	border-right: none;
}
<?php echo esc_attr( $content_parent ); ?> blockquote.bs-pullquote-left {
	text-align: left;
	float: left;
	margin-right: 25px;
	border-left: 4px solid <?php echo esc_attr( $highlight_color ); ?>;
}
<?php echo esc_attr( $content_parent ); ?>.rtl blockquote.bs-pullquote-left {
	text-align: right;
	float: right;
	margin-left: 25px;
	margin-right: auto;
	border-right: 4px solid <?php echo esc_attr( $highlight_color ); ?>;
	border-left: none;
}
<?php echo esc_attr( $content_parent ); ?> blockquote p:last-child{
	margin-bottom: 0;
}


/**
* ->Dropcap
**/
<?php echo esc_attr( $content_parent ); ?> .dropcap.dropcap {
	display: inline-block;
	float: left;
	margin: 0 8px -10px 0;
	font-size: 74px;
	line-height: 74px;
	height: 74px;
	text-transform: uppercase;
}
<?php echo esc_attr( $content_parent ); ?>.rtl .dropcap.dropcap {
	float: right;
	margin: 0 0 -10px 8px;
}
<?php echo esc_attr( $content_parent ); ?> .dropcap.dropcap-square {
	background-color: <?php echo esc_attr( $highlight_color ); ?>;
	color: #fff;
	padding: 0 11px;
}
<?php echo esc_attr( $content_parent ); ?> .dropcap.dropcap-square-outline {
	border: 2px solid <?php echo esc_attr( $highlight_color ); ?>;
	color: <?php echo esc_attr( $highlight_color ); ?>;
	padding: 0 11px;
	line-height: 70px;
}
<?php echo esc_attr( $content_parent ); ?> .dropcap.dropcap-circle {
	background-color: <?php echo esc_attr( $highlight_color ); ?>;
	color: #fff;
	padding: 0 11px;
	border-radius: 50%;
	min-width: 74px;
	font-size: 52px;
	text-align: center;
}
<?php echo esc_attr( $content_parent ); ?> .dropcap.dropcap-circle-outline {
	border: 2px solid <?php echo esc_attr( $highlight_color ); ?>;
	color: <?php echo esc_attr( $highlight_color ); ?>;
	padding: 0 11px;
	border-radius: 50%;
	min-width: 74px;
	font-size: 52px;
	text-align: center;
	line-height: 72px;
}


/**
* ->Highlight
**/
<?php echo esc_attr( $content_parent ); ?> .bs-highlight{
	background-color: #FF9;
	padding: 0 3px;
}
<?php echo esc_attr( $content_parent ); ?> .bs-highlight.bs-highlight-red{
	background-color: #FFB6B6;
}


/**
* ->Alert Shortcode
**/
<?php echo esc_attr( $content_parent ); ?> .bs-shortcode-alert.alert{
	border-radius: 0;
}
<?php echo esc_attr( $content_parent ); ?> .bs-shortcode-alert.alert-simple{
	background-color: #F3F3F3;
	border-color: #E6E6E6;
}


/**
* ->Divider
**/
<?php echo esc_attr( $content_parent ); ?> hr.bs-divider{
	height: 2px;
	border-width: 2px;
	border-style: solid;
	border-color: #DBDBDB;
	border-top-width: 0;
	border-right-width: 0;
	border-left-width: 0;
	margin: 30px auto 28px;
	position: relative;
	width: 90%;
}
<?php echo esc_attr( $content_parent ); ?> hr.bs-divider.dashed-line{
	border-top-width: 2px;
	height: 2px;
}
<?php echo esc_attr( $content_parent ); ?> hr.bs-divider.full{
	width: 100%;
}
<?php echo esc_attr( $content_parent ); ?> hr.bs-divider.large{
	width: 90%;
}
<?php echo esc_attr( $content_parent ); ?> hr.bs-divider.small{
	width: 70%;
}
<?php echo esc_attr( $content_parent ); ?> hr.bs-divider.tiny{
	width: 50%;
}
<?php echo esc_attr( $content_parent ); ?> hr.bs-divider + h3,
<?php echo esc_attr( $content_parent ); ?> hr.bs-divider + h2,
<?php echo esc_attr( $content_parent ); ?> hr.bs-divider + h1 {
	margin-top: -10px;
}
<?php echo esc_attr( $content_parent ); ?> hr.bs-divider + h5{
	margin-top: -5px;
}
<?php echo esc_attr( $content_parent ); ?> h5 + hr.bs-divider,
<?php echo esc_attr( $content_parent ); ?> h4 + hr.bs-divider,
<?php echo esc_attr( $content_parent ); ?> h3 + hr.bs-divider,
<?php echo esc_attr( $content_parent ); ?> h2 + hr.bs-divider,
<?php echo esc_attr( $content_parent ); ?> h1 + hr.bs-divider{
	margin-top: 28px;
}


/**
* ->Buttons
**/
<?php echo esc_attr( $content_parent ); ?> .btn {
	background: <?php echo esc_attr( $highlight_color ); ?>;
	border: none;
	color: #fff;
	border-radius: 0;
	outline: none;
	height: 32px;
	line-height: 32px;
	padding: 0 12px;
	vertical-align: middle;
	text-transform: uppercase <?php echo esc_attr( $important ); ?>;
	-webkit-transition: all .3s ease;
	-moz-transition: all .3s ease;
	-o-transition: all .3s ease;
	transition: all .3s ease;
	text-decoration: none <?php echo esc_attr( $important );?>;
}
<?php echo esc_attr( $content_parent ); ?> .btn:focus,
<?php echo esc_attr( $content_parent ); ?> .btn:hover {
	background: <?php echo esc_attr( $highlight_color ); ?>;
	color: #fff;
	opacity: 0.9;
}
<?php echo esc_attr( $content_parent ); ?> .btn[data-mce-selected]{
	margin: 0 !important;
	box-shadow: none !important;
}
<?php echo esc_attr( $content_parent ); ?> .btn.btn-lg{
	height: 57px;
	line-height: 57px;
	padding: 0 30px;
}
<?php echo esc_attr( $content_parent ); ?> .btn.btn-xs{
	height: 47px;
	line-height: 47px;
	padding: 0 20px;
}
<?php echo esc_attr( $content_parent ); ?> .btn.btn-light {
	background: #FFF;
	border:1px solid #D4D4D4;
	color: #9C9C9C <?php echo esc_attr( $important );?>;
	font-family: "Open Sans", Helvetica, sans-serif;
	font-size: 12px;
	height: auto;
	padding: 0 13px;
}
<?php echo esc_attr( $content_parent ); ?> .btn.btn-light:hover,.btn.btn-light.hover {
	border-color: #868686;
	color: #868686 <?php echo esc_attr( $important );?>;
}
<?php echo esc_attr( $content_parent ); ?> .btn.btn-light[disabled] {
	border-color: #EAEAEA;
	color: #EAEAEA;
}


/**
* ->Text Padding
**/
<?php echo esc_attr( $content_parent ); ?> .bs-padding-1-1{
	margin-left: 5%;
	margin-right: 5%;
}
<?php echo esc_attr( $content_parent ); ?> .bs-padding-0-1{
	margin-right: 5%;
}
<?php echo esc_attr( $content_parent ); ?>.rtl .bs-padding-0-1{
	margin-right: auto;
	margin-left: 5%;
}
<?php echo esc_attr( $content_parent ); ?> .bs-padding-1-0{
	margin-left: 5%;
}
<?php echo esc_attr( $content_parent ); ?>.rtl .bs-padding-1-0{
	margin-left: auto;
	margin-right: 5%;
}
<?php echo esc_attr( $content_parent ); ?> .bs-padding-2-2{
	margin-left: 10%;
	margin-right: 10%;
}
<?php echo esc_attr( $content_parent ); ?> .bs-padding-2-1{
	margin-left: 10%;
	margin-right: 5%;
}
<?php echo esc_attr( $content_parent ); ?>.rtl .bs-padding-2-1{
	margin-left: 5%;
	margin-right: 10%;
}
<?php echo esc_attr( $content_parent ); ?> .bs-padding-1-2{
	margin-left: 5%;
	margin-right: 10%;
}
<?php echo esc_attr( $content_parent ); ?>.rtl .bs-padding-1-2{
	margin-left: 10%;
	margin-right: 5%;
}
<?php echo esc_attr( $content_parent ); ?> .bs-padding-0-2{
	margin-right: 10%;
}
<?php echo esc_attr( $content_parent ); ?>.rtl .bs-padding-0-2{
	margin-left: 10%;
	margin-right: auto;
}
<?php echo esc_attr( $content_parent ); ?> .bs-padding-2-0{
	margin-left: 10%;
}
<?php echo esc_attr( $content_parent ); ?>.rtl .bs-padding-2-0{
	margin-left: auto;
	margin-right: 10%;
}
<?php echo esc_attr( $content_parent ); ?> .bs-padding-3-3{
	margin-left: 15%;
	margin-right: 15%;
}
<?php echo esc_attr( $content_parent ); ?> .bs-padding-0-3{
	margin-right: 15%;
}
<?php echo esc_attr( $content_parent ); ?>.rtl .bs-padding-0-3{
	margin-right: auto;
	margin-left: 15%;
}
<?php echo esc_attr( $content_parent ); ?> .bs-padding-3-0{
	margin-left: 15%;
}
<?php echo esc_attr( $content_parent ); ?>.rtl .bs-padding-3-0{
	margin-left: auto;
	margin-right: 15%;
}


/**
* ->Column Text Padding
**/
<?php echo esc_attr( $content_parent ); ?> .bs-shortcode-col.bs-padding-1-1{
	margin-left: 0;
	margin-right: 0;

	padding-left: 5%;
	padding-right: 5%;
}
<?php echo esc_attr( $content_parent ); ?> .bs-shortcode-col.bs-padding-0-1{
	margin-right: 0;
	padding-right: 5%;
}
<?php echo esc_attr( $content_parent ); ?>.rtl .bs-shortcode-col.bs-padding-0-1{
	margin-right: auto;
	padding-right: auto;
	margin-left: 0;
	padding-left: 5%;
}
<?php echo esc_attr( $content_parent ); ?> .bs-shortcode-col.bs-padding-1-0{
	margin-left: 0;
	padding-left: 5%;
}
<?php echo esc_attr( $content_parent ); ?>.rtl .bs-shortcode-col.bs-padding-1-0{
	margin-left: auto;
	padding-left: auto;
	margin-right: 0;
	padding-right: 5%;
}
<?php echo esc_attr( $content_parent ); ?> .bs-shortcode-col.bs-padding-2-2{
	margin-left: 0;
	margin-right: 0;

	padding-left: 10%;
	padding-right: 10%;
}
<?php echo esc_attr( $content_parent ); ?> .bs-shortcode-col.bs-padding-2-1{
	margin-left: 0;
	margin-right: 0;

	padding-left: 10%;
	padding-right: 5%;
}
<?php echo esc_attr( $content_parent ); ?>.rtl .bs-shortcode-col.bs-padding-2-1{
	padding-left: 5%;
	padding-right: 10%;
}
<?php echo esc_attr( $content_parent ); ?> .bs-shortcode-col.bs-padding-1-2{
	margin-left: 0;
	margin-right: 0;

	padding-left: 5%;
	padding-right: 10%;
}
<?php echo esc_attr( $content_parent ); ?>.rtl .bs-shortcode-col.bs-padding-1-2{
	padding-left: 10%;
	padding-right: 5%;
}
<?php echo esc_attr( $content_parent ); ?> .bs-shortcode-col.bs-padding-0-2{
	margin-right: 0;
	padding-right: 10%;
}
<?php echo esc_attr( $content_parent ); ?>.rtl .bs-shortcode-col.bs-padding-0-2{
	margin-right: auto;
	padding-right: auto;
	margin-left: 0;
	padding-left: 10%;
}
<?php echo esc_attr( $content_parent ); ?> .bs-shortcode-col.bs-padding-2-0{
	margin-left: 0;
	padding-left: 10%;
}
<?php echo esc_attr( $content_parent ); ?>.rtl .bs-shortcode-col.bs-padding-2-0{
	margin-left: auto;
	padding-left: auto;
	margin-right: 0;
	padding-right: 10%;
}
<?php echo esc_attr( $content_parent ); ?> .bs-shortcode-col.bs-padding-3-3{
	margin-left: 0;
	margin-right: 0;

	padding-left: 15%;
	padding-right: 15%;
}
<?php echo esc_attr( $content_parent ); ?> .bs-shortcode-col.bs-padding-0-3{
	margin-right: 0;
	padding-right: 15%;
}
<?php echo esc_attr( $content_parent ); ?>.rtl .bs-shortcode-col.bs-padding-0-3{
	margin-right: auto;
	padding-right: auto;
	margin-left: 0;
	padding-left: 15%;
}
<?php echo esc_attr( $content_parent ); ?> .bs-shortcode-col.bs-padding-3-0{
	margin-left: 0;
	padding-left: 15%;
}
<?php echo esc_attr( $content_parent ); ?>.rtl .bs-shortcode-col.bs-padding-3-0{
	margin-left: auto;
	padding-left: auto;
	margin-right: 0;
	padding-right: 15%;
}


/**
* ->List Shortcode
**/
<?php echo esc_attr( $content_parent ); ?> ul.bs-shortcode-list ul,
<?php echo esc_attr( $content_parent ); ?> ul.bs-shortcode-list{
	list-style: none;
	padding-left: 20px;
	overflow: hidden;
}
<?php echo esc_attr( $content_parent ); ?>.rtl ul.bs-shortcode-list ul,
<?php echo esc_attr( $content_parent ); ?>.rtl ul.bs-shortcode-list{
	padding-left: auto;
	padding-right: 20px;
}
<?php echo esc_attr( $content_parent ); ?> ul.bs-shortcode-list ul{
	padding-left: 13px;
}
<?php echo esc_attr( $content_parent ); ?>.rtl ul.bs-shortcode-list ul{
	padding-left: auto;
	padding-right: 13px;
}
<?php echo esc_attr( $content_parent ); ?> ul.bs-shortcode-list li{
	position: relative;
	margin-bottom: 7px;
	padding-left: 25px;
}
<?php echo esc_attr( $content_parent ); ?>.rtl ul.bs-shortcode-list li{
	padding-left: auto;
	padding-right: 25px;
}
<?php echo esc_attr( $content_parent ); ?> ul.bs-shortcode-list li:before{
	width: 25px;
	content: "\f00c";
	display: inline-block;
	font: normal normal normal 14px/1 FontAwesome;
	font-size: inherit;
	text-rendering: auto;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
	position: absolute;
	left: 0;
	top: 6px;
	color: <?php echo esc_attr( $highlight_color ); ?>;
}
<?php echo esc_attr( $content_parent ); ?>.rtl ul.bs-shortcode-list li:before{
	left: auto;
	right: 0;
}
<?php echo esc_attr( $content_parent ); ?> ul.bs-shortcode-list li:empty{
	display: none;
}
<?php echo esc_attr( $content_parent ); ?> ul.bs-shortcode-list.list-style-check li:before{
	content: "\f00c";
}
<?php echo esc_attr( $content_parent ); ?> ul.bs-shortcode-list.list-style-star li:before{
	content: "\f005";
}
<?php echo esc_attr( $content_parent ); ?> ul.bs-shortcode-list.list-style-edit li:before{
	content: "\f044";
}
<?php echo esc_attr( $content_parent ); ?> ul.bs-shortcode-list.list-style-folder li:before{
	content: "\f07b";
}
<?php echo esc_attr( $content_parent ); ?> ul.bs-shortcode-list.list-style-file li:before{
	content: "\f15b";
}
<?php echo esc_attr( $content_parent ); ?> ul.bs-shortcode-list.list-style-heart li:before{
	content: "\f004";
}
<?php echo esc_attr( $content_parent ); ?> ul.bs-shortcode-list.list-style-asterisk li:before{
	content: "\f069";
}

<?php

/***
 *
 * AMP Specific style
 *
 */

if( $is_amp ){ ?>

	<?php echo esc_attr( $content_parent ); ?> *[type='slides']{
		margin-bottom: 28px;
	}

<?php
} else { ?>
	img.wp-more-tag.mce-wp-more {
		background-repeat: no-repeat;
		background-position: top;
		height: 20px;
	}
<?php } ?>
