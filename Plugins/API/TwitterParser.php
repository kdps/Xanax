<?php

include('./vendor/autoload.php');

use Xanax\Classes\ClientURL as ClientURL;

class TwitterParser {

  private $guestToken;
  private $token = "AAAAAAAAAAAAAAAAAAAAANRILgAAAAAAnNwIzUejRCOuH5E6I8xnZz4puTs%3D1Zv7ttfk8LF81IUq16cHjhLTvJu4FA33AGWWjCpTnA";
  
  public function __construct() {
    $this->guestToken = $this->getGuestToken();
  }
  
  public function getGuestToken() {
    $cURL = new ClientURL();
    $cURL->Option->setURL('https://api.twitter.com/1.1/guest/activate.json')
      ->setPostField(true)
      ->setHeaders($headers)
      ->setReturnTransfer(true)
      ->setAutoReferer(true)
      ->setReturnHeader(false)
      ->disableCache(true);

      $result = $cURL->Execute();
      $guestToken = json_decode($result)->guest_token;
      
      return $guestToken;
  }
  
  public function getUserTweetsAndReplies($userId) {
    $headers = array(
      'authorization:Bearer '.$this->token,
      'x-guest-token:'.$guestToken
    );

    $cURL = new ClientURL();
    $cURL->Option->setURL("https://twitter.com/i/api/graphql/2Kp5fEiA-6QtZoCKRCcGKg/UserTweetsAndReplies?variables=%7B%22userId%22%3A%2".$userId."%22%2C%22count%22%3A20%2C%22withHighlightedLabel%22%3Atrue%2C%22withTweetQuoteCount%22%3Atrue%2C%22includePromotedContent%22%3Atrue%2C%22withTweetResult%22%3Afalse%2C%22withReactions%22%3Afalse%2C%22withUserResults%22%3Afalse%2C%22withVoice%22%3Afalse%2C%22withNonLegacyCard%22%3Atrue%2C%22withBirdwatchPivots%22%3Afalse%7D")
      ->setPostMethod(false)
      ->setHeaders($headers)
      ->setReturnTransfer(true)
      ->setAutoReferer(true)
      ->setReturnHeader(false)
      ->disableCache(true);

    $result = $cURL->Execute();
    return json_decode($result)->data->user->result;
  }
  
}
