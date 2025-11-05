<?php
$page = $_REQUEST['page'] ?? null;

include 'components/header.php';


switch ($page) {
    case 'customers':
        include 'components/customer.php';
        break;
    case 'items':
        include 'components/item.php';
        break;
    case 'reports':
        include 'components/report.php';
        break;
    default:
        include 'components/customer.php';
        break;
}

function setActiveNav($pageName)
{
    $currentPage = $_REQUEST['page'] ?? 'customers';
    return $currentPage === $pageName ? 'active' : '';
}
?>