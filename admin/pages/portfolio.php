<?php
if (!isset($_SESSION['admin_logged_in'])) exit;

$status = '';

function uploadPortfolioImage(array $file) {
    if ($file['error'] == 0) {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'port_' . uniqid() . '.' . $ext;
        if (move_uploaded_file($file['tmp_name'], '../assets/images/' . $filename)) {
            return $filename;
        }
    }
    return '';
}

function uploadMultipleImages(array $files) {
    $uploaded = [];
    if (!empty($files['name'][0])) {
        foreach ($files['name'] as $key => $name) {
            if ($files['error'][$key] == 0) {
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $filename = 'port_add_' . uniqid() . '_' . $key . '.' . $ext;
                if (move_uploaded_file($files['tmp_name'][$key], '../assets/images/' . $filename)) {
                    $uploaded[] = $filename;
                }
            }
        }
    }
    return implode(',', $uploaded);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_project'])) {
        $title = $conn->real_escape_string($_POST['title']);
        $description = $conn->real_escape_string($_POST['description']);
        $tech_stack = $conn->real_escape_string($_POST['tech_stack']);
        $link = $conn->real_escape_string($_POST['link']);
        $client = $conn->real_escape_string($_POST['client']);
        $project_date = $conn->real_escape_string($_POST['project_date']);
        
        $image = uploadPortfolioImage($_FILES['image']);
        
        $conn->query("INSERT INTO portfolio (title, description, image, link, tech_stack, client, project_date) 
                      VALUES ('$title', '$description', '$image', '$link', '$tech_stack', '$client', '$project_date')");
        $status = 'Project added successfully!';
    } elseif (isset($_POST['update_project'])) {
        $id = (int)$_POST['id'];
        $title = $conn->real_escape_string($_POST['title']);
        $description = $conn->real_escape_string($_POST['description']);
        $link = $conn->real_escape_string($_POST['link']);
        $tech_stack = $conn->real_escape_string($_POST['tech_stack']);
        $client = $conn->real_escape_string($_POST['client']);
        $project_date = $conn->real_escape_string($_POST['project_date']);
        
        $image = uploadPortfolioImage($_FILES['image']);
        if ($image) {
            $conn->query("UPDATE portfolio SET title='$title', description='$description', image='$image', link='$link', tech_stack='$tech_stack', client='$client', project_date='$project_date' WHERE id=$id");
        } else {
            $conn->query("UPDATE portfolio SET title='$title', description='$description', link='$link', tech_stack='$tech_stack', client='$client', project_date='$project_date' WHERE id=$id");
        }
        $status = 'Project updated successfully!';
    } elseif (isset($_POST['delete_project'])) {
        $id = (int)$_POST['id'];
        $conn->query("DELETE FROM portfolio WHERE id = $id");
        $status = 'Project deleted!';
    }
}

$portfolio = $conn->query("SELECT * FROM portfolio ORDER BY id DESC");
?>
<div class="admin-header">
    <h2 class="admin-title">Manage Portfolio</h2>
</div>

<?php if($status): ?>
    <div class="alert alert-success bg-transparent border-success text-success"><?= $status ?></div>
<?php endif; ?>

<div class="card-admin mb-4">
    <h5 class="mb-4">Add Project</h5>
    <form method="POST" enctype="multipart/form-data">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="text-white mb-2">Project Title *</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="text-white mb-2">Project URL / Link</label>
                <input type="text" name="link" class="form-control" placeholder="https://...">
            </div>
            
            <div class="col-md-6 mt-3">
                <label class="text-white mb-2">Client</label>
                <input type="text" name="client" class="form-control" placeholder="e.g., DNSC">
            </div>
            <div class="col-md-6 mt-3">
                <label class="text-white mb-2">Project Date</label>
                <input type="text" name="project_date" class="form-control" placeholder="e.g., May 2024">
            </div>
            
            <div class="col-12 mt-3">
                <label class="text-white mb-2">Tech Stack (comma-separated)</label>
                <input type="text" name="tech_stack" class="form-control" placeholder="e.g., PHP, MySQL, Bootstrap">
            </div>

            <div class="col-12 mt-3">
                <label class="text-white mb-2">Project Image (Primary)</label>
                <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png">
                <small class="text-secondary">Main thumbnail for the project</small>
            </div>

            <div class="col-12 mt-3">
                <label class="text-white mb-2">Description</label>
                <textarea name="description" class="form-control" rows="4"></textarea>
            </div>
            
            <div class="col-12 mt-4">
                <button type="submit" name="add_project" class="btn btn-solid px-4">Add Project</button>
            </div>
        </div>
    </form>
</div>

<div class="card-admin">
    <h5 class="mb-4">Existing Projects</h5>
    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Details</th>
                    <th>Tech Stack</th>
                    <th width="150">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if($portfolio && $portfolio->num_rows > 0): ?>
                    <?php while($row = $portfolio->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?php if($row['image']): ?>
                                    <img src="../assets/images/<?= $row['image'] ?>" width="80" style="border-radius:4px; object-fit:cover;">
                                <?php else: ?>
                                    <span class="text-muted">No Image</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($row['title']) ?></strong><br>
                                <small class="text-secondary">Client: <?= htmlspecialchars($row['client']) ?> | <?= htmlspecialchars($row['project_date']) ?></small><br>
                                <?php if($row['link']): ?>
                                    <a href="<?= htmlspecialchars($row['link']) ?>" target="_blank" class="text-info" style="font-size:0.8rem;">View Link</a>
                                <?php endif; ?>
                            </td>
                            <td><small><?= htmlspecialchars($row['tech_stack']) ?></small></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editProjectModal<?= $row['id'] ?>"><i class="fas fa-edit"></i></button>
                                <form method="POST" class="d-inline" onsubmit="return confirm('Delete this project?');">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" name="delete_project" class="btn btn-sm btn-danger-outline"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Project Modal -->
                        <div class="modal fade" id="editProjectModal<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content bg-dark text-white border-secondary">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="modal-header border-secondary">
                                            <h5 class="modal-title text-white">Edit Project</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="text-white mb-2">Project Title *</label>
                                                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($row['title']) ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="text-white mb-2">Project URL / Link</label>
                                                    <input type="text" name="link" class="form-control" value="<?= htmlspecialchars($row['link']) ?>">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label class="text-white mb-2">Client</label>
                                                    <input type="text" name="client" class="form-control" value="<?= htmlspecialchars($row['client']) ?>">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label class="text-white mb-2">Project Date</label>
                                                    <input type="text" name="project_date" class="form-control" value="<?= htmlspecialchars($row['project_date']) ?>">
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <label class="text-white mb-2">Tech Stack (comma-separated)</label>
                                                    <input type="text" name="tech_stack" class="form-control" value="<?= htmlspecialchars($row['tech_stack']) ?>">
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <label class="text-white mb-2">Replace Project Image (Optional)</label>
                                                    <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png">
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <label class="text-white mb-2">Description</label>
                                                    <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($row['description']) ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-secondary">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" name="update_project" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="text-center text-muted py-3">No projects added yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
