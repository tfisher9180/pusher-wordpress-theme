jQuery(document).ready(function($) {

	$('.button-collapse').sideNav({
		menuWidth: 300,
		edge: 'left',
		closeOnClick: true
	});

	$('li.page_item').each(function() {
		$(this).addClass('waves-effect waves-light');
	});

});