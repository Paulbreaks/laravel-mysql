 <!-- Наследуем основной шаблон -->

<?php $__env->startSection('title', 'Главная'); ?> <!-- Заголовок страницы -->

<?php $__env->startSection('content'); ?> <!-- Контент -->
    <div class="text-center">
        <h1 class="mb-4">Главная страница</h1>

        <?php if(auth()->guard()->check()): ?>
            <div class="card mx-auto mb-4" style="max-width: 400px;">
                <div class="card-body">
                    <p class="fw-bold">Вы вошли как: <span class="text-primary"><?php echo e(auth()->user()->email); ?></span></p>
                    <p>💰 Ваш баланс: <strong><?php echo e(number_format(auth()->user()->cash, 2)); ?> <?php echo e(auth()->user()->currency); ?></strong></p>
                    <p>🎁 Ваш бонус: <strong><?php echo e(number_format(auth()->user()->bonus, 2)); ?> <?php echo e(auth()->user()->currency); ?></strong></p>

                    <form method="POST" action="<?php echo e(route('logout')); ?>" class="mt-3">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-danger w-100">Выйти</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <p class="mb-3">Вы не вошли в систему.</p>
            <a href="<?php echo e(route('login')); ?>" class="btn btn-primary me-2">Войти</a>
            <a href="<?php echo e(route('register')); ?>" class="btn btn-outline-primary">Регистрация</a>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/home.blade.php ENDPATH**/ ?>