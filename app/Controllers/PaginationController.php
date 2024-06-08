<?php

namespace App\Controllers;

use System\libs\Controller;

/**
 * Pagination Controller
 */
class PaginationController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getPagination($totalrecord, $block, $func = "")
    {
        $callFunc = "nextPage";
        if ($func != "") {
            $callFunc = $func;
        }

        $from_rs = isset(request()->from) ? request()->from : "";
        if ($from_rs == "") {
            $from_rs = 0;
        }
        if ($block == "") {
            $block = 12;
        }
        $to_rs = (int)$from_rs + $block;
        if ($from_rs >= $block) {
            $from_rs = $from_rs + 1;
        }
        if ($from_rs == "" || $from_rs == 0) {
            $from_rs = 1;
        }
        if ($to_rs == "" || $totalrecord < $block) {
            $to_rs = $totalrecord;
        } else if ($to_rs == "" && $totalrecord > $block) {
            $to_rs = $block;
        }
        if ($to_rs > $totalrecord) {
            $to_rs = $totalrecord;
        }
        if ($totalrecord == 0) {
            $from_rs = 0;
        }

        $plink = isset(request()->page_no) ? request()->page_no : "";
        if ($plink == "") {
            $plink = 1;
        }
        if ($totalrecord > $block) {
            $res = $totalrecord / $block;
            $res = (int)$res;
            if (($totalrecord % $block) != 0) {
                $totalpage = $res + 1;
            } else {
                $totalpage = $res;
            }
        } else {
            $totalpage = 1;
        }
        $paginationStr = "";

        if ($totalrecord > $block) {
            $two = isset(request()->from) ? request()->from : "";
            if ($two == "") {
                $two = 0;
            }
            $pno = isset(request()->page_no) ? request()->page_no : "";
            if ($pno == "") {
                $pno = 0;
            }
            $pno = $pno - 1;
            $frm = $two - $block;
            $to = $block;
            if ($pno <= $totalpage && $pno > 0) {
                $paginationStr .= "<button class='join-item btn' onclick=" . $callFunc . "($frm,$to,$pno) >&laquo;</button>";
            }
        } else {
            $paginationStr .= "<button class='join-item btn' disabled>&laquo;</button>";
        }
        if ($totalpage >= 1) {
            $i = 1;
            $from = 0;
            $to = $block;
            while ($i <= $totalpage) {
                if ($from == 0) {
                    $paginationStr .= "<button class='join-item btn";
                    if ($i == $plink) {
                        $paginationStr .= " btn-active";
                    }
                    $paginationStr .= "' ";
                    $paginationStr .= "onclick=" . $callFunc . "($from,$to,$i)>$i";
                    $paginationStr .= "</button>";
                } else {
                    $paginationStr .= "<button class='join-item btn";
                    if ($i == $plink) {
                        $paginationStr .= " btn-active";
                    }
                    $paginationStr .= "' ";
                    $paginationStr .= "onclick=" . $callFunc . "($from,$to,$i)>$i";
                    $paginationStr .= "</button>";
                }
                $i++;
                $from = $from + $block;
                if ($to > $totalrecord) {
                    $to = $totalrecord;
                }
            }
        }
        if ($totalrecord > $block) {
            $f = isset(request()->from) ? request()->from : "";
            $page = isset(request()->page_no) ? request()->page_no : "";
            $page = (int)$page + 1;
            if ($f == "" || $f == 0) {
                $f = $block;
                $page = 2;
            } else {
                $f = $f + $block;
            }
            $t = $block;
            if ($t > $totalrecord) {
                $t = $totalrecord;
            }
            if ($page <= $totalpage) {
                $paginationStr .= "<button class='join-item btn' onclick=" . $callFunc . "($f,$t,$page) >&raquo;</button>";
            }
        } else {
            $paginationStr .= "<button class='join-item btn' disabled>&raquo;</button>";
        }

        return $paginationStr;
    }

    public function ellipsisPagination($totalRecord, $block, $func = "")
    {
        $callFunc = $func ?: "nextPage";

        // Get the current page and starting record number from the request
        $currentPage = isset(request()->page_no) ? request()->page_no : 0;
        $from = isset(request()->from) ? request()->from : 0;

        // Define the number of records per page
        $block = $block ?: 12;

        // Calculate total pages
        $totalPage = ceil($totalRecord / $block);

        // Initialize pagination string
        $paginationStr = "";

        // Previous button
        if ($currentPage > 1) {
            $prevPage = $currentPage - 1;
            $prevFrom = ($prevPage - 1) * $block;
            $paginationStr .= "<button class='join-item btn' onclick=\"$callFunc($prevFrom, $block, $prevPage)\">&laquo;</button>";
        } else {
            $paginationStr .= "<button class='join-item btn' disabled>&laquo;</button>";
        }

        // Page buttons with ellipsis
        if ($totalPage <= 7) {
            // Less than 7 total pages, show all
            for ($i = 1; $i <= $totalPage; $i++) {
                $from = ($i - 1) * $block;
                $activeClass = $i == $currentPage ? " btn-active" : "";
                $paginationStr .= "<button class='join-item btn$activeClass' onclick=\"$callFunc($from, $block, $i)\">$i</button>";
            }
        } else {
            // More than 7 total pages, show partial with ellipsis
            if ($currentPage <= 4) {
                for ($i = 1; $i <= 5; $i++) {
                    $from = ($i - 1) * $block;
                    $activeClass = $i == $currentPage ? " btn-active" : "";
                    $paginationStr .= "<button class='join-item btn$activeClass' onclick=\"$callFunc($from, $block, $i)\">$i</button>";
                }
                $paginationStr .= "<span class='join-item btn'>...</span>";
                $from = ($totalPage - 1) * $block;
                $paginationStr .= "<button class='join-item btn' onclick=\"$callFunc($from, $block, $totalPage)\">$totalPage</button>";
            } elseif ($currentPage > 4 && $currentPage < $totalPage - 3) {
                $paginationStr .= "<button class='join-item btn' onclick=\"$callFunc(0, $block, 1)\">1</button>";
                $paginationStr .= "<span class='join-item btn'>...</span>";
                for ($i = $currentPage - 1; $i <= $currentPage + 1; $i++) {
                    $from = ($i - 1) * $block;
                    $activeClass = $i == $currentPage ? " btn-active" : "";
                    $paginationStr .= "<button class='join-item btn$activeClass' onclick=\"$callFunc($from, $block, $i)\">$i</button>";
                }
                $paginationStr .= "<span class='join-item btn'>...</span>";
                $from = ($totalPage - 1) * $block;
                $paginationStr .= "<button class='join-item btn' onclick=\"$callFunc($from, $block, $totalPage)\">$totalPage</button>";
            } else {
                $paginationStr .= "<button class='join-item btn' onclick=\"$callFunc(0, $block, 1)\">1</button>";
                $paginationStr .= "<span class='join-item btn'>...</span>";
                for ($i = $totalPage - 4; $i <= $totalPage; $i++) {
                    $from = ($i - 1) * $block;
                    $activeClass = $i == $currentPage ? " btn-active" : "";
                    $paginationStr .= "<button class='join-item btn$activeClass' onclick=\"$callFunc($from, $block, $i)\">$i</button>";
                }
            }
        }

        // Next button
        if ($currentPage < $totalPage) {
            $nextPage = (int)$currentPage + 1;
            $nextFrom = (int)$currentPage * (int)$block;
            $paginationStr .= "<button class='join-item btn' onclick=\"$callFunc($nextFrom, $block, $nextPage)\">&raquo;</button>";
        } else {
            $paginationStr .= "<button class='join-item btn' disabled>&raquo;</button>";
        }

        return $paginationStr;
    }

}
