<?php
/**
 * @var string $title
 * @var string $description
 * @var array $buttons
 * @var Template $this
 * @var string $name
 * @var boolean $allowClose
 * @var string $type
 */
use Travelpayouts\Vendor\League\Plates\Template\Template;

Travelpayouts::getInstance()->assets->loader->registerAsset('admin-notice');

$this->layout('admin::notices/layout', [
	'allowClose' => $allowClose,
	'name' => $name,
	'type' => $type,
]);

$this->start('buttons');
foreach ($buttons as $button) {
	echo $button;
}
$this->stop();
?>

<?php if (isset($title)): ?>
    <div class="travelpayouts-notice__text__title"><?= $title ?></div>
<?php endif ?>
<?php if (isset($description)): ?>
    <div class="travelpayouts-notice__text__description"><?= $description ?></div>
<?php endif ?>
