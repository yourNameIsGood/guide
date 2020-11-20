<?php

$tid = isset($argv[1]) ? $argv[1] : null;
if(!$tid){
    die("PLS enter tweet id pls".PHP_EOL);
}
$pos = strrpos($tid, "/");
$tid = substr($tid, $pos+1);

# curl -v "https://www.google.com" --proxy "https://www.thebiotek.com:4443" --proxy-user 'thebiotek:Pass.1973'

$cmd =<<<PPP
curl --proxy 'https://www.thebiotek.com:4443' --proxy-user 'thebiotek:Pass.1973' 'https://api.twitter.com/2/timeline/conversation/$tid.json?include_profile_interstitial_type=1&include_blocking=1&include_blocked_by=1&include_followed_by=1&include_want_retweets=1&include_mute_edge=1&include_can_dm=1&include_can_media_tag=1&skip_status=1&cards_platform=Web-12&include_cards=1&include_ext_alt_text=true&include_quote_count=true&include_reply_count=1&tweet_mode=extended&include_entities=true&include_user_entities=true&include_ext_media_color=true&include_ext_media_availability=true&send_error_codes=true&simple_quoted_tweet=true&count=20&referrer=home&controller_data=DAACDAABDAABCgABAgUMVNECACEKAAIAAAAAAANACAMACAIAAAAA&include_ext_has_birdwatch_notes=false&ext=mediaStats%2ChighlightedLabel' \
  -H 'authority: api.twitter.com' \
  -H 'pragma: no-cache' \
  -H 'cache-control: no-cache' \
  -H 'authorization: Bearer AAAAAAAAAAAAAAAAAAAAANRILgAAAAAAnNwIzUejRCOuH5E6I8xnZz4puTs%3D1Zv7ttfk8LF81IUq16cHjhLTvJu4FA33AGWWjCpTnA' \
  -H 'x-twitter-client-language: en' \
  -H 'x-csrf-token: bcac5be24ede000668db346a0d3ce4ae' \
  -H 'x-twitter-auth-type: OAuth2Session' \
  -H 'x-twitter-active-user: yes' \
  -H 'user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4229.3 Safari/537.36' \
  -H 'accept: */*' \
  -H 'origin: https://twitter.com' \
  -H 'sec-fetch-site: same-site' \
  -H 'sec-fetch-mode: cors' \
  -H 'sec-fetch-dest: empty' \
  -H 'referer: https://twitter.com/nuki_taro_/status/$tid' \
  -H 'accept-language: en-US,en;q=0.9' \
  -H 'cookie: personalization_id="v1_u2qXXLIMBP6Bqn4JkwjKxg=="; guest_id=v1%3A159749107868190172; ct0=bcac5be24ede000668db346a0d3ce4ae; _ga=GA1.2.1950873089.1597491084; _gid=GA1.2.1047921374.1597491084; dnt=1; ads_prefs="HBESAAA="; kdt=J7iL69iEG2AGfykPaE6Hz8jnoFmnHgdBtA5o917T; remember_checked_on=1; _twitter_sess=BAh7CiIKZmxhc2hJQzonQWN0aW9uQ29udHJvbGxlcjo6Rmxhc2g6OkZsYXNo%250ASGFzaHsABjoKQHVzZWR7ADoPY3JlYXRlZF9hdGwrCNB34%252FFzAToMY3NyZl9p%250AZCIlMjZmMDRlODA0Yjc3MmNmNDcxY2Y3YWFmZWE2MDM3ODU6B2lkIiUyOTg1%250ANWRhNWUxMGNmMDE3NjU1MjBjYmY0NGE1MWFkNjoJdXNlcmwrB9%252Bj%252FXA%253D--4875ea37b09686a8b41a11207e247c98caff39e4; auth_token=c26a9870fe1dadc91c48c3aec42f1b1533d0ee23; twid=u%3D1895670751' \
  --compressed
PPP;

$json = shell_exec($cmd);
echo strlen($json).PHP_EOL;
$arr = json_decode($json, true);
var_export($arr);

if(!isset($arr['globalObjects'])){
    echo PHP_EOL."Login FAIL!";die;
}
$variants = $arr['globalObjects']['tweets'][$tid]['extended_entities']['media'][0]['video_info']['variants'];
$url= "";
foreach($variants as $val){
    if($val['content_type'] == "application/x-mpegURL"){
        $url = $val['url'];
    }
}

echo $url;
$cmd_download = "sh ~/work/code/onionGuide/tools/ffmpegTool.sh $url $tid";
shell_exec($cmd_download);
