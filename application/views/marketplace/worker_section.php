<div class="worker-section-container">
    <!-- Worker Sub-Navigation -->
    <div class="worker-subnav">
        <div class="subnav-tabs">
            <button class="subnav-btn active" onclick="switchWorkerTab('worker-grid')">
                <i class="fa fa-hard-hat"></i> Active Workers
            </button>
            <button class="subnav-btn" onclick="switchWorkerTab('request-list')">
                <i class="fa fa-briefcase"></i> Buyer Requests
            </button>
        </div>
        
        <button class="post-request-btn" onclick="openRequestModal()">
            <i class="fa fa-plus-circle"></i> Post a Request
        </button>
    </div>

    <!-- Workers Grid -->
    <div id="worker-grid" class="worker-content active">
        <div class="listings-grid">
            <?php if(empty($workers)): ?>
                <div class="no-results">
                    <i class="fa fa-users-slash"></i>
                    <p>No active workers found at the moment.</p>
                </div>
            <?php else: ?>
                <?php foreach($workers as $worker): ?>
                <div class="worker-card listing-card" data-category="<?= $worker['category_id'] ?>" data-location="<?= $worker['location'] ?>">
                    <div class="worker-header">
                        <div class="worker-avatar-large">
                            <?php if(!empty($worker['photo'])): ?>
                                <img src="<?= base_url($worker['photo']) ?>" alt="<?= $worker['display_name'] ?>">
                            <?php else: ?>
                                <span><?= strtoupper(substr($worker['display_name'], 0, 1)) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="worker-badges">
                             <span class="listing-badge">VERIFIED</span>
                        </div>
                    </div>
                    
                    <div class="worker-body listing-content">
                        <h3 class="worker-name listing-title"><?= htmlspecialchars($worker['display_name']) ?></h3>
                        <p class="worker-role"><i class="fa fa-tools"></i> <?= htmlspecialchars($worker['category_name'] ?? 'General Worker') ?></p>
                        
                        <div class="worker-rating">
                            <?php 
                                $rating = $worker['average_rating'] ?? 0; 
                                for($i=1; $i<=5; $i++) {
                                    echo '<i class="fa fa-star '.($i <= $rating ? 'filled' : '').'"></i>';
                                }
                            ?>
                            <span>(<?= $worker['total_ratings'] ?? 0 ?>)</span>
                        </div>
                        
                        <div class="worker-details listing-meta">
                            <span class="meta-item"><i class="fa fa-map-marker-alt"></i> <?= htmlspecialchars($worker['location']) ?></span>
                            <span class="meta-item"><i class="fa fa-clock"></i> <?= $worker['experience_years'] ?> Yrs Exp.</span>
                        </div>
                        
                        <div class="worker-price listing-price">
                            LKR <?= number_format($worker['hourly_rate'], 2) ?> <span class="per-unit">/ hr</span>
                        </div>
                        
                        <div class="worker-skills">
                            <?php 
                                $skills = json_decode($worker['skills'] ?? '[]', true);
                                if(is_array($skills)) {
                                    $skills = array_slice($skills, 0, 3);
                                    foreach($skills as $skill) {
                                        echo '<span class="skill-tag">'.htmlspecialchars($skill).'</span>';
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    
                    <div class="worker-footer listing-footer">
                        <button class="view-btn" style="width: 100%" onclick="window.location.href='<?= base_url('worker/view/'.$worker['id']) ?>'">
                            View Profile
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Buyer Requests List -->
    <div id="request-list" class="worker-content">
        <div class="requests-container">
            <?php if(empty($requests)): ?>
                <div class="no-results">
                    <i class="fa fa-clipboard-list"></i>
                    <p>No buyer requests posted yet. Be the first!</p>
                </div>
            <?php else: ?>
                <?php foreach($requests as $req): ?>
                <div class="request-card">
                    <div class="request-header">
                        <div class="request-info">
                            <h3><?= htmlspecialchars($req['title']) ?></h3>
                            <span class="request-date"><i class="fa fa-calendar-alt"></i> <?= date('M d, Y', strtotime($req['created_at'])) ?></span>
                        </div>
                        <div class="request-budget">
                            Budget: <span>LKR <?= number_format($req['budget'], 2) ?></span>
                        </div>
                    </div>
                    
                    <p class="request-desc"><?= nl2br(htmlspecialchars($req['description'])) ?></p>
                    
                    <div class="request-footer">
                        <div class="req-meta">
                            <span><i class="fa fa-user"></i> <?= htmlspecialchars($req['username']) ?></span>
                            <span><i class="fa fa-map-marker-alt"></i> <?= htmlspecialchars($req['location']) ?></span>
                        </div>
                        <button class="apply-btn" onclick="contactBuyer('<?= $req['user_id'] ?>')">Contact Buyer</button>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Post Request Modal -->
<div class="share-modal" id="requestModal">
    <div class="share-content" style="max-width: 600px;">
        <div class="share-header">
            <h3>Post a Buyer Request</h3>
            <button class="close-modal" onclick="closeRequestModal()">×</button>
        </div>
        
        <form id="requestForm" onsubmit="submitRequest(event)">
            <div class="form-group">
                <label>Title (e.g., Need 50 Teak Logs)</label>
                <input type="text" name="title" required class="form-control" placeholder="What are you looking for?">
            </div>
            
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" required class="form-control" rows="4" placeholder="Describe your requirements in detail..."></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Budget (LKR)</label>
                        <input type="number" name="budget" required class="form-control" placeholder="0.00">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" name="location" required class="form-control" placeholder="City/Area">
                    </div>
                </div>
            </div>
            
            <button type="submit" class="submit-btn" style="width: 100%; margin-top: 20px;">Post Request</button>
        </form>
    </div>
</div>

<script>
function switchWorkerTab(tabId) {
    document.querySelectorAll('.subnav-btn').forEach(btn => btn.classList.remove('active'));
    event.target.closest('.subnav-btn').classList.add('active');
    
    document.querySelectorAll('.worker-content').forEach(content => content.classList.remove('active'));
    document.getElementById(tabId).classList.add('active');
}

function openRequestModal() {
    <?php if(!$is_logged_in): ?>
        window.location.href = '<?= base_url('user') ?>';
        return;
    <?php endif; ?>
    document.getElementById('requestModal').classList.add('active');
}

function closeRequestModal() {
    document.getElementById('requestModal').classList.remove('active');
}

function submitRequest(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());
    
    // Add CSRF token if needed, or implement simple ajax
    fetch('<?= base_url('marketplace/add_request') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'Success') {
            alert('Request posted successfully!');
            location.reload();
        } else {
            alert(data.message || 'Error posting request');
        }
    });
}
</script>
