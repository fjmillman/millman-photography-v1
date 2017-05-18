START TRANSACTION;

CREATE DATABASE IF NOT EXISTS `millman_photography`;

USE `millman_photography`;

DROP TABLE `user`;

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL DEFAULT '',
  `token` varchar(256) NOT NULL DEFAULT '',
  `is_admin` tinyint(1) unsigned NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `user` (`id`, `username`, `password`, `token`, `is_admin`, `date_created`, `date_modified`)
VALUES
  (1, 'fred', 'f73ddi3MP', '12345', 1, '2017-01-01 00:00:00', '2017-01-01 00:00:00');

DROP TABLE `blog_post`;

CREATE TABLE `blog_post` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `title` varchar(100) NOT NULL,
  `body` text NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_blog_post_user_id` (`user_id`),
  CONSTRAINT `fk_blog_post_user_id__user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `blog_post` (`id`, `user_id`, `title`, `body`, `date_created`, `date_modified`)
VALUES
  (1, 1, 'Title', 'Content', '2017-01-01 00:00:00', '2017-01-01 00:00:00');

COMMIT;