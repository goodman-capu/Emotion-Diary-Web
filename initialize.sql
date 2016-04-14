-- Emotion Diary initial database structure

-- Table structure for table `user`

CREATE TABLE `user` (
	`id` varchar(128) NOT NULL,
	`name` varchar(30) NOT NULL,
	`register_time` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
	`latest_time` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
	PRIMARY KEY(`id`)
);