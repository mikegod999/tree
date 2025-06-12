<?php include 'header.php'; ?>

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
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel">
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

<!-- Change node title modal -->
<div class="modal fade" id="changeNodeTitleModal" tabindex="-1" aria-labelledby="editNodeModalTitle">
    <div class="modal-dialog">
        <form id="editNodeForm" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editNodeModalTitle">Change node title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="nodeTitle" class="form-label">Нова назва</label>
                    <input type="text" class="form-control" id="nodeTitle" name="nodeTitle" required>
                    <div class="error-title text-danger mt-1 hidden" id="error-title" ></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>


<?php include 'footer.php'; ?>
