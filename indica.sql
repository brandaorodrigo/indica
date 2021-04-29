CREATE TABLE IF NOT EXISTS `channels` (
    `id` int(11) NOT NULL,
    `user` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
    `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
    `url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
    `game` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
    `views` int(11) NOT NULL,
    `followers` int(11) NOT NULL,
    `image_logo` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
    `image_game` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
    `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `channels` ADD PRIMARY KEY (`id`), ADD KEY `id` (`id`);

CREATE TABLE IF NOT EXISTS `images` (
    `id` int(11) NOT NULL,
    `image_custom` varchar(200) COLLATE utf8_unicode_ci NULL,
    `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `images` ADD PRIMARY KEY (`id`), ADD KEY `id` (`id`);

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL,
  `channel` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `game` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `caller` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;