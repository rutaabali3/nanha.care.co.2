<?php
    $rating = $rating ?? 0;
    $full = floor($rating);
    $half = ($rating - $full) >= 0.5 ? 1 : 0;
    $empty = 5 - $full - $half;
?>
<div class="star-rating d-inline-flex align-items-center gap-1 text-sunshine-yellow">
    <?php for($i = 0; $i < $full; $i++): ?>
        <i class="bi bi-star-fill"></i>
    <?php endfor; ?>
    <?php if($half): ?>
        <i class="bi bi-star-half"></i>
    <?php endif; ?>
    <?php for($i = 0; $i < $empty; $i++): ?>
        <i class="bi bi-star"></i>
    <?php endfor; ?>
    <span class="ms-1 small text-muted">(<?php echo e(number_format($rating, 1)); ?>)</span>
</div>
<?php /**PATH /app/resources/views/partials/_star-rating.blade.php ENDPATH**/ ?>