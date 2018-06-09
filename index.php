<?php
    include 'library/config.php';
    require_once 'library/twitch.php';

    // get followers count
    twitchapiv3::followers('CHANNEL');

    // get game
    twitchapiv3::game('CHANNEL');

    // get title
    twitchapiv3::title('CHANNEL');

    // get total channel views
    twitchapiv3::channelviews('CHANNEL');

    // get current viewers 
    twitchapiv3::viewers('CHANNEL');

    // get uptime
    twitchapiv3::uptime('CHANNEL');

    // get followage
    twitchapiv3::followage('CHANNEL', 'FOLLOWER');

    // get subcount
    twitchapiv3::subcount('CHANNEL');
?>