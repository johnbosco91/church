<?php

use Yiisoft\TranslatorExtractor\Command\ExtractCommand;

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Church System',
    'languages' => [
        'en'=>'English',
        'sw'=>'Swahili',
        'fr'=>'French',
        'itl'=>'Italiano',
    ],
    'yiisoft/yii-console' => [
        'commands' => [
            'translator/extract' => ExtractCommand::class,
        ],
    ],
    'yiisoft/translator-extractor' => [
        // Using relative path:
        'messagePath' => dirname(__DIR__, 5) . '/messages',
    ],
];
