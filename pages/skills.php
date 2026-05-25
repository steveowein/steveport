<?php
global $conn;
$skill_result = $conn->query("SELECT * FROM skills ORDER BY id DESC");
?>
<section class="page-hero">
    <div class="container">
        <span class="page-subtitle">// Abilities</span>
        <h1 class="page-title">My Skills</h1>
    </div>
</section>

<section class="page-content">
    <div class="container">
        <div class="row g-4">
            <?php if($skill_result && $skill_result->num_rows > 0): ?>
                <?php while($skill = $skill_result->fetch_assoc()): ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card-premium text-center" style="padding: 30px 15px;">
                            <?php if(!empty($skill['icon_image'])): ?>
                                <div class="mb-3"><img src="<?= $base_url ?>/assets/images/<?= htmlspecialchars($skill['icon_image']) ?>" height="40" alt="<?= htmlspecialchars($skill['skill_name']) ?>"></div>
                            <?php elseif(!empty($skill['icon_class'])): ?>
                                <?php if(strpos($skill['icon_class'], 'http') !== false): ?>
                                    <div class="mb-3"><img src="<?= htmlspecialchars($skill['icon_class']) ?>" height="40" alt="<?= htmlspecialchars($skill['skill_name']) ?>"></div>
                                <?php else: ?>
                                    <div class="card-icon mb-3"><i class="<?= htmlspecialchars($skill['icon_class']) ?>"></i></div>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <h4 class="text-white mb-3" style="font-size: 1.1rem;"><?= htmlspecialchars($skill['skill_name']) ?></h4>
                            
                            <div class="progress bg-dark" style="height: 6px; border-radius: 3px;">
                                <div class="progress-bar bg-light" role="progressbar" style="width: <?= (int)$skill['level'] ?>%;" aria-valuenow="<?= (int)$skill['level'] ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <!-- Fallbacks -->
                <?php
                $default_skills = [
                    'Figma (Basic UI Design)',
                    'Adaptability',
                    'Teamwork',
                    'Time management',
                    'Information Systems',
                    'SMAW Operations',
                    'Problem Solving',
                    'Technical Tasks'
                ];
                foreach ($default_skills as $s):
                ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card-premium text-center d-flex justify-content-center align-items-center" style="padding: 30px 15px; min-height: 120px;">
                            <h4 class="text-white mb-0" style="font-size: 1.1rem;"><?= htmlspecialchars($s) ?></h4>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
