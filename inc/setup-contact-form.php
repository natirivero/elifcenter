<?php
/**
 * One-time setup: Elif Center contact form for Fluent Forms.
 *
 * Run via: studio wp eval 'require get_stylesheet_directory() . "/inc/setup-contact-form.php";'
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use FluentForm\App\Helpers\Helper;
use FluentForm\App\Models\FormMeta;
use FluentForm\App\Services\Form\FormService;

if ( ! function_exists( 'fluentFormMix' ) ) {
	echo "Fluent Forms is not active.\n";
	return;
}

$form_service = new FormService();

$existing = fluentFormApi( 'forms' )->forms(
	array(
		'search'   => 'Contacto Elif Center',
		'per_page' => 1,
	)
);

if ( ! empty( $existing['data'] ) ) {
	$form_id = (int) $existing['data'][0]['id'];
	echo "Form already exists with ID {$form_id}.\n";
} else {
	$form = $form_service->store(
		array(
			'type'       => 'form',
			'predefined' => 'blank_form',
		)
	);

	$form_id = (int) $form->id;

	$uniq = static function (): string {
		return 'el_' . str_replace( '.', '', (string) microtime( true ) );
	};

	$required = static function ( string $message ): array {
		return array(
			'required' => array(
				'value'   => true,
				'message' => $message,
				'global'  => true,
			),
		);
	};

	$text_field = static function (
		int $index,
		string $name,
		string $label,
		string $placeholder,
		string $container_class,
		array $validation,
		string $uniq_key
	): array {
		return array(
			'index'          => $index,
			'element'        => 'input_text',
			'attributes'     => array(
				'type'        => 'text',
				'name'        => $name,
				'value'       => '',
				'class'       => '',
				'placeholder' => $placeholder,
				'maxlength'   => '',
			),
			'settings'       => array(
				'container_class'  => $container_class,
				'label'              => $label,
				'label_placement'    => '',
				'admin_field_label'  => $label,
				'help_message'       => '',
				'validation_rules'   => $validation,
				'conditional_logics' => array(
					'type'       => 'any',
					'status'     => false,
					'conditions' => array(
						array(
							'field'    => '',
							'value'    => '',
							'operator' => '',
						),
					),
				),
			),
			'editor_options' => array(
				'title'      => 'Simple Text',
				'icon_class' => 'ff-edit-text',
				'template'   => 'inputText',
			),
			'uniqElKey'      => $uniq_key,
		);
	};

	$fields = array(
		$text_field(
			0,
			'nombre',
			'Nombre',
			'Tu nombre completo',
			'form-field',
			$required( 'El nombre es obligatorio.' ),
			$uniq()
		),
		$text_field(
			1,
			'empresa',
			'Empresa',
			'Nombre del centro o salón',
			'form-field',
			array(),
			$uniq()
		),
		array(
			'index'          => 2,
			'element'        => 'input_email',
			'attributes'     => array(
				'type'        => 'email',
				'name'        => 'email',
				'value'       => '',
				'id'          => '',
				'class'       => '',
				'placeholder' => 'tu@correo.com',
			),
			'settings'       => array(
				'container_class'  => 'form-field',
				'label'              => 'Email',
				'label_placement'    => '',
				'admin_field_label'  => 'Email',
				'help_message'       => '',
				'validation_rules'   => array_merge(
					$required( 'El email es obligatorio.' ),
					array(
						'email' => array(
							'value'   => true,
							'message' => 'Introduce un email válido.',
							'global'  => true,
						),
					)
				),
				'conditional_logics' => array(),
			),
			'editor_options' => array(
				'title'      => 'Email Address',
				'icon_class' => 'ff-edit-email',
				'template'   => 'inputText',
			),
			'uniqElKey'      => $uniq(),
		),
		$text_field(
			3,
			'telefono',
			'Teléfono',
			'+51 9XX XXX XXX',
			'form-field',
			array(),
			$uniq()
		),
		array(
			'index'          => 4,
			'element'        => 'select',
			'attributes'     => array(
				'name'  => 'tipo_negocio',
				'value' => '',
				'id'    => '',
				'class' => '',
			),
			'settings'       => array(
				'label'              => 'Tipo de negocio',
				'help_message'       => '',
				'container_class'  => 'form-field wide',
				'label_placement'    => '',
				'placeholder'        => 'Selecciona una opción',
				'validation_rules'   => array(),
				'conditional_logics' => array(),
			),
			'options'        => array(
				'Spa'                    => 'Spa',
				'Salón'                  => 'Salón',
				'Clínica estética'       => 'Clínica estética',
				'Cosmetóloga'            => 'Cosmetóloga',
				'Emprendedora beauty'    => 'Emprendedora beauty',
				'Centro de depilación'   => 'Centro de depilación',
			),
			'editor_options' => array(
				'title'      => 'Dropdown',
				'icon_class' => 'ff-edit-dropdown',
				'element'    => 'select',
				'template'   => 'select',
			),
			'uniqElKey'      => $uniq(),
		),
		array(
			'index'          => 5,
			'element'        => 'textarea',
			'attributes'     => array(
				'name'        => 'mensaje',
				'value'       => '',
				'id'          => '',
				'class'       => '',
				'placeholder' => 'Cuéntanos qué equipo o servicio te interesa, qué tipo de cabina manejas y tu cronograma estimado.',
				'rows'        => 4,
				'cols'        => 2,
			),
			'settings'       => array(
				'container_class'  => 'form-field wide',
				'label'              => 'Mensaje',
				'admin_field_label'  => 'Mensaje',
				'label_placement'    => '',
				'help_message'       => '',
				'validation_rules'   => $required( 'El mensaje es obligatorio.' ),
				'conditional_logics' => array(
					'type'       => 'any',
					'status'     => false,
					'conditions' => array(
						array(
							'field'    => '',
							'value'    => '',
							'operator' => '',
						),
					),
				),
			),
			'editor_options' => array(
				'title'      => 'Text Area',
				'icon_class' => 'ff-edit-textarea',
				'template'   => 'inputTextarea',
			),
			'uniqElKey'      => $uniq(),
		),
		array(
			'index'          => 6,
			'element'        => 'turnstile',
			'attributes'     => array(
				'name' => 'cf-turnstile-response',
			),
			'settings'       => array(
				'label'              => '',
				'label_placement'    => '',
				'container_class'  => 'form-field wide',
				'validation_rules' => array(),
			),
			'editor_options' => array(
				'title'      => 'Turnstile',
				'icon_class' => 'ff-edit-recaptha',
				'template'   => 'turnstile',
			),
			'uniqElKey'      => $uniq(),
		),
	);

	$form_fields = array(
		'fields'       => $fields,
		'submitButton' => array(
			'uniqElKey'      => $uniq(),
			'element'        => 'button',
			'attributes'     => array(
				'type'  => 'submit',
				'class' => 'btn btn-primary',
			),
			'settings'       => array(
				'align'            => 'left',
				'button_style'     => 'default',
				'container_class'  => 'form-submit',
				'help_message'     => '',
				'background_color' => '#1a7efb',
				'button_size'      => 'md',
				'color'            => '#ffffff',
				'button_ui'        => array(
					'type'     => 'default',
					'text'     => 'Enviar mensaje',
					'img_url'  => '',
				),
			),
			'editor_options' => array(
				'title' => 'Submit Button',
			),
		),
	);

	$form_service->update(
		array(
			'form_id'    => $form_id,
			'title'      => 'Contacto Elif Center',
			'status'     => 'published',
			'formFields' => wp_json_encode( $form_fields ),
		)
	);

	Helper::setFormMeta(
		$form_id,
		'notifications',
		array(
			'name'           => 'Notificación comercial',
			'sendTo'         => array(
				'type'    => 'email',
				'email'   => 'elifcenterperu@gmail.com',
				'field'   => 'email',
				'routing' => array(
					array(
						'email'    => null,
						'field'    => null,
						'operator' => '=',
						'value'    => null,
					),
				),
			),
			'fromName'       => 'Elif Center Perú',
			'fromEmail'      => '',
			'replyTo'        => '{inputs.email}',
			'bcc'            => '',
			'subject'        => '[Contacto] Nueva consulta de {inputs.nombre}',
			'message'        => '<p>{all_data}</p><p>Enviado desde: {embed_post.permalink}</p>',
			'conditionals'   => array(
				'status'     => false,
				'type'       => 'all',
				'conditions' => array(
					array(
						'field'    => null,
						'operator' => '=',
						'value'    => null,
					),
				),
			),
			'enabled'        => true,
			'email_template' => '',
		)
	);

	Helper::setFormMeta(
		$form_id,
		'formSettings',
		array(
			'confirmation' => array(
				'redirectTo'           => 'samePage',
				'messageToShow'        => 'Gracias por escribirnos. Nuestro equipo comercial te contactará en menos de 24 horas hábiles.',
				'customPage'           => null,
				'samePageFormBehavior' => 'hide_form',
				'customUrl'            => null,
			),
			'restrictions' => array(
				'limitNumberOfEntries' => array(
					'enabled'         => false,
					'numberOfEntries' => null,
					'period'          => 'total',
					'limitReachedMsg' => 'Maximum number of entries exceeded.',
				),
				'scheduleForm'         => array(
					'enabled'    => false,
					'start'      => null,
					'end'        => null,
					'pendingMsg' => 'Form submission is not started yet.',
					'expiredMsg' => 'Form submission is now closed.',
				),
				'requireLogin'         => array(
					'enabled'         => false,
					'requireLoginMsg' => 'You must be logged in to submit the form.',
				),
				'denyEmptySubmission'  => array(
					'enabled' => false,
					'message' => 'Sorry, you cannot submit an empty form.',
				),
			),
			'layout'       => array(
				'labelPlacement'         => 'top',
				'helpMessagePlacement'   => 'with_label',
				'errorMessagePlacement'  => 'inline',
				'asteriskPlacement'      => 'asterisk-right',
			),
		)
	);

	Helper::setFormMeta( $form_id, '_primary_email_field', 'email' );

	// Cloudflare Turnstile test keys (always pass). Replace in Fluent Forms > Settings > Turnstile
	// with your production Site Key and Secret Key before going live.
	update_option(
		'_fluentform_turnstile_details',
		array(
			'siteKey'    => '1x00000000000000000000AA',
			'secretKey'  => '1x0000000000000000000000000000000AA',
			'invisible'  => 'no',
			'appearance' => 'always',
			'theme'      => 'auto',
		),
		'no'
	);
	update_option( '_fluentform_turnstile_keys_status', true, 'no' );

	echo "Created contact form with ID {$form_id}.\n";
}

update_option( 'elif_center_contact_form_id', $form_id, false );
echo "Stored option elif_center_contact_form_id = {$form_id}.\n";
