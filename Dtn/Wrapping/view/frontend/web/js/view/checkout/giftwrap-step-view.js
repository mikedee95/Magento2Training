define(
    [
        'ko',
        'uiComponent',
        'underscore',
        'Magento_Checkout/js/model/step-navigator',
        'jquery', 'Magento_Checkout/js/action/get-totals',
        'Magento_Checkout/js/model/full-screen-loader'],
    function(
        ko,
        Component,
        _, stepNavigator,
        jQuery,
        getTotalsAction,
        fullScreenLoader
    ) {
        'use strict';
        var quotevalue = window.quotevalue;
        var giftwrapitems = window.giftwrapitems;
        var saveUrl = window.saveUrl;
        var quoteId = window.quoteentityid;
        var moduleEnabled = window.moduleEnabled;
        var perOrder = window.perOrder;
        jQuery('body').on('click', '.smallimagegift', function(event) {
            var $this = jQuery(this);
            if ($this.hasClass("activeimage")) {
                var basePrice = $this.closest('tr').find('.price-product-base').text();
                $this.closest('tr').find('.price-product').text(basePrice);
                $this.removeClass("activeimage");
                $this.closest('td').find('.is_giftwrap').val(0);
                $this.closest('td').find('.giftwrap_id').val(null);
                $this.closest('td').find('.giftwrap_price').val(null);
            } else {
                jQuery(this).closest('li').siblings().find('img').removeClass("activeimage");
                $this.addClass("activeimage");
                var wrapprice = $this.siblings('.gift-wrap-price').text();
                var basePrice = $this.closest('tr').find('.price-product-base').text();
                var totalPrice = parseFloat(wrapprice) + parseFloat(basePrice);
                $this.closest('tr').find('.price-product').text(parseFloat(totalPrice).toFixed(2));
                $this.closest('td').find('.is_giftwrap').val(1);
                $this.closest('td').find('.giftwrap_id').val($this.attr('id'));
                $this.closest('td').find('.giftwrap_price').val($this.attr('price'));
            }
        });
        jQuery('body').on('click', '#include-giftwrap', function(event) {
            jQuery(".giftwrap-form-container").toggle();
            jQuery(".actions-toolbar-container").toggle();
        });

        jQuery('body').on('click', '.dontapply', function(event) {
            jQuery(this).closest('tr').find('textarea[name="message"]').val('');
            jQuery(this).closest('tr').find('.smallimagegift').each(function(){
                if(jQuery(this).hasClass('activeimage')){
                    jQuery(this).click();
                }
            });
        });

        var maxLength = 40;
        jQuery("body").on("keyup", "textarea[name='message']",function() {
            var length = jQuery(this).val().length;
            jQuery('#chars').text(40 - length);
            if(length == 40){
                jQuery("#char-limit").addClass('full');
            } else{
                jQuery("#char-limit").removeClass('full');
            }
        });

        return Component.extend({
            defaults: {
                template: 'Excellence_Giftwrap/checkout/giftwrapstep'
            },
            isVisible: ko.observable(false),
            productData: quotevalue,
            moduleEnabled: moduleEnabled,
            isVisiblePre : ko.observable(false),
            amount : ko.observable(window.perOrderCost),
            initialize: function() {
                var self = this;
                this._super();
                if(moduleEnabled && !(jQuery.isEmptyObject(giftwrapitems))) {
                    stepNavigator.registerStep('giftwrapstep', 'giftwrapstep', 'Gift Wrap', this.isVisible, _.bind(this.navigate, this), 14);
                }
                console.log(perOrder);

                if(window.perOrder!= true){
                    self.isVisiblePre(true);
                    console.log('show');
                }
                else{
                    console.log('hide');
                    self.isVisiblePre(false);
                }
                return this;
            },
            navigate: function() {
                var self = this;
                self.isVisible(true);
            },
            navigateToNextStep: function() {
                fullScreenLoader.startLoader();
                jQuery.ajax({
                    url: saveUrl,
                    type: "POST",
                    data: {
                        delete: 1,
                        quote_id: quoteId
                    },
                    success: function(response) {
                        if (response) {
                            var deferred = jQuery.Deferred();
                            getTotalsAction([], deferred);
                            fullScreenLoader.stopLoader();
                            stepNavigator.next();
                        }
                    }
                });
            },
            saveGiftWrap: function(formElemen) {
                if(!(jQuery('.activeimage').length)){
                    jQuery('#no-gift-box-msg').show();
                    jQuery('#no-gift-box-msg').fadeOut(6000);
                    return false;
                }
                var arr = [];
                jQuery('body').find('.giftwrapform').find('input,textarea').each(function(key) {
                    var object = {};
                    object[jQuery(this).attr('name')] = jQuery(this).val();
                    arr.push(object);
                });
                fullScreenLoader.startLoader();
                jQuery.ajax({
                    url: saveUrl,
                    type: "POST",
                    data: {
                        data: arr,
                        quote_id: quoteId
                    },
                    success: function(response) {
                        if (response) {
                            var deferred = jQuery.Deferred();
                            getTotalsAction([], deferred);
                            fullScreenLoader.stopLoader();
                            stepNavigator.next();
                        }
                    }
                });
            },
        });
    });