<?php

$fields['_style_options']                = array(
	'name' => __( 'Style', 'better-studio' ),
	'id'   => '_style_options',
	'type' => 'tab',
	'icon' => 'bsai-paint',
);
$fields['_bs_review_enabled']            = array(
	'name'      => __( 'Enable Review', 'better-studio' ),
	'id'        => '_bs_review_enabled',
	'type'      => 'switch',
	'on-label'  => __( 'Enable', 'better-studio' ),
	'off-label' => __( 'Disable', 'better-studio' ),
	'desc'      => __( 'Enabling this will adds review box to post', 'better-studio' ),
);
$fields['_bs_review_pos']                = array(
	'name'    => __( 'Review Box Position', 'better-studio' ),
	'id'      => '_bs_review_pos',
	'type'    => 'select',
	'desc'    => __( 'Chose position of review box on page. <br> For showing review box between post texts you should chose "<code>Do Not Display</code>" and use <br>"<code>[better-reviews]</code>" shrotcode.', 'better-studio' ),
	'options' => array(
		'none'       => __( 'Do Not Display', 'better-studio' ),
		'top'        => __( 'Top', 'better-studio' ),
		'bottom'     => __( 'Bottom', 'better-studio' ),
		'top-bottom' => __( 'Top & Bottom', 'better-studio' ),
	)
);
$fields['_bs_review_rating_type']        = array(
	'name'          => __( 'Rating Style', 'better-studio' ),
	'desc'          => __( 'Chose style of review', 'better-studio' ),
	'id'            => '_bs_review_rating_type',
	'type'          => 'image_radio',
	'section_class' => 'style-floated-left bordered',
	'options'       => array(
		'stars'      => array(
			'img'   => Better_Reviews::dir_url() . 'img/review-star.png',
			'label' => __( 'Stars', 'better-studio' ),
		),
		'percentage' => array(
			'img'   => Better_Reviews::dir_url() . 'img/review-bar.png',
			'label' => __( 'Percentage', 'better-studio' ),
		),
		'points'     => array(
			'img'   => Better_Reviews::dir_url() . 'img/review-point.png',
			'label' => __( 'Points', 'better-studio' ),
		)
	)
);
$fields[]                                = array(
	'name'  => __( 'Review Box Padding', 'better-studio' ),
	'type'  => 'group',
	'state' => 'close',
);
$fields['_bs_review_box_padding_top']    = array(
	'name'   => __( 'Review Box Top Padding', 'better-studio' ),
	'id'     => '_bs_review_box_padding_top',
	'suffix' => __( 'Pixel', 'better-studio' ),
	'desc'   => __( 'In pixels without px, ex: 20. <br>Leave empty for default value.', 'better-studio' ),
	'type'   => 'text',
);
$fields['_bs_review_box_padding_bottom'] = array(
	'name'   => __( 'Review Box Bottom Padding', 'better-studio' ),
	'id'     => '_bs_review_box_padding_bottom',
	'suffix' => __( 'Pixel', 'better-studio' ),
	'desc'   => __( 'In pixels without px, ex: 20. <br>Leave empty for default value.', 'better-studio' ),
	'type'   => 'text',
);
$fields['_bs_review_box_padding_left']   = array(
	'name'   => __( 'Review Box Left Padding', 'better-studio' ),
	'id'     => '_bs_review_box_padding_left',
	'suffix' => __( 'Pixel', 'better-studio' ),
	'desc'   => __( 'In pixels without px, ex: 20. <br>Leave empty for default value.', 'better-studio' ),
	'type'   => 'text',
);
$fields['_bs_review_box_padding_right']  = array(
	'name'   => __( 'Review Box Right Padding', 'better-studio' ),
	'suffix' => __( 'Pixel', 'better-studio' ),
	'id'     => '_bs_review_box_padding_right',
	'desc'   => __( 'In pixels without px, ex: 20. <br>Leave empty for default value.', 'better-studio' ),
	'type'   => 'text',
);


/**
 * => Verdict Options
 */
$fields['_verdict_options']           = array(
	'name' => __( 'Verdict', 'better-studio' ),
	'id'   => '_verdict_options',
	'type' => 'tab',
	'icon' => 'bsai-verdict',
);
$fields['_bs_review_heading']         = array(
	'name' => __( 'Heading', 'better-studio' ),
	'id'   => '_bs_review_heading',
	'type' => 'text',
	'desc' => __( 'Optional title for review box', 'better-studio' ),
);
$fields['_bs_review_verdict']         = array(
	'name' => __( 'Verdict', 'better-studio' ),
	'id'   => '_bs_review_verdict',
	'type' => 'text',
	'desc' => __( '1 or 2 word for overall verdict. ex: Awesome', 'better-studio' ),
);
$fields['_bs_review_verdict_summary'] = array(
	'name' => __( 'Verdict Description - Top', 'better-studio' ),
	'desc' => __( 'Verdict description that will be shown on top of criteria', 'better-studio' ),
	'id'   => '_bs_review_verdict_summary',
	'type' => 'textarea',
);
$fields['_bs_review_extra_desc']      = array(
	'name' => __( 'Verdict Description - Bottom', 'better-studio' ),
	'desc' => __( 'Verdict description that will be shown under criteria', 'better-studio' ),
	'id'   => '_bs_review_extra_desc',
	'type' => 'textarea',
);


/**
 * => Criteria Options
 */
$fields['_criteria_options']   = array(
	'name' => __( 'Criteria', 'better-studio' ),
	'id'   => '_criteria_options',
	'type' => 'tab',
	'icon' => 'bsai-list-bullet',
);
$fields['_bs_review_criteria'] = array(
	'name'          => __( 'Criteria', 'better-studio' ),
	'id'            => '_bs_review_criteria',
	'type'          => 'repeater',
	'add_label'     => '<i class="fa fa-plus"></i> ' . __( 'Add Criterion', 'better-studio' ),
	'delete_label'  => __( 'Delete Criterion', 'better-studio' ),
	'item_title'    => __( 'Criterion', 'better-studio' ),
	'section_class' => 'full-with-both',
	'std'           => array(
		array(
			'label' => __( 'Design', 'better-studio' ),
			'rate'  => '8',
		)
	),
	'default'       => array(
		array(
			'label' => __( 'Design', 'better-studio' ),
			'rate'  => '8',
		)
	),
	'options'       => array(
		'label' => array(
			'name'          => __( 'Label', 'better-studio' ),
			'id'            => 'label',
			'std'           => '',
			'type'          => 'text',
			'section_class' => 'full-with-both bs-review-field-label',
			'repeater_item' => TRUE
		),
		'rate'  => array(
			'name'          => __( 'Rating / 10', 'better-studio' ),
			'id'            => 'rate',
			'type'          => 'text',
			'std'           => '',
			'section_class' => 'full-with-both bs-review-field-rating',
			'repeater_item' => TRUE,
		),
	)
);

