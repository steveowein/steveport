<?php
global $conn;
$serv_result = $conn->query("SELECT * FROM services ORDER BY id DESC");
?>
<section class="page-hero">
    <div class="container">
        <span class="page-subtitle">// Solutions</span>
        <h1 class="page-title">My Services</h1>
    </div>
</section>

<section class="page-content">
    <div class="container">
        <div class="row g-4">
            <?php if($serv_result && $serv_result->num_rows > 0): ?>
                <?php while($serv = $serv_result->fetch_assoc()): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card-premium">
                            <?php if(strpos($serv['icon'], 'http') !== false): ?>
                                <div class="mb-4"><img src="<?= htmlspecialchars($serv['icon']) ?>" height="50" alt="<?= htmlspecialchars($serv['title']) ?>"></div>
                            <?php elseif(strpos($serv['icon'], 'fas ') !== false || strpos($serv['icon'], 'fab ') !== false): ?>
                                <i class="<?= htmlspecialchars($serv['icon']) ?> card-icon"></i>
                            <?php else: ?>
                                <div class="mb-4"><img src="<?= $base_url ?>/assets/images/<?= htmlspecialchars($serv['icon']) ?>" height="50" alt="Service Icon"></div>
                            <?php endif; ?>
                            
                            <h3 class="card-title"><?= htmlspecialchars($serv['title']) ?></h3>
                            <p class="text-secondary mb-0"><?= nl2br(htmlspecialchars($serv['description'])) ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <!-- Fallbacks -->
                <div class="col-md-6 col-lg-4">
                    <div class="card-premium">
                        <i class="fab fa-figma card-icon"></i>
                        <h3 class="card-title">Basic UI Design</h3>
                        <p class="text-muted mb-0">Crafting clean, intuitive, and modern user interfaces using Figma, focusing on layout and user experience.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card-premium">
                        <i class="fas fa-fire-burner card-icon"></i>
                        <h3 class="card-title">SMAW Operations</h3>
                        <p class="text-muted mb-0">Executing technical tasks and Shielded Metal Arc Welding procedures safely and precisely based on NC II standards.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card-premium">
                        <i class="fas fa-code card-icon"></i>
                        <h3 class="card-title">Technical Support</h3>
                        <p class="text-muted mb-0">Applying Information Systems knowledge to solve technical problems and organize tools and materials.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
