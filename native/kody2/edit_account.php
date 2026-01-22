<?php include('includes/header.php') ?>
<?php include('includes/navbar.php') ?>
<?php include('includes/sidebar.php') ?>

<?php 
// Check if editing (id parameter exists)
$edit_mode = isset($_GET['id']) && !empty($_GET['id']);
$account = null;
$parent = 0;
$last_id = "";

if ($edit_mode) {
    // Fetch account data for editing
    $account_id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql_account = "SELECT * FROM acc_head WHERE id = '$account_id'";
    $account = $conn->query($sql_account)->fetch_assoc();
    
    if ($account) {
        $parent = substr($account['code'], 0, -3);
        $last_id = $account['code'];
        
        // Get parent accounts for dropdown - show all basic accounts when editing to allow changing parent
        $sqlasc = "SELECT * FROM acc_head where is_basic = 1 order by code";
        $resacs = $conn->query($sqlasc);
    } else {
        // Account not found, redirect or show error
        header("Location: accounts.php?error=not_found");
        exit;
    }
} else {
    // Add mode - use existing logic
    if (isset($_GET['parent_id'])) {    
        $parent = $_GET['parent_id'];
        $sqllst = "SELECT * FROM acc_head where code like '$parent%' AND is_basic = 0 order by id desc";
        $rowlast = $conn->query($sqllst)->fetch_assoc();
        if ($rowlast != null) {
            $acccode = explode($parent, $rowlast['code']);
            $lstacc = $acccode[1];
            $lstacc_int = (int)$lstacc;
            $lstacc_int++;
            $lstacc_new = sprintf("%03d", $lstacc_int);
            $last_id = $parent.$lstacc_new;
        } else {
            $last_id = $parent."001";
        }
    } else {
        $parent = 0;
        $last_id = "";
    }
    
    if (isset($_GET['parent_id'])) {
        $sqlasc = "SELECT * FROM acc_head where is_basic = 1 AND code like '$parent%' order by code";
        $resacs = $conn->query($sqlasc);
    } else {
        $sqlasc = "SELECT * FROM acc_head where is_basic = 1 order by code";
        $resacs = $conn->query($sqlasc);
    }
}
?>
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">

<?php 
// Permission check - use edit permissions if editing, add permissions if adding
$has_permission = false;
if ($edit_mode) {
    // Edit permissions (assuming similar structure to add permissions)
    $has_permission = (($parent == '122' && isset($role['edit_clients']) && $role['edit_clients'] == 1) ||
    ($parent == '211' && isset($role['edit_suppliers']) && $role['edit_suppliers'] == 1) ||
    ($parent == '121' && isset($role['edit_funds']) && $role['edit_funds'] == 1) ||
    ($parent == '124' && isset($role['edit_banks']) && $role['edit_banks'] == 1) ||
    ($parent == '44' && isset($role['edit_expenses']) && $role['edit_expenses'] == 1) ||
    ($parent == '32' && isset($role['edit_revenuses']) && $role['edit_revenuses'] == 1) ||
    ($parent == '212' && isset($role['edit_credits']) && $role['edit_credits'] == 1) ||
    ($parent == '125' && isset($role['edit_depits']) && $role['edit_depits'] == 1) ||
    ($parent == '221' && isset($role['edit_partners']) && $role['edit_partners'] == 1) ||
    ($parent == '11' && isset($role['edit_assets']) && $role['edit_assets'] == 1) ||
    ($parent == '213' && isset($role['edit_employees']) && $role['edit_employees'] == 1) ||
    ($parent == '112' && isset($role['edit_rentables']) && $role['edit_rentables'] == 1) ||
    ($parent == '123' && isset($role['edit_stock']) && $role['edit_stock'] == 1));
    
    // Fallback to add permissions if edit permissions don't exist
    if (!$has_permission) {
        $has_permission = (($parent == '122' && $role['add_clients'] == 1) ||
        ($parent == '211' && $role['add_suppliers'] == 1) ||
        ($parent == '121' && $role['add_funds'] == 1) ||
        ($parent == '124' && $role['add_banks'] == 1) ||
        ($parent == '44' && $role['add_expenses'] == 1) ||
        ($parent == '32' && $role['add_revenuses'] == 1) ||
        ($parent == '212' && $role['add_credits'] == 1) ||
        ($parent == '125' && $role['add_depits'] == 1) ||
        ($parent == '221' && $role['add_partners'] == 1) ||
        ($parent == '11' && $role['add_assets'] == 1) ||
        ($parent == '213' && $role['add_employees'] == 1) ||
        ($parent == '112' && $role['add_rentables'] == 1) ||
        ($parent == '123' && $role['add_stock'] == 1));
    }
} else {
    // Add mode - use original permission check
    $has_permission = (($parent == '122' && $role['add_clients'] == 1) ||
    ($parent == '211' && $role['add_suppliers'] == 1) ||
    ($parent == '121' && $role['add_funds'] == 1) ||
    ($parent == '124' && $role['add_banks'] == 1) ||
    ($parent == '44' && $role['add_expenses'] == 1) ||
    ($parent == '32' && $role['add_revenuses'] == 1) ||
    ($parent == '212' && $role['add_credits'] == 1) ||
    ($parent == '125' && $role['add_depits'] == 1) ||
    ($parent == '221' && $role['add_partners'] == 1) ||
    ($parent == '11' && $role['add_assets'] == 1) ||
    ($parent == '213' && $role['add_employees'] == 1) ||
    ($parent == '112' && $role['add_rentables'] == 1) ||
    ($parent == '123' && $role['add_stock'] == 1));
}

if ($has_permission) {
?>



        <form id="myForm" action="do/<?= $edit_mode ? 'doedit_account.php' : 'doadd_account.php' ?>" method="post">
            <?php if ($edit_mode) { ?>
                <input type="hidden" name="id" value="<?= $account['id'] ?>">
            <?php } ?>
            <input type="text" name="q" value="<?= $parent ?>" hidden>
        <div class="card card-info">
            <div class="card-header">
                <h3><?= $edit_mode ? 'تعديل حساب' : 'اضافه حساب' ?></h3>
            </div>
             <div class="card-body">
            <div class="row">
                <div class="col col-3">
                <div class="form-group">
                            <label for="">الكود</label><span class="text-danger">*</span>
                            <input required class="form-control font-bold" type="text" name="code" id="" value="<?= $last_id ?>" <?= $edit_mode ? 'readonly' : '' ?>>
                        </div>
                </div>
                <div class="col">
                    
                <div class="form-group">
                            <label for="">الاسم</label><span class="text-danger">*</span>
                            <input required class="form-control font-bold form-control font-bold frst" type="text" name="aname" id="frst" value="<?= $edit_mode ? htmlspecialchars($account['aname']) : '' ?>">
                            <div id="resaname" ></div>
                        </div>
                </div>
            </div>

            <div class="row">
                <div class="col col-4">
                    
                <div class="form-group">
                            <label for="">نوع الحساب</label><span class="text-danger">*</span>
                            <select class="form-control font-bold" name="is_basic" id="">
                                <option value="1" <?= ($edit_mode && $account['is_basic'] == 1) ? 'selected' : '' ?>>اساسي</option>
                                <option value="0" <?= (!$edit_mode || $account['is_basic'] == 0) ? 'selected' : '' ?>>حساب عادي</option>
                            </select>
                        </div>
                </div>
                <div class="col">
                    
                <div class="form-group">
                            <label for="">يتبع ل</label><span class="text-danger">*</span>
                            <select class="form form-control font-bold" name="parent_id" id="">
                                
                                <?php
                                // Store results in array to allow multiple iterations
                                $parent_accounts = [];
                                if (is_object($resacs)) {
                                    while ($rowacs = $resacs->fetch_assoc()) {
                                        $parent_accounts[] = $rowacs;
                                    }
                                }
                                // Display options
                                foreach ($parent_accounts as $rowacs) {?>
                                   <option value="<?= $rowacs['id'] ?>" <?= ($edit_mode && isset($account['parent_id']) && $account['parent_id'] == $rowacs['id']) ? 'selected' : '' ?>><?= $rowacs['code'] ?>-<?= $rowacs['aname'] ?></option>
                               <?php }?>
                            </select>

                        </div>
                </div>
            </div>


            
            <div class="row">
                <div class="col col-4">
                    
                <div class="form-group">
                            <label for="">تليفون</label>
                            <input class="form-control font-bold" type="text" name="phone" id="" value="<?= $edit_mode ? htmlspecialchars($account['phone'] ?? '') : '' ?>" placeholder="التليفون او تليفون المسؤول">
                        
                            
                        </div>
                </div>
                <div class="col">
                    
                <div class="form-group">
                            <label for="">العنوان</label>
                            <input class="form-control font-bold" type="text" name="address" id="" value="<?= $edit_mode ? htmlspecialchars($account['address'] ?? '') : '' ?>" placeholder="اكتب العنوان او عنوان المسؤول">
                        
                        </div>
                </div>
            </div>





            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col">
                        <div class="form-group">
                            <label for="">مخزون</label>
                            <input type="checkbox" name="is_stock" id="" <?php 
                                if ($edit_mode && isset($account['is_stock']) && $account['is_stock'] == 1) {
                                    echo "checked ";
                                } elseif (!$edit_mode && $parent == "123") {
                                    echo "checked ";
                                }
                            ?>>
                                </div>

                        </div>
                        <div class="col">
                            
                <div class="form-group">
                            <label for="">حساب سري</label>
                            <input type="checkbox" name="secret" id="" <?= ($edit_mode && isset($account['secret']) && $account['secret'] == 1) ? 'checked ' : '' ?>>
                        </div>
                        </div>
                    </div>
                   </div>

                   <div class="col">         
                <div class="form-group">
                            <label for="">حساب صندوق</label>
                            <input type="checkbox" name="is_fund" id="" <?php 
                                if ($edit_mode && isset($account['is_fund']) && $account['is_fund'] == 1) {
                                    echo "checked ";
                                } elseif (!$edit_mode && $parent == "121") {
                                    echo "checked ";
                                }
                            ?>>
                        </div>
                        </div>
                        
                   <div class="col">         
                <div class="form-group">
                            <label for="">اصل قابل للتأجير</label>
                            <input type="checkbox" name="rentable" id="" <?php 
                                if ($edit_mode && isset($account['rentable']) && $account['rentable'] == 1) {
                                    echo "checked ";
                                } elseif (!$edit_mode && $parent == "112") {
                                    echo "checked ";
                                }
                            ?>>
                        </div>
                        </div>
                    </div>
                   </div>


                   <div class="col">
                    
                </div>
            </div>

            </div>
            <div class="card-footer">
                <div class="row">
                <div class="col">
                    <button class="btn btn-primary btn-block" type="submit"><?= $edit_mode ? 'تحديث' : 'تأكيد' ?></button>
            </div>
            <div class="col">
            <button class="btn btn-default btn-block" type="reset">مسح</button>
            </div>
                </div>
            </div>


        </div>
        </form>


        <?php }else{ echo $userErrorMassage; }?>



        </div>
    </section>
</div>



<script>
$(document).ready(function() {
    $('#frst').on('keyup', function() {
        var itemId = $(this).val();
        var accountId = '<?= $edit_mode ? $account['id'] : '' ?>';
        var url = 'get/get_accinfo.php?id=' + itemId;
        if (accountId) {
            url += '&current_id=' + accountId;
        }
        
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json', // Parse response as JSON
            success: function(response) {
                if (response.status === "exists") {
                    $('#resaname').text(response.message);
                } else {
                    $('#resaname').text(response.message);
                }
            },
            error: function(xhr, status, error) {
                $('#resaname').html("<p class='text-danger'>.</p>");
            }
        });
    });
});


</script>



<?php include('includes/footer.php') ?>