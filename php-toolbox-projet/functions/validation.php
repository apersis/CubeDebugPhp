<?php

function sanitize($item, $type) {
    switch($type) {
        case 'string':
            $item = filter_var($item, FILTER_SANITIZE_STRING);
            break;
        case 'email':
            $item = filter_var($item, FILTER_SANITIZE_EMAIL);
            break;
        case 'int':
            $item = filter_var($item, FILTER_SANITIZE_NUMBER_INT);
            break;
        case 'url':
            $item = filter_var($item, FILTER_SANITIZE_URL);
            break;
    }

    return $item;
}

function validate(array $items, array $rule_items) {
    $result = array();
    foreach($rule_items as $item_key => $item_value) {

        // S'il existe une clé de tableau '$item_key' dans $items (par exemple, $item_key contient la chaîne 'name' et $items contient un tableau associatif $items['name'])
        if (array_key_exists($item_key, $items)) {
            $form_items[$item_key] = trim($items[$item_key]);
            $form_label = $item_value['label'];

            foreach($item_value as $rule_key => $rule_value) { // Pour transformer les nom de champs et que les messages d'erreur soit comprehensible par tous
                switch($form_label){
                    case 'Name':
                        $label_fr='nom';
                        break;
                    case 'Email':
                        $label_fr='email';
                        break;
                    case 'Subject':
                        $label_fr='objet';
                        break;
                    case 'Message':
                        $label_fr='message';
                        break;
                }
                switch($rule_key) {
                    case 'required':
                        if ($rule_value === TRUE && empty($form_items[$item_key])) {
                            $result['danger'][] = 'Votre ' . $label_fr . ' est requis !';
                        }
                        break;
                    case 'sanitize':
                        if (!sanitize($form_items[$item_key], $rule_value)) {
                            $result['danger'][] = 'Votre ' . $label_fr . " n'est pas valide !";
                        }
                        break;
                    case 'min':
                        if (strlen($form_items[$item_key]) < $rule_value) {
                            $result['danger'][] = 'Votre ' . $label_fr . ' doit comporter au moins '.$rule_value.' caractères !';
                        }
                        break;
                    case 'max':
                        if (strlen($form_items[$item_key]) > $rule_value) {
                            $result['danger'][] = 'Votre ' . $label_fr . ' doit comporter au plus '.$rule_value.' caractères !';
                        }
                        break;
                    case 'regexp':
                        if (!preg_match($rule_value, $form_items[$item_key])) {
                            $result['danger'][] = 'Votre ' . $label_fr . ' ne dois pas comporter de caractères spéciaux !';
                        }
                        break;
                    case 'matches':
                        if ($form_items[$item_key] !== $form_items[$rule_value]) {
                            $result['danger'][] = 'Votre ' . $label_fr . ' ne correspond pas !';
                        }
                        break;

                }

                $result['item'] = $form_items;
            }
        }
    }
    return $result;

}

function is_passed(array $items) {
    return !array_key_exists('danger', $items);
}

function check_validation(array $validated_items, array $after_validation = null) {
    if (is_passed($validated_items)) {

        $after_validated_items = $validated_items['item'];
        if ($after_validation !== null) {
            foreach($after_validation as $action_key => $action_value) {
                switch($action_key) {
                    case 'hash':
                        $argument = explode(':', $action_value);
                        $after_validated_items[$argument[0]] = password_hash($after_validated_items[$argument[0]], constant($argument[1]));
                        break;
                    case 'remove':
                        unset($after_validated_items[$action_value]);
                        break;
                }
            }
        }
        return $after_validated_items;
    } else {
        $result['danger'] = $validated_items['danger'];
        return $result;
    }
}
