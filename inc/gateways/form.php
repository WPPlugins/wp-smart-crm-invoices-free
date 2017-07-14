<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$customer=$_GET['customer'];
$token=$_POST['stripeToken'];

if($form="new")
    {
        $email=$_POST['stripeEmail'];
        $name=$_POST['stripeBillingName'];
        $address=$_POST['stripeBillingAddressLine1'];
        $town=$_POST['stripeBillingAddressCity'];
        $name=explode(" ",$name);
        $first_name=$name[0];
        $k=array_shift($name);
        $last_name=implode(' ', $name);
?>
    <form id="CRM_newCustomer">
        <h2><?php _e('Confirm your data','WPsmartcrm')?></h2>
        <label><?php _e('First Name','WPsmartcrm')?></label><input type="text" id="CRM_firstname" name="CRM_firstname" value="<?php echo $first_name ?>" required /><br />
        <label><?php _e('Last Name','WPsmartcrm')?></label><input type="text" id="CRM_lastname" name="CRM_lastname" value="<?php echo $last_name ?>" required/><br />
        <label><?php _e('Email','WPsmartcrm')?></label><input type="email" id="CRM_email" name="CRM_email" value="<?php echo $email ?>" required /><br />
        <label><?php _e('Address','WPsmartcrm')?></label><input type="text" name="CRM_address" value="<?php echo $address ?>"/><br />
        <label><?php _e('Town','WPsmartcrm')?></label><input type="text" name="CRM_town" value="<?php echo $town ?>"/><br />
        <label><?php _e('Customer Type','WPsmartcrm')?></label><label><?php _e('Private','WPsmartcrm')?></label><input type="radio" name="CRM_client_type" value="privato" />
        <label><?php _e('Business','WPsmartcrm')?></label><input type="radio" name="CRM_client_type" value="azienda"/><br />
        <label>C.F.</label><input type="text" id="CRM_client_CF" name="CRM_client_CF" /><br />
        <label><?php _e('VAT code','WPsmartcrm')?></label><input type="text" id="CRM_client_IVA" name="CRM_client_IVA" /><br />
        <hr />
        <label><?php _e('Choose a username','WPsmartcrm')?></label><input name="CRM_username" type="text" />
        <label><?php _e('Choose a Password','WPsmartcrm')?></label><input type="password" name="CRM_password" id="CRM_password" />
        <button type="submit"><?php _e('Confirm','WPsmartcrm')?></button>
    </form>
<script>
    jQuery(document).ready(function ($) {

        $("#CRM_password").strength({
            strengthClass: 'strength',
            strengthMeterClass: 'strength_meter',
            strengthButtonClass: 'button_strength',
            strengthButtonText: 'Show password',
            strengthButtonTextToggle: 'Hide Password'
        });

    });
</script>
    <?php
    }
else{
    
}