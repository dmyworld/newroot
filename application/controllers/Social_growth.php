<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Social_growth Controller
 * Handles all Social-Driven Growth module operations.
 *
 * Admin routes (roleid 5):
 *   /social_growth/admin_settings
 *   /social_growth/admin_templates
 *   /social_growth/admin_logs
 *   /social_growth/admin_leaderboard
 *   /social_growth/run_migration
 *
 * User routes (logged-in):
 *   /social_growth/generate_media/{ad_id}
 *   /social_growth/media_status/{ad_id}
 *   /social_growth/share_wizard/{ad_id}/{ad_type}
 *   /social_growth/oauth_connect/{platform}
 *   /social_growth/oauth_callback/{platform}
 *   /social_growth/do_share/{platform}/{ad_id}
 *   /social_growth/verify_share/{ad_id}
 *   /social_growth/my_insights
 *
 * Public routes:
 *   /social_growth/track_link/{token}
 */
class Social_growth extends CI_Controller
{
    private $is_admin  = false;
    private $user_id   = 0;
    private $username  = '';
    private $media_dir = '';
    private $media_url = '';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Aauth');
        $this->load->model('Social_growth_model', 'sg');
        $this->load->model('Marketplace_model', 'mp');

        $this->media_dir = FCPATH . 'userfiles/generated_media/';
        $this->media_url = base_url('userfiles/generated_media/');

        // Create media directory if it doesn't exist
        if (!is_dir($this->media_dir)) {
            @mkdir($this->media_dir, 0755, true);
        }
        if (!is_dir(FCPATH . 'userfiles/social_templates/')) {
            @mkdir(FCPATH . 'userfiles/social_templates/', 0755, true);
        }

        // Auto-run DB migration on every request (safe — uses CREATE TABLE IF NOT EXISTS)
        try {
            $this->sg->ensure_tables();
        } catch (Exception $e) {
            // Log but don't crash — tables may already exist or DB may have a transient issue
            log_message('error', 'Social_growth ensure_tables: ' . $e->getMessage());
        }

        if ($this->aauth->is_loggedin()) {
            $u = $this->aauth->get_user();
            $this->user_id  = $u ? (int)$u->id : 0;
            $this->username = $u ? ($u->username ?? '') : '';
            // Reverting to roleid >= 5 for admin as aauth_groups is empty in this system
            $this->is_admin = $u ? ((int)($u->roleid ?? 0) >= 5) : false;
        }
    }


    // =========================================================================
    // MIGRATION
    // =========================================================================

    public function run_migration()
    {
        if (!$this->is_admin) { show_error('Access denied', 403); return; }
        $this->sg->ensure_tables();
        echo '<h3>✅ Migration complete!</h3><p>7 social growth tables created/verified.</p>';
        echo '<a href="' . base_url('social_growth/admin_settings') . '">→ Go to Admin Settings</a>';
    }

    // =========================================================================
    // ADMIN: API SETTINGS
    // =========================================================================

    public function admin_settings()
    {
        if (!$this->is_admin) { show_error('Access denied', 403); return; }

        if ($this->input->post()) {
            $platforms = ['facebook', 'youtube', 'tiktok', 'google_tts', 'openai'];
            foreach ($platforms as $platform) {
                $this->sg->save_api_settings(
                    $platform,
                    $this->input->post($platform . '_app_id'),
                    $this->input->post($platform . '_app_secret'),
                    $this->input->post($platform . '_api_key'),
                    $this->input->post($platform . '_extra')
                );
            }
            echo json_encode(['status' => 'Success', 'message' => 'API settings saved successfully!']);
            return;
        }

        $head = ['title' => 'Social Growth Settings', 'usernm' => $this->username];
        $data = [
            'settings'  => $this->sg->get_api_settings(),
            'templates' => $this->sg->get_templates(),
        ];
        $this->load->view('fixed/header', $head);
        $this->load->view('social_growth/admin_settings', $data);
        $this->load->view('fixed/footer');
    }

    // =========================================================================
    // ADMIN: TEMPLATE MANAGER
    // =========================================================================

    public function admin_templates()
    {
        if (!$this->is_admin) { show_error('Access denied', 403); return; }

        $tpl_dir = FCPATH . 'userfiles/social_templates/';
        $msg = '';

        if ($this->input->post('action') === 'upload_music') {
            // Upload background music
            if (!empty($_FILES['bg_music']['name'])) {
                $ext = strtolower(pathinfo($_FILES['bg_music']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, ['mp3', 'ogg', 'wav'])) {
                    $dest = $tpl_dir . 'bg_music.' . $ext;
                    move_uploaded_file($_FILES['bg_music']['tmp_name'], $dest);
                    $msg = 'Background music uploaded!';
                }
            }
        } elseif ($this->input->post('action') === 'upload_template') {
            $slot = (int)$this->input->post('slot');
            $name = $this->input->post('name') ?: 'Template ' . $slot;
            if ($slot >= 1 && $slot <= 5 && !empty($_FILES['template_img']['name'])) {
                $ext = strtolower(pathinfo($_FILES['template_img']['name'], PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                    $fname = 'template_slot_' . $slot . '.' . $ext;
                    $dest  = $tpl_dir . $fname;
                    move_uploaded_file($_FILES['template_img']['tmp_name'], $dest);
                    $this->sg->save_template($slot, $name, 'userfiles/social_templates/' . $fname);
                    $msg = 'Template ' . $slot . ' uploaded!';
                }
            }
        } elseif ($this->input->post('action') === 'delete_template') {
            $id = (int)$this->input->post('id');
            $t  = $this->sg->delete_template($id);
            if ($t && !empty($t['file_path'])) {
                @unlink(FCPATH . $t['file_path']);
            }
            echo json_encode(['status' => 'Success', 'message' => 'Template deleted.']);
            return;
        }

        $head = ['title' => 'Social Templates Manager', 'usernm' => $this->username];
        $data = [
            'templates' => $this->sg->get_templates(),
            'msg'       => $msg,
            'music_exists' => file_exists($tpl_dir . 'bg_music.mp3') || file_exists($tpl_dir . 'bg_music.ogg'),
        ];
        $this->load->view('fixed/header', $head);
        $this->load->view('social_growth/admin_templates', $data);
        $this->load->view('fixed/footer');
    }

    // =========================================================================
    // ADMIN: LOGS
    // =========================================================================

    public function admin_logs()
    {
        if (!$this->is_admin) { show_error('Access denied', 403); return; }

        $head = ['title' => 'Social Growth Logs', 'usernm' => $this->username];
        $data = ['logs' => $this->sg->get_share_logs()];
        $this->load->view('fixed/header', $head);
        $this->load->view('social_growth/admin_logs', $data);
        $this->load->view('fixed/footer');
    }

    // =========================================================================
    // ADMIN: LEADERBOARD
    // =========================================================================

    public function admin_leaderboard()
    {
        if (!$this->is_admin) { show_error('Access denied', 403); return; }

        $head = ['title' => 'Social Leaderboard', 'usernm' => $this->username];
        $data = ['leaders' => $this->sg->get_leaderboard(20)];
        $this->load->view('fixed/header', $head);
        $this->load->view('social_growth/leaderboard', $data);
        $this->load->view('fixed/footer');
    }

    // =========================================================================
    // GENERATE MEDIA
    // =========================================================================

    public function generate_media($ad_id = 0, $ad_type = 'logs')
    {
        if (!$this->aauth->is_loggedin()) {
            echo json_encode(['status' => 'Error', 'message' => 'Login required']);
            return;
        }

        $ad_id   = (int)$ad_id;
        $ad_type = in_array($ad_type, ['logs', 'sawn']) ? $ad_type : 'logs';

        if (!$ad_id) {
            echo json_encode(['status' => 'Error', 'message' => 'Invalid ad ID']);
            return;
        }

        // Get lot details
        $lot = $this->mp->get_lot_details($ad_id, $ad_type);
        if (!$lot) {
            echo json_encode(['status' => 'Error', 'message' => 'Ad not found']);
            return;
        }

        // Delete old generated media for this ad
        $old = $this->sg->get_generated_media($ad_id);
        foreach ($old as $m) {
            @unlink(FCPATH . $m['file_path']);
        }
        $this->sg->delete_generated_media($ad_id);

        // Progress tracking file
        $progress_file = $this->media_dir . 'progress_' . $ad_id . '.json';
        file_put_contents($progress_file, json_encode(['step' => 1, 'total' => 7, 'msg' => 'Starting...']));

        // === STEP 1: Prepare source image ===
        $photos = json_decode($lot['photos'] ?? '[]', true);
        $source_photo = !empty($photos[0]) ? FCPATH . ltrim($photos[0], '/') : null;
        file_put_contents($progress_file, json_encode(['step' => 2, 'total' => 7, 'msg' => 'Enhancing image...']));

        // === STEP 2: AI Image Enhancement ===
        $enhanced_path = null;
        if ($source_photo && file_exists($source_photo)) {
            $enhanced_path = $this->_enhance_image($source_photo, $ad_id);
        }

        // === STEP 3: Generate AI Caption ===
        file_put_contents($progress_file, json_encode(['step' => 3, 'total' => 7, 'msg' => 'Generating AI caption...']));
        list($caption, $hashtags) = $this->_generate_caption($lot);

        // === STEP 4: Generate 5 poster templates ===
        file_put_contents($progress_file, json_encode(['step' => 4, 'total' => 7, 'msg' => 'Creating posters...']));
        $poster_paths = [];
        for ($slot = 1; $slot <= 5; $slot++) {
            $poster_path = $this->_generate_poster($lot, $slot, $enhanced_path ?? $source_photo, $ad_id, $caption, $hashtags);
            if ($poster_path) {
                $poster_paths[] = $poster_path;
                $this->sg->save_generated_media($ad_id, $ad_type, 'poster', $poster_path, $slot, $caption, $hashtags);
            }
        }

        // === STEP 5: Generate TTS audio ===
        file_put_contents($progress_file, json_encode(['step' => 5, 'total' => 7, 'msg' => 'Generating voice-over...']));
        $audio_path = $this->_generate_tts($lot, $ad_id);

        // === STEP 6: Generate video ===
        file_put_contents($progress_file, json_encode(['step' => 6, 'total' => 7, 'msg' => 'Generating promo video...']));
        $video_path = $this->_generate_video($poster_paths, $audio_path, $ad_id);
        if ($video_path) {
            $this->sg->save_generated_media($ad_id, $ad_type, 'video', $video_path, null, $caption, $hashtags);
        }

        // === STEP 7: Done ===
        $referral_token = $this->sg->generate_referral_token($this->user_id, $ad_id, 'fb');
        file_put_contents($progress_file, json_encode(['step' => 7, 'total' => 7, 'msg' => 'Complete!', 'done' => true]));

        // Award first share badge check (will be awarded on actual share)
        $this->sg->_check_and_award_badges($this->user_id);

        echo json_encode([
            'status'   => 'Success',
            'message'  => 'Media generated!',
            'posters'  => $poster_paths,
            'video'    => $video_path,
            'caption'  => $caption,
            'hashtags' => $hashtags,
        ]);
    }

    public function media_status($ad_id = 0)
    {
        $progress_file = $this->media_dir . 'progress_' . (int)$ad_id . '.json';
        if (file_exists($progress_file)) {
            echo file_get_contents($progress_file);
        } else {
            echo json_encode(['step' => 0, 'total' => 7, 'msg' => 'Not started']);
        }
    }

    // =========================================================================
    // SHARE WIZARD
    // =========================================================================

    public function share_wizard($ad_id = 0, $ad_type = 'logs')
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('user', 'refresh');
            return;
        }

        $ad_id   = (int)$ad_id;
        $ad_type = in_array($ad_type, ['logs', 'sawn']) ? $ad_type : 'logs';
        $lot     = $this->mp->get_lot_details($ad_id, $ad_type);

        if (!$lot) { show_404(); return; }

        $photos = json_decode($lot['photos'] ?? '[]', true);
        $lot['photos'] = $photos;

        // Get already generated media
        $generated = $this->sg->get_generated_media($ad_id);
        $posters    = array_filter($generated, fn($m) => $m['media_type'] === 'poster');
        $videos     = array_filter($generated, fn($m) => $m['media_type'] === 'video');

        // Get share status for this user
        $share_status = $this->sg->get_share_status($this->user_id, $ad_id);

        // Get user's social tokens (connected accounts)
        $fb_connected = (bool)$this->sg->get_user_token($this->user_id, 'facebook');
        $yt_connected = (bool)$this->sg->get_user_token($this->user_id, 'youtube');
        $tt_connected = (bool)$this->sg->get_user_token($this->user_id, 'tiktok');

        // Generate unique referral tokens per platform
        $referral_tokens = [];
        foreach (['facebook', 'youtube', 'tiktok', 'whatsapp'] as $p) {
            $existing_log = array_values(array_filter(
                $this->sg->get_share_logs(['user_id' => $this->user_id]),
                fn($l) => $l['ad_id'] == $ad_id && $l['platform'] === $p
            ));
            $referral_tokens[$p] = !empty($existing_log[0]['referral_token'])
                ? $existing_log[0]['referral_token']
                : $this->sg->generate_referral_token($this->user_id, $ad_id, $p);
        }

        // Caption from generated media
        $caption   = !empty($posters) ? reset($posters)['caption'] : '';
        $hashtags  = !empty($posters) ? reset($posters)['hashtags'] : '';

        // WhatsApp message
        $shop_url = site_url('shop/view/' . $ad_type . '/' . $ad_id);
        $wa_ref   = site_url('social_growth/track_link/' . $referral_tokens['whatsapp']);
        $wa_msg   = urlencode("{$caption}\n{$hashtags}\n\n🔗 " . $wa_ref);

        $head = ['title' => 'Share Your Ad | TimberPro', 'is_shop' => true];
        $data = [
            'lot'              => $lot,
            'ad_id'            => $ad_id,
            'ad_type'          => $ad_type,
            'posters'          => array_values($posters),
            'video'            => !empty($videos) ? reset($videos) : null,
            'share_status'     => $share_status,
            'fb_connected'     => $fb_connected,
            'yt_connected'     => $yt_connected,
            'tt_connected'     => $tt_connected,
            'caption'          => $caption,
            'hashtags'         => $hashtags,
            'wa_msg'           => $wa_msg,
            'referral_tokens'  => $referral_tokens,
            'shop_url'         => $shop_url,
            'has_media'        => count($generated) > 0,
            'badges'           => $this->sg->get_user_badges($this->user_id),
            'insights'         => $this->sg->get_referral_insights($this->user_id),
        ];

        $this->load->view('shop/header', $head);
        $this->load->view('social_growth/share_wizard', $data);
        $this->load->view('shop/footer');
    }

    // =========================================================================
    // OAUTH
    // =========================================================================

    public function oauth_connect($platform = '')
    {
        if (!$this->aauth->is_loggedin()) { redirect('user'); return; }

        $settings = $this->sg->get_api_settings($platform);
        if (empty($settings['app_id'])) {
            redirect('social_growth/share_wizard/' . ($this->input->get('ad_id') ?: 0));
            return;
        }

        $callback = base_url('social_growth/oauth_callback/' . $platform);

        switch ($platform) {
            case 'facebook':
                $scope = 'public_profile,email,publish_to_groups,pages_manage_posts';
                $url   = "https://www.facebook.com/v19.0/dialog/oauth?client_id={$settings['app_id']}&redirect_uri=" . urlencode($callback) . "&scope={$scope}&state=" . $this->input->get('ad_id');
                break;

            case 'youtube':
                $scope = urlencode('https://www.googleapis.com/auth/youtube.upload https://www.googleapis.com/auth/youtube.readonly');
                $url   = "https://accounts.google.com/o/oauth2/v2/auth?client_id={$settings['app_id']}&redirect_uri=" . urlencode($callback) . "&response_type=code&scope={$scope}&access_type=offline&state=" . $this->input->get('ad_id');
                break;

            case 'tiktok':
                $scope = 'video.upload,video.publish';
                $url   = "https://www.tiktok.com/auth/authorize/?client_key={$settings['app_id']}&response_type=code&scope={$scope}&redirect_uri=" . urlencode($callback) . "&state=" . $this->input->get('ad_id');
                break;

            default:
                redirect('social_growth/share_wizard/' . ($this->input->get('ad_id') ?: 0));
                return;
        }

        redirect($url);
    }

    public function oauth_callback($platform = '')
    {
        if (!$this->aauth->is_loggedin()) { redirect('user'); return; }

        $code   = $this->input->get('code');
        $state  = $this->input->get('state'); // ad_id
        $settings = $this->sg->get_api_settings($platform);
        $callback = base_url('social_growth/oauth_callback/' . $platform);

        if (!$code) {
            redirect('social_growth/share_wizard/' . (int)$state);
            return;
        }

        // Exchange code for token
        $token_data = null;
        switch ($platform) {
            case 'facebook':
                $resp = $this->_http_post('https://graph.facebook.com/v19.0/oauth/access_token', [
                    'client_id'     => $settings['app_id'],
                    'client_secret' => $settings['app_secret'],
                    'redirect_uri'  => $callback,
                    'code'          => $code,
                ]);
                $token_data = json_decode($resp, true);
                break;

            case 'youtube':
                $resp = $this->_http_post('https://oauth2.googleapis.com/token', [
                    'client_id'     => $settings['app_id'],
                    'client_secret' => $settings['app_secret'],
                    'redirect_uri'  => $callback,
                    'grant_type'    => 'authorization_code',
                    'code'          => $code,
                ]);
                $token_data = json_decode($resp, true);
                break;

            case 'tiktok':
                $resp = $this->_http_post('https://open.tiktokapis.com/v2/oauth/token/', [
                    'client_key'    => $settings['app_id'],
                    'client_secret' => $settings['app_secret'],
                    'grant_type'    => 'authorization_code',
                    'auth_code'     => $code,
                    'redirect_uri'  => $callback,
                ]);
                $token_data = json_decode($resp, true);
                break;
        }

        if ($token_data && !empty($token_data['access_token'])) {
            $expires = !empty($token_data['expires_in'])
                ? date('Y-m-d H:i:s', time() + (int)$token_data['expires_in'])
                : null;
            $this->sg->save_user_token($this->user_id, $platform, $token_data['access_token'], $token_data, $expires);
        }

        redirect('social_growth/share_wizard/' . (int)$state);
    }

    // =========================================================================
    // DO SHARE
    // =========================================================================

    public function do_share($platform = '', $ad_id = 0)
    {
        if (!$this->aauth->is_loggedin()) {
            echo json_encode(['status' => 'Error', 'message' => 'Login required']); return;
        }

        $ad_id   = (int)$ad_id;
        $ad_type = $this->input->post('ad_type') ?: 'logs';
        $lot     = $this->mp->get_lot_details($ad_id, $ad_type);
        if (!$lot) { echo json_encode(['status' => 'Error', 'message' => 'Ad not found']); return; }

        $generated = $this->sg->get_generated_media($ad_id);
        $posters   = array_values(array_filter($generated, fn($m) => $m['media_type'] === 'poster'));
        $videos    = array_values(array_filter($generated, fn($m) => $m['media_type'] === 'video'));

        $caption   = !empty($posters) ? $posters[0]['caption'] : '';
        $hashtags  = !empty($posters) ? $posters[0]['hashtags'] : '';
        $full_text = $caption . "\n" . $hashtags . "\n🔗 " . site_url('shop/view/' . $ad_type . '/' . $ad_id);

        $referral_token = $this->sg->generate_referral_token($this->user_id, $ad_id, $platform);
        $token_row = $this->sg->get_user_token($this->user_id, $platform);
        $access_token = $token_row['access_token'] ?? null;

        $result = ['status' => 'Success', 'post_id' => null, 'message' => ''];

        switch ($platform) {
            case 'facebook':
                if (!$access_token) {
                    $result = ['status' => 'Error', 'message' => 'Connect your Facebook account first.'];
                    break;
                }
                // Post to profile
                $post_resp = $this->_http_post('https://graph.facebook.com/v19.0/me/feed', [
                    'access_token' => $access_token,
                    'message'      => $full_text,
                    'link'         => site_url('social_growth/track_link/' . $referral_token),
                ]);
                $post_data = json_decode($post_resp, true);
                $result['post_id'] = $post_data['id'] ?? null;
                $result['message'] = $result['post_id'] ? 'Posted to Facebook!' : ($post_data['error']['message'] ?? 'Post failed');
                if (!$result['post_id']) $result['status'] = 'Error';
                break;

            case 'whatsapp':
                // WhatsApp is done client-side (wa.me deep link)
                $result['message'] = 'WhatsApp link generated';
                $result['wa_url']  = 'https://wa.me/?text=' . urlencode($full_text . "\n" . site_url('social_growth/track_link/' . $referral_token));
                break;

            case 'youtube':
                if (!$access_token || empty($videos)) {
                    $result = ['status' => 'Error', 'message' => empty($videos) ? 'No video generated yet.' : 'Connect YouTube first.'];
                    break;
                }
                $video_file = FCPATH . $videos[0]['file_path'];
                if (!file_exists($video_file)) {
                    $result = ['status' => 'Error', 'message' => 'Video file not found']; break;
                }
                $upload_resp = $this->_upload_to_youtube($access_token, $video_file, ($lot['species'] ?? 'Timber') . ' - TimberPro', $full_text);
                $result = $upload_resp;
                break;

            case 'tiktok':
                if (!$access_token || empty($videos)) {
                    $result = ['status' => 'Error', 'message' => empty($videos) ? 'No video generated yet.' : 'Connect TikTok first.'];
                    break;
                }
                $video_file = FCPATH . $videos[0]['file_path'];
                $tiktok_resp = $this->_upload_to_tiktok($access_token, $video_file, ($lot['species'] ?? 'Timber'), $full_text);
                $result = $tiktok_resp;
                break;

            default:
                $result = ['status' => 'Error', 'message' => 'Unknown platform'];
        }

        // Log the share
        $status = $result['status'] === 'Success' ? 'success' : 'failed';
        $this->sg->log_share(
            $this->user_id, $ad_id, $ad_type, $platform,
            $status, $referral_token,
            $result['post_id'] ?? null,
            $result['status'] !== 'Success' ? $result['message'] : null
        );

        // Check and award badges
        $new_badges = $this->sg->_check_and_award_badges($this->user_id);
        $result['new_badges'] = $new_badges;
        $result['share_count'] = $this->sg->count_user_shares($this->user_id);

        // Check speed sharer badge (all within 10 min)
        $this->_check_speed_sharer_badge($this->user_id, $ad_id);

        echo json_encode($result);
    }

    public function verify_share($ad_id = 0)
    {
        if (!$this->aauth->is_loggedin()) {
            echo json_encode(['status' => 'Error', 'message' => 'Login required']); return;
        }

        $ad_id = (int)$ad_id;
        $share_status = $this->sg->get_share_status($this->user_id, $ad_id);

        $platforms_done = array_filter($share_status, fn($s) => $s === 'success');
        $total_done     = count($platforms_done);
        $insights       = $this->sg->get_referral_insights($this->user_id);
        $badges         = $this->sg->get_user_badges($this->user_id);

        echo json_encode([
            'status'       => 'Success',
            'share_status' => $share_status,
            'total_done'   => $total_done,
            'all_done'     => $total_done >= 3,
            'insights'     => $insights,
            'badges'       => $badges,
        ]);
    }

    // =========================================================================
    // REFERRAL LINK TRACKER
    // =========================================================================

    public function track_link($token = '')
    {
        if (!$token) { redirect('shop'); return; }

        $log = $this->sg->track_referral_click(
            $token,
            $this->input->ip_address(),
            $this->input->user_agent()
        );

        if ($log) {
            redirect('shop/view/' . ($log['ad_type'] ?? 'logs') . '/' . ($log['ad_id'] ?? ''));
        } else {
            redirect('shop');
        }
    }

    // =========================================================================
    // USER INSIGHTS
    // =========================================================================

    public function my_insights()
    {
        if (!$this->aauth->is_loggedin()) { redirect('user'); return; }

        $insights  = $this->sg->get_referral_insights($this->user_id);
        $leaderboard = $this->sg->get_leaderboard(10);
        $my_rank   = null;
        foreach ($leaderboard as $i => $l) {
            if ((int)$l['user_id'] === $this->user_id) {
                $my_rank = $i + 1;
                break;
            }
        }

        $head = ['title' => 'My Social Insights | TimberPro', 'is_shop' => true];
        $data = [
            'insights'    => $insights,
            'leaderboard' => $leaderboard,
            'my_rank'     => $my_rank,
            'username'    => $this->username,
        ];
        $this->load->view('shop/header', $head);
        $this->load->view('social_growth/my_insights', $data);
        $this->load->view('shop/footer');
    }

    // =========================================================================
    // REPOST REMINDER (called by Cronjob)
    // =========================================================================

    public function repost_check()
    {
        if (!$this->is_admin && php_sapi_name() !== 'cli') {
            show_error('Access denied', 403); return;
        }
        $due = $this->sg->get_ads_due_for_repost();
        $count = 0;
        foreach ($due as $item) {
            // Log a reminder notification (using existing notification mechanism or email)
            // For now, we log it to a simple table entry
            $this->sg->log_share(
                $item['user_id'], $item['ad_id'], $item['ad_type'] ?? 'logs',
                'system_reminder', 'pending', null
            );
            $count++;
        }
        echo json_encode(['status' => 'Success', 'reminders_sent' => $count]);
    }

    // =========================================================================
    // MEDIA GENERATION ENGINE (Private Methods)
    // =========================================================================

    /**
     * AI Image Enhancement: auto brightness + contrast correction via GD
     */
    private function _enhance_image($source_path, $ad_id)
    {
        $info = @getimagesize($source_path);
        if (!$info) return $source_path;

        switch ($info[2]) {
            case IMAGETYPE_JPEG: $img = imagecreatefromjpeg($source_path); break;
            case IMAGETYPE_PNG:  $img = imagecreatefrompng($source_path);  break;
            case IMAGETYPE_GIF:  $img = imagecreatefromgif($source_path);  break;
            default: return $source_path;
        }
        if (!$img) return $source_path;

        imagefilter($img, IMG_FILTER_BRIGHTNESS, 15);
        imagefilter($img, IMG_FILTER_CONTRAST, -10);
        imagefilter($img, IMG_FILTER_SATURATION, 20);

        $out_path = $this->media_dir . "enhanced_{$ad_id}.jpg";
        imagejpeg($img, $out_path, 90);
        imagedestroy($img);

        return 'userfiles/generated_media/enhanced_' . $ad_id . '.jpg';
    }

    /**
     * Generate social media caption and hashtags
     * Uses OpenAI if key available, otherwise smart PHP template
     */
    private function _generate_caption($lot)
    {
        $settings = $this->sg->get_api_settings('openai');
        $species  = $lot['species'] ?? 'Timber';
        $price    = number_format($lot['selling_price'] ?? 0);
        $location = $lot['location'] ?? 'Sri Lanka';
        $type     = $lot['lot_type'] ?? 'logs';

        // Try OpenAI
        if (!empty($settings['api_key'])) {
            $prompt = "Write a compelling Sri Lankan timber ad caption in Sinhala and English mixed style (max 2 sentences) for: {$species} {$type}, LKR {$price}, from {$location}. Add relevant hashtags.";
            try {
                $resp = $this->_http_post('https://api.openai.com/v1/chat/completions',
                    json_encode([
                        'model'    => 'gpt-4o-mini',
                        'messages' => [['role' => 'user', 'content' => $prompt]],
                        'max_tokens' => 200,
                    ]),
                    ['Authorization: Bearer ' . $settings['api_key'], 'Content-Type: application/json']
                );
                $data = json_decode($resp, true);
                if (!empty($data['choices'][0]['message']['content'])) {
                    $content = $data['choices'][0]['message']['content'];
                    // Split hashtags from caption
                    preg_match_all('/#\w+/', $content, $tags);
                    $hashtags = implode(' ', $tags[0]);
                    $caption  = trim(preg_replace('/#\w+/', '', $content));
                    return [$caption, $hashtags];
                }
            } catch (Exception $e) { /* Fall through to template */ }
        }

        // Smart template fallback
        $templates = [
            "🌿 {$species} {$type} - LKR {$price} පමණින් ලබා ගන්න! 📍 {$location} | ☎️ දැනම අළවි යවන්න.",
            "✨ Premium {$species} timber - Best quality, best price LKR {$price}. 📍 {$location}",
            "🏆 {$species} {$type} | LKR {$price} | 📍 {$location} | TimberPro ජාලයෙන් ලබා ගන්න!",
        ];
        $caption   = $templates[array_rand($templates)];
        $hashtags  = "#TimberSL #{$species}LK #WoodWorking #SriLankaTimber #TimberPro #{$type}forsale";

        return [$caption, $hashtags];
    }

    /**
     * Generate one poster image for a given template slot (1–5) using PHP GD
     */
    private function _generate_poster($lot, $slot, $source_image_path, $ad_id, $caption, $hashtags)
    {
        $width = 1080; $height = 1080;
        $canvas = imagecreatetruecolor($width, $height);

        // Define template colors / styles
        $templates = [
            1 => ['bg' => [26, 60, 114],   'accent' => [255, 193, 7],  'name' => 'Direct Sales',    'style' => 'price_bold'],
            2 => ['bg' => [45, 45, 45],    'accent' => [255, 215, 0],  'name' => 'Trust/Review',    'style' => 'review'],
            3 => ['bg' => [27, 94, 32],    'accent' => [255, 255, 255],'name' => 'Location Focused','style' => 'location'],
            4 => ['bg' => [183, 28, 28],   'accent' => [255, 235, 59], 'name' => 'Urgency',         'style' => 'urgency'],
            5 => ['bg' => [245, 245, 245], 'accent' => [33, 33, 33],   'name' => 'Minimalist',      'style' => 'minimal'],
        ];

        $tpl   = $templates[$slot] ?? $templates[1];
        $bg    = $tpl['bg'];
        $accent= $tpl['accent'];

        // === Background ===
        $bg_color = imagecolorallocate($canvas, $bg[0], $bg[1], $bg[2]);
        imagefill($canvas, 0, 0, $bg_color);

        // === Try to use uploaded template background ===
        $tpl_db = $this->sg->get_template_by_slot($slot);
        if (!empty($tpl_db['file_path']) && file_exists(FCPATH . $tpl_db['file_path'])) {
            $tpl_img = @imagecreatefromjpeg(FCPATH . $tpl_db['file_path'])
                    ?: @imagecreatefrompng(FCPATH . $tpl_db['file_path']);
            if ($tpl_img) {
                imagecopyresampled($canvas, $tpl_img, 0, 0, 0, 0, $width, $height,
                    imagesx($tpl_img), imagesy($tpl_img));
                // Dark overlay for readability
                $overlay = imagecreatetruecolor($width, $height);
                imagefill($overlay, 0, 0, imagecolorallocatealpha($overlay, 0, 0, 0, 60));
                imagecopymerge($canvas, $overlay, 0, 0, 0, 0, $width, $height, 55);
                imagedestroy($tpl_img);
                imagedestroy($overlay);
            }
        }

        // === Source photo (top half) for non-minimalist templates ===
        if ($slot !== 5 && $source_image_path && file_exists(FCPATH . ltrim($source_image_path, '/'))) {
            $src_path = FCPATH . ltrim($source_image_path, '/');
            $info     = @getimagesize($src_path);
            if ($info) {
                switch ($info[2]) {
                    case IMAGETYPE_JPEG: $src_img = imagecreatefromjpeg($src_path); break;
                    case IMAGETYPE_PNG:  $src_img = imagecreatefrompng($src_path); break;
                    default: $src_img = null;
                }
                if (!empty($src_img)) {
                    // Place photo in upper 55% of canvas
                    imagecopyresampled($canvas, $src_img, 0, 0, 0, 0, $width, (int)($height * 0.55),
                        imagesx($src_img), imagesy($src_img));
                    imagedestroy($src_img);
                }
            }
        }

        // === Colors ===
        $white    = imagecolorallocate($canvas, 255, 255, 255);
        $black    = imagecolorallocate($canvas, 0, 0, 0);
        $accent_c = imagecolorallocate($canvas, $accent[0], $accent[1], $accent[2]);
        $dark_bg  = imagecolorallocate($canvas, $bg[0], $bg[1], $bg[2]);
        $text_col = ($slot === 5) ? $black : $white;
        $y_start  = ($slot === 5) ? 100 : (int)($height * 0.58);

        // === Species / Name (large) ===
        $species  = strtoupper($lot['species'] ?? 'TIMBER');
        $lot_type = ucfirst($lot['lot_type'] ?? 'Logs');
        $font     = 5; // built-in GD font

        // Title background strip
        $strip_h = 80;
        imagefilledrectangle($canvas, 0, $y_start, $width, $y_start + $strip_h, $dark_bg);

        // Draw species name
        $text_x = 40;
        imagestring($canvas, $font, $text_x, $y_start + 15, $species . ' ' . $lot_type, $accent_c);

        // === Price badge ===
        $price_y = $y_start + $strip_h + 20;
        $price   = 'LKR ' . number_format($lot['selling_price'] ?? 0);

        if ($slot === 4) { // Urgency — big red badge
            imagefilledrectangle($canvas, 0, $price_y, $width, $price_y + 90, imagecolorallocate($canvas, 220, 30, 30));
            imagestring($canvas, $font, $text_x, $price_y + 15, 'සීමිත තොගයක්! HURRY!', $white);
            imagestring($canvas, $font, $text_x, $price_y + 45, $price, imagecolorallocate($canvas, 255, 235, 59));
        } else {
            imagestring($canvas, $font, $text_x, $price_y + 10, $price, $accent_c);
        }

        // === Location ===
        if ($slot === 3) {
            $loc_text = 'දැන් ' . ($lot['location'] ?? 'ශ්‍රී ලංකාව') . 'ට / ' . $species;
            imagestring($canvas, 4, $text_x, $price_y + 70, $loc_text, $white);
        }

        // === Review stars for trust template ===
        if ($slot === 2) {
            $stars = '★★★★★ Customer Rated';
            imagestring($canvas, 4, $text_x, $price_y + 70, $stars, $accent_c);
        }

        // === Hashtag strip at bottom ===
        $hash_y  = $height - 60;
        $hash_bg = imagecolorallocate($canvas, 0, 0, 0);
        imagefilledrectangle($canvas, 0, $hash_y, $width, $height, $hash_bg);
        imagestring($canvas, 2, $text_x, $hash_y + 10, substr($hashtags, 0, 80), imagecolorallocate($canvas, 150, 220, 150));

        // === Business logo watermark ===
        $logo_path = FCPATH . 'userfiles/company/';
        $logo_files = glob($logo_path . '*.{jpg,jpeg,png}', GLOB_BRACE);
        if (!empty($logo_files)) {
            $logo_file = $logo_files[0];
            $logo_info = @getimagesize($logo_file);
            if ($logo_info) {
                $logo_img = ($logo_info[2] === IMAGETYPE_PNG) ? @imagecreatefrompng($logo_file) : @imagecreatefromjpeg($logo_file);
                if ($logo_img) {
                    $lw = 120; $lh = 60;
                    imagecopyresampled($canvas, $logo_img, $width - $lw - 20, 20, 0, 0,
                        $lw, $lh, imagesx($logo_img), imagesy($logo_img));
                    imagedestroy($logo_img);
                }
            }
        }

        // === QR Code (simple pixel matrix using GD) ===
        $qr_data = base_url('shop/view/' . ($lot['lot_type'] ?? 'logs') . '/' . $lot['id']);
        $this->_draw_simple_qr($canvas, $qr_data, $width - 160, $price_y + 50, 120);

        // === Save ===
        $out_file = "poster_{$ad_id}_slot{$slot}.jpg";
        $out_path = $this->media_dir . $out_file;
        imagejpeg($canvas, $out_path, 88);
        imagedestroy($canvas);

        return 'userfiles/generated_media/' . $out_file;
    }

    /**
     * Generate Google TTS Sinhala audio
     */
    private function _generate_tts($lot, $ad_id)
    {
        $settings = $this->sg->get_api_settings('google_tts');
        if (empty($settings['api_key'])) return null;

        $species = $lot['species'] ?? 'දැව';
        $price   = number_format($lot['selling_price'] ?? 0);
        $text    = "අඩුම මිලට උසස්ම තත්වයේ {$species} දැව මිලදී ගැනීමට, දැනම් TimberPro අමතන්න. LKR {$price} ක් සිට.";

        $payload = json_encode([
            'input'       => ['text' => $text],
            'voice'       => ['languageCode' => 'si-LK', 'ssmlGender' => 'FEMALE'],
            'audioConfig' => ['audioEncoding' => 'MP3'],
        ]);

        $resp = $this->_http_post(
            'https://texttospeech.googleapis.com/v1/text:synthesize?key=' . $settings['api_key'],
            $payload,
            ['Content-Type: application/json']
        );

        $data = json_decode($resp, true);
        if (!empty($data['audioContent'])) {
            $audio_path = $this->media_dir . "tts_{$ad_id}.mp3";
            file_put_contents($audio_path, base64_decode($data['audioContent']));
            return $audio_path;
        }

        return null;
    }

    /**
     * Generate MP4 video using FFmpeg
     */
    private function _generate_video($poster_paths, $audio_path, $ad_id)
    {
        // Test FFmpeg availability
        exec('ffmpeg -version 2>&1', $out, $ret);
        if ($ret !== 0 || count($poster_paths) < 1) return null;

        // Determine bg music
        $music_found = null;
        foreach (['bg_music.mp3', 'bg_music.ogg', 'bg_music.wav'] as $mf) {
            $mp = FCPATH . 'userfiles/social_templates/' . $mf;
            if (file_exists($mp)) { $music_found = $mp; break; }
        }

        $out_video = $this->media_dir . "promo_{$ad_id}.mp4";
        $slide_duration = 5; // seconds per slide

        // Build FFmpeg concat input file
        $concat_list = $this->media_dir . "concat_{$ad_id}.txt";
        $concat_content = '';
        foreach ($poster_paths as $p) {
            $full_p = FCPATH . $p;
            $concat_content .= "file '" . addslashes($full_p) . "'\nduration {$slide_duration}\n";
        }
        // Repeat last for seamless ending
        if (!empty($poster_paths)) {
            $full_p = FCPATH . end($poster_paths);
            $concat_content .= "file '" . addslashes($full_p) . "'\n";
        }
        file_put_contents($concat_list, $concat_content);

        // Build audio mix argument
        $audio_inputs = '';
        $audio_filter = '';

        if ($audio_path && file_exists($audio_path) && $music_found) {
            // TTS + bg music
            $audio_inputs  = " -i " . escapeshellarg($audio_path) . " -i " . escapeshellarg($music_found);
            $audio_filter  = ' -filter_complex "[2:a]volume=0.3[bg];[1:a][bg]amix=inputs=2:duration=shortest[a]" -map 0:v -map "[a]"';
        } elseif ($audio_path && file_exists($audio_path)) {
            $audio_inputs  = " -i " . escapeshellarg($audio_path);
            $audio_filter  = ' -map 0:v -map 1:a';
        } elseif ($music_found) {
            $audio_inputs  = " -i " . escapeshellarg($music_found);
            $audio_filter  = ' -map 0:v -map 1:a -shortest';
        }

        // Final FFmpeg command
        $cmd = "ffmpeg -y -f concat -safe 0 -i " . escapeshellarg($concat_list)
             . $audio_inputs
             . " -vf \"scale=1080:1080:force_original_aspect_ratio=decrease,pad=1080:1080:(ow-iw)/2:(oh-ih)/2,fps=25,format=yuv420p\""
             . $audio_filter
             . " -c:v libx264 -preset fast -crf 23 -c:a aac -b:a 128k -t 30"
             . " " . escapeshellarg($out_video)
             . " 2>&1";

        exec($cmd, $output, $return_code);
        @unlink($concat_list);

        if ($return_code === 0 && file_exists($out_video)) {
            return 'userfiles/generated_media/promo_' . $ad_id . '.mp4';
        }
        return null;
    }

    /**
     * Upload video to YouTube
     */
    private function _upload_to_youtube($access_token, $video_path, $title, $description)
    {
        $metadata = json_encode([
            'snippet' => [
                'title'       => $title,
                'description' => $description,
                'categoryId'  => '22', // People & Blogs
                'tags'        => ['TimberSL', 'WoodWorking', 'SriLanka'],
            ],
            'status' => ['privacyStatus' => 'public'],
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/upload/youtube/v3/videos?part=snippet,status&uploadType=multipart');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $access_token,
            'Content-Type: multipart/related; boundary=foo_bar_baz',
        ]);
        $body  = "--foo_bar_baz\r\nContent-Type: application/json; charset=UTF-8\r\n\r\n$metadata\r\n";
        $body .= "--foo_bar_baz\r\nContent-Type: video/mp4\r\n\r\n" . file_get_contents($video_path) . "\r\n";
        $body .= "--foo_bar_baz--";
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $resp = curl_exec($ch);
        $err  = curl_error($ch);
        curl_close($ch);

        if ($err) return ['status' => 'Error', 'message' => $err];
        $data = json_decode($resp, true);
        if (!empty($data['id'])) {
            return ['status' => 'Success', 'message' => 'Uploaded to YouTube!', 'post_id' => $data['id']];
        }
        return ['status' => 'Error', 'message' => $data['error']['message'] ?? 'Upload failed'];
    }

    /**
     * Upload video to TikTok
     */
    private function _upload_to_tiktok($access_token, $video_path, $title, $description)
    {
        // Step 1: Initialize upload
        $init_resp = $this->_http_post(
            'https://open.tiktokapis.com/v2/post/publish/video/init/',
            json_encode([
                'post_info'   => ['title' => $title . ' #TimberSL', 'privacy_level' => 'PUBLIC_TO_EVERYONE'],
                'source_info' => ['source' => 'FILE_UPLOAD', 'video_size' => filesize($video_path), 'chunk_size' => filesize($video_path), 'total_chunk_count' => 1],
            ]),
            ['Authorization: Bearer ' . $access_token, 'Content-Type: application/json; charset=UTF-8']
        );
        $init = json_decode($init_resp, true);
        if (empty($init['data']['upload_url'])) {
            return ['status' => 'Error', 'message' => 'TikTok init failed: ' . ($init['error']['message'] ?? 'Unknown')];
        }

        // Step 2: Upload video binary
        $ch = curl_init($init['data']['upload_url']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_PUT, true);
        curl_setopt($ch, CURLOPT_INFILE, fopen($video_path, 'r'));
        curl_setopt($ch, CURLOPT_INFILESIZE, filesize($video_path));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: video/mp4', 'Content-Range: bytes 0-' . (filesize($video_path) - 1) . '/' . filesize($video_path)]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);
        curl_close($ch);

        return ['status' => 'Success', 'message' => 'Uploaded to TikTok!', 'post_id' => $init['data']['publish_id'] ?? null];
    }

    /**
     * Draw a simple placeholder QR code using GD pixel squares
     */
    private function _draw_simple_qr($canvas, $url, $x, $y, $size)
    {
        // Simple finder pattern squares (visual indicator only, not scannable)
        // Full QR generation would require an external library
        $black = imagecolorallocate($canvas, 0, 0, 0);
        $white = imagecolorallocate($canvas, 255, 255, 255);
        $pixel = max(3, (int)($size / 25));

        // Draw QR border squares (finder patterns)
        imagefilledrectangle($canvas, $x, $y, $x + $size, $y + $size, $white);
        // Outer border
        imagerectangle($canvas, $x + 2, $y + 2, $x + $size - 2, $y + $size - 2, $black);
        // Top-left finder
        imagefilledrectangle($canvas, $x + 4, $y + 4, $x + 4 + $pixel * 7, $y + 4 + $pixel * 7, $black);
        imagefilledrectangle($canvas, $x + 6, $y + 6, $x + 4 + $pixel * 7 - 2, $y + 4 + $pixel * 7 - 2, $white);
        imagefilledrectangle($canvas, $x + 8, $y + 8, $x + 4 + $pixel * 5, $y + 4 + $pixel * 5, $black);
        // URL text below QR (tiny)
        imagestring($canvas, 1, $x, $y + $size + 2, 'Scan for details', $black);
    }

    /**
     * Check and award Speed Sharer badge
     */
    private function _check_speed_sharer_badge($user_id, $ad_id)
    {
        $this->db->where('user_id', $user_id)->where('ad_id', $ad_id)->where('status', 'success');
        $this->db->select('MIN(created_at) AS first_share, MAX(created_at) AS last_share, COUNT(*) AS cnt');
        $row = $this->db->get('share_logs')->row_array();

        if (!empty($row['cnt']) && (int)$row['cnt'] >= 3) {
            $diff = strtotime($row['last_share']) - strtotime($row['first_share']);
            if ($diff <= 600) { // within 10 minutes
                $this->sg->award_badge($user_id, 'speed_sharer');
            }
        }
    }

    /**
     * Generic HTTP POST helper
     */
    private function _http_post($url, $data, $headers = [])
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        if (is_array($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        if ($headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $resp = curl_exec($ch);
        curl_close($ch);
        return $resp;
    }
}
