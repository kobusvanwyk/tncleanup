function initiateStripeHelper() {
    var apiKey = document.getElementById('stripeHelper').getAttribute('data-api-key');

    return Stripe(apiKey);
}


async function initialiseStripeModal(clientSecret) {
    var stripe = initiateStripeHelper();

    const checkout = await stripe.initEmbeddedCheckout({
        clientSecret,
    });

    // Mount Checkout
    checkout.mount('#stripeContainer');

    document.getElementById('paymentClose').addEventListener('click', function () {
        checkout.destroy();
    });

    document.getElementById('formModal').addEventListener('hidden.bs.modal', function () {
        checkout.destroy();
    });
}
