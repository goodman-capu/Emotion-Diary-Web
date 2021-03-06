# API 说明

## 总体说明

* 所有请求均为 HTTP 的 POST 请求，返回 JSON 格式数据
* 所有请求均需含有 `version` 字段，表明客户端的版本，以及 `platform` 字段，表面客户端的平台，其值为 `iOS` `Android` `Web` 之一
* 除了注册、登录和特殊说明的情况之外，所有请求均需含有 `userid` 和 `token` 字段，以进行身份的验证
* 返回码 `code` 为 `0` 时表示请求成功，`data` 字段为返回的数据，否则返回一个对应的错误信息 `message`
* 所有情况下，以下错误码对应固定的含义：
	* `-110` 未知错误
	* `-100` 参数非法
	* `-50` 服务器错误
	* `-10` 客户端版本不支持
	* `-5` 未登录
	* `-1` 参数缺失

## 注册

###### 网址

* `/api/register.php`

###### 参数

* `name` 用户名，不能超过 32 字节，不允许含有任何特殊字符
* `password` 密码，需经过 MD5 加密，大小写编码均可
* `sex` 性别，其值为 `male` `female` 之一，可为空，为空表示保密
* `email` 邮箱，可为空，不能超过 128 字节
* `icon` 头像文件名，可为空
* `personid` Face++ 产生的人脸识别 ID，即返回的 `person_id` 字段，可为空

###### 返回

* `userid` 用户 ID，以后每次请求均需要此 ID
* `token` 用户登录凭据，以后每次请求均需要此 token

## 登录

###### 网址

* `/api/login.php`

###### 参数

* `name`、`email` 二选一，参考注册 API 说明
* `password` 参考注册 API 说明

###### 返回

* `name` 用户名
* 其余参考注册 API 说明

## 登出

###### 网址

* `/api/logout.php`

###### 参数

* 无

###### 返回

* 无

## 查看用户信息

###### 网址

* `/api/view_user.php`

###### 参数

* `name` 用户名

###### 返回

* `name` 用户名
* `sex` 性别，其值为 `male` `female` `secret` 之一
* `icon` 头像文件名，对应文件为 `/images/icon/xxx.jpg`
* `email` 邮箱，只有当查看的是自己的信息时才会返回
* `personid` 人脸识别 ID，只有当查看的是自己的信息时才会返回

## 修改用户信息

###### 网址

* `/api/edit_user.php`

###### 参数

* `name` 用户名，参考注册 API 说明
* `password` 当前密码，参考注册 API 说明
* `new_password` 新密码，不修改密码则留空
* `sex` 性别，参考注册 API 说明
* `email` 邮箱，参考注册 API 说明
* `icon` 头像文件名，参考注册 API 说明
* `personid` 人脸识别 ID，参考注册 API 说明

###### 返回

* 无

## 发布日记

###### 网址

* `/api/post_diary.php`

###### 参数

* `emotion` 情绪值，范围是 0 ~ 100
* `selfie` 自拍像文件名，可为空
* `images` 图片文件名序列，以 ` | ` 作为分隔符（例如 `001 | 002 | 003` ），最多 9 个，可为空
* `tags` 标签序列，以 ` | ` 作为分隔符，可为空
* `text` 日记正文，字符串
* `place_name` 地点名称，字符串，可为空
* `place_long` 地点经度，浮点数，范围 -180 ~ 180，可为空
* `place_lat` 地点纬度，浮点数，范围 -90 ~ 90，可为空
* `weather` 天气，字符串，可为空
* `create_time` 创建时间，使用北京时间，任意格式的字符串，可为空，为空表示当前时间

###### 返回

* `diaryid` 日记的 ID，供以后查询使用

## 查看日记

###### 网址

* `/api/view_diary.php`

###### 参数

* `diaryid` 日记 ID
* `share_key` 分享密钥，可为空，如果该参数存在，此次请求不需要 `userid` 和 `token` 字段

###### 返回

* `emotion` 情绪值
* `selfie` 自拍像文件名，对应文件为 `/images/selfie/xxx.jpg`
* `images` 图片文件名数组，每一个文件名对应文件为 `/images/image/xxx.jpg`
* `tags` 标签数组
* `text` 日记正文
* `place_name` 地点名称
* `place_long` 地点经度
* `place_lat` 地点纬度
* `weather` 天气
* `create_time` 创建日期，北京时间
* `is_shared` 是否被分享

## 同步日记

###### 网址

* `/api/sync_diary.php`

###### 参数

* `year` 年份
* `month` 月份，可为空，为空表示同步全年日记

###### 返回

* `diaries` 一个数组，每个元素代表一个日记，说明如下
	* `diaryid` 日记 ID
	* `emotion` 情绪值
	* `selfie` 自拍像文件名，参考查看日记 API 说明
	* `has_image` 是否有图片
	* `has_tag` 是否有标签
	* `short_text` 日记正文，取前140字节
	* `place_name` 地点名称
	* `weather` 天气
	* `create_time` 创建日期，北京时间

## 搜索日记

###### 网址

* `/api/search_diary.php`

###### 参数

* `keywords` 关键词，以 ` | ` 作分隔符，不要超过五个

###### 返回

* 参考同步日记 API 说明

## 删除日记

###### 网址

* `/api/delete_diary.php`

###### 参数

* `diaryid` 日记 ID

###### 返回

* 无

## 分享日记

###### 网址

* `/api/share_diary.php`

###### 参数

* `diaryid` 日记 ID

###### 返回

* `share_key` 分享秘钥，有此秘钥可不登陆查看日记，参考查看日记 API 说明，网页版可通过 `/web/diary/?diaryid=xxx&share_key=xxx` 查看

## 查看分享列表

###### 网址

* `/api/share_list.php`

###### 参数

* 无

###### 返回

* 参考同步日记 API 说明

## 取消分享日记

###### 网址

* `/api/unshare_diary.php`

###### 参数

* `diaryid` 日记 ID

###### 返回

* 无

## 上传图片

###### 网址

* `/api/upload_image.php`

###### 参数

* `image` 图片字符串，BASE64 编码
* `type` 图片类型，其值为 `icon` `selfie` `image` 之一，分别对应用户头像，自拍，日记图片，大小限制分别为 50KB，100KB，200KB

###### 返回

* `file_name` 头像文件名
