<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

/**
 * TimberPro ERP - Base API Controller
 * All API controllers extend this class.
 * Provides: JWT auth, standard response format, audit logging
 */
class Api_base extends REST_Controller
{
    protected $current_user_id = 0;
    protected $current_user    = null;
    protected $jwt_secret      = 'TimberPro_JWT_S3cr3t_2026!';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Aauth');
        $this->load->model('Audit_model', 'audit');
        $this->load->database();
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-API-KEY');
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }
    }

    /* ------------------------------------------------------------------
     * JWT Helpers
     * ------------------------------------------------------------------ */

    /**
     * Authenticate request via JWT Bearer token.
     * Returns false and sends 401 if invalid.
     */
    protected function _authenticate(): bool
    {
        $header = $this->input->server('HTTP_AUTHORIZATION');
        if (!$header || strpos($header, 'Bearer ') !== 0) {
            $this->_fail('No token provided', 401);
            return false;
        }
        $token = substr($header, 7);
        $payload = $this->_decode_jwt($token);
        if (!$payload) {
            $this->_fail('Invalid or expired token', 401);
            return false;
        }
        $this->current_user_id = $payload['uid'];
        $this->current_user    = $payload;
        return true;
    }

    /** Generate JWT token */
    protected function _generate_jwt(array $payload): string
    {
        $header  = base64_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
        $payload['exp'] = time() + 86400 * 7; // 7 days
        $body    = base64_encode(json_encode($payload));
        $sig     = base64_encode(hash_hmac('sha256', "$header.$body", $this->jwt_secret, true));
        return "$header.$body.$sig";
    }

    /** Decode & verify JWT token */
    protected function _decode_jwt(string $token): ?array
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) return null;
        [$header, $body, $sig] = $parts;
        $expected = base64_encode(hash_hmac('sha256', "$header.$body", $this->jwt_secret, true));
        if (!hash_equals($expected, $sig)) return null;
        $payload = json_decode(base64_decode($body), true);
        if (!$payload || (isset($payload['exp']) && $payload['exp'] < time())) return null;
        return $payload;
    }

    /* ------------------------------------------------------------------
     * Standard Response Helpers
     * ------------------------------------------------------------------ */

    protected function _success($data = [], string $message = 'OK', int $code = 200): void
    {
        $this->response([
            'status'    => 'success',
            'message'   => $message,
            'data'      => $data,
            'timestamp' => date('c'),
        ], $code);
    }

    protected function _fail(string $message, int $code = 400, $errors = null): void
    {
        $resp = [
            'status'    => 'error',
            'message'   => $message,
            'timestamp' => date('c'),
        ];
        if ($errors !== null) $resp['errors'] = $errors;
        $this->response($resp, $code);
    }

    protected function _paginated(array $data, int $total, int $page, int $per_page): void
    {
        $this->response([
            'status'    => 'success',
            'data'      => $data,
            'meta'      => [
                'total'       => $total,
                'page'        => $page,
                'per_page'    => $per_page,
                'total_pages' => (int) ceil($total / $per_page),
            ],
            'timestamp' => date('c'),
        ], 200);
    }

    /* ------------------------------------------------------------------
     * Audit Logging
     * ------------------------------------------------------------------ */

    protected function _log_action(string $action, string $entity, $entity_id = null, array $details = []): void
    {
        if (isset($this->audit)) {
            $this->audit->log([
                'user_id'    => $this->current_user_id,
                'action'     => $action,
                'entity'     => $entity,
                'entity_id'  => $entity_id,
                'details'    => json_encode($details),
                'ip_address' => $this->input->ip_address(),
                'user_agent' => $this->input->user_agent(),
            ]);
        }
    }
}
