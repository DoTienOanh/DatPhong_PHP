window.paypal.Buttons({
    style: {
        shape: 'rect',
        layout: 'vertical',
        color: 'gold',
        label: 'paypal',
    },
    createOrder: async function(data, actions) {
        // Lấy thông tin từ form
        const checkin = document.querySelector('input[name="checkin"]').value;
        const checkout = document.querySelector('input[name="checkout"]').value;
        const totalPayment = calculateTotalPayment(checkin, checkout); // Hàm tính toán tổng tiền

        return actions.order.create({
            purchase_units: [{
                amount: {
                    value: totalPayment.toFixed(2) // Giá trị thanh toán
                }
            }]
        });
    },
    onApprove: async function(data, actions) {
        const order = await actions.order.capture();
        console.log('Transaction completed', order);
        // Hiển thị thông báo thành công hoặc điều hướng đến trang cảm ơn
        alert('Transaction completed successfully!');
    },
    onError: function(err) {
        console.error('PayPal Checkout onError', err);
        alert('An error occurred during the transaction. Please try again.');
    }
}).render('#pay_now'); // Thay thế '#pay_now' bằng ID của phần tử nơi bạn muốn hiển thị nút