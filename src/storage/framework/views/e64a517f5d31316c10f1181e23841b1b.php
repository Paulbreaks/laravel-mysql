<?php $__env->startSection('title', 'Регистрация'); ?>

<?php $__env->startSection('content'); ?>
<h1 class="mb-4 text-center">Регистрация</h1>

    <form method="POST" action="<?php echo e(route('register')); ?>" class="w-50 mx-auto">
        <?php echo csrf_field(); ?>

        <!-- Поле Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="<?php echo e(old('email')); ?>" required>
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-danger"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Поле Пароль -->
        <div class="mb-3">
            <label for="password" class="form-label">Пароль:</label>
            <input type="password" name="password" id="password" class="form-control" required>
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-danger"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Подтверждение пароля -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Подтвердите пароль:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
    </form>

    <p class="mt-3 text-center">Уже есть аккаунт? <a href="<?php echo e(route('login')); ?>">Войти</a></p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/auth/register.blade.php ENDPATH**/ ?>