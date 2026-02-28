<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/Api_base.php';

/**
 * Audit Trail Model
 * Logs every financial and data change in the system.
 */
class Audit_model extends CI_Model
{
    const TABLE = 'timber_audit_log';

    public function __construct()
    {
        parent::__construct();
        $this->_ensure_table();
    }

    private function _ensure_table(): void
    {
        if (!$this->db->table_exists(self::TABLE)) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS `" . self::TABLE . "` (
                  `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                  `user_id`     INT UNSIGNED DEFAULT 0,
                  `action`      VARCHAR(100) NOT NULL,
                  `entity`      VARCHAR(100) NOT NULL,
                  `entity_id`   VARCHAR(50)  DEFAULT NULL,
                  `details`     TEXT         DEFAULT NULL,
                  `ip_address`  VARCHAR(45)  DEFAULT NULL,
                  `user_agent`  VARCHAR(255) DEFAULT NULL,
                  `created_at`  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  INDEX(`user_id`),
                  INDEX(`action`),
                  INDEX(`entity`),
                  INDEX(`created_at`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ");
        }
    }

    /** Write an audit log entry */
    public function log(array $data): void
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert(self::TABLE, $data);
    }

    /**
     * Get audit logs with filters
     * @param array $filters  keys: user_id, action, entity, date_from, date_to
     * @param int   $limit
     * @param int   $offset
     */
    public function get_logs(array $filters = [], int $limit = 50, int $offset = 0): array
    {
        $this->db->from(self::TABLE . ' al');
        $this->db->select('al.*, u.username, u.email');
        $this->db->join('geopos_users u', 'u.id = al.user_id', 'left');

        if (!empty($filters['user_id']))  $this->db->where('al.user_id', $filters['user_id']);
        if (!empty($filters['action']))   $this->db->like('al.action', $filters['action']);
        if (!empty($filters['entity']))   $this->db->where('al.entity', $filters['entity']);
        if (!empty($filters['date_from'])) $this->db->where('DATE(al.created_at) >=', $filters['date_from']);
        if (!empty($filters['date_to']))   $this->db->where('DATE(al.created_at) <=', $filters['date_to']);
        if (!empty($filters['keyword']))  $this->db->like('al.details', $filters['keyword']);

        $this->db->order_by('al.created_at', 'DESC');
        $this->db->limit($limit, $offset);

        return $this->db->get()->result_array();
    }

    public function count_logs(array $filters = []): int
    {
        $this->db->from(self::TABLE . ' al');
        if (!empty($filters['user_id']))  $this->db->where('al.user_id', $filters['user_id']);
        if (!empty($filters['action']))   $this->db->like('al.action', $filters['action']);
        if (!empty($filters['entity']))   $this->db->where('al.entity', $filters['entity']);
        if (!empty($filters['date_from'])) $this->db->where('DATE(al.created_at) >=', $filters['date_from']);
        if (!empty($filters['date_to']))   $this->db->where('DATE(al.created_at) <=', $filters['date_to']);
        return (int) $this->db->count_all_results();
    }

    /** Summary stats for dashboard */
    public function get_summary(): array
    {
        return [
            'today_actions'  => (int) $this->db->where('DATE(created_at)', date('Y-m-d'))->count_all_results(self::TABLE),
            'total_actions'  => (int) $this->db->count_all(self::TABLE),
            'unique_users'   => (int) $this->db->query("SELECT COUNT(DISTINCT user_id) as c FROM " . self::TABLE)->row()->c,
            'recent_entries' => $this->get_logs([], 5, 0),
        ];
    }
}
