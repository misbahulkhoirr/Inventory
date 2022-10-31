<?php

use App\Models\ListMutasi;


function setActive($uri, $output = "active")
{
  if (is_array($uri)) {
    foreach ($uri as $u) {
      if (Route::is($u)) {
        return $output;
      }
    }
  } else {
    if (Route::is($uri)) {
      return $output;
    }
  }
}
function change($type)
{
  $from = date('Y-m-01');
  $to = date('Y-m-t');
  $tb = date('ym');
  $data = ListMutasi::whereBetween('tanggal', [$from, $to])->where('mutasi', $type)->max('no_trx');
  if ($data) {
    if ($type == 'In') {
      sprintf('BM' . abs($data++));
      return $data;
      // $ganti = str_replace('BM', '', $data[0]['no_trx']);
      // $no = (int)$ganti;
      // return 'BM' . (int)($no + 1);
      
    } else {
      sprintf('BK' . abs($data++));
      return $data;
      // $ganti = str_replace('BK', '', $data[0]['no_trx']);
      // $no = (int)$ganti;
      // return 'BK' . (int)($no + 1);
    }
  }
  $no = $type == 'In' ? 'BM' : 'BK';
  return $no . $tb . '0001';
}
