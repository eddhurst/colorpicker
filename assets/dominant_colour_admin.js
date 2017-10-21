function attachDominantColor() {
	jQuery('.trigger-rebuild').click(function() {
		jQuery(this).html('Building Color Palette...');
		storage = jQuery('input[name*="dominant-override"]');
		storage.val('trigger-rebuild');
		storage.change();
	});
}