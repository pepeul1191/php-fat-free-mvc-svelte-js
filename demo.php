<?php
$dateTime = new DateTime();
// Override current time
$timestamp = $dateTime->getTimestamp();
echo $timestamp;