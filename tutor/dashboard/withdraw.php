<?php

/**
 * @package TutorLMS/Templates
 * @version 1.7.5
 * @theme-version 3.4.1
 */

use \TUTOR\Input;
use \Tutor\Models\WithdrawModel;

defined('ABSPATH') || exit;

$per_page     = tutor_utils()->get_option('statement_show_per_page', 20);
$current_page = Input::get('current_page', 1, Input::TYPE_INT);
$offset       = (abs($current_page) - 1) * $per_page;

$min_withdraw                  = tutor_utils()->get_option('min_withdraw_amount');
$formatted_min_withdraw_amount = tutor_utils()->tutor_price($min_withdraw);

$saved_account        = WithdrawModel::get_user_withdraw_method();
$withdraw_method_name = tutor_utils()->avalue_dot('withdraw_method_name', $saved_account);

$user_id         = get_current_user_id();
$withdraw_status = array(
	WithdrawModel::STATUS_PENDING,
	WithdrawModel::STATUS_APPROVED,
	WithdrawModel::STATUS_REJECTED,
);
$all_histories		= WithdrawModel::get_withdrawals_history($user_id, array('status' => $withdraw_status), $offset, $per_page);
$image_base			= tutor()->url . '/assets/images/';

$method_icons = array(
	'bank_transfer_withdraw' => $image_base . 'icon-bank.svg',
	'echeck_withdraw'        => $image_base . 'icon-echeck.svg',
	'paypal_withdraw'        => $image_base . 'icon-paypal.svg',
);

$status_message = array(
	'rejected' => __('Please contact the site administrator for more information.', 'edumall-child'),
	'pending'  => __('Withdrawal request is pending for approval, please hold tight.', 'edumall-child'),
);

$currency_symbol = '';
if (function_exists('get_woocommerce_currency_symbol')) {
	$currency_symbol = get_woocommerce_currency_symbol();
} elseif (function_exists('edd_currency_symbol')) {
	$currency_symbol = edd_currency_symbol();
}

$summary_data 						= WithdrawModel::get_withdraw_summary($user_id);
// $summary_data                         = Edumall_Tutor::instance()->get_withdraw_summary($user_id);
$is_balance_sufficient				= $summary_data->available_for_withdraw >= $min_withdraw;
$available_for_withdraw_formatted	= tutor_utils()->tutor_price($summary_data->available_for_withdraw);
$current_balance_formated 			= tutor_utils()->tutor_price($summary_data->current_balance);
?>
<div class="tutor-dashboard-content-inner">

	<div class="dashboard-content-box withdraw-page-current-balance">
		<h4 class="dashboard-content-box-title"><?php esc_html_e('Withdrawal', 'edumall-child'); ?></h4>

		<div class="withdraw-balance-row">
			<p class="withdraw-balance-col">
				<?php echo sprintf(esc_html__('Current Balance is %s', 'edumall-child'), $current_balance_formated); ?>
				<br />
				<?php if ($is_balance_sufficient) : ?>
					<?php echo sprintf(
						esc_html__('You have %s ready to withdraw now.', 'edumall-child'),
						'<strong class="available_balance">' . $available_for_withdraw_formatted . '</strong>'
					); ?>
				<?php else : ?>
					<?php echo sprintf(
						esc_html__('You have %s and this is insufficient balance to withdraw.', 'edumall-child'),
						'<strong class="available_balance">' . $available_for_withdraw_formatted . '</strong>'
					); ?>
				<?php endif; ?>
			</p>
		</div>

		<div class="current-withdraw-account-wrap withdrawal-preference inline-image-text">
			<span class="far fa-question-circle primary-color"></span>
			<span>
				<?php
				$my_profile_url = tutor_utils()->get_tutor_dashboard_page_permalink('settings/withdraw-settings');
				echo $withdraw_method_name ? sprintf(esc_html__('The preferred payment method is selected as %s. ', 'edumall-child'), $withdraw_method_name) : '';
				echo sprintf(esc_html__('You can change your %s withdrawal preference %s', 'edumall-child'), '<a href="' . esc_url($my_profile_url) . '" class="link-transition-02">', '</a>');
				?>
			</span>
		</div>

		<?php if ($is_balance_sufficient && $withdraw_method_name) : ?>
			<?php
			Edumall_Templates::render_button([
				'link'        => [
					'url' => 'javascript:void(0);',
				],
				'text'        => esc_html__('Make a withdraw', 'edumall-child'),
				'extra_class' => 'open-withdraw-form-btn',
				'size'        => 'xs',
				'wrapper'     => false,
				'attributes'  => [
					'data-tutor-modal-target' => 'tutor-earning-withdraw-modal',
				],
			]);
			?>
		<?php endif; ?>
	</div>

	<?php if ($is_balance_sufficient && $withdraw_method_name) { ?>
		<div id="tutor-earning-withdraw-modal" class="tutor-modal">
			<div class="tutor-modal-overlay"></div>
			<div class="tutor-modal-window">
				<div class="tutor-modal-content tutor-modal-content-white">
					<button class="tutor-iconic-btn tutor-modal-close-o" data-tutor-modal-close>
						<span class="tutor-icon-times" area-hidden="true"></span>
					</button>
					<div class="tutor-modal-body">
						<div class="tutor-py-20 tutor-px-24">
							<div class="tutor-round-box tutor-round-box-lg tutor-mb-16">
								<span class="tutor-icon-wallet" area-hidden="true"></span>
							</div>

							<div class="tutor-fs-4 tutor-fw-medium tutor-color-black tutor-mb-24"><?php esc_html_e('Withdrawal Request', 'tutor'); ?></div>
							<div class="tutor-fs-6 tutor-color-muted"><?php esc_html_e('Please check your transaction notification on your connected withdrawal method', 'tutor'); ?></div>

							<div class="tutor-row tutor-mt-32">
								<div class="tutor-col">
									<div class="tutor-fs-6 tutor-color-secondary tutor-mb-4"><?php esc_html_e('Withdrawable Balance', 'tutor'); ?></div>
									<div class="tutor-fs-6 tutor-fw-bold tutor-color-black"><?php echo wp_kses_post($available_for_withdraw_formatted); ?></div>
								</div>

								<div class="tutor-col">
									<div class="tutor-fs-6 tutor-color-secondary tutor-mb-4"><?php esc_html_e('Selected Payment Method', 'tutor'); ?></div>
									<div class="tutor-fs-6 tutor-fw-bold tutor-color-black"><?php esc_html_e($withdraw_method_name); ?></div>
								</div>
							</div>
						</div>

						<div class="tutor-mx-n32 tutor-my-32">
							<div class="tutor-hr" area-hidden="true"></div>
						</div>

						<form id="tutor-earning-withdraw-form" method="post">
							<div class="tutor-py-20 tutor-px-24">
								<?php wp_nonce_field(tutor()->nonce_action, tutor()->nonce); ?>
								<input type="hidden" value="tutor_make_an_withdraw" name="action" />
								<?php do_action('tutor_withdraw_form_before'); ?>

								<label class="tutor-form-label" for="tutor_withdraw_amount"><?php esc_html_e('Amount', 'tutor'); ?></label>
								<div class="tutor-form-wrap tutor-mb-16">
									<span class="tutor-form-icon"><?php echo esc_attr($currency_symbol); ?></span>
									<input type="number" class="tutor-form-control" min="<?php echo esc_attr($min_withdraw); ?>" name="tutor_withdraw_amount" id="tutor_withdraw_amount" step=".01" required />
								</div>

								<div class="tutor-form-help tutor-d-flex tutor-align-center">
									<span class="tutor-icon-circle-question-mark tutor-mr-8" area-hidden="true"></span>
									<span><?php echo __('Minimum withdraw amount is', 'tutor') . ' ' . strip_tags($formatted_min_withdraw_amount); ?></span>
								</div>

								<div class="tutor-withdraw-form-response"></div>

								<?php do_action('tutor_withdraw_form_after'); ?>
							</div>
							<div class="tutor-d-flex tutor-mt-48">
								<div>
									<button class="tutor-btn tutor-btn-outline-primary" data-tutor-modal-close>
										<?php _e('Cancel', 'tutor'); ?>
									</button>
								</div>

								<div class="tutor-ml-auto">
									<button type="submit" name="withdraw-form-submit" id="tutor-earning-withdraw-btn" class="tutor-btn tutor-btn-primary tutor-modal-btn-edit tutor-ml-16">
										<?php esc_html_e('Submit Request', 'tutor'); ?>
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
</div>
<?php } ?>

<div class="dashboard-content-box withdraw-history-table-wrap">
	<h4 class="dashboard-content-box-title"><?php esc_html_e('Withdrawal History', 'edumall-child'); ?></h4>
	<?php if (is_array($all_histories->results) && count($all_histories->results)) : ?>
		<div class="dashboard-table-wrapper dashboard-table-responsive">
			<div class="dashboard-table-container">
				<table class="withdrawals-history tutor-table dashboard-table">
					<thead>
						<tr>
							<th><?php esc_html_e('Withdrawal Method', 'edumall-child'); ?></th>
							<th width="30%"><?php esc_html_e('Requested On', 'edumall-child'); ?></th>
							<th width="15%"><?php esc_html_e('Amount', 'edumall-child'); ?></th>
							<th width="15%"><?php esc_html_e('Status', 'edumall-child'); ?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($all_histories->results as $withdraw_history) : ?>
							<tr>
								<td>
									<?php
									$method_data  = maybe_unserialize($withdraw_history->method_data);
									$method_key   = $method_data['withdraw_method_key'];
									$method_title = '';

									switch ($method_key) {
										case 'bank_transfer_withdraw':
											$method_title = $method_data['account_number']['value'];
											$method_title = substr_replace($method_title, '****', 2, strlen($method_title) - 4);
											break;
										case 'paypal_withdraw':
											$method_title = $method_data['paypal_email']['value'];
											$email_base   = substr($method_title, 0, strpos($method_title, '@'));
											$method_title = substr_replace($email_base, '****', 2, strlen($email_base) - 3) . substr($method_title, strpos($method_title, '@'));
											break;
									}
									?>
									<div class="inline-image-text is-inline-block">
										<?php if (isset($method_icons[$method_key])) : ?>
											<img src="<?php echo esc_url($method_icons[$method_key]); ?>" />
										<?php endif; ?>
										&nbsp;
										<span>
											<?php
											echo '<strong class="withdraw-method-name">', tutor_utils()->avalue_dot('withdraw_method_name', $method_data), '</strong>';
											echo '<small>', $method_title, '</small>';
											?>
										</span>
									</div>
								</td>
								<td>
									<?php
									echo date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($withdraw_history->created_at));
									?>
								</td>
								<td>
									<strong><?php echo tutor_utils()->tutor_price($withdraw_history->amount); ?></strong>
								</td>
								<td>
									<span class="withdraw-status tutor-status-text <?php echo 'status-' . $withdraw_history->status; ?>">
										<?php echo __(ucfirst($withdraw_history->status), 'edumall-child'); ?>
									</span>
								</td>
								<td>
									<?php if ($withdraw_history->status !== 'approved' && isset($status_message[$withdraw_history->status])) : ?>
										<span class="hint--left hint--bounce hint--primary" aria-label="<?php echo esc_attr($status_message[$withdraw_history->status]); ?>">
											<i class="far fa-question-circle primary-color"></i>
										</span>
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	<?php else : ?>
		<p><?php esc_html_e('No withdrawal yet', 'edumall-child'); ?></p>
	<?php endif; ?>
</div>
</div>