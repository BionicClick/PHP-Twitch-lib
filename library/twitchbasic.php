<?php
    class twitchapibasic {

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

        static function oldcall($request) {
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

        static function getgamename($gameid) {
            $data = self::call('games?id='. $gameid);
            $json = json_decode($data, true);
            return $json['data'][0]['name'];
        }

        static function followers($channel) {
            $data = self::oldcall('channels/'. $channel);
            $json = json_decode($data, true);
            return $json['followers'];
        }

        static function currentgame($userid) {
            $data = self::oldcall('channels/'. $userid);
            $json = json_decode($data, true);
            return $json['game'];
        }
        
        static function title($userid) {
            $data = self::oldcall('channels/'. $userid);
            $json = json_decode($data, true);
            return $json['status'];
        }
        
        static function channelviews($channel) {
            $request = 'users?id='. $channel;
            $data = self::call($request);
            $json = json_decode($data, true);
            return $json['data'][0]['view_count'];
        }
        
        static function viewers($channel) {
            $request = 'streams?user_id='. $channel;
            $data = self::call($request);
            $json = json_decode($data, true);
            if($json['data'][0]['type'] == 'live') {
                return $json['data'][0]['viewer_count'];
            } elseif($json['data'][0]['type'] == 'rerun') {
                return 'return';
            } else {
                return 'offline';
            }
        }
        
        static function uptime($channel) {
            $request = 'streams?user_id='. $channel;
            $data = self::call($request);
            $json = json_decode($data, true);
            if(isset($json['data'][0]['id'])) {
                $starttime = new DateTime($json['data'][0]['started_at']);
                $now = new DateTime();
                $time = $starttime->diff($now);
                $makehours= intval($time->format('%a'))*24+intval($time->format('%H'));
                if($makehours > '1') { 
                    $h = $makehours . ' hours ';
                } elseif($makehours == '1') {
                    $h = $makehours . ' hours ';
                } elseif($makehours == '0') {
                    $h = '';
                }
                if($time->format('%i') > '1') { 
                    $i = $time->format('%i minutes ');
                } elseif($time->format('%i') == '1') {
                    $i = $time->format('%i minute ');
                } elseif($time->format('%i') == '0') {
                    $i = 'less than a minute';
                }
                if($makehours > '1') { 
                    $a = 'and ';
                } elseif($makehours == '1') {
                    $a = 'and ';
                } elseif($makehours == '0') {
                    $a = '';
                }
                return $h . $a . $i;
            } else {
                return 'offline';
            }
        }

        static function followage($channel, $user) {
            $request = 'users/follows?to_id='. $channel . '&from_id=' . $user;
            $data = self::call($request);
            $json = json_decode($data, true);
            if(isset($json['data'][0]['followed_at'])) {
                $starttime = new DateTime($json['data'][0]['followed_at']);
                $now = new DateTime();
                $time = $starttime->diff($now);
                if($time->format('%y') > '1') { 
                    $y = $time->format('%y years ');
                } elseif($time->format('%y') == '1') {
                    $y = $time->format('%y year ');
                } elseif($time->format('%y') == '0') {
                    $y = '';
                }
                if($time->format('%m') > '1') { 
                    $m = $time->format('%m months ');
                } elseif($time->format('%m') == '1') {
                    $m = $time->format('%m month ');
                } elseif($time->format('%m') == '0') {
                    $m = '';
                }
                if($time->format('%d') > '1') { 
                    $d = $time->format('%d days ');
                } elseif($time->format('%d') == '1') {
                    $d = $time->format('%d day ');
                } elseif($time->format('%d') == '0') {
                    $d = '';
                }
                if($time->format('%h') > '1') { 
                    $h = $time->format('%h hours ');
                } elseif($time->format('%h') == '1') {
                    $h = $time->format('%h hour ');
                } elseif($time->format('%h') == '0') {
                    $h = '';
                }
                if($time->format('%i') > '1') { 
                    $i = $time->format('%i minutes ');
                } elseif($time->format('%i') == '1') {
                    $i = $time->format('%i minute ');
                } elseif($time->format('%i') == '0') {
                    $i = 'less than a minute';
                }
                if($time->format('%h') > '1') { 
                    $a = 'and ';
                } elseif($time->format('%h') == '1') {
                    $a = 'and ';
                } elseif($time->format('%h') == '0') {
                    if($time->format('%i') > '1') { 
                        $a = 'and ';
                    } elseif($time->format('%i') == '1') {
                        $a = 'and ';
                    } elseif($time->format('%i') == '0') {
                        $a = '';
                    }
                }

                return $y . $m . $d . $h . $a . $i;
            } else {
                return 'not following';
            }
        }

        static function subcount($channel) {
            $request = 'channels/' . $channel . '/subscriptions';
            $data = self::oldcall($request);
            $json = json_decode($data, true);
            $count = --$json['_total'];
            return $count;
        }

        static function laststream($channel) {
            $request = 'channels/' . $channel . '/videos?limit=1&broadcast_type=archive';
            $data = self::oldcall($request);
            $json = json_decode($data, true);
            return $json;
        }

        static function paststreams($channel, $limit) {
            $request = 'channels/' . $channel . '/videos?limit='. $limit .'&broadcast_type=archive';
            $data = self::oldcall($request);
            $json = json_decode($data, true);
            return $json;
        }

        static function highlights($channel, $limit) {
            $request = 'channels/' . $channel . '/videos?limit='. $limit .'&broadcast_type=highlight';
            $data = self::oldcall($request);
            $json = json_decode($data, true);
            return $json;
        }

        static function uploads($channel, $limit) {
            $request = 'channels/' . $channel . '/videos?limit='. $limit .'&broadcast_type=upload';
            $data = self::oldcall($request);
            $json = json_decode($data, true);
            return var_dump($json);
        }

        static function topgames($limit = '25') {
            $request = 'games/top?first='. $limit;
            $data = self::call($request);
            $json = json_decode($data, true);
            return $json;
        }

        static function getclip($clip) {
            $request = '/clips?id='. $clip;
            $data = self::call($request);
            $json = json_decode($data, true);
            return $json;
        }

        static function channelclips($channel) {
            $request = '/clips?broadcaster_id='. $channel;
            $data = self::call($request);
            $json = json_decode($data, true);
            return var_dump($json);
        }

        static function topstreams($amount = '25') {
            $request = '/streams?first='. $amount;
            $data = self::call($request);
            $json = json_decode($data, true);
            return var_dump($json);
        }

        static function bitsleaderboard($period, $count, $started_at = '2018-08-31T00:00:00Z') {
            $request = 'bits/leaderboard?period='. $period .'&count='. $count .'&started_at='. $started_at;
            $data = self::call($request);
            $json = json_decode($data, true);
            return $json;
        }

        static function game($gameid) {
            $request = '/games?id='. $gameid;
            $data = self::call($request);
            $json = json_decode($data, true);
            return $json;
        }
    }
?>