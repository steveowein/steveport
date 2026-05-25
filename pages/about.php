<?php
global $conn;
$edu_result = $conn->query("SELECT * FROM education ORDER BY id DESC");
$exp_result = $conn->query("SELECT * FROM experience ORDER BY id DESC");
?>
<section class="page-hero">
    <div class="container">
        <span class="page-subtitle">// Discover</span>
        <h1 class="page-title">About Me</h1>
    </div>
</section>

<section class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <h3 class="mb-5 text-white" style="font-weight: 700;">Education</h3>
                <?php if($edu_result && $edu_result->num_rows > 0): ?>
                    <?php while($edu = $edu_result->fetch_assoc()): ?>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <span class="timeline-date"><?= htmlspecialchars($edu['year']) ?></span>
                            <h4 class="text-white mb-2"><?= htmlspecialchars($edu['degree']) ?></h4>
                            <p class="text-muted mb-0"><?= htmlspecialchars($edu['institution']) ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <!-- Fallback based on CV -->
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <span class="timeline-date">2024</span>
                        <h4 class="text-white mb-2">Bachelor of Science in Information Systems</h4>
                        <p class="text-muted mb-0">Davao del Norte State College</p>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <span class="timeline-date">2022-2024</span>
                        <h4 class="text-white mb-2">Technical-Vocational-Livelihood (SMAW)</h4>
                        <p class="text-muted mb-0">Balagunan National High School</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="col-lg-6">
                <h3 class="mb-5 text-white" style="font-weight: 700;">Experience</h3>
                <?php if($exp_result && $exp_result->num_rows > 0): ?>
                    <?php while($exp = $exp_result->fetch_assoc()): ?>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <span class="timeline-date"><?= htmlspecialchars($exp['date']) ?></span>
                            <h4 class="text-white mb-2"><?= htmlspecialchars($exp['role']) ?></h4>
                            <p class="text-muted mb-0"><?= nl2br(htmlspecialchars($exp['description'])) ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <!-- Fallback based on CV -->
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <span class="timeline-date">Jun 2024</span>
                        <h4 class="text-white mb-2">Helper / SMAW</h4>
                        <p class="text-muted mb-0">
                            - Assisted in technical tasks and supported instructors during practical sessions.<br>
                            - Helped organize and maintain workshop tools and materials.<br>
                            - Learned and performed basic SMAW procedures under supervision.<br>
                            - Gained hands-on experience and practical skills in welding and technical operations.
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
