require(
[
    'jquery',
    'Magento_Ui/js/modal/modal',
    'mage/url',
    'mage/validation'
],
function(
    $,
    modal,
    url
) {    
    var dataForm = $('#form-validate-popup');
    dataForm.mage('validation', {});
    $('#form-validate-popup').submit(function(){
        var status = dataForm.validation('isValid');
        
        if(status){
        url.setBaseUrl(BASE_URL);
        var loginUrl = url.build('customer/account/createpost');
        var loginButton = $('#form-validate-popup').find('button[type=submit]');       
                //loginButton.attr("disabled", "disabled");
                var formData = getFormData($(this));
                $.ajax({
                    type: "POST",
                    url: loginUrl,
                    data: formData,
                    dataType: "json",
                    showLoader: true,
                    success: function(data) {
                        console.log(data);
                        showResponse(data);
                        if(data.errors) {
                           
                            loginButton.removeAttr('disabled');
                        } else {
                            location.reload();
                        }
                    }
                });
            }
                return false;
            });
        function getFormData(formElem){
                var unindexed_array = formElem.serializeArray();
                var indexed_array = {};

                jQuery.map(unindexed_array, function(n, i){
                    indexed_array[n['name']] = n['value'];
                });

                return indexed_array;
            }
            function showResponse(data) {
                console.log(data);
                if(data.errors) {
                    $('.response-msg').html("<div generated='true' class='mage-error'>"+data.message+"</div>");
                } else {
                    $('.response-msg').html("<div class='success'>"+data.message+"</div>");
                }
               
            }

     	let register_options = {
        type: 'popup',
        responsive: true,
        innerScroll: true,
        title: 'Register',
        buttons: []
	    };
	    
	    let $registerModal = $('#form-validate-popup');
	    let registerpopup = modal(register_options, $registerModal);
	    
	    
	    $("#popup-register").click(function() {
	    $registerModal.modal('openModal');
	    });
   
}
);