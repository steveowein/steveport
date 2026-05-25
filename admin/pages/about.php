<?php
if (!isset($_SESSION['admin_logged_in'])) exit;

$status = '';

// Handle Education Form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_education'])) {
        $degree = $conn->real_escape_string($_POST['degree']);
        $institution = $conn->real_escape_string($_POST['institution']);
        $year = $conn->real_escape_string($_POST['year']);
        $conn->query("INSERT INTO education (degree, institution, year) VALUES ('$degree', '$institution', '$year')");
        $status = 'Education added successfully!';
    } elseif (isset($_POST['update_education'])) {
        $id = (int)$_POST['id'];
        $degree = $conn->real_escape_string($_POST['degree']);
        $institution = $conn->real_escape_string($_POST['institution']);
        $year = $conn->real_escape_string($_POST['year']);
        $conn->query("UPDATE education SET degree='$degree', institution='$institution', year='$year' WHERE id=$id");
        $status = 'Education updated successfully!';
    } elseif (isset($_POST['delete_education'])) {
        $id = (int)$_POST['id'];
        $conn->query("DELETE FROM education WHERE id = $id");
        $status = 'Education deleted!';
    }

    // Handle Experience Form
    if (isset($_POST['add_experience'])) {
        $role = $conn->real_escape_string($_POST['role']);
        $date = $conn->real_escape_string($_POST['date']);
        $description = $conn->real_escape_string($_POST['description']);
        $conn->query("INSERT INTO experience (role, date, description) VALUES ('$role', '$date', '$description')");
        $status = 'Experience added successfully!';
    } elseif (isset($_POST['update_experience'])) {
        $id = (int)$_POST['id'];
        $role = $conn->real_escape_string($_POST['role']);
        $date = $conn->real_escape_string($_POST['date']);
        $description = $conn->real_escape_string($_POST['description']);
        $conn->query("UPDATE experience SET role='$role', date='$date', description='$description' WHERE id=$id");
        $status = 'Experience updated successfully!';
    } elseif (isset($_POST['delete_experience'])) {
        $id = (int)$_POST['id'];
        $conn->query("DELETE FROM experience WHERE id = $id");
        $status = 'Experience deleted!';
    }
}

$education_list = $conn->query("SELECT * FROM education ORDER BY id DESC");
$experience_list = $conn->query("SELECT * FROM experience ORDER BY id DESC");
?>
<div class="admin-header">
    <h2 class="admin-title">Manage About Page</h2>
</div>

<?php if($status): ?>
    <div class="alert alert-success bg-transparent border-success text-success"><?= $status ?></div>
<?php endif; ?>

<div class="row">
    <!-- EDUCATION SECTION -->
    <div class="col-lg-6 mb-5">
        <div class="card-admin mb-4">
            <h5 class="mb-4">Add Education</h5>
            <form method="POST">
                <div class="mb-3">
                    <label class="text-white mb-2">Degree / Course *</label>
                    <input type="text" name="degree" class="form-control" placeholder="e.g. BS Information Systems" required>
                </div>
                <div class="mb-3">
                    <label class="text-white mb-2">Institution / School *</label>
                    <input type="text" name="institution" class="form-control" placeholder="e.g. Davao del Norte State College" required>
                </div>
                <div class="mb-4">
                    <label class="text-white mb-2">Year *</label>
                    <input type="text" name="year" class="form-control" placeholder="e.g. 2020 - 2024" required>
                </div>
                <button type="submit" name="add_education" class="btn btn-solid w-100">Add Education</button>
            </form>
        </div>

        <div class="card-admin">
            <h5 class="mb-4">Existing Education</h5>
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Degree / Institution</th>
                            <th width="120">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($education_list && $education_list->num_rows > 0): ?>
                            <?php while($row = $education_list->fetch_assoc()): ?>
                                <tr>
                                    <td><small><?= htmlspecialchars($row['year']) ?></small></td>
                                    <td>
                                        <strong><?= htmlspecialchars($row['degree']) ?></strong><br>
                                        <small class="text-secondary"><?= htmlspecialchars($row['institution']) ?></small>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editEduModal<?= $row['id'] ?>"><i class="fas fa-edit"></i></button>
                                        <form method="POST" class="d-inline" onsubmit="return confirm('Delete this education entry?');">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <button type="submit" name="delete_education" class="btn btn-sm btn-danger-outline"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Education Modal -->
                                <div class="modal fade" id="editEduModal<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content bg-dark text-white border-secondary">
                                            <form method="POST">
                                                <div class="modal-header border-secondary">
                                                    <h5 class="modal-title text-white">Edit Education</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                    <div class="mb-3">
                                                        <label class="text-white mb-2">Degree / Course *</label>
                                                        <input type="text" name="degree" class="form-control" value="<?= htmlspecialchars($row['degree']) ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="text-white mb-2">Institution / School *</label>
                                                        <input type="text" name="institution" class="form-control" value="<?= htmlspecialchars($row['institution']) ?>" required>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="text-white mb-2">Year *</label>
                                                        <input type="text" name="year" class="form-control" value="<?= htmlspecialchars($row['year']) ?>" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-secondary">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" name="update_education" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="3" class="text-center text-muted">No education added.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- EXPERIENCE SECTION -->
    <div class="col-lg-6">
        <div class="card-admin mb-4">
            <h5 class="mb-4">Add Experience</h5>
            <form method="POST">
                <div class="mb-3">
                    <label class="text-white mb-2">Role / Job Title *</label>
                    <input type="text" name="role" class="form-control" placeholder="e.g. Virtual Assistant" required>
                </div>
                <div class="mb-3">
                    <label class="text-white mb-2">Date / Duration *</label>
                    <input type="text" name="date" class="form-control" placeholder="e.g. June 2023 - Present" required>
                </div>
                <div class="mb-4">
                    <label class="text-white mb-2">Description / Tasks *</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Describe your tasks..." required></textarea>
                </div>
                <button type="submit" name="add_experience" class="btn btn-solid w-100">Add Experience</button>
            </form>
        </div>

        <div class="card-admin">
            <h5 class="mb-4">Existing Experience</h5>
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Role & Description</th>
                            <th width="120">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($experience_list && $experience_list->num_rows > 0): ?>
                            <?php while($row = $experience_list->fetch_assoc()): ?>
                                <tr>
                                    <td style="width: 100px;"><small><?= htmlspecialchars($row['date']) ?></small></td>
                                    <td>
                                        <strong><?= htmlspecialchars($row['role']) ?></strong><br>
                                        <small class="text-secondary"><?= htmlspecialchars(substr($row['description'], 0, 50)) ?>...</small>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editExpModal<?= $row['id'] ?>"><i class="fas fa-edit"></i></button>
                                        <form method="POST" class="d-inline" onsubmit="return confirm('Delete this experience entry?');">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <button type="submit" name="delete_experience" class="btn btn-sm btn-danger-outline"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Experience Modal -->
                                <div class="modal fade" id="editExpModal<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content bg-dark text-white border-secondary">
                                            <form method="POST">
                                                <div class="modal-header border-secondary">
                                                    <h5 class="modal-title text-white">Edit Experience</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                    <div class="mb-3">
                                                        <label class="text-white mb-2">Role / Job Title *</label>
                                                        <input type="text" name="role" class="form-control" value="<?= htmlspecialchars($row['role']) ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="text-white mb-2">Date / Duration *</label>
                                                        <input type="text" name="date" class="form-control" value="<?= htmlspecialchars($row['date']) ?>" required>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="text-white mb-2">Description / Tasks *</label>
                                                        <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($row['description']) ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-secondary">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" name="update_experience" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="3" class="text-center text-muted">No experience added.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
