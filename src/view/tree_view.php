<script src="/src/js/jquery/jquery-3.7.1.min.js"</script>
<script src="/src/js/bootstrap/bootstrap.min.js"></script>
<script src="/src/js/bootstrap/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="/src/js/bootstrap/bootstrap.min.css">
<script src="/src/js/index.js"></script>

<div class="container">
    <div class="row mt-2">
        <div class="col-2">
            <button id="rootBtn" class="btn btn-primary">create root</button>
        </div>
        <div id="treeContainer">
            <?php if (!empty($data)) { ?>
                <?= $data; ?>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Confirm delete modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Delete confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete the entire tree?
            </div>
            <div class="modal-footer d-flex justify-content-between align-items-center">
                <div id="countdownTimer" class="text-danger"></div>
                <div>
                    <button type="button" class="btn btn-primary" id="confirmDeleteBtn">Yes</button>
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
</div>
