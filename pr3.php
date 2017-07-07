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
	  //$temp = html_to_obj($response);
   //       $temp2 = $temp['children'][1];
    //      $temp3 = $temp2['children'][0]['children'][0]['children'][58]['children'][2]['children'];
          //$temp2 = preg_replace('/\\/s[0-9][0-9]\\//u', '/', $temp2);
	 // echo html_to_obj($response);
          //echo '<pre>'; print_r($temp2); echo '</pre>';
        //  echo json_encode($temp3);
          // echo '<pre>'; print_r($temp3); echo '</pre>';
          
          $temp_dom = new DOMDocument();
          
         $dom = new DOMDocument();
         $dom->loadHTML($response);
        $response_xpath =  new DOMXPath($dom);
		$response_row1 = $response_xpath->query("//a[contains(@data-element, 'r1.')]");// | //a[contains(@href, '4shared.com/img/')] | //a[contains(@href, '4shared.com/u/')] | //a[contains(@href, '4shared.com/folder/')] | //td[@class='tdC']/img[@src]");
     
        $response_row2 = $response_xpath->query("//a[contains(@data-element, 'r2.')]");
        $response_row3 = $response_xpath->query("//a[contains(@data-element, 'r3.')]");
        $response_row4 = $response_xpath->query("//a[contains(@data-element, 'r4.')]");
        $response_row5 = $response_xpath->query("//a[contains(@data-element, 'r5.')]");
        $response_row6 = $response_xpath->query("//a[contains(@data-element, 'r6.')]");
        $response_row7 = $response_xpath->query("//a[contains(@data-element, 'r7.')]");
        $response_row8 = $response_xpath->query("//a[contains(@data-element, 'r8.')]");
        $response_row9 = $response_xpath->query("//a[contains(@data-element, 'r9.')]");
        $response_row10 = $response_xpath->query("//a[contains(@data-element, 'r10.')]");
        $response_row11 = $response_xpath->query("//a[contains(@data-element, 'r11.')]");
        $response_row12 = $response_xpath->query("//a[contains(@data-element, 'r12.')]");
        $response_row13 = $response_xpath->query("//a[contains(@data-element, 'r13.')]");
        $response_row14 = $response_xpath->query("//a[contains(@data-element, 'r14.')]");
        $response_row15 = $response_xpath->query("//a[contains(@data-element, 'r15.')]");
        $response_row16 = $response_xpath->query("//a[contains(@data-element, 'r16.')]");
        $response_row17 = $response_xpath->query("//a[contains(@data-element, 'r17.')]");
        $response_row18 = $response_xpath->query("//a[contains(@data-element, 'r18.')]");
        $response_row19 = $response_xpath->query("//a[contains(@data-element, 'r19.')]");
        $response_row20 = $response_xpath->query("//a[contains(@data-element, 'r20.')]");

      //  echo "<pre>";  var_dump( $response_row1); echo "</pre>";
     
     
        //    $response_row = $response_xpath->query("//td@class='tdC'");
       $div1 = $temp_dom->createElement("div1");
        $temp_dom->appendchild($div1);
           if($response_row1->length > 0){
			foreach($response_row1 as $row){
			  // $temp_dom = new DOMDocument();
			//echo "<pre>";  print_r( $row); echo "</pre>";
			$div1->appendChild($temp_dom->importNode($row,true));
			// echo json_encode(element_to_obj($temp_dom));
			 
			// unset($temp_dom);
			 
			}
         }  
  
  
       $div2 = $temp_dom->createElement("div2");
        $temp_dom->appendchild($div2);
           if($response_row2->length > 0){
			foreach($response_row2 as $row){
			  // $temp_dom = new DOMDocument();
			//echo "<pre>";  print_r( $row); echo "</pre>";
			$div2->appendChild($temp_dom->importNode($row,true));
			// echo json_encode(element_to_obj($temp_dom));
			 
			// unset($temp_dom);
			 
			}
         }  
  
       $div3 = $temp_dom->createElement("div3");
        $temp_dom->appendchild($div3);
           if($response_row3->length > 0){
			foreach($response_row3 as $row){
			  // $temp_dom = new DOMDocument();
			//echo "<pre>";  print_r( $row); echo "</pre>";
			$div3->appendChild($temp_dom->importNode($row,true));
			// echo json_encode(element_to_obj($temp_dom));
			 
			// unset($temp_dom);
			 
			}
         }  
  
       $div4 = $temp_dom->createElement("div4");
        $temp_dom->appendchild($div4);
           if($response_row4->length > 0){
			foreach($response_row4 as $row){
			  // $temp_dom = new DOMDocument();
			//echo "<pre>";  print_r( $row); echo "</pre>";
			$div4->appendChild($temp_dom->importNode($row,true));
			// echo json_encode(element_to_obj($temp_dom));
			 
			// unset($temp_dom);
			 
			}
         }  
  
       $div5 = $temp_dom->createElement("div5");
        $temp_dom->appendchild($div5);
           if($response_row5->length > 0){
			foreach($response_row5 as $row){
			  // $temp_dom = new DOMDocument();
			//echo "<pre>";  print_r( $row); echo "</pre>";
			$div5->appendChild($temp_dom->importNode($row,true));
			// echo json_encode(element_to_obj($temp_dom));
			 
			// unset($temp_dom);
			 
			}
         }  
  
       $div6 = $temp_dom->createElement("div6");
        $temp_dom->appendchild($div6);
           if($response_row6->length > 0){
			foreach($response_row6 as $row){
			  // $temp_dom = new DOMDocument();
			//echo "<pre>";  print_r( $row); echo "</pre>";
			$div6->appendChild($temp_dom->importNode($row,true));
			// echo json_encode(element_to_obj($temp_dom));
			 
			// unset($temp_dom);
			 
			}
         }  
  
       $div7 = $temp_dom->createElement("div7");
        $temp_dom->appendchild($div7);
           if($response_row7->length > 0){
			foreach($response_row7 as $row){
			  // $temp_dom = new DOMDocument();
			//echo "<pre>";  print_r( $row); echo "</pre>";
			$div7->appendChild($temp_dom->importNode($row,true));
			// echo json_encode(element_to_obj($temp_dom));
			 
			// unset($temp_dom);
			 
			}
         }  
  
       $div8 = $temp_dom->createElement("div8");
        $temp_dom->appendchild($div8);
           if($response_row8->length > 0){
			foreach($response_row8 as $row){
			  // $temp_dom = new DOMDocument();
			//echo "<pre>";  print_r( $row); echo "</pre>";
			$div8->appendChild($temp_dom->importNode($row,true));
			// echo json_encode(element_to_obj($temp_dom));
			 
			// unset($temp_dom);
			 
			}
         }  
  
       $div9 = $temp_dom->createElement("div9");
        $temp_dom->appendchild($div9);
           if($response_row9->length > 0){
			foreach($response_row9 as $row){
			  // $temp_dom = new DOMDocument();
			//echo "<pre>";  print_r( $row); echo "</pre>";
			$div9->appendChild($temp_dom->importNode($row,true));
			// echo json_encode(element_to_obj($temp_dom));
			 
			// unset($temp_dom);
			 
			}
         }  
  
       $div10 = $temp_dom->createElement("div10");
        $temp_dom->appendchild($div10);
           if($response_row10->length > 0){
			foreach($response_row10 as $row){
			  // $temp_dom = new DOMDocument();
			//echo "<pre>";  print_r( $row); echo "</pre>";
			$div10->appendChild($temp_dom->importNode($row,true));
			// echo json_encode(element_to_obj($temp_dom));
			 
			// unset($temp_dom);
			 
			}
         }  
  
       $div11 = $temp_dom->createElement("div11");
        $temp_dom->appendchild($div11);
           if($response_row11->length > 0){
			foreach($response_row11 as $row){
			  // $temp_dom = new DOMDocument();
			//echo "<pre>";  print_r( $row); echo "</pre>";
			$div11->appendChild($temp_dom->importNode($row,true));
			// echo json_encode(element_to_obj($temp_dom));
			 
			// unset($temp_dom);
			 
			}
         }  
  
       $div12 = $temp_dom->createElement("div12");
        $temp_dom->appendchild($div12);
           if($response_row12->length > 0){
			foreach($response_row12 as $row){
			  // $temp_dom = new DOMDocument();
			//echo "<pre>";  print_r( $row); echo "</pre>";
			$div12->appendChild($temp_dom->importNode($row,true));
			// echo json_encode(element_to_obj($temp_dom));
			 
			// unset($temp_dom);
			 
			}
         }  
  
       $div13 = $temp_dom->createElement("div13");
        $temp_dom->appendchild($div13);
           if($response_row13->length > 0){
			foreach($response_row13 as $row){
			  // $temp_dom = new DOMDocument();
			//echo "<pre>";  print_r( $row); echo "</pre>";
			$div13->appendChild($temp_dom->importNode($row,true));
			// echo json_encode(element_to_obj($temp_dom));
			 
			// unset($temp_dom);
			 
			}
         }  
  
       $div14 = $temp_dom->createElement("div14");
        $temp_dom->appendchild($div14);
           if($response_row14->length > 0){
			foreach($response_row14 as $row){
			  // $temp_dom = new DOMDocument();
			//echo "<pre>";  print_r( $row); echo "</pre>";
			$div14->appendChild($temp_dom->importNode($row,true));
			// echo json_encode(element_to_obj($temp_dom));
			 
			// unset($temp_dom);
			 
			}
         }  
  
       $div15 = $temp_dom->createElement("div15");
        $temp_dom->appendchild($div15);
           if($response_row15->length > 0){
			foreach($response_row15 as $row){
			  // $temp_dom = new DOMDocument();
			//echo "<pre>";  print_r( $row); echo "</pre>";
			$div15->appendChild($temp_dom->importNode($row,true));
			// echo json_encode(element_to_obj($temp_dom));
			 
			// unset($temp_dom);
			 
			}
         }  
  
       $div16 = $temp_dom->createElement("div16");
        $temp_dom->appendchild($div16);
           if($response_row16->length > 0){
			foreach($response_row16 as $row){
			  // $temp_dom = new DOMDocument();
			//echo "<pre>";  print_r( $row); echo "</pre>";
			$div16->appendChild($temp_dom->importNode($row,true));
			// echo json_encode(element_to_obj($temp_dom));
			 
			// unset($temp_dom);
			 
			}
         }  
  
       $div17 = $temp_dom->createElement("div17");
        $temp_dom->appendchild($div17);
           if($response_row17->length > 0){
			foreach($response_row17 as $row){
			  // $temp_dom = new DOMDocument();
			//echo "<pre>";  print_r( $row); echo "</pre>";
			$div17->appendChild($temp_dom->importNode($row,true));
			// echo json_encode(element_to_obj($temp_dom));
			 
			// unset($temp_dom);
			 
			}
         }  
  
       $div18 = $temp_dom->createElement("div18");
        $temp_dom->appendchild($div18);
           if($response_row18->length > 0){
			foreach($response_row18 as $row){
			  // $temp_dom = new DOMDocument();
			//echo "<pre>";  print_r( $row); echo "</pre>";
			$div18->appendChild($temp_dom->importNode($row,true));
			// echo json_encode(element_to_obj($temp_dom));
			 
			// unset($temp_dom);
			 
			}
         }  
  
       $div19 = $temp_dom->createElement("div19");
        $temp_dom->appendchild($div19);
           if($response_row19->length > 0){
			foreach($response_row19 as $row){
			  // $temp_dom = new DOMDocument();
			//echo "<pre>";  print_r( $row); echo "</pre>";
			$div19->appendChild($temp_dom->importNode($row,true));
			// echo json_encode(element_to_obj($temp_dom));
			 
			// unset($temp_dom);
			 
			}
         }  
  
       $div20 = $temp_dom->createElement("div20");
        $temp_dom->appendchild($div20);
           if($response_row20->length > 0){
			foreach($response_row20 as $row){
			  // $temp_dom = new DOMDocument();
			//echo "<pre>";  print_r( $row); echo "</pre>";
			$div20->appendChild($temp_dom->importNode($row,true));
			// echo json_encode(element_to_obj($temp_dom));
			 
			// unset($temp_dom);
			 
			}
         }  
  
  
  
  
  
         
        //  echo '<pre>'; print_r($temp_dom->saveHTML()); echo '</pre>';  
      
        //   print_r($temp_dom->saveHTML());
           
            echo json_encode(element_to_obj($temp_dom));
           
           
function html_to_obj($html) {
    $dom = new DOMDocument();
    $dom->loadHTML($html);
    return element_to_obj($dom->documentElement);
}

function element_to_obj($element) {
   // echo $element->tagName, "\n";
    $obj = array( $element->tagName => $element->tagName );
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