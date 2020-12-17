require(
[
    'jquery',
    'Magento_Ui/js/modal/modal'
],
function(
    $,
    modal
) {
    let options = {
        type: 'popup',
        responsive: true,
        innerScroll: true,
        title: 'Login',
        modalClass: 'block-customer-custom-login',
        buttons: [{
            class: '',
            click: function () {
                this.closeModal();
            }
        }]
    };
    
    let $myModal = $('#popup-modal');
    let popup = modal(options, $myModal);
    
    
    $("#login-link").click(function() {
    $myModal.modal('openModal');
    });
}
);