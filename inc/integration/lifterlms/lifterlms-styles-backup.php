<?php
/**
 * Dynamic LifterLMS CSS.
 *
 * Holds Customizer LifterLMS CSS styles.
 *
 * @package Page Builder Framework
 * @subpackage Integration/LifterLMS
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

function wpbf_do_lifterlms_customizer_css() {

	$primary = ( $val = get_theme_mod( 'page_accent_color' ) ) === '#3ba9d2' ? false : $val;
	$primary = ( $val = get_theme_mod( 'lifterlms_primary_color', '#2295ff' ) ) === '#2295ff' ? $primary : $val;
	$action  = ( $val = get_theme_mod( 'lifterlms_action_color' ) ) === '#f8954f' ? false : $val;
	$accent  = ( $val = get_theme_mod( 'lifterlms_accent_color' ) ) === '#ef476f' ? false : $val;

	if ( $primary ) {

		$primary_dark  = wpbf_lifterlms_adjust_hex( $primary, -0.12 );
		$primary_light = wpbf_lifterlms_adjust_hex( $primary, 0.08 );
		$primary_text  = wpbf_lifterlms_get_luminance( $primary ) > 0.179 ? '#000' : '#fff';

		?>

		/* Primary */

		/* Primary buttons */
		.llms-button-primary {
			background: <?php echo $primary; ?>;
			color: <?php echo $primary_text; ?>;
		}
		.llms-button-primary:hover,
		.llms-button-primary.clicked {
			background: <?php echo $primary_dark; ?>;
			color: <?php echo $primary_text; ?>;
		}
		.llms-button-primary:focus,
		.llms-button-primary:active {
			background: <?php echo $primary_light; ?>;
			color: <?php echo $primary_text; ?>;
		}

		/* Pricing tables */
		.llms-access-plan-title,
		.llms-access-plan .stamp {
			background: <?php echo $primary; ?>;
			color: <?php echo $primary_text; ?>;
		}
		.llms-access-plan.featured .llms-access-plan-featured {
			background: <?php echo $primary_light; ?>;
			color: <?php echo $primary_text; ?>;
		}
		.llms-access-plan.featured .llms-access-plan-content,
		.llms-access-plan.featured .llms-access-plan-footer {
			border-left-color: <?php echo $primary; ?>;
			border-right-color: <?php echo $primary; ?>;
		}
		.llms-access-plan.featured .llms-access-plan-footer {
			border-bottom-color: <?php echo $primary; ?>;
		}

		/* Checkout */
		.llms-checkout-wrapper .llms-form-heading {
			background: <?php echo $primary; ?>;
			color: <?php echo $primary_text; ?>;
		}
		.llms-checkout-section,
		.llms-checkout-wrapper form.llms-login {
			border-color: <?php echo $primary; ?>;
		}
		.llms-form-field.type-radio input[type=radio]:checked+label:before {
			background-image: -webkit-radial-gradient(center,ellipse,<?php echo $primary; ?> 0,<?php echo $primary; ?> 40%,#fafafa 45%);
			background-image: radial-gradient(ellipse at center,<?php echo $primary; ?> 0,<?php echo $primary; ?> 40%,#fafafa 45%);
		}

		/* Notices */
		.llms-notice {
			border-color: <?php echo $primary; ?>;
			background: <?php echo wpbf_lifterlms_hex_to_rgb( $primary, 0.3 ); ?>;
		}

		/* Notifications */
		.llms-notification {
			border-top-color: <?php echo $primary; ?>;
		}

		/* Instructors */
		.llms-instructor-info .llms-instructors .llms-author {
			border-top-color: <?php echo $primary; ?>;
		}

		.llms-instructor-info .llms-instructors .llms-author .avatar {
			background: <?php echo $primary; ?>;
			border-color: <?php echo $primary; ?>;
		}

		/* Advanced quizzes */
		.llms-quiz-ui input.llms-aq-blank {
			color: <?php echo $primary; ?>;
		}
		.llms-quiz-ui input.llms-aq-blank:focus,
		.llms-quiz-ui input.llms-aq-blank:valid {
			border-bottom-color: <?php echo $primary; ?>;
		}
		.llms-quiz-ui .llms-aq-uploader.dragover {
			border-color: <?php echo $primary; ?>;
		}

	<?php } if ( $action ) {

		$action_dark  = wpbf_lifterlms_adjust_hex( $action, -0.12 );
		$action_light = wpbf_lifterlms_adjust_hex( $action, 0.08 );
		$action_text  = wpbf_lifterlms_get_luminance( $action ) > 0.179 ? '#000' : '#fff';

		?>

		/* Action */

		/* Action buttons */
		.llms-button-action {
			background: <?php echo $action; ?>;
			color: <?php echo $action_text; ?>;
		}
		.llms-button-action:hover,
		.llms-button-action.clicked {
			background: <?php echo $action_dark; ?>;
			color: <?php echo $action_text; ?>;
		}
		.llms-button-action:focus,
		.llms-button-action:active {
			background: <?php echo $action_light; ?>;
			color: <?php echo $action_text; ?>;
		}

		/* Pricing tables */
		.llms-access-plan-restrictions a {
			color: <?php echo $action; ?>;
		}
		.llms-access-plan-restrictions a:hover {
			color: <?php echo $action_dark; ?>;
		}

	<?php } if ( $accent ) { ?>

		/* Accent */

		/* Progress bar */
		.llms-progress .progress-bar-complete {
			background-color: <?php echo $accent; ?>;
		}

		/* Icons */
		.llms-widget-syllabus .lesson-complete-placeholder.done,
		.llms-widget-syllabus .llms-lesson-complete.done,
		.llms-lesson-preview.is-complete .llms-lesson-complete,
		.llms-lesson-preview.is-free .llms-lesson-complete {
			color: <?php echo $accent; ?>;
		}
		.llms-lesson-preview .llms-icon-free {
			background: <?php echo $accent; ?>;
		}

		/* Quizzes */
		.llms-question-wrapper ol.llms-question-choices li.llms-choice input:checked+.llms-marker {
			background: <?php echo $accent; ?>;
		}

		/* Advanced quizzes */
		.llms-quiz-ui .llms-aq-scale .llms-aq-scale-range .llms-aq-scale-radio input[type="radio"]:checked + .llms-aq-scale-button {
			background: <?php echo $accent; ?>;
		}
		.llms-quiz-ui ol.llms-question-choices.llms-aq-reorder-list.dragging {
			box-shadow: 0 0 0 3px <?php echo $accent; ?>;
		}
		.llms-quiz-ui ol.llms-question-choices.llms-aq-reorder-list .llms-aq-reorder-item.llms-aq-placeholder {
			border-color: <?php echo $accent; ?>;
		}
		.llms-quiz-ui ol.llms-question-choices.llms-aq-reorder-list .llms-aq-reorder-item.llms-aq-placeholder:last-child {
				border-bottom-color: <?php echo $accent; ?>;
		}

	<?php }

}
add_action( 'wpbf_after_customizer_css', 'wpbf_do_lifterlms_customizer_css', 10 );
