<?php
    class twitchapiv3 {

        static function call($request) {
            $url = 'https://api.twitch.tv/kraken/'. $request;
            $ch = curl_init();
            curl_setopt_array($ch, array(
            CURLOPT_HTTPHEADER => array(
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

        static function followers($channel) {
            $request = 'channels/'. $channel;
            $data = self::call($request);
            $json = json_decode($data, true);
            return $json['followers'];
        }

        static function game($channel) {
            $request = 'channels/'. $channel;
            $data = self::call($request);
            $json = json_decode($data, true);
            return $json['game'];
        }
        
        static function title($channel) {
            $request = 'channels/'. $channel;
            $data = self::call($request);
            $json = json_decode($data, true);
            return $json['status'];
        }
        
        static function channelviews($channel) {
            $request = 'channels/'. $channel;
            $data = self::call($request);
            $json = json_decode($data, true);
            return $json['views'];
        }
        
        static function viewers($channel) {
            $request = 'streams/'. $channel;
            $data = self::call($request);
            $json = json_decode($data, true);
            if($json['stream']['stream_type'] == 'live') {
                return $json['stream']['viewers'];
            } elseif($json['stream']['stream_type'] == 'rerun') {
                return 'return';
            } else {
                return 'offline';
            }
        }
        
        static function uptime($channel) {
            $request = 'streams/'. $channel;
            $data = self::call($request);
            $json = json_decode($data, true);
            if(isset($json['stream']['_id'])) {
                $starttime = new DateTime($json['stream']['created_at']);
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
            $request = 'users/'. $user . '/follows/channels/' . $channel;
            $data = self::call($request);
            $json = json_decode($data, true);
            if(isset($json['created_at'])) {
                $starttime = new DateTime($json['created_at']);
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
                return $user . ' is not following';
            }
        }

        static function subcount($channel) {
            $request = 'channels/' . $channel . '/subscriptions';
            $data = self::call($request);
            $json = json_decode($data, true);
            $count = --$json['_total'];
            return $count;
        }


        // test
        static function test($channel) {
            $request = 'channels/' . $channel;
            $data = self::call($request);
            $json = json_decode($data, true);
            return $data;
        }
    }
?>