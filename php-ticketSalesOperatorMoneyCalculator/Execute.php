<?php
require_once "./TicketSalesOperatorMoneyCalculator.php";
$regularTicket["adult"]  =  $argv[1];
$regularTicket["child"]  =  $argv[2];
$regularTicket["senior"] =  $argv[3];
$specialTicket["adult"]  =  $argv[4];
$specialTicket["child"]  =  $argv[5];
$specialTicket["senior"] =  $argv[6];
$o = new TicketSalesOperatorMoneyCalculator($regularTicket, $specialTicket);
$o->execute();
?>