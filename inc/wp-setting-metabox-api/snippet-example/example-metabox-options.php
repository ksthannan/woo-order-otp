<?php
$example_options = array(
	'metabox_title' => 'Example Metabox',
	'metabox_id'    => 'example_metabox',
	'post_type'     => array( 'post', 'page' ),
	'context'       => 'normal',
	'priority'      => 'high',
);

$example_fields = array(
	'hd_text_meta' => array(
		'title'   => 'Text Input',
		'type'    => 'text',
		'desc'    => 'Example Text Input',
		'sanit'   => 'nohtml',
	),
	'hd_textarea_meta' => array(
		'title'   => 'Textarea Input',
		'type'    => 'textarea',
		'desc'    => 'Example Textarea Input',
		'sanit'   => 'nohtml',
	),
	'hd_checkbox_meta' => array(
		'title'   => 'Checkbox Input',
		'type'    => 'checkbox',
		'desc'    => 'Example Checkbox Input',
		'sanit'   => 'nohtml',
	),
	'hd_radio_meta' => array(
		'title'   => 'Radio Input',
		'type'    => 'radio',
		'choices' => array(
			'one'   => 'Option 1',
			'two'   => 'Option 2',
			'three' => 'Option 3'
		),
		'desc'    => 'Example Radio Input',
		'sanit'   => 'nohtml',
	),
	'hd_select_meta' => array(
		'title'   => 'Select Input',
		'type'    => 'select',
		'choices' => array(
			'one'   => 'Option 1',
			'two'   => 'Option 2',
			'three' => 'Option 3'
		),
		'desc'    => 'Example Select Input',
		'sanit'   => 'nohtml',
	),
	'hd_multiselect_meta' => array(
		'title'   => 'Multi Select Input',
		'type'    => 'select',
		'choices' => array(
			'one'   => 'Option 1',
			'two'   => 'Option 2',
			'three' => 'Option 3'
		),
		'multiple' => true,
		'desc'     => 'Example Multi Select Input',
		'sanit'    => 'nohtml',
	),
	'hd_multicheck_meta' => array(
		'title'   => 'Multi Checkbox Input',
		'type'    => 'multicheck',
		'choices' => array(
			'one'   => 'Option 1',
			'two'   => 'Option 2',
			'three' => 'Option 3'
		),
		'desc'    => 'Example Multi Checkbox Input',
		'sanit'   => 'nohtml',
	),
	'hd_upload_meta' => array(
		'title'   => 'Upload Input',
		'type'    => 'upload',
		'desc'    => 'Example Upload Input',
		'sanit'   => 'url',
	),
	'hd_color_meta' => array(
		'title'   => 'Color Input',
		'type'    => 'color',
		'desc'    => 'Example Color Input',
		'sanit'   => 'color',
	),
	'hd_editor_meta' => array(
		'title'   => 'Editor Input',
		'type'    => 'editor',
		'desc'    => 'Example Editor Input',
		'sanit'   => 'nohtml',
	),
);

$example_metabox = new HD_WP_Metabox_API( $example_options, $example_fields );