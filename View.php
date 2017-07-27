<?php

 class View {

    public static function render($contentView = '', $data = [], $templateView = 'master') {
        // share data to the view
        if (!empty($data)) {
            foreach ($data as $variable => $value) {
                $$variable = $value;
            }
        }

        // share flash-messages
        if (!empty($_SESSION['errors'])) {
            $errors = $_SESSION['errors'];
        }

        if (!empty($_SESSION['success'])) {
            $success = $_SESSION['success'];
        }

        include 'Views/layouts/' . $templateView . '.php';
    }
 }
