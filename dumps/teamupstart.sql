SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `chats`;
CREATE TABLE `chats` (
                         `id` int NOT NULL AUTO_INCREMENT,
                         `user1_id` int DEFAULT NULL,
                         `user2_id` int DEFAULT NULL,
                         PRIMARY KEY (`id`),
                         KEY `user1_id` (`user1_id`),
                         KEY `user2_id` (`user2_id`),
                         CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`user1_id`) REFERENCES `users` (`id`),
                         CONSTRAINT `chats_ibfk_2` FOREIGN KEY (`user2_id`) REFERENCES `users` (`id`)
);

DROP TABLE IF EXISTS `like_resume`;
CREATE TABLE `like_resume` (
                               `id` int NOT NULL AUTO_INCREMENT,
                               `id_resume` int NOT NULL,
                               `id_user` int NOT NULL,
                               `status` int NOT NULL,
                               PRIMARY KEY (`id`),
                               KEY `id_resume` (`id_resume`),
                               KEY `id_user` (`id_user`),
                               CONSTRAINT `like_resume_ibfk_1` FOREIGN KEY (`id_resume`) REFERENCES `resume` (`id`),
                               CONSTRAINT `like_resume_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
);
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
                            `id` int NOT NULL AUTO_INCREMENT,
                            `chat_id` int DEFAULT NULL,
                            `sender_id` int DEFAULT NULL,
                            `message` text,
                            `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                            PRIMARY KEY (`id`),
                            KEY `chat_id` (`chat_id`),
                            KEY `sender_id` (`sender_id`),
                            CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`),
                            CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`)
);

DROP TABLE IF EXISTS `resume`;
CREATE TABLE `resume` (
                          `id` int NOT NULL AUTO_INCREMENT,
                          `user_id` int NOT NULL,
                          `adress` varchar(255) NOT NULL,
                          `education` varchar(255) NOT NULL,
                          `lang` varchar(255) NOT NULL,
                          `certifications` varchar(255) NOT NULL,
                          `skills` varchar(255) NOT NULL,
                          `description` varchar(255) NOT NULL,
                          `schedule` varchar(255) NOT NULL,
                          `from_price` int NOT NULL,
                          `age_user` varchar(255) NOT NULL,
                          `experience` varchar(255) NOT NULL,
                          `languages` varchar(255) NOT NULL,
                          `status` int NOT NULL,
                          `unique_new_resume_id` int DEFAULT '0',
                          `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
                          PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `team`;
CREATE TABLE `team` (
                        `id_team` int NOT NULL AUTO_INCREMENT,
                        `id_user_1` int NOT NULL,
                        `id_user_2` int NOT NULL,
                        `status` int NOT NULL,
                        `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                        PRIMARY KEY (`id_team`),
                        KEY `id_user_1` (`id_user_1`),
                        KEY `id_user_2` (`id_user_2`),
                        CONSTRAINT `team_ibfk_1` FOREIGN KEY (`id_user_1`) REFERENCES `users` (`id`),
                        CONSTRAINT `team_ibfk_2` FOREIGN KEY (`id_user_2`) REFERENCES `users` (`id`)
);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
                         `id` int NOT NULL AUTO_INCREMENT,
                         `name` varchar(255) NOT NULL,
                         `email` varchar(255) NOT NULL,
                         `password` varchar(255) NOT NULL,
                         `role` varchar(10) NOT NULL,
                         PRIMARY KEY (`id`)
);
SET FOREIGN_KEY_CHECKS=1;