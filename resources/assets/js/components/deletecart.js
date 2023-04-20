import $ from 'jquery';
import { update } from 'lodash';


var init = function (selector) {
   selector.querySelector('.checkout-cart-item-buttons').addEventListener('click',function(){removeFromCart(selector)});
};
 

var removeFromCart = (selector) => {
    var code = selector.getAttribute('data-id');
    var quant = selector.getAttribute('data-quant');

    var viewMode = selector.getAttribute('data-viewmode');

    let url = window.location.href.replace('checkout','removefromcart') + '?id=' + code + '&quant=' + quant;
    console.log(url);
    $.get(url, function(data, status){
        let message = data[0];
        if(message.type == 'Success'){
            updateCart(data[1],data[2],viewMode,code);
        }
        });
}

var updateCart = (cart_items,shipping, viewMode,code) =>{
    window.location.reload()
    return;
    if(cart_items.length == 0){
        window.location.reload();
    }else{
        document.getElementById('cart_item-' + code + viewMode).remove();
        document.getElementById('shipping' + viewMode).innerHTML = 
        `<p><b>Shipping: </b><span class="cart_total-mobile">$${parseFloat(shipping).toFixed(2)}</span></p>`;
        console.log(cart_items);
        if(cart_items.length == 0){
            document.querySelector('.checkout_div').innerHTML = `<p>No items in cart</p><a href="${window.location.href.replace('checkout','')}">Browse Shop</a>`
        }
        else{
            let total_html = 0;
            cart_items.forEach(element => {
                console.log(total_html)
                console.log(element)
                total_html = ((element.price * element.quantity).toFixed(2)) + total_html;
                console.log(total_html)
                console.log('0---------------------------------------0')
            });
            document.querySelector('.cart_total' + viewMode).innerHTML = '$' + parseFloat(total_html).toFixed(2);
            let order_total = total_html + shipping;
            document.querySelector('.order_total' + viewMode).innerHTML = '$' + parseFloat(order_total).toFixed(2);
        }
    }
    
}

export default { init};


