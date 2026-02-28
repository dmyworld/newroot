<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Skilled Workers - TimberPro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f5f7fa; }
        
        .workers-hero {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            padding: 60px 20px 40px;
            color: white;
            text-align: center;
        }
        
        .workers-hero h1 {
            font-size: 40px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .workers-hero p {
            font-size: 18px;
            opacity: 0.9;
        }
        
        .search-bar {
            max-width: 800px;
            margin: 30px auto 0;
            background: white;
            padding: 8px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        }
        
        .search-bar input {
            flex: 1;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            outline: none;
        }
        
        .search-bar button {
            background: #13ec5b;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 600;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
            display: flex;
            gap: 30px;
        }
        
        .filters {
            width: 280px;
            flex-shrink: 0;
        }
        
        .filter-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        
        .filter-card h3 {
            font-size: 16px;
            margin-bottom: 15px;
            color: #333;
        }
        
        .filter-option {
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .filter-option:hover {
            color: #2a5298;
            padding-left: 10px;
        }
        
        .filter-option:last-child {
            border-bottom: none;
        }
        
        .workers-grid {
            flex: 1;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
        }
        
        .worker-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: all 0.3s;
            position: relative;
        }
        
        .worker-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.15);
        }
        
        .worker-header {
            background: linear-gradient(135deg, #2a5298, #1e3c72);
            padding: 30px 20px 60px;
            position: relative;
        }
        
        .worker-photo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 5px solid white;
            position: absolute;
            bottom: -50px;
            left: 50%;
            transform: translateX(-50%);
            object-fit: cover;
            background: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: white;
            font-weight: 700;
            overflow: hidden;
        }
        
        .worker-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .worker-status {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #13ec5b;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }
        
        .worker-body {
            padding: 60px 20px 20px;
            text-align: center;
        }
        
        .worker-name {
            font-size: 22px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }
        
        .worker-category {
            display: inline-block;
            background: #e3f2fd;
            color: #2a5298;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .worker-rating {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 15px;
            font-size: 14px;
        }
        
        .stars {
            color: #ffa500;
        }
        
        .rating-count {
            color: #999;
            font-size: 13px;
        }
        
        .worker-skills {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin: 15px 0;
            justify-content: center;
        }
        
        .skill-tag {
            background: #f0f4f8;
            color: #2a5298;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .worker-meta {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-top: 1px solid #f0f0f0;
            margin-top: 15px;
            font-size: 14px;
            color: #666;
        }
        
        .worker-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .worker-actions {
            padding: 15px 20px;
            background: #f9fafb;
        }
        
        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: #2a5298;
            color: white;
        }
        
        .btn-primary:hover {
            background: #1e3c72;
        }
        
        .btn-success {
            background: #13ec5b;
            color: white;
        }
        
        .btn-success:hover {
            background: #0fa84b;
        }
        
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 80px 20px;
            color: #999;
        }
        
        .empty-state i {
            font-size: 80px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="workers-hero">
    <h1><i class="fa fa-users"></i> Find Skilled Workers</h1>
    <p>Connect with verified timber professionals in Sri Lanka</p>
    
    <div class="search-bar">
        <input type="text" placeholder="Search by skills, location, or category..." id="searchInput">
        <button onclick="searchWorkers()"><i class="fa fa-search"></i> Search</button>
    </div>
</div>

<div class="container">
    <!-- Filters Sidebar -->
    <aside class="filters">
        <div class="filter-card">
            <h3><i class="fa fa-filter"></i> Professional Category</h3>
            <div class="filter-option" onclick="filterByCategory('')">
                <strong>All Categories</strong>
            </div>
            <?php foreach($categories as $cat): ?>
                <div class="filter-option" onclick="filterByCategory('<?= $cat['id'] ?>')">
                    <?= $cat['val1'] ?>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="filter-card">
            <h3><i class="fa fa-star"></i> Rating</h3>
            <div class="filter-option" onclick="filterByRating(4)">
                ★★★★☆ 4+ Stars
            </div>
            <div class="filter-option" onclick="filterByRating(3)">
                ★★★☆☆ 3+ Stars
            </div>
            <div class="filter-option" onclick="filterByRating(0)">
                All Ratings
            </div>
        </div>
    </aside>

    <!-- Workers Grid -->
    <main class="workers-grid">
        <?php if(empty($workers)): ?>
            <div class="empty-state">
                <i class="fa fa-users-slash"></i>
                <h3>No Workers Available</h3>
                <p>Check back later for skilled professionals</p>
            </div>
        <?php else: ?>
            <?php foreach($workers as $worker): 
                $skills = json_decode($worker['skills'], true) ?? [];
                $initials = strtoupper(substr($worker['display_name'], 0, 2));
            ?>
                <div class="worker-card" data-category="<?= $worker['category_id'] ?>" data-rating="<?= floor($worker['average_rating']) ?>">
                    <div class="worker-header">
                        <div class="worker-status">
                            <i class="fa fa-check-circle"></i> AVAILABLE
                        </div>
                        <div class="worker-photo">
                            <?php if(!empty($worker['photo'])): ?>
                                <img src="<?= base_url($worker['photo']) ?>" alt="<?= $worker['display_name'] ?>">
                            <?php else: ?>
                                <?= $initials ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="worker-body">
                        <div class="worker-name"><?= $worker['display_name'] ?></div>
                        <div class="worker-category">
                            <i class="fa fa-briefcase"></i> <?= $worker['category_name'] ?>
                        </div>
                        
                        <div class="worker-rating">
                            <div class="stars">
                                <?php 
                                for($i = 1; $i <= 5; $i++) {
                                    echo $i <= round($worker['average_rating']) ? '★' : '☆';
                                }
                                ?>
                            </div>
                            <span><?= number_format($worker['average_rating'], 1) ?></span>
                            <span class="rating-count">(<?= $worker['total_ratings'] ?>)</span>
                        </div>
                        
                        <div class="worker-skills">
                            <?php foreach(array_slice($skills, 0, 4) as $skill): ?>
                                <span class="skill-tag"><?= $skill ?></span>
                            <?php endforeach; ?>
                            <?php if(count($skills) > 4): ?>
                                <span class="skill-tag">+<?= count($skills) - 4 ?> more</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="worker-meta">
                            <span>
                                <i class="fa fa-clock"></i>
                                <?= $worker['experience_years'] ?> yrs exp
                            </span>
                            <span>
                                <i class="fa fa-map-marker-alt"></i>
                                <?= $worker['location'] ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="worker-actions">
                        <?php if($is_logged_in): ?>
                            <button class="btn btn-success" onclick="showHireModal(<?= $worker['id'] ?>, '<?= $worker['display_name'] ?>')">
                                <i class="fa fa-handshake"></i> Hire Now - LKR <?= number_format($worker['hourly_rate'], 0) ?>/hr
                            </button>
                        <?php else: ?>
                            <a href="<?= base_url('user') ?>" class="btn btn-primary" style="text-decoration: none; display: block; color: white;">
                                <i class="fa fa-sign-in"></i> Login to Hire
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>
</div>

<script>
function filterByCategory(catId) {
    const url = new URL(window.location);
    if (catId) {
        url.searchParams.set('category', catId);
    } else {
        url.searchParams.delete('category');
    }
    window.location = url;
}

function filterByRating(minRating) {
    const cards = document.querySelectorAll('.worker-card');
    cards.forEach(card => {
        const rating = parseInt(card.dataset.rating);
        card.style.display = rating >= minRating ? 'block' : 'none';
    });
}

function searchWorkers() {
    const query = document.getElementById('searchInput').value.toLowerCase();
    const cards = document.querySelectorAll('.worker-card');
    
    cards.forEach(card => {
        const text = card.textContent.toLowerCase();
        card.style.display = text.includes(query) ? 'block' : 'none';
    });
}

function showHireModal(workerId, workerName) {
    // Redirect to hire endpoint
    window.location.href = '<?= base_url("worker/hire/") ?>' + workerId;
}
</script>

</body>
</html>
