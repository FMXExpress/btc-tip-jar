<?php

class Btc_Tip_Jar_User {
	protected $tip_jar;

	private $summary;
	private $deposit;
	private $withdraw;
	private $history;

	public function __construct( $tip_jar ) {
		$this->tip_jar = $tip_jar;

		require_once( 'btc-tip-jar-user-summary.php' );
		$this->summary = new Btc_Tip_Jar_User_Summary( $this );

		require_once( 'btc-tip-jar-user-deposit.php' );
		$this->deposit = new Btc_Tip_Jar_User_Deposit( $this );

		require_once( 'btc-tip-jar-user-withdraw.php' );
		$this->withdraw = new Btc_Tip_Jar_User_Withdraw( $this );

		require_once( 'btc-tip-jar-user-history.php' );
		$this->history = new Btc_Tip_Jar_User_History( $this );

		add_action( 'admin_menu', array( &$this, 'do_menu' ) );

		add_action( 'admin_init', array( &$this, 'do_scripts_and_styles' ) );
	}
	public function do_menu() {

		add_menu_page(
			'Bitcoin Tip Jar',
			'Tip Jar',
			'read',
			get_class(),
			array( &$this->summary, 'do_page' ),
			plugins_url( '../images/btc-tip-jar-16.png', __FILE__ ),
			71
		);

		$summary = add_submenu_page(
			get_class(),
			'Bitcoin Tip Jar - Overview',
			'Overview',
			'read',
			get_class(),
			array( &$this->summary, 'do_page' )
		);

		add_action(
			'admin_print_styles-' . $summary,
			array( &$this, 'print_scripts_and_styles' )
		);

		$deposit = add_submenu_page(
			get_class(),
			'Bitcoin Tip Jar - Deposit Bitcoins',
			'Deposit',
			'read',
			get_class() . '_deposit',
			array( &$this->deposit, 'do_page' )
		);

		add_action(
			'admin_print_styles-' . $deposit,
			array( &$this, 'print_scripts_and_styles' )
		);

		$withdraw = add_submenu_page(
			get_class(),
			'Bitcoin Tip Jar - Withdraw Bitcoins',
			'Withdraw',
			'read',
			get_class() . '_withdraw',
			array( &$this->withdraw, 'do_page' )
		);

		add_action(
			'admin_print_styles-' . $withdraw,
			array( &$this, 'print_scripts_and_styles' )
		);

		$history = add_submenu_page(
			get_class(),
			'Bitcoin Tip Jar - Transaction History',
			'History',
			'read',
			get_class() . '_history',
			array( &$this->history, 'do_page' )
		);

		add_action(
			'admin_print_styles-' . $history,
			array( &$this, 'print_scripts_and_styles' )
		);
	}
	public function do_scripts_and_styles() {
		wp_register_style(
			get_class(),
			plugins_url( '/../styles/btc-tip-jar-admin.css', __FILE__ )
		);
	}
	public function print_scripts_and_styles() {
		wp_enqueue_style( get_class() );
	}
}

?>
