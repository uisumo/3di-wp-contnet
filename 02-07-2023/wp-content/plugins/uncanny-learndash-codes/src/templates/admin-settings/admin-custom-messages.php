<?php
/**
 * @since   4.0
 * @author  Saad S.
 */
?>
<!-- Custom Messages -->
<div class="uo-admin-section">
	<div class="uo-admin-header">
		<div class="uo-admin-title"><?php esc_html_e( 'Custom messages', 'uncanny-learndash-codes' ); ?></div>
	</div>
	<div class="uo-admin-block">
		<div class="uo-admin-form">

			<div class="uo-admin-field">
				<div class="uo-admin-label"><?php esc_html_e( 'Invalid code', 'uncanny-learndash-codes' ); ?></div>

				<input class="uo-admin-input" type="text"
					   value="<?php if ( null !== $custom_messages ) {
						   echo esc_html( $custom_messages['invalid-code'] );
					   } ?>" name="invalid-code" id="invalid-code"
					   placeholder="<?php esc_html_e( 'Sorry, the code you entered is not valid.', 'uncanny-learndash-codes' ); ?>"/>
			</div>
			<div class="uo-admin-field">
				<div class="uo-admin-label"><?php esc_html_e( 'Expired code', 'uncanny-learndash-codes' ); ?></div>

				<input class="uo-admin-input" type="text"
					   value="<?php if ( null !== $custom_messages && isset( $custom_messages['expired-code'] ) ) {
						   echo esc_html( $custom_messages['expired-code'] );
					   } ?>" name="expired-code" id="expired-code"
					   placeholder="<?php esc_html_e( 'Sorry, the code you entered has expired.', 'uncanny-learndash-codes' ); ?>"/>
			</div>

			<div class="uo-admin-field">
				<div
					class="uo-admin-label"><?php esc_html_e( 'Code already redeemed', 'uncanny-learndash-codes' ); ?></div>

				<input class="uo-admin-input" type="text"
					   value="<?php if ( null !== $custom_messages ) {
						   echo esc_html( $custom_messages['already-redeemed'] );
					   } ?>" name="already-redeemed" id="already-redeemed" class="widefat"
					   placeholder="<?php esc_html_e( 'Sorry, the code you entered is not valid.', 'uncanny-learndash-codes' ); ?>"/>
			</div>
			<div class="uo-admin-field">
				<div
					class="uo-admin-label"><?php esc_html_e( 'Code redeemed maximum times', 'uncanny-learndash-codes' ); ?></div>

				<input class="uo-admin-input" type="text"
					   value="<?php if ( null !== $custom_messages ) {
						   echo esc_html( $custom_messages['redeemed-maximum'] );
					   } ?>" name="redeemed-maximum" id="redeemed-maximum" class="widefat"
					   placeholder="<?php esc_html_e( 'Sorry, the code you entered has already been redeemed maximum times.', 'uncanny-learndash-codes' ); ?>"/>
			</div>

			<div class="uo-admin-field">
				<div
					class="uo-admin-label"><?php esc_html_e( 'Successfully redeemed', 'uncanny-learndash-codes' ); ?></div>
				<?php
				if ( null !== $custom_messages ) {
					$allowed_html = wp_kses_allowed_html( 'post' );
					$success_msg  = wp_kses( $custom_messages['successfully-redeemed'], $allowed_html );
				} else {
					$success_msg = esc_html__( 'Congratulations, the code you entered has successfully been redeemed.', 'uncanny-learndash-codes' );
				}
				wp_editor( $success_msg, 'successfully-redeemed', [
					'textarea_rows' => 5,
					'tabindex'      => 40,
				] );
				?>
			</div>

			<div class="uo-admin-field">
				<input type="submit" name="submit" id="submit" class="uo-admin-form-submit"
					   value="<?php esc_html_e( 'Save Changes', 'uncanny-learndash-codes' ); ?>">
			</div>

		</div>
	</div>
</div>
