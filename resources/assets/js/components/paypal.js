import $ from 'jquery';
import { loadScript } from "@paypal/paypal-js";

var init = function (selector) {

    loadScript({ "client-id": 'AUEml5vTR3kDWwv3LjQkgLA1KP6ISueJoXxyqAps-dZd0MwtBbkhN1qwXNjyd89JizzAmJSVlIctFtl_' })
    .then((paypal) => {
        paypal.Buttons({

            // Sets up the transaction when a payment button is clicked
            createOrder: function(data, actions) {
              return actions.order.create({
                purchase_units: [{
                  amount: {
                    value: '0.01' // Can reference variables or functions. Example: `value: document.getElementById('...').value`
                  }
                }]
              });
            },
    
            // Finalize the transaction after payer approval
            onApprove: function(data, actions) {
              return actions.order.capture().then(function(orderData) {
                // Successful capture! For dev/demo purposes:
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                    var transaction = orderData.purchase_units[0].payments.captures[0];
                    alert('Transaction '+ transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');
    
                // When ready to go live, remove the alert and show a success message within this page. For example:
                // var element = document.getElementById('paypal-button-container');
                // element.innerHTML = '';
                // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                // Or go to another URL:  actions.redirect('thank_you.html');
              });
            }
          }).render('#paypal-button-container');
    })
    .catch((err) => {
        console.error("failed to load the PayPal JS SDK script", err);
    });
};
 
export default { init};


