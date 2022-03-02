import $ from 'jquery';

var init = function (selector) {

    var slowload = document.getElementsByClassName('slowload');
    var arr = Array.from(slowload);

    arr.forEach(element => {
        element.onloadeddata = function() {
            element.classList.remove('invisible')
        };
    });
};


export default { init};


