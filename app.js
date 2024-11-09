window.paypal
    .Buttons({
        style: {
            shape: "rect",
            layout: "vertical",
            color: "gold",
            label: "paypal",
        },
        async createOrder() {
            try {
                let price = parseFloat(document.getElementById('price').textContent); 
                let count_days = date_diff(new Date(booking_form.elements['checkin'].value), new Date(booking_form.elements['checkout'].value));
                let totalAmount = (price * count_days).toFixed(2);

                const response = await fetch("/api/orders", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ amount: totalAmount }),
                });

                if (!response.ok) {
                    throw new Error('Failed to create order: ' + response.statusText);
                }

                const orderData = await response.json();
                if (orderData.id) {
                    return orderData.id;
                }
                throw new Error('Order creation failed');
            } catch (error) {
                console.error(error);
                alert('Could not initiate PayPal Checkout... Please try again.');
            }
        },

        async onApprove(data, actions) {
            try {
                const response = await fetch(`/api/orders/${data.orderID}/capture`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                });

                const orderData = await response.json();
                const errorDetail = orderData?.details?.[0];

                if (errorDetail?.issue === "INSTRUMENT_DECLINED") {
                    return actions.restart();
                } else if (errorDetail) {
                    throw new Error(`${errorDetail.description} (${orderData.debug_id})`);
                } else if (!orderData.purchase_units) {
                    throw new Error(JSON.stringify(orderData));
                } else {
                    const transaction = orderData?.purchase_units?.[0]?.payments?.captures?.[0] || orderData?.purchase_units?.[0]?.payments?.authorizations?.[0];
                    alert(`Transaction ${transaction.status}: ${transaction.id}`);
                    console.log("Capture result", orderData, JSON.stringify(orderData, null, 2));
                }
            } catch (error) {
                console.error(error);
                alert(`Sorry, your transaction could not be processed...<br><br>${error}`);
            }
        },
    })
    .render("#pay_now");