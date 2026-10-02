<?php
    $role = auth()->user()->getRoleNames()[0] ?? 'parent';
    $currentRoute = request()->route()->getName();
?>
<nav class="sidebar-menu bg-gradient-sidebar text-on-gradient" style="width: 260px; position: fixed; top: 0; left: 0; bottom: 0; overflow-y: auto; z-index: 1030; transition: transform 0.3s;">
    <div class="p-3 border-bottom" style="border-color: rgba(255,255,255,0.1) !important;">
        <a href="<?php echo e(route('home')); ?>" class="text-decoration-none d-flex align-items-center gap-2 text-on-gradient">
            <i class="bi bi-heart-pulse-fill fs-4"></i>
            <span class="fw-bold fs-5">NanhaCare</span>
        </a>
    </div>
    <ul class="list-unstyled px-2 pt-2">
        <?php switch($role):
            case ('admin'): ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'admin.dashboard','label' => 'Dashboard','icon' => 'speedometer2','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('admin.dashboard'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Dashboard'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('speedometer2'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'admin.users.index','label' => 'Users','icon' => 'people','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('admin.users.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Users'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('people'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'admin.users.create','label' => 'Create User','icon' => 'person-plus','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('admin.users.create'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Create User'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('person-plus'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'admin.roles.index','label' => 'Roles','icon' => 'shield-check','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('admin.roles.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Roles'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('shield-check'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'admin.moderation.index','label' => 'Moderation','icon' => 'shield-exclamation','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('admin.moderation.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Moderation'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('shield-exclamation'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'admin.reports.index','label' => 'Reports','icon' => 'flag','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('admin.reports.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Reports'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('flag'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'admin.settings.index','label' => 'Settings','icon' => 'gear','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('admin.settings.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Settings'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('gear'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'admin.revenue.index','label' => 'Revenue','icon' => 'currency-dollar','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('admin.revenue.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Revenue'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('currency-dollar'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'admin.announcements.index','label' => 'Announcements','icon' => 'megaphone','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('admin.announcements.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Announcements'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('megaphone'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php break; ?>

            <?php case ('moderator'): ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'moderator.dashboard','label' => 'Dashboard','icon' => 'speedometer2','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('moderator.dashboard'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Dashboard'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('speedometer2'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'moderator.queue.index','label' => 'Queue','icon' => 'inbox','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('moderator.queue.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Queue'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('inbox'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'moderator.published.index','label' => 'Published','icon' => 'check-circle','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('moderator.published.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Published'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('check-circle'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'moderator.flagged.index','label' => 'Flagged','icon' => 'exclamation-triangle','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('moderator.flagged.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Flagged'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('exclamation-triangle'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'moderator.reports.index','label' => 'Reports','icon' => 'flag','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('moderator.reports.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Reports'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('flag'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'moderator.activity.index','label' => 'Activity','icon' => 'activity','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('moderator.activity.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Activity'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('activity'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php break; ?>

            <?php case ('parent'): ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'parent.dashboard','label' => 'Home','icon' => 'house','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('parent.dashboard'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Home'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('house'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'parent.bookings.index','label' => 'Bookings','icon' => 'calendar-check','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('parent.bookings.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Bookings'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('calendar-check'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'parent.orders.index','label' => 'Orders','icon' => 'box','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('parent.orders.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Orders'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('box'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'parent.children.index','label' => 'Children','icon' => 'people','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('parent.children.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Children'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('people'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'parent.saved-babysitters.index','label' => 'Saved','icon' => 'bookmark-heart','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('parent.saved-babysitters.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Saved'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('bookmark-heart'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'parent.bookmarks.index','label' => 'Bookmarks','icon' => 'bookmark','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('parent.bookmarks.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Bookmarks'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('bookmark'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'parent.settings.index','label' => 'Settings','icon' => 'gear','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('parent.settings.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Settings'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('gear'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php break; ?>

            <?php case ('babysitter'): ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'babysitter.dashboard','label' => 'Overview','icon' => 'speedometer2','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('babysitter.dashboard'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Overview'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('speedometer2'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'babysitter.bookings.index','label' => 'Bookings','icon' => 'calendar-check','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('babysitter.bookings.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Bookings'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('calendar-check'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'babysitter.profile.index','label' => 'Profile','icon' => 'person','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('babysitter.profile.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Profile'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('person'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'babysitter.earnings.index','label' => 'Earnings','icon' => 'currency-dollar','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('babysitter.earnings.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Earnings'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('currency-dollar'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'babysitter.reviews.index','label' => 'Reviews','icon' => 'star','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('babysitter.reviews.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Reviews'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('star'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'babysitter.notifications.index','label' => 'Notifications','icon' => 'bell','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('babysitter.notifications.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Notifications'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('bell'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php break; ?>

            <?php case ('shop_owner'): ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'shop-owner.dashboard','label' => 'Overview','icon' => 'speedometer2','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('shop-owner.dashboard'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Overview'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('speedometer2'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'shop-owner.products.index','label' => 'Products','icon' => 'box','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('shop-owner.products.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Products'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('box'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'shop-owner.orders.index','label' => 'Orders','icon' => 'cart','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('shop-owner.orders.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Orders'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('cart'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'shop-owner.earnings.index','label' => 'Earnings','icon' => 'currency-dollar','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('shop-owner.earnings.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Earnings'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('currency-dollar'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'shop-owner.profile.index','label' => 'Profile','icon' => 'person','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('shop-owner.profile.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Profile'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('person'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'shop-owner.reviews.index','label' => 'Reviews','icon' => 'star','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('shop-owner.reviews.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Reviews'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('star'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php break; ?>

            <?php case ('doctor'): ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'doctor.dashboard','label' => 'Overview','icon' => 'speedometer2','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('doctor.dashboard'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Overview'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('speedometer2'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'doctor.posts.index','label' => 'Posts','icon' => 'file-text','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('doctor.posts.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Posts'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('file-text'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'doctor.comments.index','label' => 'Comments','icon' => 'chat','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('doctor.comments.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Comments'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('chat'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'doctor.analytics.index','label' => 'Analytics','icon' => 'graph-up','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('doctor.analytics.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Analytics'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('graph-up'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'doctor.profile.index','label' => 'Profile','icon' => 'person','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('doctor.profile.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Profile'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('person'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php break; ?>

            <?php case ('support_agent'): ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'support.dashboard','label' => 'Dashboard','icon' => 'speedometer2','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('support.dashboard'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Dashboard'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('speedometer2'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'support.tickets.index','label' => 'Inbox','icon' => 'inbox','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('support.tickets.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Inbox'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('inbox'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'support.faqs.index','label' => 'FAQs','icon' => 'question-circle','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('support.faqs.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('FAQs'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('question-circle'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'support.escalations.index','label' => 'Escalations','icon' => 'exclamation-triangle','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('support.escalations.index'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Escalations'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('exclamation-triangle'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
                <?php break; ?>

            <?php default: ?>
                <?php if (isset($component)) { $__componentOriginal5bfd3bb159ce0000260348a653d76773 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5bfd3bb159ce0000260348a653d76773 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-item','data' => ['route' => 'parent.dashboard','label' => 'Dashboard','icon' => 'speedometer2','current' => $currentRoute]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('parent.dashboard'),'label' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('Dashboard'),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('speedometer2'),'current' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentRoute)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $attributes = $__attributesOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__attributesOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5bfd3bb159ce0000260348a653d76773)): ?>
<?php $component = $__componentOriginal5bfd3bb159ce0000260348a653d76773; ?>
<?php unset($__componentOriginal5bfd3bb159ce0000260348a653d76773); ?>
<?php endif; ?>
        <?php endswitch; ?>
    </ul>
</nav>

<style>
    @media (max-width: 991.98px) {
        .sidebar-menu {
            transform: translateX(-100%);
        }
        .sidebar-menu.show {
            transform: translateX(0);
        }
    }
</style>
<?php /**PATH /app/resources/views/components/sidebar-menu.blade.php ENDPATH**/ ?>