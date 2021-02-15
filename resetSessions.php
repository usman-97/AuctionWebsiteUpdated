<?php

if (isset($_SESSION['viewItem']))
{
    unset($_SESSION['viewItem']);
}

if (isset($_SESSION['searchMode']))
{
    unset($_SESSION['searchMode']);
}

if (isset($_SESSION['item']))
{
    unset($_SESSION['item']);
}

if (isset($_SESSION['viewAuctionLots']))
{
    unset($_SESSION['viewAuctionLots']);
}
