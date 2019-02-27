<?php


$fields['_bs_review_enabled']            = array(
	'std' => '0',
);
$fields['_bs_review_pos']                = array(
	'std' => 'bottom',
);
$fields['_bs_review_rating_type']        = array(
	'std' => 'stars',
);
$fields['_bs_review_box_padding_top']    = array(
	'std' => '',
);
$fields['_bs_review_box_padding_bottom'] = array(
	'std' => '',
);
$fields['_bs_review_box_padding_left']   = array(
	'std' => '',
);
$fields['_bs_review_box_padding_right']  = array(
	'std' => '',
);


/**
 * => Verdict Options
 */
$fields['_bs_review_heading']         = array(
	'std' => '',
);
$fields['_bs_review_verdict']         = array(
	'std' => __( 'Awesome', 'better-studio' ),
);
$fields['_bs_review_verdict_summary'] = array(
	'std' => '',
);
$fields['_bs_review_extra_desc']      = array(
	'std' => '',
);


/**
 * => Criteria Options
 */
$fields['_bs_review_criteria'] = array(
	'save-std' => TRUE,
	'std'      => array(
		array(
			'label' => __( 'Design', 'better-studio' ),
			'rate'  => '8',
		)
	),
	'default'  => array(
		array(
			'label' => __( 'Design', 'better-studio' ),
			'rate'  => '8',
		)
	),
);

