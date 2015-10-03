{
  "id": "<?= $generator->moduleID ?>",
  "name": "<?= $generator->getName() ?>",
  "class": "<?= str_replace('\\', '\\\\', $generator->moduleClass) ?>",
  "isCore": false,
  "description": "<?= $generator->getDescription() ?>",
  "keywords": [
    "<?= $generator->moduleID ?>"
  ],
  "version": "1.0.0"
}