<?php
/**
 * @var string $src
 * @var string $type
 */

use Travelpayouts\admin\controllers\WidgetPreviewController;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Widget preivew</title>
    <script type="text/javascript">
      /*<![CDATA[*/

      window.iFrameResizer = {
        heightCalculationMethod: "taggedElement"
      };

      /*]]>*/
    </script>
</head>
<body>
<div data-iframe-height="data-iframe-height">
    <?php if ($type === WidgetPreviewController::TYPE_SCRIPT): ?>
        <script type="text/javascript" src="<?= $src ?>" charset="utf-8" async="async"></script>
    <?php else: ?>
        <iframe src="<?= $src ?>" style="width: 100%; height: 300px; border-width:0;"></iframe>
    <?php endif; ?>
</div>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/iframe-resizer/3.6.2/iframeResizer.contentWindow.js"></script>
</body>
</html>
