<?php
    class twitchapiv5 {

        static function call($request) {
            $url = 'https://api.twitch.tv/kraken/'. $request;
            $ch = curl_init();
            curl_setopt_array($ch, array(
            CURLOPT_HTTPHEADER => array(
                'Accept: application/vnd.twitchtv.v5+json',
                'Client-ID: ' . $GLOBALS['config']['Twitch_Client-id'] . '',
                'Authorization: OAuth ' . $GLOBALS['config']['Twitch_Access-token'] . '',
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url
            ));

            $response = curl_exec($ch);
            curl_close($ch);
            return $response;
        }

        static function bits_cheermotes($c = null) {
            if(isset($c)) {
                $sc = '?channel_id='. $c;
            }
            $data = self::call('bits/actions'. $sc);
            $json = json_decode($data, true);
            return $json;
        }

        static function channel($c) {
            $data = self::call('channels/'. $c);
            $json = json_decode($data, true);
            return $json;
        }

        static function channel_collections($c, $l = 10, $o = '', $ci = null) {
            if(isset($ci)) {
                $cr = '&containing_item='. $ci;
            }
            $data = self::call('channels/'. $c . '/collections?limit='. $l .'&cursor='. $o . $cr);
            $json = json_decode($data, true);
            return $json;
        }

        static function channel_editors($c) {
            $data = self::call('channels/'. $c . '/editors');
            $json = json_decode($data, true);
            return $json;
        }

        static function channel_followers($c, $l = '25', $o = '0', $d = 'desc') {
            $data = self::call('channels/'. $c . '/follows?limit='. $l .'&offset='. $o .'&direction=' . $d);
            $json = json_decode($data, true);
            return $json;
        }

        static function channel_teams($c) {
            $data = self::call('channels/'. $c . '/teams');
            $json = json_decode($data, true);
            return $json;
        }

        static function channel_subscriptions($c, $l = '25', $o = '0', $d = 'desc') {
            $data = self::call('channels/'. $c . '/subscriptions?limit='. $l .'&offset='. $o .'&direction=' . $d);
            $json = json_decode($data, true);
            return $json;
        }

        static function channel_check_subscription($c, $s) {
            $data = self::call('channels/'. $c . '/subscriptions/'.$s);
            $json = json_decode($data, true);
            return $json;
        }

        static function channel_videos($c, $l = '25', $o = '0', $bt = '', $lg = '', $s = 'time') {
            $data = self::call('channels/'. $c . '/videos?limit='.$l . '&offset=' . $o . '&broadcast_type=' . $bt . '&language=' . $lg . '&sort=' . $s);
            $json = json_decode($data, true);
            return $json;
        }

        static function chat_badges($c = '20037') {
            $data = self::call('chat/'. $c . '/badges');
            $json = json_decode($data, true);
            return $json;
        }
        
        static function chat_emotes($e = '0') {
            $data = self::call('chat/emoticon_images?emotesets='. $e);
            $json = json_decode($data, true);
            return $json;
        }

        static function chat_rooms($c) {
            $data = self::call('chat/'.$c.'/rooms');
            $json = json_decode($data, true);
            return $json;
        }

        static function clips_get($s) {
            $data = self::call('clips/'.$s);
            $json = json_decode($data, true);
            return $json;
        }

        static function clips_top($c = '', $g = '', $l = '10', $t = 'false', $p = 'all', $o = '', $lg = null) {
            if(isset($lg)) {
                $alg = '&language=' . $lg;
            }
            $data = self::call('clips/top?channel='. $c . '&game='.$g . '&limit=' . $l . '&trending=' . $t . '&period=' . $p . '&cursor=' . $o . $alg);
            $json = json_decode($data, true);
            return $json;
        }
        
        static function clips_followed($l = '10', $t = 'false', $o = '') {
            $data = self::call('clips/followed?limit='. $l . '&trending='. $t . '&cursor=' . $o);
            $json = json_decode($data, true);
            return $json;
        }

        static function collections($c) {
            $data = self::call('collections/'. $c);
            $json = json_decode($data, true);
            return $json;
        }

        static function collections_items($c) {
            $data = self::call('collections/'. $c . '/items');
            $json = json_decode($data, true);
            return $json;
        }

        static function games_top($l = 10, $o = 0) {
            $data = self::call('games/top?limit='. $l .'&offset='. $o);
            $json = json_decode($data, true);
            return $json;
        }

        static function ingests() {
            $data = self::call('ingests');
            $json = json_decode($data, true);
            return $json;
        }
        
        static function search_channels($q, $l = 25, $o = 0) {
            $data = self::call('search/channels?query='. rawurlencode($q) .'&limit='. $l .'&offset='. $o);
            $json = json_decode($data, true);
            return $json;
        }

        static function search_games($q, $l = 'false') {
            $data = self::call('search/games?query='. rawurlencode($q) .'&live='. $l);
            $json = json_decode($data, true);
            return $json;
        }

        static function search_streams($q, $l = 25, $o = 0, $h = null) {
            if(isset($h)) {
                $sh ='&hls='. $h;
            }
            $data = self::call('search/streams?query='. rawurlencode($q) .'&limit='. $l .'&offset='. $o.$sh);
            $json = json_decode($data, true);
            return $json;
        }

        static function streams_get($c, $t = 'all') {
            $data = self::call('streams/'. $c .'?stream_type='. $t);
            $json = json_decode($data, true);
            return $json;
        }

        static function streams_list($c = null, $g = '', $lg = null,  $t = 'all', $l = '25', $o = '0') {
            if(isset($c)) {
                $sc = '&channel=' . $c;
            }
            if(isset($lg)) {
                $slg = '&language=' . $lg;
            }
            $data = self::call('streams?offset'. $o . $sc . '&game='. $g . $slg .'&stream_type='. $t .'&limit='. $l);
            $json = json_decode($data, true);
            return $json;
        }

        static function streams_summary() {
            $data = self::call('streams/summary');
            $json = json_decode($data, true);
            return $json;
        }

        static function streams_featured($l = 25, $o = 0) {
            $data = self::call('streams/featured?limit='. $l .'&offset='. $o);
            $json = json_decode($data, true);
            return $json;
        }

        static function streams_followed($l = 25, $o = 0, $t = 'all') {
            $data = self::call('streams/followed?limit='. $l .'&offset='. $o .'&stream_type='. $t);
            $json = json_decode($data, true);
            return $json;
        }

        static function teams_all($l = 25, $o = 0) {
            $data = self::call('teams?limit='. $l .'&offset='. $o);
            $json = json_decode($data, true);
            return $json;
        }

        static function teams_get($n) {
            $data = self::call('teams/'. $n);
            $json = json_decode($data, true);
            return $json;
        }

        static function user() {
            $data = self::call('user');
            $json = json_decode($data, true);
            return $json;
        }

        static function user_vhs() {
            $data = self::call('user/vhs');
            $json = json_decode($data, true);
            return $json;
        }

        static function users_get($u) {
            $data = self::call('users/'. $u);
            $json = json_decode($data, true);
            return $json;
        }

        static function users_login($u) {
            $data = self::call('users?login='. $u);
            $json = json_decode($data, true);
            return $json;
        }

        static function users_emotes($u) {
            $data = self::call('users/'. $u . '/emotes');
            $json = json_decode($data, true);
            return $json;
        }

        static function users_subscription($u, $c) {
            $data = self::call('users/'. $u . '/subscriptions/'. $c);
            $json = json_decode($data, true);
            return $json;
        }

        static function users_follows($u, $o = 0, $l = 25, $d = 'desc ', $s = 'created_at') {
            $data = self::call('users/'. $u . '/follows/channels');
            $json = json_decode($data, true);
            return $json;
        }

        static function users_following($u, $c) {
            $data = self::call('users/'. $u . '/follows/channels/'. $c);
            $json = json_decode($data, true);
            return $json;
        }

        static function users_blocks($u, $l = 25, $o = 0) {
            $data = self::call('users/'. $u . '/blocks?limit='. $l . '&offset='. $o);
            $json = json_decode($data, true);
            return $json;
        }

        static function videos_get($v) {
            $data = self::call('videos/'. $v);
            $json = json_decode($data, true);
            return $json;
        }

        static function videos_top($l = 25, $o = 0, $g = null, $p = 'week', $bt = null, $lg = null, $s = 'views') {
            if(isset($lg)) {
                $slg = '&language=' . $lg;
            }
            if(isset($g)) {
                $sg = '&game=' . $g;
            }
            if(isset($bt)) {
                $sbt = '&broadcast_type=' . $bt;
            }
            $data = self::call('videos/top?limit='. $l .'&offset='. $o . $g . '&peroid='. $p . $sbt . $slg .'&sort='. $s);
            $json = json_decode($data, true);
            return $json;
        }

        static function videos_followed($l = 25, $o = 0, $bt = null, $lg = null, $s = 'views') {
            if(isset($lg)) {
                $slg = '&language=' . $lg;
            }
            if(isset($bt)) {
                $sbt = '&broadcast_type=' . $bt;
            }
            $data = self::call('videos/followed?limit='. $l .'&offset='. $o . $sbt .'&sort='. $s);
            $json = json_decode($data, true);
            return $json;
        }
    }
?>