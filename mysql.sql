CREATE TABLE `friend` (
                          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                          `created_at` int(11) NOT NULL DEFAULT '0',
                          `updated_at` int(11) NOT NULL DEFAULT '0',
                          `friend_uid` int(11) NOT NULL DEFAULT '0' COMMENT '朋友id',
                          `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
                          `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '群id',
                          `is_delete` tinyint(1) NOT NULL DEFAULT '0',
                          PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='朋友';

CREATE TABLE `group` (
                         `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                         `created_at` int(11) NOT NULL DEFAULT '0',
                         `updated_at` int(11) NOT NULL DEFAULT '0',
                         `name` varchar(100) NOT NULL DEFAULT '' COMMENT '群名',
                         `uid` int(11) NOT NULL DEFAULT '0',
                         `is_delete` tinyint(1) NOT NULL DEFAULT '0',
                         PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='分组';

CREATE TABLE `user` (
                        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                        `name` varchar(100) NOT NULL DEFAULT '' COMMENT '用户名',
                        `password` varchar(255) NOT NULL DEFAULT '' COMMENT 'md5密码',
                        `created_at` int(11) NOT NULL DEFAULT '0',
                        `updated_at` int(11) NOT NULL DEFAULT '0',
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB   DEFAULT CHARSET=utf8mb4 COMMENT='用户信息';

CREATE TABLE `user_group` (
                              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                              `created_at` int(11) NOT NULL DEFAULT '0',
                              `updated_at` int(11) NOT NULL DEFAULT '0',
                              `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
                              `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '分组id',
                              `friend_uid` int(11) NOT NULL DEFAULT '0' COMMENT '朋友id',
                              `is_delete` tinyint(1) NOT NULL DEFAULT '0',
                              PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COMMENT='用户分组';