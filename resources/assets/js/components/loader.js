import $ from 'jquery';
window.checkImages = checkImages;
var init = function (selector) {



};

function IsImageOk(img) {
    // During the onload event, IE correctly identifies any images that
    // weren’t downloaded as not complete. Others should too. Gecko-based
    // browsers act like NS4 in that they report this incorrectly.
    if (!img.complete) {
        return false;
    }

    // However, they do have two very useful properties: naturalWidth and
    // naturalHeight. These give the true size of the image. If it failed
    // to load, either of these should be zero.
    if (img.naturalWidth === 0) {
        return false;
    }

    // No other way of checking: assume it’s ok.
    return true;
}

function checkImages(element) {
    if(element){
        element.classList.remove('unloaded');
    }else{
        $('img').each(function( index, img ) {
            if(IsImageOk(img)){
                checkImages(img);
            }
       });
    }
    let unloadeds = document.getElementsByClassName('unloaded');
    console.log(unloadeds)
    if (unloadeds.length == 0) {
            let carousels = document.getElementsByClassName('slide_1');
            for(let i = 0; i < carousels.length; i++){
                carousels[i].style.display = "block";
            }
        document.getElementById('loadingScreen').classList.add('invisible')
        setTimeout(() => {
            document.getElementById('loadingScreen').classList.add('hidden');
        }, 500)
    }
}
export default { init, checkImages};


