/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				JL Tryoen 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.5
	@build			2nd April, 2025
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
$(document).ready(function() {
	if ($('body').hasClass('site')) {
		$("#toolbar-save-new").hide();
		$("#toolbar-apply").hide();
		$("#toolbar-save-copy").hide();
		$("#toolbar-inlinehelp").hide();
		 $('#toolbar').append($('<input type="button" id="calculate" task="impot.calculate" value="Calculer"/>'));
	}
	$('#adminForm').append($('<div class="row"><textarea id="impot" value="" rows="5" cols="20"></textarea>'));
	
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
					$('#impot').val(data.replace("<br>", "\n"));
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
/*	  $.ajax({
			type: "POST",
			url: url,
			data: data,
			success: function(data) {
				$('#impot').val(data.replace("<br>", "\n"));
			}
		});*/
	});
   }
});/***[/JCBGUI$$$$]***/

