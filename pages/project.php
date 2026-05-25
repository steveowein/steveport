<?php
if(!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<div class='container py-5 text-center'><h3>Project not found</h3></div>";
    exit;
}

$id = (int)$_GET['id'];
$result = $conn->query("SELECT * FROM portfolio WHERE id = $id");
if(!$result || $result->num_rows == 0) {
    echo "<div class='container py-5 text-center'><h3>Project not found</h3></div>";
    exit;
}

$project = $result->fetch_assoc();

// Build image array
$images = [];
if(!empty($project['image'])) {
    $images[] = $project['image'];
}
if(!empty($project['additional_images'])) {
    $extra = explode(',', $project['additional_images']);
    foreach($extra as $img) {
        $img = trim($img);
        if(!empty($img)) $images[] = $img;
    }
}
?>

<section class="page-hero pb-4">
    <div class="container">
        <a href="<?= $base_url ?>/portfolio" class="text-muted text-decoration-none mb-3 d-inline-block"><i class="fas fa-arrow-left me-2"></i>Back to Portfolio</a>
        <h1 class="page-title" style="font-size: 2.5rem;"><?= htmlspecialchars($project['title']) ?></h1>
    </div>
</section>

<section class="page-content pt-0">
    <div class="container">
        
        <!-- Image Carousel -->
        <?php if(count($images) > 0): ?>
            <div class="card-premium p-1 mb-5" style="border-radius: 8px; overflow: hidden; background: var(--bg-secondary);">
                <div id="projectCarousel" class="carousel slide" data-bs-ride="carousel">
                    <?php if(count($images) > 1): ?>
                    <div class="carousel-indicators">
                        <?php foreach($images as $index => $img): ?>
                            <button type="button" data-bs-target="#projectCarousel" data-bs-slide-to="<?= $index ?>" <?= $index === 0 ? 'class="active"' : '' ?>></button>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    
                    <div class="carousel-inner">
                        <?php foreach($images as $index => $img): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <img src="<?= $base_url ?>/assets/images/<?= htmlspecialchars($img) ?>" class="d-block w-100" alt="Project Image" style="max-height: 700px; object-fit: contain; background: #000; border-radius: 6px;">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <?php if(count($images) > 1): ?>
                    <button class="carousel-control-prev" type="button" data-bs-target="#projectCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#projectCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Project Details -->
        <div class="row g-4">
            <!-- Left Column: Overview -->
            <div class="col-lg-8">
                <div class="card-premium h-100">
                    <h3 class="mb-4 d-flex align-items-center">
                        <i class="fas fa-file-alt me-3 text-muted"></i> Project Overview
                    </h3>
                    <div class="border-top border-secondary pt-4 text-secondary" style="line-height: 1.8; font-size: 1.05rem;">
                        <?= nl2br(htmlspecialchars($project['description'])) ?>
                    </div>
                </div>
            </div>
            
            <!-- Right Column: Meta Info -->
            <div class="col-lg-4">
                <div class="row g-4">
                    <!-- Technologies -->
                    <div class="col-12">
                        <div class="card-premium">
                            <h5 class="mb-3 d-flex align-items-center" style="font-size: 1.1rem;">
                                <i class="fas fa-code me-2 text-muted"></i> Technologies
                            </h5>
                            <div class="d-flex flex-wrap gap-2">
                                <?php 
                                if(!empty($project['tech_stack'])) {
                                    $techs = explode(',', $project['tech_stack']);
                                    foreach($techs as $tech) {
                                        echo '<span class="badge bg-dark text-white border border-secondary px-3 py-2" style="font-weight: 500;">'.htmlspecialchars(trim($tech)).'</span>';
                                    }
                                } else {
                                    echo '<span class="text-muted">Not specified</span>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Client Info -->
                    <div class="col-12">
                        <div class="card-premium">
                            <h5 class="mb-3 d-flex align-items-center" style="font-size: 1.1rem;">
                                <i class="fas fa-user-tie me-2 text-muted"></i> Client / Meta
                            </h5>
                            <div class="mb-2">
                                <strong class="text-white d-block mb-1">Client</strong>
                                <span class="text-secondary"><?= !empty($project['client']) ? htmlspecialchars($project['client']) : 'Academic / Personal Project' ?></span>
                            </div>
                            <?php if(!empty($project['project_date'])): ?>
                            <div class="mt-3">
                                <strong class="text-white d-block mb-1">Date</strong>
                                <span class="text-secondary"><?= htmlspecialchars($project['project_date']) ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Live Link -->
                    <?php if(!empty($project['link'])): ?>
                    <div class="col-12">
                        <a href="<?= htmlspecialchars($project['link']) ?>" target="_blank" class="btn-primary-solid w-100 text-center d-block py-3">
                            Visit Live Project <i class="fas fa-external-link-alt ms-2"></i>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
    </div>
</section>
