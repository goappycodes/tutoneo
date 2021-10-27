if (typeof stripe_obj !== 'undefined') {
    var stripe = Stripe(stripe_obj.publishable_key);
    stripe.redirectToCheckout({ sessionId: stripe_obj.session_id });
}