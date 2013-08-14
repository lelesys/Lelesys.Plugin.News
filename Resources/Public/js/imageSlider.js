jQuery(document).ready(function() {
	jQuery('.carousel-inner .item:first-child').addClass('active');
	//function to show lightbox
	jQuery('#myCarousel').each(function() {
		jQuery(this).carousel({
			interval: 5000
		});
	});
	jQuery('.carousel-inner a').lightBox({
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