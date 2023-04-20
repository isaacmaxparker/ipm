<?php

return [
    's3_img_link'=>env('S3_IMAGE_BASE_LINK', 'https://ipmsite.s3.us-west-1.amazonaws.com/img/'),
    's3_audio_link'=>env('S3_AUDIO_BASE_LINK', 'https://ipmsite.s3.us-west-1.amazonaws.com/audio/'),
    's3_portfolio_link'=>env('S3_PORTFOLIO_BASE_LINK', 'https://ipmsite.s3.us-west-1.amazonaws.com/portfolio/'),

    'facebook' => env('SOCIALS_FACEBOOK_LINK', 'https://www.facebook.com/isaacparkermusic/'),
    'instagram' => env('SOCIALS_INSTA_LINK', 'https://www.instagram.com/isaacparkermusic/'),
    'youtube' => env('SOCIALS_YOUTUBE_LINK', 'https://www.youtube.com/isaacparkermusic'),
    'itunes' => env('SOCIALS_ITUNES_LINK', 'https://music.apple.com/us/artist/isaac-parker/1475902891'),
    'spotify' => env('SOCIALS_SPOTIFY_LINK', 'https://open.spotify.com/playlist/5AX7wh7kbcFyJIEj3E8ZcX'),
    'twitter' => env('SOCIALS_TWITTER_LINK', 'https://twitter.com/isaacmcparker')
];
