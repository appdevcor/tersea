<?php

use dosamigos\fileupload\FileUploadUI;

?>

<?= FileUploadUI::widget([
    'model' => $model,
    'attribute' => 'image',
    'url' => ['uploadedfiles/image-upload', 'id' => $model->id],
    'gallery' => false,
    'fieldOptions' => [
        'accept' => 'image'
    ],
    'clientOptions' => [
        'maxFileSize' => 2000000
    ],
    // ...
    'clientEvents' => [
        'fileuploaddone' => 'function(e, data) {
                                console.log(e);
                                console.log(data);
                            }',
        'fileuploadfail' => 'function(e, data) {
                                console.log(e);
                                console.log(data);
                            }',
    ],
]); ?>