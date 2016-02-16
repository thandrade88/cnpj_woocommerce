<?php


/**
 * Add new register fields for WooCommerce registration.
 *
 * @return string Register fields HTML.
 */
function wooc_extra_register_fields() {
    ?>

    <p class="form-row form-row-wide">
    <label for="reg_billing_cnpj"><?php _e( 'CNPJ', 'woocommerce' ); ?> <span class="required">*</span></label>
    <input type="text" class="input-text" name="billing_cnpj" id="reg_billing_cnpj" value="<?php if ( ! empty( $_POST['billing_cnpj'] ) ) esc_attr_e( $_POST['billing_cnpj'] ); ?>"/>
    <span class="erro-cnpj" style="display:none; color:red; float:right;"> CNPJ Inválido!</span>
    </p>


    <?php
}

add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );


/**
 * Validate the extra register fields.
 *
 * @param  string $cnpj          Current cnpj.
 * @param  object $validation_errors WP_Error object.
 *
 * @return void
 */
function wooc_validate_extra_register_fields( $cnpj, $validation_errors ) {
    if ( isset( $_POST['billing_cnpj'] ) && empty( $_POST['billing_cnpj'] ) ) {
        $validation_errors->add( 'billing_cnpj_error', __( '<strong>Error</strong>: First name is required!', 'woocommerce' ) );
    }

}

add_action( 'woocommerce_register_post', 'wooc_validate_extra_register_fields' );


/**
 * Save the extra register fields.
 *
 * @param  int  $customer_id Current customer ID.
 *
 * @return void
 */
function wooc_save_extra_register_fields( $customer_id ) {
    if ( isset( $_POST['billing_cnpj'] ) ) {
        // WordPress cnpj field.
        update_user_meta( $customer_id, 'cnpj', sanitize_text_field( $_POST['billing_cnpj'] ) );

        // WooCommerce billing cnpj.
        update_user_meta( $customer_id, 'billing_cnpj', sanitize_text_field( $_POST['billing_cnpj'] ) );
    }

}

add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );

?>
