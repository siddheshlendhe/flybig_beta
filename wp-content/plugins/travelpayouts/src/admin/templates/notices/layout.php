<?php
/**
 * @var boolean $allowClose
 * @var string $name
 * @var string $type
 */

Travelpayouts::getInstance()->assets->loader->registerAsset('admin-notice');

$notificationClassNames = array_filter([
	$type ? "travelpayouts-notice--{$type}" : null,
	$allowClose ? "travelpayouts-notice--closeable" : null,
]);

?>
<div class="travelpayouts-chunk" style="display: none">
    <div class="travelpayouts-notice <?= implode(' ', $notificationClassNames) ?>">
        <div class="wlcm__plug__content travelpayouts-notice__content">
            <div class="wlcm__plug__logo travelpayouts-notice__logo">
                <svg width="24" height="36" viewBox="0 0 24 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M23.46 25.926h-6.18a.96.96 0 01-.96-.96V20.16h5.634a.54.54 0 00.533-.45l.382-2.28a.54.54 0 00-.533-.63H12.96v8.166a4.32 4.32 0 004.32 4.32h3.36v2.499c-1.662.632-3.085.855-4.918.855-4.678 0-7.432-2.597-7.562-7.2V16.8H.922a.54.54 0 00-.533.45l-.381 2.28a.54.54 0 00.532.63H4.8v5.28c.074 2.88.821 5.524 2.906 7.625C9.61 34.986 12.382 36 15.722 36c2.813 0 4.945-.465 7.727-1.766a.958.958 0 00.551-.868v-6.9a.54.54 0 00-.54-.54zM1.665 13.44H8.16V6.23l4.8-1.7v8.91h10.118a.54.54 0 00.533-.45l.381-2.28a.54.54 0 00-.532-.63h-7.14V.54a.54.54 0 00-.72-.509L5.16 3.728a.54.54 0 00-.36.51v5.842H2.046a.54.54 0 00-.532.45l-.382 2.28a.54.54 0 00.533.63z"
                          fill="#0085FF"/>
                </svg>
            </div>
            <div class="wlcm__plug__text travelpayouts-notice__text">
				<?= $this->section('content') ?>
            </div>
        </div>
        <div class="wlcm__plug__control travelpayouts-notice__action-bar">
			<?= $this->section('buttons') ?>
        </div>
		<?php if ($allowClose): ?>
            <div class="travelpayouts-notice__close">

                <a href="#" class="travelpayouts-notice__close__btn travelpayouts-hide-temp"
                   data-name="<?= $name ?>">
                    <svg class="travelpayouts-notice__close__icon" fill="currentColor"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511.995 511.995">
                        <path d="M437.126 74.939c-99.826-99.826-262.307-99.826-362.133 0C26.637 123.314 0 187.617 0 256.005s26.637 132.691 74.993 181.047c49.923 49.923 115.495 74.874 181.066 74.874s131.144-24.951 181.066-74.874c99.826-99.826 99.826-262.268.001-362.113zM409.08 409.006c-84.375 84.375-221.667 84.375-306.042 0-40.858-40.858-63.37-95.204-63.37-153.001s22.512-112.143 63.37-153.021c84.375-84.375 221.667-84.355 306.042 0 84.355 84.375 84.355 221.667 0 306.022z"/>
                        <path d="M341.525 310.827l-56.151-56.071 56.151-56.071c7.735-7.735 7.735-20.29.02-28.046-7.755-7.775-20.31-7.755-28.065-.02l-56.19 56.111-56.19-56.111c-7.755-7.735-20.31-7.755-28.065.02-7.735 7.755-7.735 20.31.02 28.046l56.151 56.071-56.151 56.071c-7.755 7.735-7.755 20.29-.02 28.046 3.868 3.887 8.965 5.811 14.043 5.811s10.155-1.944 14.023-5.792l56.19-56.111 56.19 56.111c3.868 3.868 8.945 5.792 14.023 5.792a19.828 19.828 0 0014.043-5.811c7.733-7.756 7.733-20.311-.022-28.046z"/>
                    </svg>
                </a>
            </div>
		<?php endif; ?>
    </div>
</div>
