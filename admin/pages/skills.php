<?php
if (!isset($_SESSION['admin_logged_in'])) exit;

$status = '';

function uploadSkillIcon(array $file) {
    if ($file['error'] == 0) {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'skill_' . uniqid() . '.' . $ext;
        if (move_uploaded_file($file['tmp_name'], '../assets/images/' . $filename)) {
            return $filename;
        }
    }
    return '';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_skill'])) {
        $skill_name = $conn->real_escape_string($_POST['skill_name']);
        $level = (int)$_POST['level'];
        $icon_class = $conn->real_escape_string($_POST['icon_class']);
        $icon_image = uploadSkillIcon($_FILES['icon_image']);
        
        $conn->query("INSERT INTO skills (skill_name, level, icon_class, icon_image) VALUES ('$skill_name', $level, '$icon_class', '$icon_image')");
        $status = 'Skill added successfully!';
    } elseif (isset($_POST['update_skill'])) {
        $id = (int)$_POST['id'];
        $skill_name = $conn->real_escape_string($_POST['skill_name']);
        $level = (int)$_POST['level'];
        $icon_class = $conn->real_escape_string($_POST['icon_class']);
        
        $icon_image = uploadSkillIcon($_FILES['icon_image']);
        if ($icon_image) {
            $conn->query("UPDATE skills SET skill_name='$skill_name', level=$level, icon_class='$icon_class', icon_image='$icon_image' WHERE id=$id");
        } else {
            $conn->query("UPDATE skills SET skill_name='$skill_name', level=$level, icon_class='$icon_class' WHERE id=$id");
        }
        $status = 'Skill updated successfully!';
    } elseif (isset($_POST['delete_skill'])) {
        $id = (int)$_POST['id'];
        $conn->query("DELETE FROM skills WHERE id = $id");
        $status = 'Skill deleted!';
    }
}

$skills = $conn->query("SELECT * FROM skills ORDER BY id DESC");
?>
<div class="admin-header">
    <h2 class="admin-title">Manage Skills</h2>
</div>

<?php if($status): ?>
    <div class="alert alert-success bg-transparent border-success text-success"><?= $status ?></div>
<?php endif; ?>

<div class="card-admin mb-4">
    <h5 class="mb-4">Add Skill</h5>
    <form method="POST" enctype="multipart/form-data">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="text-white mb-2">Skill Name *</label>
                <input type="text" name="skill_name" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="text-white mb-2">Level (0-100) *</label>
                <input type="number" name="level" class="form-control" min="0" max="100" value="0" required>
            </div>
            <div class="col-md-4">
                <label class="text-white mb-2">Upload Icon Image (PNG/JPG/SVG)</label>
                <input type="file" name="icon_image" class="form-control" accept="image/*">
                <small class="text-secondary">Upload PNG, JPG, SVG, or GIF (max 2MB)</small>
            </div>
            
            <div class="col-12">
                <label class="text-white mb-2 mt-2">OR Enter Icon URL (Colored Logo)</label>
                <input type="text" name="icon_class" class="form-control" placeholder="e.g., https://cdn.jsdelivr.net/gh/devicons/devicon/icons/figma/figma-original.svg">
                <small class="text-secondary">For real colored logos, paste a Devicon SVG link here (e.g., https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg)</small>
            </div>
            
            <div class="col-12 mt-4">
                <button type="submit" name="add_skill" class="btn btn-solid px-4">Add Skill</button>
            </div>
        </div>
    </form>
</div>

<div class="card-admin">
    <h5 class="mb-4">Existing Skills</h5>
    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0">
            <thead>
                <tr>
                    <th>Icon</th>
                    <th>Skill Name</th>
                    <th>Level</th>
                    <th width="150">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if($skills && $skills->num_rows > 0): ?>
                    <?php while($row = $skills->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?php if($row['icon_image']): ?>
                                    <img src="../assets/images/<?= $row['icon_image'] ?>" width="25">
                                <?php elseif($row['icon_class']): ?>
                                    <?php if(strpos($row['icon_class'], 'http') !== false): ?>
                                        <img src="<?= htmlspecialchars($row['icon_class']) ?>" width="25">
                                    <?php else: ?>
                                        <i class="<?= htmlspecialchars($row['icon_class']) ?> fs-5"></i>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['skill_name']) ?></td>
                            <td>
                                <div class="progress bg-secondary" style="height: 10px; width: 100px;">
                                    <div class="progress-bar bg-light" style="width: <?= $row['level'] ?>%"></div>
                                </div>
                                <small><?= $row['level'] ?>%</small>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editSkillModal<?= $row['id'] ?>"><i class="fas fa-edit"></i></button>
                                <form method="POST" class="d-inline" onsubmit="return confirm('Delete this skill?');">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" name="delete_skill" class="btn btn-sm btn-danger-outline"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Skill Modal -->
                        <div class="modal fade" id="editSkillModal<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content bg-dark text-white border-secondary">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="modal-header border-secondary">
                                            <h5 class="modal-title text-white">Edit Skill</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="text-white mb-2">Skill Name *</label>
                                                    <input type="text" name="skill_name" class="form-control" value="<?= htmlspecialchars($row['skill_name']) ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="text-white mb-2">Level (0-100) *</label>
                                                    <input type="number" name="level" class="form-control" min="0" max="100" value="<?= $row['level'] ?>" required>
                                                </div>
                                                <div class="col-12">
                                                    <label class="text-white mb-2 mt-2">Replace Icon Image (Optional)</label>
                                                    <input type="file" name="icon_image" class="form-control" accept="image/*">
                                                </div>
                                                <div class="col-12">
                                                    <label class="text-white mb-2 mt-2">OR Enter Icon URL (Colored Logo)</label>
                                                    <input type="text" name="icon_class" class="form-control" value="<?= htmlspecialchars($row['icon_class']) ?>" placeholder="e.g. https://cdn.jsdelivr.net/...">
                                                    <small class="text-secondary">Paste a Devicon SVG link here for real colored logos</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-secondary">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" name="update_skill" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="text-center text-muted py-3">No skills added yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
