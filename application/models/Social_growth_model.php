<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Social_growth_model
 * Handles all DB operations for the Social-Driven Growth module.
 */
class Social_growth_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // =========================================================================
    // DATABASE MIGRATION
    // =========================================================================

    public function ensure_tables()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `social_api_settings` (
              `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              `platform`    VARCHAR(50) NOT NULL UNIQUE,
              `app_id`      TEXT DEFAULT NULL,
              `app_secret`  TEXT DEFAULT NULL,
              `api_key`     TEXT DEFAULT NULL,
              `extra_data`  TEXT DEFAULT NULL,
              `updated_at`  DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        $this->db->query("
            CREATE TABLE IF NOT EXISTS `media_templates` (
              `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              `slot`        TINYINT UNSIGNED NOT NULL,
              `name`        VARCHAR(100) NOT NULL,
              `file_path`   VARCHAR(255) DEFAULT NULL,
              `bg_music`    VARCHAR(255) DEFAULT NULL,
              `created_at`  DATETIME DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        $this->db->query("
            CREATE TABLE IF NOT EXISTS `user_social_tokens` (
              `id`           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              `user_id`      INT UNSIGNED NOT NULL,
              `platform`     VARCHAR(50) NOT NULL,
              `access_token` TEXT DEFAULT NULL,
              `token_data`   TEXT DEFAULT NULL,
              `expires_at`   DATETIME DEFAULT NULL,
              `created_at`   DATETIME DEFAULT CURRENT_TIMESTAMP,
              UNIQUE KEY `user_platform` (`user_id`, `platform`),
              INDEX (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        $this->db->query("
            CREATE TABLE IF NOT EXISTS `share_logs` (
              `id`              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              `user_id`         INT UNSIGNED NOT NULL,
              `ad_id`           INT UNSIGNED NOT NULL,
              `ad_type`         VARCHAR(30) DEFAULT 'logs',
              `platform`        VARCHAR(50) NOT NULL,
              `status`          ENUM('pending','success','failed') DEFAULT 'pending',
              `referral_token`  VARCHAR(64) DEFAULT NULL,
              `post_id`         VARCHAR(255) DEFAULT NULL,
              `error_msg`       TEXT DEFAULT NULL,
              `created_at`      DATETIME DEFAULT CURRENT_TIMESTAMP,
              INDEX (`user_id`),
              INDEX (`ad_id`),
              INDEX (`referral_token`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        $this->db->query("
            CREATE TABLE IF NOT EXISTS `generated_media` (
              `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              `ad_id`       INT UNSIGNED NOT NULL,
              `ad_type`     VARCHAR(30) DEFAULT 'logs',
              `media_type`  ENUM('poster','video','audio') NOT NULL,
              `template_slot` TINYINT UNSIGNED DEFAULT NULL,
              `file_path`   VARCHAR(255) NOT NULL,
              `caption`     TEXT DEFAULT NULL,
              `hashtags`    TEXT DEFAULT NULL,
              `created_at`  DATETIME DEFAULT CURRENT_TIMESTAMP,
              INDEX (`ad_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        $this->db->query("
            CREATE TABLE IF NOT EXISTS `social_referral_clicks` (
              `id`              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              `referral_token`  VARCHAR(64) NOT NULL,
              `user_id`         INT UNSIGNED DEFAULT NULL,
              `ad_id`           INT UNSIGNED DEFAULT NULL,
              `ip_address`      VARCHAR(45) DEFAULT NULL,
              `user_agent`      VARCHAR(255) DEFAULT NULL,
              `clicked_at`      DATETIME DEFAULT CURRENT_TIMESTAMP,
              INDEX (`referral_token`),
              INDEX (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        $this->db->query("
            CREATE TABLE IF NOT EXISTS `social_badges` (
              `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              `user_id`     INT UNSIGNED NOT NULL,
              `badge_slug`  VARCHAR(50) NOT NULL,
              `awarded_at`  DATETIME DEFAULT CURRENT_TIMESTAMP,
              UNIQUE KEY `user_badge` (`user_id`, `badge_slug`),
              INDEX (`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        return true;
    }

    // =========================================================================
    // API SETTINGS
    // =========================================================================

    public function get_api_settings($platform = null)
    {
        if ($platform) {
            $this->db->where('platform', $platform);
            return $this->db->get('social_api_settings')->row_array() ?: [];
        }
        $rows = $this->db->get('social_api_settings')->result_array();
        $out = [];
        foreach ($rows as $r) {
            $out[$r['platform']] = $r;
        }
        return $out;
    }

    public function save_api_settings($platform, $app_id, $app_secret, $api_key = null, $extra_data = null)
    {
        $data = [
            'platform'   => $platform,
            'app_id'     => $app_id,
            'app_secret' => $app_secret,
            'api_key'    => $api_key,
            'extra_data' => $extra_data,
        ];

        $this->db->where('platform', $platform);
        $exists = $this->db->count_all_results('social_api_settings');

        if ($exists) {
            $this->db->where('platform', $platform);
            $this->db->update('social_api_settings', $data);
        } else {
            $this->db->insert('social_api_settings', $data);
        }
        return true;
    }

    // =========================================================================
    // MEDIA TEMPLATES
    // =========================================================================

    public function get_templates()
    {
        return $this->db->order_by('slot', 'ASC')->get('media_templates')->result_array();
    }

    public function get_template_by_slot($slot)
    {
        $this->db->where('slot', $slot);
        return $this->db->get('media_templates')->row_array() ?: [];
    }

    public function save_template($slot, $name, $file_path = null, $bg_music = null)
    {
        $this->db->where('slot', $slot);
        $exists = $this->db->count_all_results('media_templates');
        $data = compact('slot', 'name');
        if ($file_path !== null) $data['file_path'] = $file_path;
        if ($bg_music !== null) $data['bg_music'] = $bg_music;

        if ($exists) {
            $this->db->where('slot', $slot);
            $this->db->update('media_templates', $data);
        } else {
            $this->db->insert('media_templates', $data);
        }
        return $this->db->insert_id() ?: true;
    }

    public function delete_template($id)
    {
        $this->db->where('id', $id);
        $t = $this->db->get('media_templates')->row_array();
        if ($t) {
            $this->db->delete('media_templates', ['id' => $id]);
            return $t;
        }
        return false;
    }

    // =========================================================================
    // USER SOCIAL TOKENS
    // =========================================================================

    public function get_user_token($user_id, $platform)
    {
        $this->db->where('user_id', $user_id)->where('platform', $platform);
        return $this->db->get('user_social_tokens')->row_array() ?: null;
    }

    public function save_user_token($user_id, $platform, $access_token, $token_data = null, $expires_at = null)
    {
        $this->db->where('user_id', $user_id)->where('platform', $platform);
        $exists = $this->db->count_all_results('user_social_tokens');
        $data = [
            'user_id'      => $user_id,
            'platform'     => $platform,
            'access_token' => $access_token,
            'token_data'   => $token_data ? json_encode($token_data) : null,
            'expires_at'   => $expires_at,
        ];
        if ($exists) {
            $this->db->where('user_id', $user_id)->where('platform', $platform);
            $this->db->update('user_social_tokens', $data);
        } else {
            $this->db->insert('user_social_tokens', $data);
        }
        return true;
    }

    // =========================================================================
    // SHARE LOGS
    // =========================================================================

    public function log_share($user_id, $ad_id, $ad_type, $platform, $status = 'pending', $referral_token = null, $post_id = null, $error_msg = null)
    {
        // Upsert: update existing pending row if re-sharing same platform
        $this->db->where('user_id', $user_id)->where('ad_id', $ad_id)->where('platform', $platform);
        $exists = $this->db->get('share_logs')->row_array();

        $data = [
            'user_id'        => $user_id,
            'ad_id'          => $ad_id,
            'ad_type'        => $ad_type,
            'platform'       => $platform,
            'status'         => $status,
            'referral_token' => $referral_token,
            'post_id'        => $post_id,
            'error_msg'      => $error_msg,
        ];

        if ($exists) {
            $this->db->where('id', $exists['id']);
            $this->db->update('share_logs', $data);
        } else {
            $this->db->insert('share_logs', $data);
        }
        return true;
    }

    public function get_share_status($user_id, $ad_id)
    {
        $this->db->where('user_id', $user_id)->where('ad_id', $ad_id);
        $rows = $this->db->get('share_logs')->result_array();
        $status = [];
        foreach ($rows as $r) {
            $status[$r['platform']] = $r['status'];
        }
        return $status;
    }

    public function get_share_logs($filters = [])
    {
        $this->db->select('sl.*, u.username');
        $this->db->from('share_logs sl');
        $this->db->join('geopos_users u', 'u.id = sl.user_id', 'left');
        if (!empty($filters['user_id'])) $this->db->where('sl.user_id', $filters['user_id']);
        if (!empty($filters['platform'])) $this->db->where('sl.platform', $filters['platform']);
        if (!empty($filters['status']))   $this->db->where('sl.status', $filters['status']);
        $this->db->order_by('sl.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function count_user_shares($user_id)
    {
        $this->db->where('user_id', $user_id)->where('status', 'success');
        return $this->db->count_all_results('share_logs');
    }

    // =========================================================================
    // GENERATED MEDIA
    // =========================================================================

    public function save_generated_media($ad_id, $ad_type, $media_type, $file_path, $template_slot = null, $caption = null, $hashtags = null)
    {
        $this->db->insert('generated_media', [
            'ad_id'         => $ad_id,
            'ad_type'       => $ad_type,
            'media_type'    => $media_type,
            'template_slot' => $template_slot,
            'file_path'     => $file_path,
            'caption'       => $caption,
            'hashtags'      => $hashtags,
        ]);
        return $this->db->insert_id();
    }

    public function get_generated_media($ad_id)
    {
        $this->db->where('ad_id', $ad_id)->order_by('template_slot', 'ASC');
        return $this->db->get('generated_media')->result_array();
    }

    public function delete_generated_media($ad_id)
    {
        $this->db->delete('generated_media', ['ad_id' => $ad_id]);
    }

    // =========================================================================
    // REFERRAL TRACKING
    // =========================================================================

    public function generate_referral_token($user_id, $ad_id, $platform)
    {
        return md5($user_id . '_' . $ad_id . '_' . $platform . '_' . time());
    }

    public function track_referral_click($referral_token, $ip, $user_agent = null)
    {
        // Get ad_id from share_logs
        $this->db->where('referral_token', $referral_token)->limit(1);
        $log = $this->db->get('share_logs')->row_array();

        $this->db->insert('social_referral_clicks', [
            'referral_token' => $referral_token,
            'user_id'        => $log['user_id'] ?? null,
            'ad_id'          => $log['ad_id'] ?? null,
            'ip_address'     => $ip,
            'user_agent'     => $user_agent,
        ]);

        // Award badge if milestone reached
        if ($log) {
            $this->_check_and_award_badges($log['user_id']);
        }

        return $log;
    }

    public function get_referral_insights($user_id)
    {
        // Per-ad click counts
        $this->db->select('sl.ad_id, sl.platform, sl.referral_token, COUNT(rc.id) AS clicks');
        $this->db->from('share_logs sl');
        $this->db->join('social_referral_clicks rc', 'rc.referral_token = sl.referral_token', 'left');
        $this->db->where('sl.user_id', $user_id);
        $this->db->group_by('sl.ad_id, sl.platform, sl.referral_token');
        $this->db->order_by('clicks', 'DESC');
        $per_ad = $this->db->get()->result_array();

        // Total clicks
        $this->db->select('COUNT(rc.id) AS total_clicks');
        $this->db->from('social_referral_clicks rc');
        $this->db->join('share_logs sl', 'sl.referral_token = rc.referral_token', 'left');
        $this->db->where('sl.user_id', $user_id);
        $total = $this->db->get()->row_array();

        $total_shares = $this->count_user_shares($user_id);

        return [
            'per_ad'        => $per_ad,
            'total_clicks'  => (int)($total['total_clicks'] ?? 0),
            'total_shares'  => $total_shares,
            'badges'        => $this->get_user_badges($user_id),
        ];
    }

    // =========================================================================
    // BADGES & GAMIFICATION
    // =========================================================================

    public static $badge_definitions = [
        'first_share'        => ['label' => 'First Share',        'icon' => '🌟', 'desc' => 'First successful share'],
        'speed_sharer'       => ['label' => 'Speed Sharer',       'icon' => '⚡', 'desc' => 'All platforms shared within 10 minutes'],
        'referral_king'      => ['label' => 'Referral King',      'icon' => '🔗', 'desc' => '50+ referral clicks'],
        'super_seller'       => ['label' => 'Super Seller',       'icon' => '🏆', 'desc' => '10+ ads shared'],
        'community_builder'  => ['label' => 'Community Builder',  'icon' => '👑', 'desc' => '100+ total referral clicks'],
    ];

    public function get_user_badges($user_id)
    {
        $this->db->where('user_id', $user_id);
        $rows = $this->db->get('social_badges')->result_array();
        $defs = self::$badge_definitions;
        foreach ($rows as &$r) {
            $r['icon']  = $defs[$r['badge_slug']]['icon'] ?? '🎖️';
            $r['label'] = $defs[$r['badge_slug']]['label'] ?? $r['badge_slug'];
        }
        return $rows;
    }

    public function award_badge($user_id, $badge_slug)
    {
        $this->db->where('user_id', $user_id)->where('badge_slug', $badge_slug);
        if ($this->db->count_all_results('social_badges') === 0) {
            $this->db->insert('social_badges', [
                'user_id'    => $user_id,
                'badge_slug' => $badge_slug,
            ]);
            return true; // New badge awarded
        }
        return false; // Already has it
    }

    public function _check_and_award_badges($user_id)
    {
        $new_badges = [];
        $total_shares = $this->count_user_shares($user_id);
        $this->db->select('COUNT(rc.id) AS total_clicks');
        $this->db->from('social_referral_clicks rc');
        $this->db->join('share_logs sl', 'sl.referral_token = rc.referral_token', 'left');
        $this->db->where('sl.user_id', $user_id);
        $t = $this->db->get()->row_array();
        $total_clicks = (int)($t['total_clicks'] ?? 0);

        if ($total_shares >= 1  && $this->award_badge($user_id, 'first_share'))       $new_badges[] = 'first_share';
        if ($total_shares >= 10 && $this->award_badge($user_id, 'super_seller'))      $new_badges[] = 'super_seller';
        if ($total_clicks >= 50 && $this->award_badge($user_id, 'referral_king'))     $new_badges[] = 'referral_king';
        if ($total_clicks >= 100&& $this->award_badge($user_id, 'community_builder')) $new_badges[] = 'community_builder';

        return $new_badges;
    }

    public function get_leaderboard($limit = 10)
    {
        $this->db->select('sl.user_id, u.username, COUNT(DISTINCT sl.id) AS share_count, COUNT(DISTINCT rc.id) AS click_count');
        $this->db->from('share_logs sl');
        $this->db->join('geopos_users u', 'u.id = sl.user_id', 'left');
        $this->db->join('social_referral_clicks rc', 'rc.user_id = sl.user_id', 'left');
        $this->db->where('sl.status', 'success');
        $this->db->group_by('sl.user_id, u.username');
        $this->db->order_by('share_count', 'DESC');
        $this->db->limit($limit);
        $rows = $this->db->get()->result_array();

        foreach ($rows as &$r) {
            $r['badges'] = $this->get_user_badges($r['user_id']);
        }
        return $rows;
    }

    // =========================================================================
    // REPOST REMINDER
    // =========================================================================

    public function get_ads_due_for_repost()
    {
        // Ads shared >7 days ago with no share in the last 6 days
        $sql = "
            SELECT sl.user_id, sl.ad_id, sl.ad_type, u.email, u.username,
                   MAX(sl.created_at) AS last_shared
            FROM share_logs sl
            JOIN geopos_users u ON u.id = sl.user_id
            WHERE sl.status = 'success'
            GROUP BY sl.user_id, sl.ad_id
            HAVING last_shared < DATE_SUB(NOW(), INTERVAL 6 DAY)
        ";
        return $this->db->query($sql)->result_array();
    }
}
