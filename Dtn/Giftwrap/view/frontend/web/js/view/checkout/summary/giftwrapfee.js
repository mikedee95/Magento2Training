define(
    [
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Checkout/js/model/quote',
        'Magento_Catalog/js/price-utils',
        'Magento_Checkout/js/model/totals',
        'ko'
    ],
    function (Component, quote, priceUtils, totals , ko) {
        "use strict";

        return Component.extend({
           defaults: {
                isFullTaxSummaryDisplayed: window.checkoutConfig.isFullTaxSummaryDisplayed || false,
               template: 'Dtn_Giftwrap/checkout/summary/giftwrapfee'
            },
            totals: quote.getTotals(),
            isVisible : ko.observable(false),
            title: ko.observable('Giftwrap'),
            isTaxDisplayedInGrandTotal: window.checkoutConfig.includeTaxInGrandTotal || false,
            isDisplayed: function() {
                return this.isFullMode();
            },
            getValue: function() {
                var price = 0;
                if (this.totals()) {
                    price = totals.getSegment('giftwrap_amount').value;
                }
                if(totals.getSegment('giftwrap_amount').value > 0){
                 this.isVisible(true);
                  } else {
                     this.isVisible(false);
                  }
                this.title(totals.getSegment('giftwrap_amount').title);
                return this.getFormattedPrice(price);
            },
            getBaseValue: function() {
                var price = 0;
                if (this.totals()) {
                    price = this.totals().base_giftwrap_amount;
                }
                return priceUtils.formatPrice(price, quote.getBasePriceFormat());
            }
        });
    }
);
