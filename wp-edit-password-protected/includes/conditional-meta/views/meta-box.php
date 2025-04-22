<?php

/**
 * Meta box view for conditional display
 *
 * @package Wp Edit Password Protected
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Get the enable value first
$enable = get_post_meta($post->ID, '_wpepp_conditional_display_enable', true) ?: 'no';
$condition = get_post_meta($post->ID, '_wpepp_conditional_display_condition', true) ?: 'user_logged_in';
$action = get_post_meta($post->ID, '_wpepp_conditional_action', true) ?: 'show';

// Get saved values for specific conditions
$recurring_time_start = get_post_meta($post->ID, '_wpepp_conditional_recurring_time_start', true) ?: '09:00';
$recurring_time_end = get_post_meta($post->ID, '_wpepp_conditional_recurring_time_end', true) ?: '17:00';
$recurring_days = get_post_meta($post->ID, '_wpepp_conditional_recurring_days', true) ?: array();
$browser_types = get_post_meta($post->ID, '_wpepp_conditional_browser_type', true) ?: array();
$url_parameter_name = get_post_meta($post->ID, '_wpepp_conditional_url_parameter_name', true) ?: '';
$url_parameter_value = get_post_meta($post->ID, '_wpepp_conditional_url_parameter_value', true) ?: '';
$referrer_source = get_post_meta($post->ID, '_wpepp_conditional_referrer_source', true) ?: '';
$post_types = get_post_meta($post->ID, '_wpepp_conditional_post_type', true) ?: array();
$user_roles = get_post_meta($post->ID, '_wpepp_conditional_user_role', true) ?: array();
$device_type = get_post_meta($post->ID, '_wpepp_conditional_device_type', true) ?: 'mobile';
$day_of_week = get_post_meta($post->ID, '_wpepp_conditional_day_of_week', true) ?: array();
$time_start = get_post_meta($post->ID, '_wpepp_conditional_time_start', true) ?: '09:00';
$time_end = get_post_meta($post->ID, '_wpepp_conditional_time_end', true) ?: '17:00';
$date_start = get_post_meta($post->ID, '_wpepp_conditional_date_start', true) ?: date('Y-m-d');
$date_end = get_post_meta($post->ID, '_wpepp_conditional_date_end', true) ?: date('Y-m-d', strtotime('+7 days'));

// Get title and featured image control values
$control_title = get_post_meta($post->ID, '_wpepp_conditional_control_title', true) ?: 'no';
$control_featured_image = get_post_meta($post->ID, '_wpepp_conditional_control_featured_image', true) ?: 'no';

// Add metabox-specific wrapper class
wp_nonce_field('wpepp_conditional_meta_box', 'wpepp_conditional_meta_box_nonce');
?>

<div class="wpepp-conditional-meta-box-wrapper">
    <div class="wpepp-conditional-enable">
        <label>
            <input type="checkbox" name="wpepp_conditional_display_enable" value="yes" <?php checked('yes', $enable); ?> />
            <?php esc_html_e('Enable Conditional Display', 'wp-edit-password-protected'); ?>
        </label>
    </div>

    <div class="wpepp-conditional-options" <?php echo 'yes' !== $enable ? 'style="display:none;"' : ''; ?>>
        <p class="wpepp-notice">
            <?php esc_html_e('Note: Conditions are applied on the frontend only.', 'wp-edit-password-protected'); ?>
        </p>

        <!-- After the enable checkbox and before the condition selection -->
        <div class="wpepp-conditional-elements">
            <p><strong><?php esc_html_e('Apply to:', 'wp-edit-password-protected'); ?></strong></p>
            <label>
                <input type="checkbox" name="wpepp_conditional_control_title" value="yes" <?php checked('yes', $control_title); ?> />
                <?php esc_html_e('Post Title', 'wp-edit-password-protected'); ?>
            </label>
            <br>
            <label>
                <input type="checkbox" name="wpepp_conditional_control_featured_image" value="yes" <?php checked('yes', $control_featured_image); ?> />
                <?php esc_html_e('Featured Image', 'wp-edit-password-protected'); ?>
            </label>
            <br>
            <p class="wpepp-notice-small">
                <strong><?php esc_html_e('Content is always controlled.', 'wp-edit-password-protected'); ?></strong>
            </p>
        </div>

        <div class="wpepp-conditional-row">
            <label for="wpepp_conditional_display_condition">
                <?php esc_html_e('Display When', 'wp-edit-password-protected'); ?>
            </label>
            <select name="wpepp_conditional_display_condition" id="wpepp_conditional_display_condition">
                <option value="user_logged_in" <?php selected('user_logged_in', $condition); ?>>
                    <?php esc_html_e('User is logged in', 'wp-edit-password-protected'); ?>
                </option>
                <option value="user_logged_out" <?php selected('user_logged_out', $condition); ?>>
                    <?php esc_html_e('User is logged out', 'wp-edit-password-protected'); ?>
                </option>
                <!-- <option value="user_role" <?php selected('user_role', $condition); ?>>
                    <?php esc_html_e('User has specific role', 'wp-edit-password-protected'); ?>
                </option>
                <option value="device_type" <?php selected('device_type', $condition); ?>>
                    <?php esc_html_e('Device type is', 'wp-edit-password-protected'); ?>
                </option>
                <option value="day_of_week" <?php selected('day_of_week', $condition); ?>>
                    <?php esc_html_e('Day of week is', 'wp-edit-password-protected'); ?>
                </option>
                <option value="time_of_day" <?php selected('time_of_day', $condition); ?>>
                    <?php esc_html_e('Time is between', 'wp-edit-password-protected'); ?>
                </option>
                <option value="date_range" <?php selected('date_range', $condition); ?>>
                    <?php esc_html_e('Date is between', 'wp-edit-password-protected'); ?>
                </option>
                <option value="recurring_schedule" <?php selected('recurring_schedule', $condition); ?>>
                    <?php esc_html_e('Recurring schedule', 'wp-edit-password-protected'); ?>
                </option>
                <option value="post_type" <?php selected('post_type', $condition); ?>>
                    <?php esc_html_e('Current post type is', 'wp-edit-password-protected'); ?>
                </option>
                <option value="browser_type" <?php selected('browser_type', $condition); ?>>
                    <?php esc_html_e('Browser is', 'wp-edit-password-protected'); ?>
                </option>
                <option value="url_parameter" <?php selected('url_parameter', $condition); ?>>
                    <?php esc_html_e('URL parameter exists', 'wp-edit-password-protected'); ?>
                </option>
                <option value="referrer_source" <?php selected('referrer_source', $condition); ?>>
                    <?php esc_html_e('Visitor came from', 'wp-edit-password-protected'); ?>
                </option> -->
            </select>
        </div>

        <p class="description">
            <?php esc_html_e('Choose whether to show or hide the password protected content when the condition is met.', 'wp-edit-password-protected'); ?>
        </p>
    </div>

    <!-- User Role Condition -->
    <div class="wpepp-condition-fields wpepp-condition-user_role" <?php echo 'user_role' !== $condition ? 'style="display:none;"' : ''; ?>>
        <div class="wpepp-conditional-row">
            <label for="wpepp_conditional_user_role">
                <?php esc_html_e('Select Role', 'wp-edit-password-protected'); ?>
            </label>
            <select name="wpepp_conditional_user_role[]" id="wpepp_conditional_user_role" multiple="multiple" style="width:100%">
                <?php
                $role_options = method_exists('WPEPP_Conditional_Meta', 'get_user_roles') ?
                    (new WPEPP_Conditional_Meta())->get_user_roles() :
                    array(
                        'administrator' => __('Administrator', 'wp-edit-password-protected'),
                        'editor' => __('Editor', 'wp-edit-password-protected'),
                        'author' => __('Author', 'wp-edit-password-protected'),
                        'contributor' => __('Contributor', 'wp-edit-password-protected'),
                        'subscriber' => __('Subscriber', 'wp-edit-password-protected')
                    );

                foreach ($role_options as $value => $label) {
                    $selected = in_array($value, (array) $user_roles) ? 'selected="selected"' : '';
                    echo '<option value="' . esc_attr($value) . '" ' . $selected . '>' . esc_html($label) . '</option>';
                }
                ?>
            </select>
        </div>
    </div>

    <!-- Device Type Condition -->
    <div class="wpepp-condition-fields wpepp-condition-device_type" <?php echo 'device_type' !== $condition ? 'style="display:none;"' : ''; ?>>
        <div class="wpepp-conditional-row">
            <label for="wpepp_conditional_device_type">
                <?php esc_html_e('Select Device', 'wp-edit-password-protected'); ?>
            </label>
            <select name="wpepp_conditional_device_type" id="wpepp_conditional_device_type">
                <option value="desktop" <?php selected('desktop', $device_type); ?>>
                    <?php esc_html_e('Desktop', 'wp-edit-password-protected'); ?>
                </option>
                <option value="tablet" <?php selected('tablet', $device_type); ?>>
                    <?php esc_html_e('Tablet', 'wp-edit-password-protected'); ?>
                </option>
                <option value="mobile" <?php selected('mobile', $device_type); ?>>
                    <?php esc_html_e('Mobile', 'wp-edit-password-protected'); ?>
                </option>
            </select>
        </div>
    </div>

    <!-- Day of Week Condition -->
    <div class="wpepp-condition-fields wpepp-condition-day_of_week" <?php echo 'day_of_week' !== $condition ? 'style="display:none;"' : ''; ?>>
        <div class="wpepp-conditional-row">
            <label for="wpepp_conditional_day_of_week">
                <?php esc_html_e('Select Days', 'wp-edit-password-protected'); ?>
            </label>
            <select name="wpepp_conditional_day_of_week[]" id="wpepp_conditional_day_of_week" multiple="multiple" style="width:100%">
                <option value="1" <?php echo in_array('1', (array) $day_of_week) ? 'selected="selected"' : ''; ?>>
                    <?php esc_html_e('Monday', 'wp-edit-password-protected'); ?>
                </option>
                <option value="2" <?php echo in_array('2', (array) $day_of_week) ? 'selected="selected"' : ''; ?>>
                    <?php esc_html_e('Tuesday', 'wp-edit-password-protected'); ?>
                </option>
                <option value="3" <?php echo in_array('3', (array) $day_of_week) ? 'selected="selected"' : ''; ?>>
                    <?php esc_html_e('Wednesday', 'wp-edit-password-protected'); ?>
                </option>
                <option value="4" <?php echo in_array('4', (array) $day_of_week) ? 'selected="selected"' : ''; ?>>
                    <?php esc_html_e('Thursday', 'wp-edit-password-protected'); ?>
                </option>
                <option value="5" <?php echo in_array('5', (array) $day_of_week) ? 'selected="selected"' : ''; ?>>
                    <?php esc_html_e('Friday', 'wp-edit-password-protected'); ?>
                </option>
                <option value="6" <?php echo in_array('6', (array) $day_of_week) ? 'selected="selected"' : ''; ?>>
                    <?php esc_html_e('Saturday', 'wp-edit-password-protected'); ?>
                </option>
                <option value="0" <?php echo in_array('0', (array) $day_of_week) ? 'selected="selected"' : ''; ?>>
                    <?php esc_html_e('Sunday', 'wp-edit-password-protected'); ?>
                </option>
            </select>
        </div>
    </div>

    <!-- Time of Day Condition -->
    <div class="wpepp-condition-fields wpepp-condition-time_of_day" <?php echo 'time_of_day' !== $condition ? 'style="display:none;"' : ''; ?>>
        <div class="wpepp-conditional-row">
            <label for="wpepp_conditional_time_start">
                <?php esc_html_e('Start Time', 'wp-edit-password-protected'); ?>
            </label>
            <input type="time" name="wpepp_conditional_time_start" id="wpepp_conditional_time_start" value="<?php echo esc_attr($time_start); ?>" />
        </div>
        <div class="wpepp-conditional-row">
            <label for="wpepp_conditional_time_end">
                <?php esc_html_e('End Time', 'wp-edit-password-protected'); ?>
            </label>
            <input type="time" name="wpepp_conditional_time_end" id="wpepp_conditional_time_end" value="<?php echo esc_attr($time_end); ?>" />
        </div>
    </div>

    <!-- Date Range Condition -->
    <div class="wpepp-condition-fields wpepp-condition-date_range" <?php echo 'date_range' !== $condition ? 'style="display:none;"' : ''; ?>>
        <div class="wpepp-conditional-row">
            <label for="wpepp_conditional_date_start">
                <?php esc_html_e('Start Date', 'wp-edit-password-protected'); ?>
            </label>
            <input type="date" name="wpepp_conditional_date_start" id="wpepp_conditional_date_start" value="<?php echo esc_attr($date_start); ?>" />
        </div>
        <div class="wpepp-conditional-row">
            <label for="wpepp_conditional_date_end">
                <?php esc_html_e('End Date', 'wp-edit-password-protected'); ?>
            </label>
            <input type="date" name="wpepp_conditional_date_end" id="wpepp_conditional_date_end" value="<?php echo esc_attr($date_end); ?>" />
        </div>
    </div>

    <!-- Recurring Schedule Condition -->
    <div class="wpepp-condition-fields wpepp-condition-recurring_schedule" <?php echo 'recurring_schedule' !== $condition ? 'style="display:none;"' : ''; ?>>
        <div class="wpepp-conditional-row">
            <label for="wpepp_conditional_recurring_days">
                <?php esc_html_e('Select Days', 'wp-edit-password-protected'); ?>
            </label>
            <select name="wpepp_conditional_recurring_days[]" id="wpepp_conditional_recurring_days" multiple="multiple" style="width:100%">
                <option value="1" <?php echo in_array('1', (array) $recurring_days) ? 'selected="selected"' : ''; ?>>
                    <?php esc_html_e('Monday', 'wp-edit-password-protected'); ?>
                </option>
                <option value="2" <?php echo in_array('2', (array) $recurring_days) ? 'selected="selected"' : ''; ?>>
                    <?php esc_html_e('Tuesday', 'wp-edit-password-protected'); ?>
                </option>
                <option value="3" <?php echo in_array('3', (array) $recurring_days) ? 'selected="selected"' : ''; ?>>
                    <?php esc_html_e('Wednesday', 'wp-edit-password-protected'); ?>
                </option>
                <option value="4" <?php echo in_array('4', (array) $recurring_days) ? 'selected="selected"' : ''; ?>>
                    <?php esc_html_e('Thursday', 'wp-edit-password-protected'); ?>
                </option>
                <option value="5" <?php echo in_array('5', (array) $recurring_days) ? 'selected="selected"' : ''; ?>>
                    <?php esc_html_e('Friday', 'wp-edit-password-protected'); ?>
                </option>
                <option value="6" <?php echo in_array('6', (array) $recurring_days) ? 'selected="selected"' : ''; ?>>
                    <?php esc_html_e('Saturday', 'wp-edit-password-protected'); ?>
                </option>
                <option value="0" <?php echo in_array('0', (array) $recurring_days) ? 'selected="selected"' : ''; ?>>
                    <?php esc_html_e('Sunday', 'wp-edit-password-protected'); ?>
                </option>
            </select>
        </div>
        <div class="wpepp-conditional-row">
            <label for="wpepp_conditional_recurring_time_start">
                <?php esc_html_e('Start Time', 'wp-edit-password-protected'); ?>
            </label>
            <input type="time" name="wpepp_conditional_recurring_time_start" id="wpepp_conditional_recurring_time_start" value="<?php echo esc_attr($recurring_time_start); ?>" />
        </div>
        <div class="wpepp-conditional-row">
            <label for="wpepp_conditional_recurring_time_end">
                <?php esc_html_e('End Time', 'wp-edit-password-protected'); ?>
            </label>
            <input type="time" name="wpepp_conditional_recurring_time_end" id="wpepp_conditional_recurring_time_end" value="<?php echo esc_attr($recurring_time_end); ?>" />
        </div>
    </div>

    <!-- Post Type Condition -->
    <div class="wpepp-condition-fields wpepp-condition-post_type" <?php echo 'post_type' !== $condition ? 'style="display:none;"' : ''; ?>>
        <div class="wpepp-conditional-row">
            <label for="wpepp_conditional_post_type">
                <?php esc_html_e('Select Post Types', 'wp-edit-password-protected'); ?>
            </label>
            <select name="wpepp_conditional_post_type[]" id="wpepp_conditional_post_type" multiple="multiple" style="width:100%">
                <?php
                $available_post_types = get_post_types(array('public' => true), 'objects');
                foreach ($available_post_types as $post_type_obj) {
                    $selected = in_array($post_type_obj->name, (array) $post_types) ? 'selected="selected"' : '';
                    echo '<option value="' . esc_attr($post_type_obj->name) . '" ' . $selected . '>' . esc_html($post_type_obj->label) . '</option>';
                }
                ?>
            </select>
        </div>
    </div>

    <!-- Browser Type Condition -->
    <div class="wpepp-condition-fields wpepp-condition-browser_type" <?php echo 'browser_type' !== $condition ? 'style="display:none;"' : ''; ?>>
        <div class="wpepp-conditional-row">
            <label for="wpepp_conditional_browser_type">
                <?php esc_html_e('Select Browsers', 'wp-edit-password-protected'); ?>
            </label>
            <select name="wpepp_conditional_browser_type[]" id="wpepp_conditional_browser_type" multiple="multiple" style="width:100%">
                <option value="chrome" <?php echo in_array('chrome', (array) $browser_types) ? 'selected="selected"' : ''; ?>>
                    <?php esc_html_e('Chrome', 'wp-edit-password-protected'); ?>
                </option>
                <option value="firefox" <?php echo in_array('firefox', (array) $browser_types) ? 'selected="selected"' : ''; ?>>
                    <?php esc_html_e('Firefox', 'wp-edit-password-protected'); ?>
                </option>
                <option value="safari" <?php echo in_array('safari', (array) $browser_types) ? 'selected="selected"' : ''; ?>>
                    <?php esc_html_e('Safari', 'wp-edit-password-protected'); ?>
                </option>
                <option value="edge" <?php echo in_array('edge', (array) $browser_types) ? 'selected="selected"' : ''; ?>>
                    <?php esc_html_e('Edge', 'wp-edit-password-protected'); ?>
                </option>
                <option value="opera" <?php echo in_array('opera', (array) $browser_types) ? 'selected="selected"' : ''; ?>>
                    <?php esc_html_e('Opera', 'wp-edit-password-protected'); ?>
                </option>
                <option value="ie" <?php echo in_array('ie', (array) $browser_types) ? 'selected="selected"' : ''; ?>>
                    <?php esc_html_e('IE', 'wp-edit-password-protected'); ?>
                </option>
            </select>
        </div>
    </div>

    <!-- URL Parameter Condition -->
    <div class="wpepp-condition-fields wpepp-condition-url_parameter" <?php echo 'url_parameter' !== $condition ? 'style="display:none;"' : ''; ?>>
        <div class="wpepp-conditional-row">
            <label for="wpepp_conditional_url_parameter_name">
                <?php esc_html_e('Parameter Name', 'wp-edit-password-protected'); ?>
            </label>
            <input type="text" name="wpepp_conditional_url_parameter_name" id="wpepp_conditional_url_parameter_name" value="<?php echo esc_attr($url_parameter_name); ?>" placeholder="param" />
        </div>
        <div class="wpepp-conditional-row">
            <label for="wpepp_conditional_url_parameter_value">
                <?php esc_html_e('Parameter Value', 'wp-edit-password-protected'); ?>
            </label>
            <input type="text" name="wpepp_conditional_url_parameter_value" id="wpepp_conditional_url_parameter_value" value="<?php echo esc_attr($url_parameter_value); ?>" placeholder="value" />
        </div>
    </div>

    <!-- Referrer Source Condition -->
    <div class="wpepp-condition-fields wpepp-condition-referrer_source" <?php echo 'referrer_source' !== $condition ? 'style="display:none;"' : ''; ?>>
        <div class="wpepp-conditional-row">
            <label for="wpepp_conditional_referrer_source">
                <?php esc_html_e('Referrer Contains', 'wp-edit-password-protected'); ?>
            </label>
            <input type="text" name="wpepp_conditional_referrer_source" id="wpepp_conditional_referrer_source" value="<?php echo esc_attr($referrer_source); ?>" placeholder="google.com" />
        </div>
    </div>

    <!-- Action Selection -->
    <div class="wpepp-conditional-row wpepp-action-row">
        <label for="wpepp_conditional_action">
            <?php esc_html_e('Action', 'wp-edit-password-protected'); ?>
        </label>
        <select name="wpepp_conditional_action" id="wpepp_conditional_action">
            <option value="show" <?php selected('show', $action); ?>>
                <?php esc_html_e('Show Element', 'wp-edit-password-protected'); ?>
            </option>
            <option value="hide" <?php selected('hide', $action); ?>>
                <?php esc_html_e('Hide Element', 'wp-edit-password-protected'); ?>
            </option>
        </select>
    </div>
</div>