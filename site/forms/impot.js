/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.8
	@build			15th December, 2025
	@created		4th March, 2025
	@package		JTax
	@subpackage		impot.js
	@author			Jean-Luc Tryoen <http://www.jltryoen.fr>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/




/***[JCBGUI.admin_view.javascript_view_file.288.$$$$]***/
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
       if (!$('body').hasClass('site')) {
		$('#jform_title-lbl').closest('.control-group').hide();
        }
	if ($('body').hasClass('site')) {
		$("#toolbar-save-new").hide();
		$("#toolbar-cancel").hide();
		$("#toolbar-apply").hide();
		$("#toolbar-save-copy").hide();
		$("#toolbar-inlinehelp").hide();
	}
	$('#toolbar').append($('<button class="button-joomla custom-button-calculate btn btn-primary" id="calculate" type="button"><span class="icon-joomla custom-button-calculate" aria-hidden="true"></span>Calculer</button>'));
	$('#adminForm').submit(function(event) {
		var domForm = document.getElementById('adminForm');
		if (!document.formvalidator.isValid(domForm)) {
			return false; // Ne pas soumettre si la validation échoue
		}
		var method = $(this).attr('method');
		var url = $(this).attr('action');
		var data = $(this).serialize();
		if (this.task.value == "impot.calculate") {
			 event.preventDefault(); // Empêche la soumission par défaut
			$.ajax({
				type: method,
				url: url,
				data: data,
				dataType: "text",
				success: function(data) {
					$('#jform_impot').val(data.replace("<br>", "\n"));
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
			}); 
		} else {
		}
	 });
	if ($('body').hasClass('site')) {
		$('#jform_name').parent().hide();
		$('#jform_name-lbl').parent().hide();
		$('#jform_name-lbl').parent().hide();
		$('[role=tablist]').hide();
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
   }
});/***[/JCBGUI$$$$]***/

