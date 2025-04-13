<?php
// Path to the global state file
define('LOTTERY_STATE_FILE', __DIR__ . '/../lottery_state.json');

// Read the global lottery state from file
function get_lottery_state() {
    if (!file_exists(LOTTERY_STATE_FILE)) {
        $default = [
            'generated_numbers' => [],
            'admin_next_numbers' => [],
        ];
        file_put_contents(LOTTERY_STATE_FILE, json_encode($default));
        return $default;
    }
    $json = file_get_contents(LOTTERY_STATE_FILE);
    $state = json_decode($json, true);
    if (!is_array($state)) {
        $state = [
            'generated_numbers' => [],
            'admin_next_numbers' => [],
        ];
    }
    return $state;
}

// Save the global lottery state to file
function set_lottery_state($state) {
    file_put_contents(LOTTERY_STATE_FILE, json_encode($state));
}

// Get generated numbers (global)
function get_generated_numbers() {
    $state = get_lottery_state();
    return isset($state['generated_numbers']) ? $state['generated_numbers'] : [];
}

// Set generated numbers (global)
function set_generated_numbers($numbers) {
    $state = get_lottery_state();
    $state['generated_numbers'] = $numbers;
    set_lottery_state($state);
}

// Get admin override sequence (global)
function get_admin_next_numbers() {
    $state = get_lottery_state();
    return isset($state['admin_next_numbers']) ? $state['admin_next_numbers'] : [];
}

// Set admin override sequence (global)
function set_admin_next_numbers($numbers) {
    $state = get_lottery_state();
    $state['admin_next_numbers'] = $numbers;
    set_lottery_state($state);
}