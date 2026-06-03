<?php
if (!isset($_SESSION['admin_logged_in'])) exit;

$status = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $hero_title = $conn->real_escape_string($_POST['hero_title']);
    $hero_tagline = $conn->real_escape_string($_POST['hero_tagline']);
    $career_objective = $conn->real_escape_string($_POST['career_objective']);
    
    $email = $conn->real_escape_string($_POST['email']);
    $contact_number = $conn->real_escape_string($_POST['contact_number']);
    $linkedin = $conn->real_escape_string($_POST['linkedin']);
    $github = $conn->real_escape_string($_POST['github']);
    
    $query = "UPDATE personal_info SET 
              hero_title = '$hero_title',
              hero_tagline = '$hero_tagline',
              career_objective = '$career_objective',
              email = '$email', 
              contact_number = '$contact_number', 
              linkedin = '$linkedin',
              github = '$github'";
              
    if ($conn->query($query)) {
        $status = 'Profile settings updated successfully!';
    } else {
        $status = 'Error updating profile.';
    }
}

$info_result = $conn->query("SELECT * FROM personal_info LIMIT 1");
$info = $info_result->fetch_assoc();
?>
<div class="admin-header">
    <h2 class="admin-title">Profile & Settings</h2>
    <div class="text-muted">Welcome back, <?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></div>
</div>

<?php if($status): ?>
    <div class="alert alert-success bg-transparent border-success text-success"><?= $status ?></div>
<?php endif; ?>

<form method="POST">
    <div class="card-admin mb-4">
        <h5 class="mb-4">Manage Public Content</h5>
        
        <div class="row g-4">
            <div class="col-md-6">
                <label class="text-white mb-2">Hero Title</label>
                <input type="text" name="hero_title" class="form-control" value="<?= htmlspecialchars($info['hero_title'] ?? '') ?>" placeholder="Virtual Assistant">
            </div>
            
            <div class="col-md-6">
                <label class="text-white mb-2">Hero Tagline</label>
                <input type="text" name="hero_tagline" class="form-control" value="<?= htmlspecialchars($info['hero_tagline'] ?? '') ?>" placeholder="Motivated Virtual Assistant delivering reliable support...">
            </div>
            
            <div class="col-12">
                <label class="text-white mb-2">About Me Text</label>
                <textarea name="career_objective" class="form-control" rows="5"><?= htmlspecialchars($info['career_objective']) ?></textarea>
            </div>
        </div>
    </div>
    
    <div class="card-admin mb-4">
        <h5 class="mb-4">Contact Information</h5>
        
        <div class="row g-4">
            <div class="col-md-3">
                <label class="text-white mb-2">Email Address</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($info['email']) ?>">
            </div>
            <div class="col-md-3">
                <label class="text-white mb-2">Phone Number</label>
                <input type="text" name="contact_number" class="form-control" value="<?= htmlspecialchars($info['contact_number']) ?>">
            </div>
            <div class="col-md-3">
                <label class="text-white mb-2">LinkedIn URL</label>
                <input type="url" name="linkedin" class="form-control" value="<?= htmlspecialchars($info['linkedin']) ?>">
            </div>
            <div class="col-md-3">
                <label class="text-white mb-2">GitHub URL</label>
                <input type="url" name="github" class="form-control" value="<?= htmlspecialchars($info['github'] ?? '') ?>">
            </div>
        </div>
    </div>
    
    <div class="text-end">
        <button type="submit" name="update_profile" class="btn btn-solid px-5 py-3"><i class="fas fa-save me-2"></i> Save Changes</button>
    </div>
</form>
