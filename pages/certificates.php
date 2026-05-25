<?php
global $conn;
$cert_result = $conn->query("SELECT * FROM certificates ORDER BY id DESC");
?>
<section class="page-hero">
    <div class="container">
        <span class="page-subtitle">// Achievements</span>
        <h1 class="page-title">Certificates</h1>
    </div>
</section>

<section class="page-content">
    <div class="container">
        <div class="row g-4">
            <?php if($cert_result && $cert_result->num_rows > 0): ?>
                <?php while($cert = $cert_result->fetch_assoc()): ?>
                    <div class="col-md-6">
                        <div class="card-premium">
                            <?php if(!empty($cert['image'])): ?>
                                <img src="<?= $base_url ?>/assets/images/<?= htmlspecialchars($cert['image']) ?>" 
                                     class="img-fluid rounded mb-4" 
                                     alt="<?= htmlspecialchars($cert['title']) ?>" 
                                     style="width:100%; height:200px; object-fit:cover; cursor: pointer; transition: opacity 0.3s;"
                                     onmouseover="this.style.opacity=0.8"
                                     onmouseout="this.style.opacity=1"
                                     onclick="viewCertificate('<?= $base_url ?>/assets/images/<?= htmlspecialchars($cert['image']) ?>', '<?= htmlspecialchars(addslashes($cert['title'])) ?>')">
                            <?php else: ?>
                                <i class="fas fa-award card-icon"></i>
                            <?php endif; ?>
                            
                            <h3 class="card-title"><?= htmlspecialchars($cert['title']) ?></h3>
                            
                            <div class="d-flex justify-content-between text-muted mb-3">
                                <span><i class="fas fa-building me-2"></i><?= htmlspecialchars($cert['issuer']) ?></span>
                                <span><i class="far fa-calendar-alt me-2"></i><?= htmlspecialchars($cert['month'] . ' ' . $cert['year']) ?></span>
                            </div>
                            
                            <?php if(!empty($cert['description'])): ?>
                                <p class="text-secondary mb-3"><?= htmlspecialchars($cert['description']) ?></p>
                            <?php endif; ?>
                            
                            <?php if(!empty($cert['keywords'])): ?>
                                <div class="mt-3 pt-3 border-top border-secondary">
                                    <?php foreach(explode(',', $cert['keywords']) as $kw): ?>
                                        <span class="badge bg-dark text-secondary me-2 border border-secondary"><?= htmlspecialchars(trim($kw)) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <!-- Fallbacks -->
                <div class="col-md-6">
                    <div class="card-premium">
                        <i class="fas fa-award card-icon"></i>
                        <h3 class="card-title">Shielded Metal Arc Welding (SMAW) NC II</h3>
                        <p class="text-muted mb-0">TESDA - Grade 12</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
function viewCertificate(url, title) {
    Swal.fire({
        title: title,
        imageUrl: url,
        imageAlt: title,
        width: 'auto',
        padding: '1em',
        background: '#141414',
        color: '#fff',
        confirmButtonColor: '#fff',
        confirmButtonText: '<span style="color: #000; font-weight: bold;">Close</span>',
        showCloseButton: true,
        customClass: {
            image: 'img-fluid'
        }
    });
}
</script>
