<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PushNotification
 *
 * @author mudassar
 */
class PushNotification {

    //put your code here

    private $devicetokens;
    private $message;
    private $pemfile;

    public function __construct($devices, $message) {
        $this->message = $message;
        $this->devicetokens = $devices;
        $this->pemfile = Yii::app()->getBasePath() . "/../cert/" . Constants::PEMFILE;
    }

    public function send_notification() {
        Yii::log($this->message, CLogger::LEVEL_INFO);
        $total = $ok = $nok = 0;

        //echo $totaltokens."</br>";
        $limit=50;
        if ($limit>count($this->devicetokens))
            $limit=count($this->devicetokens);
        for ($i = 0; $i <= count($this->devicetokens); $i = $i + $limit) {
            $this->sendNotificationByLimitOffset($limit, $i, $total, $ok, $nok);
        }

        Yii::log("Sent $ok/$total");
        Yii::log("Failed $nok/$total");


        return "Success";
        
    }

    private function sendNotificationByLimitOffset($limit, $offset, &$total, &$ok, &$nok) {

        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $this->pemfile);
        stream_context_set_option($ctx, 'ssl', 'passphrase', Constants::PASSPHRASE);

        // Open a connection to the APNS server
        $fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$fp) {
            Yii::log("Failed to connect: $err $errstr");
        } else {
            $msgs = "Notification has been sent!";
            Yii::log("Connected to APNS");
        }
// Create the payload body
        $body['aps'] = array(
            'alert' => array(
                'body' => $this->message,
                'action-loc-key' => 'WearXPlay App',
            ),
            'badge' => 1,
            'sound' => 'oven.caf',
        );

// Encode the payload as JSON
        $payload = json_encode($body);
        
        for ($i = $offset; $i < $limit; $i++) {
            $device = $this->devicetokens[$i];
            Yii::log($device->devicetoken);
            try {
                $deviceToken = $device->devicetoken;
                $total ++;
                $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
                // Send it to the server
                $result = fwrite($fp, $msg, strlen($msg));
                Yii::log((string) $result . "========" . strlen((string) $msg));
                if ($result === false || $result == "0") {
                    $nok++;
                    Yii::log("FAILED FOR: $deviceToken");
                } else {
                    $ok++;
                }
            } catch (Exception $e) {
                $nok++;
                Yii::log("FAILED FOR: $deviceToken because " . $e->getMessage());
            }
        }

        fclose($fp);
    }

}
