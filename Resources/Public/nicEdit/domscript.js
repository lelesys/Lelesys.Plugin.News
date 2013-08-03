bkLib.onDomLoaded(function() {
	nicEditors.editors.push(
		new nicEditor().panelInstance(
			document.getElementById('news-description')
			)
		);
	jQuery('.nicEdit-main, .nicEdit-panelContain').css('width', '');
	jQuery('.nicEdit-main, .nicEdit-panelContain').parent().css('width', '');
});