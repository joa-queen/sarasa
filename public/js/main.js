(function($){
	$(document).on('ready', function(event) {
		$('#dlgError').dialog({
			modal: true,
			autoOpen: false,
			resizable: false,
			minHeight: 150,
			minWidth: 600,
			position: [ 'center' , 100 ]
		});
	});
})(jQuery);
function error(errorMsg) {
	$('#dlgErrorMsg').html(errorMsg);
	$("#dlgError").dialog("open");
}
function loading() {
	if ($('#loading').css('display') == 'none') $("#loading").animate({width:'toggle'},350);
}
function stoploading() {
	$('#loading').stop(true,true).hide();
	$('button.disabled').removeClass('disabled');
}
function f(funcion, parameters, notloading) {
	if (!notloading) loading();
	parameters = $.extend({}, parameters);

	$.ajax({
		type: 'POST',
		data: (parameters),
		cache: false,
		dataType: "json",
		success: processAjax,
		beforeSend: function(xhr) {
			xhr.setRequestHeader("AJAX_URL", $(location).attr('href'));
			xhr.setRequestHeader("AJAX_FUNCTION", funcion);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log('Ajax error: ' + jqXHR.responseText);
		}
	});
}

function processAjax(responses) {
	var response;
	for (var i in responses) {
		response = responses[i];
		if (response[0] == 'redirect') location.href = response[1];
		else if (response[0] == 'assign') $('#'+response[1]).html(response[2]);
		else if (response[0] == 'script') eval(response[1]);
		else if (response[0] == 'log') console.log(response[1]);
		else if (response[0] == 'fadeout') $(response[1]).fadeOut();
		else if (response[0] == 'append') $('#'+response[1]).append(response[2]);
		else if (response[0] == 'prepend') $('#'+response[1]).prepend(response[2]);
		else if (response[0] == 'alert') alert(response[1]);
	}
}