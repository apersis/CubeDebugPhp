<?php

    function logSubmitToDatabase($body, $result = null){
        $cols = [
            'form' => $body->form,
            'data' => json_encode($body),
            'result' => $result !== null ? json_encode($result) : null,
            'timestamp' => time()+7200,
        ];
        insert('logs', $cols);
    }