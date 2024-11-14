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
            alert('Giao dịch đã hoàn tất bởi ' + details.payer.name.given_name+'. Vui lòng kiểm tra email của bạn.');
            // Thực hiện các hành động khác sau khi thanh toán thành công
        });
    },
    onError: function(err) {
        console.error(err);
        alert('Đã xảy ra lỗi trong quá trình giao dịch. Vui lòng thử lại.');
    }
}).render('#pay_now');