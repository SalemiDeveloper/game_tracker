<?php 

class Validator {

    public static function validate($data, $rules) {
        $errors = [];

        foreach ($rules as $field => $fieldRules) {
            $value = trim($data[$field] ?? '');

            foreach ($fieldRules as $rule) {

                // required
                if ($rule === 'required' && $value === '') {
                    $errors[$field][] = "O campo {$field} é orbigatório.";
                }

                // number
                if ($rule === 'number' && !is_numeric($value)) {
                    $errors[$field][] = "O campo {$field} deve ser numérico (0 a 10).";
                }

                //min:0
                if (str_starts_with($rule, 'min:')) {
                    $min = explode(':', $rule)[1];
                    if ($value < $min) {
                        $errors[$field][] = "O campo {$field} deve ser maior ou igual {$min}.";
                    }
                }

                // max:10
                if (str_starts_with($rule, 'max:')) {
                    $max = explode(':', $rule)[1];
                    if ($value > $max) {
                        $errors[$field][] = "O campo {$field} deve ser menor ou igual {$max}.";
                    }
                }
            }
        }
        return $errors;
    }
}

?>