
<?php
try {
    $oauth = new OAuth('b857aa84517dcedd64f77700181cc13c','0e2b798cb2c128fc136895739f856ca0aeadc900');
    $request_token_info = $oauth->getRequestToken("https://api.4shared.com/v1_2/oauth/initiate");
    if(!empty($request_token_info)) {
        print_r($request_token_info);
    } else {
        print "Failed fetching request token, response was: " . $oauth->getLastResponse();
    }
} catch(OAuthException $E) {
    echo "Response: ". $E->lastResponse . "\n";
}
?>
