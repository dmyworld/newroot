/**
 * Auto-select Default Payment Method
 * This script automatically selects the first payment method option in various invoice and purchase forms
 * across the application (POS, Invoices, Purchase forms)
 */

(function () {
    'use strict';

    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function () {
        autoSelectPaymentMethod();
    });

    // Also run when modals are shown (for payment modals)
    $(document).on('shown.bs.modal', function () {
        autoSelectPaymentMethod();
    });

    function autoSelectPaymentMethod() {
        // Common payment method field selectors used across the application
        const paymentSelectors = [
            'select[name="pmethod"]',
            'select[name="paymethod"]',
            'select[name="payment_method"]',
            '#pmethod',
            '#paymethod',
            '#payment_method',
            '.payment-method-select',
            'select.pmethod'
        ];

        paymentSelectors.forEach(function (selector) {
            const elements = document.querySelectorAll(selector);

            elements.forEach(function (element) {
                // Only auto-select if no option is currently selected or if "Select" option is selected
                if (!element.value || element.value === '' || element.value === '0') {
                    // Try to select the first non-empty option
                    const options = element.options;
                    for (let i = 0; i < options.length; i++) {
                        const optValue = options[i].value;
                        const optText = options[i].text.toLowerCase();

                        // Skip empty, "select", "choose" options
                        if (optValue && optValue !== '' && optValue !== '0' &&
                            !optText.includes('select') && !optText.includes('choose')) {
                            element.value = optValue;

                            // Trigger change event for any dependent logic
                            const event = new Event('change', { bubbles: true });
                            element.dispatchEvent(event);

                            // For selectpicker elements (Bootstrap Select)
                            if ($(element).hasClass('selectpicker')) {
                                $(element).selectpicker('refresh');
                            }

                            console.log('Auto-selected payment method:', optText, 'Value:', optValue);
                            break;
                        }
                    }
                }
            });
        });
    }

    // Expose function globally for manual trigger if needed
    window.autoSelectPaymentMethod = autoSelectPaymentMethod;

})();
