<?php
/**
 * BuddyPress - Groups Requests Loop
 *
 * @since         3.0.0
 * @version       3.0.0
 *
 * @theme-since   2.7.4
 * @theme-version 2.7.4
 */
?>

<?php if ( bp_group_has_membership_requests( bp_ajax_querystring( 'membership_requests' ) ) ) : ?>

	<h2 class="bp-screen-title">
		<?php esc_html_e( 'Manage Membership Requests', 'edumall' ); ?>
	</h2>

	<?php bp_nouveau_pagination( 'top' ); ?>

	<ul id="request-list" class="item-list bp-list membership-requests-list members-group-list">
		<?php
		while ( bp_group_membership_requests() ) :
			bp_group_the_membership_request();
			?>

			<li class="item-entry">
				<div class="list-wrap">
					<div class="item-avatar">
						<?php edumall_bp_group_request_user_avatar_full(); ?>
					</div>

					<div class="item">
						<div class="item-block">
							<h3 class="list-title member-name"><?php bp_group_request_user_link(); ?></h3>

							<div class="item-meta">
								<span class="comments"><?php bp_group_request_comment(); ?></span>
								<span class="activity"><?php bp_group_request_time_since_requested(); ?></span>
								<?php bp_nouveau_group_hook( '', 'membership_requests_admin_item' ); ?>
							</div>
						</div>
					</div>

					<?php bp_nouveau_groups_request_buttons(); ?>
				</div>
			</li>

		<?php endwhile; ?>
	</ul>

	<?php bp_nouveau_pagination( 'bottom' ); ?>

<?php else : ?>

	<?php bp_nouveau_user_feedback( 'group-requests-none' ); ?>

<?php
endif;
