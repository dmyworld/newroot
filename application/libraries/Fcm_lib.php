<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Fcm_lib
 *
 * Lightweight Firebase Cloud Messaging helper.
 * Reads server key from univarsal_api row (id = 80) to avoid hard-coding.
 */
class Fcm_lib
{
    /** @var CI_Controller */
    protected $CI;

    /** @var string */
    protected $server_key = '';

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database();

        // Try to read FCM server key from univarsal_api (id=80, key1 = server key)
        $row = $this->CI->db->select('key1')
            ->from('univarsal_api')
            ->where('id', 80)
            ->get()
            ->row_array();

        $this->server_key = isset($row['key1']) ? trim($row['key1']) : '';
    }

    /**
     * Send to a single user (all registered devices).
     *
     * @param int    $user_id
     * @param string $title
     * @param string $body
     * @param array  $data
     * @return array Result summary
     */
    public function send_to_user($user_id, string $title, string $body, array $data = []): array
    {
        $tokens = $this->CI->db->select('fcm_token')
            ->from('tp_push_tokens')
            ->where('user_id', (int) $user_id)
            ->get()->result_array();

        if (!$tokens) {
            return ['status' => 'no_tokens', 'sent' => 0];
        }

        $token_list = array_unique(array_column($tokens, 'fcm_token'));
        return $this->send($token_list, $title, $body, $data);
    }

    /**
     * Low-level send to token list.
     *
     * @param array  $tokens
     * @param string $title
     * @param string $body
     * @param array  $data
     * @return array
     */
    public function send(array $tokens, string $title, string $body, array $data = []): array
    {
        if (empty($this->server_key) || empty($tokens)) {
            return ['status' => 'skipped', 'reason' => 'missing_server_key_or_tokens'];
        }

        $payload = [
            'registration_ids' => array_values($tokens),
            'notification'     => [
                'title' => $title,
                'body'  => $body,
                'sound' => 'default',
            ],
            'data'             => $data,
        ];

        $ch = curl_init('https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: key=' . $this->server_key,
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

        $response = curl_exec($ch);
        $error    = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return ['status' => 'error', 'error' => $error];
        }

        $decoded = json_decode($response, true);
        return [
            'status'   => 'ok',
            'response' => $decoded,
        ];
    }
}

