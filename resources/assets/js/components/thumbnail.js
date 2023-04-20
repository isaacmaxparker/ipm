import $ from 'jquery';

var init = function (selector) {
   selector.addEventListener('click',function(){switchImage(selector)});
};
 

var switchImage = (thumbnail) =>{
   let id =  thumbnail.getAttribute('data-image-id');
   let images = document.getElementsByClassName('product-image');

   let img;

   for(let i = 0;i < images.length; i++){
       img = images[i];
       if(img.getAttribute('data-image-id') == id){
           img.classList.remove('hidden-image')
       }else{
           img.classList.add('hidden-image')
       }
   }
}   

export default { init};


