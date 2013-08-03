jQuery(document).ready(function() {
	jQuery('.icon-chevron-down').click(function () {
		jQuery(this).parent('.list-info').next(".toggle-info").toggle();
		if (jQuery(this).attr('class') == 'icon-chevron-down') {
			jQuery(this).addClass('icon-chevron-up');
			jQuery(this).removeClass('icon-chevron-down');
		} else {
			jQuery(this).addClass('icon-chevron-down');
			jQuery(this).removeClass('icon-chevron-up');
		}
	});
});