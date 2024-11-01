<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$capability = "edit_plugins";
if(current_user_can($capability) != 1){
    echo '<div class="error"><p><strong>You do not have the permission to edit plugins.<br>If you should have these permissions you need to contact your admin.</strong></p></div>';
exit;
}
if($_GET['tab'] === 'Premium'){

echo '<h2 class="nav-tab-wrapper"><a href="?page=Testimonials&tab=Default" class="nav-tab">Default</a><a href="?page=Testimonials&tab=Premium" class="nav-tab">Premium</a></h2>';
echo '<div class="wrap">
<h2>Buy premium today!</h2>
    <h3>Premium features:</h3>
    <div style="margin-left:50px;">
    <ul style="list-style-type:disc">
        <li>Custom Css</li>
        <li>Google fonts</li>
        <li>Custom colors</li>
        <li>Testimonial slider</li>
        <li>And lots more</li>
    </ul>
    </div>
    <h3>Buy premium <a href="http://plugins.wijzijnmerlin.nl/index.php?pagina=mollie&Buy=true" target="_blank">here</a>.</h3>
</div>';

}else{
if(isset($_POST['testimonialswzm_hidden']) && $_POST['testimonialswzm_hidden'] === 'Y'){
    if ( 
    ! isset( $_POST['testimonialswzm_nonce_field'] ) 
    || ! wp_verify_nonce( $_POST['testimonialswzm_nonce_field'], 'testimonialswzm_action' ) 
) {
   print 'Sorry, your nonce did not verify.';
   exit;
}

$limitpp = intval($_POST['testimonialswzm_limitpp']);
if($limitpp < 1 || $limitpp > 99){
$limitpp = 1;
}
update_option('testimonialswzm_limitpp', $limitpp);
?>
<div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
<?php
}else{
    $limitpp = get_option('testimonialswzm_limitpp');
}
?>
<h2 class="nav-tab-wrapper">
    <a href="?page=Testimonials&tab=Default" class="nav-tab">Default</a>
    <a href="?page=Testimonials&tab=Premium" class="nav-tab">Premium</a>
</h2>
<div class="wrap">
    <?php    echo "<h2>" . __( 'Testimonial Options', 'testimonialswzm_option' ) . "</h2>"; ?>
     
    <form name="testimonialswzm_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <input type="hidden" name="testimonialswzm_hidden" value="Y">
        <?php wp_nonce_field( 'testimonialswzm_action', 'testimonialswzm_nonce_field' ); ?>
        <?php    echo "<h4>" . __( 'Testimonial Settings', 'testimonialswzm_option' ) . "</h4>"; ?>
        <p><?php _e("Testimonials per page: " ); ?><br>
        <input type="text" name="testimonialswzm_limitpp" maxlength="2" value="<?php echo $limitpp; ?>" size="20"><?php _e("Default: 10"); ?><br><br>
        <p class="submit">
        <input type="submit" name="Submit" value="<?php _e('Update Options', 'testimonialswzm_option' ) ?>" />
        </p>
    </form>
</div>
<?php 
}
?>