jQuery(document).ready(function ($) {
  "use strict";

  paymentMethodChanged();

  function paymentMethodChanged() {
    const paymentButton = $(".woocommerce-cart-form-totals-pay");
    const create_order_nonce = $("#create_order_nonce").val();

    paymentButton.on("click", (e) => {
      e.preventDefault();

      $.ajax({
        url: ajax_object.ajax_url,
        type: "POST",
        data: {
          action: "create_order_on_cart_page",
          security: create_order_nonce,
        },
        success: function (response) {
          if (response.success) {
            window.location.href = response.data.payment_url;
          } else {
            alert(
              "There was an error creating the order or processing the payment.",
            );
          }
        },
        error: (e) => {
          // Handle error
          console.log(e);
        },
      });
    });
  }
});
