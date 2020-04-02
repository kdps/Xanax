<?php

class FirebaseCloudMessaging {
  public function sendToChannel($token, $title, $body, $channelIdentify, $clickAction) {
    $postData = array(
      'to' => $token,
      'notification' => array(
        'title' => $title,
        'body' => $body,
        'android_channel_id' => $channelId,
        'click_action' => $clickAction
      )
    );

    $headers = array(
      'Authorization: key=',
      'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($postData) );
    $result = curl_exec($ch);
    curl_close($c);

    return $result;
  }
}
