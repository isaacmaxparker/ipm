import $ from 'jquery';
import { loadScript } from "@paypal/paypal-js";

var init = function (selector) {

  getTotal();
    loadScript({ "client-id": 'AUEml5vTR3kDWwv3LjQkgLA1KP6ISueJoXxyqAps-dZd0MwtBbkhN1qwXNjyd89JizzAmJSVlIctFtl_',
                "disable-funding":'credit'
                })
    .then((paypal) => {
        paypal.Buttons({
          // Sets up the transaction when a payment button is clicked
          createOrder: function(data, actions) { 
             getTotal();
              return actions.order.create({
                purchase_units: [{
                  amount: {
                    value: document.getElementById('order-total').value // Can reference variables or functions. Example: `value: document.getElementById('...').value`
                  }
                }]
              });
            },
    
            // Finalize the transaction after payer approval
            onApprove: function(data, actions) {
              return actions.order.capture().then(function(orderData) {
                    let url = window.location.href.replace('checkout','saveorder')

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                        $.post(url, {'data':JSON.stringify(orderData)}, function(data, status){
                          if(data[0] == 'Success'){
                            window.location = window.location.href.replace('checkout','order') + "/" + data[1]
                          }
                        });

                // When ready to go live, remove the alert and show a success message within this page. For example:
                // var element = document.getElementById('paypal-button-container');
                // element.innerHTML = '';
                // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                // Or go to another URL:  actions.redirect('thank_you.html');
              });
            }
          }).render('#paypal-button-container');
          paypal.Buttons({
            // Sets up the transaction when a payment button is clicked
            createOrder: function(data, actions) { 
               getTotal();
                return actions.order.create({
                  purchase_units: [{
                    amount: {
                      value: document.getElementById('order-total').value // Can reference variables or functions. Example: `value: document.getElementById('...').value`
                    }
                  }]
                });
              },
      
              // Finalize the transaction after payer approval
              onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {
                      let url = window.location.href.replace('checkout','saveorder')
  
                      $.ajaxSetup({
                          headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          }
                      });
  
                          $.post(url, {'data':JSON.stringify(orderData)}, function(data, status){
                            if(data[0] == 'Success'){
                              window.location = window.location.href.replace('checkout','order') + "/" + data[1]
                            }
                          });
  
                  // When ready to go live, remove the alert and show a success message within this page. For example:
                  // var element = document.getElementById('paypal-button-container');
                  // element.innerHTML = '';
                  // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                  // Or go to another URL:  actions.redirect('thank_you.html');
                });
              }
            }).render('#paypal-button-container-desktop');
    })
    .catch((err) => {
        console.error("failed to load the PayPal JS SDK script", err);
    });
};

var getTotal = () => {
  let total = 0.01;
  let url = window.location.href.replace('checkout','ordertotal')
      $.get(url, function(data, status){
        document.getElementById('order-total').value = data[0].toFixed(2);

  });
}
 
 
export default { init};


