<?php
set_time_limit(10000);
include("libs/PHPCrawler.class.php");
class MyCrawler extends PHPCrawler 
{
  function handleDocumentInfo($DocInfo) 
  {
    if (PHP_SAPI == "cli") $lb = "\n";
    else $lb = "<br />";
    echo "Page requested: ".$DocInfo->url." (".$DocInfo->http_status_code.")".$lb;
    echo "Referer-page: ".$DocInfo->referer_url.$lb;
    if ($DocInfo->received == true){
      echo "Content received: ".$DocInfo->bytes_received." bytes".$lb;
	    echo "Document Content: ".$DocInfo->source.$lb;
    }
    else
      echo "Content not received".$lb; 
    echo $lb;
    flush();
  } 
}
$url="www.flipkart.com/search/a/all?fk-search=all&query=".$_GET[query];
$crawler = new MyCrawler();
$crawler->setURL($url);
$crawler->addContentTypeReceiveRule("#text/html#");
$crawler->addURLFilterRule("#\.(jpg|jpeg|gif|png)$# i");
$crawler->enableCookieHandling(true);
$crawler->setTrafficLimit(1000 * 1024);
$crawler->setPageLimit(5);
$crawler->setFollowMode(3);
$crawler->go();
$report = $crawler->getProcessReport();
if (PHP_SAPI == "cli") $lb = "\n";
else $lb = "<br />";
echo "Summary:".$lb;
echo "Links followed: ".$report->links_followed.$lb;
echo "Documents received: ".$report->files_received.$lb;
echo "Bytes received: ".$report->bytes_received." bytes".$lb;
echo "Process runtime: ".$report->process_runtime." sec".$lb; 
?>