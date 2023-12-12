<?php 

/**
 * @access THIS IS NOT A PAGE - USEING FOR SERVICES
 */

$worker = new GearmanWorker();
$worker->addServer();

$start_time = time();
$max_runtime = 3600; // 60 minutes


// Function to process the order
$worker->addFunction("process_order", function ($job) use ($start_time, $max_runtime) {

   $order_id = $job->payload;
   $current_time = time();

   // Check MySQL every 3-5 minutes until 60 minutes
   // if (($current_time - $start_time) <= $max_runtime) {
      
   //    sleep(180);
   //    error_log("Checking MySQL for order_id: $order_id");
   // } else {
   //    // If 60 minutes have passed, stop the worker
   //    return GearmanWorker::WORKER_RETURN;
   // }

   return "Order processing completed for order_id: $order_id";
});

// Run the worker continuously
while (true) {
    $worker->work();
}
