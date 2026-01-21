

<?php $__env->startSection('title', 'Login - Tible'); ?>

<?php $__env->startSection('content'); ?>
    <div class="min-h-[80vh] flex flex-col justify-center py-12 sm:px-6 lg:px-8 animate-fade-in">
        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
            <!-- Brand Logo with Entrance Animation -->
            <div class="animate-slide-up" style="animation-delay: 0.1s;">
                <img src="<?php echo e(asset('images/logo.webp')); ?>" alt="Tible Logo"
                    class="mx-auto h-20 w-auto mb-6 hover:scale-105 transition-transform duration-500">
            </div>

            <h2 class="text-3xl font-black text-brand-black tracking-tight animate-slide-up" style="animation-delay: 0.2s;">
                Welcome to Tible
            </h2>

            <!-- Slogan -->
            <p class="mt-3 text-brand-orange font-medium text-lg italic animate-slide-up" style="animation-delay: 0.3s;">
                "Streamline your time, boost your business."
            </p>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-md animate-slide-up" style="animation-delay: 0.4s;">
            <div
                class="bg-white py-10 px-10 shadow-2xl rounded-2xl border-t-4 border-brand-orange relative overflow-hidden">
                <!-- Decorative background element -->
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-brand-orange opacity-10 rounded-full blur-xl">
                </div>

                <?php if(session('error')): ?>
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r animate-pulse">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700 font-medium"><?php echo e(session('error')); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <form class="space-y-6 relative z-10" action="/login" method="POST">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700">
                            Email Address
                        </label>
                        <div class="mt-2 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-brand-orange focus:bg-white transition duration-150 sm:text-sm"
                                placeholder="you@tible.com" value="employee@test.com">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700">
                            Password
                        </label>
                        <div class="mt-2 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg leading-5 bg-gray-50 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-orange focus:border-brand-orange focus:bg-white transition duration-150 sm:text-sm"
                                placeholder="••••••••" value="pass">
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-bold text-white bg-brand-black hover:bg-brand-orange hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-orange transition-all duration-300 transform hover:-translate-y-1">
                            Sign In
                        </button>
                    </div>
                </form>

                <div class="mt-8">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500 uppercase tracking-widest text-xs font-semibold">Demo
                                Accounts</span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-3">
                        <div
                            class="bg-gray-50 p-3 rounded-md border border-gray-200 hover:border-brand-gray transition-colors cursor-pointer group">
                            <p class="text-xs font-bold text-brand-black group-hover:text-brand-orange transition-colors">
                                Employee</p>
                            <p class="text-xs text-gray-500">employee@test.com / pass</p>
                        </div>
                        <div
                            class="bg-gray-50 p-3 rounded-md border border-gray-200 hover:border-brand-gray transition-colors cursor-pointer group">
                            <p class="text-xs font-bold text-brand-black group-hover:text-brand-orange transition-colors">
                                Manager</p>
                            <p class="text-xs text-gray-500">manager@test.com / pass</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Note -->
            <p class="mt-6 text-center text-xs text-brand-gray">
                &copy; <?php echo e(date('Y')); ?> Tible T&A. All rights reserved. <br>
                <span class="opacity-75">Professional Time & Attendance Solutions</span>
            </p>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\faru\allhours\resources\views/auth/login.blade.php ENDPATH**/ ?>