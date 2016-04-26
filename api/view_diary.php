<?php
/**
 * Created by PhpStorm.
 * User: Frank
 * Date: 16/4/26
 * Time: 下午7:41
 */

require_once 'api_utilities.php';
check_version();
$con = db_connect();

$userid = intval(filter($con, $_POST["userid"]));
$diaryid = intval(filter($con, $_POST["diaryid"]));
$share_key = filter($con, $_POST["share_key"]);

// share_key 存在时表明是共享的日记
if (strlen($share_key) == 0) {
    check_login($con);
}

$result = $con->query("SELECT * FROM diary WHERE diaryid = $diaryid");
check_sql_error($con);
$result = mysqli_fetch_array($result);

if (strlen($share_key) > 0) {
    if ($share_key != $result["share_key"]) {
        report_error(1, "该共享不存在");
    }
}else {
    if ($userid != $result["userid"]) {
        report_error(2, "这不是您的日记");
    }
}

$images = explode(" | ", $result["images"]);
$tags = explode(" | ", $result["tags"]);
$return = array(
    "emotion" => $result["emotion"],
    "selfie" => $result["selfie"],
    "images" => $images,
    "tags" => $tags,
    "text" => $result["text"],
    "location_name" => $result["location_name"],
    "location_long" => $result["location_long"],
    "location_lat" => $result["location_lat"],
    "weather" => $result["weather"],
    "create_time" => $result["create_time"],
    "edit_time" => $result["edit_time"]
);
report_success($return);