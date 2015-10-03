#!/bin/bash
        for i in {100..200}; do
            ./yii gii/module --moduleClass=eff\\modules\\test$i\\Module --moduleID=test$i --overwrite=1 --interactive=0
        done
