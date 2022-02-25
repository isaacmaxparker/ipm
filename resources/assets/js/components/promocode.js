import $ from 'jquery';


var init = function (selector) {
   selector.querySelector('.product-button').addEventListener('click',function(){checkPromos(selector)});
   selector.querySelector('.checkout-cart-item-buttons').addEventListener('click',function(){removePromos(selector)});
};
 

var checkPromos = (selector) => {
    let button = selector.querySelector('.product-button');
    var code = document.getElementById(button.getAttribute('data-inputid')).value;

    var viewMode = selector.getAttribute('data-viewmode');

    let string = 'checkout-promos-message' + viewMode;
    document.getElementById(string).parentElement.classList.add('hidden');
    document.getElementById(string).innerHTML = '';

    if(code){
        let url = window.location.href.replace('checkout','addpromo') + '?code=' + code;
        $.get(url, function(data, status){
            let message = data[0];
            if(message.type == 'Success'){
                document.getElementById('shipping' + viewMode).innerHTML = 
                    `<p><b>Shipping: </b><span class="cart_total-mobile">$${parseFloat(data[2]).toFixed(2)}</span></p>`;
                let string = 'checkout-promos-div' + viewMode;
                document.getElementById(string).classList.add('hidden');
                string = 'checkout-promos-applied' + viewMode;
                document.getElementById(string).children[1].innerHTML = message.message;
                document.getElementById(string).classList.remove('hidden'); 
                updateCart(data[1],data[2], viewMode);
            }else{
                let string = 'checkout-promos-message' + viewMode;
                document.getElementById(string).parentElement.classList.remove('hidden');
                document.getElementById(string).classList.add('promo-message-' + message.type)
                document.getElementById(string).innerHTML = message.message;
            }
          });
    }
}

var removePromos = (selector) =>{
    var viewMode = selector.getAttribute('data-viewmode');
    let url = window.location.href.replace('checkout','removepromo');
    let button = selector.querySelector('.product-button');
    var code = document.getElementById(button.getAttribute('data-inputid')).value;
    $.get(url, function(data, status){
        let message = data[0];
        if(message.type == 'Success'){
            document.getElementById('shipping' + viewMode).innerHTML = 
                `<p><b>Shipping: </b><span class="cart_total-mobile">$${parseFloat(data[2]).toFixed(2)}</span></p>`;

            let string = 'checkout-promos-div' + viewMode;
            document.getElementById(string).classList.remove('hidden');
            string = 'checkout-promos-applied' + viewMode;
            document.getElementById(string).classList.add('hidden');
            string = 'checkout-promos-message' + viewMode;
            document.getElementById(string).parentElement.classList.remove('hidden');
            document.getElementById(string).innerHTML = '';
            updateCart(data[1], data[2], viewMode);
        }
      });
}

var updateCart = (cart_items,shipping, viewMode) =>{
    let total_html = 0;
    cart_items.forEach(element => {

        let cart_row = document.getElementById('cart_item-' + element.cart_item_id + viewMode);
       
        element.product_price = element.price + element.discount;
       
        let price_html =  `<p>$${(element.product_price * element.quantity).toFixed(2)}</p>`;
        if(element.discount > 0 ){
            price_html += `<p>-$${(element.discount * element.quantity).toFixed(2)}</p>`
        }

        cart_row.querySelector('.checkout-cart-item-total-div').innerHTML = price_html;

        let total = (element.price * element.quantity);
        total_html = total_html + total;
    });

    document.querySelector('.cart_total' + viewMode).innerHTML = '$' + parseFloat(total_html).toFixed(2);
    let order_total = total_html + shipping;
    document.querySelector('.order_total' + viewMode).innerHTML = '$' + order_total.toFixed(2);

    getTotal();

}
var getTotal = () => {
    let total = 0.01;

    let url = window.location.href.replace('checkout','ordertotal')
        $.get(url, function(data, status){
          document.getElementById('order-total').value = data[0].toFixed(2);
    });
  }

export default { init};


