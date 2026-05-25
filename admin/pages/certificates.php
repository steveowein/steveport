<?php
if (!isset($_SESSION['admin_logged_in'])) exit;

$status = '';

function uploadCertImage(array $file) {
    if ($file['error'] == 0) {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'cert_' . uniqid() . '.' . $ext;
        if (move_uploaded_file($file['tmp_name'], '../assets/images/' . $filename)) {
            return $filename;
        }
    }
    return '';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_cert'])) {
        $title = $conn->real_escape_string($_POST['title']);
        $issuer = $conn->real_escape_string($_POST['issuer']);
        $month = $conn->real_escape_string($_POST['month']);
        $year = $conn->real_escape_string($_POST['year']);
        $keywords = $conn->real_escape_string($_POST['keywords']);
        $description = $conn->real_escape_string($_POST['description']);
        $image = uploadCertImage($_FILES['image']);
        
        $conn->query("INSERT INTO certificates (title, issuer, month, year, image, keywords, description) 
                      VALUES ('$title', '$issuer', '$month', '$year', '$image', '$keywords', '$description')");
        $status = 'Certificate added successfully!';
    } elseif (isset($_POST['update_cert'])) {
        $id = (int)$_POST['id'];
        $title = $conn->real_escape_string($_POST['title']);
        $issuer = $conn->real_escape_string($_POST['issuer']);
        $month = $conn->real_escape_string($_POST['month']);
        $year = $conn->real_escape_string($_POST['year']);
        $keywords = $conn->real_escape_string($_POST['keywords']);
        $description = $conn->real_escape_string($_POST['description']);
        
        $image = uploadCertImage($_FILES['image']);
        if ($image) {
            $conn->query("UPDATE certificates SET title='$title', issuer='$issuer', month='$month', year='$year', image='$image', keywords='$keywords', description='$description' WHERE id=$id");
        } else {
            $conn->query("UPDATE certificates SET title='$title', issuer='$issuer', month='$month', year='$year', keywords='$keywords', description='$description' WHERE id=$id");
        }
        $status = 'Certificate updated successfully!';
    } elseif (isset($_POST['delete_cert'])) {
        $id = (int)$_POST['id'];
        $conn->query("DELETE FROM certificates WHERE id = $id");
        $status = 'Certificate deleted!';
    }
}

$certificates = $conn->query("SELECT * FROM certificates ORDER BY id DESC");
$months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
?>
<div class="admin-header">
    <h2 class="admin-title">Manage Certificates</h2>
</div>

<?php if($status): ?>
    <div class="alert alert-success bg-transparent border-success text-success"><?= $status ?></div>
<?php endif; ?>

<div class="card-admin mb-4">
    <h5 class="mb-4">Add Certificate</h5>
    <form method="POST" enctype="multipart/form-data">
        <div class="row g-3">
            <div class="col-12">
                <label class="text-white mb-2">Title *</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            
            <div class="col-md-6">
                <label class="text-white mb-2">Issued By</label>
                <input type="text" name="issuer" class="form-control">
            </div>
            
            <div class="col-md-3">
                <label class="text-white mb-2">Month</label>
                <select name="month" class="form-select text-white bg-dark">
                    <option value="">Select Month</option>
                    <?php foreach($months as $m): ?>
                        <option value="<?= $m ?>"><?= $m ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="col-md-3">
                <label class="text-white mb-2">Year</label>
                <input type="text" name="year" class="form-control" value="<?= date('Y') ?>">
            </div>
            
            <div class="col-md-6 mt-3">
                <label class="text-white mb-2">Certificate Image</label>
                <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png">
                <small class="text-secondary">JPG/PNG only, max 2MB</small>
            </div>
            
            <div class="col-md-6 mt-3">
                <label class="text-white mb-2">Keywords (comma-separated)</label>
                <input type="text" name="keywords" class="form-control" placeholder="e.g., .NET Framework, C# Programming, Enterprise Development">
                <small class="text-secondary">Separate keywords with commas</small>
            </div>
            
            <div class="col-12 mt-3">
                <label class="text-white mb-2">Description</label>
                <textarea name="description" class="form-control" rows="4"></textarea>
            </div>
            
            <div class="col-12 mt-4">
                <button type="submit" name="add_cert" class="btn btn-solid px-4">Add Certificate</button>
            </div>
        </div>
    </form>
</div>

<div class="card-admin">
    <h5 class="mb-4">Existing Certificates</h5>
    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title & Issuer</th>
                    <th>Date</th>
                    <th>Keywords</th>
                    <th width="150">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if($certificates && $certificates->num_rows > 0): ?>
                    <?php while($row = $certificates->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?php if($row['image']): ?>
                                    <img src="../assets/images/<?= $row['image'] ?>" width="60" style="border-radius:4px;">
                                <?php else: ?>
                                    <span class="text-muted">None</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($row['title']) ?></strong><br>
                                <small class="text-secondary"><?= htmlspecialchars($row['issuer']) ?></small>
                            </td>
                            <td><?= htmlspecialchars($row['month'] . ' ' . $row['year']) ?></td>
                            <td><small><?= htmlspecialchars($row['keywords']) ?></small></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editCertModal<?= $row['id'] ?>"><i class="fas fa-edit"></i></button>
                                <form method="POST" class="d-inline" onsubmit="return confirm('Delete this certificate?');">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" name="delete_cert" class="btn btn-sm btn-danger-outline"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Certificate Modal -->
                        <div class="modal fade" id="editCertModal<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content bg-dark text-white border-secondary">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="modal-header border-secondary">
                                            <h5 class="modal-title text-white">Edit Certificate</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label class="text-white mb-2">Title *</label>
                                                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($row['title']) ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="text-white mb-2">Issued By</label>
                                                    <input type="text" name="issuer" class="form-control" value="<?= htmlspecialchars($row['issuer']) ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="text-white mb-2">Month</label>
                                                    <select name="month" class="form-select text-white bg-dark">
                                                        <option value="">Select Month</option>
                                                        <?php foreach($months as $m): ?>
                                                            <option value="<?= $m ?>" <?= $row['month'] == $m ? 'selected' : '' ?>><?= $m ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="text-white mb-2">Year</label>
                                                    <input type="text" name="year" class="form-control" value="<?= htmlspecialchars($row['year']) ?>">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label class="text-white mb-2">Replace Certificate Image (Optional)</label>
                                                    <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png">
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <label class="text-white mb-2">Keywords (comma-separated)</label>
                                                    <input type="text" name="keywords" class="form-control" value="<?= htmlspecialchars($row['keywords']) ?>">
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <label class="text-white mb-2">Description</label>
                                                    <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($row['description']) ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-secondary">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" name="update_cert" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center text-muted py-3">No certificates added yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
