<?php
if (!isset($_SESSION['admin_logged_in'])) exit;

$status = '';

function uploadServiceIcon(array $file) {
    if ($file['error'] == 0) {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'service_' . uniqid() . '.' . $ext;
        if (move_uploaded_file($file['tmp_name'], '../assets/images/' . $filename)) {
            return $filename;
        }
    }
    return '';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_service'])) {
        $title = $conn->real_escape_string($_POST['title']);
        $icon = $conn->real_escape_string($_POST['icon']);
        $desc = $conn->real_escape_string($_POST['description']);
        
        $uploaded_icon = uploadServiceIcon($_FILES['icon_image']);
        // If uploaded, we store it in the icon field or we need a new field. The original DB had 'icon'.
        // Let's store the filename in 'icon' if uploaded, otherwise use the text icon.
        $final_icon = $uploaded_icon ? $uploaded_icon : $icon;
        
        $conn->query("INSERT INTO services (title, icon, description) VALUES ('$title', '$final_icon', '$desc')");
        $status = 'Service added successfully!';
    } elseif (isset($_POST['update_service'])) {
        $id = (int)$_POST['id'];
        $title = $conn->real_escape_string($_POST['title']);
        $icon = $conn->real_escape_string($_POST['icon']);
        $desc = $conn->real_escape_string($_POST['description']);
        
        $uploaded_icon = uploadServiceIcon($_FILES['icon_image']);
        if ($uploaded_icon) {
            $conn->query("UPDATE services SET title='$title', icon='$uploaded_icon', description='$desc' WHERE id=$id");
        } else {
            $conn->query("UPDATE services SET title='$title', icon='$icon', description='$desc' WHERE id=$id");
        }
        $status = 'Service updated successfully!';
    } elseif (isset($_POST['delete_service'])) {
        $id = (int)$_POST['id'];
        $conn->query("DELETE FROM services WHERE id = $id");
        $status = 'Service deleted!';
    }
}

$services = $conn->query("SELECT * FROM services ORDER BY id DESC");
?>
<div class="admin-header">
    <h2 class="admin-title">Manage Services</h2>
</div>

<?php if($status): ?>
    <div class="alert alert-success bg-transparent border-success text-success"><?= $status ?></div>
<?php endif; ?>

<div class="card-admin mb-4">
    <h5 class="mb-4">Add Service</h5>
    <form method="POST" enctype="multipart/form-data">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="text-white mb-2">Service Name *</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="text-white mb-2">Icon URL (Colored Logo)</label>
                <input type="text" name="icon" class="form-control" placeholder="e.g., https://cdn.jsdelivr.net/gh/devicons/devicon/icons/figma/figma-original.svg">
                <small class="text-secondary">Paste a Devicon SVG link here for real colored logos</small>
            </div>
            <div class="col-12">
                <label class="text-white mb-2 mt-3">Or Upload Icon Image</label>
                <input type="file" name="icon_image" class="form-control" accept="image/*">
                <small class="text-secondary">PNG, JPG, SVG, or GIF (max 2MB)</small>
            </div>
            <div class="col-12">
                <label class="text-white mb-2 mt-3">Description *</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>
            <div class="col-12 mt-4">
                <button type="submit" name="add_service" class="btn btn-solid px-4">Add Service</button>
            </div>
        </div>
    </form>
</div>

<div class="card-admin">
    <h5 class="mb-4">Existing Services</h5>
    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0">
            <thead>
                <tr>
                    <th>Icon</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th width="150">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if($services && $services->num_rows > 0): ?>
                    <?php while($row = $services->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?php if(strpos($row['icon'], 'fas ') !== false || strpos($row['icon'], 'fab ') !== false): ?>
                                    <i class="<?= htmlspecialchars($row['icon']) ?> fs-4"></i>
                                <?php else: ?>
                                    <img src="../assets/images/<?= htmlspecialchars($row['icon']) ?>" width="30" onerror="this.style.display='none'">
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td><small><?= htmlspecialchars(substr($row['description'], 0, 50)) ?>...</small></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>"><i class="fas fa-edit"></i></button>
                                <form method="POST" class="d-inline" onsubmit="return confirm('Delete this service?');">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" name="delete_service" class="btn btn-sm btn-danger-outline"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content bg-dark text-white border-secondary">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="modal-header border-secondary">
                                            <h5 class="modal-title text-white">Edit Service</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <div class="mb-3">
                                                <label class="text-white mb-2">Service Name *</label>
                                                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($row['title']) ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="text-white mb-2">Icon URL (Colored Logo)</label>
                                                <input type="text" name="icon" class="form-control" value="<?= htmlspecialchars($row['icon']) ?>" placeholder="e.g. https://cdn.jsdelivr.net/.../figma-original.svg">
                                                <small class="text-secondary">Paste a Devicon SVG link here</small>
                                            </div>
                                            <div class="mb-3">
                                                <label class="text-white mb-2">Replace Icon Image (Optional)</label>
                                                <input type="file" name="icon_image" class="form-control" accept="image/*">
                                            </div>
                                            <div class="mb-3">
                                                <label class="text-white mb-2">Description *</label>
                                                <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($row['description']) ?></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-secondary">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" name="update_service" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="text-center text-muted py-3">No services added yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
