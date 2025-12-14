/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.7
	@build			8th December, 2025
	@created		4th March, 2025
	@package		JTax
	@subpackage		publicimpot.js
	@author			Jean-Luc Tryoen <http://www.jltryoen.fr>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

/* JS Document */

/***[JCBGUI.site_view.javascript_file.30.$$$$]***/
function onselectname($, id) {
	$.ajax({
		url:   'index.php?option=com_jtax&view=publicimpot&layout=json&id=' + id,
		type: "POST",
		dataType: "json",
		success: function(data) {
			$('#jform_year').val(data['year']);
                        $('#jform_name').val(data['name']);
		},
		error: function(xhr, status, text) {
			var response = $.parseJSON(xhr.responseText);
			console.log('Failure!');
			if (response) {
				console.log(response['data']['error']);
			} else {
				// This would mean an invalid response from the server - maybe the site went down or whatever...
			}
		}
	});
}

$(document).ready(function() {
        $('#jform_name').parent().hide();
        $('#jform_name-lbl').parent().hide();
	$('#adminForm').append($('<div class="row"><textarea id="impot" value="" rows="5" cols="20"></textarea>'));
	var selectname = $('#jform_title');
	onselectname($,  selectname.find(":selected").val());
	selectname.on('change', function() {
		onselectname($, $(this).find(":selected").val());
	});
	var selectedValue = $('#jform_deduction').find(":checked").val();
	if (selectedValue == 0) {
		$('.control-wrapper-fraisreels').show();
	} else {
		$('.control-wrapper-fraisreels').hide();
	}
	$('#jform_deduction').on('change', function() {
		var selectedValue = $(this).find(":checked").val();
		if (selectedValue == 0) {
			$('.control-wrapper-fraisreels').show();
		} else {
			$('.control-wrapper-fraisreels').hide();
		}
	});
      $('#calculate').click(function() {
		var adminform  = $("adminform");
		var method = adminform.attr('method');
		var url = adminform.attr('action');
		var data =adminform.serialize();
		data['task'] = 'impot.calculate';
		Joomla.submitbutton("impot.calculate", 'adminForm');
	});
	$('#adminForm').submit(function(event) {
		var domForm = document.getElementById('adminForm');
		var method = $(this).attr('method');
		var url = "/index.php?option=com_jtax&task=impot.calculate";
		var data = $(this).serialize();
	        event.preventDefault(); // Empêche la soumission par défaut
		$.ajax({	type: method,
				url: url,
				data: data,
				dataType: "text",
				success: function(data) {
					$('#impot').val(data.replace("<br>", "\n"));
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
		}); 
	});
});/***[/JCBGUI$$$$]***/
