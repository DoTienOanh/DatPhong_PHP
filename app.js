const payNowButton = document.getElementById('pay_now');
paypal.Buttons({
    createOrder: function(data, actions) {
        return actions.order.create({
            purchase_units: [{
                amount: {
                    value: payment_usd
                }
            }]
        });
    },
    onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
            alert('Transaction completed by ' + details.payer.name.given_name);
            // Thực hiện các hành động khác sau khi thanh toán thành công
        });
    },
    onError: function(err) {
        console.error(err);
        alert('An error occurred during the transaction. Please try again.');
    }
}).render('#pay_now');