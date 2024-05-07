<?php

return [

    'label' => 'Exportar :label',

    'modal' => [

        'heading' => 'Exportar :label',

        'form' => [

            'columns' => [

                'label' => 'Colunas',

                'form' => [

                    'is_enabled' => [
                        'label' => ':column habilitado',
                    ],

                    'label' => [
                        'label' => 'rótulo de :column',
                    ],

                ],

            ],

        ],

        'actions' => [

            'export' => [
                'label' => 'Exportar',
            ],

        ],

    ],

    'notifications' => [

        'completed' => [

            'title' => 'Exportação concluída',

            'actions' => [

                'download_csv' => [
                    'label' => 'Baixar .csv',
                ],

                'download_xlsx' => [
                    'label' => 'Baixar .xlsx',
                ],

            ],

        ],

        'max_rows' => [
            'title' => 'Exportação é muito grande',
            'body' => 'Você não pode exportar mais de 1 linha de cada vez.|Você não pode exportar mais de :count linhas de uma vez.',
        ],

        'started' => [
            'title' => 'Exportação iniciada',
            'body' => 'Sua exportação começou e será processada em segundo plano.|Sua exportação começou e :count linhas serão processadas em segundo plano.',
        ],

    ],

    'file_name' => 'exportar-:export_id-:model',

];
