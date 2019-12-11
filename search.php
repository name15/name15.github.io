<?php
$xmlDoc=new DOMDocument();
$xmlDoc->load("data.xml");
$x=$xmlDoc->getElementsByTagName('word');


//get the q parameter from URL
$q= $_GET["q"];

//lookup all links from the xml file if length of q>0
if (strlen($q)>0) {
  $suggestions=array();
  $similar=array();
  for($i=0; $i<($x->length); $i++) {
	if ($x->item(0)->nodeType==1) {
      if (strstr($x->item($i)->childNodes->item(0)->nodeValue, $q)) {
        array_push($suggestions, $x->item($i)->childNodes->item(0)->nodeValue);
      }
      else if (stristr($x->item($i)->childNodes->item(0)->nodeValue, $q))
      {
        array_push($similar, $x->item($i)->childNodes->item(0)->nodeValue);
      }
    }
  }
}

rsort($suggestions);  // - if the .xml file isnt sorted already
rsort($similar); 

if (count($suggestions)==0) {
	if (count($similar)==0){
		$response = "No words found.";
	}
	else
	{
       $response="Similar words:<br>".join("<br>",$similar);
    }
} else {
  $response=join("<br>",$suggestions);
}

//output the response
echo $response;
?>