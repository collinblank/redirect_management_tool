<?php
function csv_parser($website_id, $file_path)
{
    global $wpdb;
    $errors = [];
    $redirect_inserts = 0;
    $flag_rule_inserts = 0;

    if (!file_exists($file_path)) {
        return ["errors" => ["File not found at $file_path"]];
    }

    $file = fopen($file_path, "r");
    if ($file === false) {
        return ["errors" => ["Unable to open file."]];
    }

    try {
        $row_number = 0;

        while (($data = fgetcsv($file, 0, "|")) !== false) {
            $row_number++;

            if (empty($data[0]) || empty($data[1]) || empty($data[2])) {
                $missing_data = [];
                if (empty($data[1])) {
                    $missing_data[] = "from URL regex";
                }
                if (empty($data[2])) {
                    $missing_data[] = "to URL";
                }
                $errors[] = "Row {$row_number}: Unable to create redirect rule. Missing data in column(s): " . implode(", ", $missing_data) . ".";
                continue;
            }

            $wpdb->query('START TRANSACTION');

            // TODO: validate incoming data somehow (reusing fns from form?), and display errors.
            try {
                $redirect_result = $wpdb->insert(
                    'redirect_rules',
                    array(
                        'website_id' => $website_id,
                        'name' => $data[0] === 'No description' ? '' : sanitize_text_field($data[0]),
                        'from_url_regex' => sanitize_text_field($data[1]),
                        'to_url' => sanitize_text_field($data[2])
                    )
                );

                if ($redirect_result === false) {
                    throw new Exception("Database error upon insert: " . $wpdb->last_error);
                }

                $new_redirect_id = $wpdb->insert_id;

                if (!empty($data[3])) {
                    $my_flags = array_map("trim", explode(",", str_replace(['[', ']'], '', $data[3])));
                    $my_flags_ids = [];

                    foreach ($my_flags as $flag) {
                        $flag_id = $wpdb->get_var($wpdb->prepare(
                            "SELECT id FROM redirect_flags WHERE flags = %s",
                            sanitize_text_field($flag)
                        ));
                        $my_flags_ids[] = $flag_id;
                    }

                    if (in_array(null, $my_flags_ids, true)) {
                        $null_indices = array_keys($my_flags_ids, null, true);
                        $invalid_flags = array_map(function ($null_index) use ($my_flags) {
                            return $my_flags[$null_index];
                        }, $null_indices);

                        throw new Exception("Invalid flag(s) '" . esc_html(implode(', ', $invalid_flags)) . "' in row.");
                    }

                    foreach ($my_flags_ids as $flag_id) {
                        $flag_rule_result = $wpdb->insert(
                            'redirect_flag_rule',
                            array(
                                'redirect_id' => $new_redirect_id,
                                'flag_id' => $flag_id
                            )
                        );

                        if ($flag_rule_result === false) {
                            throw new Exception("Unable to create rule/flag connection due to the following database error: " . $wpdb->last_error);
                        }

                        $flag_rule_inserts++;
                    }
                }

                $wpdb->query('COMMIT');
                $redirect_inserts++;
            } catch (Exception $e) {
                $errors[] = "Row {$row_number}: Unable to create redirect rule. " . $e->getMessage();
                $wpdb->query('ROLLBACK');
                continue;
            }
        }
    } catch (Exception $e) {
        $errors[] = "Error reading CSV: " . $e->getMessage();
    } finally {
        fclose($file);
    }

    return array("errors" => $errors, "redirect_inserts" => $redirect_inserts, "flag_rule_inserts" => $flag_rule_inserts);
}
