<?php
function csv_parser($website_id, $file_path)
{
    global $wpdb;

    //$file_path = ABSPATH . 'wp-content/themes/redirect-management-tool/csv-parser/csv-files/import_to_mysql-2024-11-12-06-59-17.csv';

    if (!file_exists($file_path)) {
        die("Error: File not found at " . $file_path);
    }

    $file = fopen($file_path, "r");
    if ($file === false) {
        die("Error: Unable to open file");
    }

    try {
        $redirect_inserts = 0;
        $flag_rule_inserts = 0;
        $row_number = 0;

        while (($data = fgetcsv($file, 0, "|")) !== false) {
            $row_number++;
            if (empty($data[0]) || empty($data[1]) || empty($data[2])) {
                echo "Row {$row_number}: Skipping row due to missing data: " . implode(", ", $data) . "<br>";
                continue;
            }

            $wpdb->query('START TRANSACTION');

            try {
                $redirect_result = $wpdb->insert(
                    'redirect_rules',
                    array(
                        'website_id' => $website_id,
                        'description' => sanitize_text_field($data[0]),
                        'from_url_regex' => sanitize_text_field($data[1]),
                        'to_url' => sanitize_text_field($data[2]),
                        'last_modified_date' => date('Y-m-d H:i:s')
                    )
                );

                if ($redirect_result === false) {
                    throw new Exception(" Row {$row_number}: Error inserting redirect: " . $wpdb->last_error);
                }

                $new_redirect_id = $wpdb->insert_id;

                if (!empty($data[3])) {
                    $my_flags = $data[3];
                    $my_flags = str_replace(['[', ']'], '', $my_flags);
                    $my_flags = explode(",", $my_flags);

                    foreach ($my_flags as $x => $y) {
                        $redirect_flag = $y;
                        $flag_id = $wpdb->get_var($wpdb->prepare(
                            "SELECT id FROM redirect_flags WHERE flags = %s",
                            sanitize_text_field($redirect_flag)
                        ));

                        if ($flag_id) {
                            $flag_rule_result = $wpdb->insert(
                                'redirect_flag_rule',
                                array(
                                    'redirect_id' => $new_redirect_id,
                                    'flag_id' => $flag_id
                                )
                            );

                            if ($flag_rule_result === false) {
                                throw new Exception("Error inserting flag rule: " . $wpdb->last_error);
                            }

                            $flag_rule_inserts++;
                        } else {
                            echo "Warning: Flag '" . esc_html($y) . "' not found in test_flags table<br>";
                        }
                    }
                }

                $wpdb->query('COMMIT');
                $redirect_inserts++;
            } catch (Exception $e) {
                $wpdb->query('ROLLBACK');
                echo "Error processing row: " . $e->getMessage() . "<br>";
            }
        }

        echo "<p>Successfully inserted " . $redirect_inserts . " redirects and " .
            $flag_rule_inserts . " flag rules</p>";
    } catch (Exception $e) {
        echo "Error reading CSV: " . $e->getMessage();
    } finally {
        fclose($file);
    }

    echo "<p>CSV processing complete!</p>";
}
