<?php
// Get user input for number of processes
$n = (int) readline("Enter the number of processes: ");

// Initialize process array
$processes = array();

// Get user input for process arrival time and burst time
for ($i = 1; $i <= $n; $i++) {
    $arrival_time = (int) readline("Enter arrival time for process " . $i . ": ");
    $burst_time = (int) readline("Enter burst time for process " . $i . ": ");
    $processes[] = array("process_id" => $i, "arrival_time" => $arrival_time, "burst_time" => $burst_time, "remaining_time" => $burst_time);
}

// Initialize variables for current time and completion time
$current_time = 0;
$completion_time = array();

// Initialize table headers
echo "-----------------------------------------------------------------------" . PHP_EOL;
echo "| Process | Arrival Time | Burst Time | Completion Time | Turnaround Time | Waiting Time |" . PHP_EOL;
echo "-----------------------------------------------------------------------" . PHP_EOL;

// Loop until all processes are complete
while (true) {
    $min_remaining_time = INF;
    $selected_process = -1;

    // Find the process with the shortest remaining burst time
    for ($i = 0; $i < $n; $i++) {
        if ($processes[$i]["arrival_time"] <= $current_time && $processes[$i]["remaining_time"] < $min_remaining_time && $processes[$i]["remaining_time"] > 0) {
            $min_remaining_time = $processes[$i]["remaining_time"];
            $selected_process = $i;
        }
    }

    // Break if all processes are complete
    if ($selected_process == -1) {
        break;
    }

    // Update current time and remaining burst time for selected process
    $current_time += 1;
    $processes[$selected_process]["remaining_time"] -= 1;

    // If the selected process has completed, record its completion time
    if ($processes[$selected_process]["remaining_time"] == 0) {
        $completion_time[$selected_process] = $current_time;
    }

    // Print process information for each second
    //printf("| %-7d | %-12d | %-10d | ", $processes[$selected_process]["process_id"], $processes[$selected_process]["arrival_time"], $processes[$selected_process]["burst_time"]);
    if (isset($completion_time[$selected_process])) {
        printf("| %-7d | %-12d | %-10d | ", $processes[$selected_process]["process_id"], $processes[$selected_process]["arrival_time"], $processes[$selected_process]["burst_time"]);
        printf("%-15d | %-16d | %-12d |", $completion_time[$selected_process], ($completion_time[$selected_process] - $processes[$selected_process]["arrival_time"]), (($completion_time[$selected_process] - $processes[$selected_process]["arrival_time"]) - $processes[$selected_process]["burst_time"]));
        echo PHP_EOL;
    } else {
        //printf("%-15s | %-16s | %-12s |", "-", "-", "-");
    }
}

echo "-----------------------------------------------------------------------" . PHP_EOL;

// Initialize variables for total turnaround time and waiting time
$total_turnaround_time = 0;
$total_waiting_time = 0;

// Calculate turnaround time and waiting time for each process
for ($i = 0; $i < $n; $i++) {
    $turnaround_time = $completion_time[$i] - $processes[$i]["arrival_time"];
    $waiting_time = $turnaround_time - $processes[$i]["burst_time"];
    $total_turnaround_time += $turnaround_time;
    $total_waiting_time += $waiting_time;
}

// Calculate average turnaround time and waiting time
$avg_turnaround_time = $total_turnaround_time / $n;
$avg_waiting_time = $total_waiting_time / $n;

// Print results
echo "Average Turnaround Time: " . $avg_turnaround_time . PHP_EOL;
echo "Average Waiting Time: " . $avg_waiting_time . PHP_EOL;



/*
Some Examples for testing
Process	Arrival time	Burst Time
P1	        0	            6
P2	        1          	    4
P3	        2	            2
P4	        3	            3
The average waiting time is ( 9 +2 + 0 + 4)/4 = 15/4 = 3.75

Process Queue	Burst time	Arrival time
P1	                6          	2
P2	                2          	5
P3	                8       	1
P4	                3       	0
P5	                4          	4

Soloution:
Wait time 
P4= 0-0=0
P1=  (3-2) + 6 =7
P2= 5-5 = 0
P5= 4-4+2 =2
P3= 15-1 = 14
Average Waiting Time = 0+7+0+2+14/5 = 23/5 =4.6


*/