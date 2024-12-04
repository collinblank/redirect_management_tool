<?php

function commit_rules_to_file($website_id, $item_id = null)
{
    global $wpdb;
    $website = $wpdb->get_row($wpdb->prepare("SELECT * FROM websites WHERE id = %d", $website_id), ARRAY_A);
    $hyphenated_website_name = str_replace(" ", "-", strtolower($website['name']));
    $current_time = date('Y-m-d H:i:s');

    $sql = isset($item_id)
        ? $wpdb->prepare("SELECT * FROM redirect_rules WHERE website_id = %d AND ((disabled = %d AND committed = %d) OR id = %d) ORDER BY id", $website_id, 0, 1, $item_id)
        : $wpdb->prepare("SELECT * FROM redirect_rules WHERE website_id = %d AND disabled != %d ORDER BY id", $website_id, 1);

    $redirect_rules = $wpdb->get_results($sql, ARRAY_A);
    $filepath = get_template_directory() . "/storage/new-redirects/{$hyphenated_website_name}.txt";

    $file = fopen($filepath, "w");

    if (!empty($redirect_rules)) {
        if ($file) {
            $server_name = $wpdb->get_var($wpdb->prepare("SELECT name FROM servers WHERE id = %d", $website['server_id']));
            $website_base_domain = preg_replace("/^(https?:\/\/)?(www\.)?|\/$/", '', $website['domain']);

            fwrite($file, "#Server: {$server_name}\n#Domain: {$website_base_domain}\n#Time: {$current_time}\n#Begin Rewrite Rules - DO NOT EDIT\n");

            foreach ($redirect_rules as $rule) {
                $name_content = $rule['name'] ? "#{$rule['name']}\n" : '';
                $rewrite_rule_content = "RewriteRule {$rule['from_url_regex']} {$rule['to_url']}\n";
                fwrite($file, $name_content . $rewrite_rule_content);
            }

            fwrite($file, "#End Rewrite Rules - DO NOT EDIT\n");
            fclose($file);

            // update committed flag in database
            $update_where = isset($item_id) ? array('id' => $item_id) : array('disabled' => 0);
            $updated_rows = $wpdb->update(
                'redirect_rules', // Table name
                array('committed' => 1), // Data to update
                $update_where, // Where clause (only rows where `disabled` is 0)
                array('%d'), // Data format for committed (1 for integer)
                array('%d')  // Format for where clause
            );

            return ["committed" => $updated_rows];
        } else {
            return ["errors" => "Unable to write rules to file."];
        }
    }
}
