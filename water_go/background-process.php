<?php

// Load WordPress
require_once('wp-load.php');

// Retrieve job data from the options table
$job_data = get_option('my_background_job_data', array());

if (!empty($job_data) && $job_data['task'] === 'check_database') {
    // Your background database checking logic here
    // For example, check for records in the database that have expired

    // Clear the stored job data
    delete_option('my_background_job_data');
}