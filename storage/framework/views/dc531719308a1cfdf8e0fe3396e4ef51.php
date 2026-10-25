<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirm Action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to proceed? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmModalBtn">Confirm</button>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
        var confirmBtn = document.getElementById('confirmModalBtn');
        var targetForm = null;

        document.querySelectorAll('[data-confirm-form]').forEach(function(el) {
            el.addEventListener('click', function(e) {
                e.preventDefault();
                targetForm = document.getElementById(this.getAttribute('data-confirm-form'));
                if (targetForm) {
                    confirmModal.show();
                }
            });
        });

        confirmBtn.addEventListener('click', function() {
            if (targetForm) {
                targetForm.submit();
            }
            confirmModal.hide();
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /app/resources/views/partials/_confirm-modal.blade.php ENDPATH**/ ?>