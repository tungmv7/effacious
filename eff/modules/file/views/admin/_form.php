<div class="file-dropzone-wrapper">
    <?= \eff\widgets\dropzone\DropZone::widget(
        [
            'id' => $modal . '-dropzone',
            'name' => 'file',
            'url' => \yii\helpers\Url::toRoute(['/file/admin/upload']), // upload url
            'htmlOptions' => ['class' => 'file-dropzone'],
            'eventHandlers' => $dropZoneEvenHandler,
            'options' => $dropZoneOptions
        ]
    ) ?>
</div>
