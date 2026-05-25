<?php
if (!isset($_SESSION['admin_logged_in'])) exit;

$status = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_msg'])) {
        $id = (int)$_POST['id'];
        $conn->query("DELETE FROM messages WHERE id = $id");
        $status = 'Message deleted.';
    } elseif (isset($_POST['mark_read'])) {
        $id = (int)$_POST['id'];
        $conn->query("UPDATE messages SET is_read = 1 WHERE id = $id");
    }
}

$messages = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");
?>
<div class="admin-header">
    <h2 class="admin-title">Messages</h2>
</div>

<?php if($status): ?>
    <div class="alert alert-success bg-transparent border-success text-success"><?= $status ?></div>
<?php endif; ?>

<div class="card-admin">
    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if($messages && $messages->num_rows > 0): ?>
                    <?php while($row = $messages->fetch_assoc()): ?>
                        <tr style="<?= $row['is_read'] ? 'opacity: 0.7;' : 'font-weight: bold;' ?>">
                            <td>
                                <?php if($row['is_read']): ?>
                                    <span class="text-muted"><i class="fas fa-check-double"></i> Read</span>
                                <?php else: ?>
                                    <span class="text-primary"><i class="fas fa-envelope"></i> New</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><a href="mailto:<?= htmlspecialchars($row['email']) ?>" class="text-info"><?= htmlspecialchars($row['email']) ?></a></td>
                            <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                            <td><small><?= date('M d, Y h:i A', strtotime($row['created_at'])) ?></small></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <?php if(!$row['is_read']): ?>
                                    <form method="POST">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <button type="submit" name="mark_read" class="btn btn-sm btn-solid" title="Mark as Read"><i class="fas fa-check"></i></button>
                                    </form>
                                    <?php endif; ?>
                                    <form method="POST" onsubmit="return confirm('Delete message?');">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <button type="submit" name="delete_msg" class="btn btn-sm btn-danger-outline"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center text-muted py-5"><i class="fas fa-inbox fs-1 mb-3 d-block"></i> No messages found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
