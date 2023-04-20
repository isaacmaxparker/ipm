import $ from 'jquery';

var init = function (selector) {
   selector.querySelector('.songPreviewPlayButton').addEventListener('click',function(){playPreview(selector)});
   selector.querySelector('.songPreviewStopButton').addEventListener('click',function(){stopPreview(selector)})
};
 

var playPreview = (songDiv) => {
    console.log(songDiv)
    console.log(songDiv.querySelector('.songPreviewAudio'))
    let audios = document.querySelectorAll('.songPreviewDiv')
    for(let i = 0; i < audios.length; i++){
        stopPreview(audios[i])
    }
    songDiv.querySelector('.songPreviewAudio').play()
    songDiv.querySelector('.songPreviewPlayButton').classList.add('hidden')
    songDiv.querySelector('.songPreviewStopButton').classList.remove('hidden')
    songDiv.querySelector('.playingCircle').classList.remove('hidden')
    songDiv.classList.add('greyBorder')
    
    setTimeout(function(){stopPreview(songDiv)},16000)
}

var stopPreview = (songDiv) => {
    songDiv.querySelector('.songPreviewStopButton').classList.add('hidden')
    songDiv.querySelector('.songPreviewPlayButton').classList.remove('hidden')
    songDiv.querySelector('.playingCircle').classList.add('hidden')
    songDiv.classList.remove('greyBorder')
    songDiv.querySelector('.songPreviewAudio').pause()
    songDiv.querySelector('.songPreviewAudio').currentTime = 0
}

export default { init};


