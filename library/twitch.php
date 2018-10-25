<?php
    class twitchapi {

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

        static function channel($c) {
            $data = self::oldcall('channels/'. $c);
            $json = json_decode($data, true);
            return $json;
        }

        static function channel_editors($c) {
            $data = self::oldcall('channels/'. $c . '/editors');
            $json = json_decode($data, true);
            return $json;
        }

        static function channel_followers($c, $l = '25', $o = '0', $d = 'desc') {
            $data = self::oldcall('channels/'. $c . '/follows?limit='. $l .'&offset='. $o .'&direction=' . $d);
            $json = json_decode($data, true);
            return $json;
        }

        static function channel_teams($c) {
            $data = self::oldcall('channels/'. $c . '/teams');
            $json = json_decode($data, true);
            return $json;
        }

        static function channel_subscriptions($c, $l = '25', $o = '0', $d = 'desc') {
            $data = self::oldcall('channels/'. $c . '/subscriptions?limit='. $l .'&offset='. $o .'&direction=' . $d);
            $json = json_decode($data, true);
            return $json;
        }

        static function channel_check_subscription($c, $s) {
            $data = self::oldcall('channels/'. $c . '/subscriptions/'.$s);
            $json = json_decode($data, true);
            return $json;
        }

        static function channel_videos($c, $l = '25', $o = '0', $bt = '', $lg = '', $s = 'time') {
            $data = self::oldcall('channels/'. $c . '/videos?limit='.$l . '&offset=' . $o . '&broadcast_type=' . $bt . '&language=' . $lg . '&sort=' . $s);
            $json = json_decode($data, true);
            return $json;
        }
    }
?>