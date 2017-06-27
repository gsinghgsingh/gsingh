<?php
	 error_reporting(0); 
	
	  /***************************************************************************
	   * <true> to only proxy to the sites listed in '$serverUrls'
	   * <false> to proxy to any site (are you sure you want to do this?)
	   */
	  $mustMatch = FALSE;
	  
	  /***************************************************************************
	  
	   * 
	   * 'url'      = location of the  Server, either specific URL or stem
	   * 'matchAll' = <true> to forward any request beginning with the URL
	   *              <false> to forward only the request that exactly matches the url
	   * 'token'    = token to include for secured service, if any, otherwise leave it
	   *              empty
	   */
	  $serverUrls = array(
	    array( 'url' => 'http://asdjfioaj.com', 'matchAll' => true, 'token' => '' )
	  );
	  /***************************************************************************/
	  
	  function is_url_allowed($allowedServers, $url) {
	    $isOk = false;
	    $url = trim($url, "\/");
	    for ($i = 0, $len = count($allowedServers); $i < $len; $i++) {
	      $value = $allowedServers[$i];
	      $allowedUrl = trim($value['url'], "\/");
	      if ($value['matchAll']) {
	        if (stripos($url, $allowedUrl) === 0) {
	          $isOk = $i; // array index that matched
	          break;
	        }
	      }
	      else {
	        if ((strcasecmp($url, $allowedUrl) == 0)) {
	          $isOk = $i; // array index that matched
	          break;
	        }
	      }
	    }
	    return $isOk;
	  }
	  
	  // check if the curl extension is loaded
	  if (!extension_loaded("curl")) {
	    header('Status: 500', true, 500);
	    echo 'cURL extension for PHP is not loaded! <br/> Add the following lines to your php.ini file: <br/> extension_dir = &quot;&lt;your-php-install-location&gt;/ext&quot; <br/> extension = php_curl.dll';
	    return;
	  }
	  
	  $targetUrl = $_SERVER['QUERY_STRING'];
	  if (!$targetUrl) {
	    header('Status: 400', true, 400); // Bad Request
	    echo 'Target URL is not specified! <br/> Usage: <br/> http://&lt;this-proxy-url&gt;?&lt;target-url&gt;';
	    return;
	  }
	  
	  $parts = preg_split("/\?/", $targetUrl);
	  $targetPath = $parts[0];
	  
	  // check if the request URL matches any of the allowed URLs
	
	  if ($mustMatch) {
	 $pos = is_url_allowed($serverUrls, $targetPath);
	 if ($pos === false) {
	  header('Status: 403', true, 403); // Forbidden
	  echo 'Target URL is not allowed! <br/> Consult the documentation for this proxy to add the target URL to its Whitelist.';
	  return;
	 }
	   
	 // add token (if any) to the url
	 $token = $serverUrls[$pos]['token'];
	 if ($token) {
	  $targetUrl .= (stripos($targetUrl, "?") !== false ? '&' : '?').'token='.$token;
	 }
	  }
	  // open the curl session
	  $session = curl_init();
	  /*foreach ($_SERVER as $key => $value) {
	 print "$key: $value<br>\n";
	}*/
	  // set the appropriate options for this request
	  // increase timeout from 60 seconds
	  $options = array(
	    CURLOPT_URL => $targetUrl,
	    CURLOPT_HEADER => false,
	    CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_FOLLOWLOCATION => true,
	 CURLOPT_TIMEOUT => 240
	  );
	
	  if ( array_key_exists('CONTENT_TYPE', $_SERVER) and array_key_exists('HTTP_REFERER', $_SERVER) ){
	    $options[CURLOPT_HTTPHEADER] = array(
	      'Content-Type: ' . $_SERVER['CONTENT_TYPE'],
	      'Referer: ' . $_SERVER['HTTP_REFERER']
	    );
	  }
	  
	  // put the POST data in the request body
	  $postData = file_get_contents("php://input");
	  if (strlen($postData) > 0) {
	    $options[CURLOPT_POST] = true;
	    $options[CURLOPT_POSTFIELDS] = $postData;
	  }
	  curl_setopt_array($session, $options);
	  
	  // make the call
	  $response = curl_exec($session);
	  $code = curl_getinfo($session, CURLINFO_HTTP_CODE);
	  $type = curl_getinfo($session, CURLINFO_CONTENT_TYPE);
	  curl_close($session);
	  
	  // set the proper Content-Type
	  header("Status: ".$code, true, $code);
	  header("Content-Type: ".$type);
	  $temp = html_to_obj($response);
          $temp2 = $temp['children'][1];
	 // echo html_to_obj($response);
          //echo '<pre>'; print_r($temp2); echo '</pre>';
          echo json_encode($temp2);
function html_to_obj($html) {
    $dom = new DOMDocument();
    $dom->loadHTML($html);
    return element_to_obj($dom->documentElement);
}

function element_to_obj($element) {
   // echo $element->tagName, "\n";
    $obj = array( "tag" => $element->tagName );
    foreach ($element->attributes as $attribute) {
        $obj[$attribute->name] = $attribute->value;
    }
    foreach ($element->childNodes as $subElement) {
        if ($subElement->nodeType == XML_TEXT_NODE) {
            $obj["html"] = $subElement->wholeText;
        }
        elseif ($subElement->nodeType == XML_CDATA_SECTION_NODE) {
          //  $obj["html"] = $subElement->data;
        }
        else {
            $obj["children"][] = element_to_obj($subElement);
        }
    }
    return $obj;
}

	?>