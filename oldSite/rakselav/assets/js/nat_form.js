;
(function($, window, document, undefined) {
    var $formWrapper = $('#ctl-form-wrap');
    var $form = $('#ctl-form-wrap form');
    var params = {};
    params.formSettings = $formWrapper.data();
    /**********************************************************************************************/
    $(document).ready(function() {
        if (!$form.length) {
            params.action = 'create-empty-form';
            doAjax(params, 'html');
        }
        $formWrapper.on('click', '.submit_btn input[type=submit]', function(e) {
            e.preventDefault();
            cleanInlineErrors();
            hideTopMessage();
            params.action = 'form-submit';
            params.form = $formWrapper.find('form').serialize();
            doAjax(params, 'json');
        });
    });
    /**********************************************************************************************/
    function doAjax(parameters, dataType) {
        $.ajax({
            type: 'POST',
            url: 'nat_form/validate_submit_form.php',
            data: parameters,
            dataType: dataType,
            beforeSend: function() {
                $('.ajax-loader').show();
                $('#wrapper_submit_btn input[type=submit]').hide();
            },
            success: function(data) {
                if (dataType === 'html') {                        
                    $formWrapper.html(data);
                    $formWrapper.find('#purchase_amount').val(getCookie('corpshopAmount'));
                    $formWrapper.find('#purchase_amount').attr('readonly', 'readonly');
                } else if (dataType === 'json') {
                    if (data.inline_errors) {
                        showInlineErrors(data.inline_errors);
                        showTopMessage({
                            'title': 'Form Validation',
                            'message': 'Please correct the marked fields.',
                            'status': 'error'
                        });
                        var div = document.getElementById('buy-now');
                        $('html,body').animate({
                            scrollTop: div.offsetTop
                        }, 'slow')  
                    } else if(data['payment_status'] == 'OK'){
                        showTopMessage({'title':'Transaction Succeeded!', 'message': 'Your transaction was processed at this time!', 'status': 'ok'});
                        $formWrapper.find('form').hide();
                    } else {
                        showTopMessage({'title':'Transaction error', 'message': 'Your transaction could not be processed this time!', 'status': 'error'});
                        $formWrapper.find('form').hide();
                    }
                }
                $('.ajax-loader').hide();
                $('#wrapper_submit_btn input[type=submit]').show();
                var div = document.getElementById('buy-now');
                $('html,body').animate({
                    scrollTop: div.offsetTop
                }, 'slow')  
            },
            error: function() {
                showTopMessage({
                    'title': 'Error',
                    'message': "There's been a connection problem, please try later.",
                    'status': 'error'
                });
                var div = document.getElementById('buy-now');
                $('html,body').animate({
                    scrollTop: div.offsetTop
                }, 'slow')  
                $('.ajax-loader').hide();
                $('#wrapper_submit_btn input[type=submit]').show();
            }
        });
    }
/**********************************************************************************************/	
	function showInlineErrors(errorObj){
		$.each(errorObj, function( key, value ) {
  			var $fieldWrapper = $('#wrapper_' + key);
			var $errorMsg = $fieldWrapper.find('.error_msg.' + key);			
			$fieldWrapper.addClass($formWrapper.data('class_field_wrap_error'));	
			$fieldWrapper.find('input[type=text]').addClass($formWrapper.data('class_input_error'));
			$fieldWrapper.find('select').addClass($formWrapper.data('class_input_error'));					
			$errorMsg.html(value[0]).html();
			$errorMsg.show();
		});
	}
	
	/**********************************************************************************************/	
	function cleanInlineErrors(){
		$('div.field_wrapper').removeClass($formWrapper.data('class_field_wrap_error'));
		$('div.field_wrapper').find('.error_msg').html('').hide();
		$('div.field_wrapper').find('input[type=text]').removeClass($formWrapper.data('class_input_error'));
		$('div.field_wrapper').find('select').removeClass($formWrapper.data('class_input_error'));
	}	
	/**********************************************************************************************/	
	function showTopMessage(data){
		$('.top_message_title').html(data.title).html();
		$('.top_message_text').html(data.message).html();
		$('.top_message_wrapper').slideDown();
		
		if(data.status === 'ok'){
			$('.top_message_wrapper').removeClass($formWrapper.data('class_main_error_msg_wrapper'));
			$('.top_message_title').removeClass($formWrapper.data('class_main_error_msg_title'));
			$('.top_message_text').removeClass($formWrapper.data('class_main_error_msg_text'));
			
			$('.top_message_wrapper').addClass($formWrapper.data('class_success_wrapper'));
			$('.top_message_title').addClass($formWrapper.data('class_success_title'));
			$('.top_message_text').addClass($formWrapper.data('class_success_text'));			
		}
	}
	/**********************************************************************************************/	
	function hideTopMessage(){
		$('.top_message_wrapper').slideUp();
		$('.top_message_title').html('');
		$('.top_message_text').html('');
	}
    /**********************************************************************************************/
    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
        }
        return "";
    }
})(jQuery, window, document);