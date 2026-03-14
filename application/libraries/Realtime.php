<?php
/**
 * Realtime Event Trigger Library
 * Communicates with the Node.js Socket.io Server for Real-Time UI updates.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Realtime
{
    private $CI;
    private $server_url;
    
    public function __construct()
    {
        $this->CI =& get_instance();
        // Assuming the Node.js Server is running on localhost:3000
        $this->server_url = 'http://127.0.0.1:3000/trigger-event';
    }

    /**
     * Trigger an event to the Socket.io Server
     *
     * @param string $event Event Name (e.g. 'new_transaction', 'worker_ring')
     * @param mixed $data Data payload to send
     * @param int|null $business_id Optional: Restrict to business
     * @param int|null $location_id Optional: Restrict to location
     * @return bool
     */
    public function trigger($event, $data, $business_id = null, $location_id = null)
    {
        $payload = [
            'event' => $event,
            'data' => $data
        ];

        if ($business_id !== null) {
            $payload['business_id'] = $business_id;
        }
        if ($location_id !== null) {
            $payload['location_id'] = $location_id;
        }

        $options = [
            'http' => [
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($payload),
                'timeout' => 2 // 2 seconds timeout to prevent freezing the request
            ]
        ];

        $context = stream_context_create($options);

        // Suppress warnings in case the socket server is down
        $result = @file_get_contents($this->server_url, false, $context);

        if ($result === FALSE) {
            // Real-time server might be offline, log this or ignore.
            log_message('error', 'Realtime Server Unreachable: ' . $this->server_url);
            return false;
        }

        return true;
    }
}
