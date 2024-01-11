<?php
class PG_AdminFunctions {
	
	function __construct() {
		add_action( 'wp_enqueue_scripts', array($this, 'front_enqueue_styles') );
		add_action( 'admin_enqueue_scripts', array($this, 'enqueue_styles') );
		add_action( 'admin_menu', array($this, 'pg_admin_menu') );
		add_shortcode('comics', array($this, 'comics') );
	}

	function enqueue_styles() {
		global $pagenow;
		if ( $pagenow == "admin.php" ){
			if ( $_GET['page'] == "pg_admin_menu" ){
				wp_enqueue_style( 'plugin-admin-css', PG_PLUGIN . 'assets/css/admin-css.css', array(), 1.0, 'all' );
				wp_enqueue_style( 'front-end-css', PG_PLUGIN . 'assets/css/front-css.css', array(), 1.0, 'all' );
			}
		}
	}

	function front_enqueue_styles(){
		wp_enqueue_style( 'front-end-css', PG_PLUGIN . 'assets/css/front-css.css', array(), 1.0, 'all' );
	}

	function pg_admin_menu(){
		add_menu_page( PG_NAME , PG_NAME , 'manage_options', 'pg_admin_menu',array($this, 'pg_pagesetting'),'dashicons-smiley',200);
	}

	function pg_pagesetting(){
		global $pagenow;

		if (array_key_exists('api_btn',$_POST)){
			update_option('public_key', $_POST['public_key']); 
			update_option('private_key', $_POST['private_key']);  ?>
			<div id="setting-error-settings-update" class="updated settings-error notice is-dismissible"><strong>Settings have been saved.</strong></div>
		<?php }
		$public_key = get_option('public_key', '');
		$private_key = get_option('private_key', ''); ?>

		<div class="row">
			<h2><?php echo PG_NAME; ?> - Settings</h2>
			<ul class="info_list">
				<li><p class="info">To show Comics use the shortcode below on any page.<shortcode>[comics]</shortcode></p></li>
				<li><p class="info">Following attributes can be used with short code:</p>
					<ul class="info_list">
						<li><p class="info">cid - Unique ID of the character to show comics of. Unique ID can be lookedup using Marvel API.</p></li>
					</ul>
				</li>
				<li><p class="info">Short Code</p></li>
				<li><p class="info"><shortcode>[comics]</shortcode> Shows comics </p></li>
				<li><p class="info"><shortcode>[comics cid=1009351]</shortcode></p></li>
				<li><p class="info">Few Character Ids are as follow;</p>
					<ul>
						<li><p class="info">Spider-Man (Peter Parker) ID ; 1009610</p></li>
						<li><p class="info">Deadpool ID ; 1009268</p></li>
						<li><p class="info">Iron Man ID ; 1009368</p></li>
						<li><p class="info">Thor ID ; 1009664</p></li>
						<li><p class="info">Hulk ID ; 1009351</p></li>
					</ul>
				</li>
			</ul>
			<p class="info"><i>By default if no cid is given it will show comics of Spider-Man (Peter Parker).</i></p>
		</div>

		<form method="post" action="">
			<fieldset>
				<div class="form-group">
					<label for="public_key">Your public key</label>
					<input type="text" name="public_key" class="large-text1 form-control" value="<?php echo $public_key; ?>" />
				</div>
				<div class="form-group">
					<label for="private_key">Your private key</label>
					<input type="text" name="private_key" class="large-text1 form-control" value="<?php echo $private_key; ?>" />
				</div>
				<div class="form-group">
					<input type="submit" name="api_btn" class="button button-primary" value="Update Settings" />
				</div>
			</fieldset>
		</form>

		<?php
	}

	// Add Shortcode
	function comics( $atts ) {
		$public_key = get_option('public_key', '');
		$private_key = get_option('private_key', '');

		// Attributes
		$atts = shortcode_atts(
			array(
				'cid' => '1009610',
			),
			$atts
		);
		$cid = $atts['cid'];

		$Comic = '';
		$Comic .= 'Marvel Comics';
		include( "api.php" );

		$Comic = $Comics;
		return $Comic;
	}
}

if ( class_exists( 'PG_AdminFunctions' ) ) {
    $PG_AdminFunctions = new PG_AdminFunctions();
}
?>
