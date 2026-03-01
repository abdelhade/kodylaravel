<?php 
// Start output buffering to prevent headers already sent error
ob_start();

// Include necessary files
include('includes/connect.php'); // ملف الاتصال بقاعدة البيانات

// Process form submissions before any HTML output

// إضافة عميل محتمل جديد
if (isset($_POST['add_lead'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $company = mysqli_real_escape_string($conn, $_POST['company']);
    $source_id = (int)$_POST['source_id'];
    $status_id = (int)$_POST['status_id'];
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);
    
    $sql = "INSERT INTO crm_leads (name, email, phone, company, source_id, status_id, notes, created_at, updated_at)
            VALUES ('$name', '$email', '$phone', '$company', $source_id, $status_id, '$notes', NOW(), NOW())";
    if(mysqli_query($conn, $sql)) {
        header("Location: crud_crm_leads.php");
        exit();
    }
}

// تعديل عميل محتمل
if (isset($_POST['edit_lead'])) {
    $id = (int)$_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $company = mysqli_real_escape_string($conn, $_POST['company']);
    $source_id = (int)$_POST['source_id'];
    $status_id = (int)$_POST['status_id'];
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);

    $sql = "UPDATE crm_leads SET 
                name='$name', 
                email='$email',
                phone='$phone',
                company='$company',
                source_id=$source_id,
                status_id=$status_id,
                notes='$notes',
                updated_at=NOW()
            WHERE id=$id";
    if(mysqli_query($conn, $sql)) {
        header("Location: crud_crm_leads.php");
        exit();
    }
}

// حذف عميل محتمل
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if($id > 0) {
        mysqli_query($conn, "DELETE FROM crm_leads WHERE id=$id");
        header("Location: crud_crm_leads.php");
        exit();
    }
}

// Now include the header and other UI components
include('includes/header.php');
include('includes/navbar.php');
include('includes/sidebar.php');

// Get sources and statuses for dropdowns
$sources = mysqli_query($conn, "SELECT * FROM crm_lead_sources ORDER BY name");
$statuses = mysqli_query($conn, "SELECT * FROM crm_lead_statuses ORDER BY `order`");
?>

<style>
    body {
      background: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .content-wrapper {
      margin-left: 0;
      margin-right: 250px;
      padding: 20px;
      transition: all 0.3s;
    }
    .sidebar-collapsed .content-wrapper {
      margin-left: 60px;
    }
    .table-responsive {
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
      padding: 1rem;
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }
    .table {
      margin-bottom: 0;
      min-width: 800px;
    }
    .table th {
      background-color: #f8f9fa;
      white-space: nowrap;
    }
    .action-buttons .btn {
      margin: 0 2px;
    }
    @media (max-width: 991.98px) {
      .content-wrapper {
        margin-left: 0 !important;
        margin-right: 0 !important;
      }
    }
    @media (max-width: 768px) {
      .content-wrapper {
        padding: 10px;
      }
      .d-flex.justify-content-between {
        flex-direction: column;
        gap: 10px;
      }
      .d-flex.justify-content-between h3 {
        font-size: 1.3rem;
      }
      .d-flex.justify-content-between .btn {
        width: 100%;
      }
      .table {
        font-size: 0.85rem;
      }
      .table th,
      .table td {
        padding: 0.5rem 0.3rem;
      }
      .btn-sm {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
      }
    }
</style>

<div class="content-wrapper">
  <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3 mb-md-4">
      <h3 class="mb-0">👥 إدارة العملاء المحتملون</h3>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="fas fa-plus"></i> <span class="d-none d-sm-inline">إضافة عميل محتمل</span><span class="d-inline d-sm-none">إضافة</span>
      </button>
    </div>

    <div class="table-responsive">
      <table class="table table-hover text-center">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>الاسم</th>
            <th>البريد الإلكتروني</th>
            <th>الهاتف</th>
            <th>الشركة</th>
            <th>المصدر</th>
            <th>الحالة</th>
            <th>تاريخ الإضافة</th>
            <th>العمليات</th>
          </tr>
        </thead>
        <tbody>
        <?php
          $result = mysqli_query($conn, "
            SELECT l.*, s.name as source_name, st.name as status_name 
            FROM crm_leads l
            LEFT JOIN crm_lead_sources s ON l.source_id = s.id
            LEFT JOIN crm_lead_statuses st ON l.status_id = st.id
            ORDER BY l.created_at DESC
          ");
          while ($row = mysqli_fetch_assoc($result)):
        ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= htmlspecialchars($row['company']) ?></td>
            <td><?= htmlspecialchars($row['source_name']) ?></td>
            <td><?= htmlspecialchars($row['status_name']) ?></td>
            <td><?= date('Y-m-d', strtotime($row['created_at'])) ?></td>
            <td class="text-nowrap">
              <button class="btn btn-sm btn-outline-secondary" 
                      data-bs-toggle="modal" 
                      data-bs-target="#editModal<?= $row['id'] ?>"><i class="fas fa-edit"></i></button>
              <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger"
                 onclick="return confirm('هل تريد حذف <?= htmlspecialchars($row['name']) ?>؟')"><i class="fas fa-trash"></i></a>
            </td>
          </tr>

          <!-- Modal تعديل -->
          <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <form method="POST">
                  <div class="modal-header">
                    <h5 class="modal-title">تعديل عميل محتمل</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <label class="form-label">الاسم *</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" class="form-control" required>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" class="form-control">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <label class="form-label">الهاتف</label>
                        <input type="text" name="phone" value="<?= htmlspecialchars($row['phone']) ?>" class="form-control">
                      </div>
                      <div class="col-md-6 mb-3">
                        <label class="form-label">الشركة</label>
                        <input type="text" name="company" value="<?= htmlspecialchars($row['company']) ?>" class="form-control">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <label class="form-label">المصدر *</label>
                        <select name="source_id" class="form-select" required>
                          <?php 
                          mysqli_data_seek($sources, 0);
                          while($source = mysqli_fetch_assoc($sources)): 
                          ?>
                            <option value="<?= $source['id'] ?>" <?= $row['source_id'] == $source['id'] ? 'selected' : '' ?>>
                              <?= htmlspecialchars($source['name']) ?>
                            </option>
                          <?php endwhile; ?>
                        </select>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label class="form-label">الحالة *</label>
                        <select name="status_id" class="form-select" required>
                          <?php 
                          mysqli_data_seek($statuses, 0);
                          while($status = mysqli_fetch_assoc($statuses)): 
                          ?>
                            <option value="<?= $status['id'] ?>" <?= $row['status_id'] == $status['id'] ? 'selected' : '' ?>>
                              <?= htmlspecialchars($status['name']) ?>
                            </option>
                          <?php endwhile; ?>
                        </select>
                      </div>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">ملاحظات</label>
                      <textarea name="notes" class="form-control" rows="3"><?= htmlspecialchars($row['notes']) ?></textarea>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="edit_lead" class="btn btn-primary">حفظ التعديلات</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal إضافة -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header">
          <h5 class="modal-title">إضافة عميل محتمل جديد</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">الاسم *</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">البريد الإلكتروني</label>
              <input type="email" name="email" class="form-control">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">الهاتف</label>
              <input type="text" name="phone" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">الشركة</label>
              <input type="text" name="company" class="form-control">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">المصدر *</label>
              <select name="source_id" class="form-select" required>
                <option value="">اختر المصدر</option>
                <?php 
                mysqli_data_seek($sources, 0);
                while($source = mysqli_fetch_assoc($sources)): 
                ?>
                  <option value="<?= $source['id'] ?>"><?= htmlspecialchars($source['name']) ?></option>
                <?php endwhile; ?>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">الحالة *</label>
              <select name="status_id" class="form-select" required>
                <option value="">اختر الحالة</option>
                <?php 
                mysqli_data_seek($statuses, 0);
                while($status = mysqli_fetch_assoc($statuses)): 
                ?>
                  <option value="<?= $status['id'] ?>"><?= htmlspecialchars($status['name']) ?></option>
                <?php endwhile; ?>
              </select>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">ملاحظات</label>
            <textarea name="notes" class="form-control" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="add_lead" class="btn btn-success">إضافة</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php 
// End output buffering and flush the output
ob_end_flush();
include('includes/footer.php'); 
?>
