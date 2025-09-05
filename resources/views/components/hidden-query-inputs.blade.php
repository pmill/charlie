@php
    if (! function_exists('hiddenInputs')) {
        /**
         * Recursively generate hidden inputs for query parameters, excluding some keys.
         *
         * @param array $data
         * @param string|null $parentKey
         */
        function hiddenInputs($data, $parentKey = null, $exclude = []) {
            foreach ($data as $key => $value) {
                $name = $parentKey ? $parentKey . "[$key]" : $key;

                // Skip if key (dot notation) is in exclude list
                $dotKey = $parentKey ? $parentKey . '.' . $key : $key;
                if (in_array($dotKey, $exclude)) {
                    continue;
                }

                if (is_array($value)) {
                    hiddenInputs($value, $name, $exclude);
                } else {
                    echo '<input type="hidden" name="' . $name . '" value="' . e($value) . '">';
                }
            }
        }
    }

    hiddenInputs($query, null, $exclude);
@endphp
