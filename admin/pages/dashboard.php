<?php
if (!isset($_SESSION['admin_logged_in'])) exit;

// Analytics Queries
$total_visits_res = $conn->query("SELECT SUM(visits) as total FROM visitors");
$total_visits = $total_visits_res ? ($total_visits_res->fetch_assoc()['total'] ?? 0) : 0;

$today = date('Y-m-d');
$today_visits_res = $conn->query("SELECT SUM(visits) as total FROM visitors WHERE visit_date = '$today'");
$today_visits = $today_visits_res ? ($today_visits_res->fetch_assoc()['total'] ?? 0) : 0;

$msg_count_res = $conn->query("SELECT COUNT(id) as total FROM messages");
$total_msgs = $msg_count_res ? $msg_count_res->fetch_assoc()['total'] : 0;

$port_count_res = $conn->query("SELECT COUNT(id) as total FROM portfolio");
$total_projects = $port_count_res ? $port_count_res->fetch_assoc()['total'] : 0;

// Chart Data (Last 7 Days)
$chart_labels = [];
$chart_data = [];
for ($i = 6; $i >= 0; $i--) {
    $d = date('Y-m-d', strtotime("-$i days"));
    $chart_labels[] = date('M d', strtotime($d));
    $v_res = $conn->query("SELECT SUM(visits) as total FROM visitors WHERE visit_date = '$d'");
    $chart_data[] = $v_res ? ($v_res->fetch_assoc()['total'] ?? 0) : 0;
}

// Recent Messages
$recent_msgs = $conn->query("SELECT * FROM messages ORDER BY created_at DESC LIMIT 5");
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="admin-header">
    <h2 class="admin-title">Dashboard</h2>
    <div class="text-muted">Overview & Analytics</div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card-admin text-center">
            <h5 class="text-muted mb-3">Total Visitors</h5>
            <h2 class="text-white m-0"><?= number_format($total_visits) ?></h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-admin text-center">
            <h5 class="text-muted mb-3">Today's Visits</h5>
            <h2 class="text-white m-0"><?= number_format($today_visits) ?></h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-admin text-center">
            <h5 class="text-muted mb-3">Total Messages</h5>
            <h2 class="text-white m-0"><?= number_format($total_msgs) ?></h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-admin text-center">
            <h5 class="text-muted mb-3">Portfolio Projects</h5>
            <h2 class="text-white m-0"><?= number_format($total_projects) ?></h2>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Chart Column -->
    <div class="col-lg-8">
        <div class="card-admin h-100">
            <h4 class="mb-4">Visitor Analytics (Last 7 Days)</h4>
            <canvas id="visitorChart" height="120"></canvas>
        </div>
    </div>
    
    <!-- Messages Column -->
    <div class="col-lg-4">
        <div class="card-admin h-100">
            <h4 class="mb-4">Recent Messages</h4>
            <?php if($recent_msgs && $recent_msgs->num_rows > 0): ?>
                <div class="list-group list-group-flush" style="background: transparent;">
                    <?php while($msg = $recent_msgs->fetch_assoc()): ?>
                        <div class="list-group-item px-0" style="background: transparent; border-bottom: 1px solid rgba(255,255,255,0.1);">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1 text-white"><?= htmlspecialchars($msg['name']) ?></h6>
                                <small class="text-muted"><?= date('M d', strtotime($msg['created_at'])) ?></small>
                            </div>
                            <p class="mb-1 text-secondary small text-truncate"><?= htmlspecialchars($msg['message']) ?></p>
                        </div>
                    <?php endwhile; ?>
                </div>
                <div class="mt-3 text-center">
                    <a href="?page=messages" class="btn btn-sm btn-solid w-100">View All Messages</a>
                </div>
            <?php else: ?>
                <p class="text-muted mb-0">No messages received yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('visitorChart').getContext('2d');
    
    // Create gradient
    let gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(255, 255, 255, 0.2)');
    gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($chart_labels) ?>,
            datasets: [{
                label: 'Unique Visitors',
                data: <?= json_encode($chart_data) ?>,
                borderColor: '#ffffff',
                backgroundColor: gradient,
                borderWidth: 2,
                pointBackgroundColor: '#000000',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 4,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255,255,255,0.05)' },
                    ticks: { color: '#888', stepSize: 1 }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#888' }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            }
        }
    });
});
</script>
