# popot.org v4.0 (November 2022)
# Copyright (C) 2017-2022 Norbert de Jonge <nlmdejonge@gmail.com>
#
# This program is free software: you can redistribute it and/or modify it
# under the terms of the GNU General Public License as published by the Free
# Software Foundation, either version 3 of the License, or (at your option)
# any later version.
#
# This program is distributed in the hope that it will be useful, but WITHOUT
# ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
# FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for
# more details.
#
# You should have received a copy of the GNU General Public License along with
# this program. If not, see [ www.gnu.org/licenses/ ].

# mysql -u root/admin -p
# mysql -u popotorg --password=changethis

CREATE USER 'popotorg'@'localhost' IDENTIFIED BY 'changethis';
GRANT ALL PRIVILEGES ON popotorg.* TO 'popotorg'@'localhost' IDENTIFIED BY 'changethis';
FLUSH PRIVILEGES;
CREATE DATABASE `popotorg`;
USE `popotorg`;
CREATE TABLE `popot_mod` (
  `mod_id` int NOT NULL AUTO_INCREMENT,
  `mod_nr` int NOT NULL,
  `mod_name` varchar(100) NOT NULL,
  `mod_year` int NOT NULL,
  `mod_popversion` int NOT NULL,
  `mod_description` varchar(200) NOT NULL,
  `tag1_id` int NOT NULL,
  `tag2_id` int NOT NULL,
  `tag3_id` int NOT NULL,
  `mod_minutes` int NOT NULL,
  `author1_id` int NOT NULL,
  `author1_type` int NOT NULL,
  `author2_id` int NOT NULL,
  `author2_type` int NOT NULL,
  `author3_id` int NOT NULL,
  `author3_type` int NOT NULL,
  `changed_graphics_yn` int NOT NULL,
  `changed_audio_yn` int NOT NULL,
  `changed_levels_nr` int NOT NULL,
  `mod_executable` varchar(100) NOT NULL,
  `mod_executable_s` varchar(100) NOT NULL,
  `mod_executable_m` varchar(100) NOT NULL,
  `mod_cheat` varchar(100) NOT NULL,
  `mod_nrss` int NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `date_updated_zip` datetime NOT NULL,
  PRIMARY KEY (`mod_id`),
  UNIQUE KEY `mod_name` (`mod_name`),
  UNIQUE KEY `mod_nr` (`mod_nr`,`mod_popversion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `popot_user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `nick` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `gender` int NOT NULL,
  `email` varchar(50) NOT NULL,
  `email_p` int NOT NULL,
  `country` int NOT NULL,
  `website` varchar(100) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `notifynew_pv1_yn` int NOT NULL DEFAULT '0',
  `notifynew_pv2_yn` int NOT NULL DEFAULT '0',
  `notifynew_pv4_yn` int NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `nick` (`nick`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `ip` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `popot_comment` (
  `comment_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `mod_id` int NOT NULL,
  `comment` longtext NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`comment_id`),
  UNIQUE KEY `comment_id` (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `popot_vote` (
  `vote_id` int NOT NULL AUTO_INCREMENT,
  `vote_type` int NOT NULL,
  `mod_id` int NOT NULL,
  `user_id` int NOT NULL,
  `date` datetime NOT NULL,
  `vote` int NOT NULL,
  PRIMARY KEY (`vote_id`),
  UNIQUE KEY `vote_id` (`vote_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `popot_country` (
  `country_id` int NOT NULL AUTO_INCREMENT,
  `country_name` varchar(50) NOT NULL,
  PRIMARY KEY (`country_id`),
  UNIQUE KEY `country_id` (`country_id`),
  UNIQUE KEY `country_name` (`country_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `popot_service` (
  `service_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `mod_id` int NOT NULL,
  PRIMARY KEY (`service_id`),
  UNIQUE KEY `service_id` (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `popot_replay` (
  `replay_id` int NOT NULL AUTO_INCREMENT,
  `mod_id` int NOT NULL,
  `level_nr` int NOT NULL,
  `user_id` int NOT NULL,
  `format_version` varchar(10) DEFAULT NULL,
  `comment` varchar(100) DEFAULT NULL,
  `program` varchar(100) DEFAULT NULL,
  `version` varchar(10) DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`replay_id`),
  UNIQUE KEY `replay_id` (`replay_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
INSERT INTO `popot_countries` VALUES (NULL, 'Abkhazia');
INSERT INTO `popot_countries` VALUES (NULL, 'Afghanistan');
INSERT INTO `popot_countries` VALUES (NULL, 'Albania');
INSERT INTO `popot_countries` VALUES (NULL, 'Algeria');
INSERT INTO `popot_countries` VALUES (NULL, 'Andorra');
INSERT INTO `popot_countries` VALUES (NULL, 'Angola');
INSERT INTO `popot_countries` VALUES (NULL, 'Antigua and Barbuda');
INSERT INTO `popot_countries` VALUES (NULL, 'Argentina');
INSERT INTO `popot_countries` VALUES (NULL, 'Armenia');
INSERT INTO `popot_countries` VALUES (NULL, 'Australia');
INSERT INTO `popot_countries` VALUES (NULL, 'Austria');
INSERT INTO `popot_countries` VALUES (NULL, 'Azerbaijan');
INSERT INTO `popot_countries` VALUES (NULL, 'Bahamas');
INSERT INTO `popot_countries` VALUES (NULL, 'Bahrain');
INSERT INTO `popot_countries` VALUES (NULL, 'Bangladesh');
INSERT INTO `popot_countries` VALUES (NULL, 'Barbados');
INSERT INTO `popot_countries` VALUES (NULL, 'Belarus');
INSERT INTO `popot_countries` VALUES (NULL, 'Belgium');
INSERT INTO `popot_countries` VALUES (NULL, 'Belize');
INSERT INTO `popot_countries` VALUES (NULL, 'Benin');
INSERT INTO `popot_countries` VALUES (NULL, 'Bhutan');
INSERT INTO `popot_countries` VALUES (NULL, 'Bolivia');
INSERT INTO `popot_countries` VALUES (NULL, 'Bosnia and Herzegovina');
INSERT INTO `popot_countries` VALUES (NULL, 'Botswana');
INSERT INTO `popot_countries` VALUES (NULL, 'Brazil');
INSERT INTO `popot_countries` VALUES (NULL, 'Brunei');
INSERT INTO `popot_countries` VALUES (NULL, 'Bulgaria');
INSERT INTO `popot_countries` VALUES (NULL, 'Burkina Faso');
INSERT INTO `popot_countries` VALUES (NULL, 'Burma');
INSERT INTO `popot_countries` VALUES (NULL, 'Burundi');
INSERT INTO `popot_countries` VALUES (NULL, 'Cambodia');
INSERT INTO `popot_countries` VALUES (NULL, 'Cameroon');
INSERT INTO `popot_countries` VALUES (NULL, 'Canada');
INSERT INTO `popot_countries` VALUES (NULL, 'Cape Verde');
INSERT INTO `popot_countries` VALUES (NULL, 'Central African Republic');
INSERT INTO `popot_countries` VALUES (NULL, 'Chad');
INSERT INTO `popot_countries` VALUES (NULL, 'Chile');
INSERT INTO `popot_countries` VALUES (NULL, 'China');
INSERT INTO `popot_countries` VALUES (NULL, 'Colombia');
INSERT INTO `popot_countries` VALUES (NULL, 'Comoros');
INSERT INTO `popot_countries` VALUES (NULL, 'Costa Rica');
INSERT INTO `popot_countries` VALUES (NULL, 'Côte d\'Ivoire');
INSERT INTO `popot_countries` VALUES (NULL, 'Croatia');
INSERT INTO `popot_countries` VALUES (NULL, 'Cuba');
INSERT INTO `popot_countries` VALUES (NULL, 'Cyprus');
INSERT INTO `popot_countries` VALUES (NULL, 'Czech Republic');
INSERT INTO `popot_countries` VALUES (NULL, 'Democratic Republic of the Congo');
INSERT INTO `popot_countries` VALUES (NULL, 'Denmark');
INSERT INTO `popot_countries` VALUES (NULL, 'Djibouti');
INSERT INTO `popot_countries` VALUES (NULL, 'Dominica');
INSERT INTO `popot_countries` VALUES (NULL, 'Dominican Republic');
INSERT INTO `popot_countries` VALUES (NULL, 'East Timor');
INSERT INTO `popot_countries` VALUES (NULL, 'Ecuador');
INSERT INTO `popot_countries` VALUES (NULL, 'Egypt');
INSERT INTO `popot_countries` VALUES (NULL, 'El Salvador');
INSERT INTO `popot_countries` VALUES (NULL, 'Equatorial Guinea');
INSERT INTO `popot_countries` VALUES (NULL, 'Eritrea');
INSERT INTO `popot_countries` VALUES (NULL, 'Estonia');
INSERT INTO `popot_countries` VALUES (NULL, 'Ethiopia');
INSERT INTO `popot_countries` VALUES (NULL, 'Fiji');
INSERT INTO `popot_countries` VALUES (NULL, 'Finland');
INSERT INTO `popot_countries` VALUES (NULL, 'France');
INSERT INTO `popot_countries` VALUES (NULL, 'Gabon');
INSERT INTO `popot_countries` VALUES (NULL, 'Georgia');
INSERT INTO `popot_countries` VALUES (NULL, 'Germany');
INSERT INTO `popot_countries` VALUES (NULL, 'Ghana');
INSERT INTO `popot_countries` VALUES (NULL, 'Greece');
INSERT INTO `popot_countries` VALUES (NULL, 'Grenada');
INSERT INTO `popot_countries` VALUES (NULL, 'Guatemala');
INSERT INTO `popot_countries` VALUES (NULL, 'Guinea');
INSERT INTO `popot_countries` VALUES (NULL, 'Guinea-Bissau');
INSERT INTO `popot_countries` VALUES (NULL, 'Guyana');
INSERT INTO `popot_countries` VALUES (NULL, 'Haiti');
INSERT INTO `popot_countries` VALUES (NULL, 'Honduras');
INSERT INTO `popot_countries` VALUES (NULL, 'Hungary');
INSERT INTO `popot_countries` VALUES (NULL, 'Iceland');
INSERT INTO `popot_countries` VALUES (NULL, 'India');
INSERT INTO `popot_countries` VALUES (NULL, 'Indonesia');
INSERT INTO `popot_countries` VALUES (NULL, 'Iran');
INSERT INTO `popot_countries` VALUES (NULL, 'Iraq');
INSERT INTO `popot_countries` VALUES (NULL, 'Ireland');
INSERT INTO `popot_countries` VALUES (NULL, 'Israel');
INSERT INTO `popot_countries` VALUES (NULL, 'Italy');
INSERT INTO `popot_countries` VALUES (NULL, 'Jamaica');
INSERT INTO `popot_countries` VALUES (NULL, 'Japan');
INSERT INTO `popot_countries` VALUES (NULL, 'Jordan');
INSERT INTO `popot_countries` VALUES (NULL, 'Kazakhstan');
INSERT INTO `popot_countries` VALUES (NULL, 'Kenya');
INSERT INTO `popot_countries` VALUES (NULL, 'Kiribati');
INSERT INTO `popot_countries` VALUES (NULL, 'Kosovo');
INSERT INTO `popot_countries` VALUES (NULL, 'Kuwait');
INSERT INTO `popot_countries` VALUES (NULL, 'Kyrgyzstan');
INSERT INTO `popot_countries` VALUES (NULL, 'Laos');
INSERT INTO `popot_countries` VALUES (NULL, 'Latvia');
INSERT INTO `popot_countries` VALUES (NULL, 'Lebanon');
INSERT INTO `popot_countries` VALUES (NULL, 'Lesotho');
INSERT INTO `popot_countries` VALUES (NULL, 'Liberia');
INSERT INTO `popot_countries` VALUES (NULL, 'Libya');
INSERT INTO `popot_countries` VALUES (NULL, 'Liechtenstein');
INSERT INTO `popot_countries` VALUES (NULL, 'Lithuania');
INSERT INTO `popot_countries` VALUES (NULL, 'Luxembourg');
INSERT INTO `popot_countries` VALUES (NULL, 'Macedonia');
INSERT INTO `popot_countries` VALUES (NULL, 'Madagascar');
INSERT INTO `popot_countries` VALUES (NULL, 'Malawi');
INSERT INTO `popot_countries` VALUES (NULL, 'Malaysia');
INSERT INTO `popot_countries` VALUES (NULL, 'Maldives');
INSERT INTO `popot_countries` VALUES (NULL, 'Mali');
INSERT INTO `popot_countries` VALUES (NULL, 'Malta');
INSERT INTO `popot_countries` VALUES (NULL, 'Marshall Islands');
INSERT INTO `popot_countries` VALUES (NULL, 'Mauritania');
INSERT INTO `popot_countries` VALUES (NULL, 'Mauritius');
INSERT INTO `popot_countries` VALUES (NULL, 'Mexico');
INSERT INTO `popot_countries` VALUES (NULL, 'Micronesia');
INSERT INTO `popot_countries` VALUES (NULL, 'Moldova');
INSERT INTO `popot_countries` VALUES (NULL, 'Monaco');
INSERT INTO `popot_countries` VALUES (NULL, 'Mongolia');
INSERT INTO `popot_countries` VALUES (NULL, 'Montenegro');
INSERT INTO `popot_countries` VALUES (NULL, 'Morocco');
INSERT INTO `popot_countries` VALUES (NULL, 'Mozambique');
INSERT INTO `popot_countries` VALUES (NULL, 'Nagorno-Karabakh');
INSERT INTO `popot_countries` VALUES (NULL, 'Namibia');
INSERT INTO `popot_countries` VALUES (NULL, 'Nauru');
INSERT INTO `popot_countries` VALUES (NULL, 'Nepal');
INSERT INTO `popot_countries` VALUES (NULL, 'Netherlands');
INSERT INTO `popot_countries` VALUES (NULL, 'New Zealand');
INSERT INTO `popot_countries` VALUES (NULL, 'Nicaragua');
INSERT INTO `popot_countries` VALUES (NULL, 'Niger');
INSERT INTO `popot_countries` VALUES (NULL, 'Nigeria');
INSERT INTO `popot_countries` VALUES (NULL, 'Northern Cyprus');
INSERT INTO `popot_countries` VALUES (NULL, 'North Korea');
INSERT INTO `popot_countries` VALUES (NULL, 'Norway');
INSERT INTO `popot_countries` VALUES (NULL, 'Oman');
INSERT INTO `popot_countries` VALUES (NULL, 'Pakistan');
INSERT INTO `popot_countries` VALUES (NULL, 'Palau');
INSERT INTO `popot_countries` VALUES (NULL, 'Palestine');
INSERT INTO `popot_countries` VALUES (NULL, 'Panama');
INSERT INTO `popot_countries` VALUES (NULL, 'Papua New Guinea');
INSERT INTO `popot_countries` VALUES (NULL, 'Paraguay');
INSERT INTO `popot_countries` VALUES (NULL, 'Peru');
INSERT INTO `popot_countries` VALUES (NULL, 'Philippines');
INSERT INTO `popot_countries` VALUES (NULL, 'Poland');
INSERT INTO `popot_countries` VALUES (NULL, 'Portugal');
INSERT INTO `popot_countries` VALUES (NULL, 'Qatar');
INSERT INTO `popot_countries` VALUES (NULL, 'Republic of the Congo');
INSERT INTO `popot_countries` VALUES (NULL, 'Romania');
INSERT INTO `popot_countries` VALUES (NULL, 'Russia');
INSERT INTO `popot_countries` VALUES (NULL, 'Rwanda');
INSERT INTO `popot_countries` VALUES (NULL, 'SADR');
INSERT INTO `popot_countries` VALUES (NULL, 'Saint Kitts and Nevis');
INSERT INTO `popot_countries` VALUES (NULL, 'Saint Lucia');
INSERT INTO `popot_countries` VALUES (NULL, 'Saint Vincent and the Grenadines');
INSERT INTO `popot_countries` VALUES (NULL, 'Samoa');
INSERT INTO `popot_countries` VALUES (NULL, 'San Marino');
INSERT INTO `popot_countries` VALUES (NULL, 'São Tomé and Príncipe');
INSERT INTO `popot_countries` VALUES (NULL, 'Saudi Arabia');
INSERT INTO `popot_countries` VALUES (NULL, 'Senegal');
INSERT INTO `popot_countries` VALUES (NULL, 'Serbia');
INSERT INTO `popot_countries` VALUES (NULL, 'Seychelles');
INSERT INTO `popot_countries` VALUES (NULL, 'Sierra Leone');
INSERT INTO `popot_countries` VALUES (NULL, 'Singapore');
INSERT INTO `popot_countries` VALUES (NULL, 'Slovakia');
INSERT INTO `popot_countries` VALUES (NULL, 'Slovenia');
INSERT INTO `popot_countries` VALUES (NULL, 'Solomon Islands');
INSERT INTO `popot_countries` VALUES (NULL, 'Somalia');
INSERT INTO `popot_countries` VALUES (NULL, 'Somaliland');
INSERT INTO `popot_countries` VALUES (NULL, 'South Africa');
INSERT INTO `popot_countries` VALUES (NULL, 'South Korea');
INSERT INTO `popot_countries` VALUES (NULL, 'South Ossetia');
INSERT INTO `popot_countries` VALUES (NULL, 'Spain');
INSERT INTO `popot_countries` VALUES (NULL, 'Sri Lanka');
INSERT INTO `popot_countries` VALUES (NULL, 'Sudan');
INSERT INTO `popot_countries` VALUES (NULL, 'Suriname');
INSERT INTO `popot_countries` VALUES (NULL, 'Swaziland');
INSERT INTO `popot_countries` VALUES (NULL, 'Sweden');
INSERT INTO `popot_countries` VALUES (NULL, 'Switzerland');
INSERT INTO `popot_countries` VALUES (NULL, 'Syria');
INSERT INTO `popot_countries` VALUES (NULL, 'Taiwan');
INSERT INTO `popot_countries` VALUES (NULL, 'Tajikistan');
INSERT INTO `popot_countries` VALUES (NULL, 'Tanzania');
INSERT INTO `popot_countries` VALUES (NULL, 'Thailand');
INSERT INTO `popot_countries` VALUES (NULL, 'The Gambia');
INSERT INTO `popot_countries` VALUES (NULL, 'Togo');
INSERT INTO `popot_countries` VALUES (NULL, 'Tonga');
INSERT INTO `popot_countries` VALUES (NULL, 'Transnistria');
INSERT INTO `popot_countries` VALUES (NULL, 'Trinidad and Tobago');
INSERT INTO `popot_countries` VALUES (NULL, 'Tunisia');
INSERT INTO `popot_countries` VALUES (NULL, 'Turkey');
INSERT INTO `popot_countries` VALUES (NULL, 'Turkmenistan');
INSERT INTO `popot_countries` VALUES (NULL, 'Tuvalu');
INSERT INTO `popot_countries` VALUES (NULL, 'Uganda');
INSERT INTO `popot_countries` VALUES (NULL, 'Ukraine');
INSERT INTO `popot_countries` VALUES (NULL, 'United Arab Emirates');
INSERT INTO `popot_countries` VALUES (NULL, 'United Kingdom');
INSERT INTO `popot_countries` VALUES (NULL, 'United States');
INSERT INTO `popot_countries` VALUES (NULL, 'Uruguay');
INSERT INTO `popot_countries` VALUES (NULL, 'Uzbekistan');
INSERT INTO `popot_countries` VALUES (NULL, 'Vanuatu');
INSERT INTO `popot_countries` VALUES (NULL, 'Vatican City');
INSERT INTO `popot_countries` VALUES (NULL, 'Venezuela');
INSERT INTO `popot_countries` VALUES (NULL, 'Vietnam');
INSERT INTO `popot_countries` VALUES (NULL, 'Yemen');
INSERT INTO `popot_countries` VALUES (NULL, 'Zambia');
INSERT INTO `popot_countries` VALUES (NULL, 'Zimbabwe');
CREATE TABLE `popot_feedback` (
  `feedback_id` int NOT NULL AUTO_INCREMENT,
  `feedback_name` varchar(255) NOT NULL,
  `feedback_email` varchar(255) NOT NULL,
  `feedback_message` varchar(255) NOT NULL,
  `feedback_website` varchar(255) NOT NULL,
  `feedback_ip` varchar(45) NOT NULL,
  `feedback_date` datetime NOT NULL,
  PRIMARY KEY (`feedback_id`),
  UNIQUE KEY `feedback_id` (`feedback_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `popot_mailqueue` (
  `mailqueue_id` int NOT NULL AUTO_INCREMENT,
  `mailqueue_to` blob NOT NULL,
  `mailqueue_subject` varchar(1000) NOT NULL,
  `mailqueue_message` mediumtext NOT NULL,
  `mailqueue_sent` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mailqueue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `popot_tag` (
  `tag_id` int NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(100) NOT NULL,
  PRIMARY KEY (`tag_id`),
  UNIQUE KEY `tag_name` (`tag_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
