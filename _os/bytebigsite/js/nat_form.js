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
                        
                    $formWrapper.find('#firstname').val(firstname);
                    $formWrapper.find('#lastname').val(lastname);
                    $formWrapper.find('#userid').val(userid);
                    $formWrapper.find('#userid').attr('readonly', 'readonly');
                    $formWrapper.find('#order_id').val(order_id);
                    $formWrapper.find('#order_id').attr('readonly', 'readonly');

                    $formWrapper.find('#nonce_key').val(key);
                    $formWrapper.find('#nonce_key').attr('readonly', 'readonly');
                    $formWrapper.find('#wrapper_nonce_key').attr('style', 'display:none');   
                    
                    $formWrapper.find('#wrapper_purchase_instrument_brand').attr('style', 'display:none');
                    
                    $formWrapper.find('#group-1').attr('style', 'display:none');
                    $formWrapper.find('#group-3').attr('style', 'display:none');
                    $formWrapper.find('#group-4').attr('style', 'display:none');

                    $formWrapper.find("#previous_2").hide();  

                    $formWrapper.find("#wrapper_submit_btn").hide();                        
                    $formWrapper.find('#wrapper_currency_code').attr('style', 'display:none');
                    
                    document.getElementById("purchase_amount2").innerHTML = "Subtotal: <span id='number'>$0.00</span><br/> Fees: <span id='number'>$0.00</span><br/> Total: <span id='number'>$0.00</span>";

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
                        showTopMessage({'title':'Transaction Succeeded!', 'message': 'An email has been sent to you with the details of your transaction!', 'status': 'ok'});
                        $formWrapper.find('form').hide();
                        document.getElementById('infotop').style.display="none";                   
                        document.getElementById('purch_slide').style.display="none";
                        document.getElementById('success_check').style.display="block";
                        document.getElementById('success_done').style.display="block";
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
  			var $fieldWrapper = $('#wrap_' + key);
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
})(jQuery, window, document);