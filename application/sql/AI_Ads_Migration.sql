-- Database Migration for AI Ads Integration (Revid AI)

-- Add Configuration slot for Revid AI
INSERT INTO `geopos_config` (`id`, `fb_profile_id`, `access_token`) VALUES (13, '', '') 
ON DUPLICATE KEY UPDATE `fb_profile_id` = `fb_profile_id`;

-- Add video URL columns to timber lots
ALTER TABLE `geopos_timber_logs` ADD `revid_video_url` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `geopos_timber_standing` ADD `revid_video_url` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `geopos_timber_sawn` ADD `revid_video_url` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `geopos_timber_machinery` ADD `revid_video_url` VARCHAR(255) DEFAULT NULL;

-- Index for performance
ALTER TABLE `geopos_timber_logs` ADD INDEX (`revid_video_url`);
ALTER TABLE `geopos_timber_standing` ADD INDEX (`revid_video_url`);
ALTER TABLE `geopos_timber_sawn` ADD INDEX (`revid_video_url`);
ALTER TABLE `geopos_timber_machinery` ADD INDEX (`revid_video_url`);
