<?php
/**
 * The template for the menu container of the panel.
 * Override this template by specifying the path where it is stored (templates_path) in your Redux config.
 *
 * @author     Redux Framework
 * @package    TravelpayoutsSettingsFramework/Templates
 * @version:    4.0.0
 */

use Travelpayouts\components\LanguageHelper;

$requireAsset = static function ($path) {
    $assetPath = Travelpayouts::getAlias("@images/admin/panel/$path");
    if (file_exists($assetPath)) {
        return file_get_contents($assetPath);
    }
    return '';
};
?>
<div class="redux-sidebar">
    <div class="redux-sidebar-wrapper">
        <div class="travelpayouts-admin-logo">
            <div class="travelpayouts-admin-logo--full">
                <a href="javascript:void(0);"
                   class="redux-group-tab-link-a"
                   data-key="2"
                   data-rel="2">
                    <?= LanguageHelper::isRuDashboard()
                        ? $requireAsset('/logo-wide-ru.svg')
                        : $requireAsset('/logo-wide-en.svg') ?>
                </a>
            </div>
            <div class="travelpayouts-admin-logo--short">
                <a href="javascript:void(0);"
                   class="redux-group-tab-link-a"
                   data-key="2"
                   data-rel="2">
                    <?= $requireAsset('/logo-short.svg') ?>
                </a>
            </div>
        </div>
        <div class="redux-group-menu-wrapper">
            <ul class="redux-group-menu">
                <?php
                foreach ($this->parent->sections as $k => $section) {
                    $the_title = isset($section['title'])
                        ? $section['title']
                        : '';
                    $skip_sec = false;
                    foreach ($this->parent->options_class->hidden_perm_sections as $num => $section_title) {
                        if ($section_title === $the_title) {
                            $skip_sec = true;
                        }
                    }

                    if (isset($section['customizer_only']) && true === $section['customizer_only']) {
                        continue;
                    }

                    if (false === $skip_sec) {
                        echo($this->parent->section_menu($k, $section)); // phpcs:ignore WordPress.Security.EscapeOutput
                        $skip_sec = false;
                    }
                }

                /**
                 * Action 'redux_travelpayouts/page/{opt_name}/menu/after'
                 *
                 * @param object $this TravelpayoutsSettingsFramework
                 */
                do_action("redux_travelpayouts/page/{$this->parent->args['opt_name']}/menu/after", $this); // phpcs:ignore WordPress.NamingConventions.ValidHookName
                ?>
            </ul>
            <?php if (!empty($this->parent->args['display_version'])) : ?>
                <div class="redux-sidebar-version">
                    v. <?php echo wp_kses_post($this->parent->args['display_version']); ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
