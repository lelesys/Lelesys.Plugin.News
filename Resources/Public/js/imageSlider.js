jQuery(document).ready(function() {
	jQuery(function(){
		jQuery("#slides").slides({
			effect: 'slide',
			autoHeight: false,
			slideSpeed: 1000,
			start: 10,
			play:10000
		});
	});

		//function to show lightbox
	jQuery(function() {
		jQuery('#gallery a').lightBox({
			imageLoading: '/_Resources/Static/Packages/Lelesys.Plugin.News/images/lightbox-ico-loading.gif',
			imageBtnPrev: '/_Resources/Static/Packages/Lelesys.Plugin.News/images/lightbox-btn-prev.gif',
			imageBtnNext: '/_Resources/Static/Packages/Lelesys.Plugin.News/images/lightbox-btn-next.gif',
			imageBtnClose: '/_Resources/Static/Packages/Lelesys.Plugin.News/images/lightbox-btn-close.gif',
			imageBlank:	'/_Resources/Static/Packages/Lelesys.Plugin.News/images/lightbox-blank.gif'
		});
		 jQuery('#show-carousel-lightbox a').lightBox({
			imageLoading: '/_Resources/Static/Packages/Lelesys.Plugin.News/images/lightbox-ico-loading.gif',
			imageBtnPrev: '/_Resources/Static/Packages/Lelesys.Plugin.News/images/lightbox-btn-prev.gif',
			imageBtnNext: '/_Resources/Static/Packages/Lelesys.Plugin.News/images/lightbox-btn-next.gif',
			imageBtnClose: '/_Resources/Static/Packages/Lelesys.Plugin.News/images/lightbox-btn-close.gif',
			imageBlank:	'/_Resources/Static/Packages/Lelesys.Plugin.News/images/lightbox-blank.gif'
		});
	});

	jQuery('#carousel').elastislide();
});