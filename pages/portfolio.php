<?php
global $conn;
$port_result = $conn->query("SELECT * FROM portfolio ORDER BY id DESC");
?>
<section class="page-hero">
    <div class="container">
        <span class="page-subtitle">// Selected Work</span>
        <h1 class="page-title">Portfolio</h1>
    </div>
</section>

<section class="page-content">
    <div class="container">
        <div class="row g-4">
            <?php if($port_result && $port_result->num_rows > 0): ?>
                <?php while($port = $port_result->fetch_assoc()): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card-premium p-0 overflow-hidden">
                            <?php if(!empty($port['image'])): ?>
                                <img src="<?= $base_url ?>/assets/images/<?= htmlspecialchars($port['image']) ?>" alt="Project" class="portfolio-img">
                            <?php else: ?>
                                <div class="portfolio-img bg-dark d-flex align-items-center justify-content-center">
                                    <i class="fas fa-image fs-1 text-muted"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="p-4">
                                <h3 class="card-title"><?= htmlspecialchars($port['title']) ?></h3>
                                
                                <div class="d-flex justify-content-between text-muted mb-3" style="font-size: 0.85rem;">
                                    <?php if(!empty($port['client'])): ?>
                                        <span><i class="fas fa-user-tie me-1"></i> <?= htmlspecialchars($port['client']) ?></span>
                                    <?php endif; ?>
                                    <?php if(!empty($port['project_date'])): ?>
                                        <span><i class="far fa-calendar me-1"></i> <?= htmlspecialchars($port['project_date']) ?></span>
                                    <?php endif; ?>
                                </div>
                                
                                <p class="text-secondary mb-4"><?= htmlspecialchars($port['description']) ?></p>
                                
                                <?php if(!empty($port['tech_stack'])): ?>
                                    <div class="mb-4">
                                        <?php foreach(explode(',', $port['tech_stack']) as $tech): ?>
                                            <span class="badge bg-dark text-white me-1 border border-secondary"><?= htmlspecialchars(trim($tech)) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if(!empty($port['id'])): ?>
                                    <a href="<?= $base_url ?>/project?id=<?= $port['id'] ?>" class="btn-primary-solid" style="padding: 10px 20px; font-size: 0.8rem;"><i class="fas fa-arrow-right me-2"></i>View Details</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <!-- Fallbacks -->
                <div class="col-12 text-center py-5">
                    <i class="fas fa-folder-open text-muted mb-3" style="font-size: 4rem;"></i>
                    <h3 class="text-white">Portfolio Empty</h3>
                    <p class="text-muted">No projects have been added yet. Please log in to the admin panel to add your work.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
