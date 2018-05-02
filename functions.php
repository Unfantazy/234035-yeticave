<?php
    function format_price($price) {
        $ceil_price = ceil($price);
        $edited_price = $ceil_price;

        if ($ceil_price >= 1000) {
            $edited_price = number_format($ceil_price, 0, '', ' ');
        }
        return $edited_price . ' ₽';
    }

    function render_template($path, $data) {
        if (file_exists($path)) {
            ob_start();
            require "$path";
            $output = ob_get_clean();
        } else {
            $output = '';
        }
        return $output;
    }