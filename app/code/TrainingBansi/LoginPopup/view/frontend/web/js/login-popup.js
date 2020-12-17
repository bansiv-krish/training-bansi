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
        title: 'Modal Title',
        modalClass: 'custom-block-customer-login',
        buttons: [{
            text: $.mage.__('Continue'),
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