<?php
global $conn;
global $personal_info;

if (empty($personal_info) && isset($conn)) {
    $info_result = $conn->query("SELECT * FROM personal_info LIMIT 1");
    $personal_info = $info_result ? $info_result->fetch_assoc() : [];
}
?>
<section class="hero-structural">
    <div class="container">
        <div class="row align-items-center">
            
            <div class="col-lg-7 order-2 order-lg-1 mt-5 mt-lg-0 hero-content-box">
                <span class="mono-accent">// INTRODUCTION</span>
                
                <h1 class="hero-title-main">
                    <?= htmlspecialchars($personal_info['full_name'] ?? 'STEVE OWEIN G. PRESIDENTE') ?>
                </h1>
                
                <h3 class="hero-subtitle-main">
                    <?= htmlspecialchars(!empty($personal_info['hero_title']) ? $personal_info['hero_title'] : 'Information Systems Student') ?>
                </h3>
                
                <p class="hero-desc-main">
                    <?= nl2br(htmlspecialchars(!empty($personal_info['hero_tagline']) ? $personal_info['hero_tagline'] : $personal_info['career_objective'])) ?>
                </p>
                
                <div class="action-group">
                    <a href="<?= $base_url ?>/portfolio" class="btn-primary-solid">VIEW WORK</a>
                    <a href="<?= $base_url ?>/view-resume" class="btn-secondary-outline">VIEW RESUME</a>
                </div>
                
                <div class="stats-bar mt-5 pt-4 border-top border-secondary">
                    <div class="row g-4">
                        <div class="col-sm-4">
                            <strong class="d-block text-white mb-2">Location</strong>
                            <span class="text-muted" style="font-size: 0.9rem;"><?= htmlspecialchars($personal_info['address']) ?></span>
                        </div>
                        <div class="col-sm-4">
                            <strong class="d-block text-white mb-2">Contact</strong>
                            <span class="text-muted" style="font-size: 0.9rem;"><?= htmlspecialchars($personal_info['contact_number']) ?></span>
                        </div>
                        <div class="col-sm-4">
                            <strong class="d-block text-white mb-2">Email</strong>
                            <span class="text-muted" style="font-size: 0.9rem;"><?= htmlspecialchars($personal_info['email']) ?></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5 order-1 order-lg-2 text-center text-lg-end">
                <div class="hero-image-box">
                    <div class="hero-img-inner">
                        <img src="<?= $base_url ?>/assets/images/<?= htmlspecialchars($personal_info['profile_image'] ?? 'steve.jpg') ?>" class="img-fluid" alt="<?= htmlspecialchars($personal_info['full_name'] ?? 'Profile Image') ?>" style="border: 1px solid rgba(255,255,255,0.1); border-radius: 4px; padding: 10px; background: #141414;">
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
