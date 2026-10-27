<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['route', 'label', 'icon', 'current']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['route', 'label', 'icon', 'current']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $active = str_starts_with($current, $route);
?>

<li class="mb-1">
    <a href="<?php echo e(route($route)); ?>"
       class="d-flex align-items-center gap-2 px-3 py-2 rounded text-decoration-none text-on-gradient"
       style="<?php echo e($active ? 'background-color: rgba(255,255,255,0.15); font-weight: 600;' : 'background-color: transparent;'); ?>"
       onmouseover="this.style.backgroundColor='rgba(255,255,255,0.12)';"
       onmouseout="this.style.backgroundColor='<?php echo e($active ? 'rgba(255,255,255,0.15)' : 'transparent'); ?>';">
        <i class="bi bi-<?php echo e($icon); ?>"></i>
        <span><?php echo e($label); ?></span>
    </a>
</li>
<?php /**PATH /app/resources/views/components/sidebar-item.blade.php ENDPATH**/ ?>