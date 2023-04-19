import $ from 'jquery';
window.showSlides = showSlides;
window.currentSlide = currentSlide;
window.plusSlides = plusSlides;
var init = function (selector) {
};

let slideIndex = 1;

// Next/previous controls
function plusSlides(n, parent) {
showSlides(slideIndex += n, parent);
}

// Thumbnail image controls
function currentSlide(n, parent) {
showSlides(slideIndex = n, parent);
}

function showSlides(n, parent) {
let i;
console.log(parent);
let slides = parent.querySelectorAll(".mySlides");
let dots = parent.querySelectorAll(".dot");
console.log(slides);
console.log(dots);

    if (n > slides.length) {
    slideIndex = 1
    }
    if (n < 1) {
    slideIndex = slides.length
    }
    for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";
    }
export default { init, currentSlide, plusSlides, showSlides};


