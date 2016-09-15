<!DOCTYPE HTML>
<html>
<body>
<?php
$TextOut = "";
$token = "AQAAAAAH8ejxAADLW8NtBYId1E8sk7hIOaITl3Y";
function get_stat($url, $headers)
{
    $handle = curl_init();123123
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($handle);
    $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    return array("code"=>$code,"response"=>$response);
}

$endFiles = false;
$shift = 0;
$json_data = array();

while ($endFiles == false) {
    $result = get_stat('https://cloud-api.yandex.net:443/v1/disk/resources/files?limit=10&offset=' . $shift, array('Authorization: OAuth ' . $token));
    $shift += 10;
    $json = json_decode($result["response"]);
    //echo "<p>" . $result["code"] . "</p>";
    echo "<p>" . count($json->items) . "</p>";
    if (count($json->items) == 0) {
        $endFiles = true;
        break;
    }
    foreach ($json->items as $content) {
        array_push($json_data , array($content->name, $content->created, $content->modified, $content->size));
        echo "<p>" . $content->name . "</p>";
    }
};



$TextOut = $json_data[1][3];
?>
<p><?php echo $TextOut ?></p>
</body>
</html>
