jQuery(document).ready(function ($) {
  "use strict";

  paymentMethodChanged();
  couponApplication();
  couponRemove();

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
          console.log(e);
        },
      });
    });
  }

  function couponApplication() {
    $('button[name="apply_coupon_code"]').on("click", async function (e) {
      e.preventDefault();

      const couponCode = $("#coupon_code").val();

      if (couponCode.length === 0) {
        alert("Please enter a coupon code.");
        return;
      }

      try {
        const response = await $.ajax({
          url: ajax_object.ajax_url,
          type: "POST",
          data: {
            action: "apply_coupon",
            coupon_code: couponCode,
          },
        });

        if (response.success) {
          await updateCartTotals();
          $("#coupon_code").val("");
          $(".coupon-list").append(`
            <div class="coupon-list-code coupon-${couponCode}">
                            <p>${couponCode}</p>
                            <a href="#" class="coupon-list-code-remove" data-coupon-id="${couponCode}">
                                حذف
                            </a>
                        </div>
            `);
        } else {
          alert(response.data);
        }
      } catch (error) {
        console.error("Error applying coupon:", error);
        alert("An error occurred while applying the coupon.");
      }
    });

    async function updateCartTotals() {
      try {
        const response = await $.ajax({
          url: ajax_object.ajax_url,
          type: "POST",
          data: {
            action: "update_cart_totals",
          },
        });

        if (response.success) {
          $(
            ".woocommerce-cart-form-totals .cart-total span p:nth-child(1)",
          ).text(response.data.order_total);
          $(
            ".woocommerce-cart-form-totals .cart-discount-total span p:nth-child(1)",
          ).text(response.data.total_discount);
        } else {
          alert("Failed to update cart totals.");
        }
      } catch (error) {
        console.error("Error updating cart totals:", error);
        alert("An error occurred while updating the cart totals.");
      }
    }
  }

  function couponRemove() {
    $(".coupon-list-code-remove").on("click", async function (e) {
      e.preventDefault();

      const couponCode = $(this).data("coupon-id");
      try {
        const response = await $.ajax({
          url: ajax_object.ajax_url,
          type: "POST",
          data: {
            action: "remove_coupon",
            coupon_code: couponCode,
          },
        });

        if (response.success) {
          await updateCartTotals();
          $(".coupon-list").find(`.coupon-${couponCode}`).remove();
        } else {
          alert("Failed to remove coupon.");
        }
      } catch (error) {
        console.error("Error removing coupon:", error);
        alert("An error occurred while removing the coupon.");
      }
    });

    async function updateCartTotals() {
      try {
        const response = await $.ajax({
          url: ajax_object.ajax_url,
          type: "POST",
          data: {
            action: "update_cart_totals",
          },
        });

        if (response.success) {
          $(
            ".woocommerce-cart-form-totals .cart-total span p:nth-child(1)",
          ).text(response.data.order_total);
          $(
            ".woocommerce-cart-form-totals .cart-discount-total span p:nth-child(1)",
          ).text(response.data.total_discount);
        } else {
          alert("Failed to update cart totals.");
        }
      } catch (error) {
        console.error("Error updating cart totals:", error);
        alert("An error occurred while updating the cart totals.");
      }
    }
  }
});
