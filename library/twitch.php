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

    class twitchapihelix {

        static function call($request) {
            $url = 'https://api.twitch.tv/helix/'. $request;
            $ch = curl_init();
            curl_setopt_array($ch, array(
            CURLOPT_HTTPHEADER => array(
                'Client-ID: ' . $GLOBALS['config']['Twitch_Client-id'] . '',
                'Authorization: Bearer ' . $GLOBALS['config']['Twitch_Access-token'] . '',
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url
            ));

            $response = curl_exec($ch);
            curl_close($ch);
            return $response;
        }

        static function bits_leaderboard($c = 10, $p = 'all', $sa = null, $u = null) {
            if(isset($sa)) {
                $ssa = '&started_at=' . $sa;
            }
            if(isset($u)) {
                $su = '&user_id='. $u;
            }
            $data = self::call('bits/leaderboard?count'. $c .'&period='. $p . $ssa . $su);
            $json = json_decode($data, true);
            return $json;
        }

        static function clips_id($id) {
            $data = self::call('clips/?id='. $id);
            $json = json_decode($data, true);
            return $json;
        }

        static function clips_broadcaster($id, $f = 20, $sa = null, $ea = null, $a = null, $b = null) {
            if(isset($sa)) {
                $ssa = '&started_at=' . $sa;
            }
            if(isset($ea)) {
                $sea = '&ended_at=' . $ea;
            }
            if(isset($a)) {
                $sa = '&after=' . $a;
            }
            if(isset($b)) {
                $sb = '&before=' . $b;
            }
            $data = self::call('clips?broadcaster_id='. $id .'&first='. $f . $ssa . $ea . $a . $b);
            $json = json_decode($data, true);
            return $json;
        }

        static function clips_game_id($id, $f = 20, $sa = null, $ea = null, $a = null, $b = null) {
            if(isset($sa)) {
                $ssa = '&started_at=' . $sa;
            }
            if(isset($ea)) {
                $sea = '&ended_at=' . $ea;
            }
            if(isset($a)) {
                $sa = '&after=' . $a;
            }
            if(isset($b)) {
                $sb = '&before=' . $b;
            }
            $data = self::call('clips?game_id='. $id .'&first='. $f . $ssa . $ea . $a . $b);
            $json = json_decode($data, true);
            return $json;
        }

        static function games_top($f = 20, $a = null, $b = null) {
            if(isset($a)) {
                $sa = '&after=' . $a;
            }
            if(isset($b)) {
                $sb = '&before=' . $b;
            }
            $data = self::call('games/top?first='. $f . $a . $b);
            $json = json_decode($data, true);
            return $json;
        }

        static function games_id($id) {
            $data = self::call('games?id='. $id);
            $json = json_decode($data, true);
            return $json;
        }

        static function games_name($n) {
            $data = self::call('games?name='. $n);
            $json = json_decode($data, true);
            return $json;
        }

        static function streams($f = 20, $a = null, $b = null, $l = null) {
            $data = self::call('streams?first='. $f . $sa . $sb . $sl);
            $json = json_decode($data, true);
            return $json;
        }

        static function streams_game($id, $f = 20, $a = null, $b = null, $l = null) {
            if(isset($a)) {
                $sa = '&after=' . $a;
            }
            if(isset($b)) {
                $sb = '&before=' . $b;
            }
            if(isset($l)) {
                $sl = '&language=' . $l;
            }

            $data = self::call('streams?game_id='. $id . '&first='. $f . $sa . $sb . $sl );
            $json = json_decode($data, true);
            return $json;
        }

        static function streams_user($t, $u, $a = null, $b = null, $l = null) {
            if($t == 'id') {
                $su = '?user_id='. $u;
            }
            if($t = 'login') {
                $su = '?user_login='. $u;
            }
            if(isset($a)) {
                $sa = '&after=' . $a;
            }
            if(isset($b)) {
                $sb = '&before=' . $b;
            }
            if(isset($l)) {
                $sl = '&language=' . $l;
            }

            $data = self::call('streams'. $su . $sa . $sb . $sl );
            $json = json_decode($data, true);
            return $json;
        }
        
        static function streams_metadata($f = 20, $a = null, $b = null, $l = null) {
            $data = self::call('streams/metadata?first='. $f . $sa . $sb . $sl);
            $json = json_decode($data, true);
            return $json;
        }

        static function streams_metadata_game($id, $f = 20, $a = null, $b = null, $l = null) {
            if(isset($a)) {
                $sa = '&after=' . $a;
            }
            if(isset($b)) {
                $sb = '&before=' . $b;
            }
            if(isset($l)) {
                $sl = '&language=' . $l;
            }

            $data = self::call('streams/metadata?game_id='. $id . '&first='. $f . $sa . $sb . $sl );
            $json = json_decode($data, true);
            return $json;
        }

        static function streams_metadata_user($t, $u, $a = null, $b = null, $l = null) {
            if($t == 'id') {
                $su = '?user_id='. $u;
            }
            if($t == 'login') {
                $su = '?user_login='. $u;
            }
            if(isset($a)) {
                $sa = '&after=' . $a;
            }
            if(isset($b)) {
                $sb = '&before=' . $b;
            }
            if(isset($l)) {
                $sl = '&language=' . $l;
            }

            $data = self::call('streams/metadata'. $su . $sa . $sb . $sl );
            $json = json_decode($data, true);
            return $json;
        }

        static function streams_markers($t, $id, $f = 20, $a = null, $b = null) {
            if($t == 'user') {
                $sid = '?user_id='. $id;
            }
            if($t == 'video') {
                $sid = '?video_id='. $id;
            }
            if(isset($a)) {
                $sa = '&after=' . $a;
            }
            if(isset($b)) {
                $sb = '&before=' . $b;
            }
            if(isset($l)) {
                $sl = '&language=' . $l;
            }

            $data = self::call('streams/markers'. $sid .'&first='. $f . $sa . $sb . $sl);
            $json = json_decode($data, true);
            return $json;
        }

        static function users($t, $id) {
            if($t == 'id') {
                $sid = '?id='. $id;
            }
            if($t == 'login') {
                $sid = '?login='. $id;
            }

            $data = self::call('users'. $sid);
            $json = json_decode($data, true);
            return $json;
        }

        static function users_follows($f, $t= null, $l = 20, $a = null) {
            if(isset($t)) {
                $st = '&to_id='. $t;
            }
            if(isset($a)) {
                $sa = '&after=' . $a;
            }

            $data = self::call('users/follows?from_id='. $f . $st . '&first=' . $l . $sa);
            $json = json_decode($data, true);
            return $json;
        }

        static function users_extensions($u = null) {
            if(isset($u)) {
                $su = '?user_id='. $u;
            }
            $data = self::call('users/extensions'. $su);
            $json = json_decode($data, true);
            return $json;
        }

        static function users_extensions_list() {
            $data = self::call('users/extensions/list');
            $json = json_decode($data, true);
            return $json;
        }

        static function videos($rt, $id, $p = 'all', $s = 'time', $t = 'all', $a = null, $b = null, $f = 20, $l = null) {
            if($rt == 'video') {
                $sid = '?id='. $id;
            }
            if($rt == 'user') {
                $sid = '?user_id='. $id;
            }
            if($rt == 'game') {
                $sid = '?game_id='. $id;
            }
            if(isset($b)) {
                $sb = '&before=' . $b;
            }
            if(isset($l)) {
                $sl = '&language=' . $l;
            }
            $data = self::call('videos'. $sid .'&first='. $f .'&period='. $p . '&sort='. $s .'&type='. $t . $sa . $sb . $sl);
            $json = json_decode($data, true);
            return $json;
        }

        static function webhooks_subscriptions($f = 20, $a = null) {
            if(isset($a)) {
                $sa = '&after=' . $a;
            }
            $data = self::call('webhooks/subscriptions?first='. $f . $as);
            $json = json_decode($data, true);
            return $json;
        }

        
        
    }
?>