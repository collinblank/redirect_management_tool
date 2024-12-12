<?php

function commit_rules_to_file($website_id, $item_id = null)
{
    global $wpdb;

    try {
        $website = $wpdb->get_row($wpdb->prepare("SELECT * FROM websites WHERE id = %d", $website_id), ARRAY_A);

        if (!$website) {
            throw new Exception("Failed to find the website record in the database.");
        }

        $redirects_sql = isset($item_id)
            ? $wpdb->prepare("SELECT * FROM redirect_rules WHERE website_id = %d AND ((disabled = %d AND committed = %d) OR id = %d) ORDER BY id", $website_id, 0, 1, $item_id)
            : $wpdb->prepare("SELECT * FROM redirect_rules WHERE website_id = %d AND disabled = %d ORDER BY id", $website_id, 0);
        $redirect_rules = $wpdb->get_results($redirects_sql, ARRAY_A);

        if (empty($redirect_rules)) {
            throw new Exception("No redirect rules exist for this website.");
        }

        $website_slug = sanitize_title($website['name']);
        $current_timestamp = date('Y-m-d H:i:s');

        $new_redirects_file = fopen(get_template_directory() . "/storage/new-redirects/{$website_slug}.txt", "w");

        if ($new_redirects_file) {
            // write the file function
            $server_name = $wpdb->get_var($wpdb->prepare("SELECT name FROM servers WHERE id = %d", $website['server_id']));
            $base_domain = preg_replace("/^(https?:\/\/)?(www\.)?|\/$/", '', $website['domain']);

            $header_content = sprintf("#Server: %s\n#Domain: %s\n#Timestamp: %s\n#Begin Rewrite Rules - DO NOT EDIT\n", $server_name, $base_domain, $current_timestamp);
            fwrite($new_redirects_file, $header_content);

            foreach ($redirect_rules as $rule) {
                $rule_content = ($rule['name'] ? "#{$rule['name']}\n" : '') . "RewriteRule {$rule['from_url_regex']} {$rule['to_url']}\n";
                fwrite($new_redirects_file, $rule_content);
            }

            fwrite($new_redirects_file, "#End Rewrite Rules - DO NOT EDIT\n");
            fclose($new_redirects_file);


            $wpdb->query('START TRANSACTION');

            // update database function
            $update_where = isset($item_id) ? array('id' => $item_id) : array('disabled' => 0);
            $updated_rows = $wpdb->update(
                'redirect_rules', // Table name
                array('committed' => 1), // Data to update
                $update_where,
                array('%d'), // Data format for committed (1 for integer)
                array('%d')  // Format for where clause
            );

            if (!empty($wpdb->last_error)) {
                throw new Exception("Database error: " . $wpdb->last_error);
            }

            // check status files function
            $status_files = [
                'nack' => get_template_directory() . "/storage/status/{$website_slug}.txt.nack",
                'ack' => get_template_directory() . "/storage/status/{$website_slug}.txt.ack"
            ];

            if (file_exists($status_files['nack'])) {
                $nack_file = file($status_files['nack'], FILE_IGNORE_NEW_LINES);
                $error = trim(str_replace("Error: ", "", $nack_file[1]));
                rename($status_files['nack'], get_template_directory() . "/storage/status/history/{$website_slug}.txt.nack");
                throw new Exception($error ?? 'Unknown processing error.');
            }

            if (!file_exists($status_files['ack'])) {
                throw new Exception('Processing acknowledgment not found.');
            }

            $wpdb->query('COMMIT');
            rename($status_files['ack'], get_template_directory() . "/storage/status/history/{$website_slug}.txt.ack");
            return ["committed" => $updated_rows];
        }
    } catch (Exception $e) {
        $wpdb->query('ROLLBACK');
        return ["errors" => ["Unable to commit the rule(s) to the website's .htaccess file. Please address the following errors and/or try to commit the rule(s) again:", $e->getMessage()]];
    }
}
