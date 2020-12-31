define(
    [
        'TrainingBansi_OrderProcessingFee/js/view/checkout/summary/fee'
    ],
    function (Component) {
        'use strict';
        var feeIsEnable=window.checkoutConfig.isModuleEnabled;
        return Component.extend({

            /**
             * @override
             */
            canVisiblePaymentFeeBlock: feeIsEnable,
            
            isDisplayed: function () {
                if(feeIsEnable){
                return true;
                }
                return false;
            }
        })
});

   
