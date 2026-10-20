<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <h4 class="mb-4">Welcome back, <?php echo e(auth()->user()->name); ?>!</h4>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <?php if (isset($component)) { $__componentOriginal8f216e051c231b98198765acd723fb77 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8f216e051c231b98198765acd723fb77 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stats-card','data' => ['icon' => 'calendar-check','label' => 'Total Bookings','value' => $total_bookings,'color' => 'var(--sky-blue)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stats-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'calendar-check','label' => 'Total Bookings','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($total_bookings),'color' => 'var(--sky-blue)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8f216e051c231b98198765acd723fb77)): ?>
<?php $attributes = $__attributesOriginal8f216e051c231b98198765acd723fb77; ?>
<?php unset($__attributesOriginal8f216e051c231b98198765acd723fb77); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8f216e051c231b98198765acd723fb77)): ?>
<?php $component = $__componentOriginal8f216e051c231b98198765acd723fb77; ?>
<?php unset($__componentOriginal8f216e051c231b98198765acd723fb77); ?>
<?php endif; ?>
        </div>
        <div class="col-md-4">
            <?php if (isset($component)) { $__componentOriginal8f216e051c231b98198765acd723fb77 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8f216e051c231b98198765acd723fb77 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stats-card','data' => ['icon' => 'clock','label' => 'Active Bookings','value' => $active_bookings,'color' => 'var(--baby-pink)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stats-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'clock','label' => 'Active Bookings','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($active_bookings),'color' => 'var(--baby-pink)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8f216e051c231b98198765acd723fb77)): ?>
<?php $attributes = $__attributesOriginal8f216e051c231b98198765acd723fb77; ?>
<?php unset($__attributesOriginal8f216e051c231b98198765acd723fb77); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8f216e051c231b98198765acd723fb77)): ?>
<?php $component = $__componentOriginal8f216e051c231b98198765acd723fb77; ?>
<?php unset($__componentOriginal8f216e051c231b98198765acd723fb77); ?>
<?php endif; ?>
        </div>
        <div class="col-md-4">
            <?php if (isset($component)) { $__componentOriginal8f216e051c231b98198765acd723fb77 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8f216e051c231b98198765acd723fb77 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.stats-card','data' => ['icon' => 'box','label' => 'Total Orders','value' => $total_orders,'color' => 'var(--mint-green)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('stats-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'box','label' => 'Total Orders','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($total_orders),'color' => 'var(--mint-green)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8f216e051c231b98198765acd723fb77)): ?>
<?php $attributes = $__attributesOriginal8f216e051c231b98198765acd723fb77; ?>
<?php unset($__attributesOriginal8f216e051c231b98198765acd723fb77); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8f216e051c231b98198765acd723fb77)): ?>
<?php $component = $__componentOriginal8f216e051c231b98198765acd723fb77; ?>
<?php unset($__componentOriginal8f216e051c231b98198765acd723fb77); ?>
<?php endif; ?>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                    <h6 class="mb-0 fw-semibold">Recent Bookings</h6>
                    <a href="<?php echo e(route('parent.bookings.index')); ?>" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <?php $__empty_1 = true; $__currentLoopData = $recent_bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
                            <div>
                                <p class="fw-semibold mb-1"><?php echo e($booking->babysitter->name ?? 'N/A'); ?></p>
                                <small class="text-muted"><?php echo e($booking->date->format('M d, Y')); ?> · <?php echo e($booking->start_time); ?> · <?php echo e($booking->duration_hours); ?>h</small>
                            </div>
                            <span class="badge rounded-pill
                                <?php if($booking->status->value === 'completed'): ?> bg-success
                                <?php elseif($booking->status->value === 'confirmed'): ?> bg-primary
                                <?php elseif($booking->status->value === 'pending'): ?> bg-warning text-dark
                                <?php elseif($booking->status->value === 'cancelled'): ?> bg-secondary
                                <?php else: ?> bg-light text-dark
                                <?php endif; ?>">
                                <?php echo e(ucfirst($booking->status->value)); ?>

                            </span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-muted text-center py-4 mb-0">No bookings yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                    <h6 class="mb-0 fw-semibold">Recent Orders</h6>
                    <a href="<?php echo e(route('parent.orders.index')); ?>" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <?php $__empty_1 = true; $__currentLoopData = $recent_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
                            <div>
                                <p class="fw-semibold mb-1">Order #<?php echo e($order->id); ?></p>
                                <small class="text-muted">$<?php echo e(number_format($order->total, 2)); ?> · <?php echo e($order->created_at->format('M d, Y')); ?></small>
                            </div>
                            <span class="badge rounded-pill
                                <?php if($order->status->value === 'delivered'): ?> bg-success
                                <?php elseif($order->status->value === 'shipped'): ?> bg-info
                                <?php elseif($order->status->value === 'processing'): ?> bg-primary
                                <?php elseif($order->status->value === 'cancelled'): ?> bg-secondary
                                <?php else: ?> bg-warning text-dark
                                <?php endif; ?>">
                                <?php echo e(ucfirst($order->status->value)); ?>

                            </span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-muted text-center py-4 mb-0">No orders yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/dashboard/parent/index.blade.php ENDPATH**/ ?>