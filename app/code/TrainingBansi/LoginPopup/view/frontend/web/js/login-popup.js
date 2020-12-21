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
       var dataForm = $('#popup-login-form');
       dataForm.mage('validation', {});
       let options = {
        type: 'popup',
        responsive: true,
        innerScroll: true,
        title: 'Login',
        buttons: []
    };
    
    let $myModal = $('#popup-modal');
    let popup = modal(options, $myModal);
    
    
    $("#login-link").click(function() {
        $myModal.modal('openModal');
    });
    $('#popup-login-form').submit(function(){
    	var status = dataForm.validation('isValid');
    	
    	if(status){
            url.setBaseUrl(BASE_URL);
            var loginUrl = url.build('customerlogin/ajax/login');
            var loginButton = $('#popup-login-form').find('button[type=submit]');       
            loginButton.attr("disabled", "disabled");
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