<div id="cancel-reservation-div" style="display: none">
    <h4>
	<?php _e('Cancel reservation', 'redi-restaurant-reservation')?></h4><a href="#cancel" class="back-to-reservation cancel-reservation"><?php _e('Back to reservation page', 'redi-restaurant-reservation')?></a>
	<br/>
	<div id="cancel-reservation-form">
		<form method="post" action="?jquery_fail=true">
			<label for="redi-restaurant-cancelID"><?php _e('Reservation number', 'redi-restaurant-reservation')?>:<span class="redi_required"> *</span></label>
			<input type="text" name="cancelID" id="redi-restaurant-cancelID"/>
			<label for="redi-restaurant-cancelEmail"><?php _e('Phone, Email or Name', 'redi-restaurant-reservation')?>:<span class="redi_required"> *</span></label>
			<input type="text" name="cancelEmail" id="redi-restaurant-cancelEmail"/>
			<label for="redi-restaurant-cancelReason"><?php _e('Reason', 'redi-restaurant-reservation')?>:<span class="redi_required"> *</span></label>
			<textarea maxlength="250" rows="5" name="cancelEmail" id="redi-restaurant-cancelReason" class="redi-restaurant-cancelReason" cols="20"></textarea>
			<div>
            <input class="redi-restaurant-button" type="submit" id="redi-restaurant-cancel" name="action" value="<?php _e('Cancel reservation', 'redi-restaurant-reservation')?>">
			</div>
                <img id="cancel-load" style="display: none;" src="<?php echo REDI_RESTAURANT_PLUGIN_URL ?>img/ajax-loader.gif" alt=""/>
		</form>
	</div>
	<div id="cancel-errors" style="display: none;" class="redi-reservation-alert-error redi-reservation-alert"></div>
	<div id="cancel-success" style="display: none;" class="redi-reservation-alert-success redi-reservation-alert">
		<strong>
			<?php _e( 'Reservation has been successfully canceled.', 'redi-restaurant-reservation' ); ?>
		</strong>
	</div>
</div>
