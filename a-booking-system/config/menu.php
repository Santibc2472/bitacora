<?php
if (!defined('ABSPATH')) exit;

global $ABookingSystem;
global $absdashboardtext;

$ABookingSystem['menu'] = array();

/*
 * Main menu
 */
$ABookingSystem['menu']['main'] = array();

$ABookingSystem['menu']['main'][] = array('account_type' => array('free', 'pro', 'network'), // free, pro, network
                                          'title' => 'title', // button title translation
                                          'sub_title' => 'connection', // button  sub title translation
                                          'page' => 'connection',
                                          'page_admin' => 'connection',
                                          'page_owner' => 'calendars',
                                          'icon' => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgaGVpZ2h0PSIyNHB4IiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCAyNCAyNCIgd2lkdGg9IjI0cHgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6c2tldGNoPSJodHRwOi8vd3d3LmJvaGVtaWFuY29kaW5nLmNvbS9za2V0Y2gvbnMiIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj48dGl0bGUvPjxkZXNjLz48ZGVmcy8+PGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIiBpZD0ibWl1IiBzdHJva2U9Im5vbmUiIHN0cm9rZS13aWR0aD0iMSI+PGcgaWQ9IkFydGJvYXJkLTEiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC03NTUuMDAwMDAwLCAtMzM1LjAwMDAwMCkiPjxnIGlkPSJzbGljZSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMjE1LjAwMDAwMCwgMTE5LjAwMDAwMCkiLz48cGF0aCBkPSJNNzU5Ljk5OTUxMiwzMzggTDc1NiwzMzggTDc1NiwzNTYgQzc1NiwzNTcgNzU3LjEsMzU3IDc1Ny4xLDM1NyBMNzc3LDM1NyBDNzc3LDM1NyA3NzgsMzU3IDc3OCwzNTYgTDc3OCwzMzggTDc3NCwzMzggTDc3NCwzMzkuMjQ3NjMxIEM3NzQsMzQwLjIxNzE3IDc3My4yMTcyNjksMzQxIDc3Mi4yNDk1ODQsMzQxIEw3NzEuNzUwNDE2LDM0MSBDNzcwLjc4MjA1NiwzNDEgNzcwLDM0MC4yMTUwMjggNzcwLDMzOS4yNDc2MzEgTDc3MCwzMzggTDc2NCwzMzggTDc2NCwzMzkuMjQ3NjMxIEM3NjQsMzQwLjIxNzE3IDc2My4yMTcyNjksMzQxIDc2Mi4yNDk1ODQsMzQxIEw3NjEuNzUwNDE2LDM0MSBDNzYwLjc4MjA1NiwzNDEgNzYwLDM0MC4yMTUwMjggNzYwLDMzOS4yNDc2MzEgTDc2MCwzMzggTDc1OS45OTk1MTIsMzM4IFogTTc3MiwzMzYgQzc3MS40NDc3MTUsMzM2IDc3MSwzMzYuNDQ3MjA4IDc3MSwzMzYuOTk5MDUxIEw3NzEsMzM5LjAwMDk0OSBDNzcxLDMzOS41NTI3MSA3NzEuNDQ4ODM5LDM0MCA3NzIsMzQwIEM3NzIuNTUyMjg1LDM0MCA3NzMsMzM5LjU1Mjc5MiA3NzMsMzM5LjAwMDk0OSBMNzczLDMzNi45OTkwNTEgQzc3MywzMzYuNDQ3MjkgNzcyLjU1MTE2MSwzMzYgNzcyLDMzNiBaIE03NjEsMzM2Ljc1MjM2OSBMNzYxLDMzOS4yNDc2MzEgQzc2MSwzMzkuNjYzMTUzIDc2MS4zMzQ3NTUsMzQwIDc2MS43NTA0MTYsMzQwIEw3NjIuMjQ5NTg0LDM0MCBDNzYyLjY2NDAyNywzNDAgNzYzLDMzOS42NjU4NDIgNzYzLDMzOS4yNDc2MzEgTDc2MywzMzYuNzUyMzY5IEM3NjMsMzM2LjMzNjg0NyA3NjIuNjY1MjQ1LDMzNiA3NjIuMjQ5NTg0LDMzNiBMNzYxLjc1MDQxNiwzMzYgQzc2MS4zMzU5NzMsMzM2IDc2MSwzMzYuMzM0MTU4IDc2MSwzMzYuNzUyMzY5IFogTTc1OCwzNDIgTDc1OCwzNDMgTDc3NiwzNDMgTDc3NiwzNDIgTDc1OCwzNDIgWiBNNzYyLDM0Ny4zNDUwMjEgQzc2Mi43MzcyNDQsMzQ3LjI4Mjg0MiA3NjMuMjUxNDE2LDM0Ny4xNzg5MzkgNzYzLjU0MjUzMywzNDcuMDMzMzEgQzc2My44MzM2NSwzNDYuODg3NjggNzY0LjA1MTAzOSwzNDYuNTQzMjQ3IDc2NC4xOTQ3MDcsMzQ2IEw3NjUsMzQ2IEw3NjUsMzU0IEw3NjQuMDI1NDUyLDM1NCBMNzY0LjAyNTQ1MiwzNDguMDIyNDQgTDc2MiwzNDguMDIyNDQgTDc2MiwzNDcuMzQ1MDIxIFogTTc3MS41MTQxNywzNDcuMjQ1NDExIEM3NzEuODM4MDU4LDM0Ny44ODcxNTUgNzcyLDM0OC43NjYzNjcgNzcyLDM0OS44ODMwNzMgQzc3MiwzNTAuOTQxNzY4IDc3MS44NTMyNCwzNTEuODE3MzU0IDc3MS41NTk3MTcsMzUyLjUwOTg1NyBDNzcxLjEzNDYxMywzNTMuNTAzMjkxIDc3MC40Mzk2MTMsMzU0IDc2OS40NzQ2OTYsMzU0IEM3NjguNjA0MjQ3LDM1NCA3NjcuOTU2NDgsMzUzLjU5MzkzMSA3NjcuNTMxMzc3LDM1Mi43ODE3ODEgQzc2Ny4xNzcxMjQsMzUyLjEwMzc4MSA3NjcsMzUxLjE5Mzc1MSA3NjcsMzUwLjA1MTY2NiBDNzY3LDM0OS4xNjcwMDIgNzY3LjEwNjI3NCwzNDguNDA3NDM2IDc2Ny4zMTg4MjYsMzQ3Ljc3Mjk0NCBDNzY3LjcxNjkzOSwzNDYuNTkwOTc1IDc2OC40MzcyNDIsMzQ2IDc2OS40Nzk3NTcsMzQ2IEM3NzAuNDE3Njg0LDM0NiA3NzEuMDk1ODE0LDM0Ni40MTUxMzMgNzcxLjUxNDE3LDM0Ny4yNDU0MTEgQzc3MS41MTQxNywzNDcuMjQ1NDExIDc3MS4wOTU4MTQsMzQ2LjQxNTEzMyA3NzEuNTE0MTcsMzQ3LjI0NTQxMSBaIE03NzAuNTg0MzA3LDM1Mi4zNTAyMTggQzc3MC44NjE0MzcsMzUxLjkxNzAyOCA3NzEsMzUxLjExMDA1IDc3MSwzNDkuOTI5MjU4IEM3NzEsMzQ5LjA3Njg1MiA3NzAuODk5ODM0LDM0OC4zNzU1NDkgNzcwLjY5OTQ5OSwzNDcuODI1MzI3IEM3NzAuNDk5MTY0LDM0Ny4yNzUxMDYgNzcwLjExMDE4NywzNDcgNzY5LjUzMjU1NCwzNDcgQzc2OS4wMDE2NjcsMzQ3IDc2OC42MTM1MjQsMzQ3LjI2MTEzMyA3NjguMzY4MTE0LDM0Ny43ODM0MDYgQzc2OC4xMjI3MDMsMzQ4LjMwNTY3OSA3NjgsMzQ5LjA3NTEwNCA3NjgsMzUwLjA5MTcwMyBDNzY4LDM1MC44NTY3NzIgNzY4LjA3ODQ2MywzNTEuNDcxNjEzIDc2OC4yMzUzOTIsMzUxLjkzNjI0NSBDNzY4LjQ3NTc5NCwzNTIuNjQ1NDE4IDc2OC44ODY0NzUsMzUzIDc2OS40Njc0NDYsMzUzIEM3NjkuOTM0ODk0LDM1MyA3NzAuMzA3MTc3LDM1Mi43ODM0MDggNzcwLjU4NDMwNywzNTIuMzUwMjE4IEM3NzAuNTg0MzA3LDM1Mi4zNTAyMTggNzcwLjMwNzE3NywzNTIuNzgzNDA4IDc3MC41ODQzMDcsMzUyLjM1MDIxOCBaIiBmaWxsPSIjMDAwMDAwIiBpZD0iY29tbW9uLWNhbGVuZGFyLWRheS1nbHlwaCIvPjwvZz48L2c+PC9zdmc+'); // base64 encoded svg icon 

$ABookingSystem['menu']['main'][] = array('account_type' => array('free', 'pro'), // free, pro, network
                                          'title' => 'my_', // button title translation
                                          'page' => 'calendars',
                                          'used_for' => true,
                                          'role' => array('admin'),
                                          'enabled' => true);

$ABookingSystem['menu']['main'][] = array('account_type' => array('free', 'pro'), // free, pro, network
                                          'title' => 'reservations', // button title translation
                                          'page' => 'reservations',
                                          'used_for' => false,
                                          'role' => array('admin'),
                                          'enabled' => true);

$ABookingSystem['menu']['main'][] = array('account_type' => array('free', 'pro'), // free, pro, network
                                          'title' => 'my_account', // button title translation
                                          'page' => 'account',
                                          'used_for' => false,
                                          'role' => array('admin', 'owner'),
                                          'enabled' => true);

$ABookingSystem['menu']['main'][] = array('account_type' => array('free', 'pro', 'network'), // free, pro, network
                                          'title' => 'extensions', // button title translation
                                          'page' => 'extensions',
                                          'used_for' => false,
                                          'role' => array('admin', 'owner'),
                                          'enabled' => true);

$ABookingSystem['menu']['main'][] = array('account_type' => array('free', 'pro'), // free, pro, network
                                          'title' => 'support', // button title translation
                                          'page' => 'support',
                                          'used_for' => false,
                                          'role' => array('admin', 'owner'),
                                          'enabled' => true);