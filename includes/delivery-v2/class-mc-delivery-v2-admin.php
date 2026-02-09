<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'MC_Delivery_V2_Admin' ) ) {
    class MC_Delivery_V2_Admin {
        public static function register_menu() {
            add_menu_page(
                'Order Delivery Matrix',
                'Order Delivery Matrix',
                'manage_options',
                'mc_delivery_matrix_v2',
                array( __CLASS__, 'render_matrix_page' ),
                'dashicons-location-alt',
                57
            );

            add_submenu_page(
                'mc_delivery_matrix_v2',
                'Matrix',
                'Matrix',
                'manage_options',
                'mc_delivery_matrix_v2',
                array( __CLASS__, 'render_matrix_page' )
            );

            add_submenu_page(
                'mc_delivery_matrix_v2',
                'Woo Mapping',
                'Woo Mapping',
                'manage_options',
                'mc_delivery_mapping_v2',
                array( __CLASS__, 'render_mapping_page' )
            );

            add_submenu_page(
                'mc_delivery_matrix_v2',
                'Cut-off Rules',
                'Cut-off Rules',
                'manage_options',
                'mc_delivery_cutoff_v2',
                array( __CLASS__, 'render_cutoff_page' )
            );

            add_submenu_page(
                'mc_delivery_matrix_v2',
                'Diagnostics',
                'Diagnostics',
                'manage_options',
                'mc_delivery_diagnostics_v2',
                array( __CLASS__, 'render_diagnostics_page' )
            );
        }

        public static function render_matrix_page() {
            $flags             = MC_Delivery_V2_Options::get_flags_option();
            $matrix            = MC_Delivery_V2_Options::get_matrix_option();
            $scenario_labels   = MC_Delivery_V2_Options::get_scenario_labels();
            $method_labels     = MC_Delivery_V2_Options::get_method_labels();
            $runtime_mode_opts = MC_Delivery_V2_Options::get_runtime_mode_labels();
            $rows              = isset( $matrix['rows'] ) && is_array( $matrix['rows'] ) ? $matrix['rows'] : array();
            ?>
            <div class="wrap">
                <h1>Order Delivery Matrix - V2</h1>
                <?php self::render_tabs( 'mc_delivery_matrix_v2' ); ?>

                <p>
                    V2 skeleton is active. Legacy checkout behavior remains untouched while runtime mode is set to <strong>Legacy</strong>.
                </p>

                <?php settings_errors( MC_Delivery_V2_Options::OPTION_FLAGS ); ?>
                <form method="post" action="options.php">
                    <?php settings_fields( 'mc_delivery_matrix_v2_flags' ); ?>
                    <table class="form-table" role="presentation">
                        <tr>
                            <th scope="row"><label for="mc_delivery_flags_runtime_mode">Runtime mode</label></th>
                            <td>
                                <select id="mc_delivery_flags_runtime_mode" name="<?php echo esc_attr( MC_Delivery_V2_Options::OPTION_FLAGS ); ?>[runtime_mode]">
                                    <?php foreach ( $runtime_mode_opts as $mode_key => $mode_label ) : ?>
                                        <option value="<?php echo esc_attr( $mode_key ); ?>" <?php selected( $flags['runtime_mode'], $mode_key ); ?>>
                                            <?php echo esc_html( $mode_label ); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="mc_delivery_flags_canary_percentage">Canary percentage</label></th>
                            <td>
                                <input
                                    id="mc_delivery_flags_canary_percentage"
                                    name="<?php echo esc_attr( MC_Delivery_V2_Options::OPTION_FLAGS ); ?>[canary_percentage]"
                                    type="number"
                                    min="0"
                                    max="100"
                                    value="<?php echo esc_attr( isset( $flags['canary_percentage'] ) ? $flags['canary_percentage'] : 0 ); ?>"
                                />
                                <p class="description">Used only when runtime mode is Canary V2.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="mc_delivery_flags_canary_user_ids_raw">Canary admin/test user IDs</label></th>
                            <td>
                                <input
                                    id="mc_delivery_flags_canary_user_ids_raw"
                                    name="<?php echo esc_attr( MC_Delivery_V2_Options::OPTION_FLAGS ); ?>[canary_user_ids_raw]"
                                    type="text"
                                    class="regular-text"
                                    value="<?php echo esc_attr( implode( ',', isset( $flags['canary_user_ids'] ) ? $flags['canary_user_ids'] : array() ) ); ?>"
                                />
                                <p class="description">Comma-separated user IDs. Example: 1,42,85</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="mc_delivery_flags_enable_admin_preview">Admin preview</label></th>
                            <td>
                                <label>
                                    <input
                                        id="mc_delivery_flags_enable_admin_preview"
                                        name="<?php echo esc_attr( MC_Delivery_V2_Options::OPTION_FLAGS ); ?>[enable_admin_preview]"
                                        type="checkbox"
                                        value="1"
                                        <?php checked( ! empty( $flags['enable_admin_preview'] ) ); ?>
                                    />
                                    Allow admin users to preview V2 in future rollout stages.
                                </label>
                            </td>
                        </tr>
                    </table>
                    <?php submit_button( 'Save Runtime Flags' ); ?>
                </form>

                <h2>Matrix Rows</h2>
                <p>Configure checkout label, delivery promise, order, enable state, and default per scenario. One enabled default per scenario is required and auto-corrected on save if needed.</p>

                <?php settings_errors( MC_Delivery_V2_Options::OPTION_MATRIX ); ?>
                <form method="post" action="options.php">
                    <?php settings_fields( 'mc_delivery_matrix_v2_matrix' ); ?>
                    <table class="widefat striped">
                        <thead>
                            <tr>
                                <th>Scenario</th>
                                <th>Method</th>
                                <th>Enabled</th>
                                <th>Default</th>
                                <th>Sort</th>
                                <th>Checkout Title</th>
                                <th>Delivery Promise</th>
                                <th>Expected Price</th>
                                <th>Cut-off Rule</th>
                                <th>Resolved Rate ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ( empty( $rows ) ) : ?>
                                <tr>
                                    <td colspan="10">No matrix rows available.</td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ( $rows as $row_index => $row ) : ?>
                                    <?php
                                    $scenario_key = isset( $row['scenario_key'] ) ? $row['scenario_key'] : '';
                                    $method_key   = isset( $row['method_key'] ) ? $row['method_key'] : '';
                                    $base_name    = MC_Delivery_V2_Options::OPTION_MATRIX . '[rows][' . $row_index . ']';
                                    $allowed_countries = isset( $row['allowed_countries'] ) && is_array( $row['allowed_countries'] ) ? $row['allowed_countries'] : array( 'NL' );
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo esc_html( isset( $scenario_labels[ $scenario_key ] ) ? $scenario_labels[ $scenario_key ] : $scenario_key ); ?>
                                            <input type="hidden" name="<?php echo esc_attr( $base_name ); ?>[scenario_key]" value="<?php echo esc_attr( $scenario_key ); ?>" />
                                            <?php foreach ( $allowed_countries as $country_code ) : ?>
                                                <input type="hidden" name="<?php echo esc_attr( $base_name ); ?>[allowed_countries][]" value="<?php echo esc_attr( $country_code ); ?>" />
                                            <?php endforeach; ?>
                                        </td>
                                        <td>
                                            <?php echo esc_html( isset( $method_labels[ $method_key ] ) ? $method_labels[ $method_key ] : $method_key ); ?>
                                            <input type="hidden" name="<?php echo esc_attr( $base_name ); ?>[method_key]" value="<?php echo esc_attr( $method_key ); ?>" />
                                        </td>
                                        <td>
                                            <label>
                                                <input
                                                    type="checkbox"
                                                    name="<?php echo esc_attr( $base_name ); ?>[enabled]"
                                                    value="1"
                                                    <?php checked( ! empty( $row['enabled'] ) ); ?>
                                                />
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                <input
                                                    type="checkbox"
                                                    name="<?php echo esc_attr( $base_name ); ?>[is_default]"
                                                    value="1"
                                                    <?php checked( ! empty( $row['is_default'] ) ); ?>
                                                />
                                            </label>
                                        </td>
                                        <td>
                                            <input
                                                type="number"
                                                class="small-text"
                                                name="<?php echo esc_attr( $base_name ); ?>[sort_order]"
                                                value="<?php echo esc_attr( isset( $row['sort_order'] ) ? intval( $row['sort_order'] ) : 0 ); ?>"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="regular-text"
                                                name="<?php echo esc_attr( $base_name ); ?>[title_checkout]"
                                                value="<?php echo esc_attr( isset( $row['title_checkout'] ) ? $row['title_checkout'] : '' ); ?>"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="regular-text"
                                                name="<?php echo esc_attr( $base_name ); ?>[delivery_promise_text]"
                                                value="<?php echo esc_attr( isset( $row['delivery_promise_text'] ) ? $row['delivery_promise_text'] : '' ); ?>"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="small-text"
                                                name="<?php echo esc_attr( $base_name ); ?>[price_expected]"
                                                value="<?php echo esc_attr( isset( $row['price_expected'] ) ? $row['price_expected'] : '' ); ?>"
                                            />
                                        </td>
                                        <td>
                                            <?php echo esc_html( isset( $row['cutoff_rule_key'] ) ? $row['cutoff_rule_key'] : '' ); ?>
                                            <input type="hidden" name="<?php echo esc_attr( $base_name ); ?>[cutoff_rule_key]" value="<?php echo esc_attr( isset( $row['cutoff_rule_key'] ) ? $row['cutoff_rule_key'] : '' ); ?>" />
                                        </td>
                                        <td>
                                            <?php echo esc_html( isset( $row['resolved_rate_id'] ) ? $row['resolved_rate_id'] : '' ); ?>
                                            <input type="hidden" name="<?php echo esc_attr( $base_name ); ?>[resolved_rate_id]" value="<?php echo esc_attr( isset( $row['resolved_rate_id'] ) ? $row['resolved_rate_id'] : '' ); ?>" />
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <?php submit_button( 'Save Matrix' ); ?>
                </form>

                <h2>Registered Option Keys</h2>
                <ul>
                    <li><code><?php echo esc_html( MC_Delivery_V2_Options::OPTION_MATRIX ); ?></code></li>
                    <li><code><?php echo esc_html( MC_Delivery_V2_Options::OPTION_MAPPING ); ?></code></li>
                    <li><code><?php echo esc_html( MC_Delivery_V2_Options::OPTION_CUTOFF_RULES ); ?></code></li>
                    <li><code><?php echo esc_html( MC_Delivery_V2_Options::OPTION_FLAGS ); ?></code></li>
                </ul>
            </div>
            <?php
        }

        public static function render_mapping_page() {
            $mapping      = MC_Delivery_V2_Options::get_mapping_option();
            $method_labels= MC_Delivery_V2_Options::get_method_labels();
            $rate_choices = MC_Delivery_V2_Mapping_Repo::get_rate_choices();
            $rates        = MC_Delivery_V2_Mapping_Repo::get_available_rates();
            ?>
            <div class="wrap">
                <h1>Order Delivery Matrix - Woo Mapping</h1>
                <?php self::render_tabs( 'mc_delivery_mapping_v2' ); ?>

                <?php settings_errors( MC_Delivery_V2_Options::OPTION_MAPPING ); ?>
                <form method="post" action="options.php">
                    <?php settings_fields( 'mc_delivery_matrix_v2_mapping' ); ?>
                    <table class="form-table" role="presentation">
                        <?php foreach ( $method_labels as $method_key => $method_label ) : ?>
                            <tr>
                                <th scope="row">
                                    <label for="mc_delivery_mapping_<?php echo esc_attr( $method_key ); ?>">
                                        <?php echo esc_html( $method_label ); ?>
                                    </label>
                                </th>
                                <td>
                                    <select
                                        id="mc_delivery_mapping_<?php echo esc_attr( $method_key ); ?>"
                                        name="<?php echo esc_attr( MC_Delivery_V2_Options::OPTION_MAPPING ); ?>[<?php echo esc_attr( $method_key ); ?>]"
                                        class="regular-text"
                                    >
                                        <option value="">-- Not mapped --</option>
                                        <?php foreach ( $rate_choices as $rate_id => $rate_label ) : ?>
                                            <option value="<?php echo esc_attr( $rate_id ); ?>" <?php selected( isset( $mapping[ $method_key ] ) ? $mapping[ $method_key ] : '', $rate_id ); ?>>
                                                <?php echo esc_html( $rate_label ); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php submit_button( 'Save Mapping' ); ?>
                </form>

                <h2>Available Woo Shipping Rates</h2>
                <table class="widefat striped">
                    <thead>
                        <tr>
                            <th>Rate ID</th>
                            <th>Zone</th>
                            <th>Title</th>
                            <th>Method ID</th>
                            <th>Instance ID</th>
                            <th>Enabled</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ( empty( $rates ) ) : ?>
                            <tr>
                                <td colspan="6">No shipping rates discovered. Check WooCommerce shipping zones/methods.</td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ( $rates as $rate ) : ?>
                                <tr>
                                    <td><code><?php echo esc_html( $rate['rate_id'] ); ?></code></td>
                                    <td><?php echo esc_html( $rate['zone_name'] ); ?></td>
                                    <td><?php echo esc_html( $rate['title'] ); ?></td>
                                    <td><?php echo esc_html( $rate['method_id'] ); ?></td>
                                    <td><?php echo esc_html( $rate['instance_id'] ); ?></td>
                                    <td><?php echo $rate['is_enabled'] ? 'Yes' : 'No'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php
        }

        public static function render_cutoff_page() {
            $cutoff_option = MC_Delivery_V2_Options::get_cutoff_rules_option();
            $timezone      = isset( $cutoff_option['timezone'] ) ? $cutoff_option['timezone'] : 'Europe/Amsterdam';
            $rules         = isset( $cutoff_option['rules'] ) && is_array( $cutoff_option['rules'] ) ? $cutoff_option['rules'] : array();
            ?>
            <div class="wrap">
                <h1>Order Delivery Matrix - Cut-off Rules</h1>
                <?php self::render_tabs( 'mc_delivery_cutoff_v2' ); ?>

                <?php settings_errors( MC_Delivery_V2_Options::OPTION_CUTOFF_RULES ); ?>
                <form method="post" action="options.php">
                    <?php settings_fields( 'mc_delivery_matrix_v2_cutoff' ); ?>
                    <table class="form-table" role="presentation">
                        <tr>
                            <th scope="row"><label for="mc_delivery_cutoff_timezone">Timezone</label></th>
                            <td>
                                <?php if ( function_exists( 'wp_timezone_choice' ) ) : ?>
                                    <select
                                        id="mc_delivery_cutoff_timezone"
                                        name="<?php echo esc_attr( MC_Delivery_V2_Options::OPTION_CUTOFF_RULES ); ?>[timezone]"
                                    >
                                        <?php echo wp_timezone_choice( $timezone ); ?>
                                    </select>
                                <?php else : ?>
                                    <input
                                        id="mc_delivery_cutoff_timezone"
                                        type="text"
                                        class="regular-text"
                                        name="<?php echo esc_attr( MC_Delivery_V2_Options::OPTION_CUTOFF_RULES ); ?>[timezone]"
                                        value="<?php echo esc_attr( $timezone ); ?>"
                                    />
                                <?php endif; ?>
                            </td>
                        </tr>

                        <?php foreach ( $rules as $rule_key => $rule ) : ?>
                            <tr>
                                <th scope="row">
                                    <label for="mc_delivery_cutoff_<?php echo esc_attr( $rule_key ); ?>">
                                        <?php echo esc_html( isset( $rule['label'] ) ? $rule['label'] : $rule_key ); ?>
                                    </label>
                                </th>
                                <td>
                                    <input
                                        id="mc_delivery_cutoff_<?php echo esc_attr( $rule_key ); ?>"
                                        type="time"
                                        step="60"
                                        name="<?php echo esc_attr( MC_Delivery_V2_Options::OPTION_CUTOFF_RULES ); ?>[rules][<?php echo esc_attr( $rule_key ); ?>][cutoff]"
                                        value="<?php echo esc_attr( isset( $rule['cutoff'] ) ? $rule['cutoff'] : '' ); ?>"
                                    />
                                    <p class="description">Leave empty if this method group has no customer-facing cut-off.</p>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php submit_button( 'Save Cut-off Rules' ); ?>
                </form>
            </div>
            <?php
        }

        public static function render_diagnostics_page() {
            $checks = MC_Delivery_V2_Diagnostics::collect();
            ?>
            <div class="wrap">
                <h1>Order Delivery Matrix - Diagnostics</h1>
                <?php self::render_tabs( 'mc_delivery_diagnostics_v2' ); ?>

                <table class="widefat striped">
                    <thead>
                        <tr>
                            <th>Check</th>
                            <th>Status</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( $checks as $check ) : ?>
                            <tr>
                                <td><?php echo esc_html( $check['label'] ); ?></td>
                                <td><?php echo esc_html( strtoupper( $check['status'] ) ); ?></td>
                                <td><?php echo esc_html( $check['details'] ); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php
        }

        private static function render_tabs( $current_slug ) {
            $tabs = array(
                'mc_delivery_matrix_v2'      => 'Matrix',
                'mc_delivery_mapping_v2'     => 'Woo Mapping',
                'mc_delivery_cutoff_v2'      => 'Cut-off Rules',
                'mc_delivery_diagnostics_v2' => 'Diagnostics',
            );

            echo '<h2 class="nav-tab-wrapper">';
            foreach ( $tabs as $slug => $label ) {
                $class = $slug === $current_slug ? ' nav-tab nav-tab-active' : ' nav-tab';
                $url   = admin_url( 'admin.php?page=' . $slug );
                echo '<a class="' . esc_attr( $class ) . '" href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
            }
            echo '</h2>';
        }
    }
}
