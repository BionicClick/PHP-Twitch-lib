<?php
    include 'library/config.php';
    require_once 'library/twitch.php';

    // get followers count
    twitchapibasic::followers('USERID');

    // get game
    twitchapibasic::game('USERID');

    // get title
    twitchapibasic::title('USERID');

    // get total USERID views
    twitchapibasic::USERIDviews('USERID');

    // get current viewers 
    twitchapibasic::viewers('USERID');

    // get uptime
    twitchapibasic::uptime('USERID');

    // get followage
    twitchapibasic::followage('USERID', 'FOLLOWER');

    // get subcount
    twitchapibasic::subcount('USERID');
?>